@extends('layouts.app')

@section('title', 'Menu Produk')

@section('content')

<section class="py-16 bg-amber-50 min-h-[75vh]">

    <div class="max-w-7xl mx-auto px-6">

        <!-- HEADER -->

        <div class="text-center mb-10">

            <p class="text-orange-600 font-semibold">
                MENU DEGANASIA
            </p>

            <h1 class="text-4xl font-bold text-gray-900 mt-2">
                Pilih Produk Favoritmu
            </h1>

            <p class="text-gray-500 mt-3">
                Temukan berbagai produk Deganasia yang tersedia.
            </p>

        </div>


        <!-- FILTER -->

        <form
            method="GET"
            action="{{ route('produk') }}"
            class="bg-white rounded-2xl shadow-sm p-5 mb-8"
        >

            <div class="grid md:grid-cols-3 gap-4">

                <!-- SEARCH -->

                <div class="md:col-span-2">

                    <label
                        for="search"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        Cari Produk
                    </label>

                    <input
                        id="search"
                        type="text"
                        name="search"
                        value="{{ request('search', '') }}"
                        placeholder="Cari berdasarkan nama produk..."
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-orange-400 focus:border-orange-400 focus:outline-none"
                    >

                </div>


                <!-- KATEGORI -->

                <div>

                    <label
                        for="kategori"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        Kategori
                    </label>

                    <select
                        id="kategori"
                        name="kategori"
                        onchange="this.form.submit()"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-orange-400 focus:border-orange-400 focus:outline-none"
                    >

                        <option
                            value=""
                            {{ request('kategori', '') === '' ? 'selected' : '' }}
                        >
                            Semua Kategori
                        </option>

                        @foreach ($categories as $category)

                            <option
                                value="{{ $category->name }}"
                                {{ request('kategori') === $category->name ? 'selected' : '' }}
                            >
                                {{ $category->name }}
                            </option>

                        @endforeach

                    </select>

                </div>

            </div>


            <!-- STATUS FILTER -->

            <div class="flex flex-wrap gap-3 mt-5">

                <button
                    type="submit"
                    name="status"
                    value="semua"
                    class="px-4 py-2 rounded-lg transition
                        {{ request('status', 'semua') === 'semua'
                            ? 'bg-orange-500 text-white'
                            : 'bg-gray-100 text-gray-700 hover:bg-orange-100' }}"
                >
                    Semua
                </button>

                <button
                    type="submit"
                    name="status"
                    value="tersedia"
                    class="px-4 py-2 rounded-lg transition
                        {{ request('status') === 'tersedia'
                            ? 'bg-orange-500 text-white'
                            : 'bg-gray-100 text-gray-700 hover:bg-orange-100' }}"
                >
                    Tersedia
                </button>

                <button
                    type="submit"
                    name="status"
                    value="tidak_tersedia"
                    class="px-4 py-2 rounded-lg transition
                        {{ request('status') === 'tidak_tersedia'
                            ? 'bg-orange-500 text-white'
                            : 'bg-gray-100 text-gray-700 hover:bg-orange-100' }}"
                >
                    Tidak Tersedia
                </button>

                <a
                    href="{{ route('produk') }}"
                    class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-orange-100 transition"
                >
                    Reset Filter
                </a>

            </div>

        </form>


        <!-- HASIL -->

        @if ($products->isEmpty())

            <div class="bg-white rounded-2xl p-12 text-center shadow-sm border border-gray-100">

                <div class="text-6xl">
                    🔍
                </div>

                <h2 class="text-xl font-bold text-gray-900 mt-4">
                    Produk tidak ditemukan
                </h2>

                <p class="text-gray-500 mt-2">
                    Silakan ubah pencarian atau filter kategori.
                </p>

                <a
                    href="{{ route('produk') }}"
                    class="inline-block mt-6 px-5 py-2.5 rounded-xl bg-orange-500 hover:bg-orange-600 text-white font-semibold transition"
                >
                    Reset Filter
                </a>

            </div>

        @else

            <!-- PRODUCT GRID -->

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">

                @foreach ($products as $product)

                    @php
                        $availableVariants = $product->variants
                            ->filter(fn ($variant) =>
                                $variant->is_available &&
                                $variant->stock > 0
                            );

                        $hasAvailableVariant = $availableVariants->isNotEmpty();

                        $prices = $product->variants
                            ->filter(fn ($variant) => $variant->is_available)
                            ->pluck('price');

                        $minPrice = $prices->min();
                        $maxPrice = $prices->max();

                        $totalStock = $product->variants->sum('stock');
                    @endphp

                    <div
                        class="group bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:border-orange-300 hover:-translate-y-2 hover:shadow-xl transition-all duration-300"
                    >

                        <!-- IMAGE -->

                        <div
                            class="h-52 bg-orange-50 overflow-hidden group-hover:bg-orange-100 transition duration-500"
                        >

                            @if ($product->image)

                                <img
                                    src="{{ asset('images/' . $product->image) }}"
                                    alt="{{ $product->name }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition duration-500"
                                >

                            @else

                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    Tidak ada gambar
                                </div>

                            @endif

                        </div>


                        <!-- CONTENT -->

                        <div class="p-6">

                            <div class="flex justify-between items-start gap-3">

                                <div>

                                    <span class="text-sm text-orange-600">
                                        {{ optional($product->category)->name ?? 'Tanpa Kategori' }}
                                    </span>

                                    <h2 class="text-xl font-bold text-gray-900 mt-1">
                                        {{ $product->name }}
                                    </h2>

                                </div>


                                <!-- STATUS -->

                                @if ($hasAvailableVariant)

                                    <span class="text-xs bg-green-100 text-green-700 px-3 py-1 rounded-full whitespace-nowrap">
                                        Tersedia
                                    </span>

                                @else

                                    <span class="text-xs bg-red-100 text-red-700 px-3 py-1 rounded-full whitespace-nowrap">
                                        Habis
                                    </span>

                                @endif

                            </div>


                            <!-- DESCRIPTION -->

                            <p class="text-gray-500 text-sm mt-3 line-clamp-2">
                                {{ $product->description }}
                            </p>


                            <!-- VARIANTS -->

                            <div class="mt-4">

                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                    Pilihan
                                </p>

                                <div class="flex flex-wrap gap-2 mt-2">

                                    @foreach ($product->variants as $variant)

                                        <span class="text-xs bg-gray-100 text-gray-700 px-2.5 py-1 rounded-lg">
                                            {{ $variant->name }}
                                        </span>

                                    @endforeach

                                </div>

                            </div>


                            <!-- PRICE -->

                            <div class="mt-4">

                                <p class="text-sm text-gray-500">
                                    Harga
                                </p>

                                @if ($minPrice !== null)

                                    <p class="text-xl font-bold text-orange-600 mt-1">

                                        @if ($minPrice == $maxPrice)

                                            Rp {{ number_format($minPrice, 0, ',', '.') }}

                                        @else

                                            Rp {{ number_format($minPrice, 0, ',', '.') }}
                                            –
                                            Rp {{ number_format($maxPrice, 0, ',', '.') }}

                                        @endif

                                    </p>

                                @else

                                    <p class="text-xl font-bold text-gray-400">
                                        Belum tersedia
                                    </p>

                                @endif

                                <p class="text-xs text-gray-500 mt-1">
                                    Total stok: {{ $totalStock }}
                                </p>

                            </div>


                            <!-- ACTION -->

                            <div class="flex gap-3 mt-5">

                                <a
                                    href="{{ route('produk.detail', $product->id) }}"
                                    class="flex-1 text-center border border-orange-500 text-orange-600 py-2 rounded-lg hover:bg-orange-500 hover:text-white transition"
                                >
                                    Detail
                                </a>


                                @if ($hasAvailableVariant)

                                    <a
                                        href="{{ route('produk.detail', $product->id) }}"
                                        class="flex-1 text-center bg-orange-500 text-white py-2 rounded-lg hover:bg-orange-600 transition"
                                    >
                                        + Keranjang
                                    </a>

                                @else

                                    <button
                                        type="button"
                                        disabled
                                        class="flex-1 bg-gray-200 text-gray-400 py-2 rounded-lg cursor-not-allowed"
                                    >
                                        Habis
                                    </button>

                                @endif

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        @endif

    </div>

</section>

@endsection