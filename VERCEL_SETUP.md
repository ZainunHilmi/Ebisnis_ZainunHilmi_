# Panduan Deployment Vercel

Agar aplikasi ini dapat berjalan sempurna dan bisa melakukan Login/Register database TiDB, Anda **WAJIB** menambahkan Environment Variables berikut di Dashboard Vercel.

1. Buka Dashboard Vercel -> Project Anda -> **Settings** -> **Environment Variables**.
2. Masukkan data berikut (Salin dari file `.env` lokal Anda):

| Key | Value |
| --- | --- |
| `APP_KEY` | (Isi dengan APP_KEY dari .env Anda) |
| `DB_CONNECTION` | `mysql` |
| `DB_HOST` | `gateway01.ap-northeast-1.prod.aws.tidbcloud.com` |
| `DB_PORT` | `4000` |
| `DB_DATABASE` | `test` |
| `DB_USERNAME` | `CF3jpQX5kPzAEus.root` |
| `DB_PASSWORD` | `u2Fhfij1uMV7kbga` |
| `MYSQL_ATTR_SSL_CA` | `isrgrootx1.pem` |

**Catatan:**
- Tanpa variabel di atas, aplikasi akan menggunakan `cookie` untuk session (tidak crash), tetapi gagal saat mencoba Login atau transaksi database.
- Pastikan `isrgrootx1.pem` ada di root folder (sudah terupload).

**Validasi:**
Setelah input variables, buka `https://<domain-vercel>/debug-env`. Pastikan output:
- `DB_CONNECTION: mysql`
- `DB_HOST: <alamat-tidb-anda>` (Bukan NOT SET)
- `OK: DB_CONNECTION is set to 'mysql'`

**3. Initial Database Seeding (Wajib Sekali Saja)**
Agar bisa Login, Anda perlu membuat data user admin di database TiDB.
1. Buka browser: `https://<domain-vercel>/seed-db`
2. Tunggu hingga muncul pesan "🎉 Seeding Complete!".
3. Login dengan:
   - Email: `admin@example.com`
   - Pass: `password`
