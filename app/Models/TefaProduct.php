<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TefaProduct extends Model
{
    protected $table = 'tefa_products';

    protected $fillable = [
        'nama',
        'deskripsi',
        'harga',
        'gambar',
        'gambar_tambahan',
        'aktif',
        'urutan',
        'jurusan_content_id',
    ];

    protected $casts = [
        'aktif'           => 'boolean',
        'harga'           => 'integer',
        'gambar_tambahan' => 'array',
    ];

    /**
     * Relasi ke program keahlian (jurusan).
     */
    public function jurusanContent()
    {
        return $this->belongsTo(JurusanContent::class, 'jurusan_content_id');
    }

    /**
     * Scope to only include active products.
     */
    public function scopeActive($query)
    {
        return $query->where('aktif', true);
    }

    /**
     * Scope to filter by jurusan.
     */
    public function scopeByJurusan($query, $jurusanId)
    {
        return $query->where('jurusan_content_id', $jurusanId);
    }

    /**
     * Get product image source URL.
     */
    public function getGambarSrcAttribute(): string
    {
        if ($this->gambar) {
            return asset('storage/' . $this->gambar);
        }
        return asset('images/default-product.png');
    }

    /**
     * Get all images (cover + additional) as array of URLs.
     */
    public function getAllGambarAttribute(): array
    {
        $all = [];
        if ($this->gambar) {
            $all[] = asset('storage/' . $this->gambar);
        }
        if ($this->gambar_tambahan) {
            foreach ($this->gambar_tambahan as $path) {
                $all[] = asset('storage/' . $path);
            }
        }
        return $all;
    }
}
