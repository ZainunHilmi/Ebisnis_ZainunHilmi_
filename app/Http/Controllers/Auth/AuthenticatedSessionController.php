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
     * Simplified for Vercel compatibility - standard Laravel authentication
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Standard Laravel authentication
        $request->authenticate();

        // Regenerate session to prevent fixation
        $request->session()->regenerate();

        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login')->withErrors(['email' => __('auth.failed')]);
        }

        // Normalize role
        $role = strtolower(trim((string) ($user->role ?? '')));

        // Set basic session data
        session([
            'user_id' => $user->id,
            'user_role' => $role,
            'login_timestamp' => now()->timestamp,
        ]);

        // Determine redirect based on role
        if ($role === 'admin') {
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()->intended(route('user.dashboard'));
    }

    /**
     * Destroy an authenticated session.
     * Simplified logout for Vercel compatibility
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
