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
        $role = strtolower(trim((string) (auth()->user()->role ?? '')));

        if ($role !== 'user') {
            return redirect()->route('login')->with('error', 'Access limited to User accounts only.');
        }

        return $next($request);
    }
}