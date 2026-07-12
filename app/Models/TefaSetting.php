<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TefaSetting extends Model
{
    protected $table = 'tefa_settings';

    protected $fillable = [
        'hero_title',
        'hero_subtitle',
        'hero_gambar',
        'tentang_judul',
        'tentang_deskripsi',
        'telepon_wa',
    ];

    /**
     * Get the hero image source URL.
     */
    public function getHeroGambarSrcAttribute(): string
    {
        if ($this->hero_gambar) {
            return asset('storage/' . $this->hero_gambar);
        }
        return asset('images/default-tefa-hero.jpg');
    }

    /**
     * Retrieve the single TefaSetting record, or create and return a default one.
     */
    public static function getSingle(): self
    {
        $setting = self::first();

        if (!$setting) {
            $setting = self::create([
                'hero_title' => 'Teaching Factory (Tefa)',
                'hero_subtitle' => 'Mengembangkan Keterampilan Nyata Melalui Produk & Jasa Berkualitas',
                'hero_gambar' => null,
                'tentang_judul' => 'Apa itu Tefa SMK Muhammadiyah 1 Bantul?',
                'tentang_deskripsi' => 'Teaching Factory (Tefa) SMK Muhammadiyah 1 Bantul adalah konsep pembelajaran berbasis industri yang mensinergikan sekolah dengan dunia kerja untuk menghasilkan lulusan yang kompeten serta menghasilkan produk dan jasa berkualitas untuk masyarakat.',
                'telepon_wa' => '6281234567890',
            ]);
        }

        return $setting;
    }
}
