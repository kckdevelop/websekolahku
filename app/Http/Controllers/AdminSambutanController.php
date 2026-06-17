<?php

namespace App\Http\Controllers;

use App\Models\Sambutan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminSambutanController extends Controller
{
    public function edit()
    {
        $sambutan = Sambutan::getSingle();
        return view('admin.sambutan.edit', compact('sambutan'));
    }

    public function update(Request $request)
    {
        $sambutan = Sambutan::getSingle();

        $request->validate([
            'nama_kepala' => 'required|string|max:255',
            'gelar_kepala' => 'required|string|max:255',
            'foto_kepala' => 'nullable|image|max:2048',
            'isi_sambutan' => 'required|string',
        ]);

        $data = [
            'nama_kepala' => $request->nama_kepala,
            'gelar_kepala' => $request->gelar_kepala,
            'isi_sambutan' => $request->isi_sambutan,
        ];

        if ($request->hasFile('foto_kepala')) {
            if ($sambutan->foto_kepala) {
                Storage::disk('public')->delete($sambutan->foto_kepala);
            }
            $data['foto_kepala'] = $request->file('foto_kepala')->store('sambutan', 'public');
        }

        $sambutan->update($data);

        return redirect()->route('admin.sambutan.edit')->with('success', 'Sambutan Kepala Sekolah berhasil diperbarui.');
    }
}
