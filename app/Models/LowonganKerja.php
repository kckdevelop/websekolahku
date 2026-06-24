<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LowonganKerja extends Model
{
    use HasFactory;

    protected $table = 'lowongan_kerjas';

    protected $fillable = [
        'nama_perusahaan',
        'logo_perusahaan',
        'posisi',
        'lokasi',
        'tipe_pekerjaan',
        'jurusan_relevan',
        'batas_lamaran',
        'deskripsi',
        'brosur',
        'persyaratan',
        'kontak_lamaran',
        'aktif',
        'urutan',
    ];

    protected $casts = [
        'persyaratan'    => 'array',
        'aktif'          => 'boolean',
        'batas_lamaran'  => 'date',
    ];

    /**
     * Get logo URL.
     */
    public function getLogoSrcAttribute(): string
    {
        if ($this->logo_perusahaan) {
            return asset('storage/' . $this->logo_perusahaan);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->nama_perusahaan) . '&background=f97316&color=fff&size=80';
    }

    /**
     * Get brochure URL.
     */
    public function getBrosurSrcAttribute(): ?string
    {
        if ($this->brosur) {
            return asset('storage/' . $this->brosur);
        }
        return null;
    }

    /**
     * Check if the lowongan is still open (batas_lamaran >= today).
     */
    public function getIsOpenAttribute(): bool
    {
        return $this->batas_lamaran >= now()->toDateString();
    }

    /**
     * Scope for active + open lowongan.
     */
    public function scopeAktifTerbuka($query)
    {
        return $query->where('aktif', true)->where('batas_lamaran', '>=', now()->toDateString());
    }
}
