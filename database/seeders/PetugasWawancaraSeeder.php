<?php

namespace Database\Seeders;

use App\Models\PetugasWawancara;
use Illuminate\Database\Seeder;

/**
 * Seed daftar nama petugas pewawancara SPMB.
 * Sesuaikan daftar nama dengan guru/staf yang bertugas mewawancara.
 */
class PetugasWawancaraSeeder extends Seeder
{
    public function run(): void
    {
        $names = [
            'Abdullah Dian F',
            'Agung Widadi',
            'Akhmad Hanafi',
            'Alwan Effendi',
            'Ardik Sudarmaji, S.Pd',
            'Badimah',
            'Budi Sulistiyo',
            'Eko Sri Purwanto',
            'Encep Komarudin',
            'Eri Setyawan',
            'Fera Ardi Wibowo S.Pd',
            'Harimawan',
            'Heni Purwantari',
            'Ismawati',
            'Joni Tri Setyawan',
            'M. Khairil Anwar',
            'Muh Supanto',
            'Muhammad Ridwan',
            'Nanang Koya',
            'Nasmizartian',
            'Novi Hidayat',
            'R Nanang Wiratna',
            'Rr. Siti Fatimah',
            'Rr. Swisty Pritandari',
            'Sagiman',
            'Sarjana',
            'Sarwono',
            'Sigit Purnawan',
            'Siti Rokhayati, S.Pd',
            'Slamet Raharjo',
            'Subiyanti',
            'Sudarsono',
            'Suratijo',
            'Tanindra Wijananto',
            'Taswanto',
            'Tono Prihatin',
            'Triwahyuni',
            'Tunggal Winata S.Kom',
            'Usfatun Khasanah',
            'Wiji Marwanta',
        ];

        foreach ($names as $name) {
            PetugasWawancara::firstOrCreate(
                ['nama' => $name],
                [
                    'aktif'   => true,
                    'jabatan' => 'Pewawancara',
                ]
            );
        }

        $this->command->info('✅ ' . count($names) . ' petugas wawancara berhasil di-seed.');
    }
}
