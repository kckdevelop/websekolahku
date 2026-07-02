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
     * Only one wave can be active at a time.
     */
    public function activate(): void
    {
        self::where('id', '!=', $this->id)->update(['is_aktif' => false]);
        $this->update(['is_aktif' => true]);
    }

    /**
     * Get the currently active gelombang.
     */
    public static function getActive(): ?self
    {
        return self::where('is_aktif', true)->first();
    }

    /**
     * Generate the next no_daftar for this gelombang.
     * Format: MSB[YY]-[KK]-[NNN]
     *   YY  = 2-digit start year from tahun_ajaran
     *   KK  = 2-digit kode_gelombang (integer field, reliable)
     *   NNN = sequential 3-digit counter per prefix
     */
    public function generateNoDaftar(): string
    {
        // Year from tahun_ajaran e.g. "2026/2027" → "26"
        $year2 = '26';
        if (preg_match('/^(\d{4})/', $this->tahun_ajaran ?? '', $m)) {
            $year2 = substr($m[1], -2);
        }

        // Kode gelombang as 2-digit integer
        $kode = str_pad((int) $this->kode_gelombang, 2, '0', STR_PAD_LEFT);

        $prefix = 'MSB' . $year2 . '-' . $kode . '-';

        $last = \App\Models\Pendaftaran::where('no_daftar', 'like', $prefix . '%')
            ->orderBy('no_daftar', 'desc')
            ->first();

        $nextNum = $last ? ((int) substr($last->no_daftar, -3) + 1) : 1;

        return $prefix . str_pad($nextNum, 3, '0', STR_PAD_LEFT);
    }
}
