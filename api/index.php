<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: text/plain');
echo "DEEP DIAGNOSTIC - Laravel Core Services\n\n";

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';

echo "1. Laravel Version: " . $app->version() . "\n";
echo "2. ViewServiceProvider Check:\n";
$providerClass = \Illuminate\View\ViewServiceProvider::class;
echo "   - Class Name: $providerClass\n";
echo "   - Class Exists: " . (class_exists($providerClass) ? "✅" : "❌") . "\n";

echo "3. Binding Status [initial]:\n";
echo "   - [view] bound: " . ($app->bound('view') ? "✅" : "❌") . "\n";
echo "   - [config] bound: " . ($app->bound('config') ? "✅" : "❌") . "\n";

if (!$app->bound('view') && class_exists($providerClass)) {
    echo "\n4. Attempting MANUAL registration of ViewServiceProvider...\n";
    try {
        $app->register(new $providerClass($app));
        echo "   - Manual registration completed.\n";
        echo "   - [view] bound NOW: " . ($app->bound('view') ? "✅" : "❌") . "\n";
    } catch (\Throwable $e) {
        echo "   - Manual registration FAILED: " . $e->getMessage() . "\n";
    }
}

echo "\n5. Active Service Providers:\n";
$providers = array_keys($app->getLoadedProviders());
foreach ($providers as $p) {
    echo "   - $p\n";
}

echo "\n6. Final Test - Resolving 'view':\n";
try {
    $view = $app->make('view');
    echo "   - ✅ Successfully resolved 'view' service!\n";
} catch (\Throwable $e) {
    echo "   - ❌ Failed to resolve 'view': " . $e->getMessage() . "\n";
}

echo "\n--- END OF DEEP DIAGNOSTIC ---\n";
