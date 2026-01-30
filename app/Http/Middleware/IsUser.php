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
        // Check user authentication
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Authentication required.');
        }

        $user = auth()->user();
        $role = strtolower(trim((string) ($user->role ?? '')));

        // Role checking - redirect only, NO logout to prevent global session invalidation
        if ($role !== 'user') {
            // Redirect admin to admin dashboard without logout
            if ($role === 'admin') {
                return redirect()->route('admin.dashboard')->with('warning', 'Admin area is separate from user panel.');
            }
            
            // For unrecognized roles, redirect to login
            return redirect()->route('login')->with('error', 'Invalid role. Please login again.');
        }

        return $next($request);
    }
}