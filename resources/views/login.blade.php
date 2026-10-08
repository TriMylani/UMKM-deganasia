@extends('layouts.app')

@section('title', 'Login')

@section('content')

<section class="min-h-[75vh] flex items-center justify-center px-6 py-16 bg-amber-50">

    <div class="w-full max-w-md">

        <div class="bg-white rounded-3xl shadow-xl p-8 border border-amber-100">

            <!-- HEADER -->

            <div class="text-center mb-8">

                <h1 class="mt-5 text-3xl font-bold text-gray-900">
                    Selamat Datang
                </h1>

                <p class="mt-2 text-gray-500">
                    Login ke akun Deganasia Anda
                </p>

            </div>


            <!-- ERROR SESSION -->

            @if (session('error'))

                <div
                    class="mb-5
                           rounded-xl
                           bg-red-50
                           border
                           border-red-200
                           text-red-700
                           px-4
                           py-3
                           text-sm"
                >
                    {{ session('error') }}
                </div>

            @endif


            <!-- SUCCESS SESSION -->

            @if (session('success'))

                <div
                    class="mb-5
                           rounded-xl
                           bg-orange-50
                           border
                           border-orange-200
                           text-orange-700
                           px-4
                           py-3
                           text-sm"
                >
                    {{ session('success') }}
                </div>

            @endif


            <!-- VALIDATION SUMMARY -->

            @if ($errors->any())

                <div
                    class="mb-5
                           rounded-xl
                           bg-red-50
                           border
                           border-red-200
                           text-red-700
                           px-4
                           py-3
                           text-sm"
                >

                    <p class="font-semibold mb-1">
                        Login belum berhasil.
                    </p>

                    <p>
                        Silakan periksa email dan password Anda.
                    </p>

                </div>

            @endif


            <!-- FORM -->

            <form
                action="{{ route('login.proses') }}"
                method="POST"
                class="space-y-5"
            >

                @csrf


                <!-- EMAIL -->

                <div>

                    <label
                        for="email"
                        class="block
                               text-sm
                               font-semibold
                               text-gray-700
                               mb-2"
                    >
                        Email
                    </label>

                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Masukkan email"
                        autocomplete="email"
                        class="w-full
                               rounded-xl
                               border
                               border-gray-300
                               px-4
                               py-3
                               focus:outline-none
                               focus:ring-2
                               focus:ring-orange-400
                               focus:border-orange-400"
                        required
                    >

                    @error('email')

                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                <!-- PASSWORD -->

                <div>

                    <label
                        for="password"
                        class="block
                               text-sm
                               font-semibold
                               text-gray-700
                               mb-2"
                    >
                        Password
                    </label>

                    <input
                        id="password"
                        type="password"
                        name="password"
                        placeholder="Masukkan password"
                        autocomplete="current-password"
                        class="w-full
                               rounded-xl
                               border
                               border-gray-300
                               px-4
                               py-3
                               focus:outline-none
                               focus:ring-2
                               focus:ring-orange-400
                               focus:border-orange-400"
                        required
                    >

                    @error('password')

                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                <!-- SUBMIT -->

                <button
                    type="submit"
                    class="w-full
                           bg-orange-500
                           hover:bg-orange-600
                           text-white
                           font-semibold
                           py-3
                           rounded-xl
                           transition
                           shadow-lg
                           shadow-orange-200"
                >
                    Login
                </button>

            </form>


            <!-- DIVIDER -->

            <div class="relative my-7">

                <div class="absolute inset-0 flex items-center">

                    <div class="w-full border-t border-gray-200"></div>

                </div>

                <div class="relative flex justify-center">

                    <span class="bg-white px-4 text-sm text-gray-400">
                        atau
                    </span>

                </div>

            </div>


            <!-- REGISTER -->

            <p class="text-center text-sm text-gray-600">

                Belum punya akun?

                <a
                    href="{{ route('register') }}"
                    class="font-semibold
                           text-orange-600
                           hover:text-orange-700"
                >
                    Register
                </a>

            </p>

        </div>

    </div>

</section>

@endsection
