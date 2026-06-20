<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminBeritaController;
use App\Http\Controllers\AdminPrestasiController;
use App\Http\Controllers\AdminGaleriFotoController;
use App\Http\Controllers\AdminGaleriVideoController;
use App\Http\Controllers\AdminTestimoniController;
use App\Http\Controllers\AdminPendaftaranController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\SiswaAuthController;
use App\Http\Controllers\AdminHeroController;
use App\Http\Controllers\AdminJurusanController;
use App\Http\Controllers\AdminSambutanController;
use App\Http\Controllers\AdminMitraController;
use App\Http\Controllers\AdminNoboxController;
use App\Http\Controllers\AdminSpmbGelombangController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminPesanController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\PetugasKesehatanController;
use App\Http\Controllers\PetugasWawancaraController;
use App\Http\Controllers\PetugasPembayaranController;
use App\Http\Controllers\AdminPetugasWawancaraController;
use App\Http\Controllers\AdminResetController;
use App\Http\Controllers\AdminDownloadPendaftaranController;
use App\Models\RiwayatPembayaran;

/*
|--------------------------------------------------------------------------
| Website Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $heroes = \App\Models\Hero::where('aktif', true)->orderBy('urutan', 'asc')->get();
    $sambutan = \App\Models\Sambutan::getSingle();
    $beritas = \App\Models\Berita::where('draft', false)->orderBy('tanggal', 'desc')->take(5)->get();
    $prestasis = \App\Models\Prestasi::orderBy('tanggal', 'desc')->take(6)->get();
    $testimonis = \App\Models\Testimoni::orderBy('created_at', 'desc')->take(6)->get();
    $mitras = \App\Models\Mitra::where('aktif', true)->orderBy('urutan', 'asc')->get();
    return view('pages.dashboard', compact('heroes', 'sambutan', 'beritas', 'prestasis', 'testimonis', 'mitras'));
});
Route::get('/galeri/galerifoto', function () {
    $galeriFoto = \App\Models\GaleriFoto::firstOrCreate(
        [],
        [
            'folder_id' => '0B6IFRRkB6oTeSUVBc1E2U3JxQVk',
            'judul' => 'Album Foto Kegiatan',
            'deskripsi' => 'Dokumentasi foto kegiatan dan prestasi SMK Muhammadiyah 1 Bantul',
        ]
    );
    return view('pages.galeri.galerifoto', compact('galeriFoto'));
});
Route::get('/profil/identitas', function () {
    return view('pages.profil.identitas');
});
Route::get('/profil/visi-misi', function () {
    return view('pages.profil.visi-misi');
});
Route::get('/profil/sejarah', function () {
    return view('pages.profil.sejarah');
});
Route::get('/profil/fasilitas', function () {
    return view('pages.profil.fasilitas');
});
Route::get('/profil/mitra', function () {
    $mitras = \App\Models\Mitra::where('aktif', true)->orderBy('urutan', 'asc')->get();
    return view('pages.profil.mitra', compact('mitras'));
});
Route::get('/galeri/galerivideo', function () {
    $galeriVideos = \App\Models\GaleriVideo::orderBy('tanggal', 'desc')->get();
    $kategoriList = \App\Models\GaleriVideo::distinct()->orderBy('kategori')->pluck('kategori');
    return view('pages.galeri.galerivideo', compact('galeriVideos', 'kategoriList'));
});
Route::get('/jurusan/{slug}', function ($slug) {
    $listJurusan = [
        'tkr' => [
            'name' => 'Teknik Kendaraan Ringan',
            'abbr' => 'TKR',
            'sub' => 'Mencetak Teknisi Otomotif Profesional dan Siap Kerja',
            'desc1' => 'Program Keahlian Teknik Kendaraan Ringan (TKR) di SMK Muhammadiyah 1 Bantul dirancang untuk membekali siswa dengan kompetensi dalam perawatan, perbaikan, dan pemeliharaan kendaraan ringan seperti mobil dan minibus.',
            'desc2' => 'Kurikulum kami mengacu pada standar industri otomotif nasional dan internasional, dengan praktik langsung di bengkel sekolah yang dilengkapi peralatan modern.',
            'points' => [
                'Praktik langsung di bengkel sekolah',
                'Kerja sama dengan bengkel mitra industri',
                'Sertifikasi kompetensi (BNSP, Astra, dll.)',
                'Penempatan kerja lulusan 98%'
            ],
            'photos' => [
                ['gambar' => 'https://picsum.photos/seed/tkr-a/400/300', 'deskripsi' => 'Perbaikan mesin mobil di bengkel sekolah'],
                ['gambar' => 'https://picsum.photos/seed/tkr-b/400/300', 'deskripsi' => 'Kalibrasi sistem ECU menggunakan alat modern'],
                ['gambar' => 'https://picsum.photos/seed/tkr-c/400/300', 'deskripsi' => 'Servis berkala kendaraan ringan'],
                ['gambar' => 'https://picsum.photos/seed/tkr-d/400/300', 'deskripsi' => 'Tim TKR dalam kompetisi otomotif tingkat DIY'],
                ['gambar' => 'https://picsum.photos/seed/tkr-e/400/300', 'deskripsi' => 'Pelatihan teknis bersama mitra industri Astra'],
                ['gambar' => 'https://picsum.photos/seed/tkr-f/400/300', 'deskripsi' => 'Uji kompetensi keahlian oleh asesor BNSP'],
                ['gambar' => 'https://picsum.photos/seed/tkr-g/400/300', 'deskripsi' => 'Bengkel praktik TKR yang lengkap dan representatif'],
                ['gambar' => 'https://picsum.photos/seed/tkr-h/400/300', 'deskripsi' => 'Siswa TKR sedang praktik perawatan kendaraan']
            ]
        ],
        'tbsm' => [
            'name' => 'Teknik Bisnis Sepeda Motor',
            'abbr' => 'TBSM',
            'sub' => 'Mencetak Mekanik Sepeda Motor yang Handal dan Berjiwa Wirausaha',
            'desc1' => 'Program Keahlian Teknik Bisnis Sepeda Motor (TBSM) di SMK Muhammadiyah 1 Bantul membekali siswa dengan keterampilan teknik sepeda motor.',
            'desc2' => 'Siswa dilatih untuk menguasai teknologi sepeda motor terkini dengan dukungan sarana prasarana yang lengkap dan modern.',
            'points' => [
                'Praktik langsung di bengkel sekolah standar industri',
                'Kerja sama dengan pabrikan sepeda motor ternama',
                'Sertifikasi keahlian mekanik',
                'Peluang wirausaha bengkel mandiri'
            ],
            'photos' => [
                ['gambar' => 'https://picsum.photos/seed/tbsm-a/400/300', 'deskripsi' => 'Servis dan tune-up sepeda motor di bengkel sekolah'],
                ['gambar' => 'https://picsum.photos/seed/tbsm-b/400/300', 'deskripsi' => 'Pengecekan sistem injeksi sepeda motor modern'],
                ['gambar' => 'https://picsum.photos/seed/tbsm-c/400/300', 'deskripsi' => 'Praktik kelistrikan sepeda motor'],
                ['gambar' => 'https://picsum.photos/seed/tbsm-d/400/300', 'deskripsi' => 'Tim TBSM dalam kompetisi mekanik tingkat nasional'],
                ['gambar' => 'https://picsum.photos/seed/tbsm-e/400/300', 'deskripsi' => 'Pelatihan bersama Honda dan Yamaha mitra industri'],
                ['gambar' => 'https://picsum.photos/seed/tbsm-f/400/300', 'deskripsi' => 'Uji kompetensi keahlian TBSM oleh asesor BNSP'],
                ['gambar' => 'https://picsum.photos/seed/tbsm-g/400/300', 'deskripsi' => 'Bengkel TBSM yang dilengkapi alat modern'],
                ['gambar' => 'https://picsum.photos/seed/tbsm-h/400/300', 'deskripsi' => 'Siswa TBSM belajar teknik perawatan berkala']
            ]
        ],
        'tpm' => [
            'name' => 'Teknik Permesinan',
            'abbr' => 'TPM',
            'sub' => 'Membentuk Operator dan Programmer Mesin Industri yang Profesional',
            'desc1' => 'Program Keahlian Teknik Permesinan (TPM) di SMK Muhammadiyah 1 Bantul mengajarkan teknik pengoperasian mesin perkakas.',
            'desc2' => 'Kurikulum mencakup pembubutan, frais, gerinda, serta pemrograman mesin CNC standar industri manufaktur.',
            'points' => [
                'Praktik menggunakan mesin bubut, frais, dan CNC',
                'Sertifikasi kompetensi operator mesin perkakas',
                'Kerja sama dengan industri manufaktur terkemuka',
                'Keterampilan gambar teknik (CAD/CAM)'
            ],
            'photos' => [
                ['gambar' => 'https://picsum.photos/seed/tpm-a/400/300', 'deskripsi' => 'Praktik membubut presisi di bengkel mesin'],
                ['gambar' => 'https://picsum.photos/seed/tpm-b/400/300', 'deskripsi' => 'Pemrograman CNC simulator dan mesin riil'],
                ['gambar' => 'https://picsum.photos/seed/tpm-c/400/300', 'deskripsi' => 'Proses kerja mesin frais (milling)'],
                ['gambar' => 'https://picsum.photos/seed/tpm-d/400/300', 'deskripsi' => 'Pengukuran menggunakan jangka sorong dan mikrometer'],
                ['gambar' => 'https://picsum.photos/seed/tpm-e/400/300', 'deskripsi' => 'Praktik las industri dan fabrikasi logam'],
                ['gambar' => 'https://picsum.photos/seed/tpm-f/400/300', 'deskripsi' => 'Perawatan berkala mesin-mesin perkakas'],
                ['gambar' => 'https://picsum.photos/seed/tpm-g/400/300', 'deskripsi' => 'Uji kompetensi operator mesin perkakas BNSP'],
                ['gambar' => 'https://picsum.photos/seed/tpm-h/400/300', 'deskripsi' => 'Kunjungan industri manufaktur skala besar']
            ]
        ],
        'tav' => [
            'name' => 'Teknik Audio Video',
            'abbr' => 'TAV',
            'sub' => 'Mencetak Teknisi Elektronika dan Audio Video Kreatif',
            'desc1' => 'Program Keahlian Teknik Audio Video (TAV) membekali siswa dengan dasar elektronika, sistem audio, dan instalasi video.',
            'desc2' => 'Siswa diajarkan merancang, merakit, dan memperbaiki berbagai peralatan elektronik rumah tangga dan industri.',
            'points' => [
                'Praktik merakit sistem audio dan video',
                'Dasar-dasar pemrograman mikroprosesor/mikrokontroler',
                'Sertifikasi BNSP bidang elektronika',
                'Pelatihan kewirausahaan jasa servis elektronik'
            ],
            'photos' => [
                ['gambar' => 'https://picsum.photos/seed/tav-a/400/300', 'deskripsi' => 'Pembuatan layout PCB menggunakan software CAD'],
                ['gambar' => 'https://picsum.photos/seed/tav-b/400/300', 'deskripsi' => 'Proses etching dan soldering komponen elektronika'],
                ['gambar' => 'https://picsum.photos/seed/tav-c/400/300', 'deskripsi' => 'Pengukuran tegangan menggunakan osiloskop'],
                ['gambar' => 'https://picsum.photos/seed/tav-d/400/300', 'deskripsi' => 'Perakitan amplifier dan sound system sekolah'],
                ['gambar' => 'https://picsum.photos/seed/tav-e/400/300', 'deskripsi' => 'Pemrograman mikrokontroler Arduino'],
                ['gambar' => 'https://picsum.photos/seed/tav-f/400/300', 'deskripsi' => 'Instalasi jaringan CCTV dan audio distribusi'],
                ['gambar' => 'https://picsum.photos/seed/tav-g/400/300', 'deskripsi' => 'Uji kompetensi teknisi audio video BNSP'],
                ['gambar' => 'https://picsum.photos/seed/tav-h/400/300', 'deskripsi' => 'Servis peralatan elektronik rumah tangga masyarakat']
            ]
        ],
        'rpl' => [
            'name' => 'Rekayasa Perangkat Lunak',
            'abbr' => 'RPL',
            'sub' => 'Membangun Generasi Programmer dan Pengembang Aplikasi Andal',
            'desc1' => 'Program Keahlian Rekayasa Perangkat Lunak (RPL) membekali siswa dengan keahlian pemrograman web, mobile, dan desktop.',
            'desc2' => 'Fokus pada pengembangan perangkat lunak, basis data, dan algoritma menggunakan teknologi terupdate.',
            'points' => [
                'Praktik coding di laboratorium komputer modern',
                'Pengembangan aplikasi web, android, dan game',
                'Kurikulum selaras dengan kebutuhan industri IT',
                'Sertifikasi programmer dari mitra teknologi'
            ],
            'photos' => [
                ['gambar' => 'https://picsum.photos/seed/rpl-a/400/300', 'deskripsi' => 'Pembelajaran coding bahasa pemrograman modern'],
                ['gambar' => 'https://picsum.photos/seed/rpl-b/400/300', 'deskripsi' => 'Pengembangan aplikasi web dinamis dengan Laravel'],
                ['gambar' => 'https://picsum.photos/seed/rpl-c/400/300', 'deskripsi' => 'Pembuatan UI/UX design aplikasi mobile di Figma'],
                ['gambar' => 'https://picsum.photos/seed/rpl-d/400/300', 'deskripsi' => 'Praktik administrasi basis data MySQL & PostgreSQL'],
                ['gambar' => 'https://picsum.photos/seed/rpl-e/400/300', 'deskripsi' => 'Project-based learning pembuatan game edukasi'],
                ['gambar' => 'https://picsum.photos/seed/rpl-f/400/300', 'deskripsi' => 'Sesi review kode kelompok di laboratorium komputer'],
                ['gambar' => 'https://picsum.photos/seed/rpl-g/400/300', 'deskripsi' => 'Uji kompetensi programer junior oleh LSP'],
                ['gambar' => 'https://picsum.photos/seed/rpl-h/400/300', 'deskripsi' => 'Kunjungan industri ke Software House terkemuka']
            ]
        ]
    ];

    if (!array_key_exists($slug, $listJurusan)) {
        abort(404);
    }

    $j = $listJurusan[$slug];

    $content = \App\Models\JurusanContent::getOrDefault($slug, [
        'nama_jurusan' => $j['name'],
        'hero_judul' => $j['name'] . ' (' . $j['abbr'] . ')',
        'hero_subjudul' => $j['sub'],
        'deskripsi_1' => $j['desc1'],
        'deskripsi_2' => $j['desc2'],
        'poin_unggulan' => $j['points'],
        'foto_kegiatan' => $j['photos']
    ]);

    return view('pages.jurusan.' . $slug, compact('content'));
})->name('jurusan.show');
Route::get('/informasi/spmb', function () {
    $gelombangs = \App\Models\SpmbGelombang::orderBy('tanggal_mulai', 'asc')->get();
    return view('pages.informasi.spmb', compact('gelombangs'));
});
Route::get('/informasi/berita', function (\Illuminate\Http\Request $request) {
    $search = $request->query('search');
    $query = \App\Models\Berita::where('draft', false)->orderBy('tanggal', 'desc');
    if ($search) {
        $query->where(function($q) use ($search) {
            $q->where('judul', 'like', "%{$search}%")
              ->orWhere('konten', 'like', "%{$search}%");
        });
    }
    $beritas = $query->paginate(9)->withQueryString();
    return view('pages.informasi.berita.index', compact('beritas', 'search'));
});
Route::get('/informasi/berita/{slug}', function ($slug) {
    $berita = \App\Models\Berita::where('slug', $slug)->where('draft', false)->firstOrFail();
    $lainnya = \App\Models\Berita::where('id', '!=', $berita->id)->where('draft', false)->orderBy('tanggal', 'desc')->take(5)->get();
    return view('pages.informasi.berita.show', compact('berita', 'lainnya'));
});
Route::get('/informasi/prestasi', function (\Illuminate\Http\Request $request) {
    $kategori = $request->query('kategori');
    $query = \App\Models\Prestasi::orderBy('tanggal', 'desc');
    if ($kategori) {
        $query->where('kategori', $kategori);
    }
    $prestasis = $query->paginate(12)->withQueryString();
    $kategoriList = \App\Models\Prestasi::distinct()->orderBy('kategori')->pluck('kategori');
    return view('pages.informasi.prestasi.index', compact('prestasis', 'kategoriList', 'kategori'));
});
Route::get('/informasi/kontak', function () {
    return view('pages.informasi.kontak');
});
Route::post('/informasi/kontak', function (\Illuminate\Http\Request $request) {
    $validated = $request->validate([
        'nama' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'subjek' => 'required|string|max:255',
        'pesan' => 'required|string',
    ]);

    \App\Models\Pesan::create($validated);

    return response()->json(['success' => true, 'message' => 'Pesan Anda berhasil dikirim!']);
})->name('kontak.store');
/*
|--------------------------------------------------------------------------
| SPMB (Seleksi Penerimaan Murid Baru) Routes
|--------------------------------------------------------------------------
*/
Route::prefix('spmb')->name('spmb.')->group(function () {

    // Landing Page
    Route::get('/daftar', [PendaftaranController::class, 'showDaftar'])->name('daftar');

    // Auth Siswa (Register, Verifikasi, Login)
    Route::get('/register', [SiswaAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [SiswaAuthController::class, 'register'])->name('register.post');
    Route::get('/verifikasi', [SiswaAuthController::class, 'showVerifikasi'])->name('verifikasi');
    Route::post('/verifikasi', [SiswaAuthController::class, 'verifikasi'])->name('verifikasi.post');
    Route::post('/resend-otp', [SiswaAuthController::class, 'resendOTP'])->name('resend.otp');
    Route::get('/login', [SiswaAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [SiswaAuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [SiswaAuthController::class, 'logout'])->name('logout');

    // Formulir (Protected - butuh login siswa)
    Route::middleware('siswa.auth')->group(function () {
        Route::get('/formulir/{step?}', [PendaftaranController::class, 'showFormulir'])
            ->where('step', '[1-5]')
            ->name('formulir');
        Route::post('/formulir/{step}', [PendaftaranController::class, 'simpanStep'])
            ->where('step', '[1-5]')
            ->name('formulir.simpan');
    });

    // Tes Gaya Belajar — login publik via No. Daftar + Tgl Lahir
    Route::get('/tes-gaya-belajar/login',  [PendaftaranController::class, 'showLoginTes'])->name('tes-gaya-belajar.login');
    Route::post('/tes-gaya-belajar/login', [PendaftaranController::class, 'loginTes'])->name('tes-gaya-belajar.login.post');
    Route::post('/tes-gaya-belajar/logout',[PendaftaranController::class, 'logoutTes'])->name('tes-gaya-belajar.logout');

    // Tes Gaya Belajar — halaman tes (diakses via sesi siswa ATAU sesi tes)
    Route::get('/tes-gaya-belajar',  [PendaftaranController::class, 'showTesGayaBelajar'])->name('tes-gaya-belajar');
    Route::post('/tes-gaya-belajar', [PendaftaranController::class, 'simpanTesGayaBelajar'])->name('tes-gaya-belajar.simpan');

    // Halaman Hasil Tes (setelah submit tanpa siswa session)
    Route::get('/tes-gaya-belajar/hasil/{pendaftaran}', [PendaftaranController::class, 'hasilTesGayaBelajar'])->name('tes-gaya-belajar.hasil');

    // Public (Sukses & Cetak — tanpa login)
    Route::get('/sukses/{id}', [PendaftaranController::class, 'sukses'])->name('sukses');
    Route::get('/cetak/{pendaftaran}', [PendaftaranController::class, 'cetak'])->name('cetak');
});

/*
|--------------------------------------------------------------------------
| Admin Auth Routes (Guest Only)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
});

/*
|--------------------------------------------------------------------------
| Admin Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Logout
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Berita
    Route::resource('berita', AdminBeritaController::class)->parameters(['berita' => 'berita']);

    // Prestasi
    Route::resource('prestasi', AdminPrestasiController::class);

    // Galeri Foto
    Route::resource('galeri_foto', AdminGaleriFotoController::class);

    // Galeri Video
    Route::resource('galeri_video', AdminGaleriVideoController::class);

    // Testimoni
    Route::resource('testimoni', AdminTestimoniController::class);

    // Pendaftaran (Full CRUD + print)
    Route::get('/pendaftaran/laporan', [AdminPendaftaranController::class, 'laporan'])->name('pendaftaran.laporan');
    Route::get('/pendaftaran/{pendaftaran}/cetak', [AdminPendaftaranController::class, 'cetak'])->name('pendaftaran.cetak');
    Route::patch('/pendaftaran/{pendaftaran}/status', [AdminPendaftaranController::class, 'updateStatus'])->name('pendaftaran.updateStatus');
    Route::resource('pendaftaran', AdminPendaftaranController::class);

    // Hero Slideshow
    Route::resource('hero', AdminHeroController::class);

    // Jurusan / Program Keahlian
    Route::resource('jurusan', AdminJurusanController::class);

    // Mitra Industri
    Route::resource('mitra', AdminMitraController::class);

    // Sambutan Kepala Sekolah
    Route::get('/sambutan', [AdminSambutanController::class, 'edit'])->name('sambutan.edit');
    Route::put('/sambutan', [AdminSambutanController::class, 'update'])->name('sambutan.update');

    // Pengaturan Nobox
    Route::get('/nobox', [AdminNoboxController::class, 'edit'])->name('nobox.edit');
    Route::put('/nobox', [AdminNoboxController::class, 'update'])->name('nobox.update');
    Route::post('/nobox/test', [AdminNoboxController::class, 'testSend'])->name('nobox.test');

    // Pengaturan Gelombang SPMB
    Route::post('/gelombang/{gelombang}/toggle-active', [AdminSpmbGelombangController::class, 'toggleActive'])->name('gelombang.toggleActive');
    Route::resource('gelombang', AdminSpmbGelombangController::class);

    // Kelola User (admin & petugas)
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    // Pesan Masuk
    Route::resource('pesan', AdminPesanController::class)->only(['index', 'show', 'destroy']);

    // Petugas Pewawancara
    Route::get('/petugas-wawancara', [AdminPetugasWawancaraController::class, 'index'])->name('petugas-wawancara.index');
    Route::post('/petugas-wawancara', [AdminPetugasWawancaraController::class, 'store'])->name('petugas-wawancara.store');
    Route::put('/petugas-wawancara/{petugasWawancara}', [AdminPetugasWawancaraController::class, 'update'])->name('petugas-wawancara.update');
    Route::delete('/petugas-wawancara/{petugasWawancara}', [AdminPetugasWawancaraController::class, 'destroy'])->name('petugas-wawancara.destroy');

    // Reset Pendaftaran
    Route::get('/reset-pendaftaran', [AdminResetController::class, 'index'])->name('reset.index');
    Route::post('/reset-pendaftaran', [AdminResetController::class, 'reset'])->name('reset.post');

    // Download Pendaftaran (Excel)
    Route::get('/download-pendaftaran', [AdminDownloadPendaftaranController::class, 'index'])->name('download.pendaftaran');
    Route::get('/download-pendaftaran/excel', [AdminDownloadPendaftaranController::class, 'download'])->name('download.pendaftaran.excel');
});

/*
|--------------------------------------------------------------------------
| Petugas Pendaftaran Routes
|--------------------------------------------------------------------------
|
*/
Route::middleware('petugas.auth')->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', [PetugasController::class, 'index'])->name('dashboard');
    Route::get('/laporan', [PetugasController::class, 'laporan'])->name('laporan');
    Route::get('/pendaftar', [PetugasController::class, 'pendaftar'])->name('pendaftar');
    Route::get('/pendaftaran/create', [PetugasController::class, 'create'])->name('create');
    Route::post('/pendaftaran', [PetugasController::class, 'store'])->name('store');
    Route::get('/pendaftaran/{pendaftaran}', [PetugasController::class, 'show'])->name('show');
    Route::put('/pendaftaran/{pendaftaran}', [PetugasController::class, 'update'])->name('update');
    Route::delete('/pendaftaran/{pendaftaran}', [PetugasController::class, 'destroy'])->name('destroy');
    Route::post('/pendaftaran/{pendaftaran}/foto', [PetugasController::class, 'uploadFoto'])->name('upload.foto');
    Route::post('/pendaftaran/{pendaftaran}/berkas', [PetugasController::class, 'updateBerkas'])->name('update.berkas');
    Route::get('/pendaftaran/{pendaftaran}/kartu', [PetugasController::class, 'kartu'])->name('kartu');
});

// Petugas Kesehatan
Route::middleware('petugas.kesehatan.auth')->prefix('petugas/kesehatan')->name('petugas.kesehatan.')->group(function () {
    Route::get('/dashboard', [PetugasKesehatanController::class, 'index'])->name('dashboard');
    Route::get('/laporan', [PetugasKesehatanController::class, 'laporan'])->name('laporan');
    Route::get('/pendaftaran/{pendaftaran}', [PetugasKesehatanController::class, 'show'])->name('show');
    Route::put('/pendaftaran/{pendaftaran}', [PetugasKesehatanController::class, 'update'])->name('update');
});

// Petugas Wawancara, Minat Bakat & Gaya Belajar
Route::middleware('petugas.wawancara.auth')->prefix('petugas/wawancara')->name('petugas.wawancara.')->group(function () {
    Route::get('/dashboard', [PetugasWawancaraController::class, 'index'])->name('dashboard');
    Route::get('/laporan', [PetugasWawancaraController::class, 'laporan'])->name('laporan');
    Route::get('/pendaftaran/{pendaftaran}', [PetugasWawancaraController::class, 'show'])->name('show');
    Route::put('/pendaftaran/{pendaftaran}', [PetugasWawancaraController::class, 'update'])->name('update');
});

// Petugas Pembayaran
Route::middleware('petugas.pembayaran.auth')->prefix('petugas/pembayaran')->name('petugas.pembayaran.')->group(function () {
    Route::get('/dashboard', [PetugasPembayaranController::class, 'index'])->name('dashboard');
    Route::get('/laporan', [PetugasPembayaranController::class, 'laporan'])->name('laporan');
    Route::delete('/riwayat/{riwayat}', [PetugasPembayaranController::class, 'destroyRiwayat'])->name('riwayat.destroy');
    Route::get('/pendaftaran/{pendaftaran}', [PetugasPembayaranController::class, 'show'])->name('show');
    Route::put('/pendaftaran/{pendaftaran}', [PetugasPembayaranController::class, 'update'])->name('update');
    Route::get('/pendaftaran/{pendaftaran}/kartu', [PetugasPembayaranController::class, 'kartu'])->name('kartu');
    Route::get('/riwayat/{riwayat}/bukti', [PetugasPembayaranController::class, 'bukti'])->name('riwayat.bukti');
});
