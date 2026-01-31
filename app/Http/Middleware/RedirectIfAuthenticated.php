<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        // Check if user is authenticated
        if (Auth::check()) {
            $user = Auth::user();
            $role = strtolower(trim((string) ($user->role ?? '')));
            
            // Check if current route is admin route
            $isAdminRoute = $this->isAdminRoute($request);
            
            // If on admin route but user is not admin, redirect to user dashboard
            if ($isAdminRoute && $role !== 'admin') {
                return redirect()->route('user.dashboard');
            }
            
            // If on user route but user is admin, redirect to admin dashboard  
            if (!$isAdminRoute && $role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            
            // Redirect to appropriate dashboard based on role
            if ($role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($role === 'user') {
                return redirect()->route('user.dashboard');
            }

            // Fallback jika role tidak dikenali
            return redirect()->route('profile.edit');
        }

        return $next($request);
    }
    
    /**
     * Check if current route is admin route
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function isAdminRoute(Request $request): bool
    {
        $path = $request->path();
        return str_starts_with($path, 'admin/') || $path === 'admin';
    }
}
