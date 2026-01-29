@extends('layouts.admin')

@section('title', 'Manage Products')

@section('content')
    {{-- Header Section --}}
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between space-y-4 md:space-y-0 animate-fade-in text-white">
        <div>
            <h1 class="text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">Product <span class="text-gradient">Management</span></h1>
            <p class="mt-2 text-slate-500 dark:text-slate-400 font-medium tracking-wide uppercase text-[10px]">Inventory Control & Global Catalog</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.products.create') }}" class="btn-primary flex items-center shadow-primary-500/20">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                </svg>
                Create New Product
            </a>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="mb-8 animate-slide-up">
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

    {{-- Main Table Card --}}
    <div class="card overflow-hidden">
        <div class="p-8 border-b border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <h3 class="text-xl font-bold text-slate-800 dark:text-white">Professional Catalog</h3>
            <div class="flex items-center space-x-4">
                <div class="relative group">
                    <input type="text" placeholder="Search catalog..." class="bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm font-bold text-slate-600 dark:text-slate-300 pl-10 pr-4 py-2.5 w-64 focus:ring-2 focus:ring-primary-500 transition-all">
                    <svg class="w-5 h-5 absolute left-3 top-2.5 text-slate-400 group-focus-within:text-primary-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Full Product Identity</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Financials</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Operational Status</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Stock Count</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] text-right">Management</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($products as $product)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-900/40 transition-colors">
                            <td class="px-8 py-6">
                                <div class="flex items-center">
                                    <div class="relative mr-4 overflow-hidden rounded-2xl border-2 border-slate-100 dark:border-slate-800 shadow-lg shadow-black/5 group-hover:scale-105 transition-transform duration-300 h-16 w-16">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                                        @else
                                            <div class="h-full w-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="text-base font-extrabold text-slate-900 dark:text-white leading-tight mb-1">{{ $product->name }}</div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400 font-bold uppercase tracking-widest opacity-60">ID #{{ str_pad($product->id, 6, '0', STR_PAD_LEFT) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="text-lg font-black text-slate-800 dark:text-white tracking-tighter">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                            </div>
                            <td class="px-8 py-6">
                                @if($product->stock > 10)
                                    <span class="inline-flex px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 shadow-sm shadow-emerald-500/10">Active & Ready</span>
                                @elseif($product->stock > 0)
                                    <span class="inline-flex px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-400 shadow-sm shadow-amber-500/10">Limited Supply</span>
                                @else
                                    <span class="inline-flex px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full bg-rose-500/10 text-rose-600 dark:text-rose-400 shadow-sm shadow-rose-500/10">Sold Out</span>
                                @endif
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center font-extrabold text-slate-700 dark:text-slate-300">
                                    <span class="text-lg">{{ $product->stock }}</span>
                                    <span class="text-[10px] text-slate-400 uppercase tracking-widest ml-2">Units</span>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 hover:text-primary-600 hover:bg-primary-500/10 transition-all shadow-sm border border-transparent hover:border-primary-500/30">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Secure Warning: This action will permanently remove this item from the catalog. Proceed?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 hover:text-rose-600 hover:bg-rose-500/10 transition-all shadow-sm border border-transparent hover:border-rose-500/30">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center text-slate-400">
                                <div class="max-w-xs mx-auto">
                                    <div class="mb-4 flex justify-center">
                                        <div class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center">
                                            <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <h5 class="text-slate-800 dark:text-white font-bold uppercase tracking-widest text-sm mb-1">Catalog Empty</h5>
                                    <p class="text-xs font-medium">Capture your first product to see it appear in this list.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($products->hasPages())
            <div class="p-8 border-t border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50">
                {{ $products->links() }}
            </div>
        @endif
    </div>
@endsection