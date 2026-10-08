@extends('layouts.app')

@section('title', 'Kontak')

@section('content')

<section class="max-w-5xl mx-auto px-6 py-20">

    <!-- HEADER -->

    <div class="text-center">

        <p class="text-orange-500 font-semibold tracking-wide">
            HUBUNGI KAMI
        </p>

        <h1 class="text-4xl font-bold text-gray-900 mt-2">
            Kontak Deganasia
        </h1>

        <p class="text-gray-600 mt-4 max-w-2xl mx-auto">
            Silakan hubungi kami untuk informasi produk,
            pemesanan, atau pertanyaan lainnya.
        </p>

    </div>


    <!-- CONTACT CARDS -->

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mt-12">


        <!-- CHAT -->

        <a
            href="{{ route('chat') }}"
            class="group
                   bg-white
                   p-6
                   rounded-2xl
                   shadow-sm
                   border
                   border-gray-100
                   text-center
                   transition
                   duration-300
                   hover:-translate-y-2
                   hover:shadow-xl
                   hover:border-orange-100"
        >

            <div
                class="mx-auto
                       w-14
                       h-14
                       rounded-2xl
                       bg-orange-50
                       flex
                       items-center
                       justify-center
                       text-3xl
                       transition
                       group-hover:bg-orange-100"
            >
                💬
            </div>

            <h2 class="font-bold text-lg text-gray-900 mt-4">
                Chat
            </h2>

            <p class="text-gray-600 mt-2">
                Chat langsung dengan Deganasia.
            </p>

        </a>


        <!-- WHATSAPP -->

        <div
            class="bg-white
                   p-6
                   rounded-2xl
                   shadow-sm
                   border
                   border-gray-100
                   text-center"
        >

            <div
                class="mx-auto
                       w-14
                       h-14
                       rounded-2xl
                       bg-green-50
                       flex
                       items-center
                       justify-center
                       text-3xl"
            >
                📱
            </div>

            <h2 class="font-bold text-lg text-gray-900 mt-4">
                WhatsApp
            </h2>

            <p class="text-gray-600 mt-2">
                08xxxxxxxxxx
            </p>

            <p class="text-xs text-gray-400 mt-2">
                Hubungi kami melalui WhatsApp.
            </p>

        </div>


        <!-- INSTAGRAM -->

        <a
            href="https://instagram.com/deganasia"
            target="_blank"
            rel="noopener noreferrer"
            class="group
                   bg-white
                   p-6
                   rounded-2xl
                   shadow-sm
                   border
                   border-gray-100
                   text-center
                   transition
                   duration-300
                   hover:-translate-y-2
                   hover:shadow-xl
                   hover:border-orange-100"
        >

            <div
                class="mx-auto
                       w-14
                       h-14
                       rounded-2xl
                       bg-pink-50
                       flex
                       items-center
                       justify-center
                       text-3xl
                       transition
                       group-hover:bg-pink-100"
            >
                📸
            </div>

            <h2 class="font-bold text-lg text-gray-900 mt-4">
                Instagram
            </h2>

            <p class="text-gray-600 mt-2">
                @deganasia
            </p>

        </a>


        <!-- ADDRESS -->

        <div
            class="bg-white
                   p-6
                   rounded-2xl
                   shadow-sm
                   border
                   border-gray-100
                   text-center"
        >

            <div
                class="mx-auto
                       w-14
                       h-14
                       rounded-2xl
                       bg-red-50
                       flex
                       items-center
                       justify-center
                       text-3xl"
            >
                📍
            </div>

            <h2 class="font-bold text-lg text-gray-900 mt-4">
                Alamat
            </h2>

            <p class="text-gray-600 mt-2 leading-relaxed">
                CFD Jalan Onje
                <br>
                Alun-Alun Purbalingga
                <br>
                Stand 14
            </p>

        </div>


        <!-- EMAIL -->

        <a
            href="mailto:deganasia@gmail.com"
            class="group
                   bg-white
                   p-6
                   rounded-2xl
                   shadow-sm
                   border
                   border-gray-100
                   text-center
                   transition
                   duration-300
                   hover:-translate-y-2
                   hover:shadow-xl
                   hover:border-orange-100"
        >

            <div
                class="mx-auto
                       w-14
                       h-14
                       rounded-2xl
                       bg-blue-50
                       flex
                       items-center
                       justify-center
                       text-3xl
                       transition
                       group-hover:bg-blue-100"
            >
                ✉️
            </div>

            <h2 class="font-bold text-lg text-gray-900 mt-4">
                Email
            </h2>

            <p class="text-gray-600 mt-2 break-all">
                deganasia@gmail.com
            </p>

        </a>

    </div>

</section>

@endsection
