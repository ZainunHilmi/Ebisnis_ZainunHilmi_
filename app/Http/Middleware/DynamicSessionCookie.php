<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Dynamic Session Cookie Middleware
 * 
 * This middleware dynamically sets session cookie names based on URL path
 * to completely isolate admin and user sessions.
 * 
 * - /admin/* -> admin_session cookie
 * - /*      -> user_session cookie
 * 
 * MUST be placed BEFORE StartSession middleware
 */
class DynamicSessionCookie
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
        // Detect panel based on URL path
        $isAdmin = $this->isAdminRoute($request);
        
        // Set session configuration BEFORE session starts
        $this->configureSession($isAdmin);
        
        // Store panel context for other middleware
        $request->attributes->set('panel_context', $isAdmin ? 'admin' : 'user');
        
        // Process request
        $response = $next($request);
        
        // Ensure response cookies use correct names and paths
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
        
        // Direct admin URL detection
        if (str_starts_with($path, 'admin/') || $path === 'admin') {
            return true;
        }
        
        // Check intended destination for login/register routes
        if (in_array($path, ['login', 'register', 'logout'])) {
            $intended = $request->input('intended');
            if ($intended && (str_starts_with($intended, 'admin/') || str_starts_with($intended, '/admin/'))) {
                return true;
            }
            
            // Check referer header
            $referer = $request->headers->get('referer');
            if ($referer && (str_contains($referer, '/admin/') || str_ends_with($referer, '/admin'))) {
                return true;
            }
        }
        
        // Check if currently authenticated as admin
        if (Auth::check()) {
            $user = Auth::user();
            $role = strtolower(trim((string) ($user->role ?? '')));
            
            // If accessing admin routes, use admin context
            if ($role === 'admin') {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Configure session settings based on panel
     *
     * @param  bool  $isAdmin
     * @return void
     */
    protected function configureSession(bool $isAdmin): void
    {
        $config = app('config');
        
        if ($isAdmin) {
            // Admin panel configuration
            $config->set('session.cookie', 'admin_session');
            $config->set('session.path', '/admin');
            $config->set('session.same_site', 'strict');
        } else {
            // User panel configuration  
            $config->set('session.cookie', 'user_session');
            $config->set('session.path', '/');
            $config->set('session.same_site', 'lax');
        }
        
        // Common settings for both panels
        $config->set('session.secure', true);
        $config->set('session.http_only', true);
        $config->set('session.lifetime', 120);
        $config->set('session.expire_on_close', false);
    }

    /**
     * Configure response cookies to use correct names and paths
     *
     * @param  \Symfony\Component\HttpFoundation\Response  $response
     * @param  bool  $isAdmin
     * @return void
     */
    protected function configureResponseCookies(Response $response, bool $isAdmin): void
    {
        $sessionCookieName = $isAdmin ? 'admin_session' : 'user_session';
        $cookiePath = $isAdmin ? '/admin' : '/';
        $csrfCookieName = $isAdmin ? 'XSRF-TOKEN-ADMIN' : 'XSRF-TOKEN';
        
        $cookies = $response->headers->getCookies();
        $processedSession = false;
        $processedCsrf = false;
        
        foreach ($cookies as $cookie) {
            $name = $cookie->getName();
            
            // Handle session cookies
            if ($this->isSessionCookie($name) && !$processedSession) {
                $newCookie = new \Symfony\Component\HttpFoundation\Cookie(
                    $sessionCookieName,
                    $cookie->getValue(),
                    $cookie->getExpiresTime(),
                    $cookiePath,
                    $cookie->getDomain(),
                    true,  // secure
                    true,  // httpOnly
                    false, // raw
                    $isAdmin ? 'strict' : 'lax' // sameSite
                );
                
                $response->headers->removeCookie($name);
                $response->headers->setCookie($newCookie);
                $processedSession = true;
            }
            
            // Handle CSRF cookies
            if (($name === 'XSRF-TOKEN' || $name === 'XSRF-TOKEN-ADMIN') && !$processedCsrf) {
                $newCsrfCookie = new \Symfony\Component\HttpFoundation\Cookie(
                    $csrfCookieName,
                    $cookie->getValue(),
                    $cookie->getExpiresTime(),
                    $cookiePath,
                    $cookie->getDomain(),
                    true,   // secure
                    false,  // NOT httpOnly (needs JS access)
                    false,
                    $isAdmin ? 'strict' : 'lax'
                );
                
                $response->headers->removeCookie($name);
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
            'admin_session',
            'user_session',
            'laravel_admin_session',
            'session'
        ];
        
        return in_array($name, $sessionNames) || str_contains($name, 'session');
    }
}
