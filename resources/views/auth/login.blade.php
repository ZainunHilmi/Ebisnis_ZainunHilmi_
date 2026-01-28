<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <label for="email" class="form-label">
                <svg xmlns="http://www.w3.org/2000/svg" class="label-icon" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                </svg>
                Alamat Email
            </label>
            <div class="input-wrapper">
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    placeholder="contoh@email.com" class="form-input">
                <div class="input-focus-ring"></div>
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-500" />
        </div>

        <!-- Password -->
        <div class="form-group">
            <div class="flex items-center justify-between mb-2">
                <label for="password" class="form-label mb-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="label-icon" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    Password
                </label>
                @if (Route::has('password.request'))
                    <a class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 hover:underline transition-all"
                        href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                @endif
            </div>
            <div class="input-wrapper">
                <input id="password" type="password" name="password" required placeholder="••••••••" class="form-input">
                <div class="input-focus-ring"></div>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-500" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" name="remember" class="checkbox-input">
                <span class="ms-2 text-sm font-medium text-slate-600 group-hover:text-slate-800 transition-colors">Ingat
                    saya</span>
            </label>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="submit-btn">
            <span>Masuk</span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
            </svg>
        </button>

        <!-- Demo Credentials -->
        <div class="demo-credentials">
            <div class="demo-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="demo-text">
                <p class="demo-title">Kredensial Demo:</p>
                <p><span class="demo-label">Admin:</span> admin@example.com</p>
                <p><span class="demo-label">User:</span> testuser@example.com</p>
                <p><span class="demo-label">Password:</span> password</p>
            </div>
        </div>
    </form>

    <style>
        .form-group {
            margin-bottom: 4px;
        }

        .form-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 600;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .label-icon {
            width: 16px;
            height: 16px;
            color: #6366f1;
        }

        .input-wrapper {
            position: relative;
        }

        .form-input {
            width: 100%;
            padding: 14px 16px;
            font-size: 15px;
            font-weight: 500;
            color: #1e293b;
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-input::placeholder {
            color: #94a3b8;
        }

        .form-input:focus {
            background: white;
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }

        .checkbox-input {
            width: 18px;
            height: 18px;
            border-radius: 6px;
            border: 2px solid #cbd5e1;
            cursor: pointer;
            accent-color: #6366f1;
        }

        .submit-btn {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 16px 24px;
            font-size: 16px;
            font-weight: 700;
            color: white;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px -5px rgba(99, 102, 241, 0.4);
            margin-top: 8px;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px -5px rgba(99, 102, 241, 0.5);
        }

        .submit-btn:active {
            transform: scale(0.98);
        }

        .submit-btn svg {
            width: 20px;
            height: 20px;
        }

        .demo-credentials {
            display: flex;
            gap: 12px;
            padding: 16px;
            background: linear-gradient(135deg, #eff6ff 0%, #f0f9ff 100%);
            border: 1px solid #bfdbfe;
            border-radius: 12px;
            margin-top: 16px;
        }

        .demo-icon {
            flex-shrink: 0;
        }

        .demo-icon svg {
            width: 20px;
            height: 20px;
            color: #3b82f6;
        }

        .demo-text {
            font-size: 12px;
            color: #1e40af;
            line-height: 1.6;
        }

        .demo-title {
            font-weight: 700;
            margin-bottom: 4px;
        }

        .demo-label {
            opacity: 0.7;
        }
    </style>
</x-guest-layout>