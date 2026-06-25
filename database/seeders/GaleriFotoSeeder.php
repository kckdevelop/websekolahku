<?php

namespace Database\Seeders;

use App\Models\GaleriFoto;
use App\Models\GaleriVideo;
use Illuminate\Database\Seeder;

/**
 * Seed konfigurasi galeri foto (Google Drive) dan video profil sekolah.
 */
class GaleriFotoSeeder extends Seeder
{
    public function run(): void
    {
        // -- Galeri Foto (Google Drive) --
        GaleriFoto::firstOrCreate(
            ['judul' => 'Album Foto Kegiatan'],
            [
                'folder_id' => '0B6IFRRkB6oTeSUVBc1E2U3JxQVk',
                'deskripsi' => 'Dokumentasi foto kegiatan dan prestasi SMK Muhammadiyah 1 Bantul',
            ]
        );

        $this->command->info('✅ Galeri foto berhasil dikonfigurasi.');
    }
}
