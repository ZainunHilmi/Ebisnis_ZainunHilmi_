@extends('layouts.admin')

@section('title', 'Edit Product')

@section('content')
    {{-- Page Heading --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4 flex justify-between items-center">
        <h1 class="h3 mb-0 text-gray-800 text-2xl font-normal">Edit Product</h1>
    </div>

    <div class="card shadow mb-4 bg-white rounded-md overflow-hidden">
        <div class="card-header py-3 px-4 bg-gray-50 border-b border-gray-200">
            <h6 class="m-0 font-bold text-blue-600">Product Details: {{ $product->name }}</h6>
        </div>
        <div class="card-body p-6">
            <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Product Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Product Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}"
                            class="form-control w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                            placeholder="Enter product name" required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Description
                        </label>
                        <textarea name="description" id="description" rows="4"
                            class="form-control w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                            placeholder="Enter product description">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Price and Stock -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                                Price (IDR) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-2 text-gray-500">Rp</span>
                                <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}"
                                    class="form-control w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                    placeholder="0" min="0" step="1000" required>
                            </div>
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">
                                Stock <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}"
                                class="form-control w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                placeholder="0" min="0" required>
                            @error('stock')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Product Image -->
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                            Product Image
                        </label>

                        @if($product->image)
                            <div class="mb-4 p-4 bg-gray-50 rounded-md border border-gray-200">
                                <p class="text-sm text-gray-600 mb-2">Current Image:</p>
                                <img src="{{ asset('storage/' . $product->image) }}" alt="Current product image"
                                    class="h-32 w-auto rounded-md shadow-sm" id="current-image">
                            </div>
                        @endif

                        <div
                            class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-blue-400 transition-colors">
                            <div class="space-y-1 text-center">
                                <div id="image-preview-container" class="hidden mb-4">
                                    <img id="image-preview" class="mx-auto h-32 w-auto rounded-md shadow-sm" src=""
                                        alt="Preview">
                                </div>
                                <svg id="upload-icon" class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor"
                                    fill="none" viewBox="0 0 48 48">
                                    <path
                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <label for="image"
                                        class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                        <span>Upload new image</span>
                                        <input id="image" name="image" type="file" class="sr-only" accept="image/*"
                                            onchange="previewImage(event)">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                                <p class="text-xs text-blue-600 mt-2">Leave blank to keep current image</p>
                            </div>
                        </div>
                        @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.products.index') }}"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors text-sm font-medium">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors shadow-sm text-sm font-medium">
                        Update Product
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('image-preview').src = e.target.result;
                    document.getElementById('image-preview-container').classList.remove('hidden');
                    document.getElementById('upload-icon').classList.add('hidden');

                    // Hide current image when new one is selected
                    const currentImage = document.getElementById('current-image');
                    if (currentImage) {
                        currentImage.parentElement.parentElement.classList.add('opacity-50');
                    }
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection