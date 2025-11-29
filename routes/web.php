<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ==========================
// Redirect root → login
// ==========================
Route::get('/', function () {
    return redirect('/login');
});

// ==========================
// USER ROUTES
// ==========================
Route::middleware([
    'auth',
    \App\Http\Middleware\IsUser::class
])->prefix('user')->name('user.')->group(function () {

    Route::get('/dashboard', function () {
        $products = \App\Models\Product::latest()->get();
        return view('user.dashboard', compact('products'));
    })->name('dashboard');

    Route::get('/products/{product}', function (\App\Models\Product $product) {
        return view('user.products.show', compact('product'));
    })->name('products.show');

    // User Product Management (CRUD)
    Route::resource('my-products', \App\Http\Controllers\User\UserProductController::class)
        ->parameters(['my-products' => 'product']);

});

// ==========================
// ADMIN ROUTES
// ==========================
Route::middleware([
    'auth',
    'is_admin'
])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', function () {
        $totalUsers = \App\Models\User::count();
        $totalProducts = \App\Models\Product::count();
        return view('admin.dashboard', compact('totalUsers', 'totalProducts'));
    })->name('dashboard');

    // User Management
    Route::resource('users', \App\Http\Controllers\Admin\AdminUserController::class);

    // Product Management
    Route::resource('products', \App\Http\Controllers\Admin\AdminProductController::class);
});

// ==========================
// PROFILE (default Breeze)
// ==========================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==========================
// Auth routes (Breeze)
// ==========================
require __DIR__ . '/auth.php';
