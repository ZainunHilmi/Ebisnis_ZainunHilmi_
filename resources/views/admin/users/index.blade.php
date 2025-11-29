@extends('layouts.admin')

@section('title', 'Manage Users')

@section('content')
    {{-- Page Heading --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4 flex justify-between items-center">
        <h1 class="h3 mb-0 text-gray-800 text-2xl font-normal">User Management</h1>
        <a href="{{ route('admin.users.create') }}"
            class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm bg-blue-600 text-white px-3 py-1 rounded-md text-sm hover:bg-blue-700 transition-colors flex items-center">
            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add New User
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    {{-- DataTales Example --}}
    <div class="card shadow mb-4 bg-white rounded-md overflow-hidden">
        <div class="card-header py-3 px-4 bg-gray-50 border-b border-gray-200">
            <h6 class="m-0 font-bold text-blue-600">Users List</h6>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive overflow-x-auto">
                <table class="table table-bordered w-full text-left border-collapse" id="dataTable" width="100%"
                    cellspacing="0">
                    <thead>
                        <tr>
                            <th
                                class="px-4 py-2 border border-gray-200 bg-gray-50 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                User</th>
                            <th
                                class="px-4 py-2 border border-gray-200 bg-gray-50 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Email</th>
                            <th
                                class="px-4 py-2 border border-gray-200 bg-gray-50 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Role</th>
                            <th
                                class="px-4 py-2 border border-gray-200 bg-gray-50 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Registered</th>
                            <th
                                class="px-4 py-2 border border-gray-200 bg-gray-50 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">
                                Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th
                                class="px-4 py-2 border border-gray-200 bg-gray-50 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                User</th>
                            <th
                                class="px-4 py-2 border border-gray-200 bg-gray-50 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Email</th>
                            <th
                                class="px-4 py-2 border border-gray-200 bg-gray-50 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Role</th>
                            <th
                                class="px-4 py-2 border border-gray-200 bg-gray-50 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Registered</th>
                            <th
                                class="px-4 py-2 border border-gray-200 bg-gray-50 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">
                                Actions</th>
                        </tr>
                    </tfoot>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($users as $user)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-2 border border-gray-200">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div
                                                class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-semibold">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-2 border border-gray-200 text-sm text-gray-900">{{ $user->email }}</td>
                                <td class="px-4 py-2 border border-gray-200">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 border border-gray-200 text-sm text-gray-500">
                                    {{ $user->created_at->format('d M Y') }}
                                </td>
                                <td class="px-4 py-2 border border-gray-200 text-right text-sm font-medium">
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                        class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this user?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                        </form>
                                    @else
                                        <span class="text-gray-400 cursor-not-allowed" title="Cannot delete yourself">Delete</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection