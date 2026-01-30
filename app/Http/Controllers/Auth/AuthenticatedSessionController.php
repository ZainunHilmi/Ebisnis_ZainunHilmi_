<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest; // pakai LoginRequest Breeze-style
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
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Check if another user is already logged in (role switching scenario)
        if (Auth::check()) {
            $currentUser = Auth::user();
            $currentRole = strtolower(trim((string) ($currentUser->role ?? '')));
            
            // If trying to login as different user, logout first but preserve session structure
            $incomingEmail = $request->input('email');
            if ($currentUser->email !== $incomingEmail) {
                // Logout without full session invalidation to preserve CSRF token context
                Auth::guard('web')->logout();
                // Don't invalidate session here - let the new login regenerate it
            }
        }

        // LoginRequest::authenticate() akan melakukan Auth::attempt + rate-limiting
        $request->authenticate();

        // Hindari session fixation - regenerate session ID but preserve CSRF token
        $request->session()->regenerate();

        $user = Auth::user();

        // Safety: jika tidak ada user setelah authenticate -> logout & kembali ke login
        if (! $user) {
            Auth::guard('web')->logout();
            return redirect()->route('login')->withErrors(['email' => __('auth.failed')]);
        }

        // Normalisasi role: hindari case/whitespace/null issues
        $role = strtolower(trim((string) ($user->role ?? '')));

        // Set session untuk isolation dengan session ID tracking
        session([
            'user_id' => $user->id,
            'user_role' => $role,
            'login_timestamp' => now()->timestamp,
            'session_initiated' => true
        ]);

        // Prioritas admin => redirect ke admin.dashboard
        if ($role === 'admin') {
            return redirect()->intended(route('admin.dashboard'));
        }

        // Default -> user dashboard
        return redirect()->intended(route('user.dashboard'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Clear session data
        session()->forget(['user_id', 'user_role', 'login_timestamp']);
        
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
