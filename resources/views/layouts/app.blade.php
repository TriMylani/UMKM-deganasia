<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Deganasia') - Deganasia</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>

        :root {
            --brand: #f59e0b;
            --brand-dark: #ea580c;
            --brand-light: #fff7ed;
            --brand-soft: #ffedd5;
        }

        /* =========================================================
           CHAT FLOATING ANIMATION
        ========================================================= */

        @keyframes chatPulse {

            0% {
                box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.45);
            }

            70% {
                box-shadow: 0 0 0 15px rgba(245, 158, 11, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(245, 158, 11, 0);
            }

        }

        .chat-floating {
            animation: chatPulse 2.5s infinite;
        }


        /* =========================================================
           NOTIFICATION ANIMATION
        ========================================================= */

        .notification {
            animation:
                notificationIn 0.35s ease-out,
                notificationOut 0.4s ease-in 3s forwards;
        }

        @keyframes notificationIn {

            from {
                opacity: 0;
                transform: translateY(-15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }

        }

        @keyframes notificationOut {

            from {
                opacity: 1;
            }

            to {
                opacity: 0;
            }

        }

    </style>

</head>


<body class="bg-gray-50 text-gray-800">


<div class="relative min-h-screen">


    <!-- =========================================================
         NAVBAR
    ========================================================== -->

    <nav class="sticky top-0 z-50 bg-white shadow-sm">

        <div class="max-w-7xl mx-auto px-6 py-4">

            <div class="flex items-center justify-between">


                <!-- LOGO -->

                <a
                    href="{{ route('home') }}"
                    class="text-2xl font-bold text-orange-500
                           hover:text-orange-600 transition"
                >
                    Deganasia
                </a>


                <!-- DESKTOP MENU -->

                <div class="hidden md:flex items-center gap-6">


                    <!-- BERANDA -->

                    <a
                        href="{{ route('home') }}"
                        class="font-medium transition
                            {{ request()->routeIs('home')
                                ? 'text-orange-500'
                                : 'text-gray-700 hover:text-orange-500' }}"
                    >
                        Beranda
                    </a>


                    <!-- MENU -->

                    <a
                        href="{{ route('produk') }}"
                        class="font-medium transition
                            {{ request()->routeIs('produk') || request()->routeIs('produk.detail')
                                ? 'text-orange-500'
                                : 'text-gray-700 hover:text-orange-500' }}"
                    >
                        Menu
                    </a>


                    <!-- KERANJANG -->

                    <a
                        href="{{ route('keranjang') }}"
                        class="font-medium transition
                            {{ request()->routeIs('keranjang')
                                ? 'text-orange-500'
                                : 'text-gray-700 hover:text-orange-500' }}"
                    >
                        Keranjang
                    </a>


                    <!-- TENTANG -->

                    <a
                        href="{{ route('tentang') }}"
                        class="font-medium transition
                            {{ request()->routeIs('tentang')
                                ? 'text-orange-500'
                                : 'text-gray-700 hover:text-orange-500' }}"
                    >
                        Tentang
                    </a>


                    {{-- <!-- KONTAK -->

                    <a
                        href="{{ route('kontak') }}"
                        class="font-medium transition
                            {{ request()->routeIs('kontak')
                                ? 'text-orange-500'
                                : 'text-gray-700 hover:text-orange-500' }}"
                    >
                        Kontak
                    </a> --}}


                    <!-- PROFILE / LOGIN -->

                    @if (session('customer_logged_in'))

                        <a
                            href="{{ route('profil') }}"
                            title="Profil Akun"
                            class="w-11 h-11
                                   rounded-full
                                   bg-orange-500
                                   hover:bg-orange-600
                                   text-white
                                   flex
                                   items-center
                                   justify-center
                                   font-bold
                                   text-lg
                                   shadow-md
                                   transition
                                   duration-300
                                   hover:scale-105"
                        >
                            {{ strtoupper(substr(session('customer_name', 'D'), 0, 1)) }}
                        </a>

                    @else

                        <a
                            href="{{ route('login') }}"
                            class="px-5 py-2.5
                                   rounded-xl
                                   bg-orange-500
                                   text-white
                                   font-semibold
                                   hover:bg-orange-600
                                   transition
                                   shadow-md
                                   shadow-orange-200"
                        >
                            Login
                        </a>

                    @endif

                </div>

            </div>

        </div>

    </nav>


    <!-- =========================================================
         SUCCESS NOTIFICATION
    ========================================================== -->

    @if (session('success'))

        <div
            id="notification-success"
            class="notification
                   fixed
                   top-24
                   right-6
                   z-[100]
                   max-w-sm
                   bg-orange-500
                   text-white
                   px-6
                   py-4
                   rounded-xl
                   shadow-xl"
        >
            <div class="flex items-start gap-3">

                <span class="font-bold">
                    ✓
                </span>

                <span>
                    {{ session('success') }}
                </span>

            </div>
        </div>

    @endif


    <!-- =========================================================
         ERROR NOTIFICATION
    ========================================================== -->

    @if (session('error'))

        <div
            id="notification-error"
            class="notification
                   fixed
                   top-24
                   right-6
                   z-[100]
                   max-w-sm
                   bg-red-600
                   text-white
                   px-6
                   py-4
                   rounded-xl
                   shadow-xl"
        >
            <div class="flex items-start gap-3">

                <span class="font-bold">
                    ⚠
                </span>

                <span>
                    {{ session('error') }}
                </span>

            </div>
        </div>

    @endif


    <!-- =========================================================
         MAIN CONTENT
    ========================================================== -->

    <main>

        @yield('content')

    </main>


    <!-- =========================================================
         FLOATING CHAT
    ========================================================== -->

    @php

        $isLoggedIn = session('customer_logged_in');

        $chatUrl = $isLoggedIn
            ? route('chat')
            : route('login');

    @endphp


    <a
        href="{{ $chatUrl }}"
        title="{{ $isLoggedIn
            ? 'Chat dengan Customer Service'
            : 'Login untuk menggunakan Chat' }}"
        aria-label="{{ $isLoggedIn
            ? 'Chat dengan Customer Service'
            : 'Login untuk menggunakan Chat' }}"
        class="chat-floating
               fixed
               bottom-6
               right-6
               z-40
               w-16
               h-16
               rounded-full
               bg-orange-500
               hover:bg-orange-600
               text-white
               flex
               items-center
               justify-center
               shadow-2xl
               transition
               duration-300
               hover:scale-110"
    >

        <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="2"
            stroke="currentColor"
            class="w-8 h-8"
            aria-hidden="true"
        >

            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M8.625 9.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm4.125 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1-1.5 0Zm4.125 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM21 12c0 4.97-4.03 9-9 9a8.96 8.96 0 0 1-4.74-1.35L3 21l1.35-4.26A8.96 8.96 0 0 1 3 12c0-4.97 4.03-9 9-9s9 4.03 9 9Z"
            />

        </svg>

    </a>


    <!-- CHAT LABEL -->

    <div
        class="fixed
               bottom-8
               right-24
               z-30
               hidden
               md:block
               pointer-events-none
               bg-white
               px-4
               py-2
               rounded-xl
               shadow-lg
               border
               border-gray-100
               text-sm
               font-semibold
               text-gray-700"
    >
        {{ $isLoggedIn
            ? 'Chat Customer Service'
            : 'Login untuk Chat' }}
    </div>


    <!-- =========================================================
         FOOTER
    ========================================================== -->

    <footer class="mt-20 bg-orange-900 text-white">

        <div class="max-w-7xl mx-auto px-6 py-12">

            <div class="grid md:grid-cols-3 gap-10">


                <!-- ABOUT -->

                <div>

                    <h3 class="text-xl font-bold">
                        Deganasia
                    </h3>

                    <p class="mt-3 text-orange-100 leading-relaxed">
                        Produk segar dan berkualitas
                        untuk menemani setiap momen Anda.
                    </p>

                </div>


                <!-- NAVIGASI -->

                <div>

                    <h3 class="font-semibold mb-3">
                        Navigasi
                    </h3>

                    <div class="space-y-2 text-orange-100">

                        <a
                            href="{{ route('home') }}"
                            class="block hover:text-white transition"
                        >
                            Beranda
                        </a>

                        <a
                            href="{{ route('produk') }}"
                            class="block hover:text-white transition"
                        >
                            Menu
                        </a>

                        <a
                            href="{{ route('keranjang') }}"
                            class="block hover:text-white transition"
                        >
                            Keranjang
                        </a>

                        <a
                            href="{{ route('tentang') }}"
                            class="block hover:text-white transition"
                        >
                            Tentang
                        </a>

                        <a
                            href="{{ route('kontak') }}"
                            class="block hover:text-white transition"
                        >
                            Kontak
                        </a>

                    </div>

                </div>


                <!-- KONTAK -->

                <div>

                    <h3 class="font-semibold mb-3">
                        Kontak
                    </h3>

                    <div class="space-y-2 text-orange-100">

                        <p>
                            CFD Jalan Onje,
                            Alun-Alun Purbalingga
                        </p>

                        <p>
                            Stand 14
                        </p>

                        <p>
                            deganasia@gmail.com
                        </p>

                    </div>

                </div>

            </div>


            <!-- COPYRIGHT -->

            <div
                class="border-t
                       border-orange-700
                       mt-10
                       pt-6
                       text-center
                       text-orange-200"
            >
                © {{ date('Y') }} Deganasia
            </div>

        </div>

    </footer>


</div>


<!-- =========================================================
     NOTIFICATION SCRIPT
========================================================== -->

<script>

    setTimeout(function () {

        const success =
            document.getElementById('notification-success');

        const error =
            document.getElementById('notification-error');

        if (success) {
            success.remove();
        }

        if (error) {
            error.remove();
        }

    }, 3500);

</script>


@yield('scripts')

</body>

</html>
