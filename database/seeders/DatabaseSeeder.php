<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Berita;
use App\Models\Prestasi;
use App\Models\GaleriFoto;
use App\Models\GaleriVideo;
use App\Models\Testimoni;
use App\Models\Pendaftaran;
use App\Models\Hero;
use App\Models\JurusanContent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Admin User
        User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin Sekolah',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]
        );

        // Seed Kesehatan
        User::firstOrCreate(
            ['email' => 'kesehatan@admin.com'],
            [
                'name' => 'Petugas UKS & Kesehatan',
                'password' => bcrypt('kesehatan'),
                'role' => 'petugas_kesehatan',
            ]
        );

        // Seed Wawancara
        User::firstOrCreate(
            ['email' => 'wawancara@admin.com'],
            [
                'name' => 'Petugas Wawancara',
                'password' => bcrypt('wawancara'),
                'role' => 'petugas_wawancara',
            ]
        );

        // Seed Pembayaran
        User::firstOrCreate(
            ['email' => 'pembayaran@admin.com'],
            [
                'name' => 'Petugas Pembayaran',
                'password' => bcrypt('pembayaran'),
                'role' => 'petugas_pembayaran',
            ]
        );

        // Helper to download image
        $downloadImage = function($url, $subdir, $filename) {
            $path = "{$subdir}/{$filename}";
            try {
                // Check if directory exists
                if (!Storage::disk('public')->exists($subdir)) {
                    Storage::disk('public')->makeDirectory($subdir);
                }
                
                // Fetch image content with timeout
                $ctx = stream_context_create([
                    'http' => [
                        'timeout' => 8,
                        'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)'
                    ]
                ]);
                
                $data = @file_get_contents($url, false, $ctx);
                if ($data) {
                    Storage::disk('public')->put($path, $data);
                    return $path;
                }
            } catch (\Exception $e) {
                // Fallback: ignore download error
            }
            return null;
        };

        // 2. Seed Berita
        $beritaData = [
            [
                'judul' => 'SMK Muhammadiyah 1 Bantul Raih Juara 1 Robotik Nasional',
                'slug' => 'smk-muhammadiyah-1-bantul-raih-juara-1-robotik-nasional',
                'konten' => '<p>Tim robotik SMK Muhammadiyah 1 Bantul berhasil menorehkan prestasi gemilang di tingkat nasional. Dalam ajang Kompetisi Robotik Indonesia 2026, tim sekolah menyabet Juara 1 pada kategori Robot Cerdas Penyelamat.</p><p>Kepala Sekolah menyampaikan rasa bangganya terhadap dedikasi para siswa dan pembimbing yang telah bekerja keras mempersiapkan kompetisi ini selama berbulan-bulan.</p>',
                'gambar_url' => 'https://picsum.photos/id/1072/800/600',
                'filename' => 'robotik-nasional.jpg',
                'tanggal' => '2026-06-12',
                'draft' => false,
            ],
            [
                'judul' => 'Kerja Sama Industri Baru dengan PT Astra International',
                'slug' => 'kerja-sama-industri-baru-dengan-pt-astra-international',
                'konten' => '<p>Dalam rangka memperluas program link and match, SMK Muhammadiyah 1 Bantul menandatangani nota kesepahaman (MoU) kemitraan dengan PT Astra International.</p><p>Kerja sama ini mencakup penyelarasan kurikulum kejuruan, program magang guru & siswa, sertifikasi industri, hingga prioritas penyaluran kerja bagi lulusan terbaik.</p>',
                'gambar_url' => 'https://picsum.photos/id/1031/800/600',
                'filename' => 'mou-astra.jpg',
                'tanggal' => '2026-06-10',
                'draft' => false,
            ],
            [
                'judul' => 'PPDB Online Tahun Ajaran Baru 2026/2027 Resmi Dibuka!',
                'slug' => 'ppdb-online-tahun-ajaran-baru-2026-2027-resmi-dibuka',
                'konten' => '<p>Penerimaan Peserta Didik Baru (PPDB) SMK Muhammadiyah 1 Bantul untuk Tahun Ajaran 2026/2027 resmi dibuka mulai hari ini. Pendaftaran dapat dilakukan secara online melalui portal resmi SPMB sekolah.</p><p>Tersedia lima kompetensi keahlian unggulan yang siap mencetak lulusan terampil dan berakhlak mulia.</p>',
                'gambar_url' => 'https://picsum.photos/id/1039/800/600',
                'filename' => 'ppdb-buka.jpg',
                'tanggal' => '2026-06-08',
                'draft' => false,
            ],
            [
                'judul' => 'Pelepasan 15 Siswa Lulusan Magang Kerja ke Jepang',
                'slug' => 'pelepasan-15-siswa-lulusan-magang-kerja-ke-jepang',
                'konten' => '<p>Sekolah kembali melepas siswa lulusan berprestasi untuk mengikuti program magang kerja ke Jepang di bidang manufaktur dan otomotif. Program ini merupakan hasil kerja sama dengan LPK terakreditasi.</p><p>Para siswa dibekali pelatihan bahasa dan kultur Jepang selama 6 bulan sebelum keberangkatan.</p>',
                'gambar_url' => 'https://picsum.photos/id/1035/800/600',
                'filename' => 'magang-jepang.jpg',
                'tanggal' => '2026-06-05',
                'draft' => false,
            ],
            [
                'judul' => 'Workshop Teknologi IoT dan Smart Manufacturing',
                'slug' => 'workshop-teknologi-iot-dan-smart-manufacturing',
                'konten' => '<p>Siswa jurusan Rekayasa Perangkat Lunak dan Teknik Elektronika mengikuti workshop khusus mengenai Internet of Things (IoT). Acara ini menghadirkan praktisi industri smart city.</p>',
                'gambar_url' => 'https://picsum.photos/id/1038/800/600',
                'filename' => 'workshop-iot.jpg',
                'tanggal' => '2026-06-02',
                'draft' => true,
            ]
        ];

        foreach ($beritaData as $item) {
            $gambarPath = $downloadImage($item['gambar_url'], 'berita', $item['filename']);
            Berita::firstOrCreate(
                ['slug' => $item['slug']],
                [
                    'judul' => $item['judul'],
                    'konten' => $item['konten'],
                    'gambar' => $gambarPath,
                    'tanggal' => $item['tanggal'],
                    'draft' => $item['draft'],
                ]
            );
        }

        // 3. Seed Prestasi
        $prestasiData = [
            [
                'judul' => 'Juara 1 Lomba Robotik Nasional 2025',
                'deskripsi' => 'Meraih medali emas kategori Robot Cerdas Penyelamat tingkat nasional.',
                'kategori' => 'Teknologi',
                'tingkat' => 'Nasional',
                'peraih' => 'Tim Robotik SMK Muh 1 Bantul',
                'gambar_url' => 'https://picsum.photos/id/1072/600/600',
                'filename' => 'prestasi-robotik.jpg',
                'tanggal' => '2025-10-15',
            ],
            [
                'judul' => 'Juara 2 Olimpiade Teknologi Web DIY',
                'deskripsi' => 'Juara 2 bidang Web Design dan Development dalam ajang LKS Tingkat Provinsi DIY.',
                'kategori' => 'IT',
                'tingkat' => 'Provinsi',
                'peraih' => 'Rian Hidayat (Kelas XII RPL)',
                'gambar_url' => 'https://picsum.photos/id/1032/600/600',
                'filename' => 'prestasi-web.jpg',
                'tanggal' => '2025-11-20',
            ],
            [
                'judul' => 'Medali Emas Kejuaraan Pencak Silat Tapak Suci',
                'deskripsi' => 'Meraih medali emas tanding kelas C Putra Kejuaraan Daerah Tapak Suci.',
                'kategori' => 'Olahraga',
                'tingkat' => 'Kabupaten',
                'peraih' => 'Ahmad Fauzi (Kelas XI TKR)',
                'gambar_url' => 'https://picsum.photos/id/1005/600/600',
                'filename' => 'prestasi-silat.jpg',
                'tanggal' => '2025-12-05',
            ],
            [
                'judul' => 'Juara Terbaik Kategori Mobil Listrik Hemat Energi',
                'deskripsi' => 'Inovasi mobil listrik hemat energi dalam ajang Kreativitas Siswa Vokasi.',
                'kategori' => 'Teknologi',
                'tingkat' => 'Nasional',
                'peraih' => 'Tim Otomotif TKR & TPM',
                'gambar_url' => 'https://picsum.photos/id/1033/600/600',
                'filename' => 'prestasi-mobil.jpg',
                'tanggal' => '2026-02-18',
            ]
        ];

        foreach ($prestasiData as $item) {
            $fotoPath = $downloadImage($item['gambar_url'], 'prestasi', $item['filename']);
            Prestasi::firstOrCreate(
                ['judul' => $item['judul']],
                [
                    'deskripsi' => $item['deskripsi'],
                    'kategori' => $item['kategori'],
                    'tingkat' => $item['tingkat'],
                    'peraih' => $item['peraih'],
                    'foto' => $fotoPath,
                    'tanggal' => $item['tanggal'],
                ]
            );
        }

        // 4. Seed Galeri Foto
        GaleriFoto::firstOrCreate(
            ['judul' => 'Album Foto Kegiatan'],
            [
                'folder_id' => '0B6IFRRkB6oTeSUVBc1E2U3JxQVk',
                'deskripsi' => 'Dokumentasi foto kegiatan dan prestasi SMK Muhammadiyah 1 Bantul',
            ]
        );

        // 5. Seed Galeri Video
        $videoData = [
            [
                'judul' => 'PROFIL SMK MUHAMMADIYAH 1 BANTUL',
                'deskripsi' => 'Simak perjalanan, fasilitas, kegiatan, dan prestasi kami dalam video profil resmi SMK Muhammadiyah 1 Bantul.',
                'youtube_id' => '9c0dJnFd8RY',
                'kategori' => 'Profil',
                'tanggal' => '2025-05-01',
                'views' => 1250,
                'durasi' => '05:24',
            ],
            [
                'judul' => 'Praktikum Otomotif & Servis Berkala Mobil',
                'deskripsi' => 'Dokumentasi praktikum kompetensi keahlian Teknik Kendaraan Ringan di bengkel sekolah.',
                'youtube_id' => '9c0dJnFd8RY',
                'kategori' => 'Praktik',
                'tanggal' => '2025-09-12',
                'views' => 320,
                'durasi' => '03:15',
            ]
        ];

        foreach ($videoData as $item) {
            GaleriVideo::firstOrCreate(
                ['judul' => $item['judul']],
                $item
            );
        }

        // 6. Seed Testimoni
        $testimoniData = [
            [
                'nama' => 'Dwi Prasetyo',
                'alumni_tahun' => '2020',
                'pekerjaan' => 'Teknisi Senior di Auto2000',
                'kutipan' => 'Ilmu dan keterampilan yang saya dapat di SMK Muhammadiyah 1 Bantul langsung saya terapkan di tempat kerja. Alhamdulillah, sekarang saya jadi teknisi senior di bengkel ternama.',
                'gambar_url' => 'https://picsum.photos/id/1005/150/150',
                'filename' => 'alumni-dwi.jpg',
            ],
            [
                'nama' => 'Siti Rahayu',
                'alumni_tahun' => '2021',
                'pekerjaan' => 'Web Developer di Startup Yogyakarta',
                'kutipan' => 'Jurusan RPL membuka jalan karier saya di dunia IT. Guru-gurunya sangat mendukung, dan fasilitas lab-nya lengkap. Sekarang saya kerja remote sebagai web developer!',
                'gambar_url' => 'https://picsum.photos/id/1011/150/150',
                'filename' => 'alumni-siti.jpg',
            ],
            [
                'nama' => 'Budi Santoso',
                'alumni_tahun' => '2022',
                'pekerjaan' => 'Operator CNC di PT Astra International',
                'kutipan' => 'PKL di industri mitra benar-benar membekali saya. Setelah lulus, langsung direkrut! Terima kasih SMK Muhammadiyah 1 Bantul.',
                'gambar_url' => 'https://picsum.photos/id/1020/150/150',
                'filename' => 'alumni-budi.jpg',
            ],
            [
                'nama' => 'Anisa Fitriani',
                'alumni_tahun' => '2019',
                'pekerjaan' => 'Teknisi Audio di Studio Rekaman',
                'kutipan' => 'Nilai Islami yang ditanamkan di sekolah membuat saya tetap istiqomah meski kerja di lingkungan yang menantang. Sangat bersyukur pernah sekolah di sini.',
                'gambar_url' => 'https://picsum.photos/id/1030/150/150',
                'filename' => 'alumni-anisa.jpg',
            ]
        ];

        foreach ($testimoniData as $item) {
            $fotoPath = $downloadImage($item['gambar_url'], 'testimoni', $item['filename']);
            Testimoni::firstOrCreate(
                ['nama' => $item['nama']],
                [
                    'alumni_tahun' => $item['alumni_tahun'],
                    'pekerjaan' => $item['pekerjaan'],
                    'kutipan' => $item['kutipan'],
                    'foto' => $fotoPath,
                ]
            );
        }

        // 7. Seed Pendaftaran
        $dummyPendaftar = [
            [
                'no_daftar' => 'MSB26-00-001',
                'tahun_aktif' => '2026',
                'nama_lengkap' => 'AARON ADITYA PRABASWARA',
                'tempat_lahir' => 'Bantul',
                'tanggal_lahir' => '2010-05-15',
                'jenis_kelamin' => 'L',
                'agama' => 'islam',
                'no_hp_siswa' => '085602567350',
                'asal_sekolah' => 'MTS N 4 BANTUL',
                'alamat_sekolah' => 'Jl. Parangtritis Km 11, Bantul',
                'prestasi' => 'Juara 1 Lomba Adzan Kabupaten',
                'nama_ortu' => 'SINGGIH DARYONO',
                'pekerjaan_ortu' => 'Wiraswasta',
                'no_hp_ortu' => '08170016862',
                'jalan_asal' => 'Jl. Bantul',
                'dusun_asal' => 'Klodran',
                'rt_asal' => '03',
                'rw_asal' => '02',
                'desa_asal' => 'Bantul',
                'kecamatan_asal' => 'Bantul',
                'kabupaten_asal' => 'Bantul',
                'provinsi_asal' => 'DI Yogyakarta',
                'jalan_tinggal' => 'Jl. Bantul',
                'dusun_tinggal' => 'Klodran',
                'rt_tinggal' => '03',
                'rw_tinggal' => '02',
                'desa_tinggal' => 'Bantul',
                'kecamatan_tinggal' => 'Bantul',
                'kabupaten_tinggal' => 'Bantul',
                'provinsi_tinggal' => 'DI Yogyakarta',
                'pil1' => 'TBSM',
                'pil2' => 'TKR',
                'pil3' => 'TPM',
                'status' => 'pending',
            ],
            [
                'no_daftar' => 'MSB26-00-002',
                'tahun_aktif' => '2026',
                'nama_lengkap' => 'DZAKY NARENDRA ATHA',
                'tempat_lahir' => 'Bantul',
                'tanggal_lahir' => '2010-08-20',
                'jenis_kelamin' => 'L',
                'agama' => 'islam',
                'no_hp_siswa' => '087750856998',
                'asal_sekolah' => 'SMP N 3 BANTUL',
                'alamat_sekolah' => 'Bantul, Yogyakarta',
                'prestasi' => '-',
                'nama_ortu' => 'AGUS RIYANTO',
                'pekerjaan_ortu' => 'PNS',
                'no_hp_ortu' => '087864860887',
                'jalan_asal' => 'Jl. Samas',
                'dusun_asal' => 'Palbapang',
                'rt_asal' => '01',
                'rw_asal' => '04',
                'desa_asal' => 'Palbapang',
                'kecamatan_asal' => 'Bantul',
                'kabupaten_asal' => 'Bantul',
                'provinsi_asal' => 'DI Yogyakarta',
                'jalan_tinggal' => 'Jl. Samas',
                'dusun_tinggal' => 'Palbapang',
                'rt_tinggal' => '01',
                'rw_tinggal' => '04',
                'desa_tinggal' => 'Palbapang',
                'kecamatan_tinggal' => 'Bantul',
                'kabupaten_tinggal' => 'Bantul',
                'provinsi_tinggal' => 'DI Yogyakarta',
                'pil1' => 'TBSM',
                'pil2' => 'TBSM',
                'pil3' => 'TBSM',
                'status' => 'verifikasi',
            ]
        ];

        foreach ($dummyPendaftar as $pendaftar) {
            Pendaftaran::firstOrCreate(
                ['no_daftar' => $pendaftar['no_daftar']],
                $pendaftar
            );
        }

        // 8. Seed Hero Slides
        $heroData = [
            [
                'judul' => 'Belajar dengan Praktik Nyata',
                'deskripsi' => 'Siswa SMK Muhammadiyah 1 Bantul mengasah keterampilan di bengkel otomotif industri modern.',
                'gambar_url' => 'https://picsum.photos/id/1031/1920/1080',
                'filename' => 'slide-otomotif.jpg',
                'label_tombol' => 'Daftar Sekarang',
                'link_tombol' => '#informasi',
                'urutan' => 1,
                'aktif' => true,
            ],
            [
                'judul' => 'Siap Kerja di Era Digital',
                'deskripsi' => 'Program Keahlian Rekayasa Perangkat Lunak (RPL) mendidik software developer handal.',
                'gambar_url' => 'https://picsum.photos/id/1032/1920/1080',
                'filename' => 'slide-rpl.jpg',
                'label_tombol' => 'Lihat Jurusan',
                'link_tombol' => '/jurusan/tkr',
                'urutan' => 2,
                'aktif' => true,
            ],
            [
                'judul' => 'Prestasi yang Menginspirasi',
                'deskripsi' => 'Juara 1 Lomba Robotik Nasional 2025 diraih oleh siswa SMK Muhammadiyah 1 Bantul.',
                'gambar_url' => 'https://picsum.photos/id/1072/1920/1080',
                'filename' => 'slide-prestasi.jpg',
                'label_tombol' => 'Lihat Prestasi',
                'link_tombol' => '#profil',
                'urutan' => 3,
                'aktif' => true,
            ]
        ];

        foreach ($heroData as $item) {
            $gambarPath = $downloadImage($item['gambar_url'], 'hero', $item['filename']);
            Hero::firstOrCreate(
                ['judul' => $item['judul']],
                [
                    'deskripsi' => $item['deskripsi'],
                    'gambar' => $gambarPath,
                    'label_tombol' => $item['label_tombol'],
                    'link_tombol' => $item['link_tombol'],
                    'urutan' => $item['urutan'],
                    'aktif' => $item['aktif'],
                ]
            );
        }

        // 9. Seed JurusanContent TKR
        $tkrHeroPath = $downloadImage('https://picsum.photos/id/1031/1920/600', 'jurusan', 'tkr-hero.jpg');
        JurusanContent::getOrDefault('tkr', [
            'nama_jurusan' => 'Teknik Kendaraan Ringan',
            'hero_gambar' => $tkrHeroPath,
            'hero_judul' => 'Teknik Kendaraan Ringan (TKR)',
            'hero_subjudul' => 'Mencetak Teknisi Otomotif Profesional dan Siap Kerja',
            'deskripsi_1' => 'Program Keahlian Teknik Kendaraan Ringan (TKR) di SMK Muhammadiyah 1 Bantul dirancang untuk membekali siswa dengan kompetensi dalam perawatan, perbaikan, dan pemeliharaan kendaraan ringan seperti mobil dan minibus.',
            'deskripsi_2' => 'Kurikulum kami mengacu pada standar industri otomotif nasional dan internasional, dengan praktik langsung di bengkel sekolah yang dilengkapi peralatan modern.',
            'poin_unggulan' => [
                'Praktik langsung di bengkel sekolah',
                'Kerja sama dengan bengkel mitra industri',
                'Sertifikasi kompetensi (BNSP, Astra, dll.)',
                'Penempatan kerja lulusan 98%'
            ]
        ]);
    }
}
