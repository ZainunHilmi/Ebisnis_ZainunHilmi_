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
     * FIXED: Properly handles session isolation for dual panel login
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Check if another user is already logged in (role switching scenario)
        if (Auth::check()) {
            $currentUser = Auth::user();
            $currentRole = strtolower(trim((string) ($currentUser->role ?? '')));
            
            // If trying to login as different user, logout first
            $incomingEmail = $request->input('email');
            if ($currentUser->email !== $incomingEmail) {
                // Logout current user
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
            }
        }

        // Authenticate the user
        $request->authenticate();

        // Regenerate session to prevent fixation
        $request->session()->regenerate();

        $user = Auth::user();

        // Safety: jika tidak ada user setelah authenticate -> logout & kembali ke login
        if (! $user) {
            Auth::guard('web')->logout();
            return redirect()->route('login')->withErrors(['email' => __('auth.failed')]);
        }

        // Normalisasi role
        $role = strtolower(trim((string) ($user->role ?? '')));

        // Set session data untuk tracking
        session([
            'user_id' => $user->id,
            'user_role' => $role,
            'login_timestamp' => now()->timestamp,
            'session_initiated' => true
        ]);

        // Determine redirect based on role
        if ($role === 'admin') {
            return redirect()->intended(route('admin.dashboard'));
        }

        // Default -> user dashboard
        return redirect()->intended(route('user.dashboard'));
    }

    /**
     * Destroy an authenticated session.
     * FIXED: Properly handles logout without affecting other panel sessions
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Get current panel context
        $isAdmin = $request->attributes->get('panel_context') === 'admin';
        
        // Clear panel-specific session data
        session()->forget(['user_id', 'user_role', 'login_timestamp']);
        
        // Logout user
        Auth::guard('web')->logout();

        // Invalidate session
        $request->session()->invalidate();

        // Regenerate CSRF token
        $request->session()->regenerateToken();

        // Clear the specific session cookie for this panel
        $cookieName = $isAdmin ? 'laravel_admin_session' : 'laravel_session';
        $cookiePath = $isAdmin ? '/admin' : '/';
        
        // Create expired cookie to clear it
        $expiredCookie = cookie($cookieName, '', -1, $cookiePath, null, true, true, false, 'lax');

        return redirect('/')->withCookie($expiredCookie);
    }
}
