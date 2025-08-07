<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Online Shop | Verifikasi Email</title>

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
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8 md:size-10 text-indigo-600 me-2">
            <path fill-rule="evenodd" d="M7.5 6v.75H5.513c-.96 0-1.764.724-1.865 1.679l-1.263 12A1.875 1.875 0 0 0 4.25 22.5h15.5a1.875 1.875 0 0 0 1.865-2.071l-1.263-12a1.875 1.875 0 0 0-1.865-1.679H16.5V6a4.5 4.5 0 1 0-9 0ZM12 3a3 3 0 0 0-3 3v.75h6V6a3 3 0 0 0-3-3Zm-3 8.25a3 3 0 1 0 6 0v-.75a.75.75 0 0 1 1.5 0v.75a4.5 4.5 0 1 1-9 0v-.75a.75.75 0 0 1 1.5 0v.75Z" clip-rule="evenodd" />
        </svg>
        <h1 class="md:text-base text-indigo-600 font-bold max-w-xs text-wrap">Sistem Informasi UMKM Online shop informatics student</h1>
    </a>
    <!-- Logo | End -->

    <section class="px-10 py-6 bg-gray-800">
        <p class="text-sm text-center text-gray-400 mb-4">Kami Telah Mengirimkan Kode Verifikasi ke Email anda</p>

        <form action="{{ route('verifyAction') }}" class="inline-flex justify-center w-full h-8 gap-x-4 mb-4" method="post">
            @csrf
            <input type="text" name="verificationCode" class="ring-0 outline-0 h-full border border-gray-400 rounded-md placeholder:text-sm px-2.5" placeholder="Kode Verifikasi Anda" required>

            <button class="h-full px-5 ring-0 outline-0 rounded-md bg-indigo-600/75 text-white cursor-pointer hover:bg-indigo-600 text-sm">Verifikasi</button>
        </form>

        <p class="text-sm text-center text-gray-400 mb-4">Mohon periksa email anda di Inbox atau di Kotak Spam</p>
    </section>

    <!-- AlpineJS for Alert -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>


</html>
