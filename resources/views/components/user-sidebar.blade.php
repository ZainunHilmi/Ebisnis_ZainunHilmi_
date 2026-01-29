@php
    $user = Auth::user();
@endphp

<aside
    class="fixed inset-y-0 left-0 z-50 w-72 transition-transform duration-300 transform bg-slate-900 dark:bg-slate-900 border-r border-slate-800 flex flex-col"
    x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in duration-300" x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full">
    {{-- Sidebar Header --}}
    <div class="h-20 flex items-center px-6 border-b border-slate-800">
        <a href="{{ route('user.dashboard') }}" class="flex items-center space-x-3">
            <div
                class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center shadow-lg shadow-indigo-900/20">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
            </div>
            <div>
                <span class="text-xl font-bold tracking-tight text-white uppercase tracking-widest">Market</span>
            </div>
        </a>
    </div>

    {{-- Sidebar Navigation --}}
    <nav class="flex-1 px-4 py-8 space-y-2 overflow-y-auto custom-scrollbar">
        <div class="px-4 mb-4 text-xs font-semibold text-slate-500 uppercase tracking-widest">Shop</div>

        <a href="{{ route('user.dashboard') }}"
            class="sidebar-nav {{ request()->routeIs('user.dashboard') ? 'sidebar-nav-active' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span>Marketplace</span>
        </a>

        <a href="{{ route('user.cart.index') }}"
            class="sidebar-nav {{ request()->routeIs('user.cart.*') ? 'sidebar-nav-active' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span>My Cart</span>
        </a>

        <div class="px-4 mt-8 mb-4 text-xs font-semibold text-slate-500 uppercase tracking-widest">Account</div>

        <a href="{{ route('user.my-products.index') }}"
            class="sidebar-nav {{ request()->routeIs('user.my-products.*') ? 'sidebar-nav-active' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
            <span>My Products</span>
        </a>

        <a href="{{ route('profile.edit') }}"
            class="sidebar-nav {{ request()->routeIs('profile.*') ? 'sidebar-nav-active' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span>Preferences</span>
        </a>
    </nav>

    {{-- Sidebar Footer --}}
    <div class="p-4 border-t border-slate-800">
        <div class="p-4 rounded-2xl bg-indigo-600/10 border border-indigo-600/20 text-center">
            <p class="text-xs font-bold text-indigo-400 uppercase tracking-widest mb-1">Need Help?</p>
            <p class="text-[10px] text-slate-400 mb-3">Check our documentation or contact support.</p>
            <a href="#"
                class="inline-block px-4 py-2 text-xs font-bold bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-all shadow-lg shadow-indigo-900/20">
                Get Support
            </a>
        </div>

        <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf
            <button type="submit"
                class="w-full flex items-center justify-center px-4 py-3 text-sm font-bold text-slate-400 hover:text-red-500 hover:bg-red-500/10 rounded-xl transition-all border border-transparent hover:border-red-500/20">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Sign Out
            </button>
        </form>
    </div>
</aside>