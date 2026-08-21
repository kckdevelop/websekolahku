<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DojoSetting extends Model
{
    protected $table = 'dojo_settings';

    protected $fillable = [
        'hero_title',
        'hero_subtitle',
        'hero_gambar',
        'deskripsi_utama',
        'fungsi_1_judul',
        'fungsi_1_deskripsi',
        'fungsi_2_judul',
        'fungsi_2_deskripsi',
        'fungsi_3_judul',
        'fungsi_3_deskripsi',
        'safety_deskripsi',
        'welding_deskripsi',
        'assembling_deskripsi',
        'behavior_deskripsi',
        'kerjasama_info',
    ];

    public function getHeroGambarSrcAttribute(): string
    {
        if ($this->hero_gambar) {
            return asset('storage/' . $this->hero_gambar);
        }
        return 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=1600&q=80';
    }

    public static function getSingle(): self
    {
        $setting = self::first();

        if (!$setting) {
            $setting = self::create([
                'hero_title' => 'Dojo SMK Standar Industri Dunia',
                'hero_subtitle' => 'Pusat Pelatihan Keterampilan Teknis, Kedisiplinan & Keselamatan Kerja Siap Kerja',
                'hero_gambar' => null,
                'deskripsi_utama' => 'Dojo SMK adalah fasilitas pelatihan khusus sekolah kejuruan yang dirancang persis dengan standar dunia industri. Berasal dari bahasa Jepang yang berarti tempat latihan, Dojo SMK dibangun atas kerja sama dengan perusahaan manufaktur dan otomotif terkemuka untuk melatih keterampilan teknis, pembentukan karakter profesional, kedisiplinan tinggi, serta keselamatan kerja (K3).',
                
                'fungsi_1_judul' => 'Pelatihan Standar Industri',
                'fungsi_1_deskripsi' => 'Membiasakan siswa dengan atmosfer, peralatan presisi, simulasi jalur produksi, dan aturan kerja yang sama persis seperti di lokasi industri sesungguhnya.',
                
                'fungsi_2_judul' => 'Peningkatan Kompetensi',
                'fungsi_2_deskripsi' => 'Mengasah keahlian teknis spesifik siswa secara intensif di luar jam teori kelas untuk mencapai tingkat presisi dan produktivitas standar pabrik.',
                
                'fungsi_3_judul' => 'Penanaman Budaya Kerja',
                'fungsi_3_deskripsi' => 'Membangun etos kerja profesional, sikap mental pantang menyerah, nilai 5S/5R, serta tingkat kedisiplinan dan kerapian yang tinggi.',

                'safety_deskripsi' => 'Fasilitas simulasi Keselamatan dan Kesehatan Kerja (K3), penggunaan Alat Pelindung Diri (APD) standar pabrik, serta simulasi respon tanggap darurat dan pertolongan pertama.',
                'welding_deskripsi' => 'Pusat pelatihan teknik pengelasan presisi tinggi (SMAW, GMAW/MIG, TIG) sesuai standar pengujian internasional dan sertifikasi industri otomotif/manufaktur.',
                'assembling_deskripsi' => 'Tempat pelatihan proses perakitan komponen presisi, mekanik, sistem kontrol otomatis, dan penggunaan tools industri berbasis lin produksi.',
                'behavior_deskripsi' => 'Ruang pembentukan karakter, etika profesional, latihan kedisiplinan kerja, tata krama komunikasi industri, dan simulasi wawancara kerja.',

                'kerjasama_info' => 'Dojo SMK diselenggarakan melalui kolaborasi erat dengan kemitraan industri otomotif dan pabrik manufaktur nasional & internasional untuk memastikan kurikulum dan peralatan selalu up-to-date.',
            ]);
        }

        return $setting;
    }
}
