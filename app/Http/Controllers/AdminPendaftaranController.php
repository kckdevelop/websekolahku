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

        if ($request->has('status') && in_array($request->status, ['pending', 'verifikasi', 'diterima', 'ditolak', 'mundur'])) {
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
            'nama_ayah'      => 'required|string|max:255',
            'pekerjaan_ayah' => 'required|string|max:255',
            'nama_ibu'       => 'nullable|string|max:255',
            'pekerjaan_ibu'  => 'nullable|string|max:255',
            'no_hp_ortu'     => 'required|string|max:20',
            
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
            'status' => 'required|in:pending,verifikasi,diterima,ditolak,mundur',
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
            'nama_ayah'      => strtoupper($request->nama_ayah),
            'pekerjaan_ayah' => $request->pekerjaan_ayah,
            'nama_ibu'       => strtoupper($request->nama_ibu ?? ''),
            'pekerjaan_ibu'  => $request->pekerjaan_ibu,
            'no_hp_ortu'     => $request->no_hp_ortu,
            
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
            'nama_ayah'      => 'required|string|max:255',
            'pekerjaan_ayah' => 'required|string|max:255',
            'nama_ibu'       => 'nullable|string|max:255',
            'pekerjaan_ibu'  => 'nullable|string|max:255',
            'no_hp_ortu'     => 'required|string|max:20',
            
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
            'status' => 'required|in:pending,verifikasi,diterima,ditolak,mundur',
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
            'nama_ayah'      => strtoupper($request->nama_ayah),
            'pekerjaan_ayah' => $request->pekerjaan_ayah,
            'nama_ibu'       => strtoupper($request->nama_ibu ?? ''),
            'pekerjaan_ibu'  => $request->pekerjaan_ibu,
            'no_hp_ortu'     => $request->no_hp_ortu,
            
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
            'status' => 'required|in:pending,verifikasi,diterima,ditolak,mundur',
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
        $totalMundur = Pendaftaran::where('status', 'mundur')->count();

        return view('admin.pendaftaran.laporan', compact(
            'pendaftarans', 'gelombangs', 'totalAll', 'totalPending', 'totalVerified', 'totalDiterima', 'totalDitolak', 'totalMundur'
        ));
    }

    public function statistik(Request $request)
    {
        $jurusans = ['TAV', 'TPM', 'TKR', 'TBSM', 'RPL'];

        // Ambil semua gelombang dari DB, urutkan by tanggal
        $gelombangs = \App\Models\SpmbGelombang::orderBy('tanggal_mulai', 'asc')->get();

        // Ambil semua pendaftaran dengan kolom yang dibutuhkan
        $pendaftarans = Pendaftaran::select(
            'gelombang', 'pil1', 'status', 'diterima_di_jurusan',
            'jenis_kelamin',
            'pembayaran_status', 'pembayaran_nominal', 'total_tagihan',
            'biaya_spp', 'biaya_dana_awal_tahun'
        )->get();

        // Kumpulkan nama gelombang unik dari data aktual
        $gelNamas = $gelombangs->pluck('nama_gelombang')->unique()->values()->toArray();
        foreach ($pendaftarans->pluck('gelombang')->unique() as $gn) {
            if ($gn && !in_array($gn, $gelNamas)) {
                $gelNamas[] = $gn;
            }
        }

        // Helper: buat struktur tabel kosong [gelombang][jurusan] = 0
        $makeTable = function() use ($jurusans, $gelNamas) {
            $tbl = [];
            foreach ($gelNamas as $gn) {
                $tbl[$gn] = array_fill_keys(array_merge($jurusans, ['total']), 0);
            }
            $tbl['__total__'] = array_fill_keys(array_merge($jurusans, ['total']), 0);
            return $tbl;
        };

        $tblSemua      = $makeTable(); // semua pendaftar (semua status)
        $tblSeleksi    = $makeTable(); // diterima
        $tblMundur     = $makeTable(); // mundur
        $tblBayar      = $makeTable(); // diterima + sudah bayar (cicilan/lunas)
        $tblBelumBayar = $makeTable(); // diterima + belum bayar

        // Tabel per-status breakdown: [status][jurusan] = count
        $allStatuses = ['pending', 'verified', 'diterima', 'ditolak', 'mundur'];
        $statusLabels = [
            'pending'   => 'Pending',
            'verified'  => 'Terverifikasi',
            'diterima'  => 'Diterima',
            'ditolak'   => 'Ditolak',
            'mundur'    => 'Mundur',
        ];
        $tblStatus = [];
        foreach ($allStatuses as $st) {
            $tblStatus[$st] = array_fill_keys(array_merge($jurusans, ['total']), 0);
        }
        $tblStatus['__total__'] = array_fill_keys(array_merge($jurusans, ['total']), 0);

        // Statistik diterima per Jenis Kelamin x Jurusan
        // tblGender['L'|'P'][jurusan|'total'] = count
        $tblGender = [
            'L' => array_fill_keys(array_merge($jurusans, ['total']), 0),
            'P' => array_fill_keys(array_merge($jurusans, ['total']), 0),
            '__total__' => array_fill_keys(array_merge($jurusans, ['total']), 0),
        ];

        // Statistik pembayaran per Jurusan
        // tblPembayaran[jurusan]['lunas'|'cicilan'|'belum'|'total_siswa'|'terkumpul'|'tagihan'] = value
        $tblPembayaran = [];
        foreach (array_merge($jurusans, ['__total__']) as $jur) {
            $tblPembayaran[$jur] = [
                'lunas'        => 0,
                'cicilan'      => 0,
                'belum'        => 0,
                'total_siswa'  => 0,
                'terkumpul'    => 0,   // sum pembayaran_nominal
                'tagihan'      => 0,   // sum total_tagihan
            ];
        }

        foreach ($pendaftarans as $p) {
            $gel = $p->gelombang ?? null;
            $jur = $p->pil1;

            if (!in_array($jur, $jurusans)) continue;

            // Semua pendaftar (tidak peduli gelombang/status)
            $tblSemua['__total__'][$jur]++;
            $tblSemua['__total__']['total']++;
            if ($gel && array_key_exists($gel, $tblSemua)) {
                $tblSemua[$gel][$jur]++;
                $tblSemua[$gel]['total']++;
            }

            // Per-status breakdown
            $st = $p->status ?? 'pending';
            if (array_key_exists($st, $tblStatus)) {
                $tblStatus[$st][$jur]++;
                $tblStatus[$st]['total']++;
            }
            $tblStatus['__total__'][$jur]++;
            $tblStatus['__total__']['total']++;

            if (!$gel || !array_key_exists($gel, $tblSeleksi)) continue;

            if ($p->status === 'diterima') {
                $tblSeleksi[$gel][$jur]++;
                $tblSeleksi[$gel]['total']++;
                $tblSeleksi['__total__'][$jur]++;
                $tblSeleksi['__total__']['total']++;

                // Gender stats
                $gk = in_array($p->jenis_kelamin, ['L','P']) ? $p->jenis_kelamin : 'L';
                $tblGender[$gk][$jur]++;
                $tblGender[$gk]['total']++;
                $tblGender['__total__'][$jur]++;
                $tblGender['__total__']['total']++;

                // Pembayaran stats
                $ps = $p->pembayaran_status ?? 'belum_bayar';
                $nominal  = (float)($p->pembayaran_nominal ?? 0);
                $tagihan  = (float)($p->total_tagihan ?? 0);

                $tblPembayaran[$jur]['total_siswa']++;
                $tblPembayaran[$jur]['terkumpul'] += $nominal;
                $tblPembayaran[$jur]['tagihan']   += $tagihan;
                $tblPembayaran['__total__']['total_siswa']++;
                $tblPembayaran['__total__']['terkumpul'] += $nominal;
                $tblPembayaran['__total__']['tagihan']   += $tagihan;

                if ($ps === 'lunas') {
                    $tblPembayaran[$jur]['lunas']++;
                    $tblPembayaran['__total__']['lunas']++;
                    $tblBayar[$gel][$jur]++;
                    $tblBayar[$gel]['total']++;
                    $tblBayar['__total__'][$jur]++;
                    $tblBayar['__total__']['total']++;
                } elseif ($ps === 'cicilan') {
                    $tblPembayaran[$jur]['cicilan']++;
                    $tblPembayaran['__total__']['cicilan']++;
                    $tblBayar[$gel][$jur]++;
                    $tblBayar[$gel]['total']++;
                    $tblBayar['__total__'][$jur]++;
                    $tblBayar['__total__']['total']++;
                } else {
                    $tblPembayaran[$jur]['belum']++;
                    $tblPembayaran['__total__']['belum']++;
                    $tblBelumBayar[$gel][$jur]++;
                    $tblBelumBayar[$gel]['total']++;
                    $tblBelumBayar['__total__'][$jur]++;
                    $tblBelumBayar['__total__']['total']++;
                }
            }

            if ($p->status === 'mundur') {
                $tblMundur[$gel][$jur]++;
                $tblMundur[$gel]['total']++;
                $tblMundur['__total__'][$jur]++;
                $tblMundur['__total__']['total']++;
            }
        }

        $grandTotal = [
            'semua'       => $tblSemua['__total__']['total'],
            'seleksi'     => $tblSeleksi['__total__']['total'],
            'mundur'      => $tblMundur['__total__']['total'],
            'bayar'       => $tblBayar['__total__']['total'],
            'belum_bayar' => $tblBelumBayar['__total__']['total'],
        ];

        return view('admin.pendaftaran.statistik', compact(
            'jurusans', 'gelNamas',
            'tblSemua', 'tblStatus', 'statusLabels', 'allStatuses',
            'tblGender', 'tblPembayaran',
            'tblSeleksi', 'tblMundur', 'tblBayar', 'tblBelumBayar',
            'grandTotal'
        ));
    }
}
