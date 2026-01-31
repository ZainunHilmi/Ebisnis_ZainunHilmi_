# Laravel Dual Session Isolation - Vercel Serverless

Solusi lengkap untuk mengisolasi session antara panel admin dan user di Laravel yang di-deploy di Vercel (serverless environment).

## Masalah yang Diselesaikan

- ✅ **419 Page Expired** saat membuka panel admin dan user bersamaan
- ✅ **Session Bleeding** - halaman admin berganti ke user panel dan sebaliknya
- ✅ **CSRF Token Conflict** - token bentrok antara dua panel yang berbeda
- ✅ **Logout saat Refresh** - user tetap login setelah refresh halaman

## Arsitektur Solusi

```
┌─────────────────────────────────────────────────────────────┐
│                    BROWSER                                  │
├─────────────────────────────────────────────────────────────┤
│  Tab 1: example.com/admin/dashboard                        │
│  ├── Cookie: laravel_admin_session (path: /admin)          │
│  └── CSRF: XSRF-TOKEN-ADMIN                                │
│                                                             │
│  Tab 2: example.com/user/dashboard                         │
│  ├── Cookie: laravel_session (path: /)                     │
│  └── CSRF: XSRF-TOKEN                                      │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│                    VERCEL SERVERLESS                        │
├─────────────────────────────────────────────────────────────┤
│  SessionIsolator Middleware                                 │
│  ├── Detect route prefix (/admin vs /)                     │
│  ├── Set cookie name & path                                │
│  └── Store panel_context in request                        │
│                                                             │
│  VerifyCsrfToken Middleware                                 │
│  ├── Read panel_context from request                       │
│  ├── Validate panel-specific token                         │
│  └── Set panel-specific cookie                             │
│                                                             │
│  Database Session Driver                                    │
│  └── sessions table dengan panel_context column            │
└─────────────────────────────────────────────────────────────┘
```

## File yang Dibuat/Dimodifikasi

### 1. Middleware Baru
- `app/Http/Middleware/SessionIsolator.php` - Mengisolasi session berdasarkan panel
- `app/Http/Middleware/VerifyCsrfToken.php` - CSRF token terpisah per panel

### 2. Konfigurasi
- `config/auth.php` - Multi-guard setup (web, user, admin)
- `config/session.php` - Database driver, 120 menit lifetime
- `app/Http/Kernel.php` - Middleware order dengan SessionIsolator

### 3. Database
- `database/migrations/2026_01_31_062733_add_panel_context_to_sessions_table.php`
  - Menambahkan kolom `panel_context` dan `guard_type`

### 4. Routes
- `routes/web.php` - Group routes dengan middleware yang tepat

### 5. Environment
- `.env.example` - Variables untuk session isolation
- `vercel.json` - Environment variables untuk Vercel

### 6. Service Provider
- `app/Providers/CsrfServiceProvider.php` - Blade directives untuk CSRF

### 7. Testing
- `test-session-isolation.php` - Script untuk verifikasi setup

## Cara Kerja

### 1. Session Isolation
```php
// Admin Panel
Cookie: laravel_admin_session
Path: /admin
Lifetime: 120 menit

// User Panel  
Cookie: laravel_session
Path: /
Lifetime: 120 menit
```

### 2. CSRF Token Isolation
```php
// Admin Panel
Cookie Name: XSRF-TOKEN-ADMIN
Header Name: X-CSRF-TOKEN-ADMIN

// User Panel
Cookie Name: XSRF-TOKEN
Header Name: X-CSRF-TOKEN
```

### 3. Middleware Flow
```
Request → SessionIsolator → StartSession → VerifyCsrfToken → Controller
              ↓                    ↓              ↓
        Detect Panel          Load Session   Validate Token
        Set Cookie Config     by Cookie      by Panel Context
```

## Instalasi

### Step 1: Install Dependencies
```bash
composer install
npm install
```

### Step 2: Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

### Step 3: Update .env
```env
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_COOKIE=laravel_session
SESSION_SECURE_COOKIE=true
ADMIN_SESSION_COOKIE=laravel_admin_session
```

### Step 4: Run Migrations
```bash
php artisan migrate
php artisan migrate --path=database/migrations/2026_01_31_062733_add_panel_context_to_sessions_table.php
```

### Step 5: Register Service Provider
Tambahkan ke `config/app.php`:
```php
'providers' => [
    // ...
    App\Providers\CsrfServiceProvider::class,
],
```

### Step 6: Clear Cache
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### Step 7: Run Test
```bash
php test-session-isolation.php
```

## Deploy ke Vercel

### 1. Update vercel.json
File sudah terkonfigurasi dengan benar. Pastikan environment variables sudah benar:
```json
{
  "env": {
    "SESSION_DRIVER": "database",
    "SESSION_COOKIE": "laravel_session",
    "ADMIN_SESSION_COOKIE": "laravel_admin_session"
  }
}
```

### 2. Deploy
```bash
vercel --prod
```

