<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model pengaturan identitas sekolah.
 *
 * Tabel: school_settings (selalu 1 baris, id = 1)
 */
class SchoolSetting extends Model
{
    use HasFactory;

    protected $table = 'school_settings';

    protected $fillable = [
        'nama_sekolah',
        'singkatan',
        'logo',
        'favicon',
    ];

    /**
     * Ambil satu-satunya record, atau buat default jika belum ada.
     */
    public static function getSingle(): self
    {
        return self::firstOrCreate(
            ['id' => 1],
            [
                'nama_sekolah' => 'SMK Muhammadiyah 1 Bantul',
                'singkatan'    => 'SMK MUSABA',
                'logo'         => null,
                'favicon'      => null,
            ]
        );
    }

    /**
     * URL logo sekolah. Fallback ke logo default jika belum diupload.
     */
    public function getLogoUrlAttribute(): string
    {
        if ($this->logo && file_exists(storage_path('app/public/' . $this->logo))) {
            return asset('storage/' . $this->logo);
        }
        // Fallback ke file lama jika ada
        if (file_exists(public_path('storage/logomusaba.png'))) {
            return asset('storage/logomusaba.png');
        }
        // Fallback placeholder
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->singkatan) . '&background=f97316&color=fff&size=128&bold=true';
    }

    /**
     * URL favicon. Fallback ke logo jika favicon belum diupload.
     */
    public function getFaviconUrlAttribute(): string
    {
        if ($this->favicon && file_exists(storage_path('app/public/' . $this->favicon))) {
            return asset('storage/' . $this->favicon);
        }
        return $this->logo_url;
    }
}
