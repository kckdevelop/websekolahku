<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\SpmbGelombang;
use Illuminate\Http\Request;

class PetugasWawancaraController extends Controller
{
    public function index(Request $request)
    {
        $query = Pendaftaran::query()
            ->whereNotNull('verified_at')
            ->whereNotNull('kesehatan_verified_at')
            ->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_daftar', 'like', "%{$search}%")
                  ->orWhere('nama_lengkap', 'like', "%{$search}%");
            });
        }

        if ($request->filter === 'belum') {
            $query->where(function($q) {
                $q->whereNull('gaya_belajar_verified_at')
                  ->orWhereNull('wawancara_verified_at');
            });
        } elseif ($request->filter === 'sudah') {
            $query->whereNotNull('gaya_belajar_verified_at')
                  ->whereNotNull('wawancara_verified_at');
        }

        $perPage = $request->input('per_page', 20);
        if (!in_array($perPage, [10, 20, 50, 100])) {
            $perPage = 20;
        }

        $pendaftarans = $query->paginate($perPage)->withQueryString();

        $totalAll = Pendaftaran::whereNotNull('verified_at')
            ->whereNotNull('kesehatan_verified_at')
            ->count();
        $totalBelum = Pendaftaran::whereNotNull('verified_at')
            ->whereNotNull('kesehatan_verified_at')
            ->where(function($q) {
                $q->whereNull('gaya_belajar_verified_at')
                  ->orWhereNull('wawancara_verified_at');
            })
            ->count();
        $totalSudah = Pendaftaran::whereNotNull('verified_at')
            ->whereNotNull('kesehatan_verified_at')
            ->whereNotNull('gaya_belajar_verified_at')
            ->whereNotNull('wawancara_verified_at')
            ->count();

        if ($request->ajax()) {
            return view('petugas.wawancara.table', compact('pendaftarans'))->render();
        }

        return view('petugas.wawancara.index', compact('pendaftarans', 'totalAll', 'totalBelum', 'totalSudah'));
    }

    public function show(Pendaftaran $pendaftaran)
    {
        // Ambil gelombang aktif untuk referensi biaya default
        $gelombangAktif = SpmbGelombang::where('is_aktif', true)->first();
        // Ambil daftar petugas pewawancara aktif (atau yang sedang terhubung)
        $pewawancaras = \App\Models\PetugasWawancara::where('aktif', true)
            ->orWhere('id', $pendaftaran->petugas_wawancara_id)
            ->orderBy('nama')
            ->get();
        return view('petugas.wawancara.show', compact('pendaftaran', 'gelombangAktif', 'pewawancaras'));
    }

    public function update(Request $request, Pendaftaran $pendaftaran)
    {
        $request->validate([
            // Pewawancara
            'petugas_wawancara_id'       => 'required|exists:petugas_wawancaras,id',

            // Gaya Belajar & Minat
            'gaya_belajar_tipe'          => 'nullable|in:visual,auditori,kinestetik',
            'gaya_belajar_minat_bakat'   => 'nullable|string',
            'gaya_belajar_catatan'       => 'nullable|string',

            // Wawancara Keagamaan & Kepribadian
            'wawancara_baca_tulis_alquran' => 'required|string',
            'wawancara_solat_fardhu'       => 'required|string',
            'wawancara_kepribadian'        => 'required|string',
            'wawancara_catatan'            => 'nullable|string',

            // Penerimaan Jurusan & Seragam & Status Kelulusan
            'diterima_di_jurusan'          => 'required|string',
            'ukuran_seragam'               => 'required|string',
            'status'                       => 'required|in:diterima,ditolak',

            // Penetapan Biaya
            'biaya_spp'             => 'required|numeric|min:0',
            'biaya_dana_awal_tahun' => 'required|numeric|min:0',
            'biaya_infaq'           => 'required|numeric|min:0',
        ], [
            'petugas_wawancara_id.required'  => 'Petugas pewawancara wajib dipilih.',
            'petugas_wawancara_id.exists'    => 'Petugas pewawancara tidak valid.',
            'biaya_spp.required'             => 'Nominal SPP wajib diisi.',
            'biaya_dana_awal_tahun.required' => 'Nominal dana awal tahun wajib diisi.',
            'biaya_infaq.required'           => 'Nominal infaq wajib diisi.',
            'diterima_di_jurusan.required'   => 'Status jurusan yang diterima wajib diisi.',
            'ukuran_seragam.required'        => 'Ukuran seragam wajib diisi.',
            'status.required'                => 'Status kelulusan siswa wajib dipilih.',
            'status.in'                      => 'Status kelulusan siswa tidak valid.',
        ]);

        $biayaSpp           = (float) $request->biaya_spp;
        $biayaDanaAwalTahun = (float) $request->biaya_dana_awal_tahun;
        $biayaInfaq         = (float) $request->biaya_infaq;

        // Ambil potongan dari gelombang aktif
        $gelombangAktif     = SpmbGelombang::where('is_aktif', true)->first();
        $biayaPotongan      = $gelombangAktif ? (float) $gelombangAktif->potongan_subsidi : 0;

        $totalTagihan       = max(0, $biayaDanaAwalTahun + $biayaInfaq - $biayaPotongan);

        $wawancaraVerifiedAt = now();
        $noDaftarLast3 = substr($pendaftaran->no_daftar, -3);
        $nomorPembayaran = $wawancaraVerifiedAt->format('Ymd') . $noDaftarLast3;

        $pendaftaran->update([
            'nomor_pembayaran'             => $nomorPembayaran,
            'petugas_wawancara_id'         => $request->petugas_wawancara_id,

            'gaya_belajar_tipe'            => $request->gaya_belajar_tipe,
            'gaya_belajar_minat_bakat'     => $request->gaya_belajar_minat_bakat,
            'gaya_belajar_catatan'         => $request->gaya_belajar_catatan,
            'gaya_belajar_petugas'         => auth()->user()->name,
            'gaya_belajar_verified_at'     => $wawancaraVerifiedAt,

            'wawancara_baca_tulis_alquran' => $request->wawancara_baca_tulis_alquran,
            'wawancara_solat_fardhu'       => $request->wawancara_solat_fardhu,
            'wawancara_kepribadian'        => $request->wawancara_kepribadian,
            'wawancara_catatan'            => $request->wawancara_catatan,
            'wawancara_petugas'            => auth()->user()->name,
            'wawancara_verified_at'        => $wawancaraVerifiedAt,

            'diterima_di_jurusan'          => $request->diterima_di_jurusan,
            'ukuran_seragam'               => $request->ukuran_seragam,
            'status'                       => $request->status,

            'biaya_spp'             => $biayaSpp,
            'biaya_dana_awal_tahun' => $biayaDanaAwalTahun,
            'biaya_infaq'           => $biayaInfaq,
            'biaya_potongan'        => $biayaPotongan,
            'total_tagihan'         => $totalTagihan,
            'biaya_petugas'         => auth()->user()->name,
            'biaya_verified_at'     => $wawancaraVerifiedAt,
        ]);

        return redirect()->route('petugas.wawancara.dashboard')
            ->with('success', 'Data Wawancara & Biaya Siswa ' . $pendaftaran->nama_lengkap . ' berhasil disimpan!');
    }

    public function laporan(Request $request)
    {
        $query = Pendaftaran::query()
            ->whereNotNull('verified_at')
            ->whereNotNull('kesehatan_verified_at')
            ->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_daftar', 'like', "%{$search}%")
                  ->orWhere('nama_lengkap', 'like', "%{$search}%");
            });
        }

        if ($request->filled('gelombang')) {
            $query->where('gelombang', $request->gelombang);
        }

        if ($request->filled('status')) {
            if ($request->status === 'sudah') {
                $query->whereNotNull('gaya_belajar_verified_at')
                      ->whereNotNull('wawancara_verified_at');
            } else {
                $query->where(function($q) {
                    $q->whereNull('gaya_belajar_verified_at')
                      ->orWhereNull('wawancara_verified_at');
                });
            }
        }

        $pendaftarans = $query->get();
        $gelombangs = SpmbGelombang::orderBy('tanggal_mulai', 'asc')->get();

        $totalAll = Pendaftaran::whereNotNull('verified_at')
            ->whereNotNull('kesehatan_verified_at')
            ->count();
        $totalBelum = Pendaftaran::whereNotNull('verified_at')
            ->whereNotNull('kesehatan_verified_at')
            ->where(function($q) {
                $q->whereNull('gaya_belajar_verified_at')
                  ->orWhereNull('wawancara_verified_at');
            })
            ->count();
        $totalSudah = Pendaftaran::whereNotNull('verified_at')
            ->whereNotNull('kesehatan_verified_at')
            ->whereNotNull('gaya_belajar_verified_at')
            ->whereNotNull('wawancara_verified_at')
            ->count();

        return view('petugas.wawancara.laporan', compact(
            'pendaftarans', 'gelombangs', 'totalAll', 'totalBelum', 'totalSudah'
        ));
    }
}
