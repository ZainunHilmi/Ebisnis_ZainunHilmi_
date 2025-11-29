@php
    $userRole = Auth::user()->role;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - Admin Panel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700;800;900&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }

        .bg-gradient-primary {
            background-color: #4e73df;
            background-image: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
            background-size: cover;
        }
    </style>
</head>

<body class="bg-gray-100 font-sans antialiased">
    <div class="min-h-screen flex" id="wrapper">
        {{-- Admin Panel Sidebar --}}
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion w-64 min-h-screen flex flex-col text-white transition-all duration-300"
            id="accordionSidebar">
            {{-- Sidebar - Brand --}}
            <a class="sidebar-brand flex items-center justify-center py-6 px-4 text-white no-underline border-b border-white/10"
                href="{{ route('admin.dashboard') }}">
                <div class="sidebar-brand-icon mr-3 bg-white/10 backdrop-blur-sm p-3 rounded-xl border border-white/20">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                        </path>
                    </svg>
                </div>
                <div class="sidebar-brand-text">
                    <div class="text-xl font-bold tracking-tight">Admin Panel</div>
                    <div class="text-xs text-blue-200 font-medium">Management System</div>
                </div>
            </a>

            {{-- Divider --}}
            <hr class="border-t border-white/10 mx-4 my-2">

            {{-- Nav Item - Dashboard --}}
            <li class="nav-item px-3 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a class="nav-link flex items-center px-4 py-3.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-white/10 text-white border-l-4 border-white' : 'text-white/70 hover:bg-white/5 hover:text-white border-l-4 border-transparent' }}"
                    href="{{ route('admin.dashboard') }}">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-white/20' : 'bg-white/5' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <span class="ml-3 font-semibold text-sm">Dashboard</span>
                </a>
            </li>

            {{-- Divider --}}
            <hr class="border-t border-white/10 mx-4 my-2">

            {{-- Heading --}}
            <div class="sidebar-heading px-6 py-3 text-xs font-bold text-white/40 uppercase tracking-wider">
                Management
            </div>

            {{-- Nav Item - Users --}}
            <li class="nav-item px-3 {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <a class="nav-link flex items-center px-4 py-3.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-white/10 text-white border-l-4 border-white' : 'text-white/70 hover:bg-white/5 hover:text-white border-l-4 border-transparent' }}"
                    href="{{ route('admin.users.index') }}">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg {{ request()->routeIs('admin.users.*') ? 'bg-white/20' : 'bg-white/5' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </div>
                    <span class="ml-3 font-semibold text-sm">Users</span>
                </a>
            </li>

            {{-- Nav Item - Products --}}
            <li class="nav-item px-3 {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <a class="nav-link flex items-center px-4 py-3.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.products.*') ? 'bg-white/10 text-white border-l-4 border-white' : 'text-white/70 hover:bg-white/5 hover:text-white border-l-4 border-transparent' }}"
                    href="{{ route('admin.products.index') }}">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg {{ request()->routeIs('admin.products.*') ? 'bg-white/20' : 'bg-white/5' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <span class="ml-3 font-semibold text-sm">Products</span>
                </a>
            </li>

            {{-- Divider --}}
            <hr class="border-t border-white/10 mx-4 my-2">

            {{-- Spacer --}}
            <div class="flex-1"></div>

            {{-- Admin Info Card --}}
            <div class="p-4 border-t border-white/10">
                <div class="bg-white/5 backdrop-blur-sm rounded-xl p-4 border border-white/10">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-400 via-blue-500 to-blue-600 flex items-center justify-center text-white font-bold text-base shadow-lg border-2 border-white/20">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                            <div class="flex items-center mt-1">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-400/20 text-yellow-300 border border-yellow-400/30">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    Admin
                                </span>
                            </div>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center justify-center px-4 py-2.5 text-sm font-medium text-white bg-white/10 hover:bg-white/20 transition-all rounded-lg border border-white/20">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                </path>
                            </svg>
                            Sign Out
                        </button>
                    </form>
                </div>
            </div>

        </ul>
        {{-- End of Sidebar --}}

        {{-- Content Wrapper --}}
        <div id="content-wrapper" class="flex-1 flex flex-col min-w-0 overflow-hidden">

            {{-- Main Content --}}
            <div id="content" class="flex-1">

                {{-- Topbar --}}
                <nav
                    class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow flex justify-between px-6 py-3">

                    {{-- Sidebar Toggle (Topbar) --}}
                    <button id="sidebarToggleTop" class="btn btn-link md:hidden rounded-full mr-3 text-blue-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    {{-- Topbar Search --}}
                    <form class="hidden sm:inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="relative">
                            <input type="text"
                                class="form-control bg-gray-100 border-0 small px-4 py-2 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500 w-64"
                                placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                            <button
                                class="btn btn-primary absolute right-0 top-0 h-full px-3 bg-blue-600 text-white rounded-r-md hover:bg-blue-700"
                                type="button">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </button>
                        </div>
                    </form>

                    {{-- Topbar Navbar --}}
                    <ul class="navbar-nav ml-auto flex items-center space-x-4">

                        {{-- Nav Item - Alerts --}}
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle relative text-gray-400 hover:text-gray-600" href="#"
                                id="alertsDropdown" role="button">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                    </path>
                                </svg>
                                {{-- Counter - Alerts --}}
                                <span
                                    class="absolute -top-1 -right-1 bg-red-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-md">3+</span>
                            </a>
                        </li>

                        {{-- Nav Item - Messages --}}
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle relative text-gray-400 hover:text-gray-600" href="#"
                                id="messagesDropdown" role="button">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                                {{-- Counter - Messages --}}
                                <span
                                    class="absolute -top-1 -right-1 bg-red-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-md">7</span>
                            </a>
                        </li>

                        <div class="topbar-divider d-none d-sm-block w-px h-8 bg-gray-300 mx-2"></div>

                        {{-- Nav Item - User Information --}}
                        <li class="nav-item dropdown no-arrow flex items-center">
                            <a class="nav-link dropdown-toggle flex items-center space-x-2" href="#" id="userDropdown"
                                role="button">
                                <span
                                    class="mr-2 d-none d-lg-inline text-gray-600 small font-medium">{{ Auth::user()->name }}</span>
                                <img class="img-profile rounded-full w-8 h-8 object-cover border border-gray-200"
                                    src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random">
                            </a>

                            {{-- Logout Form (Hidden but accessible via JS/CSS dropdown in real app, simplified here)
                            --}}
                            <form method="POST" action="{{ route('logout') }}" class="ml-4">
                                @csrf
                                <button type="submit" class="text-gray-400 hover:text-red-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                </button>
                            </form>
                        </li>

                    </ul>

                </nav>
                {{-- End of Topbar --}}

                {{-- Begin Page Content --}}
                <div class="container-fluid px-6">
                    @yield('content')
                </div>
                {{-- /.container-fluid --}}

            </div>
            {{-- End of Main Content --}}

            {{-- Footer --}}
            <footer class="sticky-footer bg-white py-4 mt-auto border-t border-gray-200">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto text-gray-500 text-sm">
                        <span>Copyright &copy; Your Website {{ date('Y') }}</span>
                    </div>
                </div>
            </footer>
            {{-- End of Footer --}}

        </div>
        {{-- End of Content Wrapper --}}

    </div>
    {{-- End of Page Wrapper --}}
</body>

</html>