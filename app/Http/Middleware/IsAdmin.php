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
            // Prevent redirect loop by checking if already on correct route
            if ($role === 'user' && !$request->is('user/*')) {
                return redirect()->route('user.dashboard')->with('info', 'Redirected to user area.');
            }
            
            // For unrecognized roles, redirect to login
            return redirect()->route('login')->with('error', 'Invalid role. Please login again.');
        }

        // Session isolation: verify session consistency
        $sessionUserId = session('user_id');
        if ($sessionUserId && $sessionUserId != $user->id) {
            // Session mismatch detected - sync session
            session([
                'user_id' => $user->id,
                'user_role' => $role,
                'session_synced_at' => now()->timestamp
            ]);
        }

        return $next($request);
    }
}
