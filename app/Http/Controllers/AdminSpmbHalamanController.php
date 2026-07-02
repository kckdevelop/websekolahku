<?php

namespace App\Http\Controllers;

use App\Models\SpmbPageContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminSpmbHalamanController extends Controller
{
    public function edit()
    {
        $spmbContent = SpmbPageContent::getSingle();
        return view('admin.spmb_halaman.edit', compact('spmbContent'));
    }

    public function update(Request $request)
    {
        $spmbContent = SpmbPageContent::getSingle();

        $request->validate([
            'hero_title' => 'required|string|max:255',
            'hero_subtitle' => 'required|string|max:255',
            'hero_gambar' => 'nullable|image|max:3072',
            'kuota_tkro' => 'required|string|max:255',
            'kuota_tbsm' => 'required|string|max:255',
            'kuota_tpm' => 'required|string|max:255',
            'kuota_tav' => 'required|string|max:255',
            'kuota_rpl' => 'required|string|max:255',
            'alur_pendaftaran' => 'required|array|size:5',
            'alur_pendaftaran.*.judul' => 'required|string|max:255',
            'alur_pendaftaran.*.deskripsi' => 'required|string|max:500',
            'persyaratan' => 'required|array',
            'persyaratan.*' => 'required|string|max:255',
            'foto_galeri' => 'nullable|array',
            'foto_galeri.*.deskripsi' => 'nullable|string|max:255',
            'foto_galeri.*.existing' => 'nullable|string|max:255',
            'foto_galeri.*.file' => 'nullable|image|max:3072',
            'cta_title' => 'required|string|max:255',
            'cta_subtitle' => 'required|string|max:255',
        ]);

        $fotoGaleri = [];
        if ($request->has('foto_galeri')) {
            foreach ($request->input('foto_galeri') as $index => $item) {
                $path = $item['existing'] ?? null;

                if ($request->hasFile("foto_galeri.{$index}.file")) {
                    $file = $request->file("foto_galeri.{$index}.file");
                    $path = $file->store('spmb/galeri', 'public');
                    
                    if (!empty($item['existing']) && !str_starts_with($item['existing'], 'http')) {
                        Storage::disk('public')->delete($item['existing']);
                    }
                }

                if ($path || !empty($item['deskripsi'])) {
                    $fotoGaleri[] = [
                        'gambar' => $path,
                        'deskripsi' => $item['deskripsi'] ?? '',
                    ];
                }
            }
        }

        // Clean up deleted photo files
        $oldPhotos = $spmbContent->foto_galeri ?? [];
        $newPaths = array_column($fotoGaleri, 'gambar');
        foreach ($oldPhotos as $oldPhoto) {
            if (!empty($oldPhoto['gambar']) && !str_starts_with($oldPhoto['gambar'], 'http')) {
                if (!in_array($oldPhoto['gambar'], $newPaths)) {
                    Storage::disk('public')->delete($oldPhoto['gambar']);
                }
            }
        }

        $data = [
            'hero_title' => $request->hero_title,
            'hero_subtitle' => $request->hero_subtitle,
            'kuota_tkro' => $request->kuota_tkro,
            'kuota_tbsm' => $request->kuota_tbsm,
            'kuota_tpm' => $request->kuota_tpm,
            'kuota_tav' => $request->kuota_tav,
            'kuota_rpl' => $request->kuota_rpl,
            'alur_pendaftaran' => $request->alur_pendaftaran,
            'persyaratan' => array_values(array_filter($request->persyaratan)),
            'foto_galeri' => $fotoGaleri,
            'cta_title' => $request->cta_title,
            'cta_subtitle' => $request->cta_subtitle,
        ];

        if ($request->hasFile('hero_gambar')) {
            if ($spmbContent->hero_gambar) {
                Storage::disk('public')->delete($spmbContent->hero_gambar);
            }
            $data['hero_gambar'] = $request->file('hero_gambar')->store('spmb', 'public');
        }

        $spmbContent->update($data);

        return redirect()->route('admin.spmb-halaman.edit')->with('success', 'Konten halaman SPMB berhasil diperbarui.');
    }

    public function editStatus()
    {
        $spmbContent = SpmbPageContent::getSingle();
        return view('admin.spmb_halaman.status', compact('spmbContent'));
    }

    public function updateStatus(Request $request)
    {
        $spmbContent = SpmbPageContent::getSingle();

        $request->validate([
            'is_pendaftaran_open' => 'nullable|boolean',
        ]);

        $isOpen = $request->boolean('is_pendaftaran_open');

        $spmbContent->update([
            'is_pendaftaran_open' => $isOpen,
        ]);

        // Jika pendaftaran DITUTUP, nonaktifkan semua gelombang
        if (!$isOpen) {
            \App\Models\SpmbGelombang::query()->update(['is_aktif' => false]);
            return redirect()->route('admin.spmb-status.edit')
                ->with('success', 'Pendaftaran DITUTUP. Semua gelombang telah dinonaktifkan secara otomatis.');
        }

        return redirect()->route('admin.spmb-status.edit')
            ->with('success', 'Pendaftaran DIBUKA. Silakan aktifkan gelombang yang sesuai melalui menu Atur Gelombang.');
    }
}
