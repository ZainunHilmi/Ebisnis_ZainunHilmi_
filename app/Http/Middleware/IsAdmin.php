<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $role = strtolower(trim((string) (auth()->user()->role ?? '')));

        if ($role !== 'admin') {
            return redirect()->route('login')->with('error', 'Administrator access required.');
        }

        return $next($request);
    }
}
