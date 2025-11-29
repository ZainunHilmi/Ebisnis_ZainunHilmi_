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
        // LoginRequest::authenticate() akan melakukan Auth::attempt + rate-limiting
        $request->authenticate();

        // Hindari session fixation
        $request->session()->regenerate();

        $user = Auth::user();

        // Safety: jika tidak ada user setelah authenticate -> logout & kembali ke login
        if (! $user) {
            Auth::guard('web')->logout();
            return redirect()->route('login')->withErrors(['email' => __('auth.failed')]);
        }

        // Normalisasi role: hindari case/whitespace/null issues
        $role = strtolower(trim((string) ($user->role ?? '')));

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
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
