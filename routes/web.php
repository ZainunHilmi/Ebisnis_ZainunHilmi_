<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ==========================
// Redirect root → login
// ==========================
Route::get('/', function () {
    if (auth()->check()) {
        $role = strtolower(trim((string) (auth()->user()->role ?? '')));
        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($role === 'user') {
            return redirect()->route('user.dashboard');
        }
        // Fallback for recognized auth but no specific dashboard access
        return redirect()->route('profile.edit')->with('error', 'Role-based dashboard unavailable.');
    }
    return redirect()->route('login');
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
        $user = auth()->user()->load('cartItems');
        return view('user.dashboard', compact('products', 'user'));
    })->name('dashboard');

    Route::get('/products/{product}', function (\App\Models\Product $product) {
        return view('user.products.show', compact('product'));
    })->name('products.show');

    // User Product Management (CRUD)
    Route::resource('my-products', \App\Http\Controllers\User\UserProductController::class)
        ->parameters(['my-products' => 'product']);

    // Cart Routes
    Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [\App\Http\Controllers\CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{id}', [\App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [\App\Http\Controllers\CartController::class, 'destroy'])->name('cart.destroy');

    // Checkout Routes
    Route::get('/checkout', [\App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [\App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout.store');

    // Payment Routes
    Route::get('/payment/{order}', [\App\Http\Controllers\PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/{order}', [\App\Http\Controllers\PaymentController::class, 'process'])->name('payment.process');

});

// ==========================
// ADMIN ROUTES
// ==========================
Route::middleware([
    'auth',
    'is_admin'
])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

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
