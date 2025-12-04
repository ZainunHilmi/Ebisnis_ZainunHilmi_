{{-- User Panel Sidebar Component --}}
<aside class="w-64 bg-gray-900 text-white min-h-screen flex flex-col fixed h-full shadow-2xl z-50">
    {{-- Logo/Brand --}}
    <div class="p-6 border-b border-gray-800">
        <div class="flex items-center space-x-3">
            <div class="bg-gray-800 p-3 rounded-xl shadow-lg">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-bold tracking-tight text-white">User Panel</h1>
                <p class="text-xs text-gray-400 font-medium">E-Business Platform</p>
            </div>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 px-4 py-6 space-y-2">
        <a href="{{ route('user.dashboard') }}"
            class="group flex items-center px-4 py-3.5 rounded-xl transition-all duration-200 {{ request()->routeIs('user.dashboard') ? 'bg-gray-800 text-white shadow-lg border-l-4 border-blue-500' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
            <div
                class="flex items-center justify-center w-10 h-10 rounded-lg {{ request()->routeIs('user.dashboard') ? 'bg-gray-700' : 'bg-gray-800 group-hover:bg-gray-700' }} transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                    </path>
                </svg>
            </div>
            <span class="ml-3 font-semibold text-sm">Dashboard</span>
        </a>

        <a href="{{ route('user.my-products.index') }}"
            class="group flex items-center px-4 py-3.5 rounded-xl transition-all duration-200 {{ request()->routeIs('user.my-products.*') ? 'bg-gray-800 text-white shadow-lg border-l-4 border-blue-500' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
            <div
                class="flex items-center justify-center w-10 h-10 rounded-lg {{ request()->routeIs('user.my-products.*') ? 'bg-gray-700' : 'bg-gray-800 group-hover:bg-gray-700' }} transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                    </path>
                </svg>
            </div>
            <span class="ml-3 font-semibold text-sm">My Products</span>
        </a>

        <a href="{{ route('profile.edit') }}"
            class="group flex items-center px-4 py-3.5 rounded-xl transition-all duration-200 {{ request()->routeIs('profile.*') ? 'bg-gray-800 text-white shadow-lg border-l-4 border-blue-500' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
            <div
                class="flex items-center justify-center w-10 h-10 rounded-lg {{ request()->routeIs('profile.*') ? 'bg-gray-700' : 'bg-gray-800 group-hover:bg-gray-700' }} transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <span class="ml-3 font-semibold text-sm">Profile</span>
        </a>
    </nav>

    {{-- User Profile Card --}}
    <div class="p-4 border-t border-gray-800">
        <div class="bg-gray-800 rounded-xl p-4 shadow-lg">
            <div class="flex items-center space-x-3 mb-3">
                <div class="flex-shrink-0">
                    <div
                        class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500 flex items-center justify-center text-white font-bold text-base shadow-lg">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-400 truncate">{{ Auth::user()->email }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center justify-center px-4 py-2.5 text-sm font-medium text-white bg-gray-700 hover:bg-gray-600 transition-all rounded-lg shadow-md hover:shadow-lg">
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
</aside>