<?php

namespace App\Http\Controllers;

use App\Models\JurusanContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminJurusanController extends Controller
{
    /**
     * List all jurusan from DB.
     */
    public function index()
    {
        $jurusanContents = JurusanContent::orderBy('urutan')->get();
        return view('admin.jurusan.index', compact('jurusanContents'));
    }

    /**
     * Show form to create a new jurusan.
     */
    public function create()
    {
        $nextUrutan = JurusanContent::max('urutan') + 1;
        return view('admin.jurusan.create', compact('nextUrutan'));
    }

    /**
     * Store a newly created jurusan.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_jurusan'  => 'required|string|max:255',
            'slug'          => 'required|string|max:100|unique:jurusan_contents,slug|regex:/^[a-z0-9\-]+$/',
            'icon'          => 'nullable|string|max:100',
            'urutan'        => 'required|integer|min:0',
            'aktif'         => 'nullable|boolean',
            'hero_judul'    => 'required|string|max:255',
            'hero_subjudul' => 'nullable|string|max:255',
            'hero_gambar'   => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
            'deskripsi_1'   => 'required|string',
            'deskripsi_2'   => 'nullable|string',
            'poin_unggulan' => 'nullable|array',
            'poin_unggulan.*' => 'nullable|string|max:255',
            'foto_kegiatan' => 'nullable|array',
            'foto_kegiatan.*.deskripsi' => 'nullable|string|max:255',
            'foto_kegiatan.*.file'      => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
        ], [
            'slug.regex'  => 'Slug hanya boleh huruf kecil, angka, dan tanda hubung (-)',
            'slug.unique' => 'Slug sudah digunakan oleh jurusan lain.',
        ]);

        // Process foto kegiatan
        $fotoKegiatan = [];
        if ($request->has('foto_kegiatan')) {
            foreach ($request->input('foto_kegiatan') as $index => $item) {
                $path = null;
                if ($request->hasFile("foto_kegiatan.{$index}.file")) {
                    $path = $request->file("foto_kegiatan.{$index}.file")->store('jurusan/kegiatan', 'public');
                }
                if ($path || !empty($item['deskripsi'])) {
                    $fotoKegiatan[] = [
                        'gambar'    => $path,
                        'deskripsi' => $item['deskripsi'] ?? '',
                    ];
                }
            }
        }

        $data = [
            'nama_jurusan'  => $request->nama_jurusan,
            'slug'          => $request->slug,
            'icon'          => $request->icon ?? 'fas fa-graduation-cap',
            'urutan'        => $request->urutan,
            'aktif'         => $request->has('aktif'),
            'hero_judul'    => $request->hero_judul,
            'hero_subjudul' => $request->hero_subjudul,
            'deskripsi_1'   => $request->deskripsi_1,
            'deskripsi_2'   => $request->deskripsi_2,
            'poin_unggulan' => array_values(array_filter($request->input('poin_unggulan', []))),
            'foto_kegiatan' => $fotoKegiatan,
        ];

        if ($request->hasFile('hero_gambar')) {
            $data['hero_gambar'] = $request->file('hero_gambar')->store('jurusan', 'public');
        }

        JurusanContent::create($data);

        return redirect()->route('admin.jurusan.index')
            ->with('success', 'Jurusan ' . $request->nama_jurusan . ' berhasil ditambahkan.');
    }

    /**
     * Show the edit form for the specific jurusan.
     */
    public function edit(JurusanContent $jurusan)
    {
        return view('admin.jurusan.edit', compact('jurusan'));
    }

    /**
     * Update the jurusan page content.
     */
    public function update(Request $request, JurusanContent $jurusan)
    {
        $request->validate([
            'nama_jurusan'  => 'required|string|max:255',
            'icon'          => 'nullable|string|max:100',
            'urutan'        => 'required|integer|min:0',
            'hero_judul'    => 'required|string|max:255',
            'hero_subjudul' => 'nullable|string|max:255',
            'hero_gambar'   => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
            'deskripsi_1'   => 'required|string',
            'deskripsi_2'   => 'nullable|string',
            'poin_unggulan' => 'nullable|array',
            'poin_unggulan.*' => 'nullable|string|max:255',
            'foto_kegiatan' => 'nullable|array',
            'foto_kegiatan.*.deskripsi' => 'nullable|string|max:255',
            'foto_kegiatan.*.existing'  => 'nullable|string|max:255',
            'foto_kegiatan.*.file'      => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
        ]);

        // Process foto kegiatan array
        $fotoKegiatan = [];
        if ($request->has('foto_kegiatan')) {
            foreach ($request->input('foto_kegiatan') as $index => $item) {
                $path = $item['existing'] ?? null;

                if ($request->hasFile("foto_kegiatan.{$index}.file")) {
                    $file = $request->file("foto_kegiatan.{$index}.file");
                    $path = $file->store('jurusan/kegiatan', 'public');

                    if (!empty($item['existing']) && !str_starts_with($item['existing'], 'http')) {
                        Storage::disk('public')->delete($item['existing']);
                    }
                }

                if ($path || !empty($item['deskripsi'])) {
                    $fotoKegiatan[] = [
                        'gambar'    => $path,
                        'deskripsi' => $item['deskripsi'] ?? '',
                    ];
                }
            }
        }

        // Clean up deleted photos
        $oldPhotos = $jurusan->foto_kegiatan ?? [];
        $newPaths  = array_column($fotoKegiatan, 'gambar');
        foreach ($oldPhotos as $oldPhoto) {
            if (!empty($oldPhoto['gambar']) && !str_starts_with($oldPhoto['gambar'], 'http')) {
                if (!in_array($oldPhoto['gambar'], $newPaths)) {
                    Storage::disk('public')->delete($oldPhoto['gambar']);
                }
            }
        }

        $data = [
            'nama_jurusan'  => $request->nama_jurusan,
            'icon'          => $request->icon ?? 'fas fa-graduation-cap',
            'urutan'        => $request->urutan,
            'aktif'         => $request->has('aktif'),
            'hero_judul'    => $request->hero_judul,
            'hero_subjudul' => $request->hero_subjudul,
            'deskripsi_1'   => $request->deskripsi_1,
            'deskripsi_2'   => $request->deskripsi_2,
            'poin_unggulan' => array_values(array_filter($request->input('poin_unggulan', []))),
            'foto_kegiatan' => $fotoKegiatan,
        ];

        if ($request->hasFile('hero_gambar')) {
            if ($jurusan->hero_gambar) {
                Storage::disk('public')->delete($jurusan->hero_gambar);
            }
            $data['hero_gambar'] = $request->file('hero_gambar')->store('jurusan', 'public');
        }

        $jurusan->update($data);

        return redirect()->route('admin.jurusan.index')
            ->with('success', 'Halaman Program Keahlian ' . $jurusan->nama_jurusan . ' berhasil diperbarui.');
    }

    /**
     * Delete a jurusan and all its associated files.
     */
    public function destroy(JurusanContent $jurusan)
    {
        // Delete hero image
        if ($jurusan->hero_gambar) {
            Storage::disk('public')->delete($jurusan->hero_gambar);
        }

        // Delete all activity photos
        foreach ($jurusan->foto_kegiatan ?? [] as $foto) {
            if (!empty($foto['gambar']) && !str_starts_with($foto['gambar'], 'http')) {
                Storage::disk('public')->delete($foto['gambar']);
            }
        }

        $nama = $jurusan->nama_jurusan;
        $jurusan->delete();

        return redirect()->route('admin.jurusan.index')
            ->with('success', 'Jurusan ' . $nama . ' berhasil dihapus.');
    }
}
