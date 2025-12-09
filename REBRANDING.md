# Rebranding: SIPESAN → ALKAHFI DIGITAL

## 📋 Perubahan yang Dilakukan

### 1. Nama Aplikasi
- **Sebelum:** SIPESAN
- **Sesudah:** ALKAHFI DIGITAL

### 2. Database
- **Sebelum:** `sipesan_db`
- **Sesudah:** `alkahfi_digital_db`

### 3. Email Domain
- **Sebelum:** `@sipesan.id`
- **Sesudah:** `@alkahfi.digital`

## 📁 File yang Diubah

### Konfigurasi
1. ✅ `.env`
   - `APP_NAME="ALKAHFI DIGITAL"`
   - `DB_DATABASE=alkahfi_digital_db`

### Database Seeders
2. ✅ `database/seeders/DatabaseSeeder.php`
   - `admin@alkahfi.digital`
   - `bendahara@alkahfi.digital`
   - `wali@alkahfi.digital`

3. ✅ `database/seeders/SantriSeeder.php`
   - Update email reference

### Views
4. ✅ `resources/views/layouts/app.blade.php`
   - Sidebar brand: "ALKAHFI DIGITAL"

5. ✅ `resources/views/auth/login.blade.php`
   - Welcome message: "Selamat Datang di ALKAHFI DIGITAL"

6. ✅ `resources/views/admin/pembayaran/cetak.blade.php`
   - Header: "ALKAHFI DIGITAL - Sistem Pembayaran SPP Santri"

7. ✅ `resources/views/wali/pembayaran/cetak.blade.php`
   - Header: "ALKAHFI DIGITAL - Sistem Pembayaran SPP Santri"

### Services
8. ✅ `app/Services/MidtransService.php`
   - Default email: `noemail@alkahfi.digital`

## 🔄 Langkah Migrasi

### 1. Update Environment
```bash
# Copy .env yang sudah diupdate
cp .env.example .env

# Update APP_NAME dan DB_DATABASE
APP_NAME="ALKAHFI DIGITAL"
DB_DATABASE=alkahfi_digital_db
```

### 2. Buat Database Baru
```sql
CREATE DATABASE alkahfi_digital_db;
```

### 3. Migrasi Data (Opsional)
Jika ingin memindahkan data dari database lama:

```bash
# Export data lama
mysqldump -u root -p sipesan_db > backup_sipesan.sql

# Import ke database baru
mysql -u root -p alkahfi_digital_db < backup_sipesan.sql
```

### 4. Atau Fresh Migration
```bash
# Drop semua table dan migrate ulang
php artisan migrate:fresh --seed
```

### 5. Clear Cache
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

## 👥 Akun Default Baru

Setelah seeding, gunakan akun berikut:

### Administrator
- Email: `admin@alkahfi.digital`
- Password: `password`

### Bendahara
- Email: `bendahara@alkahfi.digital`
- Password: `password`

### Wali Santri
- Email: `wali@alkahfi.digital`
- Password: `password`

## ⚠️ Catatan Penting

1. **Database Lama**
   - Database `sipesan_db` tidak akan otomatis terhapus
   - Backup terlebih dahulu sebelum menghapus

2. **User Existing**
   - User dengan email `@sipesan.id` masih bisa login
   - Perlu update manual jika ingin mengubah email mereka

3. **Session**
   - User yang sedang login perlu login ulang
   - Session lama akan invalid

4. **Email Notifications**
   - Update MAIL_FROM_NAME di .env jika perlu
   - Pastikan email sender sesuai dengan branding baru

## 🎨 Branding Assets

### Logo & Icon
- Update logo di `public/landing/img/`
- Update favicon di `public/`
- Update logo di profil sekolah (via admin panel)

### Color Scheme
Warna utama tetap sama, namun bisa disesuaikan di:
- `resources/views/layouts/app.blade.php` (CSS variables)
- `public/css/landing-modern.css`

## 📞 Support

Jika ada pertanyaan atau masalah terkait rebranding:
1. Check file .env sudah benar
2. Clear semua cache Laravel
3. Restart web server
4. Check database connection

---

**Version:** 1.0  
**Date:** December 2024  
**Status:** ✅ Completed
