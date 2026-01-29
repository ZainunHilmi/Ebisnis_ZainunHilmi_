<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-6 animate-fade-in">
            <a href="{{ route('user.dashboard') }}"
                class="w-12 h-12 rounded-2xl bg-white dark:bg-slate-900 shadow-xl shadow-slate-200/50 dark:shadow-black/20 flex items-center justify-center text-slate-400 hover:text-primary-500 hover:scale-110 transition-all duration-300 group border border-slate-100 dark:border-slate-800">
                <svg class="w-6 h-6 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <nav class="flex mb-1" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-2">
                        <li class="inline-flex items-center">
                            <a href="{{ route('user.dashboard') }}" class="text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-primary-500 transition-colors">Marketplace</a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-slate-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                <span class="ml-1 text-[10px] font-black uppercase tracking-widest text-slate-500">Asset Detail</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white leading-tight tracking-tight">
                    {{ $product->name }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">

                {{-- Asset Visualization (Left) --}}
                <div class="lg:col-span-12 xl:col-span-7">
                    <div class="relative group">
                        <div class="aspect-square xl:aspect-[4/3] rounded-[2.5rem] bg-white dark:bg-slate-900 shadow-2xl shadow-slate-200/50 dark:shadow-black/40 overflow-hidden border-2 border-slate-100 dark:border-slate-800 relative z-10 transition-transform duration-700">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                            @else
                                <div class="flex flex-col items-center justify-center h-full text-slate-200 dark:text-slate-800">
                                    <svg class="w-48 h-48 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Visualization Unavailable</p>
                                </div>
                            @endif
                            
                            {{-- Floating Badges --}}
                            <div class="absolute top-8 left-8 flex flex-col space-y-3 z-20">
                                <span class="glass-card px-4 py-2 rounded-2xl text-[10px] font-black uppercase tracking-widest text-primary-600 dark:text-primary-400 border-primary-500/20 shadow-glow">Premium Asset</span>
                                @if($product->stock > 0)
                                    <span class="px-4 py-2 rounded-2xl bg-emerald-500 text-white text-[10px] font-black uppercase tracking-widest shadow-xl shadow-emerald-500/20 border-none">Verified Identity</span>
                                @endif
                            </div>
                        </div>
                        
                        {{-- Background Glow --}}
                        <div class="absolute -inset-4 bg-gradient-to-tr from-primary-500/20 to-purple-500/20 blur-3xl opacity-50 rounded-[3rem] -z-10 group-hover:opacity-75 transition-opacity duration-700"></div>
                    </div>
                </div>

                {{-- Asset Intelligence (Right) --}}
                <div class="lg:col-span-12 xl:col-span-5 space-y-8">
                    <div class="card p-8 lg:p-10 !rounded-[2.5rem] relative overflow-hidden">
                        {{-- Price Header --}}
                        <div class="mb-10 lg:mb-12">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Market Valuation</p>
                            <div class="flex items-baseline space-x-1">
                                <span class="text-2xl font-bold text-slate-400 italic">Rp</span>
                                <h2 class="text-5xl lg:text-6xl font-black text-slate-900 dark:text-white tracking-tighter transition-all duration-300 hover:text-primary-500">
                                    {{ number_format($product->price, 0, ',', '.') }}
                                </h2>
                            </div>
                        </div>

                        {{-- Acquisition Interface --}}
                        @if($product->stock > 0)
                            <form action="{{ route('user.cart.store') }}" method="POST" class="space-y-6">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                                <div class="grid grid-cols-4 gap-4">
                                    <div class="col-span-1">
                                        <label for="quantity" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Units</label>
                                        <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}"
                                            class="input-field !text-center !px-0 font-bold">
                                    </div>
                                    <div class="col-span-3">
                                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Inventory Status</label>
                                        <div class="h-[3.25rem] flex items-center px-5 rounded-2xl bg-slate-50 dark:bg-slate-900/50 border border-slate-100 dark:border-slate-800">
                                            <span class="flex-shrink-0 w-2 h-2 rounded-full bg-emerald-500 animate-pulse mr-3 shadow-glow-emerald"></span>
                                            <span class="text-[10px] font-black text-slate-600 dark:text-slate-300 uppercase tracking-widest">{{ $product->stock }} units available for deployment</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4">
                                    <button type="submit" name="action" value="add_to_cart"
                                        class="w-full flex items-center justify-center px-6 py-4 rounded-2xl bg-white dark:bg-slate-800 border-2 border-slate-100 dark:border-slate-700 text-xs font-black uppercase tracking-widest text-slate-600 dark:text-slate-300 hover:border-primary-500 hover:text-primary-500 transition-all duration-300 shadow-lg shadow-slate-200/50 dark:shadow-black/20 group">
                                        <svg class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        Stage in Cart
                                    </button>
                                    <button type="submit" name="action" value="buy_now"
                                        class="w-full btn-primary !py-4 shadow-primary-500/30">
                                        Execute Immediate Buy
                                    </button>
                                </div>
                            </form>
                        @else
                            <div class="acquisition-p-10 rounded-2xl bg-rose-50 dark:bg-rose-500/10 border-2 border-rose-100 dark:border-rose-500/20 text-center py-10">
                                <svg class="w-12 h-12 text-rose-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-[10px] font-black text-rose-600 dark:text-rose-400 uppercase tracking-widest">Inventory Fully Depleted</p>
                                <p class="text-[10px] text-rose-500 font-medium uppercase mt-1 tracking-widest">System awaiting replenishment</p>
                            </div>
                        @endif
                    </div>

                    {{-- Spec Card --}}
                    <div class="card p-8 lg:p-10 !rounded-[2.5rem]">
                        <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-6 flex items-center">
                            <span class="w-6 h-6 rounded-lg bg-primary-500/10 text-primary-500 flex items-center justify-center mr-3">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </span>
                            Asset Specification
                        </h3>
                        <div class="prose prose-slate dark:prose-invert max-w-none">
                            <p class="text-slate-600 dark:text-slate-400 leading-relaxed text-sm font-medium">
                                {{ $product->description ?? 'No detailed specifications have been published for this asset identifier.' }}
                            </p>
                        </div>
                        
                        <div class="mt-8 pt-8 border-t border-slate-100 dark:border-slate-800 grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Asset ID</p>
                                <p class="text-xs font-bold text-slate-900 dark:text-white">#{{ str_pad($product->id, 8, '0', STR_PAD_LEFT) }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Category</p>
                                <p class="text-xs font-bold text-slate-900 dark:text-white">Professional Gear</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>