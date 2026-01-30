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

        // Double-check session integrity
        if (session('user_role') !== 'user') {
            session(['user_role' => 'user', 'role_verified_at' => now()]);
        }

        // Additional security check - verify user ID matches session
        if (session('user_id') != $user->id) {
            session(['user_id' => $user->id, 'user_role' => 'user']);
        }

        return $next($request);
    }
}