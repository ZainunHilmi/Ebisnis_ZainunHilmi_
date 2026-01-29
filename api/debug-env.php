<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = \Illuminate\Http\Request::capture()
);

echo "<h1>Environment Debug</h1>";
echo "<p><strong>DB_CONNECTION:</strong> " . env('DB_CONNECTION', 'NOT SET') . "</p>";
echo "<p><strong>DB_HOST:</strong> " . env('DB_HOST', 'NOT SET') . "</p>";
echo "<p><strong>Default Config:</strong> " . config('database.default') . "</p>";
echo "<p><strong>Config DB Host:</strong> " . config('database.connections.mysql.host') . "</p>";

if (env('DB_CONNECTION') !== 'mysql') {
    echo "<h3 style='color:red'>CRITICAL: DB_CONNECTION is NOT 'mysql'. Please check Vercel Environment Variables.</h3>";
} else {
    echo "<h3 style='color:green'>OK: DB_CONNECTION is set to 'mysql'.</h3>";
}
