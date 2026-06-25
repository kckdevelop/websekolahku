<?php

namespace Database\Seeders;

use App\Models\Berita;
use App\Models\Hero;
use App\Models\Mitra;
use App\Models\Pendaftaran;
use App\Models\Prestasi;
use App\Models\Sambutan;
use App\Models\SpmbGelombang;
use App\Models\Testimoni;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * ============================================================
 * DUMMY DATA SEEDER — DEVELOPMENT / TESTING ONLY
 * ============================================================
 * ⛔ JANGAN jalankan seeder ini di server PRODUCTION!
 *
 * Seeder ini mengisi data fiktif untuk keperluan:
 *   - Testing tampilan frontend
 *   - Simulasi alur pendaftaran
 *   - Demo panel admin
 *
 * CATATAN: Gambar menggunakan URL picsum.photos (butuh internet).
 *          Di hosting tanpa akses internet, gambar tidak akan
 *          ter-download dan akan menggunakan fallback (ui-avatars).
 *
 * Jalankan:
 *   php artisan db:seed --class=DummyDataSeeder
 * ============================================================
 */
class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->warn('⚠️  Mengisi data DUMMY untuk development...');

        $this->seedHero();
        $this->seedSambutan();
        $this->seedBerita();
        $this->seedPrestasi();
        $this->seedTestimoni();
        $this->seedMitra();
        $this->seedGelombang();
        $this->seedPendaftar();

        $this->command->info('✅ Semua data dummy berhasil di-seed.');
    }

    // ── Helper: download gambar (opsional, gagal = null) ─────
    private function downloadImage(string $url, string $subdir, string $filename): ?string
    {
        $path = "{$subdir}/{$filename}";
        try {
            if (!\Illuminate\Support\Facades\Storage::disk('public')->exists($subdir)) {
                \Illuminate\Support\Facades\Storage::disk('public')->makeDirectory($subdir);
            }
            $ctx  = stream_context_create(['http' => ['timeout' => 8, 'user_agent' => 'Mozilla/5.0']]);
            $data = @file_get_contents($url, false, $ctx);
            if ($data) {
                \Illuminate\Support\Facades\Storage::disk('public')->put($path, $data);
                return $path;
            }
        } catch (\Exception $e) {
            // Abaikan jika gagal — model sudah punya fallback
        }
        return null;
    }

    // ── Hero Slides ──────────────────────────────────────────
    private function seedHero(): void
    {
        $slides = [
            ['judul' => 'Belajar dengan Praktik Nyata',        'gambar_url' => 'https://picsum.photos/id/1031/1920/1080', 'filename' => 'slide-otomotif.jpg',  'label_tombol' => 'Daftar Sekarang', 'link_tombol' => '#informasi', 'urutan' => 1],
            ['judul' => 'Siap Kerja di Era Digital',           'gambar_url' => 'https://picsum.photos/id/1032/1920/1080', 'filename' => 'slide-rpl.jpg',       'label_tombol' => 'Lihat Jurusan',   'link_tombol' => '/jurusan/rpl', 'urutan' => 2],
            ['judul' => 'Prestasi yang Menginspirasi',         'gambar_url' => 'https://picsum.photos/id/1072/1920/1080', 'filename' => 'slide-prestasi.jpg',  'label_tombol' => 'Lihat Prestasi',  'link_tombol' => '/informasi/prestasi', 'urutan' => 3],
        ];
        foreach ($slides as $item) {
            $gambar = $this->downloadImage($item['gambar_url'], 'hero', $item['filename']);
            Hero::firstOrCreate(['judul' => $item['judul']], [
                'deskripsi'     => 'Siswa SMK Muhammadiyah 1 Bantul mengasah keterampilan di lingkungan industri modern.',
                'gambar'        => $gambar,
                'label_tombol'  => $item['label_tombol'],
                'link_tombol'   => $item['link_tombol'],
                'urutan'        => $item['urutan'],
                'aktif'         => true,
            ]);
        }
        $this->command->info('  → Hero slides OK');
    }

    // ── Sambutan Kepala Sekolah ──────────────────────────────
    private function seedSambutan(): void
    {
        Sambutan::firstOrCreate(
            ['nama_kepala_sekolah' => 'Drs. H. Suparman, M.Pd'],
            [
                'foto'          => null,
                'isi_sambutan'  => 'Assalamu\'alaikum Warahmatullahi Wabarakatuh. Selamat datang di website resmi SMK Muhammadiyah 1 Bantul. Kami berkomitmen untuk terus meningkatkan mutu pendidikan kejuruan yang berakhlak mulia, kompeten, dan siap menghadapi tantangan dunia kerja global. Semoga putra-putri Anda dapat menimba ilmu dan mengembangkan potensi terbaik mereka bersama kami.',
            ]
        );
        $this->command->info('  → Sambutan kepala sekolah OK');
    }

    // ── Berita ───────────────────────────────────────────────
    private function seedBerita(): void
    {
        $items = [
            [
                'judul'      => 'SMK Muhammadiyah 1 Bantul Raih Juara 1 Robotik Nasional',
                'slug'       => 'smk-muhammadiyah-1-bantul-raih-juara-1-robotik-nasional',
                'konten'     => '<p>Tim robotik SMK Muhammadiyah 1 Bantul berhasil menorehkan prestasi gemilang di tingkat nasional. Dalam ajang Kompetisi Robotik Indonesia 2026, tim sekolah menyabet Juara 1 pada kategori Robot Cerdas Penyelamat.</p><p>Kepala Sekolah menyampaikan rasa bangganya terhadap dedikasi para siswa dan pembimbing yang telah bekerja keras mempersiapkan kompetisi ini selama berbulan-bulan.</p>',
                'gambar_url' => 'https://picsum.photos/id/1072/800/600',
                'filename'   => 'berita-robotik.jpg',
                'tanggal'    => '2026-06-12',
                'draft'      => false,
            ],
            [
                'judul'      => 'Kerja Sama Industri Baru dengan PT Astra International',
                'slug'       => 'kerja-sama-industri-baru-dengan-pt-astra-international',
                'konten'     => '<p>Dalam rangka memperluas program link and match, SMK Muhammadiyah 1 Bantul menandatangani nota kesepahaman (MoU) kemitraan dengan PT Astra International.</p><p>Kerja sama ini mencakup penyelarasan kurikulum kejuruan, program magang guru & siswa, sertifikasi industri, hingga prioritas penyaluran kerja bagi lulusan terbaik.</p>',
                'gambar_url' => 'https://picsum.photos/id/1031/800/600',
                'filename'   => 'berita-mou-astra.jpg',
                'tanggal'    => '2026-06-10',
                'draft'      => false,
            ],
            [
                'judul'      => 'PPDB Online Tahun Ajaran Baru 2026/2027 Resmi Dibuka!',
                'slug'       => 'ppdb-online-tahun-ajaran-baru-2026-2027-resmi-dibuka',
                'konten'     => '<p>Penerimaan Peserta Didik Baru (PPDB) SMK Muhammadiyah 1 Bantul untuk Tahun Ajaran 2026/2027 resmi dibuka mulai hari ini. Pendaftaran dapat dilakukan secara online melalui portal resmi SPMB sekolah.</p><p>Tersedia lima kompetensi keahlian unggulan yang siap mencetak lulusan terampil dan berakhlak mulia.</p>',
                'gambar_url' => 'https://picsum.photos/id/1039/800/600',
                'filename'   => 'berita-ppdb.jpg',
                'tanggal'    => '2026-06-08',
                'draft'      => false,
            ],
            [
                'judul'      => 'Pelepasan 15 Siswa Lulusan Magang Kerja ke Jepang',
                'slug'       => 'pelepasan-15-siswa-lulusan-magang-kerja-ke-jepang',
                'konten'     => '<p>Sekolah kembali melepas siswa lulusan berprestasi untuk mengikuti program magang kerja ke Jepang di bidang manufaktur dan otomotif. Program ini merupakan hasil kerja sama dengan LPK terakreditasi.</p><p>Para siswa dibekali pelatihan bahasa dan kultur Jepang selama 6 bulan sebelum keberangkatan.</p>',
                'gambar_url' => 'https://picsum.photos/id/1035/800/600',
                'filename'   => 'berita-magang-jepang.jpg',
                'tanggal'    => '2026-06-05',
                'draft'      => false,
            ],
        ];
        foreach ($items as $item) {
            $gambar = $this->downloadImage($item['gambar_url'], 'berita', $item['filename']);
            Berita::firstOrCreate(['slug' => $item['slug']], [
                'judul'   => $item['judul'],
                'konten'  => $item['konten'],
                'gambar'  => $gambar,
                'tanggal' => $item['tanggal'],
                'draft'   => $item['draft'],
            ]);
        }
        $this->command->info('  → Berita OK');
    }

    // ── Prestasi ─────────────────────────────────────────────
    private function seedPrestasi(): void
    {
        $items = [
            ['judul' => 'Juara 1 Lomba Robotik Nasional 2025',           'deskripsi' => 'Meraih medali emas kategori Robot Cerdas Penyelamat tingkat nasional.',              'kategori' => 'Teknologi', 'tingkat' => 'Nasional',   'peraih' => 'Tim Robotik SMK Muh 1 Bantul',  'gambar_url' => 'https://picsum.photos/id/1072/400/400', 'filename' => 'prestasi-robotik.jpg', 'tanggal' => '2025-10-15'],
            ['judul' => 'Juara 2 Olimpiade Teknologi Web DIY',           'deskripsi' => 'Juara 2 bidang Web Design dan Development dalam ajang LKS Tingkat Provinsi DIY.',   'kategori' => 'IT',        'tingkat' => 'Provinsi',   'peraih' => 'Rian Hidayat (Kelas XII RPL)',   'gambar_url' => 'https://picsum.photos/id/1032/400/400', 'filename' => 'prestasi-web.jpg',    'tanggal' => '2025-11-20'],
            ['judul' => 'Medali Emas Kejuaraan Pencak Silat Tapak Suci', 'deskripsi' => 'Meraih medali emas tanding kelas C Putra Kejuaraan Daerah Tapak Suci.',             'kategori' => 'Olahraga',  'tingkat' => 'Kabupaten',  'peraih' => 'Ahmad Fauzi (Kelas XI TKR)',     'gambar_url' => 'https://picsum.photos/id/1005/400/400', 'filename' => 'prestasi-silat.jpg',  'tanggal' => '2025-12-05'],
            ['judul' => 'Juara Terbaik Kategori Mobil Listrik Hemat Energi', 'deskripsi' => 'Inovasi mobil listrik hemat energi dalam ajang Kreativitas Siswa Vokasi.', 'kategori' => 'Teknologi', 'tingkat' => 'Nasional', 'peraih' => 'Tim Otomotif TKR & TPM', 'gambar_url' => 'https://picsum.photos/id/1033/400/400', 'filename' => 'prestasi-mobil.jpg', 'tanggal' => '2026-02-18'],
        ];
        foreach ($items as $item) {
            $foto = $this->downloadImage($item['gambar_url'], 'prestasi', $item['filename']);
            Prestasi::firstOrCreate(['judul' => $item['judul']], [
                'deskripsi' => $item['deskripsi'],
                'kategori'  => $item['kategori'],
                'tingkat'   => $item['tingkat'],
                'peraih'    => $item['peraih'],
                'foto'      => $foto,
                'tanggal'   => $item['tanggal'],
            ]);
        }
        $this->command->info('  → Prestasi OK');
    }

    // ── Testimoni Alumni ─────────────────────────────────────
    private function seedTestimoni(): void
    {
        $items = [
            ['nama' => 'Dwi Prasetyo',    'alumni_tahun' => '2020', 'pekerjaan' => 'Teknisi Senior di Auto2000',          'kutipan' => 'Ilmu dan keterampilan yang saya dapat di SMK Muhammadiyah 1 Bantul langsung saya terapkan di tempat kerja. Alhamdulillah, sekarang saya jadi teknisi senior di bengkel ternama.', 'gambar_url' => 'https://picsum.photos/id/1005/150/150', 'filename' => 'alumni-dwi.jpg'],
            ['nama' => 'Siti Rahayu',     'alumni_tahun' => '2021', 'pekerjaan' => 'Web Developer di Startup Yogyakarta', 'kutipan' => 'Jurusan RPL membuka jalan karier saya di dunia IT. Guru-gurunya sangat mendukung, dan fasilitas lab-nya lengkap. Sekarang saya kerja remote sebagai web developer!',                      'gambar_url' => 'https://picsum.photos/id/1011/150/150', 'filename' => 'alumni-siti.jpg'],
            ['nama' => 'Budi Santoso',    'alumni_tahun' => '2022', 'pekerjaan' => 'Operator CNC di PT Astra International', 'kutipan' => 'PKL di industri mitra benar-benar membekali saya. Setelah lulus, langsung direkrut! Terima kasih SMK Muhammadiyah 1 Bantul.',                                                        'gambar_url' => 'https://picsum.photos/id/1020/150/150', 'filename' => 'alumni-budi.jpg'],
            ['nama' => 'Anisa Fitriani',  'alumni_tahun' => '2019', 'pekerjaan' => 'Teknisi Audio di Studio Rekaman',      'kutipan' => 'Nilai Islami yang ditanamkan di sekolah membuat saya tetap istiqomah meski kerja di lingkungan yang menantang. Sangat bersyukur pernah sekolah di sini.',                                'gambar_url' => 'https://picsum.photos/id/1030/150/150', 'filename' => 'alumni-anisa.jpg'],
        ];
        foreach ($items as $item) {
            $foto = $this->downloadImage($item['gambar_url'], 'testimoni', $item['filename']);
            Testimoni::firstOrCreate(['nama' => $item['nama']], [
                'alumni_tahun' => $item['alumni_tahun'],
                'pekerjaan'    => $item['pekerjaan'],
                'kutipan'      => $item['kutipan'],
                'foto'         => $foto,
            ]);
        }
        $this->command->info('  → Testimoni OK');
    }

    // ── Mitra Sekolah ─────────────────────────────────────────
    private function seedMitra(): void
    {
        $mitras = ['PT Astra International', 'PT Toyota Motor', 'PT Honda Prospect', 'PT Yamaha Indonesia', 'Bank BRI'];
        foreach ($mitras as $idx => $nama) {
            Mitra::firstOrCreate(['nama' => $nama], ['logo' => null, 'urutan' => $idx + 1, 'aktif' => true]);
        }
        $this->command->info('  → Mitra OK');
    }

    // ── SPMB Gelombang ───────────────────────────────────────
    private function seedGelombang(): void
    {
        SpmbGelombang::firstOrCreate(
            ['nama_gelombang' => 'Gelombang 1'],
            [
                'kode_gelombang'    => 1,
                'tanggal_buka'      => '2026-01-01',
                'tanggal_tutup'     => '2026-04-30',
                'is_aktif'          => false,
                'biaya_pendaftaran' => 50000,
                'biaya_spp_default' => 1500000,
                'biaya_zakat_default' => 300000,
                'potongan_subsidi'  => 0,
                'keterangan'        => 'Gelombang pertama PPDB 2026/2027',
            ]
        );
        SpmbGelombang::firstOrCreate(
            ['nama_gelombang' => 'Gelombang 2'],
            [
                'kode_gelombang'    => 2,
                'tanggal_buka'      => '2026-05-01',
                'tanggal_tutup'     => '2026-07-31',
                'is_aktif'          => true,
                'biaya_pendaftaran' => 50000,
                'biaya_spp_default' => 1500000,
                'biaya_zakat_default' => 300000,
                'potongan_subsidi'  => 0,
                'keterangan'        => 'Gelombang kedua PPDB 2026/2027 (aktif)',
            ]
        );
        $this->command->info('  → Gelombang SPMB OK');
    }

    // ── Dummy Pendaftar ──────────────────────────────────────
    private function seedPendaftar(): void
    {
        $gelombang    = SpmbGelombang::where('is_aktif', true)->first();
        $kodeGelombang = $gelombang?->kode_gelombang ?? 1;
        $prefix        = 'MSB' . substr(date('Y'), -2) . '-' . str_pad($kodeGelombang, 2, '0', STR_PAD_LEFT) . '-';

        $siswaNames = [
            'Ahmad Fauzi',      'Muhammad Rizky',   'Rian Aditya',   'Budi Santoso',    'Joko Prasetyo',
            'Andi Wijaya',      'Siti Aminah',      'Dewi Sartika',  'Anisa Rahmawati', 'Rina Lestari',
            'Indra Kurniawan',  'Aditya Pratama',   'Fajar Nugroho', 'Taufik Hidayat',  'Hendra Saputra',
            'Eko Susanto',      'Agus Wibowo',      'Dwi Cahyono',   'Tri Hartono',     'Wahyu Budiman',
        ];
        $ortuNames = [
            'Singgih Daryono',  'Agus Riyanto',   'Bambang Pamungkas', 'Joko Widodo',    'Susilo Bambang',
            'Ahmad Fauzan',     'Budi Hermawan',  'Slamet Riyadi',     'Rahmat Hidayat', 'Yusuf Ibrahim',
            'Heri Setiawan',    'Edi Purwanto',   'Surya Kencana',     'Fikri Haikal',   'Gilang Ramadhan',
            'Dimas Anggara',    'Reza Rahadian',  'Kevin Sanjaya',     'Aldi Taher',     'Angga Pratama',
        ];
        $perempuan  = ['Siti Aminah', 'Dewi Sartika', 'Anisa Rahmawati', 'Rina Lestari'];
        $jurusans   = ['TKR', 'TPM', 'TAV', 'TBSM', 'RPL'];

        for ($i = 0; $i < 20; $i++) {
            $last    = Pendaftaran::where('no_daftar', 'like', $prefix . '%')->orderBy('no_daftar', 'desc')->first();
            $nextNum = $last ? ((int) substr($last->no_daftar, -3) + 1) : 1;
            $noDaftar = $prefix . str_pad($nextNum, 3, '0', STR_PAD_LEFT);

            $nama = $siswaNames[$i % count($siswaNames)];
            $ortu = $ortuNames[$i % count($ortuNames)];
            $jk   = in_array($nama, $perempuan) ? 'P' : 'L';

            shuffle($jurusans);

            Pendaftaran::create([
                'no_daftar'       => $noDaftar,
                'tahun_aktif'     => date('Y'),
                'gelombang'       => $gelombang?->nama_gelombang ?? 'Gelombang 1',
                'nama_lengkap'    => strtoupper($nama),
                'tempat_lahir'    => 'Bantul',
                'tanggal_lahir'   => date('Y-m-d', strtotime('-16 years +' . rand(1, 365) . ' days')),
                'jenis_kelamin'   => $jk,
                'agama'           => 'islam',
                'no_hp_siswa'     => '0856' . rand(10000000, 99999999),
                'asal_sekolah'    => 'SMP N ' . rand(1, 5) . ' BANTUL',
                'alamat_sekolah'  => 'Bantul, DI Yogyakarta',
                'prestasi'        => rand(0, 3) === 0 ? 'Juara ' . rand(1, 3) . ' Pencak Silat Tingkat Kabupaten' : '-',
                'nama_ortu'       => strtoupper($ortu),
                'pekerjaan_ortu'  => ['Wiraswasta', 'PNS', 'Karyawan Swasta', 'Buruh', 'Petani'][rand(0, 4)],
                'no_hp_ortu'      => '0812' . rand(10000000, 99999999),
                'rt_asal'         => str_pad(rand(1, 10), 2, '0', STR_PAD_LEFT),
                'desa_asal'       => 'Bantul',
                'kecamatan_asal'  => 'Bantul',
                'kabupaten_asal'  => 'Bantul',
                'provinsi_asal'   => 'DI Yogyakarta',
                'rt_tinggal'      => str_pad(rand(1, 10), 2, '0', STR_PAD_LEFT),
                'desa_tinggal'    => 'Bantul',
                'kecamatan_tinggal' => 'Bantul',
                'kabupaten_tinggal' => 'Bantul',
                'provinsi_tinggal'  => 'DI Yogyakarta',
                'pil1'            => $jurusans[0],
                'pil2'            => $jurusans[1],
                'pil3'            => $jurusans[2],
                'status'          => 'pending',
            ]);
        }
        $this->command->info('  → 20 dummy pendaftar OK');
    }
}
