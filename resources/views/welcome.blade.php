@extends('layout')

@section('main')
<section class="w-full sm:py-4 lg:py-6 sm:px-6 lg:px-8">
    <div class="flex flex-1 my-4 justify-center">
        <nav class="bg-gray-800 rounded-lg grid grid-cols-9 sm:w-full md:w-3/4 font-medium max-md:text-sm overflow-hidden">
            <a href="{{ route('home') }}" class="rounded-lg ring-0 outline-0 py-2 text-center @if($type == null) bg-indigo-800 text-white @else hover:bg-indigo-600 hover:text-white @endif  cursor-pointer">Semua</a>
            @foreach ($types as $ty)
            <a href="{{ route('home.type', ['type' => $ty['value']]) }}" class="rounded-lg ring-0 outline-0 py-2 text-center @if($type != null && $type == $ty['value']) bg-indigo-800 text-white @else hover:bg-indigo-600 hover:text-white @endif cursor-pointer">{{ $ty['label'] }}</a>
            @endforeach
        </nav>
    </div>
</section>
@if($products->isEmpty())
<div class="flex flex-col items-center justify-center border-2 border-dotted border-gray-400 rounded-lg sm:mx-6 lg:mx-8 px-8 py-4">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12 mb-4">
        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
    </svg>
    <h2 class="text-2xl mb-4 font-bold">Belum ada data yang ditampilkan</h2>
</div>
@else
<section class="flex flex-1 sm:mx-6 lg:mx-8 py-8 border-t border-gray-700">
    <div class="w-full grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($products->toArray() as $produk)
        <div class="relative bg-gray-800 rounded-2xl shadow-md hover:shadow-lg transition duration-300 ease-in-out overflow-hidden">
            <img
                src="/images/{{ $produk['photo'] }}"
                alt="{{ $produk['name'] }}"
                class="w-full h-48 object-cover">
            <div class="p-4">
                <span class="inline-flex items-center gap-2 rounded-lg text-xs text-white bg-indigo-800 px-3 py-1.5 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-3.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z" />
                    </svg>

                    {{ $produk['user']['nama'] }}
                </span>
                <h3 class="text-base font-semibold text-gray-400 mb-1 truncate">{{ $produk['name'] }}</h3>
                <span class="text-xs text-white font-medium bg-indigo-600 rounded-full px-3 py-0.5 uppercase">{{ $produk['type'] }}</span>
                @if($produk['latest_product_price']['discount_percent'] > 0)
                <p class="text-primary-600 font-bold text-base my-2">
                    Rp {{ number_format($produk['latest_product_price']['price'] - ($produk['latest_product_price']['price'] * $produk['latest_product_price']['discount_percent'] / 100), 0, ',', '.') }}
                    <span class="text-red-600 font-bold text-sm line-through ms-1">
                        Rp {{ number_format($produk['latest_product_price']['price'], 0, ',', '.') }}
                    </span>
                </p>
                @elseif($produk['latest_product_price']['discount_number'] > 0)
                <p class="text-primary-600 font-bold text-base my-2">
                    Rp {{ number_format($produk['latest_product_price']['price'] - $produk['latest_product_price']['discount_number'], 0, ',', '.') }}
                    <span class="text-red-600 font-bold text-sm line-through ms-1">
                        Rp {{ number_format($produk['latest_product_price']['price'], 0, ',', '.') }}
                    </span>
                </p>
                @else
                <p class="text-primary-600 font-bold text-base my-2">
                    Rp {{ number_format($produk['latest_product_price']['price'], 0, ',', '.') }}
                </p>
                @endif
                <div class="flex justify-start gap-x-2 items-center">
                    @if($user)
                    <a href="{{ route('keranjang.tambah_keranjang',['productID'=>$produk['id']]) }}" class="relative rounded-full text-green-500 p-1  hover:text-green-600 focus:ring-0  focus:ring-offset-gray-800 focus:outline-hidden cursor-pointer">
                        <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                            <path d="M2.25 2.25a.75.75 0 0 0 0 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 0 0-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 0 0 0-1.5H5.378A2.25 2.25 0 0 1 7.5 15h11.218a.75.75 0 0 0 .674-.421 60.358 60.358 0 0 0 2.96-7.228.75.75 0 0 0-.525-.965A60.864 60.864 0 0 0 5.68 4.509l-.232-.867A1.875 1.875 0 0 0 3.636 2.25H2.25ZM3.75 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0ZM16.5 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0Z" />
                        </svg>
                    </a>

                    <a href="{{ route('bayar.proses_beli_langsung', ['productID'=>$produk['id']]) }}" class="relative rounded-full text-green-500 p-1  hover:text-green-600 focus:ring-0  focus:ring-offset-gray-800 focus:outline-hidden cursor-pointer">
                        Beli
                    </a>
                    @elseif($produk['stocks'] == 0)
                    <span class="px-2 py-1 text-xs bg-red-600 text-white rounded-full">Produk Telah Habis</span>
                    @else
                    <!-- Login Button -->
                    <a href="{{ route('login') }}" class="relative ring-0 outline-0 text-sm text-indigo-600
                     font-medium rounded-lg px-2.5 py-1 border border-indigo-600 transition-colors duration-150 ease-in-out hover:text-white hover:bg-indigo-600">Masuk</a>
                    @endif
                </div>
                <div class="w-full border-t border-gray-700 mt-2 pt-2">
                    <canvas class="chartjs" data-prices="{{ json_encode($produk['product_prices']) }}"></canvas>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif
@endsection
