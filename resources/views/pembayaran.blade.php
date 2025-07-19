<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Online Shop @yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css'])
    <!-- Alpine JS -->
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="relative w-full min-h-screen flex flex-col items-center bg-gray-900" x-data="{loading: false}" x-init="setTimeout(() => loading = false, 1000)">
    <!-- Loading Component -->
    <div x-show="loading" class="fixed top-0 left-0 w-full h-full flex shrink-0 justify-center items-center bg-gray-900/50 z-[999]">
        <div class="flex flex-col items-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-10 text-indigo-600 animate-spin mb-4">
                <path fill-rule="evenodd" d="M4.755 10.059a7.5 7.5 0 0 1 12.548-3.364l1.903 1.903h-3.183a.75.75 0 1 0 0 1.5h4.992a.75.75 0 0 0 .75-.75V4.356a.75.75 0 0 0-1.5 0v3.18l-1.9-1.9A9 9 0 0 0 3.306 9.67a.75.75 0 1 0 1.45.388Zm15.408 3.352a.75.75 0 0 0-.919.53 7.5 7.5 0 0 1-12.548 3.364l-1.902-1.903h3.183a.75.75 0 0 0 0-1.5H2.984a.75.75 0 0 0-.75.75v4.992a.75.75 0 0 0 1.5 0v-3.18l1.9 1.9a9 9 0 0 0 15.059-4.035.75.75 0 0 0-.53-.918Z" clip-rule="evenodd" />
            </svg>

            <p class="text-lg font-semibold text-white">Sedang Mendapatkan data. Mohon tunggu...</p>
        </div>
    </div>
    <!-- Loading Component -->
    {{-- Floating Alert --}}
    @if (session('danger'))
    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 4000)"
        x-show="show"
        x-transition
        class="fixed top-6 right-6 z-[9999] px-4 py-3 bg-red-600 text-white rounded-lg shadow-lg flex items-center space-x-3">
        <svg class="w-5 h-5 text-white shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M18 10c0 4.418-3.582 8-8 8s-8-3.582-8-8 3.582-8 8-8 8 3.582 8 8zm-8.707-2.707a1 1 0 011.414 0L11 8.586l.293-.293a1 1 0 111.414 1.414L12.414 10l.293.293a1 1 0 01-1.414 1.414L11 11.414l-.293.293a1 1 0 01-1.414-1.414L9.586 10l-.293-.293a1 1 0 010-1.414z"
                clip-rule="evenodd" />
        </svg>
        <span class="text-sm font-medium">{{ session('danger') }}</span>
    </div>
    @endif

    <nav class="w-3/4 h-16 inline-flex items-center border-b border-gray-600 justify-between">
        <div class="flex  items-center justify-start sm:items-start sm:justify-start">
            <!-- Logo | Start -->
            <div class="flex shrink-0 items-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 md:size-6 text-indigo-600 me-2">
                    <path fill-rule="evenodd" d="M7.5 6v.75H5.513c-.96 0-1.764.724-1.865 1.679l-1.263 12A1.875 1.875 0 0 0 4.25 22.5h15.5a1.875 1.875 0 0 0 1.865-2.071l-1.263-12a1.875 1.875 0 0 0-1.865-1.679H16.5V6a4.5 4.5 0 1 0-9 0ZM12 3a3 3 0 0 0-3 3v.75h6V6a3 3 0 0 0-3-3Zm-3 8.25a3 3 0 1 0 6 0v-.75a.75.75 0 0 1 1.5 0v.75a4.5 4.5 0 1 1-9 0v-.75a.75.75 0 0 1 1.5 0v.75Z" clip-rule="evenodd" />
                </svg>

                <h1 class="md:text-xl text-indigo-600 font-bold">Online Shop</h1>
            </div>
            <!-- Logo | End -->
        </div>
        <h1 class="text-lg font-semibold text-white">Pembayaran</h1>
    </nav>
    <a href="{{ $bayar_langsung? route('bayar.hapus_beli_langsung') : route('home') }}" class="inline-flex items-center w-3/4 my-4 text-gray-400 hover:text-indigo-600">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 me-2">
            <path fill-rule="evenodd" d="M11.03 3.97a.75.75 0 0 1 0 1.06l-6.22 6.22H21a.75.75 0 0 1 0 1.5H4.81l6.22 6.22a.75.75 0 1 1-1.06 1.06l-7.5-7.5a.75.75 0 0 1 0-1.06l7.5-7.5a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
        </svg>
        Kembali
    </a>
    <form action="{{ route('bayar.proses_pembayaran') }}" class="w-3/4 grid grid-cols-3 gap-4 " method="post">
        @csrf
        <section class="col-span-1">
            <div class="mb-4">
                <label for="payment_method_id" class="form-label">Metode Pembayaran</label>
                <div class="mt-2 w-full grid grid-cols-{{ count($store['payment_methods']) }} gap-x-4">
                    @foreach($store['payment_methods'] as $payment_method)
                    <label class="cursor-pointer">
                        <input type="radio"
                            class="hidden peer"
                            name="payment_method_id"
                            id="payment_{{ $payment_method['id'] }}"
                            value="{{ $payment_method['id'] }}" {{ $payment_method['is_default']?"checked":"" }}>

                        <div class="py-4 text-gray-400 flex flex-col justify-center items-center border border-gray-400 rounded-lg
                            hover:border-indigo-600 peer-checked:border-indigo-600 peer-checked:text-indigo-600 transition">
                            <span class="text-lg font-bold">{{ $payment_method['name'] }}</span>
                            <span class="text-base">{{ $payment_method['account_number'] }}</span>
                        </div>
                    </label>
                    @endforeach
                </div>
                @error('payment_method_id')
                <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="address" class="form-label">Alamat Pengiriman</label>
                <div class="mt-2">
                    <textarea name="address" id="address" rows="4" class="form-textarea h-full" placeholder="Alamat lengkap dengan kode pos">{{ old('address') }}</textarea>
                </div>
                @error('address')
                <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="inline-flex justify-start">
                <button class="ring-0 outline-0 border-0 bg-indigo-600/50 text-gray-400 px-4 py-1.5 rounded-lg cursor-pointer hover:bg-indigo-600 hover:text-white" @click="loading = true">Pembayaran</button>
            </div>
        </section>
        <section class="col-span-2">
            @foreach($carts as $cart)
            <div class="inline-flex w-full p-4 h-40 mb-4 border border-gray-400 rounded-2xl gap-x-4">
                <img src="/images/{{ $cart['product']['photo'] }}" alt="{{ $cart['product']['name'] }}" class="rounded-lg">
                <div class="w-full flex flex-col">
                    <h3 class="text-lg font-semibold text-gray-400 mb-1 truncate">
                        {{ $cart['product']['name'] }}
                    </h3>
                    <span class="inline-flex items-center gap-2 rounded-lg w-fit text-xs text-white bg-indigo-800 px-3 py-1.5 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-3.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z" />
                        </svg>

                        {{ $cart['product']['user']['nama'] }}
                    </span>
                    <div class="flex flex-col lg:flex-row items-center gap-x-2">
                        <div class="grid grid-cols-1 w-fit">
                            <select id="qty" name="qty[{{ $cart['product']['id'] }}]" class="form-select">
                                @for($qty = 1; $qty <= $cart['product']['stocks']; $qty++)
                                    <option value="{{ $qty }}" {{ $cart['quantity'] == $qty?"selected":"" }}>{{ $qty }}</option>
                                    @endfor
                            </select>
                            <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                                <path fill-rule="evenodd" d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        @if($cart['productPhotoType'] != null)
                        <div class="grid grid-cols-1 w-fit">
                            <select name="product_photo_id[{{ $cart['product']['id'] }}]" class="form-select">
                                @foreach($cart['product']['product_photo_types'] as $productPhotoType)
                                <option value="{{ $productPhotoType['id'] }}" {{ $productPhotoType['id'] == $cart['productPhotoType']['id']?"selected":'' }}>{{ $productPhotoType['type'] }}</option>
                                @endforeach
                            </select>
                            <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                                <path fill-rule="evenodd" d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </section>
    </form>
</body>

</html>
