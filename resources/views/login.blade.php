<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Online Shop | Masuk</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css'])
</head>

<body class="flex flex-col flex-1 justify-center items-center min-h-screen text-gray-400 bg-gray-900">

    {{-- Floating Alert --}}
    @if (session('danger'))
    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 4000)"
        x-show="show"
        x-transition
        class="fixed top-6 right-6 z-50 px-4 py-3 bg-red-600 text-white rounded-lg shadow-lg flex items-center space-x-3">
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
        class="fixed top-6 right-6 z-50 px-4 py-3 bg-green-600 text-white rounded-lg shadow-lg flex items-center space-x-3">
        <svg class="w-5 h-5 text-white shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M18 10c0 4.418-3.582 8-8 8s-8-3.582-8-8 3.582-8 8-8 8 3.582 8 8zm-8.707-2.707a1 1 0 011.414 0L11 8.586l.293-.293a1 1 0 111.414 1.414L12.414 10l.293.293a1 1 0 01-1.414 1.414L11 11.414l-.293.293a1 1 0 01-1.414-1.414L9.586 10l-.293-.293a1 1 0 010-1.414z"
                clip-rule="evenodd" />
        </svg>
        <span class="text-sm font-medium">{{ session('success') }}</span>
    </div>
    @endif

    <!-- Logo | Start -->
    <a href="{{ route('home') }}" class="flex shrink-0 items-center mb-8 ring-0 outline-0">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 md:size-8 text-indigo-600 me-2">
            <path fill-rule="evenodd" d="M7.5 6v.75H5.513c-.96 0-1.764.724-1.865 1.679l-1.263 12A1.875 1.875 0 0 0 4.25 22.5h15.5a1.875 1.875 0 0 0 1.865-2.071l-1.263-12a1.875 1.875 0 0 0-1.865-1.679H16.5V6a4.5 4.5 0 1 0-9 0ZM12 3a3 3 0 0 0-3 3v.75h6V6a3 3 0 0 0-3-3Zm-3 8.25a3 3 0 1 0 6 0v-.75a.75.75 0 0 1 1.5 0v.75a4.5 4.5 0 1 1-9 0v-.75a.75.75 0 0 1 1.5 0v.75Z" clip-rule="evenodd" />
        </svg>
        <h1 class="text-xl md:text-3xl text-indigo-600 font-bold">Online Shop</h1>
    </a>
    <!-- Logo | End -->

    <form action="{{ route('loginAction') }}" method="POST"
        class="w-full sm:mx-4 md:w-3/4 lg:w-96 bg-gray-800 py-6 px-8 rounded-lg">
        @csrf
        <h1 class="text-2xl text-white font-semibold text-center mb-6">MASUK</h1>

        <!-- Username -->
        <div class="flex flex-col gap-2 mb-4 group">
            <label for="username" class="font-medium text-gray-400 group-focus-within:text-indigo-600">
                Username
            </label>
            <div class="flex flex-1 items-center border-b border-gray-400 pb-2 focus-within:border-indigo-600 group">
                <svg ... class="size-4 me-4 text-gray-500 group-focus-within:text-indigo-600">
                    <path ... />
                </svg>
                <input type="text" id="username" name="username"
                    class="ring-0 outline-0 border-0 focus:text-indigo-600"
                    placeholder="Username kamu" value="{{ old('username') }}">
            </div>
        </div>

        <!-- Password -->
        <div class="flex flex-col gap-2 mb-8 group">
            <label for="password" class="font-medium text-gray-400 group-focus-within:text-indigo-600">
                Password
            </label>
            <div class="flex flex-1 items-center border-b border-gray-400 pb-2 focus-within:border-indigo-600 group">
                <svg ... class="size-4 me-4 text-gray-500 group-focus-within:text-indigo-600">
                    <path ... />
                </svg>
                <input type="password" id="password" name="password"
                    class="ring-0 outline-0 border-0 focus:text-indigo-600"
                    placeholder="Password kamu">
            </div>
        </div>

        <!-- Submit -->
        <button type="submit"
            class="flex justify-center w-full outline-0 ring-0 border-0 uppercase py-2 mb-4 bg-indigo-600/50 text-gray-200 font-semibold rounded-full cursor-pointer hover:bg-indigo-600 transition">
            Masuk
        </button>

        <p class="text-center text-xs">
            Belum memiliki akun?
            <a href="{{ route('register') }}" class="ms-1 text-indigo-600 hover:underline">Daftar disini</a>
        </p>
    </form>

    <!-- AlpineJS for Alert -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>


</html>
