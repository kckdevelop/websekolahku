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
        $pendaftarans = Pendaftaran::select('no_daftar', 'pil1', 'diterima_di_jurusan', 'status', 'verified_at', 'jenis_kelamin')->get();

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

            // 1. & 2. Statistik Pendaftar dan Calon Siswa (berdasarkan pil1)
            $jur = $p->pil1;
            if (in_array($jur, $jurusans)) {
                // Statistik Pendaftar
                if ($gelKey) {
                    $dataPendaftar[$jur][$gelKey]++;
                    $dataPendaftar[$jur]['total']++;
                    $totalPendaftar[$gelKey]++;
                    $totalPendaftar['total']++;
                }

                // Statistik Calon Siswa (sudah diverifikasi oleh petugas, verified_at tidak null)
                if ($p->verified_at !== null) {
                    if ($gelKey) {
                        $dataCalon[$jur][$gelKey]++;
                        $dataCalon[$jur]['total']++;
                        $totalCalon[$gelKey]++;
                        $totalCalon['total']++;
                    }
                }
            }

            // 3. Statistik Siswa Diterima (diambil dari hasil wawancara: diterima_di_jurusan tidak null)
            $jurDiterima = $p->diterima_di_jurusan;
            if ($jurDiterima && in_array($jurDiterima, $jurusans)) {
                if ($gelKey) {
                    $dataDiterima[$jurDiterima][$gelKey]++;
                    $dataDiterima[$jurDiterima]['total']++;
                    $totalDiterima[$gelKey]++;
                    $totalDiterima['total']++;
                }
            }
        }

        // Statistik Siswa Diterima berdasarkan Jenis Kelamin
        $diTerimaGender = Pendaftaran::whereNotNull('diterima_di_jurusan')
            ->select('diterima_di_jurusan', 'jenis_kelamin')
            ->get();

        // Per jurusan breakdown
        $genderByJurusan = [];
        foreach ($jurusans as $j) {
            $genderByJurusan[$j] = ['L' => 0, 'P' => 0];
        }
        $totalGenderL = 0;
        $totalGenderP = 0;

        foreach ($diTerimaGender as $row) {
            $jur = $row->diterima_di_jurusan;
            $gender = strtoupper($row->jenis_kelamin);
            if (in_array($jur, $jurusans) && in_array($gender, ['L', 'P'])) {
                $genderByJurusan[$jur][$gender]++;
                if ($gender === 'L') $totalGenderL++;
                else $totalGenderP++;
            }
        }

        // Statistik Titip Bayar: pendaftar diterima yang sudah/belum melakukan pembayaran
        $pembayaranBase = Pendaftaran::whereNotNull('diterima_di_jurusan')
            ->select('diterima_di_jurusan', 'pembayaran_status', 'pembayaran_nominal', 'total_tagihan');

        // Per jurusan: belum_bayar, cicilan, lunas
        $pembayaranRows = (clone $pembayaranBase)->get();

        $pembayaranByJurusan = [];
        foreach ($jurusans as $j) {
            $pembayaranByJurusan[$j] = ['belum_bayar' => 0, 'cicilan' => 0, 'lunas' => 0, 'total' => 0];
        }

        $totalPembayaranBelum   = 0;
        $totalPembayaranCicilan = 0;
        $totalPembayaranLunas   = 0;
        $totalNominalTerkumpul  = 0;
        $totalNominalTagihan    = 0;

        foreach ($pembayaranRows as $row) {
            $jur    = $row->diterima_di_jurusan;
            $status = $row->pembayaran_status ?? 'belum_bayar';
            if (!in_array($status, ['belum_bayar', 'cicilan', 'lunas'])) {
                $status = 'belum_bayar';
            }
            if (in_array($jur, $jurusans)) {
                $pembayaranByJurusan[$jur][$status]++;
                $pembayaranByJurusan[$jur]['total']++;
            }
            if ($status === 'belum_bayar') $totalPembayaranBelum++;
            elseif ($status === 'cicilan')  $totalPembayaranCicilan++;
            elseif ($status === 'lunas')    $totalPembayaranLunas++;

            $totalNominalTerkumpul += (float) ($row->pembayaran_nominal ?? 0);
            $totalNominalTagihan   += (float) ($row->total_tagihan ?? 0);
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
            'gelMap',
            'genderByJurusan',
            'totalGenderL',
            'totalGenderP',
            'pembayaranByJurusan',
            'totalPembayaranBelum',
            'totalPembayaranCicilan',
            'totalPembayaranLunas',
            'totalNominalTerkumpul',
            'totalNominalTagihan'
        ));
    }
}
