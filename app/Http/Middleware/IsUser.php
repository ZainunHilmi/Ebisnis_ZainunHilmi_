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
        // Pastikan user sudah login
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        $user = auth()->user();
        $role = strtolower(trim((string) ($user->role ?? '')));

        // Strict role checking
        if ($role !== 'user') {
            // Jika user role 'admin', redirect ke dashboard admin
            if ($role === 'admin') {
                return redirect()->route('admin.dashboard')->with('error', 'Access denied. Admin dashboard redirected.');
            }
            
            // Jika role tidak dikenali, logout dan redirect ke login
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->with('error', 'Invalid user role. Please login again.');
        }

        // Set session flag untuk user
        session(['user_role' => 'user']);

        return $next($request);
    }
}