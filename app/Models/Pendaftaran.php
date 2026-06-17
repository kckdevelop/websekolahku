<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pendaftarans';

    protected $fillable = [
        'siswa_akun_id',
        'no_daftar',
        'tahun_aktif',
        'gelombang',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'no_hp_siswa',
        'asal_sekolah',
        'alamat_sekolah',
        'prestasi',
        'nama_ortu',
        'pekerjaan_ortu',
        'no_hp_ortu',
        
        // Alamat Asal
        'jalan_asal',
        'dusun_asal',
        'rt_asal',
        'rw_asal',
        'desa_asal',
        'kecamatan_asal',
        'kabupaten_asal',
        'provinsi_asal',
        
        // Alamat Tinggal
        'jalan_tinggal',
        'dusun_tinggal',
        'rt_tinggal',
        'rw_tinggal',
        'desa_tinggal',
        'kecamatan_tinggal',
        'kabupaten_tinggal',
        'provinsi_tinggal',
        
        // Pilihan Jurusan
        'pil1',
        'pil2',
        'pil3',
        
        // Berkas
        'foto_akta',
        'foto_kk',
        'foto_siswa',
        'berkas_lengkap',
        'catatan_petugas',
        'verified_at',
        'status',

        // UKS / Kesehatan
        'kesehatan_tinggi_badan',
        'kesehatan_berat_badan',
        'kesehatan_golongan_darah',
        'kesehatan_buta_warna',
        'kesehatan_mata_minus',
        'kesehatan_tato_tindik',
        'kesehatan_riwayat_penyakit',
        'kesehatan_catatan',
        'kesehatan_petugas',
        'kesehatan_verified_at',

        // Gaya Belajar & Minat
        'gaya_belajar_tipe',
        'gaya_belajar_minat_bakat',
        'gaya_belajar_catatan',
        'gaya_belajar_petugas',
        'gaya_belajar_verified_at',

        // Wawancara
        'wawancara_baca_tulis_alquran',
        'wawancara_solat_fardhu',
        'wawancara_kepribadian',
        'wawancara_catatan',
        'wawancara_petugas',
        'wawancara_verified_at',

        // Pembayaran
        'pembayaran_nominal',
        'pembayaran_status',
        'pembayaran_keterangan',
        'pembayaran_petugas',
        'pembayaran_verified_at',
    ];

    protected $casts = [
        'tanggal_lahir'  => 'date',
        'berkas_lengkap' => 'array',
        'verified_at'    => 'datetime',
        'kesehatan_verified_at' => 'datetime',
        'gaya_belajar_verified_at' => 'datetime',
        'wawancara_verified_at' => 'datetime',
        'pembayaran_verified_at' => 'datetime',
    ];

    /**
     * Relasi ke SiswaAkun.
     */
    public function siswaAkun()
    {
        return $this->belongsTo(SiswaAkun::class, 'siswa_akun_id');
    }
}
