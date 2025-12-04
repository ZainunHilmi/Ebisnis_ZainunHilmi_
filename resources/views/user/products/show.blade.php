<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('user.dashboard') }}"
                class="text-gray-600 hover:text-indigo-600 transition-colors p-2 hover:bg-gray-100 rounded-xl">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h2 class="font-extrabold text-4xl text-gray-900 leading-tight tracking-tight">
                    {{ __('Product Details') }}
                </h2>
                <p class="text-base text-gray-600 mt-2 font-medium">
                    <a href="{{ route('user.dashboard') }}"
                        class="hover:text-indigo-600 transition-colors font-semibold">Marketplace</a>
                    <span class="mx-2 text-gray-400">/</span>
                    <span class="text-gray-900 font-bold">{{ $product->name }}</span>
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl">
                <div class="p-8 lg:p-12">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

                        {{-- Product Image --}}
                        <div class="space-y-4">
                            <div
                                class="aspect-square bg-gradient-to-br from-gray-50 to-gray-100 rounded-3xl overflow-hidden shadow-2xl border-4 border-white">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                        class="w-full h-full object-contain p-6">
                                @else
                                    <div class="flex items-center justify-center h-full">
                                        <svg class="w-32 h-32 text-gray-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Product Info --}}
                        <div class="flex flex-col">
                            <div class="flex-1">
                                <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                                    {{ $product->name }}
                                </h1>

                                {{-- Price --}}
                                <div class="mb-8 p-6 bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl">
                                    <p class="text-sm text-gray-600 mb-2 font-medium">Price</p>
                                    <p
                                        class="text-5xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </p>
                                </div>

                                {{-- Stock Status --}}
                                <div
                                    class="mb-8 p-5 rounded-2xl {{ $product->stock > 0 ? 'bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-200' : 'bg-gradient-to-r from-red-50 to-pink-50 border-2 border-red-200' }}">
                                    <div class="flex items-center space-x-3">
                                        @if($product->stock > 0)
                                            <div class="flex-shrink-0">
                                                <svg class="w-7 h-7 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-green-900 font-bold text-lg">In Stock</p>
                                                <p class="text-green-700 text-sm">{{ $product->stock }} units available</p>
                                            </div>
                                        @else
                                            <div class="flex-shrink-0">
                                                <svg class="w-7 h-7 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-red-900 font-bold text-lg">Out of Stock</p>
                                                <p class="text-red-700 text-sm">Currently unavailable</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- Description --}}
                                <div class="mb-8">
                                    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                                        <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Description
                                    </h3>
                                    <p class="text-gray-700 leading-relaxed text-lg">
                                        {{ $product->description ?? 'No description available for this product.' }}
                                    </p>
                                </div>

                                {{-- Back Button --}}
                                <div class="mt-8">
                                    <a href="{{ route('user.dashboard') }}"
                                        class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white !text-opacity-100 text-base font-extrabold rounded-xl transition-all shadow-xl hover:shadow-2xl transform hover:-translate-y-1"
                                        style="color: #ffffff !important;">
                                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                        </svg>
                                        Back to Marketplace
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>