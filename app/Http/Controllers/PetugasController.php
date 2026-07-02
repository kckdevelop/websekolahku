<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PetugasController extends Controller
{
    /**
     * Dashboard: daftar semua pendaftaran untuk diproses petugas.
     */
    public function index(Request $request)
    {
        $totalAll    = Pendaftaran::count();
        $totalFoto   = Pendaftaran::whereNotNull('foto_siswa')->count();
        $totalVerif  = Pendaftaran::whereNotNull('verified_at')->count();
        $totalBelum  = Pendaftaran::whereNull('verified_at')->count();

        // Ambil data gelombang dari database (dinamis)
        $gelombangs = \App\Models\SpmbGelombang::orderBy('tanggal_mulai', 'asc')->get();

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
        $allPendaftaran = Pendaftaran::select('no_daftar', 'pil1', 'status', 'verified_at')->get();

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

        foreach ($allPendaftaran as $p) {
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

        return view('petugas.dashboard', compact(
            'totalAll', 'totalFoto', 'totalVerif', 'totalBelum',
            'dataPendaftar', 'dataCalon', 'dataDiterima', 'totalPendaftar', 'totalCalon', 'totalDiterima',
            'jurusans', 'gelMap'
        ));
    }

    public function pendaftar(Request $request)
    {
        $query = Pendaftaran::query()->orderBy('created_at', 'desc');

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_daftar', 'like', "%{$search}%")
                  ->orWhere('nama_lengkap', 'like', "%{$search}%");
            });
        }

        // Filter status foto / verifikasi
        if ($request->filter === 'no_foto') {
            $query->whereNull('foto_siswa');
        } elseif ($request->filter === 'has_foto') {
            $query->whereNotNull('foto_siswa');
        } elseif ($request->filter === 'belum_verif') {
            $query->whereNull('verified_at');
        } elseif ($request->filter === 'sudah_verif') {
            $query->whereNotNull('verified_at');
        }

        $perPage = $request->input('per_page', 20);
        if (!in_array($perPage, [10, 20, 50, 100])) {
            $perPage = 20;
        }

        $pendaftarans = $query->paginate($perPage)->withQueryString();

        if ($request->ajax()) {
            return view('petugas.pendaftar.table', compact('pendaftarans'))->render();
        }

        return view('petugas.pendaftar.index', compact('pendaftarans'));
    }

    /**
     * Detail pendaftaran: webcam foto + checklist berkas.
     */
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

        $berkasItems = [
            'ijazah_asli'   => 'Ijazah / SKHUN Asli',
            'ijazah_copy'   => 'Fotocopy Ijazah / SKHUN',
            'formulir'      => 'Formulir Pendataan',
            'foto_3x4'      => 'Foto 3x4 (3 lembar)',
            'akta_copy'     => 'Fotocopy Akta Kelahiran',
            'kk_copy'       => 'Fotocopy Kartu Keluarga (KK)',
            'rapor_copy'    => 'Fotocopy Rapor SMP/MTs Semester V',
        ];

        $berkasLengkap = $pendaftaran->berkas_lengkap ?? [];

        return view('petugas.show', compact('pendaftaran', 'berkasItems', 'berkasLengkap'));
    }

    /**
     * Update data pendaftaran (siswa) dari bagian petugas.
     */
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
            'gelombang_id' => 'required|exists:spmb_gelombangs,id',
        ]);

        $selectedGelombangId = $request->input('gelombang_id');
        $wave = \App\Models\SpmbGelombang::find($selectedGelombangId);
        $activeWave = $wave ?: \App\Models\SpmbGelombang::where('is_aktif', true)->first();

        $gelombangName = $activeWave ? $activeWave->nama_gelombang : 'Gelombang I';
        $tahunAjaran = $activeWave ? $activeWave->tahun_ajaran : '2026/2027';

        // Get 2-digit year (YY) from tahun_ajaran
        $startYear = date('Y');
        if (preg_match('/^\d{4}/', $tahunAjaran, $matches)) {
            $startYear = $matches[0];
        }
        $year2Digit = substr($startYear, -2); // e.g. '26'

        // Get 2-digit wave (WW) from nama_gelombang
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

        return redirect()->route('petugas.show', $pendaftaran->id)->with('success', 'Data pendaftaran berhasil diperbarui.');
    }

    /**
     * AJAX: Simpan foto siswa dari webcam (base64 → JPEG).
     */
    public function uploadFoto(Request $request, Pendaftaran $pendaftaran)
    {
        $request->validate([
            'foto_data' => 'required|string',
        ]);

        try {
            $imageData = $request->foto_data;
            // Strip "data:image/jpeg;base64," prefix
            $imageData = preg_replace('/^data:image\/\w+;base64,/', '', $imageData);
            $imageData = base64_decode($imageData);

            if (!$imageData) {
                return response()->json(['success' => false, 'message' => 'Data foto tidak valid.'], 422);
            }

            // Simpan dengan nama no_daftar
            $filename   = str_replace('-', '_', $pendaftaran->no_daftar) . '.jpg';
            $path       = 'pendaftaran/foto_siswa/' . $filename;

            Storage::disk('public')->put($path, $imageData);

            $pendaftaran->update(['foto_siswa' => $path]);

            return response()->json([
                'success' => true,
                'message' => 'Foto berhasil disimpan!',
                'url'     => Storage::disk('public')->url($path),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan foto: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Simpan checklist kelengkapan berkas + catatan petugas.
     */
    public function updateBerkas(Request $request, Pendaftaran $pendaftaran)
    {
        $berkasLengkap   = $request->input('berkas', []);
        $catatanPetugas  = $request->input('catatan_petugas', '');
        $tandaiVerif     = $request->boolean('tandai_verifikasi');

        // Tentukan status baru:
        // - Jika tandai verif ON  → status = 'verifikasi'
        // - Jika tandai verif OFF → kembalikan ke 'pending' HANYA jika belum diterima/ditolak
        if ($tandaiVerif) {
            $statusBaru = 'verifikasi';
        } elseif (in_array($pendaftaran->status, ['diterima', 'ditolak'])) {
            $statusBaru = $pendaftaran->status; // jangan ubah jika sudah final
        } else {
            $statusBaru = 'pending';
        }

        $pendaftaran->update([
            'berkas_lengkap'   => $berkasLengkap,
            'catatan_petugas'  => $catatanPetugas,
            'verified_at'      => $tandaiVerif ? now() : $pendaftaran->verified_at,
            'status'           => $statusBaru,
        ]);

        return redirect()
            ->route('petugas.show', $pendaftaran)
            ->with('success', 'Kelengkapan berkas berhasil disimpan!');
    }

    /**
     * Halaman cetak Kartu Calon Murid Baru.
     */
    public function kartu(Pendaftaran $pendaftaran)
    {
        return view('petugas.kartu', compact('pendaftaran'));
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

        if ($request->filled('status_foto')) {
            if ($request->status_foto === 'sudah') {
                $query->whereNotNull('foto_siswa');
            } else {
                $query->whereNull('foto_siswa');
            }
        }

        if ($request->filled('status_verifikasi')) {
            if ($request->status_verifikasi === 'sudah') {
                $query->whereNotNull('verified_at');
            } else {
                $query->whereNull('verified_at');
            }
        }

        $pendaftarans = $query->get();
        $gelombangs = \App\Models\SpmbGelombang::orderBy('tanggal_mulai', 'asc')->get();

        $totalAll = Pendaftaran::count();
        $totalFoto = Pendaftaran::whereNotNull('foto_siswa')->count();
        $totalBelumFoto = Pendaftaran::whereNull('foto_siswa')->count();
        $totalVerif = Pendaftaran::whereNotNull('verified_at')->count();
        $totalBelumVerif = Pendaftaran::whereNull('verified_at')->count();

        return view('petugas.laporan', compact(
            'pendaftarans', 'gelombangs', 'totalAll', 'totalFoto', 'totalBelumFoto', 'totalVerif', 'totalBelumVerif'
        ));
    }

    public function create()
    {
        $daftarPendaftar = Pendaftaran::orderBy('no_daftar', 'desc')->get();
        $gelombangs = \App\Models\SpmbGelombang::orderBy('tanggal_mulai', 'asc')->get();
        return view('petugas.create', compact('daftarPendaftar', 'gelombangs'));
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

        return redirect()->route('petugas.dashboard')->with('success', 'Data pendaftaran berhasil ditambahkan.');
    }

    public function destroy(Request $request, Pendaftaran $pendaftaran)
    {
        $nama     = $pendaftaran->nama_lengkap;
        $noDaftar = $pendaftaran->no_daftar;

        // Hapus file-file terkait dari storage
        if ($pendaftaran->foto_akta) {
            Storage::disk('public')->delete($pendaftaran->foto_akta);
        }
        if ($pendaftaran->foto_kk) {
            Storage::disk('public')->delete($pendaftaran->foto_kk);
        }
        if ($pendaftaran->foto_siswa) {
            Storage::disk('public')->delete($pendaftaran->foto_siswa);
        }

        // Hapus riwayat pembayaran terkait (relasi hasMany)
        $pendaftaran->riwayatPembayaran()->delete();

        // Hapus data pendaftaran utama (semua data kesehatan, wawancara,
        // gaya belajar, dan pembayaran tersimpan sebagai kolom di tabel ini)
        $pendaftaran->delete();

        // Selalu kembalikan JSON jika request AJAX atau Accept: application/json
        if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Data pendaftaran {$nama} ({$noDaftar}) beserta seluruh data terkait berhasil dihapus."
            ], 200);
        }

        return redirect()->route('petugas.pendaftar')
            ->with('success', "Data pendaftaran {$nama} ({$noDaftar}) beserta seluruh data terkait berhasil dihapus secara permanen.");
    }
}
