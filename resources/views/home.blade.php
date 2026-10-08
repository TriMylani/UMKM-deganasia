@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

<!-- ========================================================= -->
<!-- HERO -->
<!-- ========================================================= -->

<section class="bg-orange-50">

    <div class="max-w-7xl mx-auto px-6 py-20">

        <div class="grid md:grid-cols-2 gap-12 items-center">

            <!-- HERO CONTENT -->

            <div>

                <p class="text-orange-600 font-semibold mb-3">
                    SELAMAT DATANG DI DEGANASIA
                </p>

                <h1 class="text-4xl md:text-6xl font-bold leading-tight text-gray-900">

                    Segar, Praktis,

                    <span class="text-orange-600">
                        dan Berkualitas
                    </span>

                </h1>

                <p class="mt-6 text-lg text-gray-600 leading-relaxed">

                    Nikmati berbagai pilihan produk segar Deganasia
                    yang dibuat untuk menemani aktivitas dan momen
                    spesial Anda.

                </p>


                <!-- BUTTON -->

                <div class="flex flex-wrap gap-4 mt-8">

                    <a
                        href="{{ route('produk') }}"
                        class="inline-flex
                               items-center
                               justify-center
                               px-6
                               py-3
                               bg-orange-500
                               text-white
                               rounded-xl
                               font-semibold
                               hover:bg-orange-600
                               hover:-translate-y-1
                               transition
                               duration-300
                               shadow-md
                               hover:shadow-xl"
                    >
                        Lihat Menu
                    </a>


                    @if (session('customer_logged_in'))

                        <a
                            href="{{ route('produk') }}"
                            class="inline-flex
                                   items-center
                                   justify-center
                                   px-6
                                   py-3
                                   border-2
                                   border-orange-500
                                   text-orange-600
                                   rounded-xl
                                   font-semibold
                                   hover:bg-orange-500
                                   hover:text-white
                                   hover:-translate-y-1
                                   transition
                                   duration-300"
                        >
                            Pesan Sekarang
                        </a>

                    @else

                        <a
                            href="{{ route('login') }}"
                            class="inline-flex
                                   items-center
                                   justify-center
                                   px-6
                                   py-3
                                   border-2
                                   border-orange-500
                                   text-orange-600
                                   rounded-xl
                                   font-semibold
                                   hover:bg-orange-500
                                   hover:text-white
                                   hover:-translate-y-1
                                   transition
                                   duration-300"
                        >
                            Pesan Sekarang
                        </a>

                    @endif

                </div>


                <!-- LOYALTY -->

                <div
                    class="mt-8
                           bg-white
                           border-l-4
                           border-orange-500
                           rounded-xl
                           p-5
                           shadow-sm"
                >

                    <p class="font-bold text-orange-600">
                        Loyalty Deganasia
                    </p>

                    <p class="text-sm text-gray-600 mt-1 leading-relaxed">

                        Setiap pembelian Kelapa Puding yang selesai
                        memberikan 1 loyalty coupon. Kumpulkan 10 coupon
                        untuk mendapatkan 1 Kelapa Puding gratis.

                    </p>

                </div>

            </div>


            <!-- HERO IMAGE -->

            <div
                class="bg-white
                       rounded-3xl
                       shadow-lg
                       p-6 md:p-10
                       text-center
                       hover:-translate-y-2
                       hover:shadow-2xl
                       transition
                       duration-500"
            >

                <img
                    src="{{ asset('images/landing_page.png') }}"
                    alt="Produk Deganasia"
                    class="w-full max-w-xl mx-auto rounded-3xl object-cover"
                >

                <h2 class="text-2xl font-bold mt-6 text-gray-900">
                    Produk Segar Deganasia
                </h2>

                <p class="text-gray-500 mt-2">
                    Nikmati produk pilihan dengan kualitas terbaik.
                </p>

            </div>

        </div>

    </div>

</section>


