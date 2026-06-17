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
        if ($this->gambar && Storage::disk('public')->exists($this->gambar)) {
            return Storage::url($this->gambar);
        }
        return 'https://picsum.photos/seed/berita-' . $this->id . '/400/200';
    }

    /**
     * Accessor: ringkasan konten (150 karakter).
     */
    public function getRingkasanAttribute(): string
    {
        return \Illuminate\Support\Str::limit(strip_tags($this->konten), 120);
    }
}
