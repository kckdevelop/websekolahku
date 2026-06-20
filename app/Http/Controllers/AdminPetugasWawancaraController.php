<?php

namespace App\Http\Controllers;

use App\Models\PetugasWawancara;
use Illuminate\Http\Request;

class AdminPetugasWawancaraController extends Controller
{
    public function index()
    {
        $petugasList = PetugasWawancara::orderBy('nama')->get();
        return view('admin.petugas_wawancara.index', compact('petugasList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'    => 'required|string|max:150',
            'jabatan' => 'nullable|string|max:150',
            'nip'     => 'nullable|string|max:50',
            'aktif'   => 'nullable|boolean',
        ]);

        $validated['aktif'] = $request->has('aktif') ? true : false;

        PetugasWawancara::create($validated);

        return redirect()->route('admin.petugas-wawancara.index')
            ->with('success', 'Petugas pewawancara berhasil ditambahkan.');
    }

    public function update(Request $request, PetugasWawancara $petugasWawancara)
    {
        $validated = $request->validate([
            'nama'    => 'required|string|max:150',
            'jabatan' => 'nullable|string|max:150',
            'nip'     => 'nullable|string|max:50',
            'aktif'   => 'nullable|boolean',
        ]);

        $validated['aktif'] = $request->has('aktif') ? true : false;

        $petugasWawancara->update($validated);

        return redirect()->route('admin.petugas-wawancara.index')
            ->with('success', 'Data pewawancara berhasil diperbarui.');
    }

    public function destroy(PetugasWawancara $petugasWawancara)
    {
        $petugasWawancara->delete();

        return redirect()->route('admin.petugas-wawancara.index')
            ->with('success', 'Petugas pewawancara berhasil dihapus.');
    }
}
