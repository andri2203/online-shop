<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Online Shop | Register Akun</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css'])
</head>

<body class="flex flex-col flex-1 justify-center items-center min-h-screen text-gray-400 bg-gray-900 py-4">

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

    <!-- Logo | Start -->
    <a href="{{ route('home') }}" class="flex shrink-0 items-center mb-4 ring-0 outline-0">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 md:size-8 text-indigo-600 me-2">
            <path fill-rule="evenodd" d="M7.5 6v.75H5.513c-.96 0-1.764.724-1.865 1.679l-1.263 12A1.875 1.875 0 0 0 4.25 22.5h15.5a1.875 1.875 0 0 0 1.865-2.071l-1.263-12a1.875 1.875 0 0 0-1.865-1.679H16.5V6a4.5 4.5 0 1 0-9 0ZM12 3a3 3 0 0 0-3 3v.75h6V6a3 3 0 0 0-3-3Zm-3 8.25a3 3 0 1 0 6 0v-.75a.75.75 0 0 1 1.5 0v.75a4.5 4.5 0 1 1-9 0v-.75a.75.75 0 0 1 1.5 0v.75Z" clip-rule="evenodd" />
        </svg>

        <h1 class="text-xl md:text-3xl text-indigo-600 font-bold">Online Shop</h1>
    </a>
    <!-- Logo | End -->
    <form action="{{ route('registerAction') }}" method="POST" class="w-full max-md:mx-4 my-4 lg:w-3/5  bg-gray-800 py-6 px-8 rounded-lg">
        @csrf
        <h1 class="text-2xl text-white font-semibold text-center mb-6">REGISTER AKUN</h1>

        <section class="w-full grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
            <div class="flex flex-col gap-2">
                <label class="font-medium text-gray-400">Daftar Sebagai</label>

                <div class="inline-flex p-1 w-fit bg-gray-800 rounded-full border border-indigo-600">
                    <input type="radio" name="role" value="customer" id="customer" class="sr-only peer/customer" checked>
                    <label for="customer"
                        class="peer-checked/customer:bg-indigo-600 peer-checked/customer:text-gray-900 px-6 py-2 text-sm text-gray-300 rounded-full cursor-pointer transition-all duration-300">
                        Customer
                    </label>

                    <input type="radio" name="role" value="store" id="store" class="sr-only peer/store">
                    <label for="store"
                        class="peer-checked/store:bg-indigo-600 peer-checked/store:text-gray-900 px-6 py-2 text-sm text-gray-300 rounded-full cursor-pointer transition-all duration-300">
                        Store
                    </label>
                </div>

                @error('role')
                <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col gap-2 group">
                <label for="nama" class="font-medium text-gray-400 group-focus-within:text-indigo-600">
                    Nama Lengkap
                </label>

                <div class="flex flex-1 items-center border-b border-gray-400 pb-2 focus-within:border-indigo-600 group">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 24 24" class="size-4 me-4 text-gray-500 group-focus-within:text-indigo-600">
                        <path fill-rule="evenodd"
                            d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0
                     .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786
                     0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
                    </svg>

                    <input type="text"
                        class="ring-0 outline-0 border-0 focus:text-indigo-600"
                        placeholder="Jhon Doe" id="nama" name="nama" />
                </div>

                @error('nama')
                <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col gap-2 group">
                <label for="username" class="font-medium text-gray-400 group-focus-within:text-indigo-600">
                    Username
                </label>

                <div class="flex flex-1 items-center border-b border-gray-400 pb-2 focus-within:border-indigo-600 group">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 24 24" class="size-4 me-4 text-gray-500 group-focus-within:text-indigo-600">
                        <path fill-rule="evenodd"
                            d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0
                     .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786
                     0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
                    </svg>

                    <input type="text"
                        class="ring-0 outline-0 border-0 focus:text-indigo-600"
                        placeholder="Username kamu" id="username" name="username" />
                </div>
                @error('username')
                <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col gap-2 group">
                <label for="email" class="font-medium text-gray-400 group-focus-within:text-indigo-600">
                    Email
                </label>

                <div class="flex flex-1 items-center border-b border-gray-400 pb-2 focus-within:border-indigo-600 group">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 24 24" class="size-4 me-4 text-gray-500 group-focus-within:text-indigo-600">
                        <path fill-rule="evenodd"
                            d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0
                     .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786
                     0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
                    </svg>

                    <input type="email"
                        class="ring-0 outline-0 border-0 focus:text-indigo-600"
                        placeholder="example@example.com" id="email" name="email" />
                </div>
                @error('email')
                <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col gap-2 group">
                <label for="password" class="font-medium text-gray-400 group-focus-within:text-indigo-600">
                    Password
                </label>

                <div class="flex flex-1 items-center border-b border-gray-400 pb-2 focus-within:border-indigo-600 group">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 24 24" class="size-4 me-4 text-gray-500 group-focus-within:text-indigo-600">
                        <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z" clip-rule="evenodd" />
                    </svg>

                    <input type="password"
                        class="ring-0 outline-0 border-0 focus:text-indigo-600"
                        placeholder="Password kamu" id="password" name="password" />
                </div>

                @error('password')
                <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col gap-2 group">
                <label for="password_confirmation" class="font-medium text-gray-400 group-focus-within:text-indigo-600">
                    Konfirmasi Password
                </label>

                <div class="flex flex-1 items-center border-b border-gray-400 pb-2 focus-within:border-indigo-600 group">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 24 24" class="size-4 me-4 text-gray-500 group-focus-within:text-indigo-600">
                        <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z" clip-rule="evenodd" />
                    </svg>

                    <input type="password"
                        class="ring-0 outline-0 border-0 focus:text-indigo-600"
                        placeholder="Password kamu" id="password_confirmation" name="password_confirmation" />
                </div>

                @error('password_confirmation')
                <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

        </section>


        <button type="submit" class="flex justify-center w-full outline-0 ring-0 border-0 uppercase py-2 mb-4 bg-indigo-600/50 text-gray-200 font-semibold rounded-full cursor-pointer">
            Daftar
        </button>

        <p class="text-center text-xs">Sudah memiliki akun? <a href="{{ route('login') }}" class="ms-1 text-indigo-600 hover:underline">Masuk</a></p>
    </form>
</body>

</html>
