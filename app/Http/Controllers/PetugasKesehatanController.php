<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class PetugasKesehatanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pendaftaran::query()->whereNotNull('verified_at')->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_daftar', 'like', "%{$search}%")
                  ->orWhere('nama_lengkap', 'like', "%{$search}%");
            });
        }

        if ($request->filter === 'belum') {
            $query->whereNull('kesehatan_verified_at');
        } elseif ($request->filter === 'sudah') {
            $query->whereNotNull('kesehatan_verified_at');
        }

        $perPage = $request->input('per_page', 20);
        if (!in_array($perPage, [10, 20, 50, 100])) {
            $perPage = 20;
        }

        $pendaftarans = $query->paginate($perPage)->withQueryString();

        $totalAll = Pendaftaran::whereNotNull('verified_at')->count();
        $totalBelum = Pendaftaran::whereNotNull('verified_at')->whereNull('kesehatan_verified_at')->count();
        $totalSudah = Pendaftaran::whereNotNull('verified_at')->whereNotNull('kesehatan_verified_at')->count();

        if ($request->ajax()) {
            return view('petugas.kesehatan.table', compact('pendaftarans'))->render();
        }

        return view('petugas.kesehatan.index', compact('pendaftarans', 'totalAll', 'totalBelum', 'totalSudah'));
    }

    public function show(Pendaftaran $pendaftaran)
    {
        return view('petugas.kesehatan.show', compact('pendaftaran'));
    }
    public function update(Request $request, Pendaftaran $pendaftaran)
    {
        $request->validate([
            'kesehatan_tinggi_badan'    => 'required|string',
            'kesehatan_berat_badan'     => 'required|string',
            'kesehatan_golongan_darah'  => 'required|string',
            'kesehatan_buta_warna'      => 'required|in:ya,tidak',
            'kesehatan_mata_minus'      => 'required|string',
            'kesehatan_tato_tindik'     => 'required|in:tato,tindik,tato_tindik,tidak',
            'kesehatan_riwayat_penyakit'=> 'nullable|string',
            'kesehatan_catatan'         => 'nullable|string',
        ]);

        $pendaftaran->update([
            'kesehatan_tinggi_badan'     => $request->kesehatan_tinggi_badan,
            'kesehatan_berat_badan'      => $request->kesehatan_berat_badan,
            'kesehatan_golongan_darah'   => $request->kesehatan_golongan_darah,
            'kesehatan_buta_warna'       => $request->kesehatan_buta_warna,
            'kesehatan_mata_minus'       => $request->kesehatan_mata_minus,
            'kesehatan_tato_tindik'      => $request->kesehatan_tato_tindik,
            'kesehatan_riwayat_penyakit' => $request->kesehatan_riwayat_penyakit,
            'kesehatan_catatan'          => $request->kesehatan_catatan,
            'kesehatan_petugas'          => auth()->user()->name,
            'kesehatan_verified_at'      => now(),
        ]);

        return redirect()->route('petugas.kesehatan.dashboard')
            ->with('success', 'Data Kesehatan Siswa ' . $pendaftaran->nama_lengkap . ' berhasil disimpan!');
    }

    public function laporan(Request $request)
    {
        $query = Pendaftaran::query()->whereNotNull('verified_at')->orderBy('created_at', 'desc');

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
                $query->whereNotNull('kesehatan_verified_at');
            } else {
                $query->whereNull('kesehatan_verified_at');
            }
        }

        $pendaftarans = $query->get();
        $gelombangs = \App\Models\SpmbGelombang::orderBy('tanggal_mulai', 'asc')->get();

        $totalAll = Pendaftaran::whereNotNull('verified_at')->count();
        $totalBelum = Pendaftaran::whereNotNull('verified_at')->whereNull('kesehatan_verified_at')->count();
        $totalSudah = Pendaftaran::whereNotNull('verified_at')->whereNotNull('kesehatan_verified_at')->count();

        return view('petugas.kesehatan.laporan', compact(
            'pendaftarans', 'gelombangs', 'totalAll', 'totalBelum', 'totalSudah'
        ));
    }
}
