@extends('layouts.admin')

@section('title', 'Manage Users')

@section('content')
    {{-- Header Section --}}
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between space-y-4 md:space-y-0 animate-fade-in text-white">
        <div>
            <h1 class="text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">Identity <span class="text-gradient">Security</span></h1>
            <p class="mt-2 text-slate-500 dark:text-slate-400 font-medium tracking-wide uppercase text-[10px]">Access Control & Privilege Management</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.users.create') }}" class="btn-primary flex items-center shadow-primary-500/20">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
                Provision New Identity
            </a>
        </div>
    </div>

    {{-- Notification Cluster --}}
    @if(session('success'))
        <div class="mb-8 animate-slide-up">
            <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 flex items-center text-emerald-600 dark:text-emerald-400">
                <div class="w-8 h-8 rounded-xl bg-emerald-500/20 flex items-center justify-center mr-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <p class="text-sm font-bold uppercase tracking-widest text-emerald-600 dark:text-emerald-400">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-8 animate-slide-up">
            <div class="p-4 rounded-2xl bg-rose-500/10 border border-rose-500/20 flex items-center text-rose-600 dark:text-rose-400">
                <div class="w-8 h-8 rounded-xl bg-rose-500/20 flex items-center justify-center mr-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <p class="text-sm font-bold uppercase tracking-widest text-rose-600 dark:text-rose-400">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    {{-- Main Identity Table --}}
    <div class="card overflow-hidden">
        <div class="p-8 border-b border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <h3 class="text-xl font-bold text-slate-800 dark:text-white">Active Directory</h3>
            <div class="flex items-center space-x-4">
                <div class="relative group">
                    <input type="text" placeholder="Filter identities..." class="bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm font-bold text-slate-600 dark:text-slate-300 pl-10 pr-4 py-2.5 w-64 focus:ring-2 focus:ring-primary-500 transition-all">
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
                        <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Operational Identity</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Primary Endpoint</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Access Privilege</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Initialization Date</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] text-right">Management Commands</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach($users as $user)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-900/40 transition-colors">
                            <td class="px-8 py-6">
                                <div class="flex items-center">
                                    <div class="mr-4 h-12 w-12 rounded-2xl bg-gradient-to-br from-primary-400 to-indigo-600 flex items-center justify-center text-white font-black text-lg shadow-lg shadow-primary-500/20 transform group-hover:scale-110 transition-transform">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="text-base font-extrabold text-slate-900 dark:text-white leading-tight mb-1">{{ $user->name }}</div>
                                        <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none">Status: Connected</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="text-sm font-bold text-slate-600 dark:text-slate-300 lowercase tracking-tight">{{ $user->email }}</div>
                            </td>
                            <td class="px-8 py-6">
                                @if($user->role === 'admin')
                                    <span class="inline-flex px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full bg-purple-500/10 text-purple-600 dark:text-purple-400 shadow-sm shadow-purple-500/10 border border-purple-500/20">System Administrator</span>
                                @else
                                    <span class="inline-flex px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 shadow-sm shadow-emerald-500/10 border border-emerald-500/20">Platform User</span>
                                @endif
                            </td>
                            <td class="px-8 py-6">
                                <div class="text-xs font-extrabold text-slate-500 dark:text-slate-400 uppercase tracking-widest">{{ $user->created_at->format('d M, Y') }}</div>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 hover:text-primary-600 hover:bg-primary-500/10 transition-all shadow-sm border border-transparent hover:border-primary-500/30">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Security Warning: Permanently terminate this identity? This action is irreversible.');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 hover:text-rose-600 hover:bg-rose-500/10 transition-all shadow-sm border border-transparent hover:border-rose-500/30">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    @else
                                        <div class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-slate-900/50 flex items-center justify-center text-slate-300 dark:text-slate-700 cursor-not-allowed border border-slate-100 dark:border-slate-800" title="Protected: Current Interactive Identity">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if($users->hasPages())
            <div class="p-8 border-t border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50">
                {{ $users->links() }}
            </div>
        @endif
    </div>
@endsection