### 3. Run Migrations di Vercel
Buka URL: `https://your-app.vercel.app/seed-db`

## Penggunaan di Blade Views

### CSRF Token Default
```blade
<form method="POST">
    @csrf
    <!-- form fields -->
</form>
```

### CSRF Token dengan Panel Context
```blade
<form method="POST">
    @panelCsrf
    <!-- form fields -->
</form>
```

### Meta Tag untuk JavaScript
```blade
<head>
    @csrfMeta
</head>

<script>
// CSRF token otomatis ter-set berdasarkan panel
const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const panel = document.querySelector('meta[name="csrf-token"]').getAttribute('data-panel');
const headerName = document.querySelector('meta[name="csrf-token"]').getAttribute('data-header');

fetch('/api/endpoint', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        [headerName]: token
    },
    body: JSON.stringify(data)
});
</script>
```

## Testing Manual

### Test Case 1: Dual Login
1. Buka Tab 1: `example.com/admin/login`
2. Buka Tab 2: `example.com/login`
3. Login sebagai admin di Tab 1
4. Login sebagai user di Tab 2
5. **Expected**: Kedua tab tetap login

### Test Case 2: No Session Bleeding
1. Refresh Tab 1 (admin panel)
2. Refresh Tab 2 (user panel)
3. **Expected**: Tidak ada redirect ke panel lain

### Test Case 3: CSRF Protection
1. Buka form di admin panel
2. Submit form
3. **Expected**: Form berhasil submit tanpa error 419

### Test Case 4: Cookie Isolation
1. Buka Developer Tools → Application → Cookies
2. **Expected**: 
   - Admin panel: `laravel_admin_session` (path: /admin)
   - User panel: `laravel_session` (path: /)

## Troubleshooting

### Error 419 Page Expired
```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Clear browser cookies
# Buka DevTools → Application → Clear Storage
```

### Session Bleeding
```bash
# Pastikan SessionIsolator middleware terdaftar
php artisan route:list --path=admin
php artisan route:list --path=user

# Cek middleware order di Kernel.php
```

### CSRF Token Mismatch
```bash
# Cek apakah cookie CSRF ter-set dengan benar
# Buka DevTools → Application → Cookies

# Pastikan header name benar:
# Admin: X-CSRF-TOKEN-ADMIN
# User: X-CSRF-TOKEN
```

### Logout saat Refresh
```bash
# Cek session lifetime
php artisan tinker
>>> config('session.lifetime')
# Should return 120

# Cek database session
php artisan tinker
>>> DB::table('sessions')->count()
```

## Struktur Database Sessions

```sql
CREATE TABLE sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    panel_context VARCHAR(20) NULL, -- 'admin' atau 'user'
    guard_type VARCHAR(20) NULL,    -- 'web', 'user', atau 'admin'
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    payload TEXT NOT NULL,
    last_activity INT NOT NULL,
    INDEX (user_id),
    INDEX (panel_context),
    INDEX (guard_type),
    INDEX sessions_user_panel_index (user_id, panel_context)
);
```

## Keamanan

### Best Practices
1. **Always use HTTPS** - Cookies di-set dengan `secure: true`
2. **HttpOnly Cookies** - Session cookies tidak bisa diakses JavaScript
3. **SameSite=Lax** - Melindungi dari CSRF attacks
4. **Session Regeneration** - ID berubah saat context switch
5. **No Auth::logout()** - Gunakan redirect() untuk mencegah session invalidation

### Cookie Security
```php
// Admin Cookie
Name: laravel_admin_session
Path: /admin
Secure: true
HttpOnly: true
SameSite: lax

// User Cookie
Name: laravel_session
Path: /
Secure: true
HttpOnly: true
SameSite: lax
```

## Performance

### Database Session Driver
- ✅ Cocok untuk Vercel serverless
- ✅ Session tersimpan di PostgreSQL/MySQL
- ✅ Auto-cleanup dengan lottery system

### Session Lifetime
- Default: 120 menit
- Tidak expire on close
- Refresh saat aktivitas

## Keterbatasan

1. **File Session tidak didukung** - Gunakan database driver
2. **Redis opsional** - Bisa digunakan untuk caching
3. **Same browser** - Session terpisah per browser, bukan per tab

## Update & Maintenance

### Menambah Panel Baru
1. Tambah guard di `config/auth.php`
2. Buat middleware isolator baru
3. Update `SessionIsolator` untuk detect prefix baru
4. Tambah cookie name di `.env`

### Monitoring
```bash
# Cek active sessions
php artisan tinker
>>> DB::table('sessions')
    ->select('panel_context', DB::raw('count(*) as total'))
    ->groupBy('panel_context')
    ->get();
```

## Support

Jika ada masalah:
1. Jalankan `php test-session-isolation.php`
2. Cek logs di Vercel dashboard
3. Buka issue di repository

## Credits

Solusi ini dibuat khusus untuk Laravel di Vercel serverless environment dengan requirement dual panel (admin & user).
