<?php

namespace App\Http\Controllers;

use App\Models\DojoSetting;
use App\Models\DojoPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminDojoController extends Controller
{
    // === PAGE SETTINGS ===

    public function editSetting()
    {
        $setting = DojoSetting::getSingle();
        return view('admin.dojo.setting', compact('setting'));
    }

    public function updateSetting(Request $request)
    {
        $setting = DojoSetting::getSingle();

        $request->validate([
            'hero_title' => 'required|string|max:255',
            'hero_subtitle' => 'required|string|max:255',
            'hero_gambar' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
            'deskripsi_utama' => 'required|string',
            'fungsi_1_judul' => 'required|string|max:255',
            'fungsi_1_deskripsi' => 'nullable|string',
            'fungsi_2_judul' => 'required|string|max:255',
            'fungsi_2_deskripsi' => 'nullable|string',
            'fungsi_3_judul' => 'required|string|max:255',
            'fungsi_3_deskripsi' => 'nullable|string',
            'safety_deskripsi' => 'nullable|string',
            'welding_deskripsi' => 'nullable|string',
            'assembling_deskripsi' => 'nullable|string',
            'behavior_deskripsi' => 'nullable|string',
            'kerjasama_info' => 'nullable|string',
        ]);

        $data = $request->only([
            'hero_title',
            'hero_subtitle',
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
        ]);

        if ($request->hasFile('hero_gambar')) {
            if ($setting->hero_gambar && !str_starts_with($setting->hero_gambar, 'http') && Storage::disk('public')->exists($setting->hero_gambar)) {
                Storage::disk('public')->delete($setting->hero_gambar);
            }
            $data['hero_gambar'] = $request->file('hero_gambar')->store('dojo', 'public');
        }

        $setting->update($data);

        return redirect()->route('admin.dojo.setting')->with('success', 'Pengaturan Halaman Dojo SMK berhasil disimpan!');
    }

    // === DOJO PHOTOS CRUD ===

    public function indexPhotos(Request $request)
    {
        $search = $request->input('search');
        $unit = $request->input('unit');

        $unitList = [
            'Dojo Safety',
            'Dojo Welding',
            'Dojo Assembling',
            'Dojo Behavior',
            'Lainnya',
        ];

        $photos = DojoPhoto::when($search, fn($q) => $q->where('judul', 'like', "%{$search}%")->orWhere('deskripsi', 'like', "%{$search}%"))
            ->when($unit, fn($q) => $q->where('unit_dojo', $unit))
            ->orderBy('urutan', 'asc')
            ->orderBy('id', 'desc')
            ->paginate(12)
            ->withQueryString();

        return view('admin.dojo.photos.index', compact('photos', 'search', 'unit', 'unitList'));
    }

    public function createPhoto()
    {
        $unitList = [
            'Dojo Safety',
            'Dojo Welding',
            'Dojo Assembling',
            'Dojo Behavior',
            'Lainnya',
        ];
        return view('admin.dojo.photos.create', compact('unitList'));
    }

    public function storePhoto(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'unit_dojo' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'foto' => 'required|image|max:5120',
            'urutan' => 'nullable|integer',
            'aktif' => 'nullable|boolean',
        ]);

        $fotoPath = $request->file('foto')->store('dojo/photos', 'public');

        DojoPhoto::create([
            'judul' => $request->judul,
            'unit_dojo' => $request->unit_dojo,
            'deskripsi' => $request->deskripsi,
            'foto' => $fotoPath,
            'urutan' => $request->input('urutan', 0),
            'aktif' => $request->has('aktif'),
        ]);

        return redirect()->route('admin.dojo.photos.index')->with('success', 'Foto kegiatan Dojo berhasil ditambahkan.');
    }

    public function editPhoto(DojoPhoto $photo)
    {
        $unitList = [
            'Dojo Safety',
            'Dojo Welding',
            'Dojo Assembling',
            'Dojo Behavior',
            'Lainnya',
        ];
        return view('admin.dojo.photos.edit', compact('photo', 'unitList'));
    }

    public function updatePhoto(Request $request, DojoPhoto $photo)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'unit_dojo' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|max:5120',
            'urutan' => 'nullable|integer',
            'aktif' => 'nullable|boolean',
        ]);

        $data = [
            'judul' => $request->judul,
            'unit_dojo' => $request->unit_dojo,
            'deskripsi' => $request->deskripsi,
            'urutan' => $request->input('urutan', 0),
            'aktif' => $request->has('aktif'),
        ];

        if ($request->hasFile('foto')) {
            if ($photo->foto && !str_starts_with($photo->foto, 'http') && Storage::disk('public')->exists($photo->foto)) {
                Storage::disk('public')->delete($photo->foto);
            }
            $data['foto'] = $request->file('foto')->store('dojo/photos', 'public');
        }

        $photo->update($data);

        return redirect()->route('admin.dojo.photos.index')->with('success', 'Foto kegiatan Dojo berhasil diperbarui.');
    }

    public function destroyPhoto(DojoPhoto $photo)
    {
        if ($photo->foto && !str_starts_with($photo->foto, 'http') && Storage::disk('public')->exists($photo->foto)) {
            Storage::disk('public')->delete($photo->foto);
        }
        $photo->delete();

        return redirect()->route('admin.dojo.photos.index')->with('success', 'Foto kegiatan Dojo berhasil dihapus.');
    }

    public function toggleAktifPhoto(DojoPhoto $photo)
    {
        $photo->update(['aktif' => !$photo->aktif]);
        return redirect()->back()->with('success', 'Status foto kegiatan berhasil diubah.');
    }
}
