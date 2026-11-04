<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Seed akun admin dan seluruh petugas.
 *
 * ⚠️  PENTING: Ganti password default sebelum deploy ke production!
 *     Gunakan: php artisan tinker
 *     >> User::where('email','admin@smkmuh1bantul.sch.id')->first()->update(['password'=>Hash::make('password_baru')]);
 */
class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name'     => 'Administrator',
                'email'    => 'admin@smkmuh1bantul.sch.id',
                'password' => Hash::make('admin123'),
                'role'     => 'admin',
            ],
            [
                'name'     => 'Super Administrator',
                'email'    => 'superadmin@admin.com',
                'password' => Hash::make('superadmin123'),
                'role'     => 'super_admin',
            ],
            [
                'name'     => 'Administrator Admin.com',
                'email'    => 'admin@admin.com',
                'password' => Hash::make('admin123'),
                'role'     => 'admin',
            ],
            [
                'name'     => 'Admin Pendaftaran',
                'email'    => 'pendaftaran@admin.com',
                'password' => Hash::make('pendaftar123'),
                'role'     => 'admin_pendaftaran',
            ],
            [
                'name'     => 'Petugas Pendaftaran',
                'email'    => 'petugas@smkmuh1bantul.sch.id',
                'password' => Hash::make('petugas123'),
                'role'     => 'petugas',
            ],
            [
                'name'     => 'Petugas UKS & Kesehatan',
                'email'    => 'kesehatan@smkmuh1bantul.sch.id',
                'password' => Hash::make('kesehatan123'),
                'role'     => 'petugas_kesehatan',
            ],
            [
                'name'     => 'Petugas Wawancara',
                'email'    => 'wawancara@smkmuh1bantul.sch.id',
                'password' => Hash::make('wawancara123'),
                'role'     => 'petugas_wawancara',
            ],
            [
                'name'     => 'Petugas Pembayaran',
                'email'    => 'pembayaran@smkmuh1bantul.sch.id',
                'password' => Hash::make('pembayaran123'),
                'role'     => 'petugas_pembayaran',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                $user
            );
        }

        $this->command->info('✅ Akun admin & petugas berhasil dibuat.');
        $this->command->table(
            ['Role', 'Email', 'Password Default'],
            [
                ['Super Admin',          'superadmin@admin.com',            'superadmin123'],
                ['Admin',                'admin@smkmuh1bantul.sch.id',      'admin123'],
                ['Admin Pendaftaran',    'pendaftaran@admin.com',           'pendaftar123'],
                ['Petugas Pendaftaran',  'petugas@smkmuh1bantul.sch.id',    'petugas123'],
                ['Petugas Kesehatan',    'kesehatan@smkmuh1bantul.sch.id',  'kesehatan123'],
                ['Petugas Wawancara',    'wawancara@smkmuh1bantul.sch.id',  'wawancara123'],
                ['Petugas Pembayaran',   'pembayaran@smkmuh1bantul.sch.id', 'pembayaran123'],
            ]
        );
        $this->command->warn('⚠️  Segera ganti semua password default setelah login pertama!');
    }
}
