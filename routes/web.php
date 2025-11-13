<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| File ini aman digunakan walau Admin\DashboardController belum dibuat.
| Jika kamu ingin pakai controller, jalankan:
| php artisan make:controller Admin/DashboardController
|
*/

// Redirect root ke /login supaya user langsung diarahkan ke halaman auth
Route::get('/', function () {
    return redirect('/login');
});

// Dashboard user (biasa) - memakai middleware auth & verified (jika kamu pakai email verification)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Routes yang dipakai user terautentikasi (profile)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes — prefix /admin, name admin.*, middleware: auth + is_admin
Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {

    // Jika controller Admin\DashboardController tersedia, gunakan itu.
    if (class_exists(\App\Http\Controllers\Admin\DashboardController::class)) {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    } else {
        // Fallback: jika ada view admin.dashboard, tampilkan; kalau tidak, redirect agar tidak menyebabkan error.
        Route::get('/dashboard', function () {
            if (view()->exists('admin.dashboard')) {
                return view('admin.dashboard');
            }

            // Jika ingin, ubah redirect ini ke halaman lain yang kamu suka
            return redirect('/')->with('error', 'Admin controller belum dibuat. Jalankan: php artisan make:controller Admin/DashboardController');
        })->name('dashboard');
    }

    // contoh resource routes (aktifkan jika sudah buat controller)
    // Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
    // Route::resource('orders', App\Http\Controllers\Admin\OrderController::class);
    // Route::resource('sellers', App\Http\Controllers\Admin\SellerController::class);
});

// Autentikasi (file yang di-generate oleh Breeze/Jetstream/UI)
// Jika kamu menggunakan Breeze/Jetstream, file auth.php sudah disertakan — biarkan seperti ini:
require __DIR__ . '/auth.php';

// Jika proyekmu masih memakai Auth::routes() (lama), hapus salah satunya kalau terjadi duplicate routes.
// Jika butuh, uncomment di bawah ini (biasanya tidak perlu bila pakai Breeze/Jetstream):
// Auth::routes();

// HomeController default (jika kamu punya HomeController)
Route::get('/home', [HomeController::class, 'index'])->name('home');
