<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * @deprecated Gunakan AdminUserSeeder sebagai gantinya.
 * File ini dipertahankan untuk kompatibilitas mundur.
 */
class PetugasSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(AdminUserSeeder::class);
    }
}
