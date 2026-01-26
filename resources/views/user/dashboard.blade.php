<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col space-y-2">
            <h2 class="font-extrabold text-4xl text-gray-900 leading-tight tracking-tight">
                {{ __('Dashboard') }}
            </h2>
            <p class="text-base text-gray-600 font-medium">Selamat datang di User Panel - Kelola produk dan profil Anda</p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Quick Actions --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                {{-- My Products Card --}}
                <a href="{{ route('user.my-products.index') }}" class="group">
                    <div class="bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 hover:scale-105">
                        <div class="flex items-center justify-between mb-6">
                            <div class="bg-white/25 backdrop-blur-md p-4 rounded-2xl shadow-lg">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                            <svg class="w-7 h-7 text-white/70 group-hover:text-white group-hover:translate-x-2 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-extrabold text-white mb-3 tracking-tight">My Products</h3>
                        <p class="text-indigo-50 text-base font-medium leading-relaxed">Kelola produk Anda - tambah, edit, atau hapus produk dengan mudah</p>
                    </div>
                </a>

                {{-- Profile Card --}}
                <a href="{{ route('profile.edit') }}" class="group">
                    <div class="bg-gradient-to-br from-blue-600 via-cyan-600 to-teal-500 rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 hover:scale-105">
                        <div class="flex items-center justify-between mb-6">
                            <div class="bg-white/25 backdrop-blur-md p-4 rounded-2xl shadow-lg">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <svg class="w-7 h-7 text-white/70 group-hover:text-white group-hover:translate-x-2 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-extrabold text-white mb-3 tracking-tight">My Profile</h3>
                        <p class="text-blue-50 text-base font-medium leading-relaxed">Edit informasi profil dan ubah password Anda kapan saja</p>
                    </div>
                </a>

                {{-- Shopping Cart Card --}}
                <a href="{{ route('user.cart.index') }}" class="group md:col-span-2">
                    <div class="bg-gradient-to-br from-emerald-400 via-teal-500 to-cyan-600 rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 hover:scale-101 flex items-center justify-between relative overflow-hidden">
                         <div class="absolute top-0 right-0 -mt-10 -mr-10 w-48 h-48 bg-white/10 rounded-full blur-2xl"></div>
                        
                        <div class="relative z-10">
                            <h3 class="text-3xl font-extrabold text-white mb-2 tracking-tight drop-shadow-lg">Shopping Cart</h3>
                             <p class="text-white/90 text-base font-medium leading-relaxed mb-6">Lihat produk yang telah Anda tambahkan dan lanjutkan ke pembayaran</p>
                             
                             <div class="inline-flex items-center bg-white px-6 py-3 rounded-xl text-emerald-700 font-bold shadow-lg hover:shadow-xl transition-all hover:scale-105">
                                <span>View Cart</span>
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                             </div>
                        </div>

                        <div class="relative z-10 bg-white/25 backdrop-blur-md p-6 rounded-3xl shadow-lg transform group-hover:rotate-12 transition-transform duration-500">
                             <svg class="w-16 h-16 text-white drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                </a>
            </div>

            {{-- Marketplace Products Section --}}
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 bg-white rounded-2xl p-6 shadow-md">
                    <div>
                        <h2 class="text-3xl font-extrabold text-gray-900 mb-2 tracking-tight">Marketplace Products</h2>
                        <p class="text-gray-600 text-base font-medium">Jelajahi produk dari semua seller di platform kami</p>
                    </div>
                    <div class="flex items-center space-x-3 px-5 py-3 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl border-2 border-indigo-100">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <span class="text-indigo-700 font-bold text-lg">{{ $products->count() }} Products</span>
                    </div>
                </div>
            </div>
            
            @if($products->isEmpty())
                <div class="bg-white overflow-hidden shadow-xl rounded-3xl p-20 text-center">
                    <div class="max-w-lg mx-auto">
                        <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-full w-32 h-32 flex items-center justify-center mx-auto mb-8">
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @foreach($products as $product)
                        <div class="group bg-white overflow-hidden shadow-lg hover:shadow-2xl rounded-3xl transition-all duration-300 transform hover:-translate-y-3 hover:scale-105">
                            {{-- Product Image --}}
                            <div class="relative h-72 bg-gradient-to-br from-gray-100 to-gray-200 overflow-hidden">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover group-hover:scale-125 transition-transform duration-700 ease-out">
                                @else
                                    <div class="flex items-center justify-center h-full text-gray-400">
                                        <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                
                                {{-- Stock Badge --}}
                                <div class="absolute top-4 right-4">
                                    @if($product->stock > 10)
                                        <span class="bg-gradient-to-r from-green-500 to-emerald-600 text-white text-xs font-extrabold px-4 py-2 rounded-full shadow-xl backdrop-blur-sm">
                                            ✓ In Stock
                                        </span>
                                    @elseif($product->stock > 0)
                                        <span class="bg-gradient-to-r from-yellow-500 to-orange-600 text-white text-xs font-extrabold px-4 py-2 rounded-full shadow-xl backdrop-blur-sm">
                                            {{ $product->stock }} Left
                                        </span>
                                    @else
                                        <span class="bg-gradient-to-r from-red-500 to-rose-600 text-white text-xs font-extrabold px-4 py-2 rounded-full shadow-xl backdrop-blur-sm">
                                            Sold Out
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <a href="{{ route('user.products.show', $product) }}" class="absolute inset-0 z-10">
                                <span class="sr-only">View Product</span>
                            </a>

                            {{-- Product Details --}}
                            <div class="p-6">
                                <div class="mb-5">
                                    <h3 class="text-xl font-extrabold text-gray-900 mb-3 line-clamp-2 leading-tight tracking-tight">
                                        {{ $product->name }}
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>