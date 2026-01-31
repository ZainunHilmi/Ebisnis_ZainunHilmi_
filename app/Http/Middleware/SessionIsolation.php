<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Session Isolation Middleware - SIMPLIFIED VERSION
 * 
 * Mengisolasi session antara panel admin dan user dengan cara yang sederhana:
 * - Detect route berdasarkan URL path
 * - Set session config (cookie name & path) SEBELUM session start
 * - Gunakan cookie name berbeda: laravel_session (user) vs laravel_admin_session (admin)
 * - Gunakan cookie path berbeda: / (user) vs /admin (admin)
 * 
 * HARUS diletakkan SEBELUM StartSession di Kernel!
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
        // Detect if this is admin panel based on URL path
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
        
        foreach ($cookies as $cookie) {
            $cookieName = $cookie->getName();
            
            // Check if this is a session cookie (various possible names)
            if ($this->isSessionCookie($cookieName)) {
                // Create new cookie with correct name and path
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
            }
            
            // Handle CSRF token cookie
            if ($cookieName === 'XSRF-TOKEN' || $cookieName === 'XSRF-TOKEN-ADMIN') {
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
