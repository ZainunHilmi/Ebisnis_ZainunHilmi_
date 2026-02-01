<?php

/**
 * Session Isolation Test Script - UPDATED
 * 
 * This script tests the dual session isolation between admin and user panels.
 * Run this after implementing the fixes to verify everything works correctly.
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

// Test 1: Check SessionIsolation middleware exists (renamed from SessionIsolator)
echo "Test 1: SessionIsolation middleware exists\n";
$middlewarePath = __DIR__ . '/app/Http/Middleware/SessionIsolation.php';
if (file_exists($middlewarePath)) {
    echo "✓ PASS: SessionIsolation middleware found\n";
    $tests[] = ['name' => 'SessionIsolation exists', 'status' => 'PASS'];
    $passed++;
} else {
    echo "✗ FAIL: SessionIsolation middleware not found\n";
    $tests[] = ['name' => 'SessionIsolation exists', 'status' => 'FAIL'];
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

// Test 3: Check bootstrap/app.php has SessionIsolation in middleware groups
echo "Test 3: bootstrap/app.php middleware configuration\n";
$bootstrapContent = file_get_contents(__DIR__ . '/bootstrap/app.php');
if (strpos($bootstrapContent, 'SessionIsolation::class') !== false &&
    strpos($bootstrapContent, 'StartSession::class') !== false) {
    // Check order - SessionIsolation should be before StartSession
    $sessionIsoPos = strpos($bootstrapContent, 'SessionIsolation::class');
    $startSessionPos = strpos($bootstrapContent, 'StartSession::class');
    if ($sessionIsoPos !== false && $startSessionPos !== false && $sessionIsoPos < $startSessionPos) {
        echo "✓ PASS: SessionIsolation properly configured before StartSession\n";
        $tests[] = ['name' => 'bootstrap/app.php configuration', 'status' => 'PASS'];
        $passed++;
    } else {
        echo "✗ FAIL: SessionIsolation should be before StartSession\n";
        $tests[] = ['name' => 'bootstrap/app.php configuration', 'status' => 'FAIL'];
        $failed++;
    }
} else {
    echo "✗ FAIL: SessionIsolation or StartSession not found in bootstrap/app.php\n";
    $tests[] = ['name' => 'bootstrap/app.php configuration', 'status' => 'FAIL'];
    $failed++;
}
echo "\n";

// Test 4: Check auth.php has proper middleware setup
echo "Test 4: Auth routes middleware setup\n";
$authRoutesContent = file_get_contents(__DIR__ . '/routes/auth.php');
if (strpos($authRoutesContent, "Route::middleware('guest.redirect')") !== false ||
    strpos($authRoutesContent, "Route::middleware(['guest.redirect'])") !== false) {
    echo "✓ PASS: Auth routes use guest.redirect middleware\n";
    $tests[] = ['name' => 'Auth routes middleware', 'status' => 'PASS'];
    $passed++;
} else {
    echo "✗ FAIL: Auth routes missing guest.redirect middleware\n";
    $tests[] = ['name' => 'Auth routes middleware', 'status' => 'FAIL'];
    $failed++;
}
echo "\n";

// Test 5: Check multi-guard authentication setup
echo "Test 5: Multi-guard authentication setup\n";
$authConfig = file_get_contents(__DIR__ . '/config/auth.php');
if (strpos($authConfig, "'admin'") !== false && 
    strpos($authConfig, "'user'") !== false &&
    strpos($authConfig, "'laravel_admin_session'") !== false) {
    echo "✓ PASS: Multi-guard configuration found with admin session cookie\n";
    $tests[] = ['name' => 'Multi-guard setup', 'status' => 'PASS'];
    $passed++;
} else {
    echo "✗ FAIL: Multi-guard configuration incomplete\n";
    $tests[] = ['name' => 'Multi-guard setup', 'status' => 'FAIL'];
    $failed++;
}
echo "\n";

// Test 6: Check environment variables
echo "Test 6: Environment variables\n";
$requiredEnv = [
    'SESSION_DRIVER',
    'SESSION_LIFETIME',
    'SESSION_SECURE_COOKIE',
    'ADMIN_SESSION_COOKIE',
    'ADMIN_SESSION_PATH'
];
$envFile = file_get_contents(__DIR__ . '/.env');
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

// Test 7: Check migration exists
echo "Test 7: Session migration\n";
$migrations = glob(__DIR__ . '/database/migrations/*_create_sessions_table.php');
if (count($migrations) > 0) {
    echo "✓ PASS: Sessions table migration found\n";
    $tests[] = ['name' => 'Session migration', 'status' => 'PASS'];
    $passed++;
} else {
    echo "✗ FAIL: Sessions table migration not found\n";
    $tests[] = ['name' => 'Session migration', 'status' => 'FAIL'];
    $failed++;
}
echo "\n";

// Test 8: Check routes configuration
echo "Test 8: Routes configuration\n";
$routesContent = file_get_contents(__DIR__ . '/routes/web.php');
if (strpos($routesContent, "is_admin") !== false && 
    strpos($routesContent, "IsUser") !== false &&
    strpos($routesContent, "prefix('user')") !== false &&
    strpos($routesContent, "prefix('admin')") !== false) {
    echo "✓ PASS: Routes properly configured with middleware and prefixes\n";
    $tests[] = ['name' => 'Routes configuration', 'status' => 'PASS'];
    $passed++;
} else {
    echo "✗ FAIL: Routes missing proper middleware or prefixes\n";
    $tests[] = ['name' => 'Routes configuration', 'status' => 'FAIL'];
    $failed++;
}
echo "\n";

// Test 9: Check AuthenticatedSessionController has isolation logic
echo "Test 9: Auth Controller isolation logic\n";
$authControllerContent = file_get_contents(__DIR__ . '/app/Http/Controllers/Auth/AuthenticatedSessionController.php');
if (strpos($authControllerContent, 'session_initiated') !== false && 
    strpos($authControllerContent, 'user_role') !== false &&
    strpos($authControllerContent, 'panel_context') !== false) {
    echo "✓ PASS: Auth Controller has proper session isolation logic\n";
    $tests[] = ['name' => 'Auth Controller isolation', 'status' => 'PASS'];
    $passed++;
} else {
    echo "✗ FAIL: Auth Controller missing session isolation logic\n";
    $tests[] = ['name' => 'Auth Controller isolation', 'status' => 'FAIL'];
    $failed++;
}
echo "\n";

// Test 10: Check SessionIsolation has enhanced detection
echo "Test 10: SessionIsolation enhanced detection\n";
$sessionIsoContent = file_get_contents(__DIR__ . '/app/Http/Middleware/SessionIsolation.php');
if (strpos($sessionIsoContent, 'isAdminRoute') !== false && 
    strpos($sessionIsoContent, 'Auth::check') !== false &&
    strpos($sessionIsoContent, 'intended') !== false) {
    echo "✓ PASS: SessionIsolation has enhanced route detection\n";
    $tests[] = ['name' => 'SessionIsolation detection', 'status' => 'PASS'];
    $passed++;
} else {
    echo "✗ FAIL: SessionIsolation missing enhanced detection\n";
    $tests[] = ['name' => 'SessionIsolation detection', 'status' => 'FAIL'];
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
    echo "2. Clear caches: php artisan cache:clear && php artisan config:clear\n";
    echo "3. Test with two browsers/tabs:\n";
    echo "   - Tab 1: Login as admin at /admin/dashboard\n";
    echo "   - Tab 2: Login as user at /user/dashboard\n";
    echo "4. Check debug endpoints:\n";
    echo "   - /debug-session (should show user panel context)\n";
    echo "   - /admin/debug-session (should show admin panel context)\n";
    echo "5. Both sessions should have different session IDs\n";
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
