<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Pastikan user sudah login
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        $user = auth()->user();
        $role = strtolower(trim((string) ($user->role ?? '')));

        // Strict role checking
        if ($role !== 'admin') {
            // Jika user role 'user', redirect ke dashboard user
            if ($role === 'user') {
                return redirect()->route('user.dashboard')->with('error', 'Access denied. User dashboard redirected.');
            }
            
            // Jika role tidak dikenali, logout dan redirect ke login
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->with('error', 'Invalid user role. Please login again.');
        }

        // Set session flag untuk admin
        session(['user_role' => 'admin']);

        return $next($request);
    }
}
