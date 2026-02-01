<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Session Isolation Middleware - FIXED VERSION
 * 
 * Mengisolasi session antara panel admin dan user:
 * - Detect route berdasarkan URL path atau intended destination
 * - Set session config (cookie name & path) SEBELUM session start
 * - Gunakan cookie name berbeda: laravel_session (user) vs laravel_admin_session (admin)
 * - Gunakan cookie path berbeda: / (user) vs /admin (admin)
 * 
 * HARUS diletakkan SEBELUM StartSession di middleware stack!
 */
class SessionIsolation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Detect if this is admin panel based on URL path or intended destination
        $isAdmin = $this->isAdminRoute($request);
        
        // Configure session based on panel BEFORE session starts
        $this->configureSession($isAdmin);
        
        // Mark request with panel context for other middleware
        $request->attributes->set('panel_context', $isAdmin ? 'admin' : 'user');
        
        // Process request
        $response = $next($request);
        
        // Ensure cookies are properly configured in response
        $this->configureResponseCookies($response, $isAdmin);
        
        return $response;
    }

    /**
     * Check if current route is admin panel
     * FIXED: Also checks intended destination for login routes
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function isAdminRoute(Request $request): bool
    {
        $path = $request->path();
        
        // Check if URL starts with 'admin/'
        if (str_starts_with($path, 'admin/') || $path === 'admin') {
            return true;
        }
        
        // Check intended destination for login routes
        if ($path === 'login' || $path === 'register') {
            $intended = $request->input('intended');
            if ($intended && (str_starts_with($intended, 'admin/') || str_starts_with($intended, '/admin/'))) {
                return true;
            }
            
            // Check referer for login page
            $referer = $request->headers->get('referer');
            if ($referer && (str_contains($referer, '/admin/') || str_ends_with($referer, '/admin'))) {
                return true;
            }
        }
        
        // Check if user is already logged in as admin
        if (Auth::check()) {
            $user = Auth::user();
            $role = strtolower(trim((string) ($user->role ?? '')));
            
            // If accessing user routes but logged in as admin, stay in admin context
            // This prevents session switching when admin accesses user panel
            if ($role === 'admin' && !str_starts_with($path, 'user/')) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Configure session settings based on panel
     * INI HARUS DIJALANKAN SEBELUM StartSession!
     *
     * @param  bool  $isAdmin
     * @return void
     */
    protected function configureSession(bool $isAdmin): void
    {
        $config = app('config');
        
        if ($isAdmin) {
            // Admin panel: cookie terpisah dengan path /admin
            $config->set('session.cookie', 'laravel_admin_session');
            $config->set('session.path', '/admin');
        } else {
            // User panel: cookie default dengan path /
            $config->set('session.cookie', 'laravel_session');
            $config->set('session.path', '/');
        }
        
        // Pastikan cookie secure untuk Vercel (HTTPS)
        $config->set('session.secure', true);
        $config->set('session.http_only', true);
        $config->set('session.same_site', 'lax');
        
        // Session lifetime 120 menit
        $config->set('session.lifetime', 120);
        $config->set('session.expire_on_close', false);
    }

    /**
     * Configure response cookies untuk proper isolation
     * FIXED: Better handling of existing cookies
     *
     * @param  \Symfony\Component\HttpFoundation\Response  $response
     * @param  bool  $isAdmin
     * @return void
     */
    protected function configureResponseCookies(Response $response, bool $isAdmin): void
    {
        $sessionCookieName = $isAdmin ? 'laravel_admin_session' : 'laravel_session';
        $cookiePath = $isAdmin ? '/admin' : '/';
        
        // Get all cookies from response
        $cookies = $response->headers->getCookies();
        $processedSession = false;
        $processedCsrf = false;
        
        foreach ($cookies as $cookie) {
            $cookieName = $cookie->getName();
            
            // Check if this is a session cookie
            if ($this->isSessionCookie($cookieName) && !$processedSession) {
                // Only process the first session cookie we find
                $newCookie = new \Symfony\Component\HttpFoundation\Cookie(
                    $sessionCookieName,
                    $cookie->getValue(),
                    $cookie->getExpiresTime(),
                    $cookiePath,
                    $cookie->getDomain(),
                    true,  // secure - wajib untuk Vercel HTTPS
                    true,  // httpOnly
                    false, // raw
                    'lax'  // sameSite
                );
                
                // Remove old cookie and add new one
                $response->headers->removeCookie($cookieName);
                $response->headers->setCookie($newCookie);
                $processedSession = true;
            }
            
            // Handle CSRF token cookie
            if (($cookieName === 'XSRF-TOKEN' || $cookieName === 'XSRF-TOKEN-ADMIN') && !$processedCsrf) {
                $csrfCookieName = $isAdmin ? 'XSRF-TOKEN-ADMIN' : 'XSRF-TOKEN';
                
                $newCsrfCookie = new \Symfony\Component\HttpFoundation\Cookie(
                    $csrfCookieName,
                    $cookie->getValue(),
                    $cookie->getExpiresTime(),
                    $cookiePath,
                    $cookie->getDomain(),
                    true,   // secure
                    false,  // NOT httpOnly (harus bisa diakses JS)
                    false,
                    'lax'
                );
                
                $response->headers->removeCookie($cookieName);
                $response->headers->setCookie($newCsrfCookie);
                $processedCsrf = true;
            }
        }
    }

    /**
     * Check if cookie name is a session cookie
     *
     * @param  string  $name
     * @return bool
     */
    protected function isSessionCookie(string $name): bool
    {
        $sessionNames = [
            'laravel_session',
            'laravel_admin_session',
            'session'
        ];
        
        return in_array($name, $sessionNames) || str_contains($name, 'session');
    }
}
