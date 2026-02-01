<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Verify CSRF Token - DUAL SESSION VERSION
 * 
 * This middleware handles CSRF token validation for both admin and user panels
 * with different session cookies and CSRF tokens.
 * 
 * - Admin: XSRF-TOKEN-ADMIN, admin_session cookie
 * - User: XSRF-TOKEN, user_session cookie
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

        // Get panel context from request attributes (set by DynamicSessionCookie)
        $panelContext = $request->attributes->get('panel_context', 'user');
        $isAdmin = $panelContext === 'admin';

        // Get CSRF token from appropriate sources based on panel
        $token = $this->getTokenFromRequestWithPanel($request, $isAdmin);
        
        // Validate token against current session
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
     * Get CSRF token from request with panel awareness
     * Enhanced to handle both admin and user CSRF tokens
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  bool  $isAdmin
     * @return string|null
     */
    protected function getTokenFromRequestWithPanel($request, bool $isAdmin): ?string
    {
        // Determine expected CSRF cookie name based on panel
        $csrfCookieName = $isAdmin ? 'XSRF-TOKEN-ADMIN' : 'XSRF-TOKEN';
        
        // 1. Check _token input (form submissions)
        $token = $request->input('_token');
        if ($token) return $token;
        
        // 2. Check header X-CSRF-TOKEN
        $token = $request->header('X-CSRF-TOKEN');
        if ($token) return $token;
        
        // 3. Check header X-XSRF-TOKEN
        $token = $request->header('X-XSRF-TOKEN');
        if ($token) return $token;
        
        // 4. Check panel-specific CSRF cookie
        $token = $request->cookie($csrfCookieName);
        if ($token) return $token;
        
        // 5. Fallback: check both cookies
        if (!$isAdmin) {
            // Check admin cookie for user panel (edge case)
            $token = $request->cookie('XSRF-TOKEN-ADMIN');
            if ($token) return $token;
        } else {
            // Check user cookie for admin panel (edge case)
            $token = $request->cookie('XSRF-TOKEN');
            if ($token) return $token;
        }
        
        return null;
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
     * Enhanced to set panel-specific CSRF cookies
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Symfony\Component\HttpFoundation\Response  $response
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function addCookieToResponse($request, $response)
    {
        // Get panel context from request attributes
        $panelContext = $request->attributes->get('panel_context', 'user');
        $isAdmin = $panelContext === 'admin';
        
        // Set cookie name and path based on panel
        $cookieName = $isAdmin ? 'XSRF-TOKEN-ADMIN' : 'XSRF-TOKEN';
        $cookiePath = $isAdmin ? '/admin' : '/';
        
        // Create CSRF cookie with panel-specific settings
        $cookie = new \Symfony\Component\HttpFoundation\Cookie(
            $cookieName,
            $request->session()->token(),
            time() + 60 * 120, // 120 minutes
            $cookiePath,
            null,
            true,   // secure
            false,  // NOT httpOnly (must be accessible to JavaScript)
            false,
            $isAdmin ? 'strict' : 'lax'
        );
        
        $response->headers->setCookie($cookie);
        
        return $response;
    }
}
