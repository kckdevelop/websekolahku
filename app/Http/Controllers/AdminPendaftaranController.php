<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPendaftaranController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 25);
        if (!in_array($perPage, [10, 25, 50, 100])) {
            $perPage = 25;
        }

        $query = Pendaftaran::when($search, fn($q) =>
            $q->where('nama_lengkap', 'like', "%{$search}%")
              ->orWhere('no_daftar', 'like', "%{$search}%")
              ->orWhere('asal_sekolah', 'like', "%{$search}%")
        );

        if ($request->has('status') && in_array($request->status, ['pending', 'verifikasi', 'diterima', 'ditolak'])) {
            $query->where('status', $request->status);
        }

        $pendaftaran = $query->orderBy('created_at', 'desc')->paginate($perPage)->withQueryString();

        return view('admin.pendaftaran.index', compact(
            'pendaftaran',
            'search'
        ));
    }

    public function show(Request $request, Pendaftaran $pendaftaran)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $gelombangs = \App\Models\SpmbGelombang::orderBy('tanggal_mulai', 'asc')->get();
            return response()->json([
                'success' => true,
                'data' => $pendaftaran,
                'gelombangs' => $gelombangs
            ]);
        }
        return view('admin.pendaftaran.show', compact('pendaftaran'));
    }

    public function create()
    {
        $daftarPendaftar = Pendaftaran::orderBy('no_daftar', 'desc')->get();
        $gelombangs = \App\Models\SpmbGelombang::orderBy('tanggal_mulai', 'asc')->get();
        return view('admin.pendaftaran.create', compact('daftarPendaftar', 'gelombangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tgl' => 'required|numeric|between:1,31',
            'bulan' => 'required|string|max:2',
            'tahun' => 'required|numeric|between:2000,2020',
            'jenkel' => 'required|in:L,P',
            'agama' => 'required|string',
            'no_hp_siswa' => 'required|string|max:20',
            'asal_sekolah' => 'required|string|max:255',
            'alamat_sekolah' => 'nullable|string',
            'prestasi' => 'nullable|string',
            
            // Orang Tua
            'nama_ortu' => 'required|string|max:255',
            'pekerjaan_ortu' => 'required|string|max:255',
            'no_hp_ortu' => 'required|string|max:20',
            
            // Alamat Asal
            'rt_asal' => 'required|string|max:10',
            'desa_asal' => 'required|string|max:255',
            'kecamatan_asal' => 'required|string|max:255',
            'kabupaten_asal' => 'required|string|max:255',
            'provinsi_asal' => 'required|string|max:255',
            
            // Alamat Tinggal
            'rt_tinggal' => 'required|string|max:10',
            'desa_tinggal' => 'required|string|max:255',
            'kecamatan_tinggal' => 'required|string|max:255',
            'kabupaten_tinggal' => 'required|string|max:255',
            'provinsi_tinggal' => 'required|string|max:255',
            
            // Pilihan Jurusan
            'pil1' => 'required|in:TKR,TPM,TAV,TBSM,RPL',
            'pil2' => 'required|in:TKR,TPM,TAV,TBSM,RPL|different:pil1',
            'pil3' => 'required|in:TKR,TPM,TAV,TBSM,RPL|different:pil1|different:pil2',
            
            // Berkas Upload (Optional)
            'foto_akta' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'foto_kk' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'status' => 'required|in:pending,verifikasi,diterima,ditolak',
            'gelombang_id' => 'required|exists:spmb_gelombangs,id',
        ]);

        $tanggal_lahir = $request->tahun . '-' . $request->bulan . '-' . str_pad($request->tgl, 2, '0', STR_PAD_LEFT);

        // Generate No Daftar: ambil dari gelombang yang dipilih (atau aktif jika tidak ada)
        $wave = \App\Models\SpmbGelombang::find($request->input('gelombang_id'));
        $activeWave = $wave ?: \App\Models\SpmbGelombang::getActive();
        if (!$activeWave) {
            return redirect()->back()->withErrors(['gelombang_id' => 'Tidak ada gelombang aktif.'])->withInput();
        }
        $gelombangName = $activeWave->nama_gelombang;
        $startYear = date('Y');
        if (preg_match('/^\d{4}/', $activeWave->tahun_ajaran ?? '', $m)) {
            $startYear = $m[0];
        }
        $no_daftar = $activeWave->generateNoDaftar();

        // Upload files
        $foto_akta = null;
        $foto_kk = null;
        if ($request->hasFile('foto_akta')) {
            $foto_akta = $request->file('foto_akta')->store('pendaftaran/akta', 'public');
        }
        if ($request->hasFile('foto_kk')) {
            $foto_kk = $request->file('foto_kk')->store('pendaftaran/kk', 'public');
        }

        Pendaftaran::create([
            'no_daftar' => $no_daftar,
            'tahun_aktif' => $startYear,
            'gelombang' => $gelombangName,
            'nama_lengkap' => strtoupper($request->nama_lengkap),
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $tanggal_lahir,
            'jenis_kelamin' => $request->jenkel,
            'agama' => $request->agama,
            'no_hp_siswa' => $request->no_hp_siswa,
            'asal_sekolah' => strtoupper($request->asal_sekolah),
            'alamat_sekolah' => $request->alamat_sekolah,
            'prestasi' => $request->prestasi,
            
            // Orang Tua
            'nama_ortu' => strtoupper($request->nama_ortu),
            'pekerjaan_ortu' => $request->pekerjaan_ortu,
            'no_hp_ortu' => $request->no_hp_ortu,
            
            // Alamat Asal
            'jalan_asal' => $request->jalan_asal,
            'dusun_asal' => $request->dusun_asal,
            'rt_asal' => $request->rt_asal,
            'rw_asal' => $request->rw_asal,
            'desa_asal' => $request->desa_asal,
            'kecamatan_asal' => $request->kecamatan_asal,
            'kabupaten_asal' => $request->kabupaten_asal,
            'provinsi_asal' => $request->provinsi_asal,
            
            // Alamat Tinggal
            'jalan_tinggal' => $request->jalan_tinggal,
            'dusun_tinggal' => $request->dusun_tinggal,
            'rt_tinggal' => $request->rt_tinggal,
            'rw_tinggal' => $request->rw_tinggal,
            'desa_tinggal' => $request->desa_tinggal,
            'kecamatan_tinggal' => $request->kecamatan_tinggal,
            'kabupaten_tinggal' => $request->kabupaten_tinggal,
            'provinsi_tinggal' => $request->provinsi_tinggal,
            
            // Jurusan
            'pil1' => $request->pil1,
            'pil2' => $request->pil2,
            'pil3' => $request->pil3,
            
            // Berkas
            'foto_akta' => $foto_akta,
            'foto_kk' => $foto_kk,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.pendaftaran.index')->with('success', 'Data pendaftaran berhasil ditambahkan.');
    }

    public function edit(Pendaftaran $pendaftaran)
    {
        $gelombangs = \App\Models\SpmbGelombang::orderBy('tanggal_mulai', 'asc')->get();
        return view('admin.pendaftaran.edit', compact('pendaftaran', 'gelombangs'));
    }

    public function update(Request $request, Pendaftaran $pendaftaran)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tgl' => 'required|numeric|between:1,31',
            'bulan' => 'required|string|max:2',
            'tahun' => 'required|numeric|between:2000,2020',
            'jenkel' => 'required|in:L,P',
            'agama' => 'required|string',
            'no_hp_siswa' => 'required|string|max:20',
            'asal_sekolah' => 'required|string|max:255',
            'alamat_sekolah' => 'nullable|string',
            'prestasi' => 'nullable|string',
            
            // Orang Tua
            'nama_ortu' => 'required|string|max:255',
            'pekerjaan_ortu' => 'required|string|max:255',
            'no_hp_ortu' => 'required|string|max:20',
            
            // Alamat Asal
            'rt_asal' => 'required|string|max:10',
            'desa_asal' => 'required|string|max:255',
            'kecamatan_asal' => 'required|string|max:255',
            'kabupaten_asal' => 'required|string|max:255',
            'provinsi_asal' => 'required|string|max:255',
            
            // Alamat Tinggal
            'rt_tinggal' => 'required|string|max:10',
            'desa_tinggal' => 'required|string|max:255',
            'kecamatan_tinggal' => 'required|string|max:255',
            'kabupaten_tinggal' => 'required|string|max:255',
            'provinsi_tinggal' => 'required|string|max:255',
            
            // Pilihan Jurusan
            'pil1' => 'required|in:TKR,TPM,TAV,TBSM,RPL',
            'pil2' => 'required|in:TKR,TPM,TAV,TBSM,RPL|different:pil1',
            'pil3' => 'required|in:TKR,TPM,TAV,TBSM,RPL|different:pil1|different:pil2',
            
            // Berkas Upload (Optional)
            'foto_akta' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'foto_kk' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'status' => 'required|in:pending,verifikasi,diterima,ditolak',
            'gelombang_id' => 'required|exists:spmb_gelombangs,id',
        ]);

        $selectedGelombangId = $request->input('gelombang_id');
        $wave = \App\Models\SpmbGelombang::find($selectedGelombangId);
        $activeWave = $wave ?: \App\Models\SpmbGelombang::where('is_aktif', true)->first();

        $gelombangName = $activeWave ? $activeWave->nama_gelombang : 'Gelombang I';
        $tahunAjaran = $activeWave ? $activeWave->tahun_ajaran : '2026/2027';

        // 1. Get 2-digit year (YY) from tahun_ajaran
        $startYear = date('Y');
        if (preg_match('/^\d{4}/', $tahunAjaran, $matches)) {
            $startYear = $matches[0];
        }
        $year2Digit = substr($startYear, -2); // e.g. '26'

        // 2. Get 2-digit wave (WW) from nama_gelombang
        $waveNumber = '01';
        $cleanWave = strtolower(trim($gelombangName));
        if (preg_match('/\d+/', $cleanWave, $matches)) {
            $waveNumber = str_pad($matches[0], 2, '0', STR_PAD_LEFT);
        } else {
            if (str_contains($cleanWave, 'iii')) {
                $waveNumber = '03';
            } elseif (str_contains($cleanWave, 'ii')) {
                $waveNumber = '02';
            } elseif (str_contains($cleanWave, 'i')) {
                $waveNumber = '01';
            }
        }

        $prefix = 'MSB' . $year2Digit . '-' . $waveNumber . '-';

        $no_daftar = $pendaftaran->no_daftar;
        if (!str_starts_with($pendaftaran->no_daftar, $prefix)) {
            $lastPendaftaran = Pendaftaran::where('no_daftar', 'like', $prefix . '%')
                ->where('id', '!=', $pendaftaran->id)
                ->orderBy('no_daftar', 'desc')
                ->first();
            $nextNum = $lastPendaftaran ? ((int) substr($lastPendaftaran->no_daftar, -3) + 1) : 1;
            $no_daftar = $prefix . str_pad($nextNum, 3, '0', STR_PAD_LEFT);
        }

        $tanggal_lahir = $request->tahun . '-' . $request->bulan . '-' . str_pad($request->tgl, 2, '0', STR_PAD_LEFT);

        $data = [
            'no_daftar' => $no_daftar,
            'tahun_aktif' => $startYear,
            'gelombang' => $gelombangName,
            'nama_lengkap' => strtoupper($request->nama_lengkap),
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $tanggal_lahir,
            'jenis_kelamin' => $request->jenkel,
            'agama' => $request->agama,
            'no_hp_siswa' => $request->no_hp_siswa,
            'asal_sekolah' => strtoupper($request->asal_sekolah),
            'alamat_sekolah' => $request->alamat_sekolah,
            'prestasi' => $request->prestasi,
            
            // Orang Tua
            'nama_ortu' => strtoupper($request->nama_ortu),
            'pekerjaan_ortu' => $request->pekerjaan_ortu,
            'no_hp_ortu' => $request->no_hp_ortu,
            
            // Alamat Asal
            'jalan_asal' => $request->jalan_asal,
            'dusun_asal' => $request->dusun_asal,
            'rt_asal' => $request->rt_asal,
            'rw_asal' => $request->rw_asal,
            'desa_asal' => $request->desa_asal,
            'kecamatan_asal' => $request->kecamatan_asal,
            'kabupaten_asal' => $request->kabupaten_asal,
            'provinsi_asal' => $request->provinsi_asal,
            
            // Alamat Tinggal
            'jalan_tinggal' => $request->jalan_tinggal,
            'dusun_tinggal' => $request->dusun_tinggal,
            'rt_tinggal' => $request->rt_tinggal,
            'rw_tinggal' => $request->rw_tinggal,
            'desa_tinggal' => $request->desa_tinggal,
            'kecamatan_tinggal' => $request->kecamatan_tinggal,
            'kabupaten_tinggal' => $request->kabupaten_tinggal,
            'provinsi_tinggal' => $request->provinsi_tinggal,
            
            // Jurusan
            'pil1' => $request->pil1,
            'pil2' => $request->pil2,
            'pil3' => $request->pil3,
            'status' => $request->status,
        ];

        if ($request->hasFile('foto_akta')) {
            if ($pendaftaran->foto_akta) {
                Storage::disk('public')->delete($pendaftaran->foto_akta);
            }
            $data['foto_akta'] = $request->file('foto_akta')->store('pendaftaran/akta', 'public');
        }

        if ($request->hasFile('foto_kk')) {
            if ($pendaftaran->foto_kk) {
                Storage::disk('public')->delete($pendaftaran->foto_kk);
            }
            $data['foto_kk'] = $request->file('foto_kk')->store('pendaftaran/kk', 'public');
        }

        $pendaftaran->update($data);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Data pendaftaran berhasil diperbarui.',
                'data' => $pendaftaran
            ]);
        }

        return redirect()->route('admin.pendaftaran.show', $pendaftaran->id)->with('success', 'Data pendaftaran berhasil diperbarui.');
    }

    public function updateStatus(Request $request, Pendaftaran $pendaftaran)
    {
        if ($request->input('action_type') === 'verifikasi_berkas') {
            $berkasLengkap = $request->input('berkas', []);
            $catatanPetugas = $request->input('catatan_petugas', '');
            $tandaiVerif = $request->boolean('tandai_verifikasi');

            if ($tandaiVerif) {
                $statusBaru = 'verifikasi';
            } elseif (in_array($pendaftaran->status, ['diterima', 'ditolak'])) {
                $statusBaru = $pendaftaran->status;
            } else {
                $statusBaru = 'pending';
            }

            $pendaftaran->update([
                'berkas_lengkap' => $berkasLengkap,
                'catatan_petugas' => $catatanPetugas,
                'verified_at' => $tandaiVerif ? now() : null,
                'status' => $statusBaru,
            ]);

            return redirect()->route('admin.pendaftaran.show', $pendaftaran->id)
                ->with('success', 'Verifikasi & kelengkapan berkas fisik berhasil diperbarui.');
        }

        $request->validate([
            'status' => 'required|in:pending,verifikasi,diterima,ditolak',
        ]);

        $pendaftaran->update([
            'status' => $request->status,
            'verified_at' => $request->status === 'verifikasi' ? now() : $pendaftaran->verified_at,
        ]);

        return redirect()->route('admin.pendaftaran.show', $pendaftaran->id)
            ->with('success', 'Status pendaftaran berhasil diperbarui menjadi "' . ucfirst($request->status) . '".');
    }

    public function destroy(Request $request, Pendaftaran $pendaftaran)
    {
        $nama = $pendaftaran->nama_lengkap;
        $noDaftar = $pendaftaran->no_daftar;

        if ($pendaftaran->foto_akta) {
            Storage::disk('public')->delete($pendaftaran->foto_akta);
        }
        if ($pendaftaran->foto_kk) {
            Storage::disk('public')->delete($pendaftaran->foto_kk);
        }
        if ($pendaftaran->foto_siswa) {
            Storage::disk('public')->delete($pendaftaran->foto_siswa);
        }

        $pendaftaran->delete();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Data pendaftaran {$nama} ({$noDaftar}) berhasil dihapus."
            ]);
        }

        return redirect()->route('admin.pendaftaran.index')
            ->with('success', "Data pendaftaran {$nama} ({$noDaftar}) beserta seluruh data terkait (Kesehatan, Wawancara, Pembayaran, dan Berkas/Foto) berhasil dihapus secara permanen.");
    }

    public function cetak(Pendaftaran $pendaftaran)
    {
        return view('admin.pendaftaran.cetak', compact('pendaftaran'));
    }

    public function laporan(Request $request)
    {
        $query = Pendaftaran::query()->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_daftar', 'like', "%{$search}%")
                  ->orWhere('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('asal_sekolah', 'like', "%{$search}%");
            });
        }

        if ($request->filled('gelombang')) {
            $query->where('gelombang', $request->gelombang);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pendaftarans = $query->get();
        $gelombangs = \App\Models\SpmbGelombang::orderBy('tanggal_mulai', 'asc')->get();

        $totalAll = Pendaftaran::count();
        $totalPending = Pendaftaran::where('status', 'pending')->count();
        $totalVerified = Pendaftaran::where('status', 'verifikasi')->count();
        $totalDiterima = Pendaftaran::where('status', 'diterima')->count();
        $totalDitolak = Pendaftaran::where('status', 'ditolak')->count();

        return view('admin.pendaftaran.laporan', compact(
            'pendaftarans', 'gelombangs', 'totalAll', 'totalPending', 'totalVerified', 'totalDiterima', 'totalDitolak'
        ));
    }
}
