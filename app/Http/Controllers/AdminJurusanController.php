<?php

namespace App\Http\Controllers;

use App\Models\JurusanContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminJurusanController extends Controller
{
    /**
     * List all jurusan pages available for edit.
     */
    public function index()
    {
        // Define our target list of jurusans with their specific defaults
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
                    ['gambar' => 'https://picsum.photos/seed/tbsm-e/400/300', 'deskripsi' => 'Pelatihan bersama Honda and Yamaha mitra industri'],
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
                    'Praktik merakit sistem audio and video',
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

        // Retrieve or initialize the DB contents for each
        $jurusanContents = [];
        foreach ($listJurusan as $slug => $j) {
            $jurusanContents[] = JurusanContent::getOrDefault($slug, [
                'nama_jurusan' => $j['name'],
                'hero_judul' => $j['name'] . ' (' . $j['abbr'] . ')',
                'hero_subjudul' => $j['sub'],
                'deskripsi_1' => $j['desc1'],
                'deskripsi_2' => $j['desc2'],
                'poin_unggulan' => $j['points'],
                'foto_kegiatan' => $j['photos']
            ]);
        }

        return view('admin.jurusan.index', compact('jurusanContents'));
    }

    /**
     * Show the edit form for the specific jurusan.
     */
    public function edit(JurusanContent $jurusan)
    {
        return view('admin.jurusan.edit', compact('jurusan'));
    }

    /**
     * Update the jurusan page content.
     */
    public function update(Request $request, JurusanContent $jurusan)
    {
        $request->validate([
            'nama_jurusan' => 'required|string|max:255',
            'hero_judul' => 'required|string|max:255',
            'hero_subjudul' => 'nullable|string|max:255',
            'hero_gambar' => 'nullable|image|max:3072', // max 3MB
            'deskripsi_1' => 'required|string',
            'deskripsi_2' => 'nullable|string',
            'poin_unggulan' => 'nullable|array',
            'poin_unggulan.*' => 'nullable|string|max:255',
            'foto_kegiatan' => 'nullable|array',
            'foto_kegiatan.*.deskripsi' => 'nullable|string|max:255',
            'foto_kegiatan.*.existing' => 'nullable|string|max:255',
            'foto_kegiatan.*.file' => 'nullable|image|max:3072',
        ]);

        // Process foto kegiatan array
        $fotoKegiatan = [];
        if ($request->has('foto_kegiatan')) {
            foreach ($request->input('foto_kegiatan') as $index => $item) {
                $path = $item['existing'] ?? null;

                if ($request->hasFile("foto_kegiatan.{$index}.file")) {
                    $file = $request->file("foto_kegiatan.{$index}.file");
                    $path = $file->store('jurusan/kegiatan', 'public');
                    
                    // Delete old file if existed and is not a placeholder/external URL
                    if (!empty($item['existing']) && !str_starts_with($item['existing'], 'http')) {
                        Storage::disk('public')->delete($item['existing']);
                    }
                }

                if ($path || !empty($item['deskripsi'])) {
                    $fotoKegiatan[] = [
                        'gambar' => $path,
                        'deskripsi' => $item['deskripsi'] ?? '',
                    ];
                }
            }
        }

        // Clean up any files that were deleted entirely
        $oldPhotos = $jurusan->foto_kegiatan ?? [];
        $newPaths = array_column($fotoKegiatan, 'gambar');
        foreach ($oldPhotos as $oldPhoto) {
            if (!empty($oldPhoto['gambar']) && !str_starts_with($oldPhoto['gambar'], 'http')) {
                if (!in_array($oldPhoto['gambar'], $newPaths)) {
                    Storage::disk('public')->delete($oldPhoto['gambar']);
                }
            }
        }

        $data = [
            'nama_jurusan' => $request->nama_jurusan,
            'hero_judul' => $request->hero_judul,
            'hero_subjudul' => $request->hero_subjudul,
            'deskripsi_1' => $request->deskripsi_1,
            'deskripsi_2' => $request->deskripsi_2,
            // Filter out empty poin unggulan values
            'poin_unggulan' => array_values(array_filter($request->input('poin_unggulan', []))),
            'foto_kegiatan' => $fotoKegiatan,
        ];

        if ($request->hasFile('hero_gambar')) {
            if ($jurusan->hero_gambar) {
                Storage::disk('public')->delete($jurusan->hero_gambar);
            }
            $data['hero_gambar'] = $request->file('hero_gambar')->store('jurusan', 'public');
        }

        $jurusan->update($data);

        return redirect()->route('admin.jurusan.index')->with('success', 'Halaman Program Keahlian ' . $jurusan->nama_jurusan . ' berhasil diperbarui.');
    }
}
