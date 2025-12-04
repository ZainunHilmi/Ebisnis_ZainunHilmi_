<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div>
                <h2 class="font-extrabold text-4xl text-gray-900 leading-tight tracking-tight">
                    {{ __('My Products') }}
                </h2>
                <p class="text-base text-gray-600 mt-2 font-medium">Manage your product listings</p>
            </div>
            <a href="{{ route('user.my-products.create') }}" 
               class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 text-black !text-opacity-100 text-base font-extrabold rounded-2xl transition-all shadow-xl hover:shadow-2xl transform hover:-translate-y-1"
               style="color: #000000 !important;">
                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                </svg>
                Add New Product
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 px-6 py-4 rounded-lg shadow-sm" role="alert">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if($products->isEmpty())
                <div class="bg-white overflow-hidden shadow-xl rounded-3xl p-20 text-center">
                    <div class="max-w-lg mx-auto">
                        <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-full w-32 h-32 flex items-center justify-center mx-auto mb-8">
                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-extrabold text-gray-900 mb-4 tracking-tight">No Products Yet</h3>
                        <p class="text-gray-600 text-lg mb-8 leading-relaxed">Start by adding your first product to showcase in the marketplace!</p>
                        <a href="{{ route('user.my-products.create') }}" 
                           class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 text-black !text-opacity-100 text-base font-extrabold rounded-2xl transition-all shadow-xl hover:shadow-2xl transform hover:-translate-y-1"
                           style="color: #000000 !important;">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add Your First Product
                        </a>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @foreach($products as $product)
                        <div class="group bg-white overflow-hidden shadow-lg hover:shadow-2xl rounded-3xl transition-all duration-300 transform hover:-translate-y-2 border-2 border-gray-100">
                            {{-- Product Image --}}
                            <div class="relative h-64 bg-gradient-to-br from-gray-100 to-gray-200 overflow-hidden">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
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
                                        <span class="bg-gradient-to-r from-green-500 to-emerald-600 text-white text-xs font-extrabold px-4 py-2 rounded-full shadow-xl">
                                            {{ $product->stock }} in stock
                                        </span>
                                    @elseif($product->stock > 0)
                                        <span class="bg-gradient-to-r from-yellow-500 to-orange-600 text-white text-xs font-extrabold px-4 py-2 rounded-full shadow-xl">
                                            {{ $product->stock }} left
                                        </span>
                                    @else
                                        <span class="bg-gradient-to-r from-red-500 to-rose-600 text-white text-xs font-extrabold px-4 py-2 rounded-full shadow-xl">
                                            Out of Stock
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Product Details --}}
                            <div class="p-6">
                                <div class="mb-5">
                                    <h3 class="text-xl font-extrabold text-gray-900 mb-3 line-clamp-2 leading-tight">
                                        {{ $product->name }}
                                    </h3>
                                    <p class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600 mb-4">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </p>
                                </div>

                                <div class="flex flex-col space-y-3">
                                    <a href="{{ route('user.my-products.edit', $product) }}" 
                                       class="inline-flex items-center justify-center px-5 py-3.5 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white !text-opacity-100 text-sm font-extrabold rounded-xl transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                                       style="color: #ffffff !important;">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Update Product
                                    </a>
                                    <form action="{{ route('user.my-products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full inline-flex items-center justify-center px-5 py-3.5 bg-gradient-to-r from-rose-600 to-red-600 hover:from-rose-700 hover:to-red-700 text-white !text-opacity-100 text-sm font-extrabold rounded-xl transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                                            style="color: #ffffff !important;">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Delete Product
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($products->hasPages())
                    <div class="mt-8">
                        {{ $products->links() }}
                    </div>
                @endif
            @endif

        </div>
    </div>
</x-app-layout>
