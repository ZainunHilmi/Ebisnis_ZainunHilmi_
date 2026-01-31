<?php

/**
 * Session Isolation Test Script
 * 
 * Test dual session isolation between admin and user panels
 * Run this script to verify session isolation is working correctly
 * 
 * Usage: php test-session-isolation.php
 */

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Foundation\Application;

// Initialize Laravel application
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "========================================\n";
echo "SESSION ISOLATION TEST SUITE\n";
echo "========================================\n\n";

$tests = [];
$passed = 0;
$failed = 0;

// Test 1: Check SessionIsolator middleware exists
echo "Test 1: SessionIsolator middleware exists\n";
$middlewarePath = __DIR__ . '/app/Http/Middleware/SessionIsolator.php';
if (file_exists($middlewarePath)) {
    echo "✓ PASS: SessionIsolator middleware found\n";
    $tests[] = ['name' => 'SessionIsolator exists', 'status' => 'PASS'];
    $passed++;
} else {
    echo "✗ FAIL: SessionIsolator middleware not found\n";
    $tests[] = ['name' => 'SessionIsolator exists', 'status' => 'FAIL'];
    $failed++;
}
echo "\n";

// Test 2: Check VerifyCsrfToken middleware exists
echo "Test 2: VerifyCsrfToken middleware exists\n";
$csrfPath = __DIR__ . '/app/Http/Middleware/VerifyCsrfToken.php';
if (file_exists($csrfPath)) {
    echo "✓ PASS: VerifyCsrfToken middleware found\n";
    $tests[] = ['name' => 'VerifyCsrfToken exists', 'status' => 'PASS'];
    $passed++;
} else {
    echo "✗ FAIL: VerifyCsrfToken middleware not found\n";
    $tests[] = ['name' => 'VerifyCsrfToken exists', 'status' => 'FAIL'];
    $failed++;
}
echo "\n";

// Test 3: Check Kernel has SessionIsolator in middleware groups
echo "Test 3: Kernel middleware configuration\n";
$kernelContent = file_get_contents(__DIR__ . '/app/Http/Kernel.php');
if (strpos($kernelContent, 'SessionIsolator') !== false) {
    echo "✓ PASS: SessionIsolator registered in Kernel\n";
    $tests[] = ['name' => 'Kernel configuration', 'status' => 'PASS'];
    $passed++;
} else {
    echo "✗ FAIL: SessionIsolator not found in Kernel\n";
    $tests[] = ['name' => 'Kernel configuration', 'status' => 'FAIL'];
    $failed++;
}
echo "\n";

// Test 4: Check auth.php has multi-guard setup
echo "Test 4: Multi-guard authentication setup\n";
$authConfig = file_get_contents(__DIR__ . '/config/auth.php');
if (strpos($authConfig, "'admin'") !== false && strpos($authConfig, "'user'") !== false) {
    echo "✓ PASS: Multi-guard configuration found\n";
    $tests[] = ['name' => 'Multi-guard setup', 'status' => 'PASS'];
    $passed++;
} else {
    echo "✗ FAIL: Multi-guard configuration incomplete\n";
    $tests[] = ['name' => 'Multi-guard setup', 'status' => 'FAIL'];
    $failed++;
}
echo "\n";

// Test 5: Check environment variables
echo "Test 5: Environment variables\n";
$requiredEnv = [
    'SESSION_DRIVER',
    'SESSION_COOKIE',
    'ADMIN_SESSION_COOKIE',
    'SESSION_SECURE_COOKIE'
];
$envFile = file_get_contents(__DIR__ . '/.env.example');
$allEnvPresent = true;
foreach ($requiredEnv as $env) {
    if (strpos($envFile, $env) === false) {
        echo "✗ FAIL: Missing env variable: $env\n";
        $allEnvPresent = false;
    }
}
if ($allEnvPresent) {
    echo "✓ PASS: All required environment variables found\n";
    $tests[] = ['name' => 'Environment variables', 'status' => 'PASS'];
    $passed++;
} else {
    $tests[] = ['name' => 'Environment variables', 'status' => 'FAIL'];
    $failed++;
}
echo "\n";

// Test 6: Check migration exists
echo "Test 6: Session migration\n";
$migrationExists = false;
$migrations = glob(__DIR__ . '/database/migrations/*_add_panel_context_to_sessions_table.php');
if (count($migrations) > 0) {
    echo "✓ PASS: Panel context migration found\n";
    $tests[] = ['name' => 'Session migration', 'status' => 'PASS'];
    $passed++;
} else {
    echo "✗ FAIL: Panel context migration not found\n";
    $tests[] = ['name' => 'Session migration', 'status' => 'FAIL'];
    $failed++;
}
echo "\n";

// Test 7: Check vercel.json configuration
echo "Test 7: Vercel configuration\n";
$vercelConfig = file_get_contents(__DIR__ . '/vercel.json');
$vercelData = json_decode($vercelConfig, true);
if (json_last_error() === JSON_ERROR_NONE) {
    if (isset($vercelData['env']['SESSION_DRIVER']) && 
        isset($vercelData['env']['ADMIN_SESSION_COOKIE'])) {
        echo "✓ PASS: Vercel.json properly configured\n";
        $tests[] = ['name' => 'Vercel configuration', 'status' => 'PASS'];
        $passed++;
    } else {
        echo "✗ FAIL: Vercel.json missing session configuration\n";
        $tests[] = ['name' => 'Vercel configuration', 'status' => 'FAIL'];
        $failed++;
    }
} else {
    echo "✗ FAIL: Vercel.json is not valid JSON\n";
    $tests[] = ['name' => 'Vercel configuration', 'status' => 'FAIL'];
    $failed++;
}
echo "\n";

// Test 8: Check routes configuration
echo "Test 8: Routes configuration\n";
$routesContent = file_get_contents(__DIR__ . '/routes/web.php');
if (strpos($routesContent, 'is_admin') !== false && 
    strpos($routesContent, 'IsUser') !== false) {
    echo "✓ PASS: Routes properly configured with middleware\n";
    $tests[] = ['name' => 'Routes configuration', 'status' => 'PASS'];
    $passed++;
} else {
    echo "✗ FAIL: Routes missing proper middleware\n";
    $tests[] = ['name' => 'Routes configuration', 'status' => 'FAIL'];
    $failed++;
}
echo "\n";

// Summary
echo "========================================\n";
echo "TEST SUMMARY\n";
echo "========================================\n";
echo "Total Tests: " . count($tests) . "\n";
echo "Passed: $passed\n";
echo "Failed: $failed\n";
echo "========================================\n\n";

if ($failed === 0) {
    echo "✓ ALL TESTS PASSED!\n\n";
    echo "Next steps:\n";
    echo "1. Run migrations: php artisan migrate\n";
    echo "2. Deploy to Vercel\n";
    echo "3. Test with two browsers/tabs:\n";
    echo "   - Tab 1: example.com/admin/login (login as admin)\n";
    echo "   - Tab 2: example.com/login (login as user)\n";
    echo "4. Refresh both tabs - should stay logged in\n";
    exit(0);
} else {
    echo "✗ SOME TESTS FAILED\n";
    echo "\nFailed tests:\n";
    foreach ($tests as $test) {
        if ($test['status'] === 'FAIL') {
            echo "  - {$test['name']}\n";
        }
    }
    exit(1);
}
