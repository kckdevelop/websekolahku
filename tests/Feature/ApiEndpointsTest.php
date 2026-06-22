<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Berita;
use App\Models\Prestasi;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiEndpointsTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_berita(): void
    {
        // Create active news
        Berita::create([
            'judul' => 'Berita Aktif',
            'slug' => 'berita-aktif',
            'konten' => 'Konten berita aktif',
            'draft' => false,
            'tanggal' => now(),
        ]);

        // Create draft news
        Berita::create([
            'judul' => 'Berita Draft',
            'slug' => 'berita-draft',
            'konten' => 'Konten berita draft',
            'draft' => true,
            'tanggal' => now(),
        ]);

        $response = $this->getJson('/api/berita');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.judul', 'Berita Aktif');
    }

    public function test_can_show_single_berita_by_slug_and_id(): void
    {
        $berita = Berita::create([
            'judul' => 'Berita Detail',
            'slug' => 'berita-detail',
            'konten' => 'Konten berita detail',
            'draft' => false,
            'tanggal' => now(),
        ]);

        // Show by slug
        $response = $this->getJson('/api/berita/berita-detail');
        $response->assertStatus(200)
            ->assertJsonPath('data.id', $berita->id);

        // Show by id
        $response = $this->getJson('/api/berita/' . $berita->id);
        $response->assertStatus(200)
            ->assertJsonPath('data.slug', 'berita-detail');
    }

    public function test_can_list_prestasi(): void
    {
        Prestasi::create([
            'judul' => 'Juara Silat',
            'deskripsi' => 'Deskripsi silat',
            'kategori' => 'Olahraga',
            'tingkat' => 'Nasional',
            'peraih' => 'Ahmad',
            'tanggal' => now(),
        ]);

        $response = $this->getJson('/api/prestasi');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.judul', 'Juara Silat');
    }

    public function test_can_show_single_prestasi(): void
    {
        $prestasi = Prestasi::create([
            'judul' => 'Juara Catur',
            'deskripsi' => 'Deskripsi catur',
            'kategori' => 'Olahraga',
            'tingkat' => 'Provinsi',
            'peraih' => 'Budi',
            'tanggal' => now(),
        ]);

        $response = $this->getJson('/api/prestasi/' . $prestasi->id);
        $response->assertStatus(200)
            ->assertJsonPath('data.judul', 'Juara Catur');
    }

    public function test_cannot_find_non_existent_resources(): void
    {
        $response = $this->getJson('/api/berita/9999');
        $response->assertStatus(404);

        $response = $this->getJson('/api/prestasi/9999');
        $response->assertStatus(404);
    }

    public function test_can_download_api_pdf(): void
    {
        $response = $this->get('/docs/api-pdf');
        $response->assertStatus(200)
            ->assertHeader('Content-Type', 'application/pdf');
    }
}
