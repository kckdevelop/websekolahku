# 📦 Panduan Deploy Database ke Hosting

## Struktur File

```
database/
├── migrations/
│   ├── 2026_06_25_000001_create_all_tables_consolidated.php  ← GUNAKAN INI untuk hosting baru
│   └── (39 file lama — untuk referensi, JANGAN dijalankan bersamaan)
│
└── seeders/
    ├── DatabaseSeeder.php          ← Entry point utama (production)
    ├── AdminUserSeeder.php         ← Akun admin & petugas
    ├── PetugasWawancaraSeeder.php  ← Daftar petugas wawancara
    ├── GaleriFotoSeeder.php        ← Konfigurasi Google Drive
    ├── GaleriVideoSeeder.php       ← Video profil sekolah
    ├── JurusanContentSeeder.php    ← Konten 5 jurusan (default)
    │
    └── DummyPendaftarSeeder.php    ← ⛔ DEV ONLY — jangan di production
```

---

## 🚀 Langkah Deploy ke Hosting (Fresh Database)

### Opsi A: Menggunakan Migration Consolidated (Direkomendasikan)

Jika database **kosong / baru**:

```bash
# 1. Salin hanya file migration consolidated ke hosting
#    (hapus atau abaikan 39 file migration lama)

# 2. Jalankan migration
php artisan migrate

# 3. Jalankan seeder production
php artisan db:seed
```

### Opsi B: Menggunakan Semua Migration Lama

Jika ingin menggunakan migration terpisah (development flow):

```bash
# Pastikan semua 39 file migration ada di folder migrations/
# HAPUS file consolidated agar tidak bentrok
php artisan migrate
php artisan db:seed
```

---

## ⚠️  Catatan Penting

### Untuk Production:
- ❌ **JANGAN** jalankan `DummyPendaftarSeeder` / `DummyDataSeeder`
- ✅ Ganti semua password default SEGERA setelah pertama login
- ✅ Set `APP_ENV=production` dan `APP_DEBUG=false` di `.env`
- ✅ Jalankan `php artisan config:cache` dan `php artisan route:cache`
- ✅ Jalankan `php artisan storage:link` untuk symlink storage

### Akun Default (Ganti Segera!):

| Role               | Email                              | Password Default |
|--------------------|-------------------------------------|------------------|
| Admin              | admin@smkmuh1bantul.sch.id         | admin123         |
| Petugas            | petugas@smkmuh1bantul.sch.id       | petugas123       |
| Petugas Kesehatan  | kesehatan@smkmuh1bantul.sch.id     | kesehatan123     |
| Petugas Wawancara  | wawancara@smkmuh1bantul.sch.id     | wawancara123     |
| Petugas Pembayaran | pembayaran@smkmuh1bantul.sch.id    | pembayaran123    |

### Ganti Password via Tinker:
```bash
php artisan tinker
>>> User::where('email','admin@smkmuh1bantul.sch.id')->first()->update(['password'=>Hash::make('password_baru_anda')]);
```

---

## 🔧 Setelah Deploy

```bash
# Buat storage link
php artisan storage:link

# Cache konfigurasi (production)
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Jalankan hanya di DEVELOPMENT untuk data dummy:
php artisan db:seed --class=DummyPendaftarSeeder
```

---

## 📝 Checklist Upload ke Hosting

- [ ] File `.env` sudah dikonfigurasi (DB, APP_KEY, APP_URL)
- [ ] `php artisan key:generate` sudah dijalankan (jika APP_KEY kosong)
- [ ] `composer install --no-dev --optimize-autoloader`
- [ ] `php artisan migrate` berhasil
- [ ] `php artisan db:seed` berhasil
- [ ] `php artisan storage:link` berhasil
- [ ] Folder `storage/` dan `bootstrap/cache/` writable (chmod 775)
- [ ] Password default sudah diganti
- [ ] `APP_DEBUG=false` di `.env`
