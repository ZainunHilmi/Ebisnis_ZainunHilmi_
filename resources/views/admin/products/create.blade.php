@extends('layouts.admin')

@section('title', 'Add New Product')

@section('content')
    {{-- Header Section --}}
    <div class="mb-10 animate-fade-in">
        <a href="{{ route('admin.products.index') }}"
            class="inline-flex items-center text-xs font-bold text-slate-400 hover:text-primary-500 transition-colors uppercase tracking-widest mb-4 group">
            <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7"></path>
            </svg>
            Back to Catalog
        </a>
        <h1 class="text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">Create <span
                class="text-gradient">Catalog Entry</span></h1>
        <p class="mt-2 text-slate-500 dark:text-slate-400 font-medium tracking-wide uppercase text-[10px]">Initialize new
            infrastructure for the marketplace</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        {{-- Main Form Column --}}
        <div class="lg:col-span-2">
            <div class="card p-8">
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-8">
                    @csrf

                    {{-- Core Information Segment --}}
                    <div>
                        <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6 flex items-center">
                            <span
                                class="w-8 h-8 rounded-lg bg-primary-500/10 text-primary-600 flex items-center justify-center mr-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </span>
                            Product Identity
                        </h3>

                        <div class="space-y-6">
                            <div>
                                <label for="name"
                                    class="block text-xs font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">Display
                                    Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" class="input-field"
                                    placeholder="e.g. MacBook Pro M3 Max" required>
                                @error('name') <p class="mt-2 text-xs font-bold text-rose-500 uppercase tracking-tight">
                                {{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="description"
                                    class="block text-xs font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">Detailed
                                    Specification</label>
                                <textarea name="description" id="description" rows="5" class="input-field"
                                    placeholder="Provide a comprehensive description of the product features and capabilities...">{{ old('description') }}</textarea>
                                @error('description') <p
                                    class="mt-2 text-xs font-bold text-rose-500 uppercase tracking-tight">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Inventory & Pricing Segment --}}
                    <div class="pt-8 border-t border-slate-100 dark:border-slate-800">
                        <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6 flex items-center">
                            <span
                                class="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-600 flex items-center justify-center mr-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                            </span>
                            Economic Metrics
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label for="price"
                                    class="block text-xs font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">Market
                                    Price (IDR)</label>
                                <div class="relative">
                                    <span
                                        class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">Rp</span>
                                    <input type="number" name="price" id="price" value="{{ old('price') }}"
                                        class="input-field pl-12" placeholder="0" min="0" step="1000" required>
                                </div>
                                @error('price') <p class="mt-2 text-xs font-bold text-rose-500 uppercase tracking-tight">
                                {{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="stock"
                                    class="block text-xs font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">Available
                                    Infrastructure</label>
                                <input type="number" name="stock" id="stock" value="{{ old('stock') }}" class="input-field"
                                    placeholder="Total units in stock" min="0" required>
                                @error('stock') <p class="mt-2 text-xs font-bold text-rose-500 uppercase tracking-tight">
                                {{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Form Submission --}}
                    <div
                        class="pt-10 flex items-center justify-end space-x-4 border-t border-slate-100 dark:border-slate-800">
                        <a href="{{ route('admin.products.index') }}"
                            class="px-6 py-3 text-sm font-bold text-slate-500 hover:text-slate-800 dark:hover:text-white transition-colors uppercase tracking-widest">
                            Dismiss
                        </a>
                        <button type="submit" class="btn-primary shadow-primary-500/20 px-8">
                            Initialize Entry
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Visual Assets Column --}}
        <div class="space-y-8">
            <div class="card p-8">
                <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6 flex items-center">
                    <span class="w-8 h-8 rounded-lg bg-purple-500/10 text-purple-600 flex items-center justify-center mr-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </span>
                    Asset Capture
                </h3>

                <div class="space-y-6">
                    <div class="relative group">
                        <div id="image-preview-container"
                            class="hidden aspect-square rounded-2xl overflow-hidden border-2 border-slate-100 dark:border-slate-800 mb-6 group">
                            <img id="image-preview" src="" alt="Preview"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div
                                class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center backdrop-blur-sm">
                                <label for="image"
                                    class="cursor-pointer bg-white text-slate-900 px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-widest shadow-xl transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                                    Change Asset
                                </label>
                            </div>
                        </div>

                        <div id="drop-zone"
                            class="aspect-square rounded-3xl border-2 border-dashed border-slate-200 dark:border-slate-700 hover:border-primary-500 dark:hover:border-primary-500 transition-all flex flex-col items-center justify-center p-8 bg-slate-50 dark:bg-slate-900/50 group text-center cursor-pointer">
                            <div
                                class="w-16 h-16 rounded-2xl bg-white dark:bg-slate-800 shadow-xl shadow-slate-200/50 dark:shadow-black/20 flex items-center justify-center mb-6 text-slate-400 group-hover:text-primary-500 transition-colors transform group-hover:-translate-y-2 duration-300">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                    </path>
                                </svg>
                            </div>
                            <h4 class="text-sm font-bold text-slate-700 dark:text-white uppercase tracking-widest mb-2">
                                Upload Asset</h4>
                            <p class="text-[10px] text-slate-500 font-medium leading-relaxed">Drag and drop high resolution
                                images here</p>
                            <input type="file" form="product-form" name="image" id="image" class="sr-only" accept="image/*"
                                onchange="previewImage(event)">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quality Checklist (Visual only) --}}
            <div class="card p-8 bg-slate-900">
                <h4 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-6">Inventory Guidelines</h4>
                <div class="space-y-4">
                    @foreach(['High quality product imagery', 'Detailed technical specifications', 'Competitive market pricing', 'Accurate infrastructure count'] as $rule)
                        <div class="flex items-center text-xs font-bold text-slate-300">
                            <svg class="w-4 h-4 mr-3 text-primary-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            {{ $rule }}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        // Synchronize drop zone with hidden input
        document.getElementById('drop-zone').onclick = () => document.getElementById('image').click();

        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.getElementById('image-preview');
                    img.src = e.target.result;
                    document.getElementById('image-preview-container').classList.remove('hidden');
                    document.getElementById('drop-zone').classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection