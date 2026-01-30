<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsUser
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
        if ($role !== 'user') {
            // Force logout for any non-user trying to access user routes
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            // Redirect to appropriate dashboard or login
            if ($role === 'admin') {
                return redirect()->route('login')->with('error', 'Admin cannot access user panel. Please login as user.');
            }
            
            return redirect()->route('login')->with('error', 'Invalid role for user access. Please login again.');
        }

        // Sync session data with current user
        session(['user_role' => 'user', 'user_id' => $user->id, 'role_verified_at' => now()]);

        return $next($request);
    }
}