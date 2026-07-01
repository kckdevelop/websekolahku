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
use App\Http\Controllers\AdminSpmbHalamanController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminPesanController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\PetugasKesehatanController;
use App\Http\Controllers\PetugasWawancaraController;
use App\Http\Controllers\PetugasPembayaranController;
use App\Http\Controllers\AdminPetugasWawancaraController;
use App\Http\Controllers\AdminResetController;
use App\Http\Controllers\AdminDownloadPendaftaranController;
use App\Http\Controllers\AdminBkkController;
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
Route::get('/bkk', function () {
    $bkk = \App\Models\BkkSetting::getSingle();
    $lowongans = \App\Models\LowonganKerja::aktifTerbuka()->orderBy('urutan')->orderByDesc('created_at')->get();
    return view('pages.bkk.index', compact('bkk', 'lowongans'));
})->name('bkk');
Route::get('/jurusan/{slug}', function ($slug) {
    $content = \App\Models\JurusanContent::where('slug', $slug)->where('aktif', true)->first();

    if (!$content) {
        abort(404);
    }

    // Load all active jurusan for the tab bar
    $allJurusan = \App\Models\JurusanContent::aktif()->get();

    // Try a slug-specific view first, fall back to generic show
    $specificView = 'pages.jurusan.' . $slug;
    $view = view()->exists($specificView) ? $specificView : 'pages.jurusan.show';

    return view($view, compact('content', 'allJurusan'));
})->name('jurusan.show');

Route::get('/informasi/spmb', function () {
    $gelombangs = \App\Models\SpmbGelombang::orderBy('tanggal_mulai', 'asc')->get();
    $spmbContent = \App\Models\SpmbPageContent::getSingle();
    return view('pages.informasi.spmb', compact('gelombangs', 'spmbContent'));
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
Route::get('/informasi/prestasi/{id}', function ($id) {
    $prestasi = \App\Models\Prestasi::findOrFail($id);
    $lainnya = \App\Models\Prestasi::where('id', '!=', $prestasi->id)->orderBy('tanggal', 'desc')->take(5)->get();
    return view('pages.informasi.prestasi.show', compact('prestasi', 'lainnya'));
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

Route::get('/docs/api-pdf', function () {
    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.api_documentation');
    return $pdf->setPaper('a4', 'portrait')->stream('api-documentation.pdf');
})->name('docs.api-pdf');

Route::get('/docs/proposal-pdf', function () {
    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.proposal');
    return $pdf->setPaper('a4', 'portrait')->stream('proposal-penawaran-websekolah.pdf');
})->name('docs.proposal-pdf');

Route::get('/docs/panduan-pdf', function () {
    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.panduan');
    return $pdf->setPaper('a4', 'portrait')->stream('buku-panduan-aplikasi-websekolah.pdf');
})->name('docs.panduan-pdf');

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

    // Pengaturan Halaman SPMB
    Route::get('/spmb-halaman', [AdminSpmbHalamanController::class, 'edit'])->name('spmb-halaman.edit');
    Route::put('/spmb-halaman', [AdminSpmbHalamanController::class, 'update'])->name('spmb-halaman.update');

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

    // Bursa Kerja Khusus (BKK)
    Route::get('/bkk/setting', [AdminBkkController::class, 'editSetting'])->name('bkk.setting');
    Route::put('/bkk/setting', [AdminBkkController::class, 'updateSetting'])->name('bkk.setting.update');
    Route::get('/bkk/lowongan', [AdminBkkController::class, 'indexLowongan'])->name('bkk.lowongan.index');
    Route::get('/bkk/lowongan/create', [AdminBkkController::class, 'createLowongan'])->name('bkk.lowongan.create');
    Route::post('/bkk/lowongan', [AdminBkkController::class, 'storeLowongan'])->name('bkk.lowongan.store');
    Route::get('/bkk/lowongan/{lowongan}/edit', [AdminBkkController::class, 'editLowongan'])->name('bkk.lowongan.edit');
    Route::put('/bkk/lowongan/{lowongan}', [AdminBkkController::class, 'updateLowongan'])->name('bkk.lowongan.update');
    Route::delete('/bkk/lowongan/{lowongan}', [AdminBkkController::class, 'destroyLowongan'])->name('bkk.lowongan.destroy');
    Route::post('/bkk/lowongan/{lowongan}/toggle-aktif', [AdminBkkController::class, 'toggleAktifLowongan'])->name('bkk.lowongan.toggle-aktif');
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
