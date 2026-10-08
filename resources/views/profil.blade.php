@extends('layouts.app')

@section('title', 'Riwayat Pesanan')

@section('content')

<section class="min-h-[75vh] bg-amber-50 py-12 px-6">

    <div class="max-w-5xl mx-auto">

        <!-- HEADER -->

        <div class="mb-8">

            <p class="text-orange-600 font-semibold">
                Pesanan Saya
            </p>

            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mt-2">
                Riwayat Pesanan
            </h1>

            <p class="text-gray-500 mt-2">
                Pantau status pesanan Anda sampai selesai.
            </p>

        </div>


        <!-- PESANAN -->

        <div class="space-y-6">

            @forelse ($pesanan as $order)

                @php
                    $currentStatus = $order['status'];

                    $statusList = [
                        'Diterima',
                        'Diproses',
                        'Dikemas',
                        'Dikirim',
                        'Dalam Perjalanan',
                        'Selesai',
                    ];

                    $currentIndex = array_search(
                        $currentStatus,
                        $statusList,
                        true
                    );
                @endphp


                <div class="bg-white rounded-3xl shadow-lg border border-amber-100 overflow-hidden">

                    <!-- ORDER HEADER -->

                    <div class="p-6 border-b border-gray-100">

                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                            <div>

                                <p class="text-sm text-gray-500">
                                    Nomor Pesanan
                                </p>

                                <h2 class="text-lg font-bold text-gray-900">
                                    {{ $order['id'] }}
                                </h2>

                                <p class="text-sm text-gray-500 mt-1">
                                    {{ $order['tanggal'] }}
                                </p>

                            </div>


                            <div class="text-left md:text-right">

                                <p class="text-sm text-gray-500">
                                    Total Pesanan
                                </p>

                                <p class="text-xl font-bold text-orange-600">
                                    Rp {{ number_format($order['total'], 0, ',', '.') }}
                                </p>

                            </div>

                        </div>

                    </div>


                    <!-- PRODUCT -->

                    <div class="p-6 bg-gray-50">

                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                            <div>

                                <h3 class="font-bold text-gray-900">
                                    {{ $order['produk'] }}
                                </h3>

                                <p class="text-sm text-gray-500 mt-1">
                                    {{ $order['jumlah'] }} produk
                                </p>

                                @if (!empty($order['pickup_method']))

                                    <p class="text-sm text-gray-500 mt-2">
                                        Metode:
                                        <span class="font-medium text-gray-700">
                                            @switch($order['pickup_method'])

                                                @case('pickup_cfd')
                                                    Pickup CFD
                                                    @break

                                                @case('pickup_rumah')
                                                    Pickup Rumah Produksi
                                                    @break

                                                @case('delivery')
                                                    Delivery
                                                    @break

                                                @case('cod')
                                                    COD / Meet Area
                                                    @break

                                                @default
                                                    -
                                            @endswitch
                                        </span>
                                    </p>

                                @endif


                                <!-- REVIEW -->

                                @if ($currentStatus === 'Selesai')

                                    <a
                                        href="{{ route('review.form', $order['order_id']) }}"
                                        class="inline-block mt-4 px-4 py-2 rounded-xl bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold transition"
                                    >
                                        Beri Review
                                    </a>

                                @endif

                            </div>

                        </div>

                    </div>


                    <!-- STATUS -->

                    <div class="p-6">

                        @if ($currentStatus === 'Selesai')

                            <!-- PESANAN SELESAI -->

                            <details class="group">

                                <summary
                                    class="list-none
                                           cursor-pointer
                                           flex
                                           items-center
                                           justify-between
                                           bg-green-50
                                           border
                                           border-green-200
                                           rounded-2xl
                                           p-5
                                           hover:bg-green-100
                                           transition"
                                >

                                    <div class="flex items-center gap-4">

                                        <!-- ICON -->

                                        <div
                                            class="w-12
                                                   h-12
                                                   rounded-full
                                                   bg-green-500
                                                   text-white
                                                   flex
                                                   items-center
                                                   justify-center
                                                   text-xl
                                                   font-bold
                                                   flex-shrink-0"
                                        >
                                            ✓
                                        </div>


                                        <div>

                                            <h3 class="font-bold text-green-700">
                                                Pesanan Selesai
                                            </h3>

                                            <p class="text-sm text-green-600 mt-1">
                                                Pesanan telah selesai diproses
                                            </p>

                                        </div>

                                    </div>


                                    <!-- PANAH -->

                                    <span
                                        class="text-2xl
                                               text-green-600
                                               transition-transform
                                               duration-300
                                               group-open:rotate-180"
                                    >
                                        ⌄
                                    </span>

                                </summary>


                                <!-- DETAIL TIMELINE -->

                                <div class="mt-5 border-t pt-6">

                                    <h3 class="font-bold text-gray-900 mb-8">
                                        Detail Status Pesanan
                                    </h3>


                                    <div class="relative">

                                        <!-- GARIS -->

                                        <div
                                            class="absolute
                                                   left-5
                                                   top-5
                                                   bottom-5
                                                   w-1
                                                   bg-orange-200"
                                        ></div>


                                        <div class="space-y-7">

                                            @foreach ($statusList as $status)

                                                <div class="relative flex items-start gap-5">

                                                    <!-- ICON -->

                                                    <div
                                                        class="relative
                                                               z-10
                                                               w-10
                                                               h-10
                                                               rounded-full
                                                               flex
                                                               items-center
                                                               justify-center
                                                               font-bold
                                                               flex-shrink-0
                                                               bg-orange-500
                                                               text-white"
                                                    >
                                                        ✓
                                                    </div>


                                                    <!-- TEXT -->

                                                    <div class="pt-1">

                                                        <h4 class="font-semibold text-gray-900">
                                                            {{ $status }}
                                                        </h4>

                                                        @if ($status === 'Selesai')

                                                            <p class="text-sm text-green-600 mt-1 font-medium">
                                                                Status saat ini
                                                            </p>

                                                        @else

                                                            <p class="text-sm text-gray-500 mt-1">
                                                                Sudah selesai
                                                            </p>

                                                        @endif

                                                    </div>

                                                </div>

                                            @endforeach

                                        </div>

                                    </div>

                                </div>

                            </details>


                        @elseif ($currentStatus === 'Ditolak')

                            <!-- PESANAN DITOLAK -->

                            <div class="rounded-2xl bg-red-50 border border-red-200 p-5">

                                <div class="flex items-center gap-4">

                                    <div
                                        class="w-12
                                               h-12
                                               rounded-full
                                               bg-red-500
                                               text-white
                                               flex
                                               items-center
                                               justify-center
                                               text-xl
                                               flex-shrink-0"
                                    >
                                        ✕
                                    </div>


                                    <div>

                                        <h4 class="font-bold text-red-700">
                                            Pesanan Ditolak
                                        </h4>

                                        <p class="text-sm text-red-600 mt-1">
                                            Pesanan Anda tidak dapat diproses.
                                        </p>

                                        @if (!empty($order['admin_note']))

                                            <p class="text-sm text-red-600 mt-2">
                                                Alasan:
                                                {{ $order['admin_note'] }}
                                            </p>

                                        @endif

                                    </div>

                                </div>

                            </div>


                        @elseif ($currentStatus === 'Dibatalkan')

                            <!-- PESANAN DIBATALKAN -->

                            <div class="rounded-2xl bg-gray-100 border border-gray-200 p-5">

                                <div class="flex items-center gap-4">

                                    <div
                                        class="w-12
                                               h-12
                                               rounded-full
                                               bg-gray-500
                                               text-white
                                               flex
                                               items-center
                                               justify-center
                                               text-xl
                                               flex-shrink-0"
                                    >
                                        ✕
                                    </div>


                                    <div>

                                        <h4 class="font-bold text-gray-700">
                                            Pesanan Dibatalkan
                                        </h4>

                                        <p class="text-sm text-gray-500 mt-1">
                                            Pesanan ini telah dibatalkan.
                                        </p>

                                    </div>

                                </div>

                            </div>


                        @else

                            <!-- PESANAN MASIH BERJALAN -->

                            <h3 class="font-bold text-gray-900 mb-8">
                                Status Pesanan
                            </h3>


                            <div class="relative">

                                <!-- GARIS -->

                                <div
                                    class="absolute
                                           left-5
                                           top-5
                                           bottom-5
                                           w-1
                                           bg-gray-200"
                                ></div>


                                <div class="space-y-7">

                                    @foreach ($statusList as $index => $status)

                                        @php
                                            $isDone = $currentIndex !== false
                                                && $index <= $currentIndex;

                                            $isCurrent = $currentIndex !== false
                                                && $index === $currentIndex;
                                        @endphp


                                        <div class="relative flex items-start gap-5">

                                            <!-- ICON -->

                                            <div
                                                class="relative
                                                       z-10
                                                       w-10
                                                       h-10
                                                       rounded-full
                                                       flex
                                                       items-center
                                                       justify-center
                                                       font-bold
                                                       flex-shrink-0
                                                       {{ $isDone
                                                           ? 'bg-orange-500 text-white'
                                                           : 'bg-gray-200 text-gray-400' }}"
                                            >

                                                @if ($isDone)

                                                    ✓

                                                @else

                                                    {{ $index + 1 }}

                                                @endif

                                            </div>


                                            <!-- TEXT -->

                                            <div class="pt-1">

                                                <h4
                                                    class="font-semibold
                                                           {{ $isDone
                                                               ? 'text-gray-900'
                                                               : 'text-gray-400' }}"
                                                >
                                                    {{ $status }}
                                                </h4>


                                                @if ($isCurrent)

                                                    <p
                                                        class="text-sm
                                                               text-orange-600
                                                               mt-1
                                                               font-medium"
                                                    >
                                                        Status saat ini
                                                    </p>

                                                @elseif ($isDone)

                                                    <p class="text-sm text-gray-500 mt-1">
                                                        Sudah selesai
                                                    </p>

                                                @endif

                                            </div>

                                        </div>

                                    @endforeach

                                </div>

                            </div>

                        @endif

                    </div>

                </div>


            @empty

                <!-- EMPTY -->

                <div class="bg-white rounded-3xl shadow-lg p-10 text-center">

                    <div class="text-5xl mb-4">
                        🛒
                    </div>

                    <h2 class="text-xl font-bold text-gray-900">
                        Belum Ada Pesanan
                    </h2>

                    <p class="text-gray-500 mt-2">
                        Anda belum memiliki riwayat pesanan.
                    </p>

                    <a
                        href="{{ route('produk') }}"
                        class="inline-block
                               mt-6
                               px-6
                               py-3
                               rounded-xl
                               bg-orange-500
                               hover:bg-orange-600
                               text-white
                               font-semibold
                               transition"
                    >
                        Lihat Menu
                    </a>

                </div>

            @endforelse

        </div>


        <!-- LOGOUT -->

        <div class="mt-8">

            <form
                method="POST"
                action="{{ route('logout') }}"
            >

                @csrf

                <button
                    type="submit"
                    class="w-full
                           md:w-auto
                           inline-flex
                           items-center
                           justify-center
                           gap-2
                           px-6
                           py-3
                           rounded-xl
                           bg-red-500
                           hover:bg-red-600
                           text-white
                           font-semibold
                           transition"
                >
                    Logout
                </button>

            </form>

        </div>

    </div>

</section>

@endsection
