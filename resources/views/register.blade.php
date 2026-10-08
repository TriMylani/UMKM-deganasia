@extends('layouts.app')

@section('title', 'Register')

@section('content')

<section class="min-h-[75vh] flex items-center justify-center px-6 py-16 bg-amber-50">

    <div class="w-full max-w-md">

        <div class="bg-white rounded-3xl shadow-xl p-8 border border-amber-100">

            <!-- HEADER -->

            <div class="text-center mb-8">

                <div
                    class="mx-auto
                           w-16
                           h-16
                           rounded-2xl
                           bg-orange-500
                           text-white
                           flex
                           items-center
                           justify-center
                           text-2xl
                           font-bold
                           shadow-lg"
                >
                    D
                </div>

                <h1 class="mt-5 text-3xl font-bold text-gray-900">
                    Buat Akun
                </h1>

                <p class="mt-2 text-gray-500">
                    Daftar untuk mulai berbelanja di Deganasia
                </p>

            </div>


            <!-- SUCCESS -->

            @if (session('success'))

                <div
                    class="mb-5
                           rounded-xl
                           bg-green-50
                           border
                           border-green-200
                           text-green-700
                           px-4
                           py-3
                           text-sm"
                >
                    {{ session('success') }}
                </div>

            @endif


            <!-- ERROR -->

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
                        Pendaftaran belum berhasil.
                    </p>

                    <p>
                        Silakan periksa kembali data yang Anda masukkan.
                    </p>

                </div>

            @endif


            <!-- FORM -->

            <form
                action="{{ route('register.proses') }}"
                method="POST"
                class="space-y-5"
            >

                @csrf


                <!-- NAMA -->

                <div>

                    <label
                        for="nama"
                        class="block
                               text-sm
                               font-semibold
                               text-gray-700
                               mb-2"
                    >
                        Nama Lengkap
                    </label>

                    <input
                        id="nama"
                        type="text"
                        name="nama"
                        value="{{ old('nama') }}"
                        placeholder="Masukkan nama lengkap"
                        autocomplete="name"
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

                    @error('nama')

                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


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
                        placeholder="Minimal 8 karakter"
                        autocomplete="new-password"
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


                <!-- KONFIRMASI PASSWORD -->

                <div>

                    <label
                        for="password_confirmation"
                        class="block
                               text-sm
                               font-semibold
                               text-gray-700
                               mb-2"
                    >
                        Konfirmasi Password
                    </label>

                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        placeholder="Ulangi password"
                        autocomplete="new-password"
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

                    @error('password_confirmation')

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
                    Register
                </button>

            </form>


            <!-- LOGIN -->

            <p class="text-center text-sm text-gray-600 mt-7">

                Sudah punya akun?

                <a
                    href="{{ route('login') }}"
                    class="font-semibold
                           text-orange-600
                           hover:text-orange-700"
                >
                    Login
                </a>

            </p>

        </div>

    </div>

</section>

@endsection
