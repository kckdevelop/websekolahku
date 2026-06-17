<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PetugasSeeder extends Seeder
{
    public function run(): void
    {
        // Akun Petugas Pendaftaran
        User::updateOrCreate(
            ['email' => 'petugas@smkmuh1bantul.sch.id'],
            [
                'name'     => 'Petugas Pendaftaran',
                'password' => Hash::make('petugas123'),
                'role'     => 'petugas',
            ]
        );

        // Pastikan admin utama tetap ada
        User::updateOrCreate(
            ['email' => 'admin@smkmuh1bantul.sch.id'],
            [
                'name'     => 'Administrator',
                'password' => Hash::make('admin123'),
                'role'     => 'admin',
            ]
        );

        $this->command->info('✅ Akun petugas dan admin berhasil di-seed!');
        $this->command->table(
            ['Role', 'Email', 'Password'],
            [
                ['Admin',   'admin@smkmuh1bantul.sch.id',   'admin123'],
                ['Petugas', 'petugas@smkmuh1bantul.sch.id', 'petugas123'],
            ]
        );
    }
}
