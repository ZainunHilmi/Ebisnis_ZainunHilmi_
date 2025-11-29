<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // ambil data ringkasan jika perlu, contoh:
        // $userCount = \App\Models\User::count();
        return view('admin.dashboard'/*, compact('userCount') */);
    }
}
