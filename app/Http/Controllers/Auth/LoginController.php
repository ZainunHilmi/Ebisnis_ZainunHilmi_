<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login by default (keamanan fallback).
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // biarkan guest bisa mengakses login/logout sesuai trait
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Called after a user is authenticated.
     *
     * Mengarahkan user berdasarkan role:
     * - admin -> route('admin.dashboard')
     * - selainnya -> route('user.dashboard')
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function authenticated(Request $request, $user)
    {
        // safety: normalisasi role, hindari null/Case-sensitivity/whitespace
        $role = strtolower(trim((string) ($user->role ?? '')));

        if ($role === 'admin') {
            // intended akan mengarahkan ke halaman sebelumnya bila ada, kalau tidak => admin dashboard
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()->intended(route('user.dashboard'));
    }
}
