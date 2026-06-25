<?php

namespace Database\Seeders;

use App\Models\GaleriVideo;
use Illuminate\Database\Seeder;

/**
 * Seed video profil sekolah.
 * Ganti 'youtube_id' dengan ID video YouTube yang benar.
 */
class GaleriVideoSeeder extends Seeder
{
    public function run(): void
    {
        $videos = [
            [
                'judul'      => 'PROFIL SMK MUHAMMADIYAH 1 BANTUL',
                'deskripsi'  => 'Simak perjalanan, fasilitas, kegiatan, dan prestasi kami dalam video profil resmi SMK Muhammadiyah 1 Bantul.',
                'youtube_id' => '9c0dJnFd8RY', // ← Ganti dengan ID video resmi
                'kategori'   => 'Profil',
                'tanggal'    => '2025-05-01',
                'views'      => 0,
                'durasi'     => '05:24',
            ],
            [
                'judul'      => 'Praktikum Otomotif & Servis Berkala Mobil',
                'deskripsi'  => 'Dokumentasi praktikum kompetensi keahlian Teknik Kendaraan Ringan di bengkel sekolah.',
                'youtube_id' => '9c0dJnFd8RY', // ← Ganti dengan ID video resmi
                'kategori'   => 'Praktik',
                'tanggal'    => '2025-09-12',
                'views'      => 0,
                'durasi'     => '03:15',
            ],
        ];

        foreach ($videos as $video) {
            GaleriVideo::firstOrCreate(
                ['judul' => $video['judul']],
                $video
            );
        }

        $this->command->info('✅ Galeri video berhasil di-seed.');
        $this->command->warn('⚠️  Perbarui youtube_id pada tabel galeri_videos melalui panel admin!');
    }
}
