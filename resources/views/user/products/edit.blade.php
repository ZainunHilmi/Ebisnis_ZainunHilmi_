<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between space-y-4 md:space-y-0 animate-fade-in">
            <div>
                <a href="{{ route('user.my-products.index') }}" class="inline-flex items-center text-xs font-bold text-slate-400 hover:text-primary-500 transition-colors uppercase tracking-widest mb-4 group">
                    <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7"></path>
                    </svg>
                    Back to Catalog
                </a>
                <h1 class="text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">Configure <span class="text-gradient">Asset</span></h1>
                <p class="mt-2 text-slate-500 dark:text-slate-400 font-medium tracking-wide uppercase text-[10px]">Updating parameters for entry #{{ str_pad($product->id, 6, '0', STR_PAD_LEFT) }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                {{-- Main Form Column --}}
                <div class="lg:col-span-2">
                    <div class="card p-8">
                        <form action="{{ route('user.my-products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                            @csrf
                            @method('PUT')

                            {{-- Core Information Segment --}}
                            <div>
                                <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6 flex items-center">
                                    <span class="w-8 h-8 rounded-lg bg-primary-500/10 text-primary-600 flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </span>
                                    Asset Parameters
                                </h3>
                                
                                <div class="space-y-6">
                                    <div>
                                        <label for="name" class="block text-xs font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">Display Name</label>
                                        <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}"
                                            class="input-field"
                                            placeholder="Update asset name" required>
                                        @error('name') <p class="mt-2 text-xs font-bold text-rose-500 uppercase tracking-tight">{{ $message }}</p> @enderror
                                    </div>

                                    <div>
                                        <label for="description" class="block text-xs font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">Detailed Specification</label>
                                        <textarea name="description" id="description" rows="5"
                                            class="input-field"
                                            placeholder="Update asset specifications...">{{ old('description', $product->description) }}</textarea>
                                        @error('description') <p class="mt-2 text-xs font-bold text-rose-500 uppercase tracking-tight">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Economics Segment --}}
                            <div class="pt-8 border-t border-slate-100 dark:border-slate-800">
                                <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6 flex items-center">
                                    <span class="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-600 flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </span>
                                    Economics
                                </h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div>
                                        <label for="price" class="block text-xs font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">Unit Price (IDR)</label>
                                        <div class="relative">
                                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">Rp</span>
                                            <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}"
                                                class="input-field pl-12"
                                                placeholder="0" min="0" step="1000" required>
                                        </div>
                                        @error('price') <p class="mt-2 text-xs font-bold text-rose-500 uppercase tracking-tight">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label for="stock" class="block text-xs font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">Current Capacity</label>
                                        <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}"
                                            class="input-field"
                                            placeholder="Update unit count" min="0" required>
                                        @error('stock') <p class="mt-2 text-xs font-bold text-rose-500 uppercase tracking-tight">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Submission HUD --}}
                            <div class="pt-10 flex items-center justify-end space-x-4 border-t border-slate-100 dark:border-slate-800">
                                <a href="{{ route('user.my-products.index') }}" class="px-6 py-3 text-sm font-bold text-slate-500 hover:text-slate-800 dark:hover:text-white transition-colors uppercase tracking-widest">
                                    Dismiss
                                </a>
                                <button type="submit" class="btn-primary shadow-primary-500/20 px-8">
                                    Persist Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Visual Resources Column --}}
                <div class="space-y-8">
                    <div class="card p-8">
                        <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6 flex items-center">
                            <span class="w-8 h-8 rounded-lg bg-orange-500/10 text-orange-600 flex items-center justify-center mr-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </span>
                            Graphic Asset
                        </h3>

                        <div class="relative group">
                            {{-- Image Display Area --}}
                            <div id="image-preview-container" class="aspect-square rounded-2xl overflow-hidden border-2 border-slate-100 dark:border-slate-800 mb-6 group relative">
                                <img id="image-preview" 
                                     src="{{ $product->image ? asset('storage/' . $product->image) : '' }}" 
                                     alt="Current Asset" 
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 {{ !$product->image ? 'hidden' : '' }}">
                                
                                {{-- Empty State for Visualization --}}
                                @if(!$product->image)
                                    <div id="empty-state" class="flex flex-col items-center justify-center h-full bg-slate-50 dark:bg-slate-900/50">
                                        <svg class="w-16 h-16 text-slate-300 dark:text-slate-800 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">No Visual Asset</p>
                                    </div>
                                @endif

                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center backdrop-blur-sm">
                                    <label for="image" class="cursor-pointer bg-white text-slate-900 px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-widest shadow-xl transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                                        Change Visual
                                    </label>
                                </div>
                            </div>

                            <input type="file" form="edit-form" name="image" id="image" class="sr-only" accept="image/*" onchange="previewImage(event)">
                        </div>

                        <div class="p-4 bg-slate-50 dark:bg-slate-900/50 rounded-xl border border-slate-100 dark:border-slate-800">
                            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest leading-relaxed">
                                Tip: High-quality imagery increases user conversion by up to 40%. Protocol recommends 1:1 aspect ratio.
                            </p>
                        </div>
                    </div>

                    <div class="card p-8 bg-slate-900">
                        <h4 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-6">Asset Security</h4>
                        <div class="space-y-4">
                            @foreach(['Changes are live instantly', 'History log maintained', 'Permanent deletion available from list', 'Image replacement is irreversible'] as $rule)
                                <div class="flex items-center text-xs font-bold text-slate-300">
                                    <svg class="w-4 h-4 mr-3 text-primary-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $rule }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.getElementById('image-preview');
                    const emptyState = document.getElementById('empty-state');
                    
                    img.src = e.target.result;
                    img.classList.remove('hidden');
                    if (emptyState) emptyState.classList.add('hidden');
                    
                    img.parentElement.classList.add('border-primary-500');
                    img.parentElement.classList.remove('border-slate-100', 'dark:border-slate-800');
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
</x-app-layout>
