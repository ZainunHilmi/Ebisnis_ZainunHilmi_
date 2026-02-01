<?php

/**
 * Session Isolation Test Script - DYNAMIC SESSION COOKIE VERSION
 * 
 * Test dual session isolation between admin and user panels with dynamic cookies
 * 
 * Usage: php test-dynamic-session-isolation.php
 */

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Foundation\Application;

// Initialize Laravel application
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "========================================\n";
echo "DYNAMIC SESSION ISOLATION TEST SUITE\n";
echo "========================================\n\n";

$tests = [];
$passed = 0;
$failed = 0;

// Test 1: Check DynamicSessionCookie middleware exists
echo "Test 1: DynamicSessionCookie middleware exists\n";
$middlewarePath = __DIR__ . '/app/Http/Middleware/DynamicSessionCookie.php';
if (file_exists($middlewarePath)) {
    echo "✓ PASS: DynamicSessionCookie middleware found\n";
    $tests[] = ['name' => 'DynamicSessionCookie exists', 'status' => 'PASS'];
    $passed++;
} else {
    echo "✗ FAIL: DynamicSessionCookie middleware not found\n";
    $tests[] = ['name' => 'DynamicSessionCookie exists', 'status' => 'FAIL'];
    $failed++;
}
echo "\n";

// Test 2: Check bootstrap/app.php uses DynamicSessionCookie
echo "Test 2: bootstrap/app.php uses DynamicSessionCookie\n";
$bootstrapContent = file_get_contents(__DIR__ . '/bootstrap/app.php');
if (strpos($bootstrapContent, 'DynamicSessionCookie::class') !== false) {
    // Check order - should be before StartSession
    $dynamicSessionPos = strpos($bootstrapContent, 'DynamicSessionCookie::class');
    $startSessionPos = strpos($bootstrapContent, 'StartSession::class');
    if ($dynamicSessionPos !== false && $startSessionPos !== false && $dynamicSessionPos < $startSessionPos) {
        echo "✓ PASS: DynamicSessionCookie properly configured before StartSession\n";
        $tests[] = ['name' => 'DynamicSessionCookie order', 'status' => 'PASS'];
        $passed++;
    } else {
        echo "✗ FAIL: DynamicSessionCookie should be before StartSession\n";
        $tests[] = ['name' => 'DynamicSessionCookie order', 'status' => 'FAIL'];
        $failed++;
    }
} else {
    echo "✗ FAIL: DynamicSessionCookie not found in bootstrap/app.php\n";
    $tests[] = ['name' => 'DynamicSessionCookie order', 'status' => 'FAIL'];
    $failed++;
}
echo "\n";

// Test 3: Check auth.php has separate guards
echo "Test 3: Separate guards configuration\n";
$authConfig = file_get_contents(__DIR__ . '/config/auth.php');
if (strpos($authConfig, "'admin'") !== false && 
    strpos($authConfig, "'user'") !== false &&
    strpos($authConfig, "'admin_session'") !== false &&
    strpos($authConfig, "'user_session'") !== false) {
    echo "✓ PASS: Separate guards with different session cookies found\n";
    $tests[] = ['name' => 'Separate guards', 'status' => 'PASS'];
    $passed++;
} else {
    echo "✗ FAIL: Separate guards configuration incomplete\n";
    $tests[] = ['name' => 'Separate guards', 'status' => 'FAIL'];
    $failed++;
}
echo "\n";

