<?php

namespace Database\Seeders;

use App\Models\PetugasWawancara;
use Illuminate\Database\Seeder;

class PetugasWawancaraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = [
            "Abdullah Dian F",
            "Agung Widadi",
            "Akhmad Hanafi",
            "Alwan Effendi",
            "Ardik Sudarmaji, S.Pd",
            "Badimah",
            "Budi Sulistiyo",
            "Eko Sri Purwanto",
            "Encep Komarudin",
            "Eri Setyawan",
            "Fera Ardi Wibowo S.Pd",
            "Harimawan",
            "Heni Purwantari",
            "Ismawati",
            "JONI TRI SETYAWAN",
            "M. Khairil Anwar",
            "Muh Supanto",
            "Muhammad Ridwan",
            "Nanang Koya",
            "Nasmizartian",
            "Novi Hidayat",
            "R Nanang Wiratna",
            "Rr. Siti Fatimah",
            "RR. Swisty Pritandari",
            "Sagiman",
            "Sarjana",
            "Sarwono",
            "Sigit Purnawan",
            "Siti Rokhayati, S.Pd",
            "Slamet Raharjo",
            "Subiyanti",
            "Sudarsono",
            "Suratijo",
            "Tanindra Wijananto",
            "Taswanto",
            "Tono Prihatin",
            "Triwahyuni",
            "Tunggal Winata S.Kom",
            "Usfatun Khasanah",
            "Wiji Marwanta"
        ];

        foreach ($names as $name) {
            PetugasWawancara::firstOrCreate(
                ['nama' => $name],
                [
                    'aktif' => true,
                    'jabatan' => 'Pewawancara'
                ]
            );
        }
    }
}
