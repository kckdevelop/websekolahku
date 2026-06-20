<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\SiswaAkun;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    // ──────────────────────────────────────────────
    // LANDING PAGE SPMB
    // ──────────────────────────────────────────────

    public function showDaftar()
    {
        $siswaId = session('siswa_akun_id');

        if ($siswaId) {
            $siswa = SiswaAkun::find($siswaId);
            if ($siswa && $siswa->pendaftaran) {
                return redirect()->route('spmb.sukses', $siswa->pendaftaran->id)
                    ->with('info', 'Anda sudah melakukan pendaftaran.');
            }
            return redirect()->route('spmb.formulir');
        }

        return view('pages.informasi.daftar');
    }

    // ──────────────────────────────────────────────
    // MULTI-STEP FORMULIR
    // ──────────────────────────────────────────────

    public function showFormulir(int $step = 1)
    {
        $siswaId = session('siswa_akun_id');
        $siswa   = SiswaAkun::findOrFail($siswaId);

        // Cek apakah sudah daftar
        if ($siswa->pendaftaran) {
            return redirect()->route('spmb.sukses', $siswa->pendaftaran->id);
        }

        if ($step < 1 || $step > 5) {
            $step = 1;
        }

        // Ambil data form yang sudah tersimpan di session
        $formData = session('spmb_form_data', []);

        $gelombangs = \App\Models\SpmbGelombang::orderBy('tanggal_mulai', 'asc')->get();

        return view('pages.spmb.formulir', compact('step', 'formData', 'siswa', 'gelombangs'));
    }

    public function simpanStep(Request $request, int $step)
    {
        // Validasi per step
        $rules = $this->getValidationRules($step);
        $request->validate($rules['rules'], $rules['messages'] ?? []);

        // Simpan data step ke session
        $formData = session('spmb_form_data', []);
        $formData = array_merge($formData, $request->except(['_token', '_method']));
        session(['spmb_form_data' => $formData]);

        if ($step < 5) {
            return redirect()->route('spmb.formulir', $step + 1);
        }

        // Step 5 — final submit
        return $this->finalStore($request);
    }

    private function finalStore(Request $request)
    {
        $siswaId  = session('siswa_akun_id');
        $siswa    = SiswaAkun::findOrFail($siswaId);
        $formData = session('spmb_form_data', []);

        // Format tanggal lahir
        $tanggalLahir = $formData['tahun'] . '-' . $formData['bulan'] . '-' . str_pad($formData['tgl'], 2, '0', STR_PAD_LEFT);

        // Generate No Daftar: MSB[YY]-[WW]-[NNN]
        $selectedGelombangId = $formData['gelombang_id'] ?? null;
        $activeWave = \App\Models\SpmbGelombang::find($selectedGelombangId);
        if (!$activeWave) {
            $activeWave = \App\Models\SpmbGelombang::where('is_aktif', true)->first();
        }
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
        $last   = Pendaftaran::where('no_daftar', 'like', $prefix . '%')->orderBy('no_daftar', 'desc')->first();
        $nextNum   = $last ? (int) substr($last->no_daftar, -3) + 1 : 1;
        $noDaftar  = $prefix . str_pad($nextNum, 3, '0', STR_PAD_LEFT);

        // Upload files
        $fotoAkta = null;
        $fotoKk   = null;
        if ($request->hasFile('foto_akta')) {
            $fotoAkta = $request->file('foto_akta')->store('pendaftaran/akta', 'public');
        }
        if ($request->hasFile('foto_kk')) {
            $fotoKk = $request->file('foto_kk')->store('pendaftaran/kk', 'public');
        }

        // Nomor WA siswa dari akun (otomatis diisi)
        $noHpSiswa = $siswa->no_wa;

        $pendaftaran = Pendaftaran::create([
            'siswa_akun_id'    => $siswa->id,
            'no_daftar'        => $noDaftar,
            'tahun_aktif'      => $startYear,
            'gelombang'        => $gelombangName,
            'nama_lengkap'     => strtoupper($formData['nama_lengkap']),
            'tempat_lahir'     => $formData['tempat_lahir'],
            'tanggal_lahir'    => $tanggalLahir,
            'jenis_kelamin'    => $formData['jenkel'],
            'agama'            => $formData['agama'],
            'no_hp_siswa'      => $noHpSiswa,
            'asal_sekolah'     => strtoupper($formData['asal_sekolah']),
            'alamat_sekolah'   => $formData['alamat_sekolah'] ?? null,
            'prestasi'         => $formData['prestasi'] ?? null,
            'nama_ortu'        => strtoupper($formData['nama_ortu']),
            'pekerjaan_ortu'   => $formData['pekerjaan_ortu'],
            'no_hp_ortu'       => $formData['no_hp_ortu'],
            'jalan_asal'       => $formData['jalan_asal'] ?? null,
            'dusun_asal'       => $formData['dusun_asal'] ?? null,
            'rt_asal'          => $formData['rt_asal'],
            'rw_asal'          => $formData['rw_asal'] ?? null,
            'desa_asal'        => $formData['desa_asal'],
            'kecamatan_asal'   => $formData['kecamatan_asal'],
            'kabupaten_asal'   => $formData['kabupaten_asal'],
            'provinsi_asal'    => $formData['provinsi_asal'],
            'jalan_tinggal'    => $formData['jalan_tinggal'] ?? null,
            'dusun_tinggal'    => $formData['dusun_tinggal'] ?? null,
            'rt_tinggal'       => $formData['rt_tinggal'],
            'rw_tinggal'       => $formData['rw_tinggal'] ?? null,
            'desa_tinggal'     => $formData['desa_tinggal'],
            'kecamatan_tinggal'=> $formData['kecamatan_tinggal'],
            'kabupaten_tinggal'=> $formData['kabupaten_tinggal'],
            'provinsi_tinggal' => $formData['provinsi_tinggal'],
            'pil1'             => $formData['pil1'],
            'pil2'             => $formData['pil2'],
            'pil3'             => $formData['pil3'],
            'foto_akta'        => $fotoAkta,
            'foto_kk'          => $fotoKk,
            'status'           => 'pending',
        ]);

        // Bersihkan data form dari session
        session()->forget('spmb_form_data');

        return redirect()->route('spmb.sukses', $pendaftaran->id);
    }

    private function getValidationRules(int $step): array
    {
        return match ($step) {
            1 => [
                'rules' => [
                    'nama_lengkap' => 'required|string|max:255',
                    'tempat_lahir' => 'required|string|max:255',
                    'tgl'          => 'required|numeric|between:1,31',
                    'bulan'        => 'required|string|max:2',
                    'tahun'        => 'required|numeric|between:2000,2020',
                    'jenkel'       => 'required|in:L,P',
                    'agama'        => 'required|string',
                    'asal_sekolah' => 'required|string|max:255',
                    'alamat_sekolah' => 'nullable|string',
                    'prestasi'     => 'nullable|string',
                ],
            ],
            2 => [
                'rules' => [
                    'nama_ortu'      => 'required|string|max:255',
                    'pekerjaan_ortu' => 'required|string|max:255',
                    'no_hp_ortu'     => 'required|string|max:20',
                ],
            ],
            3 => [
                'rules' => [
                    'rt_asal'           => 'required|string|max:10',
                    'desa_asal'         => 'required|string|max:255',
                    'kecamatan_asal'    => 'required|string|max:255',
                    'kabupaten_asal'    => 'required|string|max:255',
                    'provinsi_asal'     => 'required|string|max:255',
                    'rt_tinggal'        => 'required|string|max:10',
                    'desa_tinggal'      => 'required|string|max:255',
                    'kecamatan_tinggal' => 'required|string|max:255',
                    'kabupaten_tinggal' => 'required|string|max:255',
                    'provinsi_tinggal'  => 'required|string|max:255',
                ],
            ],
            4 => [
                'rules' => [
                    'pil1'     => 'required|in:TKR,TPM,TAV,TBSM,RPL',
                    'pil2'     => 'required|in:TKR,TPM,TAV,TBSM,RPL|different:pil1',
                    'pil3'     => 'required|in:TKR,TPM,TAV,TBSM,RPL|different:pil1|different:pil2',
                    'gelombang_id' => 'required|exists:spmb_gelombangs,id',
                    'foto_akta'=> 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
                    'foto_kk'  => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
                ],
                'messages' => [
                    'pil2.different' => 'Pilihan jurusan II tidak boleh sama dengan Pilihan I.',
                    'pil3.different' => 'Pilihan jurusan III tidak boleh sama dengan Pilihan I atau II.',
                ],
            ],
            5 => [
                'rules' => [
                    'setuju' => 'required|accepted',
                ],
                'messages' => [
                    'setuju.required' => 'Anda harus menyetujui pernyataan untuk melanjutkan.',
                    'setuju.accepted' => 'Anda harus menyetujui pernyataan untuk melanjutkan.',
                ],
            ],
            default => ['rules' => []],
        };
    }

    // ──────────────────────────────────────────────
    // SUKSES & CETAK
    // ──────────────────────────────────────────────

    public function sukses($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        return view('pages.informasi.sukses', compact('pendaftaran'));
    }

    public function cetak(Pendaftaran $pendaftaran)
    {
        return view('admin.pendaftaran.cetak', compact('pendaftaran'));
    }

    // ──────────────────────────────────────────────
    // TES GAYA BELAJAR — Login via No. Daftar + Tgl Lahir
    // ──────────────────────────────────────────────

    public function showLoginTes()
    {
        // Jika sudah punya sesi tes aktif, langsung ke halaman tes
        if (session('gaya_belajar_pendaftaran_id') || session('siswa_akun_id')) {
            return redirect()->route('spmb.tes-gaya-belajar');
        }
        return view('pages.spmb.login_tes');
    }

    public function loginTes(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'no_daftar'     => 'required|string|max:30',
            'tanggal_lahir' => 'required|date',
        ], [
            'no_daftar.required'     => 'Nomor pendaftaran wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date'     => 'Format tanggal lahir tidak valid.',
        ]);

        $pendaftaran = Pendaftaran::whereRaw('UPPER(no_daftar) = ?', [strtoupper(trim($request->no_daftar))])->first();

        if (!$pendaftaran) {
            return back()->withInput()->withErrors([
                'no_daftar' => 'Nomor pendaftaran tidak ditemukan. Periksa kembali nomor Anda.',
            ]);
        }

        // Cocokkan tanggal lahir
        $tglInput = \Carbon\Carbon::parse($request->tanggal_lahir)->format('Y-m-d');
        $tglDb    = $pendaftaran->tanggal_lahir->format('Y-m-d');

        if ($tglInput !== $tglDb) {
            return back()->withInput()->withErrors([
                'tanggal_lahir' => 'Tanggal lahir tidak sesuai dengan data pendaftaran.',
            ]);
        }

        if (!$pendaftaran->verified_at) {
            return back()->withInput()->withErrors([
                'no_daftar' => 'Berkas pendaftaran Anda belum diverifikasi oleh petugas. Silakan datang ke sekolah terlebih dahulu.',
            ]);
        }

        // Simpan ke session
        session(['gaya_belajar_pendaftaran_id' => $pendaftaran->id]);

        return redirect()->route('spmb.tes-gaya-belajar');
    }

    public function logoutTes()
    {
        session()->forget('gaya_belajar_pendaftaran_id');
        return redirect()->route('spmb.tes-gaya-belajar.login')
            ->with('success', 'Anda telah keluar dari sesi Tes Gaya Belajar.');
    }

    // ──────────────────────────────────────────────
    // TES GAYA BELAJAR — Show & Simpan
    // ──────────────────────────────────────────────

    /**
     * Ambil pendaftaran dari sesi aktif (siswa login atau tes login).
     */
    private function getTesPendaftaran(): ?Pendaftaran
    {
        // Cara 1: login via no_daftar + tgl_lahir
        if ($id = session('gaya_belajar_pendaftaran_id')) {
            return Pendaftaran::find($id);
        }
        // Cara 2: login via akun siswa
        if ($siswaId = session('siswa_akun_id')) {
            $siswa = SiswaAkun::find($siswaId);
            return $siswa ? $siswa->pendaftaran : null;
        }
        return null;
    }

    public function showTesGayaBelajar()
    {
        $pendaftaran = $this->getTesPendaftaran();

        if (!$pendaftaran) {
            return redirect()->route('spmb.tes-gaya-belajar.login')
                ->with('error', 'Silakan login terlebih dahulu untuk mengakses Tes Gaya Belajar.');
        }

        if (!$pendaftaran->verified_at) {
            return redirect()->route('spmb.tes-gaya-belajar.login')
                ->with('warning', 'Tes Gaya Belajar hanya dapat diakses setelah berkas pendaftaran Anda diverifikasi oleh petugas.');
        }

        return view('pages.spmb.tes_gaya_belajar', compact('pendaftaran'));
    }

    public function simpanTesGayaBelajar(\Illuminate\Http\Request $request)
    {
        $pendaftaran = $this->getTesPendaftaran();

        if (!$pendaftaran || !$pendaftaran->verified_at) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sesi telah berakhir atau pendaftaran belum terverifikasi. Silakan login kembali.'
            ], 403);
        }

        // Validate the 24 questions and cita_cita
        $rules = [
            'cita_cita' => 'required|string|max:255',
        ];
        for ($i = 1; $i <= 24; $i++) {
            $rules["q$i"] = 'required|integer|between:1,3';
        }

        $request->validate($rules);

        // Calculate VARK scores
        $visual = 0;
        $auditori = 0;
        $kinestetik = 0;

        for ($i = 1; $i <= 8; $i++) {
            $visual += (int) $request->input("q$i");
        }
        for ($i = 9; $i <= 16; $i++) {
            $auditori += (int) $request->input("q$i");
        }
        for ($i = 17; $i <= 24; $i++) {
            $kinestetik += (int) $request->input("q$i");
        }

        // Determine dominant style
        $max = max($visual, $auditori, $kinestetik);
        if ($max === $visual) {
            $dominan = 'Visual';
            $deskripsi = "Anda sangat kuat dalam memahami informasi secara visual. Gambar, diagram, peta konsep, warna-warni, serta video peragaan akan sangat membantu Anda dalam belajar dan mengingat sesuatu.";
            $potensi = "Rekomendasi Karir/Studi: Desainer Grafis, Arsitek, Videografer, Programmer UI/UX, Editor Video, Ahli Pemetaan.";
        } elseif ($max === $auditori) {
            $dominan = 'Auditori';
            $deskripsi = "Anda belajar paling efektif melalui pendengaran. Penjelasan lisan, diskusi kelompok, membaca dengan bersuara, podcast, atau mendengarkan rekaman penjelasan materi adalah metode belajar terbaik Anda.";
            $potensi = "Rekomendasi Karir/Studi: Penyiar Radio/Podcast, Konselor, Guru/Dosen, Humas/PR, Penerjemah, Musisi.";
        } else {
            $dominan = 'Kinestetik';
            $deskripsi = "Anda sangat menyukai pembelajaran praktis dan bergerak. Praktikum langsung, eksperimen di laboratorium, simulasi, merakit alat, dan aktivitas fisik membuat Anda belajar secara mendalam.";
            $potensi = "Rekomendasi Karir/Studi: Operator Mesin, Montir/Mekanik Otomotif, Atlet, Praktisi Olahraga, Pekerja Lapangan, Wirausaha Manufaktur.";
        }

        // Update database
        $pendaftaran->update([
            'gaya_belajar_tipe'        => strtolower($dominan),
            'gaya_belajar_minat_bakat' => 'Cita-cita: ' . $request->cita_cita,
            'gaya_belajar_catatan'     => "Skor - Visual: $visual, Auditori: $auditori, Kinestetik: $kinestetik",
            'gaya_belajar_petugas'     => 'Siswa (Mandiri)',
            'gaya_belajar_verified_at' => now(),
        ]);

        // Clear public test session
        session()->forget('gaya_belajar_pendaftaran_id');

        return response()->json([
            'status'     => 'success',
            'nama'       => $pendaftaran->nama_lengkap,
            'visual'     => $visual,
            'auditori'   => $auditori,
            'kinestetik' => $kinestetik,
            'dominan'    => $dominan,
            'deskripsi'  => $deskripsi,
            'potensi'    => $potensi,
        ]);
    }

    public function hasilTesGayaBelajar(Pendaftaran $pendaftaran)
    {
        return view('pages.spmb.hasil_tes', compact('pendaftaran'));
    }
}
