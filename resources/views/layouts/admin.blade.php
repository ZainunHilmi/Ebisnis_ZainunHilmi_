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

    <title>@yield('title') - {{ config('app.name', 'Admin Panel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="font-sans antialiased text-slate-900 bg-slate-50 dark:bg-slate-950 dark:text-slate-100 transition-colors duration-300">
    <div class="min-h-screen flex overflow-hidden">

        {{-- Sidebar --}}
        <aside
            class="fixed inset-y-0 left-0 z-50 w-72 transition-transform duration-300 transform bg-slate-900 dark:bg-slate-900 border-r border-slate-800 flex flex-col"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            {{-- Sidebar Header --}}
            <div class="h-20 flex items-center px-6 border-b border-slate-800">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3">
                    <div
                        class="w-10 h-10 rounded-xl bg-primary-600 flex items-center justify-center shadow-lg shadow-primary-900/20">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div>
                        <span
                            class="text-xl font-bold tracking-tight text-white uppercase tracking-widest">{{ config('app.name', 'ADMIN') }}</span>
                    </div>
                </a>
            </div>

            {{-- Sidebar Navigation --}}
            <nav class="flex-1 px-4 py-8 space-y-2 overflow-y-auto custom-scrollbar">
                <div class="px-4 mb-4 text-xs font-semibold text-slate-500 uppercase tracking-widest">General</div>

                <a href="{{ route('admin.dashboard') }}"
                    class="sidebar-nav {{ request()->routeIs('admin.dashboard') ? 'sidebar-nav-active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span>Dashboard</span>
                </a>

                <div class="px-4 mt-8 mb-4 text-xs font-semibold text-slate-500 uppercase tracking-widest">Management
                </div>

                <a href="{{ route('admin.users.index') }}"
                    class="sidebar-nav {{ request()->routeIs('admin.users.*') ? 'sidebar-nav-active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span>Users Control</span>
                </a>

                <a href="{{ route('admin.products.index') }}"
                    class="sidebar-nav {{ request()->routeIs('admin.products.*') ? 'sidebar-nav-active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <span>Inventory</span>
                </a>
            </nav>

            {{-- Sidebar Footer --}}
            <div class="p-4 border-t border-slate-800">
                <div class="p-4 rounded-2xl bg-slate-800/50 border border-slate-700">
                    <div class="flex items-center space-x-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0ea5e9&color=fff"
                            class="w-10 h-10 rounded-lg" alt="">
                        <div class="flex-1 overflow-hidden">
                            <p class="text-sm font-semibold text-white truncate">{{ $user->name }}</p>
                            <p class="text-xs text-slate-400 truncate">{{ $user->email }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="mt-4">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-red-600/10 hover:bg-red-600/20 text-red-500 rounded-xl transition-all border border-red-600/20">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- Content Area --}}
        <main
            class="flex-1 bg-slate-50 dark:bg-slate-950 transition-all duration-300 min-h-screen relative flex flex-col"
            :class="sidebarOpen ? 'ml-72' : 'ml-0'">
            {{-- Topbar --}}
            <header
                class="h-20 flex items-center justify-between px-8 bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border-b border-slate-200 dark:border-slate-800 sticky top-0 z-40">
                <div class="flex items-center">
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:text-primary-600 dark:hover:text-primary-400 transition-all mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="sidebarOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h8m-8 6h16" />
                            <path x-show="!sidebarOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <h2 class="text-xl font-semibold text-slate-800 dark:text-white">Admin Hub</h2>
                </div>

                <div class="flex items-center space-x-4">
                    {{-- Dark Mode Toggle --}}
                    <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)"
                        class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:text-yellow-500 dark:hover:text-yellow-400 transition-all">
                        <svg x-show="!darkMode" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                        <svg x-show="darkMode" class="w-6 h-6 font-bold" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3v1m0 16v1m9-9h1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M16.243 16.243l.707.707M7.757 7.757l.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                        </svg>
                    </button>

                    <div class="h-8 w-px bg-slate-200 dark:bg-slate-800 mx-2"></div>

                    {{-- User Dropdown (Simulated with Profile Link) --}}
                    <div class="flex items-center space-x-3 pl-2">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-bold text-slate-800 dark:text-white line-clamp-1">{{ $user->name }}
                            </p>
                            <p class="text-xs font-medium text-slate-500 dark:text-slate-400 line-clamp-1">Super Admin
                            </p>
                        </div>
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0ea5e9&color=fff"
                            class="w-10 h-10 rounded-xl border-2 border-primary-500/20 shadow-lg shadow-primary-500/10"
                            alt="">
                    </div>
                </div>
            </header>

            {{-- Main Content Window --}}
            <div class="flex-1 p-8 animate-fade-in relative z-10">
                @if (session('success'))
                    <div
                        class="mb-8 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl flex items-center text-emerald-600 dark:text-emerald-400 animate-slide-up">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                @endif

                @yield('content')
            </div>

            {{-- Footer --}}
            <footer
                class="p-8 mt-auto border-t border-slate-200 dark:border-slate-800 bg-white/50 dark:bg-slate-900/50 backdrop-blur-sm">
                <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                    <p class="text-sm text-slate-500 dark:text-slate-400 font-medium tracking-wide">
                        &copy; {{ date('Y') }} <span
                            class="text-primary-600 dark:text-primary-400 font-bold uppercase">{{ config('app.name', 'ADMIN') }}</span>.
                        All rights reserved.
                    </p>
                    <div class="flex items-center space-x-6">
                        <a href="#"
                            class="text-xs font-bold text-slate-400 hover:text-primary-500 transition-colors uppercase tracking-widest">Documentation</a>
                        <a href="#"
                            class="text-xs font-bold text-slate-400 hover:text-primary-500 transition-colors uppercase tracking-widest">Support</a>
                    </div>
                </div>
            </footer>
        </main>
    </div>

    @stack('scripts')
</body>

</html>