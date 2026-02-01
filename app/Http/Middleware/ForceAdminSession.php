<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Force Admin Session Middleware - HARD SWITCH
 * 
 * This middleware forces different session cookie names based on the URL path.
 * It runs BEFORE the session starts to ensure the correct cookie name is set.
 * 
 * Admin routes (/admin/*): ebisnis_admin_session
 * User routes (/*): ebisnis_user_session
 * 
 * CRITICAL: This middleware MUST run before StartSession middleware!
 */
class ForceAdminSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, $next)
    {
        if ($request->is('admin*')) {
            config(['session.cookie' => 'ebisnis_admin_session']);
        } else {
            config(['session.cookie' => 'ebisnis_user_session']);
        }
        
        return $next($request);
    }
}
