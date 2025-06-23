@extends('toko.template')

@section('title', ' | Beranda Toko')

@section('content')
<div class="inline-flex items-center gap-4">
    @if($action == 'store.tambah_harga_produk')
    <a href="{{ route('store.produk') }}" class="ring-0 outline-0 text-gray-400 hover:text-indigo-600">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 mb-2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
        </svg>
    </a>
    <h1 class="title leading-relaxed mb-2">Tambah Harga Produk</h1>
    @else
    <a href="{{ route('store.tambah.harga.produk', ['productID' => $produk['id']]) }}" class="ring-0 outline-0 text-gray-400 hover:text-indigo-600">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 mb-2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
        </svg>
    </a>
    <h1 class="title leading-relaxed mb-2">Ubah Harga Produk</h1>
    @endif
</div>

<section class="w-full grid grid-cols-3 gap-4">
    <form action="{{ route($action, $parameters) }}" enctype="multipart/form-data" method="post" class="grid grid-cols-1 rounded-lg w-full px-4 py-2.5 bg-gray-800 gap-y-2 gap-x-4">
        @csrf
        @if($productPrice != null)
        <h3 class="text-center text-sm text-white font-semibold">Harga Produk dari : {{ \Carbon\Carbon::parse($productPrice['created_at'])->format('d-m-y H:i') }}</h3>
        @endif
        <div class="col-span-full">
            <label for="price" class="form-label">Harga Produk</label>
            <div class="mt-2">
                <input type="number" name="price" id="price" class="form-input" placeholder="harga produk anda"
                    value="{{ old('price')??$productPrice != null?$productPrice['price']:'' }}" />
            </div>
            @error('price')
            <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-span-full">
            <label for="discount_percent" class="form-label">Diskon (Dalam %)</label>
            <div class="mt-2">
                <input type="number" name="discount_percent" id="discount_percent" class="form-input" placeholder="Diskon dalam % (boleh kosong)" value="{{ old('discount_percent')??$productPrice != null?$productPrice['discount_percent']:'' }}" />
            </div>
            @error('discount_percent')
            <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-span-full mb-4">
            <label for="discount_number" class="form-label">Diskon (Nominal)</label>
            <div class="mt-2">
                <input type="number" name="discount_number" id="discount_number" class="form-input" placeholder="Diskon dalam nominal (Contoh: 10000) (Boleh Kosong)" value="{{ old('discount_number')??$productPrice != null?$productPrice['discount_number']:''  }}" />
            </div>
            @error('discount_number')
            <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-span-full inline-flex justify-start">
            <button class="ring-0 outline-0 border-0 bg-indigo-600/50 text-gray-400 px-4 py-2.5 rounded-full cursor-pointer hover:bg-indigo-600 hover:text-white" @click="loading = true">Proses Harga Produk</button>
        </div>
    </form>

    <div class="rounded-lg w-full px-4 py-2.5 bg-gray-800 col-span-2">
        <h2 class="text-center font-semibold text-lg text-white leading-relaxed mb-2">Riwayat Harga</h2>
        <table class="w-full">
            <thead class="border-b border-gray-400">
                <tr>
                    <th class="text-center py-2.5 text-sm">Tanggal</th>
                    <th class="text-center py-2.5 text-sm">Harga</th>
                    <th class="text-center py-2.5 text-sm">Diskon (%)</th>
                    <th class="text-center py-2.5 text-sm">Diskon Nominal</th>
                    <th class="text-center py-2.5 text-sm">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($produk['product_prices'] as $price)
                <tr class="border-b border-gray-400 hover:bg-gray-700/50 @if($productPrice != null && $price['id'] == $productPrice['id']) bg-green-600/50 @elseif($price['id'] == $produk['latest_product_price']['id']) bg-indigo-600/50 @endif">
                    <td class="px-4 py-2.5 text-sm">{{ \Carbon\Carbon::parse($price['created_at'])->format('d-m-y H:i') }}</td>
                    <td class="px-4 py-2.5 text-sm text-end">Rp {{ number_format($price['price'], 0, ',', '.') }}</td>
                    <td class="px-4 py-2.5 text-sm text-end">{{ $price['discount_percent'] != null?$price['discount_percent']."%":"-" }}</td>
                    <td class="px-4 py-2.5 text-sm text-end">Rp {{ number_format($price['discount_number'], 0, ',', '.') }}</td>
                    <td class="relative px-4 py-2.5 text-end">
                        <div class="rounded-lg inline-flex overflow-hidden">
                            <a href="{{ route('store.ubah.harga.produk', ['productID' => $price['product_id'], 'productPriceID' => $price['id']]) }}" @click="loading = true" class="ring-0 outline-0 px-2 py-1 text-sm text-gray-400 bg-green-600/50 hover:text-white hover:bg-green-600">Edit</a>
                            <a href="{{ route('store.hapus_harga_produk', ['productPriceID' => $price['id']]) }}" @click="loading = true" class="ring-0 outline-0 px-2 py-1 text-sm text-gray-400 bg-red-600/50 hover:text-white hover:bg-red-600">Hapus</a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="inline-flex items-center justify-center gap-x-4 mt-4 w-full">
            <span class="px-4 py-1.5 rounded-lg text-sm bg-indigo-600/50">Harga yang digunakan <span class="italic">(Harga Terbaru)</span></span>
            <span class="px-4 py-1.5 rounded-lg text-sm bg-green-600/50">Harga yang sedang di edit</span>
        </div>
    </div>
</section>
@endsection
