<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;
use Symfony\Component\HttpFoundation\Response;

/**
 * Verify CSRF Token - SIMPLIFIED VERSION
 * 
 * Menggunakan session yang sudah terisolasi oleh SessionIsolation middleware.
 * Tidak perlu detect panel lagi karena session sudah terpisah.
 * Cukup validasi token dari session yang aktif.
 */
class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Skip CSRF for read-only requests
        if ($this->isReading($request)) {
            return $this->addCookieToResponse($request, $next($request));
        }

        // Get token from request
        $token = $this->getTokenFromRequest($request);
        
        // Validate token against current session
        // Session sudah terisolasi oleh SessionIsolation middleware
        if ($this->validateToken($token, $request)) {
            return $this->addCookieToResponse($request, $next($request));
        }

        // Token mismatch
        throw new \Illuminate\Session\TokenMismatchException('CSRF token mismatch.');
    }

    /**
     * Check if request is read-only (GET, HEAD, OPTIONS)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function isReading($request): bool
    {
        return in_array($request->method(), ['HEAD', 'GET', 'OPTIONS']);
    }

    /**
     * Get CSRF token from request
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function getTokenFromRequest($request): ?string
    {
        // 1. Check _token input (form submissions)
        $token = $request->input('_token');
        
        // 2. Check header X-CSRF-TOKEN
        if (!$token) {
            $token = $request->header('X-CSRF-TOKEN');
        }
        
        // 3. Check header X-XSRF-TOKEN
        if (!$token) {
            $token = $request->header('X-XSRF-TOKEN');
        }
        
        // 4. Check cookie XSRF-TOKEN
        if (!$token) {
            $token = $request->cookie('XSRF-TOKEN');
        }
        
        // 5. Check cookie XSRF-TOKEN-ADMIN (for admin panel)
        if (!$token) {
            $token = $request->cookie('XSRF-TOKEN-ADMIN');
        }
        
        return is_string($token) ? $token : null;
    }

    /**
     * Check if tokens match
     *
     * @param  string|null  $token
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function validateToken(?string $token, $request): bool
    {
        if (!is_string($token)) {
            return false;
        }
        
        $sessionToken = $request->session()->token();
        
        return hash_equals($sessionToken, $token);
    }

    /**
     * Add CSRF cookie to response
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Symfony\Component\HttpFoundation\Response  $response
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function addCookieToResponse($request, $response)
    {
        // Determine panel context from request
        $isAdmin = $request->attributes->get('panel_context') === 'admin';
        
        // Set cookie name and path based on panel
        $cookieName = $isAdmin ? 'XSRF-TOKEN-ADMIN' : 'XSRF-TOKEN';
        $cookiePath = $isAdmin ? '/admin' : '/';
        
        // Create CSRF cookie
        $cookie = new \Symfony\Component\HttpFoundation\Cookie(
            $cookieName,
            $request->session()->token(),
            time() + 60 * 120, // 120 minutes
            $cookiePath,
            null,
            true,   // secure
            false,  // NOT httpOnly (harus bisa diakses JS)
            false,
            'lax'
        );
        
        $response->headers->setCookie($cookie);
        
        return $response;
    }
}
