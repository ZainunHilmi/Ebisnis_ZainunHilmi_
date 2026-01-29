<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between space-y-4 md:space-y-0 animate-fade-in">
            <div>
                <nav class="flex mb-1" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-2">
                        <li class="inline-flex items-center">
                            <a href="{{ route('user.cart.index') }}" class="text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-primary-500 transition-colors">Staging Area</a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-slate-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                <span class="ml-1 text-[10px] font-black uppercase tracking-widest text-slate-500">Authorization</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">Access <span class="text-gradient">Authorization</span></h1>
                <p class="mt-2 text-slate-500 dark:text-slate-400 font-medium tracking-wide uppercase text-[10px]">Confirming deployment parameters and shipping protocols</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <form action="{{ route('user.checkout.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                    
                    {{-- Logistics Column --}}
                    <div class="lg:col-span-12 xl:col-span-7 space-y-8">
                        <div class="card p-8 !rounded-[2.5rem]">
                            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-8 flex items-center">
                                <span class="w-8 h-8 rounded-lg bg-primary-500/10 text-primary-600 flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </span>
                                Logistics Profile
                            </h3>
                            
                            <div class="space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2 px-1">Authorized Recipient</label>
                                        <div class="input-field bg-slate-50 dark:bg-slate-900/50 border-slate-100 dark:border-slate-800 text-slate-500 font-bold">
                                            {{ Auth::user()->name }}
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2 px-1">Contact Anchor</label>
                                        <div class="input-field bg-slate-50 dark:bg-slate-900/50 border-slate-100 dark:border-slate-800 text-slate-500 font-bold">
                                            {{ Auth::user()->email }}
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label for="address" class="block text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2 px-1">Deployment Destination</label>
                                    <textarea name="address" id="address" rows="5" required 
                                        class="input-field" 
                                        placeholder="Enter the full coordinates for physical asset deployment..."></textarea>
                                    @error('address') <p class="mt-2 text-[10px] font-bold text-rose-500 uppercase tracking-tight">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card p-8 !rounded-[2.5rem] bg-slate-900 text-white border-none relative overflow-hidden">
                            <div class="absolute top-0 right-0 p-8 opacity-10">
                                <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            </div>
                            <h4 class="text-xs font-black text-primary-400 uppercase tracking-[0.2em] mb-4">Security Protocol</h4>
                            <p class="text-slate-400 text-sm font-medium leading-relaxed max-w-md">
                                All deployments are encrypted and tracked via real-time satellite telemetry. By authorizing this request, you agree to the standard operational protocols for asset acquisition.
                            </p>
                        </div>
                    </div>

                    {{-- Summary Column --}}
                    <div class="lg:col-span-12 xl:col-span-5">
                        <div class="card p-8 !rounded-[2.5rem] sticky top-10">
                            <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-8">Acquisition Manifest</h3>
                            
                            <div class="space-y-8 mb-10 overflow-auto max-h-[40vh] pr-2 custom-scrollbar">
                                @foreach($cart->items as $item)
                                    <div class="flex items-center space-x-5 group">
                                        <div class="flex-shrink-0 w-16 h-16 rounded-2xl overflow-hidden border border-slate-100 dark:border-slate-800 shadow-sm relative transition-all duration-300 group-hover:scale-110">
                                            @if($item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full bg-slate-50 dark:bg-slate-900 flex items-center justify-center text-slate-300">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                </div>
                                            @endif
                                            <div class="absolute inset-x-0 bottom-0 bg-black/60 backdrop-blur-sm text-[8px] font-black text-white text-center py-0.5">x{{ $item->quantity }}</div>
                                        </div>

                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-sm font-bold text-slate-900 dark:text-white truncate">{{ $item->product->name }}</h4>
                                            <p class="text-[10px] font-bold text-slate-400 tracking-widest mt-0.5 italic">Rp {{ number_format($item->product->price, 0, ',', '.') }}/unit</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-xs font-black text-slate-900 dark:text-white tracking-tight leading-none">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="pt-8 border-t border-slate-100 dark:border-slate-800 space-y-4">
                                <div class="flex justify-between items-center text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                    <span>Total Valuation</span>
                                    <span class="text-slate-900 dark:text-white">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between items-center text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                    <span>Logistics Fee</span>
                                    <span class="text-emerald-500">EXEMPTED</span>
                                </div>
                                
                                <div class="pt-6 mt-2 flex justify-between items-baseline">
                                    <span class="text-xs font-black text-slate-500 uppercase tracking-[0.2em]">Final Cost</span>
                                    <span class="text-3xl font-black text-primary-500 tracking-tighter">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                                
                                <div class="pt-8">
                                    <button type="submit" class="w-full btn-primary !py-4 shadow-primary-500/30 flex items-center justify-center group overflow-hidden relative">
                                        <span class="relative z-10">Confirm Authorization</span>
                                        <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</x-app-layout>
