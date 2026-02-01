<?php

/**
 * Session Table Test - Verify sessions are being written to database
 * 
 * This script tests if Laravel can write to the sessions table
 * Usage: php test-session-writing.php
 */

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Foundation\Application;

// Initialize Laravel application
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "========================================\n";
echo "SESSION TABLE WRITING TEST\n";
echo "========================================\n\n";

$tests = [];
$passed = 0;
$failed = 0;

// Test 1: Check if sessions table exists
echo "Test 1: Sessions table exists\n";
try {
    \Illuminate\Support\Facades\Schema::hasTable('sessions');
    if (\Illuminate\Support\Facades\Schema::hasTable('sessions')) {
        echo "✓ PASS: Sessions table exists in database\n";
        $tests[] = ['name' => 'Sessions table exists', 'status' => 'PASS'];
        $passed++;
    } else {
        echo "✗ FAIL: Sessions table does not exist\n";
        $tests[] = ['name' => 'Sessions table exists', 'status' => 'FAIL'];
        $failed++;
    }
} catch (\Exception $e) {
    echo "✗ FAIL: Cannot check sessions table - " . $e->getMessage() . "\n";
    $tests[] = ['name' => 'Sessions table exists', 'status' => 'FAIL'];
    $failed++;
}
echo "\n";

// Test 2: Test session writing
echo "Test 2: Session writing capability\n";
try {
    // Test creating a session
    $sessionId = session()->getId();
    
    // Store some test data
    session(['test_key' => 'test_value_' . time()]);
    session()->save();
    
    // Check if session is actually saved
    $sessionInDb = \Illuminate\Support\Facades\DB::table('sessions')
        ->where('id', $sessionId)
        ->first();
        
    if ($sessionInDb) {
        echo "✓ PASS: Session successfully written to database\n";
        $tests[] = ['name' => 'Session writing', 'status' => 'PASS'];
        $passed++;
    } else {
        echo "✗ FAIL: Session not found in database\n";
        $tests[] = ['name' => 'Session writing', 'status' => 'FAIL'];
        $failed++;
    }
    
    // Clean up test data
    session()->forget('test_key');
    
} catch (\Exception $e) {
    echo "✗ FAIL: Cannot write session - " . $e->getMessage() . "\n";
    $tests[] = ['name' => 'Session writing', 'status' => 'FAIL'];
    $failed++;
}
echo "\n";

// Test 3: Test session regeneration
echo "Test 3: Session regeneration\n";
try {
    $oldSessionId = session()->getId();
    session()->regenerate(true);
    $newSessionId = session()->getId();
    
    if ($oldSessionId !== $newSessionId) {
        echo "✓ PASS: Session regeneration works correctly\n";
        $tests[] = ['name' => 'Session regeneration', 'status' => 'PASS'];
        $passed++;
    } else {
        echo "✗ FAIL: Session regeneration failed\n";
        $tests[] = ['name' => 'Session regeneration', 'status' => 'FAIL'];
        $failed++;
    }
    
} catch (\Exception $e) {
    echo "✗ FAIL: Session regeneration error - " . $e->getMessage() . "\n";
    $tests[] = ['name' => 'Session regeneration', 'status' => 'FAIL'];
    $failed++;
}
echo "\n";

// Test 4: Check database connection
echo "Test 4: Database connection\n";
try {
    \Illuminate\Support\Facades\DB::connection()->getPdo();
    echo "✓ PASS: Database connection is working\n";
    $tests[] = ['name' => 'Database connection', 'status' => 'PASS'];
    $passed++;
} catch (\Exception $e) {
    echo "✗ FAIL: Database connection failed - " . $e->getMessage() . "\n";
    $tests[] = ['name' => 'Database connection', 'status' => 'FAIL'];
    $failed++;
}
echo "\n";

// Test 5: Check session driver configuration
echo "Test 5: Session driver configuration\n";
$sessionDriver = config('session.driver');
$sessionSecure = config('session.secure');
$sessionSameSite = config('session.same_site');
$sessionDomain = config('session.domain');

echo "Session Driver: $sessionDriver\n";
echo "Session Secure: " . ($sessionSecure ? 'true' : 'false') . "\n";
echo "Session Same Site: $sessionSameSite\n";
echo "Session Domain: " . ($sessionDomain ?: 'null') . "\n";

if ($sessionDriver === 'database' && $sessionSecure === true && $sessionSameSite === 'lax' && $sessionDomain === null) {
    echo "✓ PASS: Session configuration is correct for Vercel\n";
    $tests[] = ['name' => 'Session configuration', 'status' => 'PASS'];
    $passed++;
} else {
    echo "✗ FAIL: Session configuration is incorrect\n";
    $tests[] = ['name' => 'Session configuration', 'status' => 'FAIL'];
    $failed++;
}
echo "\n";

// Test 6: Clean up old sessions
echo "Test 6: Clean up test sessions\n";
try {
    $deletedCount = \Illuminate\Support\Facades\DB::table('sessions')
        ->where('payload', 'like', '%test_key%')
        ->delete();
    
    echo "✓ PASS: Cleaned up $deletedCount test sessions\n";
    $tests[] = ['name' => 'Session cleanup', 'status' => 'PASS'];
    $passed++;
    
} catch (\Exception $e) {
    echo "✗ FAIL: Cannot clean up sessions - " . $e->getMessage() . "\n";
    $tests[] = ['name' => 'Session cleanup', 'status' => 'FAIL'];
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
    echo "Session System Status:\n";
    echo "┌─────────────────────────────────┐\n";
    echo "│ ✓ Database Connected          │\n";
    echo "│ ✓ Sessions Table Available   │\n";
    echo "│ ✓ Session Writing Works      │\n";
    echo "│ ✓ Session Regeneration OK   │\n";
    echo "│ ✓ Config Optimized           │\n";
    echo "│ ✓ Cleanup Working           │\n";
    echo "└─────────────────────────────────┘\n\n";
    
    echo "Ready for Vercel deployment!\n";
    echo "Login attempts should now work without 419 errors.\n";
    exit(0);
} else {
    echo "✗ SOME TESTS FAILED\n";
    echo "\nFailed tests:\n";
    foreach ($tests as $test) {
        if ($test['status'] === 'FAIL') {
            echo "  - {$test['name']}\n";
        }
    }
    echo "\nFix these issues before deploying to Vercel.\n";
    exit(1);
}
