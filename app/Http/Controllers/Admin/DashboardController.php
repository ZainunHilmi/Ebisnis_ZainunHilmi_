<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // Contoh data dummy — ganti dengan query Eloquent aslinya nanti
        $totalOrders = 1234;
        $activeSellers = 87;
        $totalRevenue = 'Rp 120.000.000';

        return view('admin.dashboard', compact('totalOrders','activeSellers','totalRevenue'));
    }
}
