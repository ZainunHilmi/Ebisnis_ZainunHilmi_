<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Force check user authentication and role
        if (!auth()->check()) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->with('error', 'Authentication required.');
        }

        $user = auth()->user();
        $role = strtolower(trim((string) ($user->role ?? '')));

        // SUPER STRICT role checking - NO EXCEPTIONS
        if ($role !== 'admin') {
            // Force logout for any non-admin trying to access admin routes
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            // Redirect to appropriate dashboard or login
            if ($role === 'user') {
                return redirect()->route('login')->with('error', 'User cannot access admin panel. Please login as admin.');
            }
            
            return redirect()->route('login')->with('error', 'Invalid role for admin access. Please login again.');
        }

        // Double-check session integrity
        if (session('user_role') !== 'admin') {
            session(['user_role' => 'admin', 'role_verified_at' => now()]);
        }

        // Additional security check - verify user ID matches session
        if (session('user_id') != $user->id) {
            session(['user_id' => $user->id, 'user_role' => 'admin']);
        }

        return $next($request);
    }
}
