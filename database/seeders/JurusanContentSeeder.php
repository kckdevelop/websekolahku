<?php

namespace Database\Seeders;

use App\Models\JurusanContent;
use Illuminate\Database\Seeder;

/**
 * Seed konten default untuk setiap jurusan/kompetensi keahlian.
 * Data ini dapat diubah melalui panel admin setelah login.
 */
class JurusanContentSeeder extends Seeder
{
    public function run(): void
    {
        $jurusans = [
            'tkr' => [
                'nama_jurusan'   => 'Teknik Kendaraan Ringan',
                'hero_judul'     => 'Teknik Kendaraan Ringan (TKR)',
                'hero_subjudul'  => 'Mencetak Teknisi Otomotif Profesional dan Siap Kerja',
                'deskripsi_1'    => 'Program Keahlian Teknik Kendaraan Ringan (TKR) di SMK Muhammadiyah 1 Bantul dirancang untuk membekali siswa dengan kompetensi dalam perawatan, perbaikan, dan pemeliharaan kendaraan ringan seperti mobil dan minibus.',
                'deskripsi_2'    => 'Kurikulum kami mengacu pada standar industri otomotif nasional dan internasional, dengan praktik langsung di bengkel sekolah yang dilengkapi peralatan modern.',
                'poin_unggulan'  => [
                    'Praktik langsung di bengkel sekolah',
                    'Kerja sama dengan bengkel mitra industri',
                    'Sertifikasi kompetensi (BNSP, Astra, dll.)',
                    'Penempatan kerja lulusan 98%',
                ],
            ],
            'tbsm' => [
                'nama_jurusan'   => 'Teknik dan Bisnis Sepeda Motor',
                'hero_judul'     => 'Teknik dan Bisnis Sepeda Motor (TBSM)',
                'hero_subjudul'  => 'Ahli Servis Sepeda Motor Bersertifikat Industri',
                'deskripsi_1'    => 'Jurusan TBSM mempelajari perawatan, perbaikan, dan pengembangan bisnis sepeda motor modern termasuk kendaraan listrik.',
                'deskripsi_2'    => 'Dilengkapi bengkel sepeda motor standar ATPM, siswa mendapatkan pengalaman praktis langsung dari teknisi berpengalaman.',
                'poin_unggulan'  => [
                    'Bengkel standar ATPM (Honda, Yamaha, dll.)',
                    'Pelatihan mekanik kendaraan listrik',
                    'Sertifikasi BNSP bidang otomotif roda dua',
                    'Program magang di dealer resmi',
                ],
            ],
            'tpm' => [
                'nama_jurusan'   => 'Teknik Pemesinan',
                'hero_judul'     => 'Teknik Pemesinan (TPM)',
                'hero_subjudul'  => 'Operator & Programmer Mesin CNC Profesional',
                'deskripsi_1'    => 'Jurusan TPM membekali siswa dengan keahlian mengoperasikan mesin perkakas konvensional dan CNC (Computer Numerical Control) untuk industri manufaktur.',
                'deskripsi_2'    => 'Fasilitas mesin CNC lengkap dan up-to-date mempersiapkan lulusan yang langsung siap bekerja di industri manufaktur skala nasional maupun internasional.',
                'poin_unggulan'  => [
                    'Fasilitas mesin CNC Turning & Milling',
                    'Pelatihan CAD/CAM manufacturing',
                    'Sertifikasi BNSP operator mesin',
                    'Rekrutmen langsung oleh mitra industri',
                ],
            ],
            'tav' => [
                'nama_jurusan'   => 'Teknik Audio Video',
                'hero_judul'     => 'Teknik Audio Video (TAV)',
                'hero_subjudul'  => 'Teknisi Elektronika & Multimedia Profesional',
                'deskripsi_1'    => 'Jurusan TAV mempelajari instalasi, perawatan, dan perbaikan perangkat audio-video serta sistem elektronika modern termasuk smart home dan IoT.',
                'deskripsi_2'    => 'Lulusan TAV memiliki peluang karir di bidang teknisi elektronik, industri hiburan, broadcast, hingga wirausaha perbaikan perangkat elektronik.',
                'poin_unggulan'  => [
                    'Lab elektronika & sistem audio-video modern',
                    'Pelatihan instalasi sistem smart home & IoT',
                    'Sertifikasi kompetensi elektronika BNSP',
                    'Kemitraan dengan perusahaan elektronik',
                ],
            ],
            'rpl' => [
                'nama_jurusan'   => 'Rekayasa Perangkat Lunak',
                'hero_judul'     => 'Rekayasa Perangkat Lunak (RPL)',
                'hero_subjudul'  => 'Mencetak Software Developer & IT Profesional Masa Depan',
                'deskripsi_1'    => 'Jurusan RPL membekali siswa dengan kemampuan pemrograman, pengembangan aplikasi web & mobile, database, dan jaringan komputer sesuai standar industri IT.',
                'deskripsi_2'    => 'Dengan kurikulum yang terus diperbarui mengikuti tren teknologi, lulusan RPL siap berkarir sebagai developer, sysadmin, atau membangun startup sendiri.',
                'poin_unggulan'  => [
                    'Lab komputer modern dengan akses internet',
                    'Pelatihan web, mobile, dan cloud computing',
                    'Sertifikasi BNSP & sertifikat industri (Oracle, dll.)',
                    'Magang di perusahaan IT dan startup',
                ],
            ],
        ];

        foreach ($jurusans as $kode => $data) {
            JurusanContent::firstOrCreate(
                ['kode_jurusan' => $kode],
                array_merge($data, ['hero_gambar' => null, 'foto_kegiatan' => null])
            );
        }

        $this->command->info('✅ Konten jurusan (5 jurusan) berhasil di-seed.');
        $this->command->warn('⚠️  Upload gambar hero & foto kegiatan melalui panel admin!');
    }
}
