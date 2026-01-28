<?php

/**
 * Seed Database Endpoint for Vercel
 * Access via: /seed-db?secret=YOUR_SECRET_KEY
 * 
 * This creates the test users defined in DatabaseSeeder
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: text/html; charset=utf-8');

// Security check - require secret parameter
$secret = $_GET['secret'] ?? '';
$expectedSecret = getenv('SEED_SECRET') ?: 'ebisnis2026';

if ($secret !== $expectedSecret) {
    http_response_code(403);
    die('Forbidden: Invalid secret parameter. Usage: /seed-db?secret=YOUR_SECRET');
}

echo "<h1>🌱 Database Seeder for Vercel</h1>";

try {
    // Bootstrap Laravel
    define('LARAVEL_START', microtime(true));

    $viewsDir = '/tmp/views';
    if (!is_dir($viewsDir)) {
        @mkdir($viewsDir, 0755, true);
    }

    require __DIR__ . '/../vendor/autoload.php';
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

    echo "<h2>✅ Laravel Bootstrapped Successfully</h2>";

    // Check database connection
    $connection = \Illuminate\Support\Facades\DB::connection();
    $connection->getPdo();
    echo "<p>✅ Database connected: " . $connection->getDatabaseName() . "</p>";

    // Run seeders
    echo "<h2>🚀 Running Seeders...</h2>";

    $seeder = new \Database\Seeders\DatabaseSeeder();
    $seeder->run();

    echo "<p>✅ DatabaseSeeder executed successfully!</p>";

    // Verify users were created
    echo "<h2>📋 Verifying Users...</h2>";

    $users = \App\Models\User::all(['id', 'name', 'email', 'role']);

    echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
    echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th></tr>";

    foreach ($users as $user) {
        echo "<tr>";
        echo "<td>{$user->id}</td>";
        echo "<td>{$user->name}</td>";
        echo "<td>{$user->email}</td>";
        echo "<td>{$user->role}</td>";
        echo "</tr>";
    }

    echo "</table>";

    // Verify password works
    echo "<h2>🔐 Testing Password Hash...</h2>";

    $testUser = \App\Models\User::where('email', 'admin@example.com')->first();
    if ($testUser) {
        $passwordWorks = \Illuminate\Support\Facades\Hash::check('password', $testUser->password);
        echo "<p>" . ($passwordWorks ? "✅ Password 'password' works for admin@example.com!" : "❌ Password verification failed!") . "</p>";
    } else {
        echo "<p>⚠️ admin@example.com not found in database</p>";
    }

    // Check products
    echo "<h2>📦 Products in Database...</h2>";
    $products = \App\Models\Product::all(['id', 'name', 'price', 'stock']);

    echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
    echo "<tr><th>ID</th><th>Name</th><th>Price</th><th>Stock</th></tr>";

    foreach ($products as $product) {
        echo "<tr>";
        echo "<td>{$product->id}</td>";
        echo "<td>{$product->name}</td>";
        echo "<td>Rp " . number_format($product->price, 0, ',', '.') . "</td>";
        echo "<td>{$product->stock}</td>";
        echo "</tr>";
    }

    echo "</table>";

    echo "<h2>🎉 Seeding Complete!</h2>";
    echo "<p><strong>You can now login with:</strong></p>";
    echo "<ul>";
    echo "<li><strong>Admin:</strong> admin@example.com / password</li>";
    echo "<li><strong>User:</strong> testuser@example.com / password</li>";
    echo "</ul>";
    echo "<p><a href='/login'>Go to Login Page →</a></p>";

} catch (\Throwable $e) {
    echo "<h2>❌ Error</h2>";
    echo "<pre style='background: #fee; padding: 20px; border-radius: 5px;'>";
    echo "Error: " . $e->getMessage() . "\n\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n\n";
    echo "Trace:\n" . $e->getTraceAsString();
    echo "</pre>";
}
