@extends('layouts.app')

@section('title', 'Detail Produk')

@section('content')

<section class="py-16 bg-amber-50 min-h-[75vh]">

    <div class="max-w-6xl mx-auto px-6">

        <div class="grid md:grid-cols-2 gap-12 bg-white rounded-3xl shadow-sm border border-amber-100 p-8">

            <!-- IMAGE -->

            <div class="h-96 bg-orange-50 rounded-3xl overflow-hidden">

                @if ($product->image)

                    <img
                        src="{{ asset('images/' . $product->image) }}"
                        alt="{{ $product->name }}"
                        class="w-full h-full object-cover"
                    >

                @else

                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                        Tidak ada gambar
                    </div>

                @endif

            </div>


            <!-- DETAIL -->

            <div>

                <span class="text-orange-600 font-semibold">
                    {{ optional($product->category)->name ?? 'Tanpa Kategori' }}
                </span>


                <h1 class="text-4xl font-bold text-gray-900 mt-2">
                    {{ $product->name }}
                </h1>


                <!-- DESCRIPTION -->

                <p class="text-gray-600 mt-6 leading-relaxed">
                    {{ $product->description }}
                </p>


                <!-- VARIANT -->

                <form
                    method="POST"
                    action="{{ route('produk.tambah', $product->id) }}"
                    class="mt-8"
                    id="cartForm"
                >

                    @csrf

                    <div>

                        <label
                            for="variant_id"
                            class="block font-semibold text-gray-700 mb-3"
                        >
                            Pilih Varian
                            <span class="text-red-500">*</span>
                        </label>


                        <div class="grid gap-3">

                            @foreach ($product->variants as $variant)

                                <label
                                    class="variant-option border border-gray-200 rounded-xl p-4 cursor-pointer hover:border-orange-400 hover:bg-orange-50 transition"
                                >

                                    <div class="flex items-center gap-3">

                                        <input
                                            type="radio"
                                            name="variant_id"
                                            value="{{ $variant->id }}"
                                            data-price="{{ $variant->price }}"
                                            data-stock="{{ $variant->stock }}"
                                            data-available="{{ $variant->is_available && $variant->stock > 0 ? '1' : '0' }}"
                                            class="variant-radio accent-orange-500"
                                            {{ $loop->first && $variant->is_available && $variant->stock > 0 ? 'checked' : '' }}
                                            {{ !($variant->is_available && $variant->stock > 0) ? 'disabled' : '' }}
                                        >

                                        <div class="flex-1">

                                            <div class="flex justify-between gap-3">

                                                <span class="font-semibold text-gray-900">
                                                    {{ $variant->name }}
                                                </span>

                                                <span class="font-bold text-orange-600">
                                                    Rp {{ number_format($variant->price, 0, ',', '.') }}
                                                </span>

                                            </div>

                                            <p class="text-sm mt-1
                                                {{ $variant->is_available && $variant->stock > 0
                                                    ? 'text-gray-500'
                                                    : 'text-red-500' }}"
                                            >

                                                @if ($variant->is_available && $variant->stock > 0)

                                                    Stok tersedia: {{ $variant->stock }}

                                                @else

                                                    Habis

                                                @endif

                                            </p>

                                        </div>

                                    </div>

                                </label>

                            @endforeach

                        </div>

                    </div>


                    @error('variant_id')

                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>

                    @enderror


                    <!-- SELECTED VARIANT INFO -->

                    <div
                        id="variantInfo"
                        class="mt-5 bg-orange-50 border border-orange-100 rounded-xl p-4"
                    >

                        <div class="flex justify-between">

                            <div>

                                <p class="text-sm text-gray-500">
                                    Varian dipilih
                                </p>

                                <p
                                    id="selectedVariantName"
                                    class="font-bold text-gray-900 mt-1"
                                >
                                    -
                                </p>

                            </div>


                            <div class="text-right">

                                <p class="text-sm text-gray-500">
                                    Harga
                                </p>

                                <p
                                    id="selectedVariantPrice"
                                    class="font-bold text-orange-600 mt-1"
                                >
                                    -
                                </p>

                            </div>

                        </div>

                        <p
                            id="selectedVariantStock"
                            class="text-sm text-gray-500 mt-3"
                        >
                            -
                        </p>

                    </div>


                    <!-- PRODUCT INFO -->

                    <div class="grid grid-cols-2 gap-4 mt-5">

                        <div class="bg-gray-50 rounded-xl p-4">

                            <p class="text-sm text-gray-500">
                                Minimum Pemesanan
                            </p>

                            <p class="font-bold text-gray-900 mt-1">
                                H-3
                            </p>

                        </div>


                        <div class="bg-gray-50 rounded-xl p-4">

                            <p class="text-sm text-gray-500">
                                Pembayaran
                            </p>

                            <p class="font-bold text-gray-900 mt-1">
                                Tunai
                            </p>

                        </div>

                    </div>


                    <!-- LOYALTY -->

                    @if ($product->name === 'Kelapa Puding')

                        <div class="mt-6 bg-orange-50 border-l-4 border-orange-500 p-4 rounded-lg">

                            <p class="font-bold text-orange-600">
                                🎁 Loyalty Coupon
                            </p>

                            <p class="text-sm text-gray-600 mt-1">
                                Setiap pembelian Kelapa Puding
                                yang selesai mendapatkan
                                1 loyalty coupon.
                            </p>

                            <p class="text-xs text-gray-500 mt-2">
                                10 loyalty coupon dapat ditukar
                                dengan 1 Kelapa Puding secara offline.
                            </p>

                        </div>

                    @endif


                    <!-- QUANTITY -->

                    <div class="mt-6">

                        <label
                            for="quantity"
                            class="block font-medium text-gray-700 mb-2"
                        >
                            Jumlah
                        </label>

                        <input
                            id="quantity"
                            type="number"
                            name="quantity"
                            min="1"
                            value="{{ old('quantity', 1) }}"
                            disabled
                            class="w-32 border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400"
                        >

                        @error('quantity')

                            <p class="text-red-500 text-sm mt-2">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    <!-- BUTTON -->

                    <button
                        id="addToCartButton"
                        type="submit"
                        disabled
                        class="w-full mt-6 bg-orange-500 text-white py-3 rounded-lg font-semibold hover:bg-orange-600 transition disabled:bg-gray-300 disabled:text-gray-500 disabled:cursor-not-allowed"
                    >
                        Pilih Varian
                    </button>

                </form>


                <!-- BACK -->

                <a
                    href="{{ route('produk') }}"
                    class="inline-block mt-5 text-orange-600 hover:text-orange-700 font-semibold"
                >
                    ← Kembali ke Menu Produk
                </a>

            </div>

        </div>

    </div>

