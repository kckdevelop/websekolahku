<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\GaleriFoto;
use App\Models\GaleriVideo;
use App\Models\JurusanContent;
use App\Models\NoboxSetting;
use App\Models\SpmbPageContent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * ============================================================
 * DATABASE SEEDER - Production Ready
 * SMK Muhammadiyah 1 Bantul
 * ============================================================
 * Seeder ini HANYA mengisi data wajib / konfigurasi awal:
 *   - Akun admin & petugas
 *   - Galeri foto (konfigurasi Google Drive)
 *   - Galeri video profil
 *   - Konten jurusan default
 *
 * Data dummy (pendaftar, berita, prestasi, testimoni) TIDAK
 * disertakan agar tidak mengotori database production.
 *
 * Untuk dev/testing, jalankan secara terpisah:
 *   php artisan db:seed --class=DummyPendaftarSeeder
 *
 * Jalankan: php artisan db:seed
 * ============================================================
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            PetugasWawancaraSeeder::class,
            GaleriFotoSeeder::class,
            GaleriVideoSeeder::class,
            JurusanContentSeeder::class,
        ]);
    }
}
