<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between space-y-4 md:space-y-0 animate-fade-in">
            <div>
                <nav class="flex mb-1" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-2">
                        <li class="inline-flex items-center">
                            <a href="{{ route('user.dashboard') }}" class="text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-primary-500 transition-colors">Marketplace</a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-slate-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                <span class="ml-1 text-[10px] font-black uppercase tracking-widest text-slate-500">Staging Area</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">Deployment <span class="text-gradient">Cart</span></h1>
                <p class="mt-2 text-slate-500 dark:text-slate-400 font-medium tracking-wide uppercase text-[10px]">Reviewing assets staged for immediate acquisition</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Success Notification --}}
            @if(session('success'))
                <div class="mb-8 animate-fade-in">
                    <div class="glass-card bg-emerald-500/10 border-emerald-500/20 p-4 rounded-2xl flex items-center">
                        <div class="w-8 h-8 rounded-lg bg-emerald-500 text-white flex items-center justify-center mr-4 shadow-glow-emerald">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <p class="text-xs font-black text-emerald-600 dark:text-emerald-400 uppercase tracking-widest">Protocol Success: {{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(!$cart || $cart->items->isEmpty())
                <div class="flex flex-col items-center justify-center py-20 animate-fade-in">
                    <div class="w-32 h-32 rounded-[2.5rem] bg-slate-50 dark:bg-slate-900 flex items-center justify-center mb-8 border-2 border-slate-100 dark:border-slate-800 shadow-xl">
                        <svg class="w-12 h-12 text-slate-300 dark:text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Cart Registry Empty</h3>
                    <p class="text-slate-500 dark:text-slate-400 font-medium text-center max-w-xs mb-8">Your procurement staging area is currently vacant. No assets have been flagged for deployment.</p>
                    <a href="{{ route('user.dashboard') }}" class="btn-primary px-8">Return to Marketplace</a>
                </div>
            @else
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                    {{-- Cart Items List --}}
                    <div class="lg:col-span-2 space-y-6">
                        @php $total = 0; @endphp
                        @foreach($cart->items as $item)
                            @php 
                                $subtotal = $item->product->price * $item->quantity; 
                                $total += $subtotal;
                            @endphp
                            <div class="card p-6 flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-6 animate-fade-in transition-all duration-300 hover:border-primary-500/30">
                                {{-- Asset Thumbnail --}}
                                <div class="w-24 h-24 rounded-2xl overflow-hidden flex-shrink-0 border-2 border-slate-50 dark:border-slate-800 shadow-lg">
                                    @if($item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover" alt="">
                                    @else
                                        <div class="w-full h-full bg-slate-50 dark:bg-slate-900 flex items-center justify-center text-slate-300 dark:text-slate-700">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    @endif
                                </div>

                                {{-- Asset Info --}}
                                <div class="flex-1 text-center sm:text-left">
                                    <h4 class="text-lg font-bold text-slate-900 dark:text-white mb-1 uppercase tracking-tight">{{ $item->product->name }}</h4>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Unit Identity: #{{ str_pad($item->product->id, 6, '0', STR_PAD_LEFT) }}</p>
                                    <div class="flex flex-wrap justify-center sm:justify-start gap-4">
                                        <div class="text-[10px] font-black text-primary-500 border border-primary-500/20 bg-primary-500/5 px-3 py-1 rounded-lg uppercase tracking-widest">
                                            Price: Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                        </div>
                                        <div class="text-[10px] font-black text-emerald-500 border border-emerald-500/20 bg-emerald-500/5 px-3 py-1 rounded-lg uppercase tracking-widest leading-none flex items-center">
                                            Sub: Rp {{ number_format($subtotal, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>

                                {{-- Interaction Zone --}}
                                <div class="flex flex-col sm:items-end space-y-4 w-full sm:w-auto">
                                    <form action="{{ route('user.cart.update', $item->id) }}" method="POST" class="flex items-center space-x-2">
                                        @csrf
                                        @method('PATCH')
                                        <div class="flex items-center overflow-hidden rounded-xl border border-slate-100 dark:border-slate-800 focus-within:border-primary-500 transition-colors">
                                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" 
                                                class="w-16 border-none bg-transparent text-center text-xs font-black text-slate-900 dark:text-white focus:ring-0">
                                            <button type="submit" class="px-3 py-2 bg-slate-50 dark:bg-slate-900 text-[10px] font-black uppercase text-primary-500 hover:text-primary-600 border-l border-slate-100 dark:border-slate-800 transition-colors">
                                                Sync
                                            </button>
                                        </div>
                                    </form>

                                    <div class="flex items-center space-x-2 justify-center sm:justify-end">
                                        <form action="{{ route('user.cart.destroy', $item->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-10 h-10 rounded-xl bg-rose-50 dark:bg-rose-500/10 text-rose-500 flex items-center justify-center hover:bg-rose-500 hover:text-white transition-all duration-300" onclick="return confirm('Initiate asset removal protocol?')">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                        <a href="{{ route('user.checkout.index') }}" class="px-6 py-2.5 rounded-xl bg-emerald-500 text-white text-[10px] font-black uppercase tracking-widest shadow-lg shadow-emerald-500/20 transform hover:scale-105 transition-all">
                                            Buy
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Deployment Summary --}}
                    <div class="space-y-6">
                        <div class="card p-8 !bg-slate-900 overflow-hidden relative group">
                            {{-- Decorative Background --}}
                            <div class="absolute -top-24 -right-24 w-48 h-48 bg-primary-500/10 rounded-full blur-3xl group-hover:bg-primary-500/20 transition-all duration-700"></div>
                            
                            <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-8 flex items-center">
                                <span class="w-6 h-6 rounded-lg bg-primary-500/10 text-primary-500 flex items-center justify-center mr-3">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                </span>
                                Acquisition Protocol
                            </h3>

                            <div class="space-y-6">
                                <div class="flex justify-between items-center text-xs font-bold text-slate-400">
                                    <span class="uppercase tracking-widest">Asset Count</span>
                                    <span class="text-slate-200">{{ $cart->items->sum('quantity') }} Units</span>
                                </div>
                                <div class="flex justify-between items-center text-xs font-bold text-slate-400">
                                    <span class="uppercase tracking-widest">Base Valuation</span>
                                    <span class="text-slate-200">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between items-center text-xs font-bold text-slate-400">
                                    <span class="uppercase tracking-widest">Priority Tax (0%)</span>
                                    <span class="text-emerald-500">EXEMPT</span>
                                </div>

                                <div class="pt-6 border-t border-slate-800">
                                    <div class="flex justify-between items-baseline mb-8">
                                        <span class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Total Deployment Cost</span>
                                        <span class="text-3xl font-black text-white tracking-tighter transition-all">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                    </div>

                                    <a href="{{ route('user.checkout.index') }}" class="w-full btn-primary !py-4 shadow-primary-500/30 flex items-center justify-center">
                                        Proceed to Authorization
                                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="card p-6 border-dashed border-2 bg-transparent text-center">
                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Secure transaction protocol active</p>
                            <div class="mt-4 flex justify-center space-x-4 opacity-30">
                                @foreach(['VISA', 'MASTERCARD', 'QRIS'] as $p)
                                    <span class="text-[8px] font-black px-2 py-1 rounded border border-slate-500 dark:border-slate-400 text-slate-500 dark:text-slate-400">{{ $p }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
