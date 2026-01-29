@php
    use Illuminate\Support\Facades\Auth;
@endphp

<nav class="bg-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            {{-- Logo dan Brand --}}
            <div class="flex items-center">
                <div class="flex-shrink-0 flex items-center">
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-2 rounded-xl">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <span class="ml-3 text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                        {{ config('app.name', 'E-Commerce') }}
                    </span>
                </div>
            </div>

            {{-- Navigation Links --}}
            @if(Auth::check())
                <div class="hidden md:flex items-center space-x-1">
                    @if(optional(Auth::user())->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" 
                           class="px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-indigo-600 font-medium transition-all duration-200 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Admin Dashboard
                        </a>
                    @else
                        <a href="{{ route('user.dashboard') }}" 
                           class="px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-indigo-600 font-medium transition-all duration-200 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Dashboard
                        </a>
                        
                        <a href="{{ route('user.products.index') }}" 
                           class="px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-indigo-600 font-medium transition-all duration-200 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            Products
                        </a>

                        <a href="{{ route('user.cart.index') }}" 
                           class="px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-indigo-600 font-medium transition-all duration-200 flex items-center relative">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Cart
                            @if(auth()->user()->cart && auth()->user()->cart->items->count() > 0)
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold">
                                    {{ auth()->user()->cart->items->count() }}
                                </span>
                            @endif
                        </a>
                    @endif

                    <a href="{{ route('profile.edit') }}" 
                       class="px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-indigo-600 font-medium transition-all duration-200 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Profile
                    </a>

                    {{-- Logout Button --}}
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" 
                                class="px-4 py-2 rounded-lg text-red-600 hover:bg-red-50 hover:text-red-700 font-medium transition-all duration-200 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            @else
                <div class="hidden md:flex items-center space-x-4">
                    <a href="{{ route('login') }}" 
                       class="px-6 py-2 text-indigo-600 hover:text-indigo-700 font-medium transition-colors">
                        Login
                    </a>
                    <a href="{{ route('register') }}" 
                       class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 font-medium transition-all shadow-md">
                        Register
                    </a>
                </div>
            @endif

            {{-- Mobile menu button --}}
            <div class="md:hidden flex items-center">
                <button type="button" 
                        class="mobile-menu-button p-2 rounded-md text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile menu --}}
        @if(Auth::check())
            <div class="mobile-menu hidden md:hidden pb-3">
                <div class="flex flex-col space-y-2 pt-2">
                    @if(optional(Auth::user())->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">Dashboard</a>
                    @else
                        <a href="{{ route('user.dashboard') }}" class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">Dashboard</a>
                        <a href="{{ route('user.products.index') }}" class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">Products</a>
                        <a href="{{ route('user.cart.index') }}" class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">Cart</a>
                    @endif
                    <a href="{{ route('profile.edit') }}" class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">Profile</a>
                    <form method="POST" action="{{ route('logout') }}" class="px-4">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg">Logout</button>
                    </form>
                </div>
            </div>
        @else
            <div class="mobile-menu hidden md:hidden pb-3">
                <div class="flex flex-col space-y-2 pt-2">
                    <a href="{{ route('login') }}" class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">Login</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 text-indigo-600 hover:bg-indigo-50 rounded-lg">Register</a>
                </div>
            </div>
        @endif
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuButton = document.querySelector('.mobile-menu-button');
    const mobileMenu = document.querySelector('.mobile-menu');
    
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    }
});
</script>