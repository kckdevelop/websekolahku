<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\RiwayatPembayaran;
use App\Models\SpmbGelombang;
use Illuminate\Http\Request;

class PetugasPembayaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pendaftaran::query()
            ->whereNotNull('verified_at')
            ->whereNotNull('kesehatan_verified_at')
            ->whereNotNull('gaya_belajar_verified_at')
            ->whereNotNull('wawancara_verified_at')
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
                $q->where('pembayaran_status', 'belum_bayar')
                  ->orWhereNull('pembayaran_status');
            });
        } elseif ($request->filter === 'cicilan') {
            $query->where('pembayaran_status', 'cicilan');
        } elseif ($request->filter === 'lunas') {
            $query->where('pembayaran_status', 'lunas');
        }

        $perPage = $request->input('per_page', 20);
        if (!in_array($perPage, [10, 20, 50, 100])) {
            $perPage = 20;
        }

        $pendaftarans = $query->paginate($perPage)->withQueryString();

        // Query base untuk statistika counts
        $statsBase = Pendaftaran::whereNotNull('verified_at')
            ->whereNotNull('kesehatan_verified_at')
            ->whereNotNull('gaya_belajar_verified_at')
            ->whereNotNull('wawancara_verified_at');

        $totalAll     = (clone $statsBase)->count();
        $totalBelum   = (clone $statsBase)->where(function($q) {
            $q->where('pembayaran_status', 'belum_bayar')->orWhereNull('pembayaran_status');
        })->count();
        $totalCicilan = (clone $statsBase)->where('pembayaran_status', 'cicilan')->count();
        $totalLunas   = (clone $statsBase)->where('pembayaran_status', 'lunas')->count();

        if ($request->ajax()) {
            return view('petugas.pembayaran.table', compact('pendaftarans'))->render();
        }

        return view('petugas.pembayaran.index', compact(
            'pendaftarans', 'totalAll', 'totalBelum', 'totalCicilan', 'totalLunas'
        ));
    }

    public function show(Pendaftaran $pendaftaran)
    {
        $riwayat = $pendaftaran->riwayatPembayaran()->latest()->get();
        $gelombangAktif = SpmbGelombang::where('is_aktif', true)->first();
        return view('petugas.pembayaran.show', compact('pendaftaran', 'riwayat', 'gelombangAktif'));
    }

    /**
     * Catat transaksi titip bayar baru (ditambahkan ke riwayat).
     */
    public function update(Request $request, Pendaftaran $pendaftaran)
    {
        $request->validate([
            'nominal'     => 'required|numeric|min:1',
            'keterangan'  => 'nullable|string|max:255',
        ], [
            'nominal.required' => 'Nominal pembayaran wajib diisi.',
            'nominal.min'      => 'Nominal pembayaran harus lebih dari 0.',
        ]);

        // Simpan transaksi ke riwayat
        $riwayat = RiwayatPembayaran::create([
            'pendaftaran_id' => $pendaftaran->id,
            'nominal'        => $request->nominal,
            'keterangan'     => $request->keterangan,
            'petugas'        => auth()->user()->name,
        ]);

        // Hitung ulang total terbayar & update status di pendaftaran
        $this->recalculateStatus($pendaftaran);

        // Redirect ke halaman bukti pembayaran
        return redirect()->route('petugas.pembayaran.riwayat.bukti', $riwayat->id)
            ->with('success', 'Transaksi Rp ' . number_format($request->nominal, 0, ',', '.') . ' berhasil dicatat!');
    }

    /**
     * Hapus satu entri riwayat pembayaran, lalu recalculate status.
     */
    public function destroyRiwayat(RiwayatPembayaran $riwayat)
    {
        $pendaftaran = $riwayat->pendaftaran;
        $nominal     = $riwayat->nominal;
        $riwayat->delete();

        $this->recalculateStatus($pendaftaran);

        return redirect()->route('petugas.pembayaran.show', $pendaftaran->id)
            ->with('success', 'Riwayat pembayaran Rp ' . number_format($nominal, 0, ',', '.') . ' berhasil dihapus.');
    }

    /**
     * Recalculate total terbayar & status dari riwayat terkini.
     */
    private function recalculateStatus(Pendaftaran $pendaftaran): void
    {
        $totalTerbayar = (float) $pendaftaran->riwayatPembayaran()->sum('nominal');
        $totalTagihan  = (float) ($pendaftaran->total_tagihan ?? 0);

        if ($totalTerbayar <= 0) {
            $status = 'belum_bayar';
        } elseif ($totalTagihan > 0 && $totalTerbayar >= $totalTagihan) {
            $status = 'lunas';
        } else {
            $status = 'cicilan';
        }

        $pendaftaran->update([
            'pembayaran_nominal'     => $totalTerbayar,
            'pembayaran_status'      => $status,
            'pembayaran_petugas'     => auth()->user()->name,
            'pembayaran_verified_at' => now(),
        ]);
    }

    public function laporan(Request $request)
    {
        $query = Pendaftaran::query()
            ->whereNotNull('verified_at')
            ->whereNotNull('kesehatan_verified_at')
            ->whereNotNull('gaya_belajar_verified_at')
            ->whereNotNull('wawancara_verified_at')
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
            $query->where('pembayaran_status', $request->status);
        }

        $pendaftarans   = $query->get();
        $gelombangs     = SpmbGelombang::orderBy('tanggal_mulai', 'asc')->get();

        // Query base untuk statistika counts
        $statsBase = Pendaftaran::whereNotNull('verified_at')
            ->whereNotNull('kesehatan_verified_at')
            ->whereNotNull('gaya_belajar_verified_at')
            ->whereNotNull('wawancara_verified_at');

        $totalAll       = (clone $statsBase)->count();
        $totalBelum     = (clone $statsBase)->where(function($q) {
            $q->where('pembayaran_status', 'belum_bayar')->orWhereNull('pembayaran_status');
        })->count();
        $totalCicilan   = (clone $statsBase)->where('pembayaran_status', 'cicilan')->count();
        $totalLunas     = (clone $statsBase)->where('pembayaran_status', 'lunas')->count();
        $totalTagihan   = (clone $statsBase)->sum('total_tagihan');
        $totalTerbayar  = (clone $statsBase)->sum('pembayaran_nominal');
        $totalSisa      = max(0, $totalTagihan - $totalTerbayar);

        return view('petugas.pembayaran.laporan', compact(
            'pendaftarans', 'gelombangs',
            'totalAll', 'totalBelum', 'totalCicilan', 'totalLunas',
            'totalTagihan', 'totalTerbayar', 'totalSisa'
        ));
    }

    public function kartu(Pendaftaran $pendaftaran)
    {
        $riwayat = $pendaftaran->riwayatPembayaran()->orderBy('created_at', 'asc')->get();
        return view('petugas.pembayaran.kartu', compact('pendaftaran', 'riwayat'));
    }

    /**
     * Tampilkan bukti pembayaran untuk satu transaksi.
     */
    public function bukti(RiwayatPembayaran $riwayat)
    {
        $pendaftaran = $riwayat->pendaftaran;
        $allRiwayat  = $pendaftaran->riwayatPembayaran()->orderBy('created_at', 'asc')->get();
        $nomorPembayaran = $pendaftaran->nomor_pembayaran;
        if (!$nomorPembayaran) {
            $noDaftarLast3   = substr($pendaftaran->no_daftar, -3);
            $tgl = $pendaftaran->wawancara_verified_at ?: ($pendaftaran->created_at ?: now());
            $nomorPembayaran = $tgl->format('Ymd') . $noDaftarLast3;
        }
        return view('petugas.pembayaran.bukti', compact('riwayat', 'pendaftaran', 'allRiwayat', 'nomorPembayaran'));
    }
}
