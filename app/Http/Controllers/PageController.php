<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PageController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HOME
    |--------------------------------------------------------------------------
    */

    public function home()
    {
        $featuredProducts = Product::with([
            'category',
            'variants',
        ])
            ->where('is_available', true)
            ->whereHas('variants', function ($query) {
                $query->where('is_available', true)
                    ->where('stock', '>', 0);
            })
            ->orderBy('name')
            ->take(5)
            ->get();

        $reviews = Review::with([
            'user',
            'product',
        ])
            ->where('is_visible', true)
            ->latest()
            ->take(6)
            ->get();

        return view('home', compact(
            'featuredProducts',
            'reviews'
        ));
    }


    /*
    |--------------------------------------------------------------------------
    | PRODUK
    |--------------------------------------------------------------------------
    */

    public function produk(Request $request)
    {
        $query = Product::with([
            'category',
            'variants',
        ]);

        if ($request->filled('search')) {
            $search = trim($request->input('search'));

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere(
                        'description',
                        'like',
                        '%' . $search . '%'
                    );
            });
        }

        if ($request->filled('kategori')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where(
                    'name',
                    $request->input('kategori')
                );
            });
        }

        if ($request->input('status') === 'tersedia') {
            $query
                ->where('is_available', true)
                ->whereHas('variants', function ($q) {
                    $q->where('is_available', true)
                        ->where('stock', '>', 0);
                });
        }

        if ($request->input('status') === 'tidak_tersedia') {
            $query->where(function ($q) {
                $q->where('is_available', false)
                    ->orWhereDoesntHave(
                        'variants',
                        function ($variantQuery) {
                            $variantQuery
                                ->where('is_available', true)
                                ->where('stock', '>', 0);
                        }
                    );
            });
        }

        $products = $query
            ->orderBy('name')
            ->get();

        $categories = Category::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('produk', compact(
            'products',
            'categories'
        ));
    }


    /*
    |--------------------------------------------------------------------------
    | DETAIL PRODUK
    |--------------------------------------------------------------------------
    */

    public function produkDetail($id)
    {
        $product = Product::with([
            'category',
            'variants' => function ($query) {
                $query
                    ->orderBy('price')
                    ->orderBy('name');
            },
        ])->findOrFail($id);

        return view('produk-detail', compact('product'));
    }


    /*
    |--------------------------------------------------------------------------
    | TAMBAH KERANJANG
    |--------------------------------------------------------------------------
    */

    public function tambahKeranjang(
        Request $request,
        $id
    ) {
        if (!session('customer_logged_in')) {
            return redirect()
                ->route('login')
                ->with(
                    'error',
                    'Silakan login terlebih dahulu untuk membeli produk.'
                );
        }

        $validated = $request->validate([
            'variant_id' => [
                'required',
                'integer',
                'exists:product_variants,id',
            ],

            'quantity' => [
                'required',
                'integer',
                'min:1',
            ],
        ], [
            'variant_id.required' =>
                'Silakan pilih varian produk.',

            'variant_id.integer' =>
                'Varian produk tidak valid.',

            'variant_id.exists' =>
                'Varian produk tidak valid.',

            'quantity.required' =>
                'Jumlah produk wajib diisi.',

            'quantity.integer' =>
                'Jumlah produk harus berupa angka.',

            'quantity.min' =>
                'Jumlah produk minimal 1.',
        ]);

        $userId = session('customer_id');

        $product = Product::findOrFail($id);

        if (!$product->is_available) {
            return back()
                ->with(
                    'error',
                    'Produk sedang tidak tersedia.'
                );
        }

        /*
         * Pastikan variant benar-benar milik product
         * yang sedang dibuka.
         */
        $variant = ProductVariant::where(
            'id',
            $validated['variant_id']
        )
            ->where(
                'product_id',
                $product->id
            )
            ->first();

        if (!$variant) {
            return back()
                ->with(
                    'error',
                    'Varian produk tidak valid.'
                );
        }

        if (
            !$variant->is_available ||
            $variant->stock <= 0
        ) {
            return back()
                ->with(
                    'error',
                    'Varian ' .
                    $variant->name .
                    ' sedang tidak tersedia.'
                );
        }

        $quantity = (int) $validated['quantity'];

        $cart = Cart::firstOrCreate([
            'user_id' => $userId,
        ]);

        $cartItem = CartItem::where(
            'cart_id',
            $cart->id
        )
            ->where(
                'product_id',
                $product->id
            )
            ->where(
                'variant_id',
                $variant->id
            )
            ->first();

        $currentQuantity = $cartItem?->quantity ?? 0;

        $newQuantity =
            $currentQuantity +
            $quantity;

        if ($newQuantity > $variant->stock) {
            return back()
                ->with(
                    'error',
                    'Jumlah melebihi stok varian ' .
                    $variant->name .
                    '. Stok saat ini: ' .
                    $variant->stock
                );
        }

        if ($cartItem) {
            $cartItem->update([
                'quantity' => $newQuantity,
            ]);
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'variant_id' => $variant->id,
                'quantity' => $quantity,
            ]);
        }

        return redirect()
            ->route('keranjang')
            ->with(
                'success',
                $product->name .
                ' (' .
                $variant->name .
                ') berhasil ditambahkan ke keranjang.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | KERANJANG
    |--------------------------------------------------------------------------
    */

    public function keranjang()
    {
        if (!session('customer_logged_in')) {
            return redirect()->route('login');
        }

        $userId = session('customer_id');

        $cartModel = Cart::with([
            'items.product',
            'items.variant',
        ])
            ->where('user_id', $userId)
            ->first();

        $cartItems = [];

        if ($cartModel) {
            foreach ($cartModel->items as $item) {
                if (
                    !$item->product ||
                    !$item->variant
                ) {
                    continue;
                }

                $price = (float) $item->variant->price;

                $cartItems[] = [
                    'id' => $item->id,

                    'product_id' =>
                        $item->product->id,

                    'variant_id' =>
                        $item->variant->id,

                    'nama' =>
                        $item->product->name,

                    'varian' =>
                        $item->variant->name,

                    'harga' =>
                        $price,

                    'gambar' =>
                        $item->product->image,

                    'quantity' =>
                        $item->quantity,

                    'subtotal' =>
                        $price * $item->quantity,

                    'stock' =>
                        $item->variant->stock,

                    'tersedia' =>
                        $item->variant->is_available &&
                        $item->variant->stock > 0,
                ];
            }
        }

        $total = collect($cartItems)
            ->sum('subtotal');

        return view('keranjang', [
            'cart' => $cartItems,
            'total' => $total,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE KERANJANG
    |--------------------------------------------------------------------------
    */

    public function updateKeranjang(
        Request $request
    ) {
        if (!session('customer_logged_in')) {
            return redirect()->route('login');
        }

        $request->validate([
            'quantity' => [
                'nullable',
                'array',
            ],

            'quantity.*' => [
                'integer',
                'min:0',
            ],
        ]);

        $userId = session('customer_id');

        $cart = Cart::where(
            'user_id',
            $userId
        )->first();

        if (!$cart) {
            return redirect()
                ->route('keranjang')
                ->with(
                    'error',
                    'Keranjang Anda masih kosong.'
                );
        }

        foreach (
            $request->input('quantity', [])
            as $cartItemId => $quantity
        ) {
            $quantity = (int) $quantity;

            /*
             * CartItem ID digunakan sebagai identitas utama.
             * User hanya bisa mengubah item milik cart-nya sendiri.
             */
            $cartItem = CartItem::with([
                'product',
                'variant',
            ])
                ->where(
                    'id',
                    $cartItemId
                )
                ->where(
                    'cart_id',
                    $cart->id
                )
                ->first();

            if (!$cartItem) {
                continue;
            }

            if (
                !$cartItem->product ||
                !$cartItem->variant
            ) {
                $cartItem->delete();

                continue;
            }

            if ($quantity <= 0) {
                $cartItem->delete();

                continue;
            }

            $variant = $cartItem->variant;

            if (
                !$variant->is_available ||
                $variant->stock <= 0
            ) {
                return redirect()
                    ->route('keranjang')
                    ->with(
                        'error',
                        'Varian ' .
                        $variant->name .
                        ' sedang tidak tersedia.'
                    );
            }

            if ($quantity > $variant->stock) {
                return redirect()
                    ->route('keranjang')
                    ->with(
                        'error',
                        'Jumlah ' .
                        $cartItem->product->name .
                        ' (' .
                        $variant->name .
                        ') melebihi stok tersedia (' .
                        $variant->stock .
                        ').'
                    );
            }

            $cartItem->update([
                'quantity' => $quantity,
            ]);
        }

        return redirect()
            ->route('keranjang')
            ->with(
                'success',
                'Keranjang berhasil diperbarui.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | HAPUS KERANJANG
    |--------------------------------------------------------------------------
    */

    public function hapusKeranjang(
        Request $request
    ) {
        if (!session('customer_logged_in')) {
            return redirect()->route('login');
        }

        $request->validate([
            'id' => [
                'required',
                'integer',
            ],
        ]);

        $userId = session('customer_id');

        $cart = Cart::where(
            'user_id',
            $userId
        )->first();

        if ($cart) {
            CartItem::where(
                'cart_id',
                $cart->id
            )
                ->where(
                    'id',
                    $request->input('id')
                )
                ->delete();
        }

        return redirect()
            ->route('keranjang')
            ->with(
                'success',
                'Produk berhasil dihapus dari keranjang.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | LOGIN
    |--------------------------------------------------------------------------
    */

    public function login()
    {
        if (session('customer_logged_in')) {
            return redirect()->route('home');
        }

        return view('login');
    }


    public function prosesLogin(
        Request $request
    ) {
        $credentials = $request->validate([
            'email' => [
                'required',
                'email',
            ],

            'password' => [
                'required',
                'string',
            ],
        ], [
            'email.required' =>
                'Email wajib diisi.',

            'email.email' =>
                'Format email tidak valid.',

            'password.required' =>
                'Password wajib diisi.',
        ]);

        $user = User::where(
            'email',
            $credentials['email']
        )->first();

        if (
            !$user ||
            !Hash::check(
                $credentials['password'],
                $user->password
            )
        ) {
            return back()
                ->withInput(
                    $request->only('email')
                )
                ->with(
                    'error',
                    'Email atau password salah.'
                );
        }

        if ($user->role !== 'customer') {
            return back()
                ->withInput(
                    $request->only('email')
                )
                ->with(
                    'error',
                    'Akun ini bukan akun customer.'
                );
        }

        $request->session()->regenerate();

        session([
            'customer_logged_in' => true,
            'customer_id' => $user->id,
            'customer_name' => $user->name,
            'customer_email' => $user->email,
        ]);

        return redirect()
            ->intended(route('home'))
            ->with(
                'success',
                'Login berhasil. Selamat datang, ' .
                $user->name .
                '!'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | REGISTER
    |--------------------------------------------------------------------------
    */

    public function register()
    {
        if (session('customer_logged_in')) {
            return redirect()->route('home');
        }

        return view('register');
    }


    public function prosesRegister(
        Request $request
    ) {
        $validated = $request->validate([
            'nama' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ], [
            'nama.required' =>
                'Nama wajib diisi.',

            'email.required' =>
                'Email wajib diisi.',

            'email.email' =>
                'Format email tidak valid.',

            'email.unique' =>
                'Email sudah terdaftar.',

            'password.required' =>
                'Password wajib diisi.',

            'password.min' =>
                'Password minimal 8 karakter.',

            'password.confirmed' =>
                'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'name' =>
                $validated['nama'],

            'email' =>
                $validated['email'],

            'password' =>
                Hash::make(
                    $validated['password']
                ),

            'role' => 'customer',
        ]);

        $request->session()->regenerate();

        session([
            'customer_logged_in' => true,
            'customer_id' => $user->id,
            'customer_name' => $user->name,
            'customer_email' => $user->email,
        ]);

        return redirect()
            ->route('home')
            ->with(
                'success',
                'Registrasi berhasil. Selamat datang di Deganasia!'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    public function logout(
        Request $request
    ) {
        $request->session()->forget([
            'customer_logged_in',
            'customer_id',
            'customer_email',
            'customer_name',
        ]);

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()
            ->route('home')
            ->with(
                'success',
                'Anda berhasil logout.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | CHECKOUT
    |--------------------------------------------------------------------------
    */

    public function checkout()
    {
        if (!session('customer_logged_in')) {
            return redirect()->route('login');
        }

        $userId = session('customer_id');

        $cartModel = Cart::with([
            'items.product',
            'items.variant',
        ])
            ->where(
                'user_id',
                $userId
            )
            ->first();

        if (
            !$cartModel ||
            $cartModel->items->isEmpty()
        ) {
            return redirect()
                ->route('keranjang')
                ->with(
                    'error',
                    'Keranjang Anda masih kosong.'
                );
        }

        $cartItems = [];

        foreach ($cartModel->items as $item) {
            if (
                !$item->product ||
                !$item->variant
            ) {
                continue;
            }

            $price = (float) $item->variant->price;

            $cartItems[] = [
                'id' =>
                    $item->id,

                'product_id' =>
                    $item->product->id,

                'variant_id' =>
                    $item->variant->id,

                'nama' =>
                    $item->product->name,

                'varian' =>
                    $item->variant->name,

                'harga' =>
                    $price,

                'gambar' =>
                    $item->product->image,

                'quantity' =>
                    $item->quantity,

                'subtotal' =>
                    $price * $item->quantity,
            ];
        }

        if (empty($cartItems)) {
            return redirect()
                ->route('keranjang')
                ->with(
                    'error',
                    'Keranjang Anda masih kosong.'
                );
        }

        $total = collect($cartItems)
            ->sum('subtotal');

        return view('checkout', [
            'cart' => $cartItems,
            'total' => $total,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | PROSES CHECKOUT
    |--------------------------------------------------------------------------
    */

    public function prosesCheckout(
        Request $request
    ) {
        if (!session('customer_logged_in')) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'tanggal_pemesanan' => [
                'required',
                'date',
                'after_or_equal:' .
                    now()
                        ->addDays(3)
                        ->format('Y-m-d'),
            ],

            'metode_transaksi' => [
                'required',
                'in:pickup_cfd,pickup_rumah,delivery,cod',
            ],

            'alamat_lokasi' => [
                'nullable',
                'string',
                'max:500',
                'required_if:metode_transaksi,delivery',
                'required_if:metode_transaksi,cod',
            ],

            'catatan' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ], [
            'tanggal_pemesanan.required' =>
                'Tanggal pesanan wajib dipilih.',

            'tanggal_pemesanan.date' =>
                'Format tanggal pesanan tidak valid.',

            'tanggal_pemesanan.after_or_equal' =>
                'Pesanan minimal H-3.',

            'metode_transaksi.required' =>
                'Silakan pilih metode pengambilan.',

            'metode_transaksi.in' =>
                'Metode transaksi tidak valid.',

            'alamat_lokasi.required_if' =>
                'Alamat atau lokasi wajib diisi untuk Delivery atau COD.',

            'catatan.max' =>
                'Catatan pesanan maksimal 1000 karakter.',
        ]);

        $userId = session('customer_id');

        try {
            $order = DB::transaction(
                function () use (
                    $request,
                    $validated,
                    $userId
                ) {
                    /*
                     * Lock cart supaya proses checkout
                     * tidak berjalan bersamaan untuk cart yang sama.
                     */
                    $cart = Cart::where(
                        'user_id',
                        $userId
                    )
                        ->lockForUpdate()
                        ->first();

                    if (!$cart) {
                        throw new \RuntimeException(
                            'Keranjang Anda masih kosong.'
                        );
                    }

                    $cartItems = CartItem::where(
                        'cart_id',
                        $cart->id
                    )
                        ->with([
                            'product',
                            'variant',
                        ])
                        ->lockForUpdate()
                        ->get();

                    if ($cartItems->isEmpty()) {
                        throw new \RuntimeException(
                            'Keranjang Anda masih kosong.'
                        );
                    }

                    $subtotal = 0;

                    /*
                     * Lock seluruh variant yang dibeli
                     * sebelum stok dikurangi.
                     */
                    foreach ($cartItems as $cartItem) {
                        if (!$cartItem->product) {
                            throw new \RuntimeException(
                                'Produk tidak ditemukan.'
                            );
                        }

                        if (!$cartItem->variant) {
                            throw new \RuntimeException(
                                'Varian produk tidak ditemukan.'
                            );
                        }

                        $variant = ProductVariant::where(
                            'id',
                            $cartItem->variant_id
                        )
                            ->where(
                                'product_id',
                                $cartItem->product_id
                            )
                            ->lockForUpdate()
                            ->first();

                        if (!$variant) {
                            throw new \RuntimeException(
                                'Varian ' .
                                $cartItem->product->name .
                                ' tidak ditemukan.'
                            );
                        }

                        if (
                            !$variant->is_available ||
                            $variant->stock <= 0
                        ) {
                            throw new \RuntimeException(
                                $cartItem->product->name .
                                ' (' .
                                $variant->name .
                                ') sedang tidak tersedia.'
                            );
                        }

                        if (
                            $cartItem->quantity >
                            $variant->stock
                        ) {
                            throw new \RuntimeException(
                                'Stok ' .
                                $cartItem->product->name .
                                ' (' .
                                $variant->name .
                                ') tidak mencukupi. ' .
                                'Stok tersedia: ' .
                                $variant->stock
                            );
                        }

                        $subtotal +=
                            (float) $variant->price *
                            $cartItem->quantity;
                    }

                    /*
                     * MVP saat ini:
                     * belum ada biaya delivery.
                     */
                    $deliveryFee = 0;

                    /*
                     * Belum ada promo code.
                     */
                    $discount = 0;

                    $total =
                        $subtotal +
                        $deliveryFee -
                        $discount;

                    /*
                     * Generate nomor order unik.
                     */
                    do {
                        $orderNumber =
                            'DGN-' .
                            now()->format('YmdHis') .
                            '-' .
                            strtoupper(
                                substr(
                                    bin2hex(
                                        random_bytes(4)
                                    ),
                                    0,
                                    8
                                )
                            );
                    } while (
                        Order::where(
                            'order_number',
                            $orderNumber
                        )->exists()
                    );

                    $order = Order::create([
                        'order_number' =>
                            $orderNumber,

                        'user_id' =>
                            $userId,

                        /*
                         * Untuk MVP delivery menggunakan
                         * snapshot alamat text.
                         */
                        'address_id' =>
                            null,

                        'order_date' =>
                            $validated[
                                'tanggal_pemesanan'
                            ],

                        'pickup_method' =>
                            $validated[
                                'metode_transaksi'
                            ],

                        'delivery_address' =>
                            $validated[
                                'alamat_lokasi'
                            ] ?? null,

                        'subtotal' =>
                            $subtotal,

                        'delivery_fee' =>
                            $deliveryFee,

                        'discount' =>
                            $discount,

                        'total' =>
                            $total,

                        'status' =>
                            'diterima',

                        'admin_note' =>
                            null,

                        /*
                         * Catatan customer dari checkout.
                         */
                        'customer_note' =>
                            isset(
                                $validated['catatan']
                            )
                                ? trim(
                                    $validated['catatan']
                                )
                                : null,
                    ]);

                    /*
                     * Buat OrderItem dari snapshot variant.
                     */
                    foreach ($cartItems as $cartItem) {
                        $variant = ProductVariant::where(
                            'id',
                            $cartItem->variant_id
                        )
                            ->where(
                                'product_id',
                                $cartItem->product_id
                            )
                            ->lockForUpdate()
                            ->firstOrFail();

                        $itemSubtotal =
                            (float) $variant->price *
                            $cartItem->quantity;

                        OrderItem::create([
                            'order_id' =>
                                $order->id,

                            'product_id' =>
                                $cartItem->product_id,

                            'variant_id' =>
                                $variant->id,

                            /*
                             * Snapshot nama produk.
                             */
                            'product_name' =>
                                $cartItem->product->name,

                            /*
                             * Snapshot nama variant.
                             */
                            'variant_name' =>
                                $variant->name,

                            /*
                             * Snapshot harga.
                             */
                            'price' =>
                                $variant->price,

                            'quantity' =>
                                $cartItem->quantity,

                            'subtotal' =>
                                $itemSubtotal,
                        ]);

                        /*
                         * Kurangi stok variant.
                         */
                        $variant->decrement(
                            'stock',
                            $cartItem->quantity
                        );

                        $variant->refresh();

                        /*
                         * Jika stok habis, variant otomatis
                         * menjadi tidak tersedia.
                         */
                        if ($variant->stock <= 0) {
                            $variant->update([
                                'is_available' => false,
                            ]);
                        }

                        /*
                         * Sinkronisasi kolom legacy Product.
                         *
                         * Kolom ini tetap ada sementara agar
                         * data lama dan Blade lama tidak rusak.
                         */
                        $this->syncProductStock(
                            $cartItem->product_id
                        );
                    }

                    /*
                     * Pembayaran MVP: tunai.
                     */
                    Payment::create([
                        'order_id' =>
                            $order->id,

                        'method' =>
                            'cash',

                        'amount' =>
                            $total,

                        'status' =>
                            'pending',

                        'paid_at' =>
                            null,

                        'reference' =>
                            null,

                        'note' =>
                            'Pembayaran tunai.',
                    ]);

                    /*
                     * Cart dikosongkan setelah order berhasil.
                     */
                    CartItem::where(
                        'cart_id',
                        $cart->id
                    )->delete();

                    return $order;
                }
            );
        } catch (\RuntimeException $e) {
            return redirect()
                ->route('keranjang')
                ->with(
                    'error',
                    $e->getMessage()
                );
        } catch (\Throwable $e) {
            report($e);

            return redirect()
                ->route('keranjang')
                ->with(
                    'error',
                    'Pesanan gagal dibuat. Silakan coba lagi.'
                );
        }

        return redirect()
            ->route('pesanan')
            ->with(
                'success',
                'Pesanan ' .
                $order->order_number .
                ' berhasil dibuat dan menunggu konfirmasi.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | PESANAN
    |--------------------------------------------------------------------------
    */

    public function pesanan()
    {
        if (!session('customer_logged_in')) {
            return redirect()->route('login');
        }

        return redirect()->route('profil');
    }


    /*
    |--------------------------------------------------------------------------
    | PROFIL
    |--------------------------------------------------------------------------
    */

    public function profil()
    {
        if (!session('customer_logged_in')) {
            return redirect()->route('login');
        }

        $userId = session('customer_id');

        $orders = Order::with([
            'items.product',
            'items.variant',
            'payment',
        ])
            ->where(
                'user_id',
                $userId
            )
            ->latest()
            ->get();

        $pesanan = $orders
            ->map(function ($order) {
                $firstItem =
                    $order->items->first();

                $productNames = $order->items
                    ->map(function ($item) {
                        $variantName =
                            $item->variant_name
                                ? ' (' .
                                $item->variant_name .
                                ')'
                                : '';

                        return
                            $item->product_name .
                            $variantName .
                            ' x' .
                            $item->quantity;
                    })
                    ->implode(', ');

                return [
                    'id' =>
                        $order->order_number,

                    'order_id' =>
                        $order->id,

                    'tanggal' =>
                        $order->order_date
                            ? $order->order_date
                                ->translatedFormat(
                                    'd F Y'
                                )
                            : '-',

                    'produk' =>
                        $productNames ?: '-',

                    'produk_id' =>
                        $firstItem?->product_id,

                    'jumlah' =>
                        $order->items
                            ->sum('quantity'),

                    'total' =>
                        (float) $order->total,

                    'status' =>
                        $this->formatOrderStatus(
                            $order->status
                        ),

                    'status_raw' =>
                        $order->status,

                    'pickup_method' =>
                        $order->pickup_method,

                    'alamat_lokasi' =>
                        $order->delivery_address,

                    'tanggal_dibuat' =>
                        $order->created_at
                            ? $order->created_at
                                ->format(
                                    'd M Y H:i'
                                )
                            : '-',

                    'admin_note' =>
                        $order->admin_note,
                ];
            })
            ->values()
            ->all();

        return view(
            'profil',
            compact('pesanan')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FORM REVIEW
    |--------------------------------------------------------------------------
    */

    public function formReview($id)
    {
        if (!session('customer_logged_in')) {
            return redirect()->route('login');
        }

        $userId = session('customer_id');

        $order = Order::with([
            'items.product',
            'items.variant',
        ])
            ->where(
                'id',
                $id
            )
            ->where(
                'user_id',
                $userId
            )
            ->firstOrFail();

        if ($order->status !== 'selesai') {
            return redirect()
                ->route('profil')
                ->with(
                    'error',
                    'Review hanya dapat diberikan setelah pesanan selesai.'
                );
        }

        $items = $order->items
            ->map(
                function ($item) use (
                    $userId,
                    $order
                ) {
                    $existingReview =
                        Review::where(
                            'user_id',
                            $userId
                        )
                            ->where(
                                'product_id',
                                $item->product_id
                            )
                            ->where(
                                'order_id',
                                $order->id
                            )
                            ->exists();

                    return [
                        'product_id' =>
                            $item->product_id,

                        'product_name' =>
                            $item->product_name,

                        'variant_name' =>
                            $item->variant_name,

                        'quantity' =>
                            $item->quantity,

                        'already_reviewed' =>
                            $existingReview,
                    ];
                }
            )
            ->values();

        $orderData = [
            'id' =>
                $order->id,

            'order_number' =>
                $order->order_number,

            'tanggal' =>
                $order->order_date
                    ? $order->order_date
                        ->translatedFormat(
                            'd F Y'
                        )
                    : '-',

            'produk' =>
                $order->items
                    ->map(
                        fn ($item) =>
                            $item->product_name .
                            (
                                $item->variant_name
                                    ? ' (' .
                                    $item->variant_name .
                                    ')'
                                    : ''
                            )
                    )
                    ->implode(', '),

            'jumlah' =>
                $order->items
                    ->sum('quantity'),

            'total' =>
                (float) $order->total,

            'status' =>
                'Selesai',
        ];

        return view('review', [
            'order' => $orderData,
            'items' => $items,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | SIMPAN REVIEW
    |--------------------------------------------------------------------------
    */

    public function simpanReview(
        Request $request,
        $id
    ) {
        if (!session('customer_logged_in')) {
            return redirect()->route('login');
        }

        $request->validate([
            'product_id' => [
                'required',
                'integer',
                'exists:products,id',
            ],

            'rating' => [
                'required',
                'integer',
                'min:1',
                'max:5',
            ],

            'komentar' => [
                'required',
                'string',
                'min:5',
                'max:500',
            ],
        ], [
            'product_id.required' =>
                'Produk review wajib dipilih.',

            'product_id.exists' =>
                'Produk tidak valid.',

            'rating.required' =>
                'Silakan pilih rating.',

            'rating.min' =>
                'Rating minimal 1.',

            'rating.max' =>
                'Rating maksimal 5.',

            'komentar.required' =>
                'Komentar wajib diisi.',

            'komentar.min' =>
                'Komentar minimal 5 karakter.',

            'komentar.max' =>
                'Komentar maksimal 500 karakter.',
        ]);

        $userId = session('customer_id');

        $order = Order::with('items')
            ->where(
                'id',
                $id
            )
            ->where(
                'user_id',
                $userId
            )
            ->where(
                'status',
                'selesai'
            )
            ->first();

        if (!$order) {
            return redirect()
                ->route('profil')
                ->with(
                    'error',
                    'Pesanan tidak ditemukan atau belum selesai.'
                );
        }

        $productId =
            (int) $request->input(
                'product_id'
            );

        /*
         * Pastikan product benar-benar ada
         * di order tersebut.
         */
        $hasPurchased = $order
            ->items()
            ->where(
                'product_id',
                $productId
            )
            ->exists();

        if (!$hasPurchased) {
            return redirect()
                ->route('profil')
                ->with(
                    'error',
                    'Anda hanya dapat memberikan review untuk produk yang dibeli.'
                );
        }

        $alreadyReviewed = Review::where(
            'user_id',
            $userId
        )
            ->where(
                'product_id',
                $productId
            )
            ->where(
                'order_id',
                $order->id
            )
            ->exists();

        if ($alreadyReviewed) {
            return redirect()
                ->route('profil')
                ->with(
                    'error',
                    'Anda sudah memberikan review untuk produk ini.'
                );
        }

        Review::create([
            'user_id' =>
                $userId,

            'product_id' =>
                $productId,

            'order_id' =>
                $order->id,

            'rating' =>
                (int) $request->input(
                    'rating'
                ),

            'comment' =>
                trim(
                    $request->input(
                        'komentar'
                    )
                ),

            'is_visible' =>
                true,
        ]);

        return redirect()
            ->route('profil')
            ->with(
                'success',
                'Terima kasih! Review Anda berhasil dikirim.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | CHAT
    |--------------------------------------------------------------------------
    */

    public function chat()
    {
        if (!session('customer_logged_in')) {
            return redirect()->route('login');
        }

        $messages = session(
            'chat_messages',
            []
        );

        $hasAdminMessage = collect($messages)
            ->contains(function ($message) {
                return (
                    $message['sender'] ?? ''
                ) === 'admin';
            });

        if (!$hasAdminMessage) {
            array_unshift(
                $messages,
                [
                    'sender' =>
                        'admin',

                    'message' =>
                        'Halo! 👋 Selamat datang di Deganasia. Ada yang bisa kami bantu?',

                    'time' =>
                        now()->format('H:i'),
                ]
            );

            session([
                'chat_messages' =>
                    $messages,
            ]);
        }

        return view(
            'chat',
            compact('messages')
        );
    }


    public function kirimChat(
        Request $request
    ) {
        if (!session('customer_logged_in')) {
            return redirect()->route('login');
        }

        $request->validate([
            'message' => [
                'required',
                'string',
                'max:1000',
            ],
        ], [
            'message.required' =>
                'Pesan wajib diisi.',

            'message.max' =>
                'Pesan maksimal 1000 karakter.',
        ]);

        $messages = session(
            'chat_messages',
            []
        );

        $messages[] = [
            'sender' =>
                'customer',

            'message' =>
                trim(
                    $request->input(
                        'message'
                    )
                ),

            'time' =>
                now()->format('H:i'),
        ];

        session([
            'chat_messages' =>
                $messages,
        ]);

        return redirect()
            ->route('chat');
    }


    /*
    |--------------------------------------------------------------------------
    | LOYALTY
    |--------------------------------------------------------------------------
    */

    public function loyalty()
    {
        return view('loyalty');
    }


    /*
    |--------------------------------------------------------------------------
    | TENTANG
    |--------------------------------------------------------------------------
    */

    public function tentang()
    {
        return view('tentang');
    }


    /*
    |--------------------------------------------------------------------------
    | KONTAK
    |--------------------------------------------------------------------------
    */

    public function kontak()
    {
        return view('kontak');
    }


    /*
    |--------------------------------------------------------------------------
    | HELPER - SYNC PRODUCT STOCK
    |--------------------------------------------------------------------------
    */

    private function syncProductStock(
        int $productId
    ): void {
        $product = Product::find(
            $productId
        );

        if (!$product) {
            return;
        }

        $remainingStock =
            ProductVariant::where(
                'product_id',
                $productId
            )->sum('stock');

        $hasAvailableVariant =
            ProductVariant::where(
                'product_id',
                $productId
            )
                ->where(
                    'is_available',
                    true
                )
                ->where(
                    'stock',
                    '>',
                    0
                )
                ->exists();

        $product->update([
            'stock' =>
                $remainingStock,

            'is_available' =>
                $hasAvailableVariant,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | HELPER - FORMAT ORDER STATUS
    |--------------------------------------------------------------------------
    */

    private function formatOrderStatus(
        string $status
    ): string {
        return match ($status) {
            'diterima' =>
                'Diterima',

            'diproses' =>
                'Diproses',

            'dikemas' =>
                'Dikemas',

            'dikirim' =>
                'Dikirim',

            'dalam_perjalanan' =>
                'Dalam Perjalanan',

            'selesai' =>
                'Selesai',

            'ditolak' =>
                'Ditolak',

            'dibatalkan' =>
                'Dibatalkan',

            default =>
                ucfirst(
                    str_replace(
                        '_',
                        ' ',
                        $status
                    )
                ),
        };
    }
}

