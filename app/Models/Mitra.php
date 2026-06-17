<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    use HasFactory;

    protected $table = 'mitras';

    protected $fillable = [
        'nama',
        'logo',
        'logo_url',
        'link',
        'urutan',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'urutan' => 'integer',
    ];

    /**
     * Get resolved image/logo source path.
     */
    public function getLogoSrcAttribute(): string
    {
        if ($this->logo) {
            return asset('storage/' . $this->logo);
        }
        return $this->logo_url ?? 'https://picsum.photos/150/60?text=Mitra';
    }
}
