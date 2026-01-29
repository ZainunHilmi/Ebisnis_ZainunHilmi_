@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
    {{-- Hero Section --}}
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between space-y-4 md:space-y-0 animate-fade-in">
        <div>
            <h1 class="text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                Welcome back, <span class="text-gradient">{{ explode(' ', Auth::user()->name)[0] }}!</span>
            </h1>
            <p class="mt-2 text-slate-500 dark:text-slate-400 font-medium">Here's what's happening with your marketplace today.</p>
        </div>
        <div class="flex items-center space-x-3">
            <button class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300 px-5 py-2.5 rounded-xl font-bold text-sm shadow-sm hover:shadow-md transition-all flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Export Report
            </button>
            <button class="btn-primary flex items-center shadow-primary-500/20">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                New Product
            </button>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-10">
        {{-- Revenue Card --}}
        <div class="card p-6 group transition-all duration-300 hover:border-primary-500/30">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-primary-500/10 text-primary-600 dark:text-primary-400 rounded-2xl group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="text-xs font-bold text-emerald-500 bg-emerald-500/10 px-2 py-1 rounded-lg">+12.5%</span>
            </div>
            <p class="text-slate-500 dark:text-slate-400 text-sm font-bold uppercase tracking-widest">Total Revenue</p>
            <h3 class="text-3xl font-extrabold text-slate-900 dark:text-white mt-1">$45,285</h3>
        </div>

        {{-- Orders Card --}}
        <div class="card p-6 group transition-all duration-300 hover:border-indigo-500/30">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 rounded-2xl group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <span class="text-xs font-bold text-emerald-500 bg-emerald-500/10 px-2 py-1 rounded-lg">+8.2%</span>
            </div>
            <p class="text-slate-500 dark:text-slate-400 text-sm font-bold uppercase tracking-widest">Total Orders</p>
            <h3 class="text-3xl font-extrabold text-slate-900 dark:text-white mt-1">1,284</h3>
        </div>

        {{-- Products Card --}}
        <div class="card p-6 group transition-all duration-300 hover:border-purple-500/30">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-purple-500/10 text-purple-600 dark:text-purple-400 rounded-2xl group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <span class="text-xs font-bold text-slate-500 bg-slate-500/10 px-2 py-1 rounded-lg">Active</span>
            </div>
            <p class="text-slate-500 dark:text-slate-400 text-sm font-bold uppercase tracking-widest">Products</p>
            <h3 class="text-3xl font-extrabold text-slate-900 dark:text-white mt-1">{{ \App\Models\Product::count() }}</h3>
        </div>

        {{-- Customers Card --}}
        <div class="card p-6 group transition-all duration-300 hover:border-blue-500/30">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-blue-500/10 text-blue-600 dark:text-blue-400 rounded-2xl group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <span class="text-xs font-bold text-emerald-500 bg-emerald-500/10 px-2 py-1 rounded-lg">+5.1%</span>
            </div>
            <p class="text-slate-500 dark:text-slate-400 text-sm font-bold uppercase tracking-widest">Customers</p>
            <h3 class="text-3xl font-extrabold text-slate-900 dark:text-white mt-1">{{ \App\Models\User::count() }}</h3>
        </div>
    </div>

    {{-- Main Analytics Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        {{-- Charts Column --}}
        <div class="lg:col-span-2 space-y-10">
            {{-- Sales Overview --}}
            <div class="card p-8">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h4 class="text-xl font-bold text-slate-800 dark:text-white">Sales Performance</h4>
                        <p class="text-sm text-slate-500 font-medium">Revenue generated over the last 30 days</p>
                    </div>
                    <select class="bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm font-bold text-slate-600 dark:text-slate-300 px-4 py-2 focus:ring-2 focus:ring-primary-500">
                        <option>Last 7 Days</option>
                        <option selected>Last 30 Days</option>
                        <option>Last 12 Months</option>
                    </select>
                </div>
                {{-- Chart Placeholder --}}
                <div class="h-80 w-full relative">
                    <div class="absolute inset-0 flex items-end justify-between px-4 pb-2">
                        @foreach([40, 65, 45, 80, 55, 90, 70, 85, 60, 95, 75, 100] as $height)
                            <div class="w-full mx-1 bg-primary-500/20 dark:bg-primary-500/10 rounded-t-lg transition-all duration-700 hover:bg-primary-500 animate-slide-up" style="height: {{ $height }}%"></div>
                        @endforeach
                    </div>
                    <div class="absolute inset-x-0 bottom-0 h-[1px] bg-slate-200 dark:bg-slate-800"></div>
                </div>
                <div class="flex justify-between mt-4 px-2">
                    @foreach(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $month)
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">{{ $month }}</span>
                    @endforeach
                </div>
            </div>

            {{-- Recent Activity --}}
            <div class="card p-8">
                <h4 class="text-xl font-bold text-slate-800 dark:text-white mb-6">Recent Activity</h4>
                <div class="space-y-6">
                    @foreach([
                        ['icon' => 'shopping-cart', 'color' => 'primary', 'user' => 'Zainun Hilmi', 'action' => 'purchased', 'item' => 'MacBook Pro M3', 'time' => '2 mins ago'],
                        ['icon' => 'user-plus', 'color' => 'indigo', 'user' => 'Sarah Connor', 'action' => 'registered', 'item' => 'new account', 'time' => '15 mins ago'],
                        ['icon' => 'tag', 'color' => 'purple', 'user' => 'Ahmad Fauzi', 'action' => 'added', 'item' => 'Nike Air Max', 'time' => '1 hour ago'],
                    ] as $activity)
                        <div class="flex items-start space-x-4">
                            <div class="w-10 h-10 rounded-full bg-{{ $activity['color'] }}-500/10 flex items-center justify-center text-{{ $activity['color'] }}-600 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-slate-800 dark:text-slate-200">
                                    <span class="font-bold">{{ $activity['user'] }}</span> {{ $activity['action'] }} <span class="text-{{ $activity['color'] }}-500 font-bold tracking-tight">{{ $activity['item'] }}</span>
                                </p>
                                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium mt-0.5">{{ $activity['time'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button class="w-full mt-8 py-3 text-sm font-bold text-primary-600 dark:text-primary-400 hover:bg-primary-500/5 transition-all rounded-xl border border-dashed border-primary-500/30">
                    View All Activity
                </button>
            </div>
        </div>

        {{-- Side Column --}}
        <div class="space-y-10">
            {{-- Category Breakdown --}}
            <div class="card p-8">
                <h4 class="text-xl font-bold text-slate-800 dark:text-white mb-6">Popular Categories</h4>
                <div class="space-y-5">
                    @foreach([
                        ['name' => 'Electronics', 'count' => 125, 'percentage' => 45, 'color' => 'primary'],
                        ['name' => 'Fashion', 'count' => 84, 'percentage' => 30, 'color' => 'indigo'],
                        ['name' => 'Home & Living', 'count' => 42, 'percentage' => 15, 'color' => 'purple'],
                        ['name' => 'Others', 'count' => 28, 'percentage' => 10, 'color' => 'slate'],
                    ] as $category)
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-bold text-slate-700 dark:text-slate-300">{{ $category['name'] }}</span>
                                <span class="text-xs font-extrabold text-slate-500">{{ $category['count'] }} sold</span>
                            </div>
                            <div class="w-full bg-slate-100 dark:bg-slate-800 rounded-full h-2.5">
                                <div class="bg-{{ $category['color'] }}-500 h-2.5 rounded-full transition-all duration-1000" style="width: {{ $category['percentage'] }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Support Card --}}
            <div class="bg-gradient-to-br from-primary-600 to-indigo-700 rounded-3xl p-8 shadow-2xl relative overflow-hidden group">
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
                <div class="relative z-10">
                    <h4 class="text-2xl font-extrabold text-white leading-tight">Professional Support 24/7</h4>
                    <p class="text-primary-100 text-sm mt-3 font-medium opacity-90 leading-relaxed">Need help with your management panel? Our expert team is ready to assist you any time.</p>
                    <button class="mt-6 w-full bg-white text-primary-700 font-extrabold py-3.5 rounded-2xl shadow-xl hover:shadow-2xl hover:scale-105 transition-all text-sm uppercase tracking-widest">
                        Contact Support
                    </button>
                </div>
                <div class="absolute -left-5 -bottom-5 w-24 h-24 bg-indigo-500/20 rounded-full blur-2xl"></div>
            </div>
            
            {{-- Quick Settings --}}
            <div class="card p-8">
                <h4 class="text-xl font-bold text-slate-800 dark:text-white mb-6">Quick Actions</h4>
                <div class="grid grid-cols-2 gap-4">
                    <button class="flex flex-col items-center justify-center p-4 rounded-2xl bg-slate-50 dark:bg-slate-800 hover:bg-primary-500/10 transition-all border border-slate-100 dark:border-slate-700 border-dashed group">
                        <div class="p-3 bg-white dark:bg-slate-900 rounded-xl shadow-sm mb-3 group-hover:text-primary-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            </svg>
                        </div>
                        <span class="text-xs font-bold text-slate-600 dark:text-slate-400">Settings</span>
                    </button>
                    <button class="flex flex-col items-center justify-center p-4 rounded-2xl bg-slate-50 dark:bg-slate-800 hover:bg-emerald-500/10 transition-all border border-slate-100 dark:border-slate-700 border-dashed group">
                        <div class="p-3 bg-white dark:bg-slate-900 rounded-xl shadow-sm mb-3 group-hover:text-emerald-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                        <span class="text-xs font-bold text-slate-600 dark:text-slate-400">View Shop</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection