<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Check user authentication - don't invalidate session on refresh
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Authentication required.');
        }

        $user = auth()->user();
        $role = strtolower(trim((string) ($user->role ?? '')));

        // Role checking - only invalidate if role is wrong (not on auth failure)
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

        // Sync session data with current user
        session(['user_role' => 'admin', 'user_id' => $user->id, 'role_verified_at' => now()]);

        return $next($request);
    }
}
