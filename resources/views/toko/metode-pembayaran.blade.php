@extends('toko.template')

@section('title', ' | Beranda Toko')

@section('content')
<div class="inline-flex items-center gap-4">
    @if($payment != null)
    <a href="{{ route('store.metode.pembayaran') }}" class="ring-0 outline-0 text-gray-400 hover:text-indigo-600">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 mb-2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
        </svg>
    </a>
    <h1 class="title leading-relaxed mb-2">Ubah Metode Pembayaran</h1>
    @else
    <h1 class="title leading-relaxed mb-2">Metode Pembayaran</h1>
    @endif
</div>

<section class="grid grid-cols-3 gap-4 w-full">
    <form action="{{ route($action, $parameters) }}" method="post" class="grid grid-cols-1 rounded-lg w-full px-4 py-2.5 bg-gray-800 gap-y-2 gap-x-4">
        @csrf
        <div class="col-span-1">
            <label for="name" class="form-label">Nama Bank</label>
            <div class="mt-2">
                <input type="text" name="name" id="name" class="form-input" placeholder="Bank yang anda gunakan" value="{{ old('name')??$payment != null? $payment['name']:'' }}" />
            </div>
            @error('name')
            <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-span-1 mb-2">
            <label for="account_number" class="form-label">No. Rekening</label>
            <div class="mt-2">
                <input type="text" name="account_number" id="account_number" class="form-input" placeholder="Nomor Rekening Bank Anda" value="{{ old('account_number')??$payment != null? $payment['account_number']:'' }}" />
            </div>
            @error('account_number')
            <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-span-full inline-flex justify-start">
            <button class="ring-0 outline-0 border-0 bg-indigo-600/50 text-sm text-gray-400 px-4 py-1.5 rounded-lg cursor-pointer hover:bg-indigo-600 hover:text-white" @click="loading = true">@if($payment != null) Ubah @else Tambah @endif Metode Pembayaran </button>
        </div>
    </form>

    <div class="col-span-2 w-full px-4 py-2.5 rounded-lg bg-gray-800">
        <table class="w-full">
            <thead class="border-b border-gray-400">
                <tr>
                    <th class="py-2.5">#</th>
                    <th class="py-2.5">Nama Pembayaran</th>
                    <th class="py-2.5">No. Pembayaran</th>
                    <th class="py-2.5">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $index => $pay)
                <tr class="border-b border-gray-400 hover:bg-gray-700/50 @if($payment !=null && $payment['id'] == $pay['id']) bg-indigo-600/50 @endif">
                    <th class="text-center px-4 py-2.5 text-sm">{{ $index + 1 }}</th>
                    <td class="text-center px-4 py-2.5 text-sm">{{ $pay['name'] }}</td>
                    <td class="text-center px-4 py-2.5 text-sm">{{ $pay['account_number'] }}</td>
                    <td class="relative px-4 py-2.5 text-end">
                        @if($pay['is_default'] == false)
                        <div class="rounded-lg inline-flex overflow-hidden">
                            <a href="{{ route('store.ubah.metode.pembayaran',['paymentMethodID'=>$pay['id']]) }}" @click="loading = true" class="ring-0 outline-0 px-2 py-1 text-sm text-gray-400 bg-green-600/50 hover:text-white hover:bg-green-600">Edit</a>
                            <a href="{{ route('store.hapus_metode_pembayaran',['paymentMethodID'=>$pay['id']]) }}" @click="loading = true" class="ring-0 outline-0 px-2 py-1 text-sm text-gray-400 bg-red-600/50 hover:text-white hover:bg-red-600">Hapus</a>
                        </div>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection
