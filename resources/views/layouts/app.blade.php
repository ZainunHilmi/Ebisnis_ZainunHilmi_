@php
    $user = Auth::user();
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    x-data="{ darkMode: localStorage.getItem('darkMode') === 'true', sidebarOpen: true }" :class="{ 'dark': darkMode }">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Marketplace') - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="font-sans antialiased text-slate-900 bg-slate-50 dark:bg-slate-950 dark:text-slate-100 transition-colors duration-300">
    <div class="min-h-screen flex overflow-hidden">

        {{-- User Sidebar --}}
        <x-user-sidebar />

        {{-- Main Content --}}
        <main class="flex-1 transition-all duration-300 min-h-screen relative flex flex-col"
            :class="sidebarOpen ? 'ml-72' : 'ml-0'">
            {{-- User Topbar --}}
            <header
                class="h-20 flex items-center justify-between px-8 bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border-b border-slate-200 dark:border-slate-800 sticky top-0 z-40">
                <div class="flex items-center">
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:text-primary-600 dark:hover:text-primary-400 transition-all mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="sidebarOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                            <path x-show="!sidebarOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                        </svg>
                    </button>
                    @isset($header)
                        <div class="text-xl font-semibold text-slate-800 dark:text-white">
                            {{ $header }}
                        </div>
                    @endisset
                </div>

                <div class="flex items-center space-x-4">
                    {{-- Dark Mode Toggle --}}
                    <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)"
                        class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:text-yellow-500 dark:hover:text-yellow-400 transition-all">
                        <svg x-show="!darkMode" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                        <svg x-show="darkMode" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3v1m0 16v1m9-9h1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M16.243 16.243l.707.707M7.757 7.757l.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                        </svg>
                    </button>

                    <div class="h-8 w-px bg-slate-200 dark:bg-slate-800 mx-2"></div>

                    {{-- User Profile --}}
                    <div class="flex items-center space-x-3 pl-2">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-bold text-slate-800 dark:text-white">{{ $user->name }}</p>
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-primary-100 text-primary-700 dark:bg-primary-900/30 dark:text-primary-400 uppercase tracking-wider">Buyer
                                Account</span>
                        </div>
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=6366f1&color=fff"
                            class="w-10 h-10 rounded-xl border-2 border-primary-500/20 shadow-lg shadow-primary-500/10"
                            alt="">
                    </div>
                </div>
            </header>

            {{-- Content Area --}}
            <div class="flex-1 p-8 animate-fade-in relative z-10 overflow-y-auto custom-scrollbar">
                {{ $slot }}
            </div>

            {{-- Footer --}}
            <footer
                class="p-8 border-t border-slate-200 dark:border-slate-800 bg-white/50 dark:bg-slate-900/50 backdrop-blur-sm">
                <div
                    class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0 text-center md:text-left">
                    <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">
                        &copy; {{ date('Y') }} <span
                            class="text-indigo-600 dark:text-indigo-400 font-bold tracking-tight uppercase">{{ config('app.name', 'Laravel') }}</span>.
                        Experience the future of commerce.
                    </p>
                    <div class="flex items-center space-x-6">
                        <a href="#"
                            class="text-xs font-bold text-slate-400 hover:text-primary-500 transition-colors uppercase tracking-widest">Privacy</a>
                        <a href="#"
                            class="text-xs font-bold text-slate-400 hover:text-primary-500 transition-colors uppercase tracking-widest">Terms</a>
                    </div>
                </div>
            </footer>
        </main>
    </div>

    @stack('scripts')
</body>

</html>