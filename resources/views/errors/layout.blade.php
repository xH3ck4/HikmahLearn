<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('code') | @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-r from-purple-400 via-pink-500 to-red-500 flex items-center justify-center min-h-screen p-4">
    <div class="text-center p-6 bg-white rounded-lg shadow-lg max-w-lg w-full">
        <h1 class="text-9xl font-extrabold text-purple-600">@yield('code')</h1>
        <p class="text-2xl md:text-3xl font-light leading-normal mt-4 font-bold">@yield('message')</p>
        <p class="mt-2 text-gray-600">Anda bisa menemukan banyak hal lain di halaman utama kami.</p>
        <a href="/" class="mt-8 px-6 py-3 bg-purple-600 text-white rounded-full hover:bg-purple-700 transition duration-300 ease-in-out transform hover:scale-105 inline-block font-bold">Kembali ke Beranda</a>
    </div>
</body>
</html>