// Test 4: Check environment variables
echo "Test 4: Environment variables\n";
$requiredEnv = [
    'SESSION_DRIVER',
    'SESSION_LIFETIME',
    'SESSION_SECURE_COOKIE'
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

// Test 5: Check migration exists
echo "Test 5: Session migration\n";
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

// Test 6: Check routes configuration
echo "Test 6: Routes configuration\n";
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

// Test 7: Check Auth Controller handles dynamic sessions
echo "Test 7: Auth Controller handles dynamic sessions\n";
$authControllerContent = file_get_contents(__DIR__ . '/app/Http/Controllers/Auth/AuthenticatedSessionController.php');
if (strpos($authControllerContent, 'panel_context') !== false && 
    strpos($authControllerContent, 'regenerate(false)') !== false) {
    echo "✓ PASS: Auth Controller has dynamic session handling\n";
    $tests[] = ['name' => 'Auth Controller dynamic sessions', 'status' => 'PASS'];
    $passed++;
} else {
    echo "✗ FAIL: Auth Controller missing dynamic session handling\n";
    $tests[] = ['name' => 'Auth Controller dynamic sessions', 'status' => 'FAIL'];
    $failed++;
}
echo "\n";

// Test 8: Check VerifyCsrfToken handles dual tokens
echo "Test 8: VerifyCsrfToken handles dual tokens\n";
$csrfContent = file_get_contents(__DIR__ . '/app/Http/Middleware/VerifyCsrfToken.php');
if (strpos($csrfContent, 'getTokenFromRequestWithPanel') !== false && 
    strpos($csrfContent, 'XSRF-TOKEN-ADMIN') !== false &&
    strpos($csrfContent, 'panel_context') !== false) {
    echo "✓ PASS: VerifyCsrfToken handles dual tokens\n";
    $tests[] = ['name' => 'CSRF dual tokens', 'status' => 'PASS'];
    $passed++;
} else {
    echo "✗ FAIL: VerifyCsrfToken missing dual token handling\n";
    $tests[] = ['name' => 'CSRF dual tokens', 'status' => 'FAIL'];
    $failed++;
}
echo "\n";

// Test 9: Check DynamicSessionCookie has proper detection
echo "Test 9: DynamicSessionCookie route detection\n";
$sessionMiddlewareContent = file_get_contents(__DIR__ . '/app/Http/Middleware/DynamicSessionCookie.php');
if (strpos($sessionMiddlewareContent, 'admin_session') !== false && 
    strpos($sessionMiddlewareContent, 'user_session') !== false &&
    strpos($sessionMiddlewareContent, 'isAdminRoute') !== false) {
    echo "✓ PASS: DynamicSessionCookie has proper route detection\n";
    $tests[] = ['name' => 'DynamicSessionCookie detection', 'status' => 'PASS'];
    $passed++;
} else {
    echo "✗ FAIL: DynamicSessionCookie missing proper detection\n";
    $tests[] = ['name' => 'DynamicSessionCookie detection', 'status' => 'FAIL'];
    $failed++;
}
echo "\n";

// Test 10: Check package.json has vercel-build
echo "Test 10: Vercel build script\n";
$packageContent = file_get_contents(__DIR__ . '/package.json');
$packageData = json_decode($packageContent, true);
if (isset($packageData['scripts']['vercel-build']) && 
    strpos($packageData['scripts']['vercel-build'], 'migrate --force') !== false) {
    echo "✓ PASS: Vercel build script configured\n";
    $tests[] = ['name' => 'Vercel build script', 'status' => 'PASS'];
    $passed++;
} else {
    echo "✗ FAIL: Vercel build script missing or incorrect\n";
    $tests[] = ['name' => 'Vercel build script', 'status' => 'FAIL'];
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
    echo "Dynamic Session Isolation Architecture:\n";
    echo "┌─────────────────────────────────────────┐\n";
    echo "│              BROWSER                  │\n";
    echo "├─────────────────────────────────────────┤\n";
    echo "│ Admin Tab: /admin/dashboard        │\n";
    echo "│ ├── Cookie: admin_session          │\n";
    echo "│ ├── Path: /admin                  │\n";
    echo "│ └── CSRF: XSRF-TOKEN-ADMIN       │\n";
    echo "│                                   │\n";
    echo "│ User Tab: /user/dashboard         │\n";
    echo "│ ├── Cookie: user_session           │\n";
    echo "│ ├── Path: /                      │\n";
    echo "│ └── CSRF: XSRF-TOKEN             │\n";
    echo "└─────────────────────────────────────────┘\n\n";
    
    echo "Next steps:\n";
    echo "1. Run migrations: php artisan migrate\n";
    echo "2. Clear caches: php artisan cache:clear && php artisan config:clear\n";
    echo "3. Deploy to Vercel\n";
    echo "4. Test dual login:\n";
    echo "   - Tab 1: Login as admin at /admin/dashboard\n";
    echo "   - Tab 2: Login as user at /user/dashboard\n";
    echo "5. Check different session IDs and no 419 errors\n";
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
