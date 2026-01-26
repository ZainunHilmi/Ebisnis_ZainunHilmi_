<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Vercel Environment Diagnostic</h1>";

echo "<h2>Paths</h2>";
echo "Current Dir: " . __DIR__ . "<br>";
echo "Real Root: " . realpath(__DIR__ . '/..') . "<br>";

echo "<h2>File Existence</h2>";
$checks = [
    '../vendor/autoload.php',
    '../bootstrap/app.php',
    '../config/app.php',
    '../config/view.php',
    '../isrgrootx1.pem'
];

foreach ($checks as $file) {
    echo "$file: " . (file_exists(__DIR__ . '/' . $file) ? "✅ EXISTS" : "❌ MISSING") . " (" . realpath(__DIR__ . '/' . $file) . ")<br>";
}

echo "<h2>Root Directory Contents</h2>";
echo "<pre>";
print_r(scandir(__DIR__ . '/..'));
echo "</pre>";

echo "<h2>Vendor Directory Contents (snippet)</h2>";
if (is_dir(__DIR__ . '/../vendor')) {
    echo "<pre>";
    print_r(array_slice(scandir(__DIR__ . '/../vendor'), 0, 20));
    echo "</pre>";
} else {
    echo "❌ vendor directory NOT FOUND!";
}

echo "<h2>Environment Variables</h2>";
echo "APP_ENV: " . getenv('APP_ENV') . "<br>";
echo "DB_HOST: " . (getenv('DB_HOST') ? "✅ SET" : "❌ NOT SET") . "<br>";

echo "<h2>Try simple Laravel Bootstrap</h2>";
try {
    require __DIR__ . '/../vendor/autoload.php';
    echo "✅ Autoloader loaded.<br>";

    $app = require_once __DIR__ . '/../bootstrap/app.php';
    echo "✅ App bootstrapped.<br>";
    echo "Laravel Version: " . $app->version() . "<br>";

    echo "Binding [view] check: " . ($app->bound('view') ? "✅ BOUND" : "❌ NOT BOUND") . "<br>";
} catch (Exception $e) {
    echo "❌ Bootstrap Failed: " . $e->getMessage() . "<br>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
echo "<h2>End of Diagnostic</h2>";
