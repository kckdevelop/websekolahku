<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpmbPageContent extends Model
{
    use HasFactory;

    protected $table = 'spmb_page_contents';

    protected $fillable = [
        'hero_title',
        'hero_subtitle',
        'hero_gambar',
        'kuota_tkro',
        'kuota_tbsm',
        'kuota_tpm',
        'kuota_tav',
        'kuota_rpl',
        'alur_pendaftaran',
        'persyaratan',
        'foto_galeri',
        'cta_title',
        'cta_subtitle',
    ];

    protected $casts = [
        'alur_pendaftaran' => 'array',
        'persyaratan' => 'array',
        'foto_galeri' => 'array',
    ];

    /**
     * Get the hero image source URL.
     */
    public function getHeroGambarSrcAttribute(): string
    {
        if ($this->hero_gambar) {
            return asset('storage/' . $this->hero_gambar);
        }
        return 'https://picsum.photos/seed/spmb-hero/1920/600';
    }

    /**
     * Retrieve the single SpmbPageContent record, or create and return a default one.
     */
    public static function getSingle(): self
    {
        $defaultAlur = [
            ['judul' => 'Daftar Online', 'deskripsi' => 'Kunjungi portal PPDB resmi dan lengkapi formulir pendaftaran.'],
            ['judul' => 'Upload Berkas', 'deskripsi' => 'Unggah scan rapor kelas VII–IX, akta kelahiran, dan KK.'],
            ['judul' => 'Verifikasi Berkas', 'deskripsi' => 'Tunggu proses verifikasi dan validasi berkas oleh petugas admin sekolah.'],
            ['judul' => 'Seleksi & Pengumuman', 'deskripsi' => 'Hasil seleksi diumumkan melalui website dan SMS.'],
            ['judul' => 'Daftar Ulang', 'deskripsi' => 'Lakukan daftar ulang dengan membawa berkas asli.']
        ];

        $defaultPersyaratan = [
            'Lulus SMP/MTs atau sederajat (tahun 2023–2025)',
            'Usia maksimal 21 tahun pada 1 Juli 2025',
            'Rapor kelas VII–IX (semester 1–5)',
            'Akta kelahiran',
            'Kartu Keluarga (KK)',
            'Foto berwarna 3x4 (2 lembar)',
            'Tidak buta warna (khusus TKRO, TBSM, TPM)'
        ];

        $defaultGaleri = [
            ['gambar' => 'https://picsum.photos/seed/spmb1/400/300', 'deskripsi' => 'Pendaftaran SPMB'],
            ['gambar' => 'https://picsum.photos/seed/spmb2/400/300', 'deskripsi' => 'Verifikasi Berkas'],
            ['gambar' => 'https://picsum.photos/seed/spmb3/400/300', 'deskripsi' => 'Sosialisasi Jurusan'],
            ['gambar' => 'https://picsum.photos/seed/spmb4/400/300', 'deskripsi' => 'Pengumuman Kelulusan']
        ];

        return self::firstOrCreate(
            ['id' => 1],
            [
                'hero_title' => 'SPMB 2026/2027',
                'hero_subtitle' => 'Seleksi Penerimaan Peserta Didik Baru',
                'hero_gambar' => null,
                'kuota_tkro' => '5 Kelas',
                'kuota_tbsm' => '3 Kelas',
                'kuota_tpm' => '3 Kelas',
                'kuota_tav' => '2 Kelas',
                'kuota_rpl' => '3 Kelas',
                'alur_pendaftaran' => $defaultAlur,
                'persyaratan' => $defaultPersyaratan,
                'foto_galeri' => $defaultGaleri,
                'cta_title' => 'Siap Bergabung?',
                'cta_subtitle' => 'Daftar sekarang dan dapatkan bonus eksklusif untuk pendaftar awal!',
            ]
        );
    }
}
