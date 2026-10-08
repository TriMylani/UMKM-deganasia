@extends('layouts.app')

@section('title', 'Checkout')

@section('content')

<section class="py-16 bg-gray-50">

    <div class="max-w-6xl mx-auto px-6">

        <!-- HEADER -->

        <div>
            <p class="text-orange-600 font-semibold">
                PEMESANAN
            </p>

            <h1 class="text-3xl font-bold text-gray-900 mt-1">
                Checkout
            </h1>

            <p class="text-gray-500 mt-2">
                Lengkapi informasi pemesanan Anda.
            </p>
        </div>


        <!-- ERROR -->

        @if ($errors->any())

            <div
                class="mt-6
                       bg-red-50
                       border
                       border-red-200
                       text-red-700
                       p-5
                       rounded-xl"
            >

                <p class="font-bold mb-2">
                    Periksa kembali data berikut:
                </p>

                <ul class="list-disc ml-5 space-y-1">

                    @foreach ($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        <!-- SUCCESS -->

        @if (session('success'))

            <div
                class="mt-6
                       bg-green-50
                       border
                       border-green-200
                       text-green-700
                       p-5
                       rounded-xl"
            >
                {{ session('success') }}
            </div>

        @endif


        <form
            method="POST"
            action="{{ route('checkout.proses') }}"
            class="grid lg:grid-cols-3 gap-8 mt-8"
        >

            @csrf


            <!-- ================================================= -->
            <!-- FORM CHECKOUT -->
            <!-- ================================================= -->

            <div class="lg:col-span-2 space-y-6">


                <!-- TANGGAL PEMENUHAN -->

                <div class="bg-white rounded-2xl shadow-sm p-6">

                    <h2 class="text-xl font-bold text-gray-900">
                        Tanggal Pemenuhan Pesanan
                        <span class="text-red-500">*</span>
                    </h2>

                    <p class="text-gray-500 text-sm mt-2">
                        Pesanan harus dibuat minimal H-3 dari tanggal pemenuhan.
                    </p>


                    <label
                        for="tanggal_pemesanan"
                        class="block text-sm font-semibold text-gray-700 mt-5 mb-2"
                    >
                        Pilih tanggal
                    </label>

                    <input
                        id="tanggal_pemesanan"
                        type="date"
                        name="tanggal_pemesanan"
                        min="{{ now()->addDays(3)->format('Y-m-d') }}"
                        value="{{ old('tanggal_pemesanan') }}"
                        required
                        class="w-full
                               border
                               border-gray-300
                               rounded-xl
                               px-4
                               py-3
                               focus:ring-2
                               focus:ring-orange-400
                               focus:border-orange-400
                               focus:outline-none"
                    >


                    @error('tanggal_pemesanan')

                        <p class="text-sm text-red-500 mt-2">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                <!-- ================================================= -->
                <!-- METODE PEMENUHAN -->
                <!-- ================================================= -->

                <div class="bg-white rounded-2xl shadow-sm p-6">

                    <h2 class="text-xl font-bold text-gray-900">
                        Metode Pemenuhan Pesanan
                        <span class="text-red-500">*</span>
                    </h2>

                    <p class="text-gray-500 text-sm mt-2">
                        Pilih cara menerima pesanan Anda.
                    </p>


                    <div class="grid md:grid-cols-2 gap-4 mt-5">


                        <!-- PICKUP CFD -->

                        <label
                            class="group
                                   block
                                   border
                                   border-gray-200
                                   rounded-xl
                                   p-5
                                   cursor-pointer
                                   hover:border-orange-400
                                   hover:bg-orange-50
                                   transition"
                        >

                            <div class="flex items-start gap-3">

                                <input
                                    type="radio"
                                    name="metode_transaksi"
                                    value="pickup_cfd"
                                    required
                                    {{ old('metode_transaksi') === 'pickup_cfd' ? 'checked' : '' }}
                                    class="mt-1 accent-orange-500"
                                >

                                <div>

                                    <span class="font-semibold text-gray-900">
                                        Pickup CFD
                                    </span>

                                    <p class="text-sm text-gray-500 mt-2 leading-relaxed">
                                        Ambil pesanan di CFD Jalan Onje,
                                        Alun-Alun Purbalingga, Stand 14.
                                    </p>

                                </div>

                            </div>

                        </label>


                        <!-- PICKUP RUMAH PRODUKSI -->

                        <label
                            class="group
                                   block
                                   border
                                   border-gray-200
                                   rounded-xl
                                   p-5
                                   cursor-pointer
                                   hover:border-orange-400
                                   hover:bg-orange-50
                                   transition"
                        >

                            <div class="flex items-start gap-3">

                                <input
                                    type="radio"
                                    name="metode_transaksi"
                                    value="pickup_rumah"
                                    required
                                    {{ old('metode_transaksi') === 'pickup_rumah' ? 'checked' : '' }}
                                    class="mt-1 accent-orange-500"
                                >

                                <div>

                                    <span class="font-semibold text-gray-900">
                                        Pickup Rumah Produksi
                                    </span>

                                    <p class="text-sm text-gray-500 mt-2 leading-relaxed">
                                        Ambil pesanan langsung di rumah produksi
                                        Deganasia.
                                    </p>

                                </div>

                            </div>

                        </label>


                        <!-- DELIVERY -->

                        <label
                            class="group
                                   block
                                   border
                                   border-gray-200
                                   rounded-xl
                                   p-5
                                   cursor-pointer
                                   hover:border-orange-400
                                   hover:bg-orange-50
                                   transition"
                        >

                            <div class="flex items-start gap-3">

                                <input
                                    type="radio"
                                    name="metode_transaksi"
                                    value="delivery"
                                    required
                                    {{ old('metode_transaksi') === 'delivery' ? 'checked' : '' }}
                                    class="mt-1 accent-orange-500"
                                >

                                <div>

                                    <span class="font-semibold text-gray-900">
                                        Delivery
                                    </span>

                                    <p class="text-sm text-gray-500 mt-2 leading-relaxed">
                                        Pesanan diantar ke alamat yang Anda berikan.
                                    </p>

                                </div>

                            </div>

                        </label>


                        <!-- COD -->

                        <label
                            class="group
                                   block
                                   border
                                   border-gray-200
                                   rounded-xl
                                   p-5
                                   cursor-pointer
                                   hover:border-orange-400
                                   hover:bg-orange-50
                                   transition"
                        >

                            <div class="flex items-start gap-3">

                                <input
                                    type="radio"
                                    name="metode_transaksi"
                                    value="cod"
                                    required
                                    {{ old('metode_transaksi') === 'cod' ? 'checked' : '' }}
                                    class="mt-1 accent-orange-500"
                                >

                                <div>

                                    <span class="font-semibold text-gray-900">
                                        COD / Meet Area
                                    </span>

                                    <p class="text-sm text-gray-500 mt-2 leading-relaxed">
                                        Bayar tunai saat bertemu di lokasi
                                        yang telah disepakati.
                                    </p>

                                </div>

                            </div>

                        </label>

                    </div>


                    @error('metode_transaksi')

                        <p class="text-sm text-red-500 mt-3">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                <!-- ================================================= -->
                <!-- ALAMAT / LOKASI -->
                <!-- ================================================= -->

                <div
                    id="alamatContainer"
                    class="bg-white rounded-2xl shadow-sm p-6 hidden"
                >

                    <h2
                        id="alamatTitle"
                        class="text-xl font-bold text-gray-900"
                    >
                        Alamat Pengiriman
                        <span class="text-red-500">*</span>
                    </h2>


                    <p
                        id="alamatDescription"
                        class="text-gray-500 text-sm mt-2"
                    >
                        Masukkan alamat lengkap tujuan pengiriman.
                    </p>


                    <label
                        for="alamatLokasi"
                        class="block text-sm font-semibold text-gray-700 mt-5 mb-2"
                    >
                        Alamat / Lokasi
                    </label>


                    <textarea
                        id="alamatLokasi"
                        name="alamat_lokasi"
                        rows="4"
                        placeholder="Masukkan alamat..."
                        class="w-full
                               border
                               border-gray-300
                               rounded-xl
                               px-4
                               py-3
                               focus:ring-2
                               focus:ring-orange-400
                               focus:border-orange-400
                               focus:outline-none"
                    >{{ old('alamat_lokasi') }}</textarea>


                    @error('alamat_lokasi')

                        <p class="text-sm text-red-500 mt-2">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                <!-- ================================================= -->
                <!-- PEMBAYARAN -->
                <!-- ================================================= -->

                <div class="bg-white rounded-2xl shadow-sm p-6">

                    <h2 class="text-xl font-bold text-gray-900">
                        Pembayaran
                    </h2>


                    <div
                        class="mt-5
                               bg-orange-50
                               border-l-4
                               border-orange-500
                               p-5
                               rounded-lg"
                    >

                        <div class="flex items-center gap-3">

                            <p class="font-bold text-orange-600">
                                Pembayaran Tunai
                            </p>

                        </div>


                        <p class="text-sm text-gray-600 mt-2 leading-relaxed">
                            Pembayaran dilakukan secara tunai sesuai
                            metode pemenuhan pesanan yang dipilih.
                        </p>

                    </div>

                </div>


                <!-- ================================================= -->
                <!-- CATATAN CUSTOMER -->
                <!-- ================================================= -->

                <div class="bg-white rounded-2xl shadow-sm p-6">

                    <h2 class="text-xl font-bold text-gray-900">
                        Catatan Pesanan
                    </h2>

                    <p class="text-gray-500 text-sm mt-2">
                        Tambahkan catatan jika ada informasi khusus untuk pesanan.
                    </p>

                    <textarea
                        name="catatan"
                        rows="4"
                        maxlength="1000"
                        placeholder="Contoh: Tolong siapkan pesanan pukul 08.00..."
                        class="w-full
                               mt-5
                               border
                               border-gray-300
                               rounded-xl
                               px-4
                               py-3
                               focus:ring-2
                               focus:ring-orange-400
                               focus:border-orange-400
                               focus:outline-none"
                    >{{ old('catatan') }}</textarea>

                    @error('catatan')

                        <p class="text-sm text-red-500 mt-2">
                            {{ $message }}
                        </p>

                    @enderror

                </div>

            </div>


            <!-- ================================================= -->
            <!-- RINGKASAN PESANAN -->
            <!-- ================================================= -->

            <div
                class="bg-white
                       rounded-2xl
                       shadow-sm
                       p-6
                       h-fit
                       lg:sticky
                       lg:top-24"
            >

                <h2 class="text-xl font-bold text-gray-900">
                    Ringkasan Pesanan
                </h2>


                @forelse ($cart as $item)

                    <div
                        class="mt-6
                               pb-5
                               border-b
                               border-gray-100"
                    >

                        <div class="flex justify-between gap-4">

                            <div class="min-w-0">

                                <!-- PRODUCT NAME -->

                                <p class="font-semibold text-gray-800">
                                    {{ $item['nama'] }}
                                </p>


                                <!-- VARIANT -->

                                <p class="text-sm text-orange-600 font-medium mt-1">
                                    Varian:
                                    {{ $item['varian'] ?? 'Regular' }}
                                </p>


                                <!-- QUANTITY × PRICE -->

                                <p class="text-sm text-gray-500 mt-1">

                                    {{ $item['quantity'] }} ×
                                    Rp {{ number_format(
                                        $item['harga'],
                                        0,
                                        ',',
                                        '.'
                                    ) }}

                                </p>

                            </div>


                            <!-- SUBTOTAL -->

                            <span
                                class="font-semibold
                                       text-gray-800
                                       whitespace-nowrap"
                            >

                                Rp {{ number_format(
                                    $item['subtotal'],
                                    0,
                                    ',',
                                    '.'
                                ) }}

                            </span>

                        </div>

                    </div>

                @empty

                    <div class="py-8 text-center">

                        <div class="text-4xl">
                            🛒
                        </div>

                        <p class="text-gray-500 mt-3">
                            Keranjang masih kosong.
                        </p>

                        <a
                            href="{{ route('produk') }}"
                            class="inline-block
                                   mt-4
                                   text-orange-600
                                   font-semibold
                                   hover:text-orange-800"
                        >
                            Lihat Produk
                        </a>

                    </div>

                @endforelse


                <!-- TOTAL -->

                <div
                    class="border-t
                           mt-6
                           pt-6
                           flex
                           justify-between
                           items-center"
                >

                    <span class="font-bold text-gray-900">
                        Total
                    </span>

                    <span class="text-xl font-bold text-orange-600">

                        Rp {{ number_format(
                            $total,
                            0,
                            ',',
                            '.'
                        ) }}

                    </span>

                </div>


                <!-- H-3 NOTICE -->

                <div
                    class="mt-5
                           bg-amber-50
                           border
                           border-amber-100
                           rounded-xl
                           p-4"
                >

                    <p class="text-sm font-semibold text-amber-800">
                        Perhatian Pemesanan
                    </p>

                    <p class="text-xs text-amber-700 mt-1 leading-relaxed">
                        Semua produk Deganasia wajib dipesan minimal
                        H-3 sebelum tanggal pemenuhan pesanan.
                    </p>

                </div>


                <!-- PAYMENT NOTICE -->

                <div
                    class="mt-4
                           bg-orange-50
                           border
                           border-orange-100
                           rounded-xl
                           p-4"
                >

                    <p class="text-sm font-semibold text-orange-800">
                        Pembayaran Tunai
                    </p>

                    <p class="text-xs text-orange-700 mt-1 leading-relaxed">
                        Pembayaran dilakukan secara tunai sesuai
                        metode pemenuhan yang dipilih.
                    </p>

                </div>


                <!-- SUBMIT -->

                @if (count($cart) > 0)

                    <button
                        type="submit"
                        class="w-full
                               mt-6
                               bg-orange-500
                               text-white
                               py-3
                               rounded-xl
                               font-semibold
                               hover:bg-orange-600
                               hover:-translate-y-0.5
                               transition
                               shadow-md
                               hover:shadow-lg"
                    >
                        Buat Pesanan
                    </button>

                @else

                    <button
                        type="button"
                        disabled
                        class="w-full
                               mt-6
                               bg-gray-200
                               text-gray-400
                               py-3
                               rounded-xl
                               font-semibold
                               cursor-not-allowed"
                    >
                        Keranjang Kosong
                    </button>

                @endif


                <p class="text-xs text-gray-400 text-center mt-4">
                    Pastikan tanggal, metode pemenuhan,
                    dan detail pesanan sudah sesuai.
                </p>

            </div>

        </form>

    </div>

</section>


<!-- ========================================================= -->
<!-- ALAMAT / LOKASI SCRIPT -->
<!-- ========================================================= -->

<script>

document.addEventListener('DOMContentLoaded', function () {

    const radios = document.querySelectorAll(
        'input[name="metode_transaksi"]'
    );

    const container = document.getElementById(
        'alamatContainer'
    );

    const title = document.getElementById(
        'alamatTitle'
    );

    const description = document.getElementById(
        'alamatDescription'
    );

    const textarea = document.getElementById(
        'alamatLokasi'
    );


    function updateAlamat() {

        const selected = document.querySelector(
            'input[name="metode_transaksi"]:checked'
        );


        /*
        |--------------------------------------------------------------------------
        | BELUM MEMILIH METODE
        |--------------------------------------------------------------------------
        */

        if (!selected) {

            container.classList.add('hidden');

            textarea.removeAttribute('required');

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | DELIVERY
        |--------------------------------------------------------------------------
        */

        if (selected.value === 'delivery') {

            container.classList.remove('hidden');

            title.innerHTML =
                'Alamat Pengiriman <span class="text-red-500">*</span>';

            description.innerText =
                'Masukkan alamat lengkap tujuan pengiriman.';

            textarea.placeholder =
                'Contoh: Jalan Onje No. 10, Purbalingga...';

            textarea.setAttribute(
                'required',
                'required'
            );

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | COD / MEET AREA
        |--------------------------------------------------------------------------
        */

        if (selected.value === 'cod') {

            container.classList.remove('hidden');

            title.innerHTML =
                'Lokasi Ketemuan <span class="text-red-500">*</span>';

            description.innerText =
                'Masukkan lokasi yang disepakati untuk COD / meet area.';

            textarea.placeholder =
                'Contoh: Alun-Alun Purbalingga, depan pintu masuk...';

            textarea.setAttribute(
                'required',
                'required'
            );

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | PICKUP
        |--------------------------------------------------------------------------
        */

        container.classList.add('hidden');

        textarea.removeAttribute('required');

    }


    radios.forEach(function (radio) {

        radio.addEventListener(
            'change',
            updateAlamat
        );

    });


    updateAlamat();

});

</script>

@endsection

