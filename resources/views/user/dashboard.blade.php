<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-3xl text-gray-800 leading-tight">
                    {{ __('Dashboard') }}
                </h2>
                <p class="text-sm text-gray-900 mt-2">Selamat datang di User Panel</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Quick Actions --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                {{-- My Products Card --}}
                <a href="{{ route('user.my-products.index') }}" class="group">
                    <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-white/20 backdrop-blur-sm p-3 rounded-xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                            <svg class="w-6 h-6 text-white/60 group-hover:text-white group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-2">My Products</h3>
                        <p class="text-indigo-100 text-sm">Kelola produk Anda - tambah, edit, atau hapus produk</p>
                    </div>
                </a>

                {{-- Profile Card --}}
                <a href="{{ route('profile.edit') }}" class="group">
                    <div class="bg-gradient-to-br from-blue-500 to-cyan-600 rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-white/20 backdrop-blur-sm p-3 rounded-xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <svg class="w-6 h-6 text-white/60 group-hover:text-white group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-2">My Profile</h3>
                        <p class="text-blue-100 text-sm">Edit informasi profil dan ubah password Anda</p>
                    </div>
                </a>
            </div>

            {{-- Marketplace Products Section --}}
            <div class="mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">Marketplace Products</h2>
                        <p class="text-gray-800">Jelajahi produk dari semua seller</p>
                    </div>
                    <div class="flex items-center space-x-2 px-4 py-2 bg-indigo-50 rounded-lg">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <span class="text-indigo-700 font-semibold">{{ $products->count() }} Products</span>
                    </div>
                </div>
            </div>
            
            @if($products->isEmpty())
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl p-16 text-center">
                    <div class="max-w-md mx-auto">
                        <svg class="mx-auto h-24 w-24 text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">No Products Available</h3>
                        <p class="text-gray-700 text-lg mb-4">Check back later for exciting new products!</p>
                        <a href="{{ route('user.my-products.create') }}" class="inline-flex items-center px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl transition-all shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah Produk Pertama Anda
                        </a>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($products as $product)
                        <div class="group bg-white overflow-hidden shadow-md hover:shadow-2xl rounded-2xl transition-all duration-300 transform hover:-translate-y-2">
                            {{-- Product Image --}}
                            <div class="relative h-64 bg-gradient-to-br from-gray-50 to-gray-100 overflow-hidden">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="flex items-center justify-center h-full text-gray-300">
                                        <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                
                                {{-- Stock Badge --}}
                                <div class="absolute top-4 right-4">
                                    @if($product->stock > 10)
                                        <span class="bg-gradient-to-r from-green-500 to-green-600 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg">
                                            ✓ In Stock
                                        </span>
                                    @elseif($product->stock > 0)
                                        <span class="bg-gradient-to-r from-yellow-500 to-orange-500 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg">
                                            {{ $product->stock }} Left
                                        </span>
                                    @else
                                        <span class="bg-gradient-to-r from-red-500 to-red-600 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg">
                                            Sold Out
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Product Details --}}
                            <div class="p-5">
                                <div class="mb-4">
                                    <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2">
                                        {{ $product->name }}
                                    </h3>
                                    <p class="text-2xl font-bold text-indigo-600">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </p>
                                </div>
                                <a href="{{ route('user.products.show', $product) }}" 
                                   class="inline-flex items-center justify-center w-full px-5 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white text-sm font-bold rounded-xl transition-all shadow-md hover:shadow-lg">
                                    View Details
                                    <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>