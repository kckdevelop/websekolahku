<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class PetugasPembayaranController extends Controller
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

        if ($request->filter === 'belum') {
            $query->where('pembayaran_status', 'belum_bayar');
        } elseif ($request->filter === 'lunas') {
            $query->where('pembayaran_status', 'lunas');
        }

        $pendaftarans = $query->paginate(20)->withQueryString();

        $totalAll = Pendaftaran::count();
        $totalBelum = Pendaftaran::where('pembayaran_status', 'belum_bayar')->count();
        $totalLunas = Pendaftaran::where('pembayaran_status', 'lunas')->count();

        return view('petugas.pembayaran.index', compact('pendaftarans', 'totalAll', 'totalBelum', 'totalLunas'));
    }

    public function show(Pendaftaran $pendaftaran)
    {
        return view('petugas.pembayaran.show', compact('pendaftaran'));
    }

    public function update(Request $request, Pendaftaran $pendaftaran)
    {
        $request->validate([
            'pembayaran_nominal'    => 'required|numeric|min:0',
            'pembayaran_status'     => 'required|in:belum_bayar,lunas',
            'pembayaran_keterangan' => 'nullable|string',
        ]);

        $pendaftaran->update([
            'pembayaran_nominal'    => $request->pembayaran_nominal,
            'pembayaran_status'     => $request->pembayaran_status,
            'pembayaran_keterangan' => $request->pembayaran_keterangan,
            'pembayaran_petugas'    => auth()->user()->name,
            'pembayaran_verified_at'=> now(),
        ]);

        return redirect()->route('petugas.pembayaran.dashboard')
            ->with('success', 'Transaksi Pembayaran Siswa ' . $pendaftaran->nama_lengkap . ' berhasil disimpan!');
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
            $query->where('pembayaran_status', $request->status);
        }

        $pendaftarans = $query->get();
        $gelombangs = \App\Models\SpmbGelombang::orderBy('tanggal_mulai', 'asc')->get();

        $totalAll = Pendaftaran::count();
        $totalBelum = Pendaftaran::where('pembayaran_status', 'belum_bayar')->count();
        $totalLunas = Pendaftaran::where('pembayaran_status', 'lunas')->count();
        $totalNominal = Pendaftaran::where('pembayaran_status', 'lunas')->sum('pembayaran_nominal');

        return view('petugas.pembayaran.laporan', compact(
            'pendaftarans', 'gelombangs', 'totalAll', 'totalBelum', 'totalLunas', 'totalNominal'
        ));
    }
}
