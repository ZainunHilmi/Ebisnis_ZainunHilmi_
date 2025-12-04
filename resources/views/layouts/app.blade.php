<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Marketplace</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="font-sans antialiased bg-white">
    <div class="min-h-screen flex">
        {{-- User Panel Sidebar --}}
        <x-user-sidebar />

        {{-- Main Content --}}
        <div class="flex-1 ml-64 relative z-10">
            {{-- Page Heading --}}
            @isset($header)
                <header class="bg-white shadow-sm">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            {{-- Page Content --}}
            <main class="bg-gray-100 min-h-screen">
                {{ $slot }}
            </main>

            {{-- Footer --}}
            <footer class="bg-white/80 backdrop-blur-sm border-t border-gray-200 py-4 mt-8">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <p class="text-center text-sm text-gray-500">
                        &copy; {{ date('Y') }} E-Business Marketplace. All rights reserved.
                    </p>
                </div>
            </footer>
        </div>
    </div>
</body>

</html>