<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div class="form-group">
            <label for="name" class="form-label">
                <svg xmlns="http://www.w3.org/2000/svg" class="label-icon" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Nama Lengkap
            </label>
            <div class="input-wrapper">
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                    placeholder="Masukkan nama lengkap" class="form-input" autocomplete="name">
                <div class="input-focus-ring"></div>
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-500" />
        </div>

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
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                    placeholder="contoh@email.com" class="form-input" autocomplete="username">
                <div class="input-focus-ring"></div>
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-500" />
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password" class="form-label">
                <svg xmlns="http://www.w3.org/2000/svg" class="label-icon" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                Password
            </label>
            <div class="input-wrapper">
                <input id="password" type="password" name="password" required placeholder="Minimal 8 karakter"
                    class="form-input" autocomplete="new-password">
                <div class="input-focus-ring"></div>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-500" />
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <label for="password_confirmation" class="form-label">
                <svg xmlns="http://www.w3.org/2000/svg" class="label-icon" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                Konfirmasi Password
            </label>
            <div class="input-wrapper">
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    placeholder="Ulangi password" class="form-input" autocomplete="new-password">
                <div class="input-focus-ring"></div>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-500" />
        </div>

        <!-- Terms Agreement (Optional Visual) -->
        <div class="flex items-start gap-3">
            <input id="terms" type="checkbox" required class="checkbox-input mt-0.5">
            <label for="terms" class="text-sm text-slate-600 leading-relaxed">
                Saya setuju dengan <a href="#" class="text-indigo-600 font-medium hover:underline">Syarat &
                    Ketentuan</a> dan <a href="#" class="text-indigo-600 font-medium hover:underline">Kebijakan
                    Privasi</a>
            </label>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="submit-btn">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
            </svg>
            <span>Daftar Sekarang</span>
        </button>

        <!-- Benefits -->
        <div class="benefits-box">
            <p class="benefits-title">Keuntungan mendaftar:</p>
            <div class="benefits-list">
                <div class="benefit-item">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Akses ke semua produk</span>
                </div>
                <div class="benefit-item">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Promo eksklusif member</span>
                </div>
                <div class="benefit-item">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Pengiriman cepat</span>
                </div>
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
            flex-shrink: 0;
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
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px -5px rgba(16, 185, 129, 0.4);
            margin-top: 8px;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px -5px rgba(16, 185, 129, 0.5);
        }

        .submit-btn:active {
            transform: scale(0.98);
        }

        .submit-btn svg {
            width: 20px;
            height: 20px;
        }

        .benefits-box {
            padding: 16px;
            background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
            border: 1px solid #86efac;
            border-radius: 12px;
            margin-top: 16px;
        }

        .benefits-title {
            font-size: 13px;
            font-weight: 700;
            color: #166534;
            margin-bottom: 12px;
        }

        .benefits-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .benefit-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: #15803d;
        }

        .benefit-item svg {
            width: 16px;
            height: 16px;
            color: #22c55e;
            flex-shrink: 0;
        }
    </style>
</x-guest-layout>