</section>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const radios = document.querySelectorAll('.variant-radio');

    const quantity = document.getElementById('quantity');

    const button = document.getElementById('addToCartButton');

    const nameElement = document.getElementById('selectedVariantName');

    const priceElement = document.getElementById('selectedVariantPrice');

    const stockElement = document.getElementById('selectedVariantStock');


    function formatRupiah(value) {

        return 'Rp ' + Number(value).toLocaleString('id-ID');

    }


    function updateVariant() {

        const selected = document.querySelector(
            '.variant-radio:checked'
        );


        if (!selected) {

            quantity.disabled = true;

            button.disabled = true;

            button.textContent = 'Pilih Varian';

            nameElement.textContent = '-';

            priceElement.textContent = '-';

            stockElement.textContent = '-';

            return;

        }


        const variantName =
            selected.closest('.variant-option')
                .querySelector('.font-semibold')
                .textContent
                .trim();


        const price = selected.dataset.price;

        const stock = Number(selected.dataset.stock);

        const available = selected.dataset.available === '1';


        nameElement.textContent = variantName;

        priceElement.textContent = formatRupiah(price);

        stockElement.textContent =
            available
                ? 'Stok tersedia: ' + stock
                : 'Stok habis';


        if (available && stock > 0) {

            quantity.disabled = false;

            quantity.max = stock;

            if (Number(quantity.value) > stock) {
                quantity.value = stock;
            }

            if (Number(quantity.value) < 1) {
                quantity.value = 1;
            }

            button.disabled = false;

            button.textContent = 'Tambahkan ke Keranjang';

        } else {

            quantity.disabled = true;

            button.disabled = true;

            button.textContent = 'Varian Tidak Tersedia';

        }

    }


    radios.forEach(function (radio) {

        radio.addEventListener(
            'change',
            updateVariant
        );

    });


    quantity.addEventListener('input', function () {

        const selected = document.querySelector(
            '.variant-radio:checked'
        );

        if (!selected) {
            return;
        }

        const stock = Number(selected.dataset.stock);

        let value = Number(quantity.value);

        if (value < 1) {
            value = 1;
        }

        if (value > stock) {
            value = stock;
        }

        quantity.value = value;

    });


    updateVariant();

});

</script>

@endsection