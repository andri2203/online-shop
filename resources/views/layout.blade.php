<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Online Shop</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Alpine JS -->
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="text-gray-400" x-data="{loading: false}" x-init="setTimeout(() => loading = false, 1000)">
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

    {{-- Floating Alert --}}
    @if (session('success'))
    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 4000)"
        x-show="show"
        x-transition
        class="fixed top-6 right-6 z-[9999] px-4 py-3 bg-green-600 text-white rounded-lg shadow-lg flex items-center space-x-3">
        <svg class="w-5 h-5 text-white shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M18 10c0 4.418-3.582 8-8 8s-8-3.582-8-8 3.582-8 8-8 8 3.582 8 8zm-8.707-2.707a1 1 0 011.414 0L11 8.586l.293-.293a1 1 0 111.414 1.414L12.414 10l.293.293a1 1 0 01-1.414 1.414L11 11.414l-.293.293a1 1 0 01-1.414-1.414L9.586 10l-.293-.293a1 1 0 010-1.414z"
                clip-rule="evenodd" />
        </svg>
        <span class="text-sm font-medium">{{ session('success') }}</span>
    </div>
    @endif

    <nav class="fixed top-0 left-0 w-full bg-gray-800 shadow-sm shadow-indigo-600/50 z-[999]">
        <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
            <div class="relative flex h-16 items-center justify-between">
                <a href="{{ route('home') }}" class="flex  items-center justify-start sm:items-start sm:justify-start">
                    <!-- Logo | Start -->
                    <div class="flex shrink-0 items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 md:size-6 text-indigo-600 me-2">
                            <path fill-rule="evenodd" d="M7.5 6v.75H5.513c-.96 0-1.764.724-1.865 1.679l-1.263 12A1.875 1.875 0 0 0 4.25 22.5h15.5a1.875 1.875 0 0 0 1.865-2.071l-1.263-12a1.875 1.875 0 0 0-1.865-1.679H16.5V6a4.5 4.5 0 1 0-9 0ZM12 3a3 3 0 0 0-3 3v.75h6V6a3 3 0 0 0-3-3Zm-3 8.25a3 3 0 1 0 6 0v-.75a.75.75 0 0 1 1.5 0v.75a4.5 4.5 0 1 1-9 0v-.75a.75.75 0 0 1 1.5 0v.75Z" clip-rule="evenodd" />
                        </svg>

                        <h1 class="md:text-xl text-indigo-600 font-bold">Online Shop</h1>
                    </div>
                    <!-- Logo | End -->
                </a>
                <div class="flex items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="flex shrink-0 items-center px-3.5 py-1.5 text-sm text-gray-400 border border-gray-400 rounded-full has-focus:text-white has-focus:border-indigo-600 transition ease-out duration-100">
                        <svg class="size-4 me-2 " fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                            <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
                        </svg>
                        <input type="text" name="search" id="search" class="w-full ring-0 outline-0 text-gray-200 focus:text-white" placeholder="Cari Toko / Produk">

                        <span class="bg-gray-600 text-xs rounded-xl px-2 py-1 text-gray-300">Enter</span>
                    </div>
                </div>
                <div class="relative flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                    @if($user)
                    <div class="relative ml-3 group">
                        <!-- Tombol ikon keranjang -->
                        <button type="button"
                            class="relative rounded-full bg-gray-800 p-1 text-gray-400 hover:text-indigo-600 focus:outline-none focus:ring-0 cursor-pointer"
                            aria-expanded="false" aria-haspopup="true" id="cart-menu-button">
                            <span class="absolute bottom-0 right-0 flex items-center justify-center size-4 text-xs rounded-full bg-red-600 text-white">
                                {{ count($cart) }}
                            </span>
                            <span class="sr-only">Lihat Keranjang</span>
                            <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 2.25a.75.75 0 0 0 0 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 0 0-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 0 0 0-1.5H5.378A2.25 2.25 0 0 1 7.5 15h11.218a.75.75 0 0 0 .674-.421 60.358 60.358 0 0 0 2.96-7.228.75.75 0 0 0-.525-.965A60.864 60.864 0 0 0 5.68 4.509l-.232-.867A1.875 1.875 0 0 0 3.636 2.25H2.25ZM3.75 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0ZM16.5 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0Z" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div
                            class="absolute right-0 z-10 mt-2 w-96 px-2 origin-top-right rounded-md bg-gray-900 py-1 shadow-lg ring-1 ring-white/5 hidden  group-focus-within:block"
                            role="menu" aria-orientation="vertical" aria-labelledby="cart-menu-button" tabindex="-1">
                            <span class="block px-4 py-2 border-b border-gray-950 text-gray-200  text-sm text-center">Keranjang Anda</span>
                            @foreach($cart as $index => $ct)
                            <div class="inline-flex justify-between items-center gap-x-2 w-full">
                                <span class="block px-4 py-2 text-gray-200 text-xs">{{ $ct['product']['name'] }}{{ $ct['productPhotoType']!= null?" - ".$ct['productPhotoType']['type']:"" }}</span>
                                <span class="inline-flex items-center gap-x-2 px-4 py-2 text-gray-200 text-xs">
                                    x {{ $ct['quantity'] }}
                                    <a href="{{ route('keranjang.hapus_dari_keranjang', ['cart_index'=>$index]) }}" @click="loading = true" class="block p-1 text-red-200  hover:bg-red-800/50 text-sm text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                            <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                                        </svg>

                                    </a>
                                </span>
                            </div>
                            @endforeach
                            <a href="{{ route('bayar.proses') }}" @click="loading = true" class="block px-4 py-2 border-t border-gray-950 text-gray-200  hover:bg-gray-800/50 text-sm text-center">Proses Pembayaran</a>
                        </div>
                    </div>

                    <!-- Profile dropdown -->
                    <div class="relative ml-3 group">
                        <div>
                            <button type="button" class="relative flex rounded-full bg-gray-800 text-sm focus:ring-0 focus:ring-offset-gray-800 focus:outline-hidden" aria-expanded="false" aria-haspopup="true">
                                <span class="absolute -inset-1.5"></span>
                                <span class="sr-only">Open user menu</span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8">
                                    <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" clip-rule="evenodd" />
                                </svg>

                            </button>
                        </div>

                        <div class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-gray-900 py-1 shadow-lg ring-1 ring-white/5 focus:outline-hidden  hidden  group-focus-within:block" role="menu" aria-orientation="vertical" aria-labelledby="cart-menu-button" tabindex="-1">
                            @if($user->role->value == "store")
                            <a href="{{ route('store.beranda') }}" class="block px-4 py-2 text-sm text-gray-200 hover:bg-gray-800/50" role="menuitem" tabindex="-1" id="user-menu-item-0">Beranda</a>
                            @else
                            <a href="{{ route('semua_orderan') }}" class="block px-4 py-2 text-sm text-gray-200 hover:bg-gray-800/50" role="menuitem" tabindex="-1" id="user-menu-item-1">Transaksi Anda</a>
                            @endif
                            <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-gray-200 hover:bg-gray-800/50" role="menuitem" tabindex="-1" id="user-menu-item-2">Keluar</a>
                        </div>
                    </div>
                    @else
                    <!-- Login Button -->
                    <a href="{{ route('login') }}" class="relative ring-0 outline-0 ml-3 text-sm text-indigo-600
                     font-medium rounded-lg px-2.5 py-1 border border-indigo-600 transition-colors duration-150 ease-in-out hover:text-white hover:bg-indigo-600">Masuk</a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <main class="bg-gray-900 mt-16 py-4 min-h-screen">
        @yield('main')
    </main>

    <footer class="flex flex-1 py-4 justify-center bg-gray-800">
        &copy; 2025 All Right Reserved
    </footer>
</body>

</html>
