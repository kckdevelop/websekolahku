<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Berita extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'slug',
        'konten',
        'gambar',
        'tanggal',
        'draft',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'draft' => 'boolean',
    ];

    /**
     * Accessor: URL gambar berita.
     */
    public function getGambarSrcAttribute(): string
    {
        if (!$this->gambar) {
            return 'https://picsum.photos/seed/berita-' . ($this->id ?? rand(1, 999)) . '/400/200';
        }

        if (\Illuminate\Support\Str::startsWith($this->gambar, ['http://', 'https://'])) {
            return $this->gambar;
        }

        $cleanPath = ltrim(str_replace('public/', '', $this->gambar), '/');
        if (\Illuminate\Support\Str::startsWith($cleanPath, 'storage/')) {
            $cleanPath = substr($cleanPath, 8);
        }

        if (Storage::disk('public')->exists($cleanPath)) {
            return url(Storage::url($cleanPath));
        }

        return asset('storage/' . $cleanPath);
    }


    /**
     * Accessor: ringkasan konten (150 karakter).
     */
    public function getRingkasanAttribute(): string
    {
        return \Illuminate\Support\Str::limit(strip_tags($this->konten), 120);
    }
}
