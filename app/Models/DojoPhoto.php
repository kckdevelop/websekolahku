<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DojoPhoto extends Model
{
    protected $table = 'dojo_photos';

    protected $fillable = [
        'judul',
        'unit_dojo',
        'deskripsi',
        'foto',
        'urutan',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'urutan' => 'integer',
    ];

    public function getFotoSrcAttribute(): string
    {
        if ($this->foto) {
            if (str_starts_with($this->foto, 'http://') || str_starts_with($this->foto, 'https://')) {
                return $this->foto;
            }
            return asset('storage/' . $this->foto);
        }
        return 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=800&q=80';
    }

    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    public function scopeByUnit($query, $unit)
    {
        if ($unit && $unit !== 'Semua') {
            return $query->where('unit_dojo', $unit);
        }
        return $query;
    }
}
