<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     * FIXED: Properly handles dual session isolation without invalidating other sessions
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Get panel context from request attributes (set by DynamicSessionCookie)
        $panelContext = $request->attributes->get('panel_context', 'user');
        
        // Check if already logged in with different role
        if (Auth::check()) {
            $currentUser = Auth::user();
            $currentRole = strtolower(trim((string) ($currentUser->role ?? '')));
            $incomingEmail = $request->input('email');
            
            // Only logout if different email trying to login
            if ($currentUser->email !== $incomingEmail) {
                // Logout current user from current guard only
                $guard = $panelContext === 'admin' ? 'admin' : 'user';
                Auth::guard($guard)->logout();
                
                // Clear session data for current panel only
                session()->forget(['user_id', 'user_role', 'login_timestamp']);
                
                // Don't invalidate session completely - preserve other panel sessions
                $request->session()->regenerate(false); // Don't destroy old session
            }
        }

        // Authenticate using appropriate guard
        $guard = $panelContext === 'admin' ? 'admin' : 'user';
        
        // Custom authentication attempt with specific guard
        $credentials = $request->only('email', 'password');
        
        if (!Auth::guard($guard)->attempt($credentials)) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        // Get authenticated user
        $user = Auth::guard($guard)->user();

        if (!$user) {
            Auth::guard($guard)->logout();
            return redirect()->route('login')->withErrors(['email' => __('auth.failed')]);
        }

        // Normalize role
        $role = strtolower(trim((string) ($user->role ?? '')));

        // Set panel-specific session data
        session([
            'user_id' => $user->id,
            'user_role' => $role,
            'login_timestamp' => now()->timestamp,
            'panel_context' => $panelContext,
            'session_initiated' => true
        ]);

        // Set intended URL based on role and context
        $intendedUrl = null;
        if ($role === 'admin' && $panelContext === 'admin') {
            $intendedUrl = route('admin.dashboard');
        } elseif ($role === 'user' && $panelContext === 'user') {
            $intendedUrl = route('user.dashboard');
        } elseif ($role === 'admin') {
            // Admin accessing user context - redirect to admin
            $intendedUrl = route('admin.dashboard');
        } else {
            // User accessing admin context - redirect to user
            $intendedUrl = route('user.dashboard');
        }

        return redirect()->intended($intendedUrl);
    }

    /**
     * Destroy an authenticated session.
     * FIXED: Logout from specific panel only, preserve other sessions
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Get panel context from request attributes
        $panelContext = $request->attributes->get('panel_context', 'user');
        $guard = $panelContext === 'admin' ? 'admin' : 'user';
        
        // Clear panel-specific session data
        session()->forget(['user_id', 'user_role', 'login_timestamp', 'panel_context']);
        
        // Logout from specific guard only
        Auth::guard($guard)->logout();

        // Clear the specific session cookie for this panel
        $cookieName = $panelContext === 'admin' ? 'admin_session' : 'user_session';
        $cookiePath = $panelContext === 'admin' ? '/admin' : '/';
        
        // Create expired cookie to clear it
        $expiredCookie = cookie($cookieName, '', -1, $cookiePath, null, true, true, false, 
            $panelContext === 'admin' ? 'strict' : 'lax');

        // Regenerate CSRF token for security
        $request->session()->regenerateToken();

        return redirect('/')->withCookie($expiredCookie);
    }
}
