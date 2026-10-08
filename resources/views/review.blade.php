@extends('layouts.app')

@section('title', 'Beri Review')

@section('content')

<section class="min-h-[75vh] bg-amber-50 py-12 px-6">

    <div class="max-w-2xl mx-auto">

        <!-- HEADER -->

        <div class="mb-8">

            <a
                href="{{ route('profil') }}"
                class="text-orange-600 hover:text-orange-700 font-medium"
            >
                ← Kembali ke Pesanan
            </a>

            <h1 class="text-3xl font-bold text-gray-900 mt-5">
                Beri Review
            </h1>

            <p class="text-gray-500 mt-2">
                Bagikan pengalaman Anda setelah membeli produk kami.
            </p>

        </div>


        <!-- REVIEW CARD -->

        <div class="bg-white rounded-3xl shadow-lg border border-amber-100 p-8">

            <!-- INFORMASI PESANAN -->

            <div class="bg-orange-50 rounded-2xl p-5 mb-8">

                <p class="text-sm text-gray-500">
                    Pesanan
                </p>

                <h2 class="text-xl font-bold text-gray-900 mt-1">
                    {{ $order['order_number'] }}
                </h2>

                <p class="text-sm text-gray-500 mt-2">
                    {{ $order['tanggal'] }}
                </p>

            </div>


            @if ($items->isEmpty())

                <div class="text-center py-8">

                    <p class="text-gray-500">
                        Tidak ada produk yang dapat direview.
                    </p>

                    <a
                        href="{{ route('profil') }}"
                        class="inline-block mt-4 text-orange-600 font-semibold"
                    >
                        Kembali ke Pesanan
                    </a>

                </div>

            @else

                @foreach ($items as $item)

                    <div
                        class="border border-gray-200 rounded-2xl p-5 mb-6"
                    >

                        <!-- PRODUK -->

                        <div class="flex items-center justify-between gap-4 mb-5">

                            <div>

                                <h3 class="font-bold text-gray-900">
                                    {{ $item['product_name'] }}
                                </h3>

                                <p class="text-sm text-gray-500 mt-1">
                                    Jumlah: {{ $item['quantity'] }}
                                </p>

                            </div>

                            @if ($item['already_reviewed'])

                                <span
                                    class="text-xs
                                           font-semibold
                                           bg-green-100
                                           text-green-700
                                           px-3
                                           py-1.5
                                           rounded-full"
                                >
                                    Sudah Direview
                                </span>

                            @endif

                        </div>


                        @if ($item['already_reviewed'])

                            <div
                                class="bg-green-50
                                       border
                                       border-green-100
                                       rounded-xl
                                       p-4"
                            >

                                <p class="text-sm text-green-700">
                                    Anda sudah memberikan review
                                    untuk produk ini.
                                </p>

                            </div>

                        @else

                            <!-- FORM REVIEW -->

                            <form
                                action="{{ route('review.simpan', $order['id']) }}"
                                method="POST"
                            >

                                @csrf

                                <input
                                    type="hidden"
                                    name="product_id"
                                    value="{{ $item['product_id'] }}"
                                >


                                <!-- RATING -->

                                <div class="mb-6">

                                    <label
                                        class="block
                                               font-semibold
                                               text-gray-800
                                               mb-3"
                                    >
                                        Rating Produk
                                    </label>

                                    <div class="flex gap-2">

                                        @for ($i = 1; $i <= 5; $i++)

                                            <label class="cursor-pointer">

                                                <input
                                                    type="radio"
                                                    name="rating"
                                                    value="{{ $i }}"
                                                    class="hidden peer"
                                                    required
                                                >

                                                <span
                                                    class="text-4xl
                                                           text-gray-300
                                                           peer-checked:text-yellow-400
                                                           transition"
                                                >
                                                    ★
                                                </span>

                                            </label>

                                        @endfor

                                    </div>

                                    @error('rating')
                                        <p class="text-red-500 text-sm mt-2">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                </div>


                                <!-- KOMENTAR -->

                                <div class="mb-6">

                                    <label
                                        for="komentar-{{ $item['product_id'] }}"
                                        class="block
                                               font-semibold
                                               text-gray-800
                                               mb-3"
                                    >
                                        Review Anda
                                    </label>

                                    <textarea
                                        id="komentar-{{ $item['product_id'] }}"
                                        name="komentar"
                                        rows="4"
                                        placeholder="Ceritakan pengalaman Anda..."
                                        class="w-full
                                               rounded-2xl
                                               border
                                               border-gray-300
                                               px-4
                                               py-3
                                               focus:outline-none
                                               focus:ring-2
                                               focus:ring-orange-400
                                               focus:border-orange-400"
                                        required
                                    >{{ old('komentar') }}</textarea>

                                    @error('komentar')
                                        <p class="text-red-500 text-sm mt-2">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                </div>


                                <!-- BUTTON -->

                                <button
                                    type="submit"
                                    class="w-full
                                           bg-orange-500
                                           hover:bg-orange-600
                                           text-white
                                           font-semibold
                                           py-3.5
                                           rounded-xl
                                           transition
                                           shadow-lg
                                           shadow-orange-200"
                                >
                                    Kirim Review
                                </button>

                            </form>

                        @endif

                    </div>

                @endforeach

            @endif

        </div>

    </div>

</section>

@endsection

