<?php

namespace Database\Seeders;

use App\Models\DojoSetting;
use App\Models\DojoPhoto;
use Illuminate\Database\Seeder;

class DojoSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Initial Dojo Setting
        DojoSetting::getSingle();

        // 2. Initial Sample Activity Photos
        if (DojoPhoto::count() === 0) {
            $photos = [
                [
                    'judul' => 'Simulasi Tanggap Darurat & Penggunaan APD Lengkap',
                    'unit_dojo' => 'Dojo Safety',
                    'deskripsi' => 'Siswa mempraktikkan prosedur Keselamatan dan Kesehatan Kerja (K3) industri serta penggunaan helm, kacamata safety, dan sepatu safety sesuai standar pabrik.',
                    'foto' => 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?auto=format&fit=crop&w=1000&q=80',
                    'urutan' => 1,
                    'aktif' => true,
                ],
                [
                    'judul' => 'Pelatihan Pengelasan Presisi Tinggi SMAW & MIG',
                    'unit_dojo' => 'Dojo Welding',
                    'deskripsi' => 'Pengujian hasil lasan menggunakan alat ukur presisi dan standar sertifikasi pengelasan industri manufaktur.',
                    'foto' => 'https://images.unsplash.com/photo-1504328345606-18bbc8c9d7d1?auto=format&fit=crop&w=1000&q=80',
                    'urutan' => 2,
                    'aktif' => true,
                ],
                [
                    'judul' => 'Simulasi Lin Perakitan Komponen Manufaktur (Assembly Line)',
                    'unit_dojo' => 'Dojo Assembling',
                    'deskripsi' => 'Peningkatan Kecepatan (Takt Time) dan Kualitas Perakitan komponen mekanik presisi sesuai prosedur kerja standar industri.',
                    'foto' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=1000&q=80',
                    'urutan' => 3,
                    'aktif' => true,
                ],
                [
                    'judul' => 'Pembentukan Karakter & Budaya Kerja 5S / 5R',
                    'unit_dojo' => 'Dojo Behavior',
                    'deskripsi' => 'Pembiasaan apel pagi, pemeriksaan kerapian (Seiri, Seiton, Seiso, Seiketsu, Shitsuke), serta penanaman etika komunikasi industri.',
                    'foto' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=1000&q=80',
                    'urutan' => 4,
                    'aktif' => true,
                ],
                [
                    'judul' => 'Pelatihan Alat Ukur Presisi & Caliper Digital',
                    'unit_dojo' => 'Dojo Assembling',
                    'deskripsi' => 'Pengukuran toleransi mikro meter pada komponen mesin otomotif.',
                    'foto' => 'https://images.unsplash.com/photo-1581092335397-9583fe92d232?auto=format&fit=crop&w=1000&q=80',
                    'urutan' => 5,
                    'aktif' => true,
                ],
                [
                    'judul' => 'Simulasi Penanganan Bahan Berbahaya & Apar',
                    'unit_dojo' => 'Dojo Safety',
                    'deskripsi' => 'Latihan pemadaman api menggunakan APAR dan evakuasi darurat di area kerja.',
                    'foto' => 'https://images.unsplash.com/photo-1621905251189-08b45d6a269e?auto=format&fit=crop&w=1000&q=80',
                    'urutan' => 6,
                    'aktif' => true,
                ],
            ];

            foreach ($photos as $p) {
                DojoPhoto::create($p);
            }
        }
    }
}
