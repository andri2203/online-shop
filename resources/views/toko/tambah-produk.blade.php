@extends('toko.template')

@section('title', ' | Beranda Toko')

@section('content')
<h1 class="title mb-2">Tambah Produk</h1>

<form action="{{ route('store.tambah_produk') }}" enctype="multipart/form-data" method="post" class="grid grid-cols-1 lg:grid-cols-2 rounded-lg w-full px-4 py-2.5 bg-gray-800 gap-y-2 gap-x-4">
    @csrf
    <div class="col-span 1">
        <div class="mb-2">
            <label for="name" class="form-label">Nama Produk</label>
            <div class="mt-2">
                <input type="text" name="name" id="name" class="form-input" placeholder="Produk anda" value="{{ old('name') }}" />
            </div>
            @error('name')
            <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-2">
            <label for="type" class="form-label">Tipe Produk</label>
            <div class="mt-2 grid grid-cols-1">
                <select id="type" name="type" class="form-select">
                    <option value="">-- Pilih Tipe Produk --</option>
                    @foreach($tipe_produk as $tipe)
                    <option value="{{ $tipe->value }}"><span class="uppercase">{{ $tipe->name }}</span></option>
                    @endforeach
                </select>
                <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                    <path fill-rule="evenodd" d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                </svg>
            </div>
            @error('type')
            <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-2">
            <label for="stocks" class="form-label">Jumlah Produk</label>
            <div class="mt-2">
                <input type="number" name="stocks" id="stocks" class="form-input" placeholder="Jumlah produk dijual" value="{{ old('stocks') }}" />
            </div>
            @error('stocks')
            <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-2 row-span-3">
            <label for="description" class="form-label">Deskripsi Produk</label>
            <div class="mt-2">
                <textarea name="description" id="description" rows="7" class="form-textarea h-full" placeholder="Deskripsikan produk anda">{{ old('decription') }}</textarea>
            </div>
            @error('description')
            <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-2">
            <label for="price" class="form-label">Harga Produk</label>
            <div class="mt-2">
                <input type="number" name="price" id="price" class="form-input" placeholder="harga produk anda" value="{{ old('price') }}" />
            </div>
            @error('price')
            <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-2">
            <label for="discount_percent" class="form-label">Diskon (Dalam %)</label>
            <div class="mt-2">
                <input type="number" name="discount_percent" id="discount_percent" class="form-input" placeholder="Diskon dalam % (boleh kosong)" value="{{ old('discount_percent') }}" />
            </div>
            @error('discount_percent')
            <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-2">
            <label for="discount_number" class="form-label">Diskon (Nominal)</label>
            <div class="mt-2">
                <input type="number" name="discount_number" id="discount_number" class="form-input" placeholder="Diskon dalam nominal (Contoh: 10000) (Boleh Kosong)" value="{{ old('discount_number') }}" />
            </div>
            @error('discount_number')
            <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-span-1" x-data="{ previews: [] }">
        <div id="clone_element" class="w-full mb-4">
            <label for="cover-photo" class="block text-sm/6 font-medium text-gray-400">Foto Produk</label>
            <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-400/25 px-6 py-10">
                <div class="text-center">
                    <svg class="mx-auto size-12 text-gray-600" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z" clip-rule="evenodd" />
                    </svg>

                    <div class="mt-4 flex justify-center text-sm/6 text-gray-400">
                        <label for="file-upload"
                            class="relative cursor-pointer rounded-md bg-gray-900 px-4 font-semibold text-indigo-600 focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 focus-within:outline-hidden hover:text-indigo-500">
                            <span>Upload a file</span>
                            <input id="file-upload" name="photo[]" type="file" class="sr-only"
                                @change=" const files = Array.from($event.target.files);
  console.log('Semua files:', files);
  previews = files.filter(file => file instanceof File && file.size > 0 && file.type.startsWith('image/'));
  console.log('Filtered previews:', previews);" multiple />
                        </label>
                    </div>
                    <p class="text-sm/5 text-gray-400">Pilih Foto Produk anda</p>
                    <p class="text-xs/5 text-gray-400">Anda dapat membedakan jenis produk anda di setiap gambar. (anda dapat mengkosongkannya)</p>
                </div>
            </div>
            @error('photo')
            <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>
        <div class="grid grid-cols-2 gap-4">
            <template x-if="previews.length > 0">
                <template x-for="(preview, index) in previews" :key="index">
                    <div class="w-full" x-init="console.log(preview)">
                        <img :src="URL.createObjectURL(preview)" alt="Preview"
                            class="mx-auto h-32 w-32 object-cover rounded-md shadow mb-2" />
                        <div class="">
                            <div class="mt-2">
                                <input type="text" name="jenis_produk[]" id="jenis_product" class="form-input" placeholder="Jenis Produk Anda" />
                            </div>
                            @error('jenis_product')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </template>
            </template>
        </div>

    </div>

    <div class="col-span-full inline-flex justify-start">
        <button class="ring-0 outline-0 border-0 bg-indigo-600/50 text-gray-400 px-4 py-2.5 rounded-full cursor-pointer hover:bg-indigo-600 hover:text-white" @click="loading = true">Tambah Produk</button>
    </div>
</form>
@endsection