<!-- ========================================================= -->
<!-- KEUNGGULAN -->
<!-- ========================================================= -->

<section class="py-16">

    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center mb-10">

            <p class="text-orange-600 font-semibold">
                KEUNGGULAN
            </p>

            <h2 class="text-3xl font-bold mt-2 text-gray-900">
                Mengapa Deganasia?
            </h2>

        </div>


        <div class="grid md:grid-cols-3 gap-6">

            <!-- QUALITY -->

            <div
                class="group
                       bg-white
                       p-8
                       rounded-2xl
                       shadow-sm
                       text-center
                       border
                       border-transparent
                       hover:border-orange-300
                       hover:-translate-y-3
                       hover:shadow-2xl
                       transition-all
                       duration-500"
            >

                <div
                    class="w-20
                           h-20
                           mx-auto
                           rounded-2xl
                           bg-orange-50
                           flex
                           items-center
                           justify-center
                           text-4xl
                           group-hover:bg-orange-500
                           group-hover:scale-110
                           transition-all
                           duration-500"
                >
                    🥗
                </div>

                <h3 class="font-bold text-xl mt-5 group-hover:text-orange-600">
                    Produk Berkualitas
                </h3>

                <p class="text-gray-500 mt-2">
                    Menggunakan bahan yang dipilih untuk menjaga kualitas produk.
                </p>

            </div>


            <!-- FRESH -->

            <div
                class="group
                       bg-white
                       p-8
                       rounded-2xl
                       shadow-sm
                       text-center
                       border
                       border-transparent
                       hover:border-orange-300
                       hover:-translate-y-3
                       hover:shadow-2xl
                       transition-all
                       duration-500"
            >

                <div
                    class="w-20
                           h-20
                           mx-auto
                           rounded-2xl
                           bg-orange-50
                           flex
                           items-center
                           justify-center
                           text-4xl
                           group-hover:bg-orange-500
                           group-hover:scale-110
                           transition-all
                           duration-500"
                >
                    ✨
                </div>

                <h3 class="font-bold text-xl mt-5 group-hover:text-orange-600">
                    Segar dan Praktis
                </h3>

                <p class="text-gray-500 mt-2">
                    Pilihan produk yang praktis untuk berbagai kebutuhan.
                </p>

            </div>


            <!-- SERVICE -->

            <div
                class="group
                       bg-white
                       p-8
                       rounded-2xl
                       shadow-sm
                       text-center
                       border
                       border-transparent
                       hover:border-orange-300
                       hover:-translate-y-3
                       hover:shadow-2xl
                       transition-all
                       duration-500"
            >

                <div
                    class="w-20
                           h-20
                           mx-auto
                           rounded-2xl
                           bg-orange-50
                           flex
                           items-center
                           justify-center
                           text-4xl
                           group-hover:bg-orange-500
                           group-hover:scale-110
                           transition-all
                           duration-500"
                >
                    ❤️
                </div>

                <h3 class="font-bold text-xl mt-5 group-hover:text-orange-600">
                    Pelayanan Terbaik
                </h3>

                <p class="text-gray-500 mt-2">
                    Kami berusaha memberikan pengalaman terbaik kepada pelanggan.
                </p>

            </div>

        </div>

    </div>

</section>


<!-- ========================================================= -->
<!-- PRODUK UNGGULAN -->
<!-- ========================================================= -->

