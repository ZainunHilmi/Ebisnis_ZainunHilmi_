# SESSION ISOLATION FIX - Vercel Laravel

## Masalah yang Terjadi
- Error 419 Page Expired saat login di panel admin dan user bersamaan
- Session bleeding antara admin dan user
- CSRF token conflict
- Logout saat refresh halaman

## Solusi yang Diimplementasikan

### 1. SessionIsolation Middleware (BARU)
**File**: `app/Http/Middleware/SessionIsolation.php`

Cara kerja:
- Detect route berdasarkan URL path (/admin/* vs /*)
- Set session config SEBELUM StartSession middleware:
  - Admin: cookie name = `laravel_admin_session`, path = `/admin`
  - User: cookie name = `laravel_session`, path = `/`
- Cookie terpisah = Session terpisah = Tidak ada bleeding

### 2. VerifyCsrfToken Middleware (MODIFIED)
**File**: `app/Http/Middleware/VerifyCsrfToken.php`

Cara kerja:
- Gunakan session yang sudah terisolasi
- Validasi token dari session yang aktif
- Support multiple token sources: _token, header, cookie
- Set CSRF cookie berdasarkan panel context

### 3. Kernel Update
**File**: `app/Http/Kernel.php`

Middleware order (PENTING!):
```
1. EncryptCookies
2. AddQueuedCookiesToResponse
3. SessionIsolation ← HARUS di sini, sebelum StartSession
4. StartSession
5. VerifyCsrfToken
6. SubstituteBindings
```

### 4. Database Migration
**File**: `database/migrations/2026_01_31_064423_add_guard_to_sessions_table.php`

Menambahkan kolom `guard` untuk tracking session ownership.

### 5. Routes
**File**: `routes/web.php`

Sudah menggunakan 'web' middleware group yang include SessionIsolation.

## Cara Kerja Session Isolation

```
User Panel (example.com/login)
    ↓
Cookie: laravel_session
Path: /
Session ID: abc123
CSRF: XSRF-TOKEN

Admin Panel (example.com/admin/login)
    ↓
Cookie: laravel_admin_session  
Path: /admin
Session ID: xyz789
CSRF: XSRF-TOKEN-ADMIN
```

Karena cookie name dan path berbeda:
- Browser mengirim cookie yang sesuai dengan URL
- Session terpisah di database
- Tidak ada konflik antar panel

## Langkah Deploy

### 1. Local Development
```bash
# Install dependencies
composer install

# Run migrations
php artisan migrate

# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Test
php test-isolation.php
```

### 2. Vercel Deployment
```bash
# Deploy
vercel --prod

# Run migrations di Vercel
https://your-app.vercel.app/seed-db
```

### 3. Environment Variables (vercel.json)
```json
{
  "env": {
    "SESSION_DRIVER": "database",
    "SESSION_LIFETIME": "120",
    "SESSION_COOKIE": "laravel_session",
    "SESSION_SECURE_COOKIE": "true"
  }
}
```

## Testing Manual

### Test 1: Dual Login
1. Buka Tab 1: `example.com/admin/login` → login admin
2. Buka Tab 2: `example.com/login` → login user
3. **Expected**: Kedua tab tetap login tanpa error 419

### Test 2: No Session Bleeding
1. Refresh admin panel → tetap di admin
2. Refresh user panel → tetap di user
3. **Expected**: Tidak ada pindah panel

### Test 3: CSRF Protection
1. Submit form di admin → sukses
2. Submit form di user → sukses
3. **Expected**: Tidak ada error 419

### Test 4: Cookie Isolation
1. Buka DevTools → Application → Cookies
2. **Expected**:
   - Admin: `laravel_admin_session` (path: /admin)
   - User: `laravel_session` (path: /)

## Troubleshooting

### Error 419 masih terjadi
```bash
# Clear browser cookies
# Clear server cache
php artisan cache:clear
php artisan config:clear
```

### Session masih tercampur
```bash
# Cek middleware order di Kernel.php
# Pastikan SessionIsolation sebelum StartSession
```

### Console error connection
Ini biasanya browser extension, bukan dari aplikasi. Abaikan jika tidak affect functionality.

## File yang Diubah/Dibuat

### Baru:
1. `app/Http/Middleware/SessionIsolation.php`
2. `app/Http/Middleware/VerifyCsrfToken.php` (overwrite)
3. `database/migrations/2026_01_31_064423_add_guard_to_sessions_table.php`
4. `test-isolation.php`

### Modified:
1. `app/Http/Kernel.php`
2. `routes/web.php` (sudah OK, tidak perlu ubah)

### Tidak perlu diubah:
- `config/auth.php` (sudah ada multi-guard)
- `config/session.php` (sudah database driver)

## Keunggulan Solusi Ini

✅ Sederhana - tidak over-engineered
✅ Working - cookie isolation yang sebenarnya
✅ Vercel compatible - database session
✅ No session bleeding - cookie path terpisah
✅ CSRF fixed - token dari session terisolasi
✅ No logout on refresh - session lifetime 120 menit

## Status

✅ Implementation: COMPLETE
✅ Local Test: PASSED
✅ Ready for Vercel: YES

---

**Catatan**: Solusi ini menggunakan cookie isolation yang merupakan approach paling reliable untuk session separation di Laravel. Dengan cookie name dan path yang berbeda, browser secara otomatis mengirim cookie yang sesuai dengan URL yang diakses.
