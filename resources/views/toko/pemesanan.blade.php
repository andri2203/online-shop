@extends('toko.template')

@section('title', ' | Beranda Toko')

@section('content')
<h1 class="title mb-2">Pemesanan</h1>


<section class="w-full px-4 py-2.5 rounded-lg bg-gray-800">
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
                        <label for="showModalDetailProducts_{{ $index }}" class="ring-0 outline-0 block w-fit px-4 py-2 text-sm rounded-lg bg-indigo-600 text-white hover:bg-indigo-500 transition cursor-pointer">
                            Lihat Produk
                        </label>

                        <!-- Input hidden sebagai trigger fokus -->
                        <input type="checkbox" id="showModalDetailProducts_{{ $index }}" class="sr-only peer" />

                        <!-- Modal overlay dan konten -->
                        <div class="fixed -top-8 left-0 w-full min-h-screen flex justify-center items-center bg-gray-800/50 z-[9999] opacity-0 pointer-events-none peer-checked:opacity-100 peer-checked:pointer-events-auto transition">
                            <div class="relative">
                                <!-- Tombol Print -->
                                <button id="detail_print_{{ $index }}" class="absolute -top-5 -left-5 ring-0 outline-0 rounded-full p-2.5 text-white bg-indigo-700 hover:bg-indigo-800 cursor-pointer z-[9999]"
                                    @click="printElement('detail_order_{{ $index }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="text-white size-6">
                                        <path fill-rule="evenodd" d="M7.875 1.5C6.839 1.5 6 2.34 6 3.375v2.99c-.426.053-.851.11-1.274.174-1.454.218-2.476 1.483-2.476 2.917v6.294a3 3 0 0 0 3 3h.27l-.155 1.705A1.875 1.875 0 0 0 7.232 22.5h9.536a1.875 1.875 0 0 0 1.867-2.045l-.155-1.705h.27a3 3 0 0 0 3-3V9.456c0-1.434-1.022-2.7-2.476-2.917A48.716 48.716 0 0 0 18 6.366V3.375c0-1.036-.84-1.875-1.875-1.875h-8.25ZM16.5 6.205v-2.83A.375.375 0 0 0 16.125 3h-8.25a.375.375 0 0 0-.375.375v2.83a49.353 49.353 0 0 1 9 0Zm-.217 8.265c.178.018.317.16.333.337l.526 5.784a.375.375 0 0 1-.374.409H7.232a.375.375 0 0 1-.374-.409l.526-5.784a.373.373 0 0 1 .333-.337 41.741 41.741 0 0 1 8.566 0Zm.967-3.97a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H18a.75.75 0 0 1-.75-.75V10.5ZM15 9.75a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75V10.5a.75.75 0 0 0-.75-.75H15Z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <!-- Tombol close -->
                                <label for="showModalDetailProducts_{{ $index }}" class="absolute -top-5 -right-5 ring-0 outline-0 rounded-full p-2.5 text-white bg-gray-900 hover:bg-indigo-800 cursor-pointer z-[9999]">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="text-white size-6">
                                        <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                    </svg>
                                </label>
                                <ul id="detail_order_{{ $index }}" class="flex flex-col gap-y-2.5 py-2.5 w-fit bg-gray-800 border border-gray-900 rounded-lg">
                                    <li class="flex flex-1 shrink-0 h-14 max-h-14 justify-center items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 md:size-6 text-indigo-600 me-2">
                                            <path fill-rule="evenodd" d="M7.5 6v.75H5.513c-.96 0-1.764.724-1.865 1.679l-1.263 12A1.875 1.875 0 0 0 4.25 22.5h15.5a1.875 1.875 0 0 0 1.865-2.071l-1.263-12a1.875 1.875 0 0 0-1.865-1.679H16.5V6a4.5 4.5 0 1 0-9 0ZM12 3a3 3 0 0 0-3 3v.75h6V6a3 3 0 0 0-3-3Zm-3 8.25a3 3 0 1 0 6 0v-.75a.75.75 0 0 1 1.5 0v.75a4.5 4.5 0 1 1-9 0v-.75a.75.75 0 0 1 1.5 0v.75Z" clip-rule="evenodd" />
                                        </svg>

                                        <h1 class="md:text-xl text-indigo-600 font-bold">Online Shop</h1>
                                    </li>
                                    <li class="text-center mx-4 pb-2.5 text-white font-medium border-b border-gray-600">Detail Orderan</li>
                                    <li class="grid grid-cols-5 mx-4 pb-2.5 border-b border-gray-600">
                                        <span class="col-span-2 text-start">Nama </span> <span class="col-span-3 text-start"> : {{ $order['user']['nama'] }}</span>
                                        <span class="col-span-2 text-start">Alamat Pengiriman </span> <span class="col-span-3 text-start"> : {{ $order['address'] }}</span>
                                    </li>
                                    @php $grand_total = 0; @endphp
                                    @foreach($order['order_details'] as $detail)
                                    @php
                                    $product_name = $detail['product']['name'] . ($detail['product_photo_type'] === null?"": " - " . $detail['product_photo_type']['type']);
                                    $product_price = $detail['product']['latest_product_price']['price'];
                                    $total = $product_price * $detail['qty'];
                                    $grand_total += $total;
                                    @endphp
                                    <li class="px-4 inline-flex justify-between">
                                        <span>{{ $product_name }} @ {{ $detail['qty'] }}</span>
                                        <span>x Rp {{ number_format($product_price, 0, ',', '.') }} = Rp {{ number_format($total, 0, ',', '.') }}</span>
                                    </li>
                                    @endforeach
                                    <li class="text-center mx-4 py-2.5 text-white font-medium border-t border-gray-600">
                                        Total Pembayaran {{ $order['payment_method']['name'] == "COD"? $order['payment_method']['name'] : "Transfer " }} Rp {{ number_format($grand_total, 0, ',', '.') }}
                                    </li>
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
                        <label for="showModal" class="ring-0 outline-0 block w-fit px-4 py-2 text-sm rounded-lg bg-indigo-600 text-white hover:bg-indigo-500 transition cursor-pointer">
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
                    @if($order['payment_photo'] == null && $order['payment_method']['name'] != 'COD')
                    Belum Pembayaran
                    @elseif($order['status'] == 'menunggu')
                    <a href="{{ route('store.proses_pesanan', ['orderID'=>$order['id'], 'action'=>'diproses']) }}" @click="loading = true" class="block w-fit px-4 py-2 text-sm rounded-lg bg-indigo-600 text-white hover:bg-indigo-500 transition">Proses Pesanan</a>
                    @elseif($order['status'] == 'diproses')
                    <a href="{{ route('store.proses_pesanan', ['orderID'=>$order['id'], 'action'=>'dikirim']) }}" @click="loading = true" class="block w-fit px-4 py-2 text-sm rounded-lg bg-indigo-600 text-white hover:bg-indigo-500 transition">Kirim Pesanan</a>
                    @else
                    <span class="block w-fit px-4 py-2 text-sm rounded-lg bg-green-600 text-white transition">Pesanan Selesai</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</section>
@endsection
