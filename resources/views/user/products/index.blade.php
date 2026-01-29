<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between space-y-4 md:space-y-0 animate-fade-in">
            <div>
                <h1 class="text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">Personal <span class="text-gradient">Catalog</span></h1>
                <p class="mt-2 text-slate-500 dark:text-slate-400 font-medium tracking-wide uppercase text-[10px]">Infrastructure & Asset Inventory</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('user.my-products.create') }}" class="btn-primary flex items-center shadow-primary-500/20">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Deploy New Asset
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Notification Cluster --}}
            @if(session('success'))
                <div class="mb-10 animate-slide-up">
                    <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 flex items-center text-emerald-600 dark:text-emerald-400">
                        <div class="w-8 h-8 rounded-xl bg-emerald-500/20 flex items-center justify-center mr-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <p class="text-sm font-bold uppercase tracking-widest">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if($products->isEmpty())
                <div class="card p-20 text-center animate-fade-in">
                    <div class="max-w-md mx-auto">
                        <div class="w-24 h-24 rounded-3xl bg-slate-50 dark:bg-slate-900 flex items-center justify-center mx-auto mb-8 border border-slate-100 dark:border-slate-800 shadow-xl group hover:scale-110 transition-transform duration-500">
                            <svg class="w-12 h-12 text-slate-400 group-hover:text-primary-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-black text-slate-900 dark:text-white mb-4 uppercase tracking-tighter">Inventory Empty</h3>
                        <p class="text-slate-500 dark:text-slate-400 text-sm font-medium mb-10 leading-relaxed uppercase tracking-widest text-[10px]">Your personal repository is currently at zero capacity. Protocol requires at least one active asset.</p>
                        <a href="{{ route('user.my-products.create') }}" class="btn-primary shadow-primary-500/20 inline-flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Execute Provisioning
                        </a>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @foreach($products as $product)
                        <div class="card group overflow-hidden border-2 border-transparent hover:border-primary-500/30 transition-all duration-500 hover:-translate-y-2">
                            {{-- Asset Visualization --}}
                            <div class="relative h-64 bg-slate-50 dark:bg-slate-900 overflow-hidden">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                @else
                                    <div class="flex items-center justify-center h-full text-slate-300 dark:text-slate-800">
                                        <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                
                                {{-- Status HUD --}}
                                <div class="absolute top-4 right-4 z-10">
                                    @if($product->stock > 10)
                                        <span class="glass-card px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest text-emerald-600 dark:text-emerald-400 border-none shadow-glow">Available</span>
                                    @elseif($product->stock > 0)
                                        <span class="glass-card px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest text-amber-600 dark:text-amber-400 border-none shadow-glow">Low Units</span>
                                    @else
                                        <span class="glass-card px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest text-rose-600 dark:text-rose-400 border-none">Depleted</span>
                                    @endif
                                </div>

                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            </div>

                            {{-- Asset Parameters --}}
                            <div class="p-6">
                                <h3 class="text-lg font-black text-slate-900 dark:text-white mb-1 line-clamp-1 leading-tight group-hover:text-primary-500 transition-colors">
                                    {{ $product->name }}
                                </h3>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Stock: {{ $product->stock }} Units</p>
                                
                                <div class="text-2xl font-black text-slate-900 dark:text-white mb-6 tracking-tighter">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </div>

                                <div class="grid grid-cols-2 gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                                    <a href="{{ route('user.my-products.edit', $product) }}" class="flex items-center justify-center px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-[10px] font-black uppercase tracking-widest text-slate-600 dark:text-slate-300 hover:bg-primary-500 hover:text-white transition-all">
                                        Configure
                                    </a>
                                    <form action="{{ route('user.my-products.destroy', $product) }}" method="POST" onsubmit="return confirm('Security Protocol: Permanent asset decommissioning? Status is irreversible.');" class="w-full">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full flex items-center justify-center px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-[10px] font-black uppercase tracking-widest text-slate-600 dark:text-slate-300 hover:bg-rose-500 hover:text-white transition-all">
                                            Terminate
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($products->hasPages())
                    <div class="mt-12 p-6 rounded-2xl bg-slate-50/50 dark:bg-slate-900/50 border border-slate-100 dark:border-slate-800">
                        {{ $products->links() }}
                    </div>
                @endif
            @endif

        </div>
    </div>
</x-app-layout>
