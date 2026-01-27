<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased bg-slate-50">
    <div
        class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-blue-600 to-indigo-700">
        <div
            class="w-full sm:max-w-md mt-6 px-10 py-12 bg-white shadow-2xl overflow-hidden sm:rounded-2xl border border-white/20">
            <div class="flex flex-col items-center mb-10">
                <a href="/" class="transition-transform hover:scale-105 duration-300">
                    <x-application-logo class="w-16 h-16 fill-current text-blue-600 drop-shadow-lg" />
                </a>
                <h2 class="text-3xl font-extrabold text-slate-800 mt-6 tracking-tight">Login</h2>
                <p class="text-slate-500 mt-2 text-sm">Silakan masuk ke akun Anda</p>
            </div>

            {{ $slot }}
        </div>

        <div class="mt-8 text-white/70 text-sm font-medium">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
</body>

</html>