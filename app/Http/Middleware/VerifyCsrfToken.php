<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;
use Illuminate\Http\Request;

/**
 * Verify CSRF Token - SIMPLIFIED FOR VERCER
 * 
 * Simplified CSRF token validation without custom session handling
 * Using standard Laravel behavior with TrustProxies for HTTPS
 */
class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'login',
        'logout',
        'register',
    ];
}
