@extends('layouts.app')

@section('title', 'Chat')

@section('content')

<section class="py-16 bg-gray-50">

    <div class="max-w-3xl mx-auto px-6">

        <!-- LOGIN CHECK -->

        @if (!session('customer_logged_in'))

            <div class="bg-white rounded-2xl shadow-sm p-8 text-center">

                <div class="text-5xl">
                    💬
                </div>

                <h1 class="text-2xl font-bold text-gray-900 mt-5">
                    Chat dengan Deganasia
                </h1>

                <p class="text-gray-500 mt-2">
                    Silakan login terlebih dahulu untuk mengirim pesan
                    kepada Deganasia.
                </p>

                <div class="flex justify-center gap-3 mt-6">

                    <a
                        href="{{ route('login') }}"
                        class="bg-orange-500
                               text-white
                               px-6
                               py-3
                               rounded-xl
                               font-semibold
                               hover:bg-orange-600
                               transition"
                    >
                        Login
                    </a>

                    <a
                        href="{{ route('register') }}"
                        class="border
                               border-orange-500
                               text-orange-600
                               px-6
                               py-3
                               rounded-xl
                               font-semibold
                               hover:bg-orange-50
                               transition"
                    >
                        Register
                    </a>

                </div>

            </div>

        @else

            <div
                class="bg-white
                       rounded-2xl
                       shadow-sm
                       overflow-hidden"
            >

                <!-- ================================================= -->
                <!-- HEADER -->
                <!-- ================================================= -->

                <div
                    class="bg-orange-500
                           text-white
                           px-6
                           py-5"
                >

                    <div class="flex items-center gap-4">

                        <div
                            class="w-12
                                   h-12
                                   rounded-full
                                   bg-white
                                   text-orange-500
                                   flex
                                   items-center
                                   justify-center
                                   text-xl"
                        >
                            💬
                        </div>

                        <div>

                            <h1 class="text-xl font-bold">
                                Chat Deganasia
                            </h1>

                            <p class="text-orange-100 text-sm mt-1">
                                Silakan kirim pesan kepada kami.
                            </p>

                        </div>

                    </div>

                </div>


                <!-- ================================================= -->
                <!-- VALIDATION ERROR -->
                <!-- ================================================= -->

                @if ($errors->any())

                    <div
                        class="mx-6
                               mt-5
                               bg-red-50
                               border
                               border-red-200
                               text-red-700
                               px-4
                               py-3
                               rounded-xl
                               text-sm"
                    >

                        @foreach ($errors->all() as $error)

                            <p>
                                {{ $error }}
                            </p>

                        @endforeach

                    </div>

                @endif


                <!-- ================================================= -->
                <!-- SUCCESS -->
                <!-- ================================================= -->

                @if (session('success'))

                    <div
                        class="mx-6
                               mt-5
                               bg-green-50
                               border
                               border-green-200
                               text-green-700
                               px-4
                               py-3
                               rounded-xl
                               text-sm"
                    >
                        {{ session('success') }}
                    </div>

                @endif


                <!-- ================================================= -->
                <!-- MESSAGES -->
                <!-- ================================================= -->

                <div
                    class="p-6
                           min-h-[400px]
                           max-h-[500px]
                           overflow-y-auto
                           space-y-4
                           bg-gray-50"
                >

                    @forelse ($messages as $message)

                        <div
                            class="flex
                                   {{ $message['sender'] === 'customer'
                                       ? 'justify-end'
                                       : 'justify-start' }}"
                        >

                            <div
                                class="max-w-[80%]
                                       rounded-2xl
                                       px-4
                                       py-3
                                       shadow-sm
                                       {{ $message['sender'] === 'customer'
                                           ? 'bg-orange-500 text-white rounded-br-md'
                                           : 'bg-white text-gray-800 border border-gray-100 rounded-bl-md' }}"
                            >

                                <p class="leading-relaxed break-words">
                                    {{ $message['message'] }}
                                </p>

                                <div
                                    class="text-xs
                                           mt-2
                                           opacity-70
                                           {{ $message['sender'] === 'customer'
                                               ? 'text-orange-100'
                                               : 'text-gray-400' }}"
                                >
                                    {{ $message['time'] }}
                                </div>

                            </div>

                        </div>

                    @empty

                        <div
                            class="min-h-[350px]
                                   flex
                                   flex-col
                                   items-center
                                   justify-center
                                   text-center"
                        >

                            <div class="text-5xl">
                                💬
                            </div>

                            <h2 class="font-bold text-lg text-gray-700 mt-4">
                                Belum ada pesan
                            </h2>

                            <p class="text-gray-500 text-sm mt-1">
                                Kirim pesan pertama Anda kepada Deganasia.
                            </p>

                        </div>

                    @endforelse

                </div>


                <!-- ================================================= -->
                <!-- INPUT -->
                <!-- ================================================= -->

                <form
                    method="POST"
                    action="{{ route('chat.kirim') }}"
                    class="border-t
                           border-gray-100
                           bg-white
                           p-5"
                >

                    @csrf

                    <div class="flex gap-3">

                        <input
                            type="text"
                            name="message"
                            value="{{ old('message') }}"
                            required
                            maxlength="1000"
                            autocomplete="off"
                            placeholder="Tulis pesan..."
                            class="flex-1
                                   border
                                   border-gray-300
                                   rounded-xl
                                   px-4
                                   py-3
                                   focus:outline-none
                                   focus:ring-2
                                   focus:ring-orange-400
                                   focus:border-orange-400"
                        >

                        <button
                            type="submit"
                            class="bg-orange-500
                                   text-white
                                   px-6
                                   py-3
                                   rounded-xl
                                   font-semibold
                                   hover:bg-orange-600
                                   transition
                                   shadow-sm
                                   hover:shadow-md"
                        >
                            Kirim
                        </button>

                    </div>

                    <p class="text-xs text-gray-400 mt-2">
                        Maksimal 1000 karakter.
                    </p>

                </form>

            </div>

        @endif

    </div>

</section>

@endsection
