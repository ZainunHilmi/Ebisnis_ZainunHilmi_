@extends('layouts.admin')

@section('title', 'Add New User')

@section('content')
    {{-- Header Section --}}
    <div class="mb-10 animate-fade-in text-white">
        <a href="{{ route('admin.users.index') }}"
            class="inline-flex items-center text-xs font-bold text-slate-400 hover:text-primary-500 transition-colors uppercase tracking-widest mb-4 group">
            <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7"></path>
            </svg>
            Back to Directory
        </a>
        <h1 class="text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">Provision <span
                class="text-gradient">Identity</span></h1>
        <p class="mt-2 text-slate-500 dark:text-slate-400 font-medium tracking-wide uppercase text-[10px]">Initialize a new
            secure access point for the platform</p>
    </div>

    <div class="max-w-4xl mx-auto">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Primary Identity Segment --}}
                <div class="card p-8">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6 flex items-center">
                        <span
                            class="w-8 h-8 rounded-lg bg-primary-500/10 text-primary-600 flex items-center justify-center mr-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </span>
                        User Identity
                    </h3>

                    <div class="space-y-6">
                        <div>
                            <label for="name"
                                class="block text-xs font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">Legal
                                Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" class="input-field"
                                placeholder="e.g. Zainun Hilmi" required>
                            @error('name') <p class="mt-2 text-xs font-bold text-rose-500 uppercase tracking-tight">
                            {{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="email"
                                class="block text-xs font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">Primary
                                Endpoint (Email)</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" class="input-field"
                                placeholder="name@domain.com" required>
                            @error('email') <p class="mt-2 text-xs font-bold text-rose-500 uppercase tracking-tight">
                            {{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="role"
                                class="block text-xs font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">Access
                                Privilege Level</label>
                            <select name="role" id="role" class="input-field appearance-none cursor-pointer">
                                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Platform User (Limited)
                                </option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Platform Administrator
                                    (Full Access)</option>
                            </select>
                            @error('role') <p class="mt-2 text-xs font-bold text-rose-500 uppercase tracking-tight">
                            {{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                {{-- Security Segment --}}
                <div class="card p-8">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6 flex items-center">
                        <span class="w-8 h-8 rounded-lg bg-rose-500/10 text-rose-600 flex items-center justify-center mr-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                        </span>
                        Security Protocol
                    </h3>

                    <div class="space-y-6">
                        <div>
                            <label for="password"
                                class="block text-xs font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">Access
                                Key (Password)</label>
                            <input type="password" name="password" id="password" class="input-field"
                                placeholder="Minimum 8 characters" required>
                            @error('password') <p class="mt-2 text-xs font-bold text-rose-500 uppercase tracking-tight">
                            {{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="password_confirmation"
                                class="block text-xs font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">Verify
                                Access Key</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="input-field" placeholder="Re-enter to confirm" required>
                        </div>

                        <div
                            class="p-4 bg-slate-50 dark:bg-slate-900/50 rounded-xl border border-slate-100 dark:border-slate-800 mt-4">
                            <p
                                class="text-[10px] text-slate-500 font-bold uppercase tracking-widest flex items-center leading-relaxed">
                                <svg class="w-4 h-4 mr-2 text-primary-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Security Note: Provisioning will trigger a record in the system logs. Ensure legal identity
                                names and secure credentials.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="mt-10 flex items-center justify-end space-x-6 border-t border-slate-100 dark:border-slate-800 pt-10">
                <a href="{{ route('admin.users.index') }}"
                    class="text-sm font-bold text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors uppercase tracking-widest">
                    Dismiss
                </a>
                <button type="submit" class="btn-primary shadow-primary-500/20 px-10">
                    Authorize Entry
                </button>
            </div>
        </form>
    </div>
@endsection