<section class="bg-white py-16">

    <div class="max-w-7xl mx-auto px-6">

        <div class="flex justify-between items-end mb-10">

            <div>

                <p class="text-orange-600 font-semibold">
                    PILIHAN PRODUK
                </p>

                <h2 class="text-3xl font-bold mt-2 text-gray-900">
                    Produk Unggulan
                </h2>

            </div>


            <a
                href="{{ route('produk') }}"
                class="hidden md:block text-orange-600 font-semibold hover:text-orange-800 transition"
            >
                Lihat Semua →
            </a>

        </div>


        @if ($featuredProducts->count())

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">

                @foreach ($featuredProducts as $item)

                    <div
                        class="group
                               bg-white
                               rounded-2xl
                               overflow-hidden
                               shadow-sm
                               border
                               border-gray-100
                               hover:border-orange-300
                               hover:-translate-y-3
                               hover:shadow-2xl
                               transition-all
                               duration-500"
                    >

                        <!-- IMAGE -->

                        <div
                            class="h-52
                                   bg-orange-50
                                   overflow-hidden
                                   group-hover:bg-orange-100
                                   transition
                                   duration-500"
                        >

                            @if ($item->image)

                                <img
                                    src="{{ asset('images/' . $item->image) }}"
                                    alt="{{ $item->name }}"
                                    class="w-full
                                           h-full
                                           object-cover
                                           group-hover:scale-110
                                           transition-all
                                           duration-500"
                                >

                            @else

                                <div class="w-full h-full flex items-center justify-center text-5xl">
                                    🥥
                                </div>

                            @endif

                        </div>


                        <!-- CONTENT -->

                        <div class="p-6">

                            <p class="text-sm text-orange-600 font-semibold">
                                {{ optional($item->category)->name ?? 'Tanpa Kategori' }}
                            </p>

                            <h3
                                class="text-xl
                                       font-bold
                                       mt-1
                                       text-gray-900
                                       group-hover:text-orange-600"
                            >
                                {{ $item->name }}
                            </h3>

                            <p class="text-gray-500 text-sm mt-2 line-clamp-2">
                                {{ $item->description ?? 'Produk pilihan Deganasia.' }}
                            </p>


                            <div class="flex justify-between items-center mt-5">

                                <span class="font-bold text-orange-600">
                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                </span>


                                <a
                                    href="{{ route('produk.detail', $item->id) }}"
                                    class="text-sm
                                           font-semibold
                                           text-orange-600
                                           hover:text-orange-800
                                           transition"
                                >
                                    Detail
                                </a>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="text-center py-12">

                <p class="text-gray-500">
                    Belum ada produk yang tersedia.
                </p>

            </div>

        @endif

    </div>

</section>



<!-- ========================================================= -->
<!-- LOKASI -->
<!-- ========================================================= -->

<section class="py-16 bg-orange-50">

    <div class="max-w-7xl mx-auto px-6">

        <div class="grid md:grid-cols-2 gap-10 items-center">

            <!-- LOCATION INFO -->

            <div>

                <p class="text-orange-600 font-semibold">
                    LOKASI OFFLINE
                </p>

                <h2 class="text-3xl font-bold mt-2 text-gray-900">
                    Temukan Deganasia di CFD Purbalingga
                </h2>

                <p class="text-gray-600 mt-4 leading-relaxed">
                    Selain pemesanan online, Deganasia juga hadir
                    di lokasi offline untuk memudahkan pelanggan
                    menikmati produk secara langsung.
                </p>

                <div
                    class="mt-6
                           p-5
                           bg-white
                           rounded-xl
                           shadow-sm
                           hover:shadow-lg
                           hover:-translate-y-1
                           transition"
                >

                    <p class="font-semibold text-gray-900">
                        CFD Purbalingga
                    </p>

                    <p class="text-gray-500 mt-1">
                        CFD Jalan Onje, Alun-Alun Purbalingga, Stand 14.
                    </p>

                </div>


                <!-- GOOGLE MAPS BUTTON -->

                <a
                    href="https://www.google.com/maps/search/?api=1&query=Alun-Alun+Purbalingga"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex
                           items-center
                           justify-center
                           mt-5
                           px-6
                           py-3
                           bg-orange-500
                           text-white
                           rounded-xl
                           font-semibold
                           hover:bg-orange-600
                           hover:-translate-y-1
                           transition
                           duration-300
                           shadow-md
                           hover:shadow-xl"
                >
                    Buka di Google Maps
                </a>

            </div>


            <!-- GOOGLE MAP -->

            <div
                class="bg-white
                       rounded-2xl
                       overflow-hidden
                       shadow-sm
                       hover:shadow-xl
                       transition
                       duration-500"
            >

                <div class="aspect-[4/3] md:aspect-[16/10]">

                    <iframe
                        src="https://www.google.com/maps?q=Alun-Alun+Purbalingga&output=embed"
                        width="100%"
                        height="100%"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Lokasi Deganasia di Alun-Alun Purbalingga"
                    ></iframe>

                </div>

            </div>

        </div>

    </div>

</section>



<!-- ========================================================= -->
<!-- CARA PEMESANAN -->
<!-- ========================================================= -->

<section class="py-16">

    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center mb-10">

            <p class="text-orange-600 font-semibold">
                CARA PEMESANAN
            </p>

            <h2 class="text-3xl font-bold mt-2">
                Pesan dengan Mudah
            </h2>

        </div>


        @php

            $steps = [
                [
                    'number' => 1,
                    'title' => 'Pilih Produk',
                    'description' => 'Pilih produk yang ingin dipesan.'
                ],
                [
                    'number' => 2,
                    'title' => 'Masukkan Keranjang',
                    'description' => 'Atur jumlah produk sesuai kebutuhan.'
                ],
                [
                    'number' => 3,
                    'title' => 'Checkout',
                    'description' => 'Pilih tanggal dan metode pemenuhan pesanan.'
                ],
                [
                    'number' => 4,
                    'title' => 'Selesaikan Pesanan',
                    'description' => 'Pembayaran dilakukan secara tunai.'
                ]
            ];

        @endphp


        <div class="grid md:grid-cols-4 gap-6">

            @foreach ($steps as $step)

                <div
                    class="text-center
                           group
                           hover:-translate-y-2
                           transition
                           duration-300"
                >

                    <div
                        class="w-14
                               h-14
                               mx-auto
                               rounded-full
                               bg-orange-100
                               flex
                               items-center
                               justify-center
                               font-bold
                               text-orange-600
                               group-hover:bg-orange-500
                               group-hover:text-white
                               group-hover:scale-110
                               transition
                               duration-300"
                    >
                        {{ $step['number'] }}
                    </div>

                    <h3 class="font-bold mt-4">
                        {{ $step['title'] }}
                    </h3>

                    <p class="text-sm text-gray-500 mt-2">
                        {{ $step['description'] }}
                    </p>

                </div>

            @endforeach

        </div>

    </div>

</section>


<!-- ========================================================= -->
<!-- LOYALTY -->
<!-- ========================================================= -->

<section class="py-16">

    <div class="max-w-5xl mx-auto px-6">

        <div
            class="rounded-3xl
                   bg-gradient-to-r
                   from-orange-500
                   to-amber-500
                   text-white
                   p-10
                   text-center
                   shadow-xl
                   hover:shadow-2xl
                   transition"
        >

            <div class="text-5xl">
                🎁
            </div>

            <h2 class="text-3xl font-bold mt-4">
                Kumpulkan Loyalty Coupon
            </h2>

            <p class="mt-4 max-w-2xl mx-auto text-orange-50 leading-relaxed">

                Setiap 1 Kelapa Puding yang telah selesai
                dipesan memberikan 1 loyalty coupon.
                Kumpulkan 10 coupon dan tukarkan secara
                offline untuk mendapatkan 1 Kelapa Puding gratis.

            </p>

            <p class="mt-4 font-semibold">
                Loyalty berlaku untuk Kelapa Puding.
            </p>

        </div>

    </div>

</section>


<!-- ========================================================= -->
<!-- CUSTOMER REVIEW -->
<!-- ========================================================= -->

