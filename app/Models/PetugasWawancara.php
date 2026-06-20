<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PetugasWawancara extends Model
{
    use HasFactory;

    protected $table = 'petugas_wawancaras';

    protected $fillable = [
        'nama',
        'jabatan',
        'nip',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    /**
     * Daftar pendaftaran yang diwawancarai oleh petugas ini.
     */
    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class, 'petugas_wawancara_id');
    }
}
