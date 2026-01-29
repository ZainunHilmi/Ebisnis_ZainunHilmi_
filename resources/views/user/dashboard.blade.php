<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
            {{ __('Marketplace Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6 animate-fade-in">
        {{-- Quick Stats / Welcome --}}
        <div class="mb-10 p-8 rounded-3xl bg-gradient-to-r from-primary-600 to-indigo-700 shadow-2xl shadow-primary-500/20 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-64 h-64 bg-white/10 rounded-full -mr-20 -mt-20 blur-3xl group-hover:scale-125 transition-transform duration-700"></div>
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between">
                <div>
                    <h1 class="text-3xl font-extrabold text-white mb-2 leading-tight">Elite Shopping Experience</h1>
                    <p class="text-primary-100 font-medium opacity-90">Discover the best products curated just for you.</p>
                </div>
                <div class="mt-6 md:mt-0 flex space-x-4">
                    <div class="px-6 py-4 bg-white/10 backdrop-blur-md rounded-2xl border border-white/20 text-center">
                        <p class="text-xs font-bold text-primary-200 uppercase tracking-widest mb-1">Items in Cart</p>
                        <p class="text-2xl font-black text-white">{{ $user->cartItems->count() ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            {{-- My Store --}}
            <a href="{{ route('user.my-products.index') }}" class="group">
                <div class="card p-6 h-full border-b-4 border-b-primary-500 hover:shadow-2xl transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-primary-500/10 text-primary-600 dark:text-primary-400 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-2">My Store</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Manage your products and sales history effortlessly.</p>
                </div>
            </a>

            {{-- My Orders --}}
            <a href="{{ route('user.cart.index') }}" class="group">
                <div class="card p-6 h-full border-b-4 border-b-indigo-500 hover:shadow-2xl transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-2">Cart & Checkout</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Review your items and proceed to secure payment.</p>
                </div>
            </a>

            {{-- Profile Settings --}}
            <a href="{{ route('profile.edit') }}" class="group">
                <div class="card p-6 h-full border-b-4 border-b-purple-500 hover:shadow-2xl transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-purple-500/10 text-purple-600 dark:text-purple-400 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-2">Account Settings</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Customize your preferences and secure your account.</p>
                </div>
            </a>
        </div>

        {{-- Marketplace Section --}}
        <div class="mb-8 flex items-center justify-between px-2">
            <div>
                <h3 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Marketplace</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Browse through our curated collection.</p>
            </div>
            <div class="flex items-center space-x-2">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest mr-2">Sort by:</span>
                <select class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-300 px-3 py-1.5 focus:ring-2 focus:ring-primary-500">
                    <option>Newest First</option>
                    <option>Price: Low to High</option>
                    <option>Price: High to Low</option>
                </select>
            </div>
        </div>

        @if($products->isEmpty())
            <div class="card p-20 text-center border-dashed bg-slate-50/50 dark:bg-slate-900/20">
                <div class="p-4 bg-slate-100 dark:bg-slate-800 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6 text-slate-400 dark:text-slate-500">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <h4 class="text-xl font-bold text-slate-800 dark:text-white mb-2">No products found</h4>
                <p class="text-slate-500 dark:text-slate-400 font-medium max-w-sm mx-auto">It seems our marketplace is currently empty. Check back later!</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach($products as $product)
                    <div class="card group overflow-hidden hover:shadow-2xl hover:-translate-y-2 transition-all duration-500">
                        {{-- Product Image --}}
                        <div class="relative h-64 bg-slate-100 dark:bg-slate-800 overflow-hidden">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out">
                            @else
                                <div class="flex items-center justify-center h-full text-slate-300 dark:text-slate-600">
                                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-6">
                                <a href="{{ route('user.products.show', $product) }}" class="w-full py-2.5 bg-white text-slate-900 text-center font-bold rounded-xl text-sm shadow-xl hover:bg-primary-500 hover:text-white transition-all">
                                    View Details
                                </a>
                            </div>
                            <div class="absolute top-4 right-4">
                                @if($product->stock > 0)
                                    <span class="glass-card px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest text-emerald-600 dark:text-emerald-400 border-none shadow-glow">Available</span>
                                @else
                                    <span class="glass-card px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest text-red-600 dark:text-red-400 border-none">Sold Out</span>
                                @endif
                            </div>
                        </div>

                        {{-- Product Info --}}
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="text-lg font-extrabold text-slate-800 dark:text-white line-clamp-1 flex-1 pr-4">{{ $product->name }}</h4>
                                <span class="text-primary-600 dark:text-primary-400 font-black tracking-tight tracking-widest">${{ number_format($product->price, 0) }}</span>
                            </div>
                            <p class="text-xs text-slate-500 dark:text-slate-400 font-medium line-clamp-2 leading-relaxed h-8 mb-4">
                                {{ $product->description ?? 'No description provided for this premium item.' }}
                            </p>
                            <div class="flex items-center justify-between border-t border-slate-100 dark:border-slate-800 pt-4 mt-2">
                                <div class="flex items-center space-x-2">
                                    <div class="w-6 h-6 rounded-full bg-slate-200 dark:bg-slate-700"></div>
                                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Seller Name</span>
                                </div>
                                <form action="{{ route('user.cart.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="p-2 text-slate-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>