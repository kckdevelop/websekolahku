<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Prestasi;
use App\Models\GaleriFoto;
use App\Models\GaleriVideo;
use App\Models\Testimoni;
use App\Models\Pendaftaran;
use App\Models\SpmbGelombang;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'berita' => Berita::count(),
            'prestasi' => Prestasi::count(),
            'galeri_foto' => GaleriFoto::count(),
            'galeri_video' => GaleriVideo::count(),
            'testimoni' => Testimoni::count(),
            'pendaftaran_pending' => Pendaftaran::where('status', 'pending')->count(),
            'pendaftaran_total' => Pendaftaran::count(),
        ];

        // Ambil data gelombang dari database (dinamis)
        $gelombangs = SpmbGelombang::orderBy('tanggal_mulai', 'asc')->get();

        // Buat map: nomor gelombang (2-digit dari no_daftar) => nama gelombang
        // Format no_daftar: MSB26-01-001 -> bagian [1] adalah kode gelombang
        $gelMap = []; // kode => nama (e.g. '01' => 'Gelombang I')
        foreach ($gelombangs as $g) {
            $cleanWave = strtolower(trim($g->nama_gelombang));
            $waveNum = '01';
            if (preg_match('/\d+/', $cleanWave, $m)) {
                $waveNum = str_pad($m[0], 2, '0', STR_PAD_LEFT);
            } elseif (str_contains($cleanWave, 'iii')) {
                $waveNum = '03';
            } elseif (str_contains($cleanWave, 'ii')) {
                $waveNum = '02';
            } elseif (str_contains($cleanWave, 'i')) {
                $waveNum = '01';
            }
            $gelMap[$waveNum] = $g->nama_gelombang;
        }

        // Jika belum ada gelombang di DB, fallback ke kolom statis
        if (empty($gelMap)) {
            $gelMap = ['01' => 'Gelombang I', '02' => 'Gelombang II', '03' => 'Gelombang III'];
        }

        // Fetch registration data for stats tables
        $pendaftarans = Pendaftaran::select('no_daftar', 'pil1', 'status', 'verified_at')->get();

        $jurusans = ['TKR', 'TPM', 'TAV', 'TBSM', 'RPL'];
        $gelKeys  = array_keys($gelMap); // e.g. ['01','02','03']

        // Initialize structures
        $initRow = array_fill_keys($gelKeys, 0);
        $initRow['total'] = 0;

        $dataPendaftar = [];
        $dataCalon     = [];
        $dataDiterima  = [];

        foreach ($jurusans as $j) {
            $dataPendaftar[$j] = $initRow;
            $dataCalon[$j]     = $initRow;
            $dataDiterima[$j]  = $initRow;
        }

        $totalPendaftar = $initRow;
        $totalCalon     = $initRow;
        $totalDiterima  = $initRow;

        foreach ($pendaftarans as $p) {
            // Format: MSB26-01-001 => parts[1] = '01'
            $parts  = explode('-', $p->no_daftar);
            $gelKey = isset($parts[1]) ? $parts[1] : null;

            // Hanya hitung jika kode gelombang dikenal
            if (!$gelKey || !isset($gelMap[$gelKey])) {
                $gelKey = null;
            }

            $jur = $p->pil1;
            if (!in_array($jur, $jurusans)) {
                continue;
            }

            // 1. Statistik Pendaftar
            // Hanya tambahkan ke kolom gelombang DAN total jika gelKey dikenali
            // Sehingga: sum(kolom gelombang) == kolom Total == baris Total footer
            if ($gelKey) {
                $dataPendaftar[$jur][$gelKey]++;
                $dataPendaftar[$jur]['total']++;
                $totalPendaftar[$gelKey]++;
                $totalPendaftar['total']++;
            }

            // 2. Statistik Calon Siswa (sudah diverifikasi oleh petugas, verified_at tidak null)
            if ($p->verified_at !== null) {
                if ($gelKey) {
                    $dataCalon[$jur][$gelKey]++;
                    $dataCalon[$jur]['total']++;
                    $totalCalon[$gelKey]++;
                    $totalCalon['total']++;
                }
            }

            // 3. Statistik Siswa Diterima (status: diterima)
            if ($p->status === 'diterima') {
                if ($gelKey) {
                    $dataDiterima[$jur][$gelKey]++;
                    $dataDiterima[$jur]['total']++;
                    $totalDiterima[$gelKey]++;
                    $totalDiterima['total']++;
                }
            }
        }

        // Pastikan stats['pendaftaran_total'] konsisten dengan tabel statistik
        $stats['pendaftaran_total'] = $totalPendaftar['total'];

        return view('admin.dashboard', compact(
            'stats',
            'dataPendaftar',
            'dataCalon',
            'dataDiterima',
            'totalPendaftar',
            'totalCalon',
            'totalDiterima',
            'jurusans',
            'gelMap'
        ));
    }
}