<section class="py-20 bg-white">

    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center max-w-2xl mx-auto">

            <p class="text-orange-600 font-semibold">
                TESTIMONI CUSTOMER
            </p>

            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-2">
                Apa Kata Customer Kami?
            </h2>

            <p class="text-gray-500 mt-4">
                Pengalaman customer setelah menikmati produk Deganasia.
            </p>

        </div>


        @if (count($reviews) > 0)

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mt-12">

                @foreach ($reviews as $review)

                    <div
                        class="bg-amber-50
                               rounded-3xl
                               p-6
                               border
                               border-amber-100
                               hover:-translate-y-2
                               hover:shadow-xl
                               transition
                               duration-300"
                    >

                        <!-- RATING -->

                        <div class="flex gap-1 text-yellow-400 text-xl">

                            @for ($i = 1; $i <= 5; $i++)

                                @if ($i <= $review['rating'])

                                    ★

                                @else

                                    <span class="text-gray-300">
                                        ★
                                    </span>

                                @endif

                            @endfor

                        </div>


                        <!-- COMMENT -->

                        <p class="text-gray-700 mt-5 leading-relaxed">
                            "{{ $review['komentar'] }}"
                        </p>


                        <!-- CUSTOMER -->

                        <div class="flex items-center gap-3 mt-6">

                            <div
                                class="w-11
                                       h-11
                                       rounded-full
                                       bg-orange-500
                                       text-white
                                       flex
                                       items-center
                                       justify-center
                                       font-bold"
                            >
                                {{ strtoupper(substr($review['nama'], 0, 1)) }}
                            </div>

                            <div>

                                <p class="font-bold text-gray-900">
                                    {{ $review['nama'] }}
                                </p>

                                <p class="text-sm text-gray-500">
                                    {{ $review['tanggal'] }}
                                </p>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="mt-12 text-center">

                <div class="inline-block bg-amber-50 rounded-2xl px-8 py-6">

                    <p class="text-gray-500">
                        Belum ada review dari customer.
                    </p>

                    <p class="text-sm text-gray-400 mt-1">
                        Jadilah customer pertama yang memberikan review.
                    </p>

                </div>

            </div>

        @endif

    </div>

</section>


<!-- ========================================================= -->
<!-- FAQ -->
<!-- ========================================================= -->

<section class="bg-white py-16">

    <div class="max-w-4xl mx-auto px-6">

        <div class="text-center mb-10">

            <p class="text-orange-600 font-semibold">
                FAQ
            </p>

            <h2 class="text-3xl font-bold mt-2">
                Pertanyaan Umum
            </h2>

        </div>


        <div class="space-y-4">

            <!-- FAQ 1 -->

            <div
                class="border
                       rounded-xl
                       p-5
                       hover:border-orange-400
                       hover:shadow-md
                       transition"
            >

                <h3 class="font-semibold">
                    Kapan pesanan dapat dipenuhi?
                </h3>

                <p class="text-gray-500 mt-2">
                    Pemesanan mengikuti aturan minimum H-3.
                </p>

            </div>


            <!-- FAQ 2 -->

            <div
                class="border
                       rounded-xl
                       p-5
                       hover:border-orange-400
                       hover:shadow-md
                       transition"
            >

                <h3 class="font-semibold">
                    Apakah tersedia pickup dan delivery?
                </h3>

                <p class="text-gray-500 mt-2">
                    Customer dapat memilih metode pemenuhan pesanan
                    saat checkout.
                </p>

            </div>


            <!-- FAQ 3 -->

            <div
                class="border
                       rounded-xl
                       p-5
                       hover:border-orange-400
                       hover:shadow-md
                       transition"
            >

                <h3 class="font-semibold">
                    Bagaimana sistem loyalty coupon?
                </h3>

                <p class="text-gray-500 mt-2 leading-relaxed">

                    Setiap pembelian Kelapa Puding yang selesai
                    menghasilkan 1 loyalty coupon.

                    10 coupon dapat ditukarkan secara offline
                    menjadi 1 Kelapa Puding gratis.

                </p>

            </div>

        </div>

    </div>

</section>

@endsection
