<?php

namespace App\Http\Controllers;

use App\Models\GaleriFoto;
use Illuminate\Http\Request;

class AdminGaleriFotoController extends Controller
{
    public function index()
    {
        $galeriFoto = GaleriFoto::firstOrCreate(
            [],
            [
                'folder_id' => '0B6IFRRkB6oTeSUVBc1E2U3JxQVk',
                'judul' => 'Album Foto Kegiatan',
                'deskripsi' => 'Dokumentasi foto kegiatan dan prestasi SMK Muhammadiyah 1 Bantul',
            ]
        );

        return view('admin.galeri_foto.index', compact('galeriFoto'));
    }

    public function update(Request $request, GaleriFoto $galeriFoto)
    {
        $request->validate([
            'folder_id' => 'required|string|max:255',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $folderId = $this->extractFolderId($request->folder_id);

        $galeriFoto->update([
            'folder_id' => $folderId,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.galeri_foto.index')->with('success', 'Pengaturan Galeri Foto berhasil diperbarui.');
    }

    private function extractFolderId($input)
    {
        if (preg_match('/folders\/([a-zA-Z0-9-_]+)/', $input, $matches)) {
            return $matches[1];
        }
        
        if (preg_match('/id=([a-zA-Z0-9-_]+)/', $input, $matches)) {
            return $matches[1];
        }

        return trim($input);
    }
}
