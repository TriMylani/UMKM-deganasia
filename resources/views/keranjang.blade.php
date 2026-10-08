@extends('layouts.app')

@section('title', 'Keranjang')

@section('content')

<section class="py-16 bg-amber-50 min-h-[70vh]">

    <div class="max-w-6xl mx-auto px-6">

        <div class="mb-8">

            <p class="text-orange-500 font-semibold">
                BELANJA
            </p>

            <h1 class="text-3xl font-bold text-gray-900 mt-1">
                Keranjang Belanja
            </h1>

            <p class="text-gray-600 mt-2">
                Periksa kembali produk, varian, dan jumlah pesanan Anda.
            </p>

        </div>


        <div class="grid lg:grid-cols-3 gap-8">

            <!-- ITEMS -->

            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm p-6">

                @if (session('error'))

                    <div class="mb-6 rounded-xl bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-sm">
                        {{ session('error') }}
                    </div>

                @endif


                @if (session('success'))

                    <div class="mb-6 rounded-xl bg-green-50 border border-green-200 text-green-700 px-4 py-3 text-sm">
                        {{ session('success') }}
                    </div>

                @endif


                @forelse ($cart as $item)

                    <div class="flex flex-col sm:flex-row sm:items-center gap-5 border-b border-gray-100 pb-6 mb-6 last:border-b-0 last:pb-0 last:mb-0">

                        <!-- IMAGE -->

                        <div class="w-24 h-24 bg-orange-50 rounded-xl overflow-hidden flex-shrink-0">

                            @if (!empty($item['gambar']))

                                <img
                                    src="{{ asset('images/' . $item['gambar']) }}"
                                    alt="{{ $item['nama'] }}"
                                    class="w-full h-full object-cover"
                                >

                            @else

                                <div class="w-full h-full flex items-center justify-center text-3xl">
                                    🥥
                                </div>

                            @endif

                        </div>


                        <!-- INFO -->

                        <div class="flex-1 min-w-0">

                            <h2 class="font-bold text-lg text-gray-900">
                                {{ $item['nama'] }}
                            </h2>

                            <p class="text-sm text-gray-500 mt-1">
                                Varian:
                                <span class="font-semibold text-gray-700">
                                    {{ $item['varian'] }}
                                </span>
                            </p>

                            <p class="text-orange-500 font-semibold mt-2">
                                Rp {{ number_format($item['harga'], 0, ',', '.') }}
                                × {{ $item['quantity'] }}
                            </p>

                            <p class="text-xs text-gray-500 mt-1">
                                Stok tersedia: {{ $item['stock'] }}
                            </p>


                            <!-- QUANTITY -->

                            <div class="flex items-center gap-3 mt-4">

                                <form
                                    method="POST"
                                    action="{{ route('keranjang.update') }}"
                                >

                                    @csrf

                                    <button
                                        type="submit"
                                        name="quantity[{{ $item['id'] }}]"
                                        value="{{ max(0, $item['quantity'] - 1) }}"
                                        class="w-9 h-9 border border-gray-300 rounded-lg flex items-center justify-center hover:bg-gray-100 transition"
                                        aria-label="Kurangi jumlah"
                                    >
                                        −
                                    </button>

                                </form>


                                <span class="font-semibold min-w-[32px] text-center text-gray-900">
                                    {{ $item['quantity'] }}
                                </span>


                                <form
                                    method="POST"
                                    action="{{ route('keranjang.update') }}"
                                >

                                    @csrf

                                    <button
                                        type="submit"
                                        name="quantity[{{ $item['id'] }}]"
                                        value="{{ $item['quantity'] + 1 }}"
                                        class="w-9 h-9 border border-gray-300 rounded-lg flex items-center justify-center hover:bg-gray-100 transition disabled:bg-gray-100 disabled:text-gray-400"
                                        aria-label="Tambah jumlah"
                                        @if ($item['quantity'] >= $item['stock'])
                                            disabled
                                        @endif
                                    >
                                        +
                                    </button>

                                </form>

                            </div>

                        </div>


                        <!-- SUBTOTAL -->

                        <div class="sm:text-right sm:min-w-[150px]">

                            <p class="text-xs text-gray-500 mb-1">
                                Subtotal
                            </p>

                            <p class="font-bold text-gray-800">
                                Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                            </p>


                            <form
                                method="POST"
                                action="{{ route('keranjang.hapus') }}"
                                class="mt-3"
                            >

                                @csrf

                                <button
                                    type="submit"
                                    name="id"
                                    value="{{ $item['id'] }}"
                                    class="text-red-500 hover:text-red-700 text-sm transition"
                                >
                                    Hapus
                                </button>

                            </form>

                        </div>

                    </div>

                @empty

                    <div class="text-center py-16">

                        <h2 class="font-bold text-xl text-gray-900 mt-5">
                            Keranjang masih kosong
                        </h2>

                        <p class="text-gray-500 mt-2">
                            Yuk pilih produk yang ingin kamu pesan.
                        </p>

                        <a
                            href="{{ route('produk') }}"
                            class="inline-block mt-6 bg-orange-500 text-white px-6 py-3 rounded-xl font-semibold hover:bg-orange-600 transition"
                        >
                            Lihat Produk
                        </a>

                    </div>

                @endforelse

            </div>


            <!-- SUMMARY -->

            <div class="bg-white rounded-2xl shadow-sm p-6 h-fit">

                <h2 class="text-xl font-bold text-gray-900">
                    Ringkasan Pesanan
                </h2>


                <div class="flex justify-between mt-6 text-gray-600">

                    <span>
                        Subtotal
                    </span>

                    <span class="font-medium text-gray-900">
                        Rp {{ number_format($total, 0, ',', '.') }}
                    </span>

                </div>


                <div class="flex justify-between mt-3 text-gray-600">

                    <span>
                        Pengiriman
                    </span>

                    <span class="font-medium text-gray-900">
                        Diatur saat checkout
                    </span>

                </div>


                <div class="border-t border-gray-200 mt-5 pt-5 flex justify-between font-bold text-lg">

                    <span>
                        Total
                    </span>

                    <span class="text-orange-500">
                        Rp {{ number_format($total, 0, ',', '.') }}
                    </span>

                </div>


                @if (count($cart) > 0)

                    <a
                        href="{{ route('checkout') }}"
                        class="block text-center mt-6 bg-orange-500 text-white py-3 rounded-xl font-semibold hover:bg-orange-600 transition shadow-lg shadow-orange-100"
                    >
                        Lanjut Checkout
                    </a>

                @else

                    <button
                        type="button"
                        disabled
                        class="w-full mt-6 bg-gray-200 text-gray-400 py-3 rounded-xl font-semibold cursor-not-allowed"
                    >
                        Lanjut Checkout
                    </button>

                @endif


                <div class="mt-5 rounded-xl bg-amber-50 border border-amber-100 p-4">

                    <p class="text-sm font-semibold text-amber-800">
                         Perhatian Pemesanan
                    </p>

                    <p class="text-xs text-amber-700 mt-1 leading-relaxed">
                        Semua produk Deganasia wajib dipesan minimal
                        H-3 sebelum tanggal pemenuhan pesanan.
                    </p>

                </div>

            </div>

        </div>

    </div>

</section>

@endsection