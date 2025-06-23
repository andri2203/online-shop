@extends('layout')

@section('main')
<h1 class="text-3xl text-center text-white font-semibold mb-4">Semua Transaksi</h1>

<section class="px-4 py-2.5 sm:mx-6 lg:mx-8 rounded-lg bg-gray-800">
    <table class="w-full">
        <thead class="border-b border-gray-400">
            <tr>
                <th class="py-2.5">#</th>
                <th class="py-2.5">Tanggal Orderan</th>
                <th class="py-2.5">Metode Bayar</th>
                <th class="py-2.5">Total Bayar</th>
                <th class="py-2.5">Status</th>
                <th class="py-2.5">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $index => $order)
            <tr class="border-b border-gray-400  hover:bg-gray-700/50">
                <th class="text-center px-4 py-2.5">{{ $index + 1 }}</th>
                <td class="text-center px-4 py-2.5">
                    <a href="{{ route('orderan_anda', ['orderID'=>$order['id']]) }}" class="px-2 py-1 text-base hover:text-indigo-500 text-white" @click="loading = true">
                        {{ \Carbon\Carbon::parse($order['created_at'])->format('d-m-y H:i') }}
                    </a>
                </td>
                <td class="text-center px-4 py-2.5">
                    @if($order->paymentMethod->name == 'COD' || $order['payment_photo'] == null)
                    {{ $order->paymentMethod->name }}
                    @else
                    <!-- Wrapper sebagai group -->
                    <div class="relative group">

                        <!-- Tombol trigger -->
                        <label for="showModal" class="ring-0 outline-0 px-4 py-1.5 rounded-lg text-sm bg-indigo-700/50 hover:bg-indigo-500 text-white cursor-pointer">
                            {{ "Transfer ke " . $order->paymentMethod->name }}
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
                                        Bukti Transfer Anda
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
                    @if($order->paymentMethod->name != 'COD' && $order['payment_photo'] == null)
                    <a href="{{ route('orderan_anda', ['orderID'=>$order['id']]) }}" class="px-2 py-1 text-sm rounded-md bg-indigo-500/50 hover:bg-indigo-500 text-white" @click="loading = true">
                        Silahkan Melakukan Pembayaran
                    </a>
                    @elseif($order['status'] == 'menunggu')
                    <span class="text-sm">Menunggu Konfirmasi</span>
                    @elseif($order['status'] == 'diproses')
                    <span class="text-sm">Orderan sedang diproses</span>
                    @else
                    <span class="text-sm">Pesanan Telah Dikirim oleh </span>
                    @endif
                </td>
                <td class="px-4 py-2.5 text-center">

                    <div class="rounded-md overflow-hidden w-fit inline-flex">
                        @if($order['status'] == 'menunggu' && $order['payment_photo'] == null)
                        <a href="{{ route('orderan_anda', ['orderID'=>$order['id']]) }}" class="px-2 py-1 text-xs bg-red-600/50 hover:bg-red-600 text-white" @click="loading = true">
                            Batalkan Pesanan
                        </a>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</section>
@endsection
