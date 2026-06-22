<?php

namespace Database\Seeders;

use App\Models\Pendaftaran;
use App\Models\SpmbGelombang;
use Illuminate\Database\Seeder;

class DummyPendaftarSeeder extends Seeder
{
    public function run(): void
    {
        $gelombangAktif = SpmbGelombang::where('is_aktif', true)->first();
        $kode_gelombang = $gelombangAktif ? $gelombangAktif->kode_gelombang : 1;
        $prefix = 'MSB' . substr(date('Y'), -2) . '-' . str_pad($kode_gelombang, 2, '0', STR_PAD_LEFT) . '-';

        $siswaNames = [
            'Ahmad Fauzi', 'Muhammad Rizky', 'Rian Aditya', 'Budi Santoso', 'Joko Prasetyo',
            'Andi Wijaya', 'Siti Aminah', 'Dewi Sartika', 'Anisa Rahmawati', 'Rina Lestari',
            'Indra Kurniawan', 'Aditya Pratama', 'Fajar Nugroho', 'Taufik Hidayat', 'Hendra Saputra',
            'Eko Susanto', 'Agus Wibowo', 'Dwi Cahyono', 'Tri Hartono', 'Wahyu Budiman',
            'Slamet Riyadi', 'Rahmat Hidayatullah', 'Yusuf Ibrahim', 'Aris Munandar', 'Rudi Hermawan',
            'Heri Setiawan', 'Edi Purwanto', 'Surya Kencana', 'Fikri Haikal', 'Gilang Ramadhan',
            'Dimas Anggara', 'Reza Rahadian', 'Kevin Sanjaya', 'Aldi Taher', 'Angga Pratama',
            'Bagas Adi', 'Ilham Akbar', 'Faisal Basri', 'Rizky Billar', 'Putri Rahayu',
            'Mega Utami', 'Indah Permatasari', 'Larasati Putri', 'Sri Wahyuni', 'Kartika Sari',
            'Nurul Hidayah', 'Fitriani Lestari', 'Dian Sastrowardoyo', 'Chelsea Olivia', 'Maudy Ayunda'
        ];

        $ortuNames = [
            'Singgih Daryono', 'Agus Riyanto', 'Bambang Pamungkas', 'Joko Widodo', 'Susilo Bambang',
            'Megawati Soekarnoputri', 'Prabowo Subianto', 'Anies Baswedan', 'Ganjar Pranowo', 'Ridwan Kamil',
            'Sandiaga Uno', 'Erick Thohir', 'Mahfud MD', 'Gibran Rakabuming', 'Kaesang Pangarep',
            'Bobby Nasution', 'Basuki Tjahaja', 'Djarot Saiful', 'Anhar Gonggong', 'Emil Dardak',
            'Khofifah Indar', 'Tri Rismaharini', 'Abdullah Azwar', 'Bima Arya', 'Yayan Ruhian',
            'Joe Taslim', 'Iko Uwais', 'Deddy Corbuzier', 'Raffi Ahmad', 'Sule Sutisna',
            'Andre Taulany', 'Wendy Cagur', 'Denny Cagur', 'Raditya Dika', 'Tora Sudiro',
            'Indro Warkop', 'Dono Warkop', 'Kasino Warkop', 'Ahmad Dhani', 'Once Mekel',
            'Ari Lasso', 'Katon Bagaskara', 'Iwan Fals', 'Ebiet G. Ade', 'Rhoma Irama',
            'Muchsin Alatas', 'Mansyur S.', 'A. Rafiq', 'Didi Kempot', 'Chrisye Rahadi'
        ];

        $jurusans = ['TKR', 'TPM', 'TAV', 'TBSM', 'RPL'];

        for ($i = 0; $i < 50; $i++) {
            // Cek nomor terakhir setiap iterasi agar tidak bentrok
            $lastPendaftaran = Pendaftaran::where('no_daftar', 'like', $prefix . '%')
                ->orderBy('no_daftar', 'desc')
                ->first();
            $nextNum = $lastPendaftaran ? ((int) substr($lastPendaftaran->no_daftar, -3) + 1) : 1;
            $no_daftar = $prefix . str_pad($nextNum, 3, '0', STR_PAD_LEFT);

            $siswaName = $siswaNames[$i % count($siswaNames)];
            $ortuName = $ortuNames[$i % count($ortuNames)];
            
            // Random gender based on name
            $jk = in_array($siswaName, [
                'Siti Aminah', 'Dewi Sartika', 'Anisa Rahmawati', 'Rina Lestari', 'Putri Rahayu',
                'Mega Utami', 'Indah Permatasari', 'Larasati Putri', 'Sri Wahyuni', 'Kartika Sari',
                'Nurul Hidayah', 'Fitriani Lestari', 'Dian Sastrowardoyo', 'Chelsea Olivia', 'Maudy Ayunda'
            ]) ? 'P' : 'L';

            // Randomize choices
            shuffle($jurusans);
            $pil1 = $jurusans[0];
            $pil2 = $jurusans[1];
            $pil3 = $jurusans[2];

            Pendaftaran::create([
                'no_daftar' => $no_daftar,
                'tahun_aktif' => date('Y'),
                'gelombang' => $gelombangAktif ? $gelombangAktif->nama_gelombang : 'Gelombang 1',
                'nama_lengkap' => strtoupper($siswaName),
                'tempat_lahir' => 'Bantul',
                'tanggal_lahir' => date('Y-m-d', strtotime('-16 years + ' . rand(1, 365) . ' days')),
                'jenis_kelamin' => $jk,
                'agama' => 'islam',
                'no_hp_siswa' => '08' . rand(1000000000, 9999999999),
                'asal_sekolah' => 'SMP N ' . rand(1, 5) . ' BANTUL',
                'alamat_sekolah' => 'Bantul, DI Yogyakarta',
                'prestasi' => rand(0, 4) === 0 ? 'Juara ' . rand(1, 3) . ' Pencak Silat Tingkat Kabupaten' : '-',
                'nama_ortu' => strtoupper($ortuName),
                'pekerjaan_ortu' => ['Wiraswasta', 'PNS', 'Karyawan Swasta', 'Buruh', 'Petani'][rand(0, 4)],
                'no_hp_ortu' => '08' . rand(1000000000, 9999999999),
                'rt_asal' => str_pad(rand(1, 10), 2, '0', STR_PAD_LEFT),
                'desa_asal' => 'Bantul',
                'kecamatan_asal' => 'Bantul',
                'kabupaten_asal' => 'Bantul',
                'provinsi_asal' => 'DI Yogyakarta',
                'rt_tinggal' => str_pad(rand(1, 10), 2, '0', STR_PAD_LEFT),
                'desa_tinggal' => 'Bantul',
                'kecamatan_tinggal' => 'Bantul',
                'kabupaten_tinggal' => 'Bantul',
                'provinsi_tinggal' => 'DI Yogyakarta',
                'pil1' => $pil1,
                'pil2' => $pil2,
                'pil3' => $pil3,
                'status' => 'pending'
            ]);
        }
    }
}
