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
        'kode_gelombang',
        'tahun_ajaran',
        'tanggal_mulai',
        'tanggal_selesai',
        'is_aktif',
        'keterangan',
        'biaya_pendaftaran',
        'biaya_spp_default',
        'biaya_zakat_default',
        'potongan_subsidi',
    ];

    protected $casts = [
        'is_aktif'           => 'boolean',
        'kode_gelombang'     => 'integer',
        'tanggal_mulai'      => 'date',
        'tanggal_selesai'    => 'date',
        'biaya_pendaftaran'  => 'decimal:2',
        'biaya_spp_default'  => 'decimal:2',
        'biaya_zakat_default'=> 'decimal:2',
        'potongan_subsidi'   => 'decimal:2',
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
