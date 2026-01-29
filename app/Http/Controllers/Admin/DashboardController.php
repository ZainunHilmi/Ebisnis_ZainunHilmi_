<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = \App\Models\User::count();
        $totalProducts = \App\Models\Product::count();
        $recentOrders = \App\Models\Order::latest()->take(5)->get();
        $lowStockProducts = \App\Models\Product::where('stock', '<=', 5)->get();
        
        return view('admin.dashboard', compact('totalUsers', 'totalProducts', 'recentOrders', 'lowStockProducts'));
    }
}
