<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BkkSetting extends Model
{
    use HasFactory;

    protected $table = 'bkk_settings';

    protected $fillable = [
        'hero_title',
        'hero_subtitle',
        'hero_gambar',
        'tentang_judul',
        'tentang_deskripsi',
        'statistik',
        'layanan',
        'mitra_perusahaan',
        'kontak_nama',
        'kontak_telepon',
        'kontak_email',
        'kontak_jam_operasional',
        'kontak_lokasi',
        'cta_title',
        'cta_subtitle',
    ];

    protected $casts = [
        'statistik'       => 'array',
        'layanan'         => 'array',
        'mitra_perusahaan'=> 'array',
    ];

    /**
     * Get the hero image URL.
     */
    public function getHeroGambarSrcAttribute(): string
    {
        if ($this->hero_gambar) {
            return asset('storage/' . $this->hero_gambar);
        }
        return 'https://picsum.photos/seed/bkk-hero/1920/600';
    }

    /**
     * Get single settings row, create default if not exists.
     */
    public static function getSingle(): self
    {
        $defaultStatistik = [
            ['label' => 'Lulusan Tersalurkan', 'nilai' => '850+', 'ikon' => 'fa-users'],
            ['label' => 'Mitra Perusahaan',    'nilai' => '75+',  'ikon' => 'fa-building'],
            ['label' => 'Tingkat Penempatan',  'nilai' => '92%',  'ikon' => 'fa-chart-line'],
            ['label' => 'Tahun Berpengalaman', 'nilai' => '15+',  'ikon' => 'fa-award'],
        ];

        $defaultLayanan = [
            ['judul' => 'Informasi Lowongan', 'deskripsi' => 'Menyediakan dan menyebarluaskan informasi lowongan kerja dari perusahaan mitra kepada lulusan SMK.', 'ikon' => 'fa-briefcase'],
            ['judul' => 'Konsultasi Karir',   'deskripsi' => 'Layanan konsultasi perencanaan karir, pembuatan CV, dan persiapan wawancara kerja.', 'ikon' => 'fa-comments'],
            ['judul' => 'Job Fair Tahunan',   'deskripsi' => 'Penyelenggaraan job fair yang mempertemukan lulusan dengan puluhan perusahaan mitra secara langsung.', 'ikon' => 'fa-handshake'],
            ['judul' => 'Magang Industri',    'deskripsi' => 'Fasilitas program Praktik Kerja Lapangan (PKL) dan magang di perusahaan mitra terpercaya.', 'ikon' => 'fa-industry'],
        ];

        $defaultMitra = [
            ['nama' => 'PT Astra Honda Motor',    'logo' => null],
            ['nama' => 'PT Toyota Astra Motor',   'logo' => null],
            ['nama' => 'PT Yamaha Motor',          'logo' => null],
            ['nama' => 'PT Suzuki Indomobil',      'logo' => null],
            ['nama' => 'PT Samsung Electronics',   'logo' => null],
            ['nama' => 'PT Indofood',              'logo' => null],
        ];

        return self::firstOrCreate(
            ['id' => 1],
            [
                'hero_title'              => 'Bursa Kerja Khusus (BKK)',
                'hero_subtitle'           => 'Jembatan karir lulusan SMK Muhammadiyah 1 Bantul menuju dunia kerja profesional',
                'hero_gambar'             => null,
                'tentang_judul'           => 'Tentang BKK SMK Muh. 1 Bantul',
                'tentang_deskripsi'       => 'Bursa Kerja Khusus (BKK) SMK Muhammadiyah 1 Bantul adalah unit layanan resmi yang bertugas membantu lulusan mendapatkan pekerjaan sesuai kompetensi keahlian. BKK kami telah aktif menjalin kerja sama dengan ratusan perusahaan dari berbagai sektor industri, mulai dari otomotif, manufaktur, teknologi informasi, hingga elektronika.',
                'statistik'               => $defaultStatistik,
                'layanan'                 => $defaultLayanan,
                'mitra_perusahaan'        => $defaultMitra,
                'kontak_nama'             => 'Koordinator BKK SMK Muh. 1 Bantul',
                'kontak_telepon'          => '0274-123456',
                'kontak_email'            => 'bkk@smkmusaba.sch.id',
                'kontak_jam_operasional'  => 'Senin – Jumat, 08.00 – 14.00 WIB',
                'kontak_lokasi'           => 'Jl. Urip Sumoharjo No.8, Bantul, Yogyakarta',
                'cta_title'               => 'Siap Memasuki Dunia Kerja?',
                'cta_subtitle'            => 'Hubungi BKK kami dan temukan peluang karir terbaik untuk Anda.',
            ]
        );
    }
}
