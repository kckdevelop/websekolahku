<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use App\Http\Controllers\PendaftaranController;

// Bootstrap Laravel
$consoleKernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$consoleKernel->bootstrap();

// Instantiate PendaftaranController
$controller = new PendaftaranController();

// Mock request
$request = Request::create('/spmb/daftar', 'POST', [
    'nama_lengkap' => 'TESTING CANDIDATE',
    'tempat_lahir' => 'Yogyakarta',
    'tgl' => '12',
    'bulan' => '05',
    'tahun' => '2008',
    'jenkel' => 'L',
    'agama' => 'islam',
    'no_hp_siswa' => '0899999999',
    'asal_sekolah' => 'SMP N 1 BANTUL',
    'alamat_sekolah' => 'Manding, Bantul',
    'prestasi' => 'Juara Catur',
    'nama_ortu' => 'WALI TESTING',
    'pekerjaan_ortu' => 'Karyawan',
    'no_hp_ortu' => '0877777777',
    'rt_asal' => '05',
    'desa_asal' => 'Sleman',
    'kecamatan_asal' => 'Sleman',
    'kabupaten_asal' => 'Sleman',
    'provinsi_asal' => 'DI Yogyakarta',
    'rt_tinggal' => '05',
    'desa_tinggal' => 'Sleman',
    'kecamatan_tinggal' => 'Sleman',
    'kabupaten_tinggal' => 'Sleman',
    'provinsi_tinggal' => 'DI Yogyakarta',
    'pil1' => 'RPL',
    'pil2' => 'TKR',
    'pil3' => 'TPM',
    'setuju' => 'setuju',
]);

// Call store directly
$response = $controller->store($request);

$pendaftar = Pendaftaran::where('nama_lengkap', 'TESTING CANDIDATE')->first();

if ($pendaftar) {
    echo "SUCCESS: Pendaftaran created!\n";
    echo "No Daftar: " . $pendaftar->no_daftar . "\n";
    echo "Tahun Aktif: " . $pendaftar->tahun_aktif . "\n";
    echo "Tanggal Lahir: " . $pendaftar->tanggal_lahir->format('Y-m-d') . "\n";
    echo "Pilihan 1: " . $pendaftar->pil1 . "\n";
} else {
    echo "FAILED: Pendaftaran not found!\n";
}
