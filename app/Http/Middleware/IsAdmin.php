<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Check user authentication
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Authentication required.');
        }

        $user = auth()->user();
        $role = strtolower(trim((string) ($user->role ?? '')));

        // Role checking - redirect only, NO logout to prevent global session invalidation
        if ($role !== 'admin') {
            // Redirect user to user dashboard without logout
            if ($role === 'user') {
                return redirect()->route('user.dashboard')->with('warning', 'User area is separate from admin panel.');
            }
            
            // For unrecognized roles, redirect to login
            return redirect()->route('login')->with('error', 'Invalid role. Please login again.');
        }

        return $next($request);
    }
}
