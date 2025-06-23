@extends('toko.template')

@section('title', ' | Beranda Toko')

@section('content')
<h1 class="title mb-2">Laporan</h1>

<form class="inline-flex w-fit px-4 py-2.5 rounded-lg bg-gray-800 mb-2">
    <div class="flex items-center me-2.5">
        <label for="country" class="form-label me-2.5">Jenis laporan</label>
        <div class="mt-2 grid grid-cols-1">
            <select id="country" name="country" autocomplete="country-name" class="form-select">
                <option value="">-- Pilih Jenis laporan --</option>
                <option value="">Laporan Stock Produk</option>
                <option value="">Laporan Penjualan</option>
            </select>
            <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                <path fill-rule="evenodd" d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
            </svg>
        </div>
    </div>
    <button class="ring-0 outline-0 border-0 bg-indigo-600/50 text-gray-400 text-sm px-4 py-1 rounded-full cursor-pointer hover:bg-indigo-600 hover:text-white">Buat Laporan</button>
</form>

<section class="w-full px-4 py-2.5 rounded-lg bg-gray-800">
    <table class="w-full">
        <thead class="border-b border-gray-400">
            <tr>
                <th class="text-center py-2.5">#</th>
                <th class="text-center py-2.5">Nama Laporan</th>
                <th class="text-center py-2.5">Tanggal dibuat</th>
                <th class="text-center py-2.5">Jenis Laporan</th>
                <th class="text-center py-2.5">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr class="border-b border-gray-400 hover:bg-gray-700/50">
                <th colspan="5" class="px-4 py-2.5">Belum ada data laporan</th>
            </tr>
        </tbody>
    </table>
</section>
@endsection
