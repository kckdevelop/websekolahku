<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class PetugasWawancaraController extends Controller
{
    public function index(Request $request)
    {
        $query = Pendaftaran::query()->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_daftar', 'like', "%{$search}%")
                  ->orWhere('nama_lengkap', 'like', "%{$search}%");
            });
        }

        // Filter: Belum Tes (either Gaya Belajar or Wawancara is not verified)
        if ($request->filter === 'belum') {
            $query->where(function($q) {
                $q->whereNull('gaya_belajar_verified_at')
                  ->orWhereNull('wawancara_verified_at');
            });
        } elseif ($request->filter === 'sudah') {
            $query->whereNotNull('gaya_belajar_verified_at')
                  ->whereNotNull('wawancara_verified_at');
        }

        $pendaftarans = $query->paginate(20)->withQueryString();

        $totalAll = Pendaftaran::count();
        $totalBelum = Pendaftaran::whereNull('gaya_belajar_verified_at')
            ->orWhereNull('wawancara_verified_at')
            ->count();
        $totalSudah = Pendaftaran::whereNotNull('gaya_belajar_verified_at')
            ->whereNotNull('wawancara_verified_at')
            ->count();

        return view('petugas.wawancara.index', compact('pendaftarans', 'totalAll', 'totalBelum', 'totalSudah'));
    }

    public function show(Pendaftaran $pendaftaran)
    {
        return view('petugas.wawancara.show', compact('pendaftaran'));
    }

    public function update(Request $request, Pendaftaran $pendaftaran)
    {
        $request->validate([
            // Gaya Belajar & Minat
            'gaya_belajar_tipe'          => 'required|in:visual,auditori,kinestetik',
            'gaya_belajar_minat_bakat'   => 'required|string',
            'gaya_belajar_catatan'       => 'nullable|string',

            // Wawancara Keagamaan & Kepribadian
            'wawancara_baca_tulis_alquran' => 'required|string',
            'wawancara_solat_fardhu'       => 'required|string',
            'wawancara_kepribadian'        => 'required|string',
            'wawancara_catatan'            => 'nullable|string',
        ]);

        $pendaftaran->update([
            'gaya_belajar_tipe'            => $request->gaya_belajar_tipe,
            'gaya_belajar_minat_bakat'     => $request->gaya_belajar_minat_bakat,
            'gaya_belajar_catatan'         => $request->gaya_belajar_catatan,
            'gaya_belajar_petugas'         => auth()->user()->name,
            'gaya_belajar_verified_at'     => now(),

            'wawancara_baca_tulis_alquran' => $request->wawancara_baca_tulis_alquran,
            'wawancara_solat_fardhu'       => $request->wawancara_solat_fardhu,
            'wawancara_kepribadian'        => $request->wawancara_kepribadian,
            'wawancara_catatan'            => $request->wawancara_catatan,
            'wawancara_petugas'            => auth()->user()->name,
            'wawancara_verified_at'        => now(),
        ]);

        return redirect()->route('petugas.wawancara.dashboard')
            ->with('success', 'Data Wawancara & Gaya Belajar Siswa ' . $pendaftaran->nama_lengkap . ' berhasil disimpan!');
    }

    public function laporan(Request $request)
    {
        $query = Pendaftaran::query()->orderBy('created_at', 'desc');

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
        $gelombangs = \App\Models\SpmbGelombang::orderBy('tanggal_mulai', 'asc')->get();

        $totalAll = Pendaftaran::count();
        $totalBelum = Pendaftaran::whereNull('gaya_belajar_verified_at')
            ->orWhereNull('wawancara_verified_at')
            ->count();
        $totalSudah = Pendaftaran::whereNotNull('gaya_belajar_verified_at')
            ->whereNotNull('wawancara_verified_at')
            ->count();

        return view('petugas.wawancara.laporan', compact(
            'pendaftarans', 'gelombangs', 'totalAll', 'totalBelum', 'totalSudah'
        ));
    }
}
