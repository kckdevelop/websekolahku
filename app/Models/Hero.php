<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    use HasFactory;

    protected $table = 'heros';

    protected $fillable = [
        'judul',
        'deskripsi',
        'gambar',
        'gambar_url',
        'label_tombol',
        'link_tombol',
        'urutan',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'urutan' => 'integer',
    ];

    /**
     * Ambil URL gambar yang valid (upload lokal atau URL eksternal)
     */
    public function getGambarSrcAttribute(): string
    {
        if ($this->gambar) {
            return asset('storage/' . $this->gambar);
        }
        return $this->gambar_url ?? 'https://picsum.photos/1920/1080';
    }
}
