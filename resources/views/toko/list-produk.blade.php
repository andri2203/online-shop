@extends('toko.template')

@section('title', ' | Beranda Toko')

@section('content')
<h1 class="title mb-2">Data Produk</h1>

<section class="w-full px-4 py-2.5 rounded-lg bg-gray-800">
    <table class="w-full">
        <thead class="border-b border-gray-400">
            <tr>
                <th class="text-center py-2.5">#</th>
                <th class="text-center py-2.5">Nama Produk</th>
                <th class="text-center py-2.5">Tipe Produk</th>
                <th class="text-center py-2.5">Harga Produk</th>
                <th class="text-center py-2.5">Jumlah Produk</th>
                <th class="text-center py-2.5">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $index => $produk)
            <tr class="border-b border-gray-400  hover:bg-gray-700/50">
                <th class="px-4 py-2.5">{{ $index + 1 }}</th>
                <td class="px-4 py-2.5">{{ $produk['name'] }}</td>
                <td class="px-4 py-2.5 text-center">{{ $produk['type'] }}</td>
                <td class="px-4 py-2.5 text-end">Rp {{ number_format($produk['latest_product_price']['price'], 0, ',', '.') }}</td>
                <td class="px-4 py-2.5 text-center">{{ $produk['stocks'] }}</td>
                <td class="relative px-4 py-2.5 group">
                    <button class="ring-0 outline-0 text-gray-400 hover:text-indigo-600 cursor-pointer group-focus-within:text-indigo-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                            <path fill-rule="evenodd" d="M11.828 2.25c-.916 0-1.699.663-1.85 1.567l-.091.549a.798.798 0 0 1-.517.608 7.45 7.45 0 0 0-.478.198.798.798 0 0 1-.796-.064l-.453-.324a1.875 1.875 0 0 0-2.416.2l-.243.243a1.875 1.875 0 0 0-.2 2.416l.324.453a.798.798 0 0 1 .064.796 7.448 7.448 0 0 0-.198.478.798.798 0 0 1-.608.517l-.55.092a1.875 1.875 0 0 0-1.566 1.849v.344c0 .916.663 1.699 1.567 1.85l.549.091c.281.047.508.25.608.517.06.162.127.321.198.478a.798.798 0 0 1-.064.796l-.324.453a1.875 1.875 0 0 0 .2 2.416l.243.243c.648.648 1.67.733 2.416.2l.453-.324a.798.798 0 0 1 .796-.064c.157.071.316.137.478.198.267.1.47.327.517.608l.092.55c.15.903.932 1.566 1.849 1.566h.344c.916 0 1.699-.663 1.85-1.567l.091-.549a.798.798 0 0 1 .517-.608 7.52 7.52 0 0 0 .478-.198.798.798 0 0 1 .796.064l.453.324a1.875 1.875 0 0 0 2.416-.2l.243-.243c.648-.648.733-1.67.2-2.416l-.324-.453a.798.798 0 0 1-.064-.796c.071-.157.137-.316.198-.478.1-.267.327-.47.608-.517l.55-.091a1.875 1.875 0 0 0 1.566-1.85v-.344c0-.916-.663-1.699-1.567-1.85l-.549-.091a.798.798 0 0 1-.608-.517 7.507 7.507 0 0 0-.198-.478.798.798 0 0 1 .064-.796l.324-.453a1.875 1.875 0 0 0-.2-2.416l-.243-.243a1.875 1.875 0 0 0-2.416-.2l-.453.324a.798.798 0 0 1-.796.064 7.462 7.462 0 0 0-.478-.198.798.798 0 0 1-.517-.608l-.091-.55a1.875 1.875 0 0 0-1.85-1.566h-.344ZM12 15.75a3.75 3.75 0 1 0 0-7.5 3.75 3.75 0 0 0 0 7.5Z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <ul class="absolute hidden flex-col bottom-full right-0 min-w-40 rounded-lg bg-gray-800 border border-gray-400 group-focus-within:flex z-50">
                        <li><a href="{{ route('store.tambah.harga.produk', ['productID'=>$produk['id']]) }}" class="inline-flex items-center p-2.5 text-xs w-full hover:text-indigo-600 cursor-pointer">Ubah Harga</a></li>
                        <li><a href="{{ route('store.edit.produk', ['productID'=>$produk['id']]) }}" class="inline-flex items-center p-2.5 text-xs w-full hover:text-indigo-600 cursor-pointer">Ubah Data Produk</a></li>
                    </ul>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</section>
@endsection
