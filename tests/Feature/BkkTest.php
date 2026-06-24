<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\BkkSetting;
use App\Models\LowonganKerja;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BkkTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_bkk_page_returns_successful_response(): void
    {
        $response = $this->get('/bkk');
        $response->assertStatus(200);
        $response->assertSee('Bursa Kerja Khusus');
    }

    public function test_unauthenticated_user_cannot_access_bkk_admin_settings(): void
    {
        $response = $this->get('/admin/bkk/setting');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_admin_can_access_bkk_admin_settings(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($user)->get('/admin/bkk/setting');
        $response->assertStatus(200);
        $response->assertSee('Pengaturan Halaman BKK');
    }

    public function test_admin_can_update_bkk_settings(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($user)->put('/admin/bkk/setting', [
            'hero_title' => 'Judul Baru BKK',
            'hero_subtitle' => 'Sub Judul Baru BKK',
            'tentang_judul' => 'Judul Tentang Baru',
            'tentang_deskripsi' => 'Deskripsi Tentang Baru',
            'statistik' => [
                ['label' => 'Stat 1', 'nilai' => '100', 'ikon' => 'fa-star'],
            ],
            'layanan' => [
                ['judul' => 'Layanan 1', 'deskripsi' => 'Desc 1', 'ikon' => 'fa-cogs'],
            ],
            'mitra_perusahaan' => [
                ['nama' => 'Mitra A'],
            ],
            'kontak_nama' => 'Budi Koordinator',
            'kontak_telepon' => '08123456789',
            'kontak_email' => 'budi@smk.sch.id',
            'kontak_jam_operasional' => '08:00 - 15:00',
            'kontak_lokasi' => 'Bantul',
            'cta_title' => 'CTA Baru',
            'cta_subtitle' => 'CTA Sub Baru',
        ]);

        $response->assertRedirect(route('admin.bkk.setting'));
        $this->assertDatabaseHas('bkk_settings', [
            'hero_title' => 'Judul Baru BKK',
            'kontak_nama' => 'Budi Koordinator',
        ]);
    }

    public function test_admin_can_perform_lowongan_crud(): void
    {
        \Illuminate\Support\Facades\Storage::fake('public');

        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $logoFile = \Illuminate\Http\UploadedFile::fake()->create('logo.jpg', 100, 'image/jpeg');
        $brosurFile = \Illuminate\Http\UploadedFile::fake()->create('flyer.jpg', 200, 'image/jpeg');

        // 1. Create
        $response = $this->actingAs($user)->post('/admin/bkk/lowongan', [
            'nama_perusahaan' => 'PT Test Indonesia',
            'logo_perusahaan' => $logoFile,
            'posisi' => 'Software Engineer',
            'lokasi' => 'Yogyakarta',
            'tipe_pekerjaan' => 'Full Time',
            'jurusan_relevan' => 'RPL',
            'batas_lamaran' => now()->addDays(7)->toDateString(),
            'deskripsi' => 'Deskripsi pekerjaan test',
            'brosur' => $brosurFile,
            'persyaratan' => ['Lulusan SMK', 'Menguasai PHP'],
            'kontak_lamaran' => 'hrd@test.com',
            'aktif' => 1,
            'urutan' => 1,
        ]);

        $response->assertRedirect(route('admin.bkk.lowongan.index'));
        $this->assertDatabaseHas('lowongan_kerjas', [
            'nama_perusahaan' => 'PT Test Indonesia',
            'posisi' => 'Software Engineer',
        ]);

        $lowongan = LowonganKerja::first();
        $this->assertNotNull($lowongan->logo_perusahaan);
        $this->assertNotNull($lowongan->brosur);

        \Illuminate\Support\Facades\Storage::disk('public')->assertExists($lowongan->logo_perusahaan);
        \Illuminate\Support\Facades\Storage::disk('public')->assertExists($lowongan->brosur);

        $oldBrosurPath = $lowongan->brosur;

        // 2. Edit Page
        $response = $this->actingAs($user)->get("/admin/bkk/lowongan/{$lowongan->id}/edit");
        $response->assertStatus(200);

        // 3. Update with new brochure
        $newBrosurFile = \Illuminate\Http\UploadedFile::fake()->create('new_flyer.jpg', 200, 'image/jpeg');

        $response = $this->actingAs($user)->put("/admin/bkk/lowongan/{$lowongan->id}", [
            'nama_perusahaan' => 'PT Test Indonesia Updated',
            'posisi' => 'Senior Developer',
            'lokasi' => 'Yogyakarta',
            'tipe_pekerjaan' => 'Full Time',
            'jurusan_relevan' => 'RPL',
            'batas_lamaran' => now()->addDays(7)->toDateString(),
            'deskripsi' => 'Deskripsi pekerjaan test',
            'brosur' => $newBrosurFile,
            'persyaratan' => ['Lulusan SMK', 'Menguasai PHP'],
            'kontak_lamaran' => 'hrd@test.com',
            'aktif' => 1,
            'urutan' => 2,
        ]);

        $response->assertRedirect(route('admin.bkk.lowongan.index'));
        $this->assertDatabaseHas('lowongan_kerjas', [
            'nama_perusahaan' => 'PT Test Indonesia Updated',
            'posisi' => 'Senior Developer',
        ]);

        $lowongan = $lowongan->fresh();
        \Illuminate\Support\Facades\Storage::disk('public')->assertMissing($oldBrosurPath);
        \Illuminate\Support\Facades\Storage::disk('public')->assertExists($lowongan->brosur);

        // 4. Toggle Active
        $response = $this->actingAs($user)->post("/admin/bkk/lowongan/{$lowongan->id}/toggle-aktif");
        $response->assertRedirect();
        $this->assertEquals(0, $lowongan->fresh()->aktif);

        // 5. Delete
        $response = $this->actingAs($user)->delete("/admin/bkk/lowongan/{$lowongan->id}");
        $response->assertRedirect(route('admin.bkk.lowongan.index'));
        
        $this->assertDatabaseMissing('lowongan_kerjas', [
            'id' => $lowongan->id,
        ]);

        \Illuminate\Support\Facades\Storage::disk('public')->assertMissing($lowongan->logo_perusahaan);
        \Illuminate\Support\Facades\Storage::disk('public')->assertMissing($lowongan->brosur);
    }
}
