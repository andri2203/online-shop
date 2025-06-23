@extends('toko.template')

@section('title', ' | Beranda Toko')

@section('content')
<section class="grid grid-cols-3 gap-4 w-full">
    <div class="p-4 rounded-lg bg-gray-800 shadow shadow-indigo-900">
        <div class="inline-flex w-full mb-2 gap-x-4 text-white items-center justify-between">
            <h1 class="text-base leading-relaxed">Jumlah Produk</h1>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                <path d="M2.25 2.25a.75.75 0 0 0 0 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 0 0-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 0 0 0-1.5H5.378A2.25 2.25 0 0 1 7.5 15h11.218a.75.75 0 0 0 .674-.421 60.358 60.358 0 0 0 2.96-7.228.75.75 0 0 0-.525-.965A60.864 60.864 0 0 0 5.68 4.509l-.232-.867A1.875 1.875 0 0 0 3.636 2.25H2.25ZM3.75 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0ZM16.5 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0Z" />
            </svg>
        </div>
        <p class="text-xl">{{ $product_count }} Produk</p>
    </div>
    <div class="p-4 rounded-lg bg-gray-800 shadow shadow-indigo-900">
        <div class="inline-flex w-full mb-2 gap-x-4 text-white items-center justify-between">
            <h1 class="text-base leading-relaxed">Jumlah Pemesanan</h1>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                <path d="M2.25 2.25a.75.75 0 0 0 0 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 0 0-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 0 0 0-1.5H5.378A2.25 2.25 0 0 1 7.5 15h11.218a.75.75 0 0 0 .674-.421 60.358 60.358 0 0 0 2.96-7.228.75.75 0 0 0-.525-.965A60.864 60.864 0 0 0 5.68 4.509l-.232-.867A1.875 1.875 0 0 0 3.636 2.25H2.25ZM3.75 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0ZM16.5 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0Z" />
            </svg>
        </div>
        <p class="text-xl">{{ $order_count }} Pemesanan</p>
    </div>
    <div class="p-4 rounded-lg bg-gray-800 shadow shadow-indigo-900">
        <div class="inline-flex w-full mb-2 gap-x-4 text-white items-center justify-between">
            <h1 class="text-base leading-relaxed">Total Penjualan</h1>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                <path d="M4.5 3.75a3 3 0 0 0-3 3v.75h21v-.75a3 3 0 0 0-3-3h-15Z" />
                <path fill-rule="evenodd" d="M22.5 9.75h-21v7.5a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3v-7.5Zm-18 3.75a.75.75 0 0 1 .75-.75h6a.75.75 0 0 1 0 1.5h-6a.75.75 0 0 1-.75-.75Zm.75 2.25a.75.75 0 0 0 0 1.5h3a.75.75 0 0 0 0-1.5h-3Z" clip-rule="evenodd" />
            </svg>

        </div>
        <p class="text-xl flex justify-between"><span>Rp</span> {{ number_format($totalSales, 0, ',', '.') }}</p>
    </div>

    <section class="relative col-span-full px-4 py-2.5 rounded-lg bg-gray-800">
        <div class="inline-flex w-full justify-end mb-4">
            <a href="{{ route('store.pesanan') }}" @click="loading = true" class="ring-o outline-0 px-4 py-2.5 rounded-xl bg-indigo-600/50 text-white hover:bg-indigo-500">Buka Halaman Pemesanan</a>
        </div>
        <table class="w-full">
            <thead class="border-b border-gray-400">
                <tr>
                    <th class="text-center py-2.5">Nama Pemesan</th>
                    <th class="text-center py-2.5">Tanggal</th>
                    <th class="text-center py-2.5">Alamat</th>
                    <th class="text-center py-2.5">Produk Dipesan</th>
                    <th class="text-center py-2.5">Metode Bayar</th>
                    <th class="text-center py-2.5">Total Bayar</th>
                    <th class="text-center py-2.5">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $index => $order)
                <tr class="hover:bg-gray-700/50">
                    <th class="text-center px-4 py-2.5">{{ $order['user']['nama'] }}</th>
                    <td class="text-center px-4 py-2.5">{{ \Carbon\Carbon::parse($order['created_at'])->format('d-m-y H:i') }}</td>
                    <td class="text-center px-4 py-2.5">{{ $order['address'] }}</td>
                    <td class="text-center px-4 py-2.5">
                        <!-- Wrapper sebagai group -->
                        <div class="relative group">
                            <!-- Tombol trigger -->
                            <label for="showModalDetailProducts" class="ring-0 outline-0 px-4 py-1.5 rounded-lg text-sm bg-indigo-700/50 hover:bg-indigo-500 text-white cursor-pointer">
                                Lihat Produk
                            </label>

                            <!-- Input hidden sebagai trigger fokus -->
                            <input type="checkbox" id="showModalDetailProducts" class="sr-only peer" />

                            <!-- Modal overlay dan konten -->
                            <div class="fixed -top-8 left-0 w-full min-h-screen flex justify-center items-center bg-gray-800/50 z-[9999] opacity-0 pointer-events-none peer-checked:opacity-100 peer-checked:pointer-events-auto transition">
                                <div class="relative">
                                    <!-- Tombol close -->
                                    <label for="showModalDetailProducts" class="absolute -top-5 -right-5 ring-0 outline-0 rounded-full p-2.5 text-white bg-gray-900 hover:bg-indigo-800 cursor-pointer z-[9999]">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="text-white size-6">
                                            <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                        </svg>
                                    </label>
                                    <ul class="flex flex-col gap-y-2.5 py-2.5 bg-gray-800 border border-gray-900 rounded-lg">
                                        <li class="text-center mx-4 py-2.5 text-white font-medium border-b border-gray-600">Detail Orderan</li>
                                        @foreach($order['order_details'] as $detail)
                                        <li class="px-4">{{ $detail['product']['name'] }} x {{ $detail['qty'] }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="text-center px-4 py-2.5 group">
                        @if($order['payment_method']['name'] == 'COD' || $order['payment_photo'] == null)
                        {{ $order['payment_method']['name'] }}
                        @else
                        <!-- Wrapper sebagai group -->
                        <div class="relative group">

                            <!-- Tombol trigger -->
                            <label for="showModal" class="ring-0 outline-0 px-4 py-1.5 rounded-lg text-sm bg-indigo-700/50 hover:bg-indigo-500 text-white cursor-pointer">
                                {{ "Transfer ke " . $order['payment_method']['name'] }}
                            </label>

                            <!-- Input hidden sebagai trigger fokus -->
                            <input type="checkbox" id="showModal" class="sr-only peer" />

                            <!-- Modal overlay dan konten -->
                            <div class="fixed -top-8 left-0 w-full min-h-screen flex justify-center items-center bg-gray-800/50 z-[9999] opacity-0 pointer-events-none peer-checked:opacity-100 peer-checked:pointer-events-auto transition">

                                <div class="relative">

                                    <!-- Tombol close -->
                                    <label for="showModal" class="absolute -top-3.5 -right-3.5 ring-0 outline-0 rounded-full p-2.5 text-white bg-gray-900 hover:bg-indigo-800 cursor-pointer z-[9999]">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="text-white size-6">
                                            <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                        </svg>
                                    </label>
                                    <!-- Gambar -->
                                    <img src="/images/{{ $order['payment_photo'] }}" class="rounded-t-2xl h-96" alt="Orderan dari {{ $order['user']['nama'] }}">
                                    <div class="bg-indigo-600 rounded-b-2xl w-full py-2.5">
                                        <h1 class="text-center text-white text-xs px-4 mb-2">
                                            Bukti Transfer dari {{ $order['user']['nama'] }}
                                        </h1>
                                        <h1 class="text-center text-white text-xs px-4">
                                            Total Pembayaran Rp {{ number_format($order['payment_total'], 0, ',', '.') }}
                                        </h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </td>
                    <td class="text-end px-4 py-2.5">Rp {{ number_format($order['payment_total'], 0, ',', '.') }}</td>
                    <td class="text-center px-4 py-2.5 capitalize">
                        @if($order['payment_photo'] == null)
                        Belum Pembayaran
                        @elseif($order['status'] == 'menunggu')
                        <a href="{{ route('store.proses_pesanan', ['orderID'=>$order['id'], 'action'=>'diproses']) }}" @click="loading = true" class="ring-o outline-0 px-3 py-1 text-sm rounded-xl bg-indigo-600/50 text-white hover:bg-indigo-500">Proses Pesanan</a>
                        @elseif($order['status'] == 'diproses')
                        <a href="{{ route('store.proses_pesanan', ['orderID'=>$order['id'], 'action'=>'dikirim']) }}" @click="loading = true" class="ring-o outline-0 px-3 py-1 text-sm rounded-xl bg-indigo-600/50 text-white hover:bg-indigo-500">Kirim Pesanan</a>
                        @else
                        <span class="px-2 py-1.5 text-sm bg-green-600 text-white rounded-xl">Pesanan Selesai</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>
</section>
@endsection
