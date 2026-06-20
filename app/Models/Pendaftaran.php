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
        'nomor_pembayaran',
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

        // Biaya (ditetapkan saat wawancara)
        'biaya_spp',
        'biaya_dana_awal_tahun',
        'biaya_zakat',
        'biaya_infaq',
        'biaya_potongan',
        'total_tagihan',
        'biaya_petugas',
        'biaya_verified_at',

        // Diterima di Jurusan
        'diterima_di_jurusan',
        'ukuran_seragam',
        'petugas_wawancara_id',

        // Pembayaran (ringkasan)
        'pembayaran_nominal',
        'pembayaran_status',
        'pembayaran_keterangan',
        'pembayaran_petugas',
        'pembayaran_verified_at',
    ];

    protected $casts = [
        'tanggal_lahir'            => 'date',
        'berkas_lengkap'           => 'array',
        'verified_at'              => 'datetime',
        'kesehatan_verified_at'    => 'datetime',
        'gaya_belajar_verified_at' => 'datetime',
        'wawancara_verified_at'    => 'datetime',
        'biaya_verified_at'        => 'datetime',
        'pembayaran_verified_at'   => 'datetime',
        'biaya_spp'                => 'decimal:2',
        'biaya_dana_awal_tahun'    => 'decimal:2',
        'biaya_zakat'              => 'decimal:2',
        'biaya_infaq'              => 'decimal:2',
        'biaya_potongan'           => 'decimal:2',
        'total_tagihan'            => 'decimal:2',
        'pembayaran_nominal'       => 'decimal:2',
    ];

    /**
     * Relasi ke SiswaAkun.
     */
    public function siswaAkun()
    {
        return $this->belongsTo(SiswaAkun::class, 'siswa_akun_id');
    }

    /**
     * Relasi ke RiwayatPembayaran.
     */
    public function riwayatPembayaran()
    {
        return $this->hasMany(RiwayatPembayaran::class)->orderBy('created_at', 'asc');
    }

    /**
     * Relasi ke PetugasWawancara (pewawancara).
     */
    public function petugasWawancara()
    {
        return $this->belongsTo(\App\Models\PetugasWawancara::class, 'petugas_wawancara_id');
    }

    /**
     * Total uang yang sudah dibayarkan (sum semua riwayat).
     */
    public function getTotalTerbayarAttribute(): float
    {
        return (float) $this->riwayatPembayaran()->sum('nominal');
    }

    /**
     * Sisa tagihan yang belum dibayar.
     */
    public function getSisaTagihanAttribute(): float
    {
        if (!$this->total_tagihan) return 0;
        $sisa = (float) $this->total_tagihan - $this->total_terbayar;
        return max(0, $sisa);
    }

    /**
     * Label status pembayaran otomatis berdasarkan riwayat.
     * lunas | cicilan | belum_bayar
     */
    public function getStatusBayarAttribute(): string
    {
        if (!$this->total_tagihan) return 'belum_bayar';
        $terbayar = $this->total_terbayar;
        if ($terbayar <= 0) return 'belum_bayar';
        if ($terbayar >= (float) $this->total_tagihan) return 'lunas';
        return 'cicilan';
    }

    /**
     * Persentase pembayaran (0-100).
     */
    public function getPersenBayarAttribute(): int
    {
        if (!$this->total_tagihan || $this->total_tagihan <= 0) return 0;
        return (int) min(100, round(($this->total_terbayar / (float) $this->total_tagihan) * 100));
    }
}
