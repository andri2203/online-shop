@extends('layout')

@section('main')
<h1 class="text-3xl text-center text-white font-semibold mb-4">Orderan Anda</h1>

<section class="p-4 sm:mx-6 lg:mx-8 rounded-lg bg-gray-800">
    <span class="mb-4 text-lg text-white font-medium">Tanggal Order : {{ \Carbon\Carbon::parse($order['created_at'])->format('d-m-y H:i') }}</span>
    <table class="w-full">
        <thead class="border-b border-gray-400">
            <tr>
                <th class="py-2.5">#</th>
                <th class="py-2.5">Nama Produk</th>
                <th class="py-2.5">Jumlah</th>
                <th class="py-2.5">Harga</th>
                <th class="py-2.5">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order_details as $index => $order_detail)
            <tr>
                <th class="text-center px-4 py-2.5">{{ $index + 1 }}</th>
                <td class="text-center px-4 py-2.5">{{ $order_detail['product']['name'] }} {{ $order_detail['product_photo_type']==null?"":" - " .$order_detail['product_photo_type']['type'] }}</td>
                <td class="text-center px-4 py-2.5">{{ $order_detail['qty'] }}</td>
                <td class="text-end px-4 py-2.5">Rp {{ number_format($order_detail['product_price']['price'], 0, ',', '.') }}</td>
                <td class="text-end px-4 py-2.5">Rp {{ number_format($order_detail['product_price']['price'] * $order_detail['qty'], 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if($isCOD == false && $order['payment_photo'] == null)
    <div class="border-t border-gray-400 py-2.5 text-center text-white font-medium">
        Silahkan melakukan pembayaran ke {{ $payment_method['name'] }} ke Nomor Rekening {{ $payment_method['account_number'] }} sebesar Rp {{ number_format($order['payment_total'], 0, ',', '.') }}
    </div>
    <form action="{{ route('bayar.proses_upload_bukti_bayar', ['orderID'=>$order['id']]) }}" method="post" enctype="multipart/form-data" class="flex flex-col items-center ">
        @csrf
        <div class="w-1/2 mb-4" x-data="{ preview: null }">
            <label for="cover-photo" class="block text-sm/6 font-medium text-center text-gray-400">Mohon untuk mengirimkan Bukti Transfer</label>
            <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-400/25 px-6 py-10">
                <div class="text-center">
                    <template x-if="!preview">
                        <svg class="mx-auto size-12 text-gray-600" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z" clip-rule="evenodd" />
                        </svg>
                    </template>

                    <!-- Preview gambar -->
                    <template x-if="preview">
                        <img :src="preview" alt="Preview" class="mx-auto h-32 w-32 object-cover rounded-md shadow" />
                    </template>

                    <div class="mt-4 flex justify-center text-sm/6 text-gray-400">
                        <label for="file-upload"
                            class="relative cursor-pointer rounded-md bg-gray-900 px-4 font-semibold text-indigo-600 focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 focus-within:outline-hidden hover:text-indigo-500">
                            <span>Upload Bukti Transfer</span>
                            <input id="file-upload" name="payment_photo" type="file" class="sr-only"
                                @change="const file = $event.target.files[0]; preview = file ? URL.createObjectURL(file) : null" />
                        </label>
                    </div>
                    <p class="text-xs/5 text-gray-400">PNG, JPG up to 10MB</p>
                </div>
            </div>
            @error('payment_photo')
            <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <button @click="loading = true" class="ring-0 outline-0 px-4 py-2.5 text-sm rounded-lg bg-indigo-700/50 text-white hover:bg-indigo-600 cursor-pointer">Proses Pembayaran</button>
    </form>
    @endif
</section>
@endsection
