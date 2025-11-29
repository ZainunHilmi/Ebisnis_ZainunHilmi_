@extends('layouts.admin')

@section('title', 'Manage Products')

@section('content')
    {{-- Page Heading --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4 flex justify-between items-center">
        <h1 class="h3 mb-0 text-gray-800 text-2xl font-normal">Product Management</h1>
        <a href="{{ route('admin.products.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm bg-blue-600 text-white px-3 py-1 rounded-md text-sm hover:bg-blue-700 transition-colors flex items-center">
            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Add New Product
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    {{-- DataTales Example --}}
    <div class="card shadow mb-4 bg-white rounded-md overflow-hidden">
        <div class="card-header py-3 px-4 bg-gray-50 border-b border-gray-200">
            <h6 class="m-0 font-bold text-blue-600">DataTables Example</h6>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive overflow-x-auto">
                <table class="table table-bordered w-full text-left border-collapse" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 border border-gray-200 bg-gray-50 text-xs font-bold text-gray-500 uppercase tracking-wider">Product</th>
                            <th class="px-4 py-2 border border-gray-200 bg-gray-50 text-xs font-bold text-gray-500 uppercase tracking-wider">Price</th>
                            <th class="px-4 py-2 border border-gray-200 bg-gray-50 text-xs font-bold text-gray-500 uppercase tracking-wider">Stock</th>
                            <th class="px-4 py-2 border border-gray-200 bg-gray-50 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-2 border border-gray-200 bg-gray-50 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th class="px-4 py-2 border border-gray-200 bg-gray-50 text-xs font-bold text-gray-500 uppercase tracking-wider">Product</th>
                            <th class="px-4 py-2 border border-gray-200 bg-gray-50 text-xs font-bold text-gray-500 uppercase tracking-wider">Price</th>
                            <th class="px-4 py-2 border border-gray-200 bg-gray-50 text-xs font-bold text-gray-500 uppercase tracking-wider">Stock</th>
                            <th class="px-4 py-2 border border-gray-200 bg-gray-50 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-2 border border-gray-200 bg-gray-50 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Actions</th>
                        </tr>
                    </tfoot>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($products as $product)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-2 border border-gray-200">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-10 w-10 rounded object-cover">
                                            @else
                                                <div class="h-10 w-10 rounded bg-gray-200 flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                            <div class="text-xs text-gray-500">{{ Str::limit($product->description, 30) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-2 border border-gray-200 text-sm text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td class="px-4 py-2 border border-gray-200 text-sm text-gray-900">{{ $product->stock }}</td>
                                <td class="px-4 py-2 border border-gray-200">
                                    @if($product->stock > 10)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">In Stock</span>
                                    @elseif($product->stock > 0)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Low Stock</span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Out of Stock</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 border border-gray-200 text-right text-sm font-medium">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center border border-gray-200 text-gray-500">
                                    No products found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($products->hasPages())
                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection