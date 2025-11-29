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
        if (auth()->user()->role !== 'user') {
            return redirect('/login')->with('error', 'Akses ditolak.');
        }

        return $next($request);
    }
}