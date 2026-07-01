<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurusanContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'urutan',
        'aktif',
        'nama_jurusan',
        'icon',
        'hero_gambar',
        'hero_judul',
        'hero_subjudul',
        'deskripsi_1',
        'deskripsi_2',
        'poin_unggulan',
        'foto_kegiatan',
    ];

    protected $casts = [
        'poin_unggulan' => 'array',
        'foto_kegiatan' => 'array',
        'aktif'         => 'boolean',
    ];

    /**
     * Ambil jurusan yang aktif berurutan
     */
    public function scopeAktif($query)
    {
        return $query->where('aktif', true)->orderBy('urutan');
    }

    /**
     * Ambil konten jurusan berdasarkan slug, atau buat default jika belum ada
     */
    public static function getOrDefault(string $slug, array $defaults = []): self
    {
        return self::firstOrCreate(
            ['slug' => $slug],
            array_merge([
                'nama_jurusan'   => strtoupper($slug),
                'hero_judul'     => strtoupper($slug),
                'hero_subjudul'  => 'Program Keahlian ' . strtoupper($slug),
                'deskripsi_1'    => '',
                'deskripsi_2'    => '',
                'poin_unggulan'  => [],
                'aktif'          => true,
                'urutan'         => 0,
            ], $defaults)
        );
    }
}

