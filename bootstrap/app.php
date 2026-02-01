<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // CRITICAL: Trust all proxies for Vercel HTTPS detection
        $middleware->trustProxies(at: '*');
        
        // HARD SWITCH: Force different session cookies for Admin vs User
        // This MUST run before StartSession to set the correct cookie name
        $middleware->prepend(\App\Http\Middleware\ForceAdminSession::class);
        
        // Standard Laravel web middleware stack
        $middleware->web([
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);
        
        $middleware->alias([
            'is_admin' => \App\Http\Middleware\IsAdmin::class,
            'is_user' => \App\Http\Middleware\IsUser::class,
            'guest.redirect' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Handle CSRF Token Mismatch (419 Page Expired)
        $exceptions->render(function (TokenMismatchException $e, Request $request) {
            if ($request->is('login') || $request->is('admin/*') || $request->is('user/*')) {
                return redirect()->route('login')
                    ->with('error', 'Your session has expired. Please login again.');
            }
            return redirect()->back()->with('error', 'Session expired. Please refresh and try again.');
        });
    })->create();
