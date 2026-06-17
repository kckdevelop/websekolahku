<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminMitraController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $mitras = Mitra::when($search, fn($q) => $q->where('nama', 'like', "%{$search}%"))
            ->orderBy('urutan', 'asc')
            ->paginate(25)
            ->withQueryString();
        return view('admin.mitra.index', compact('mitras', 'search'));
    }

    public function create()
    {
        $allMitras = Mitra::orderBy('urutan')->get();
        return view('admin.mitra.create', compact('allMitras'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048',
            'logo_url' => 'nullable|url',
            'link' => 'nullable|string|max:255',
            'urutan' => 'required|integer',
            'aktif' => 'nullable|boolean',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('mitra', 'public');
        }

        Mitra::create([
            'nama' => $request->nama,
            'logo' => $logoPath,
            'logo_url' => $request->logo_url,
            'link' => $request->link ?? '#',
            'urutan' => $request->urutan,
            'aktif' => $request->has('aktif'),
        ]);

        return redirect()->route('admin.mitra.index')->with('success', 'Logo mitra berhasil ditambahkan.');
    }

    public function edit(Mitra $mitra)
    {
        $allMitras = Mitra::orderBy('urutan')->get();
        return view('admin.mitra.edit', compact('mitra', 'allMitras'));
    }

    public function update(Request $request, Mitra $mitra)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048',
            'logo_url' => 'nullable|url',
            'link' => 'nullable|string|max:255',
            'urutan' => 'required|integer',
            'aktif' => 'nullable|boolean',
        ]);

        $data = [
            'nama' => $request->nama,
            'logo_url' => $request->logo_url,
            'link' => $request->link ?? '#',
            'urutan' => $request->urutan,
            'aktif' => $request->has('aktif'),
        ];

        if ($request->hasFile('logo')) {
            if ($mitra->logo) {
                Storage::disk('public')->delete($mitra->logo);
            }
            $data['logo'] = $request->file('logo')->store('mitra', 'public');
        }

        $mitra->update($data);

        return redirect()->route('admin.mitra.index')->with('success', 'Logo mitra berhasil diperbarui.');
    }

    public function destroy(Mitra $mitra)
    {
        if ($mitra->logo) {
            Storage::disk('public')->delete($mitra->logo);
        }
        $mitra->delete();

        return redirect()->route('admin.mitra.index')->with('success', 'Logo mitra berhasil dihapus.');
    }
}
