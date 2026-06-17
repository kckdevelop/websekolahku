<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpmbGelombang extends Model
{
    use HasFactory;

    protected $table = 'spmb_gelombangs';

    protected $fillable = [
        'nama_gelombang',
        'tahun_ajaran',
        'tanggal_mulai',
        'tanggal_selesai',
        'is_aktif',
        'keterangan',
    ];

    protected $casts = [
        'is_aktif'        => 'boolean',
        'tanggal_mulai'   => 'date',
        'tanggal_selesai' => 'date',
    ];

    /**
     * Activate this wave and deactivate all other waves.
     */
    public function activate(): void
    {
        self::where('id', '!=', $this->id)->update(['is_aktif' => false]);
        $this->update(['is_aktif' => true]);
    }
}
