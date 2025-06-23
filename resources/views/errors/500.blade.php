<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Online Shop | 500</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css'])
</head>

<body class="flex flex-col flex-1 justify-center items-center min-h-screen text-gray-400 bg-gray-900">


    <!-- Logo | Start -->
    <a href="{{ route('home') }}" class="flex shrink-0 items-center mb-8 ring-0 outline-0">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 md:size-8 text-indigo-600 me-2">
            <path fill-rule="evenodd" d="M7.5 6v.75H5.513c-.96 0-1.764.724-1.865 1.679l-1.263 12A1.875 1.875 0 0 0 4.25 22.5h15.5a1.875 1.875 0 0 0 1.865-2.071l-1.263-12a1.875 1.875 0 0 0-1.865-1.679H16.5V6a4.5 4.5 0 1 0-9 0ZM12 3a3 3 0 0 0-3 3v.75h6V6a3 3 0 0 0-3-3Zm-3 8.25a3 3 0 1 0 6 0v-.75a.75.75 0 0 1 1.5 0v.75a4.5 4.5 0 1 1-9 0v-.75a.75.75 0 0 1 1.5 0v.75Z" clip-rule="evenodd" />
        </svg>
        <h1 class="text-xl md:text-3xl text-indigo-600 font-bold">Online Shop</h1>
    </a>
    <!-- Logo | End -->

    <section class="px-10 py-6 bg-gray-800 flex flex-col items-center">
        <h1 class="text-2xl text-center text-gray-400 mb-4">500 - Internal Server Error</h1>
    </section>

</body>


</html>
