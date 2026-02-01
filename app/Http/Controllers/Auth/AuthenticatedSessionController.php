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
     * Uses explicit guards to prevent session collision between admin and user.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Determine which guard to use based on intended destination or role
        $guard = 'web';
        $intended = $request->input('intended');
        
        // Check if trying to access admin area
        if ($intended && str_contains($intended, 'admin')) {
            $guard = 'admin';
        }
        
        // Attempt authentication with explicit guard
        if (! Auth::guard($guard)->attempt($request->only('email', 'password'))) {
            return redirect()->route('login')->withErrors(['email' => __('auth.failed')]);
        }

        // Regenerate session to prevent fixation
        $request->session()->regenerate();

        $user = Auth::guard($guard)->user();

        if (! $user) {
            Auth::guard($guard)->logout();
            return redirect()->route('login')->withErrors(['email' => __('auth.failed')]);
        }

        // Normalize role
        $role = strtolower(trim((string) ($user->role ?? '')));

        // Set basic session data
        session([
            'user_id' => $user->id,
            'user_role' => $role,
            'login_timestamp' => now()->timestamp,
            'auth_guard' => $guard,
        ]);

        // Determine redirect based on role
        if ($role === 'admin') {
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()->intended(route('user.dashboard'));
    }

    /**
     * Destroy an authenticated session.
     * Uses the guard stored in session to prevent collision.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Get the guard used during login
        $guard = session('auth_guard', 'web');
        
        // Clear session data
        session()->forget(['user_id', 'user_role', 'login_timestamp', 'auth_guard']);
        
        // Logout from the specific guard
        Auth::guard($guard)->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
