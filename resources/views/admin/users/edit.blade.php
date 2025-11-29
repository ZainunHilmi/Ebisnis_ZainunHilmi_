@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
    {{-- Page Heading --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4 flex justify-between items-center">
        <h1 class="h3 mb-0 text-gray-800 text-2xl font-normal">Edit User</h1>
    </div>

    <div class="card shadow mb-4 bg-white rounded-md overflow-hidden">
        <div class="card-header py-3 px-4 bg-gray-50 border-b border-gray-200">
            <h6 class="m-0 font-bold text-blue-600">User Details: {{ $user->name }}</h6>
        </div>
        <div class="card-body p-6">
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                            class="form-control w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                            required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                            class="form-control w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                            required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                        <select name="role" id="role"
                            class="form-control w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
                            <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        @error('role')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password (Leave blank to
                            keep
                            current)</label>
                        <input type="password" name="password" id="password"
                            class="form-control w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm
                            Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="form-control w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
                    </div>

                    <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.users.index') }}"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors text-sm font-medium">Cancel</a>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors shadow-sm text-sm font-medium">Update
                            User</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection