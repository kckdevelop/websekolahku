<?php

namespace App\Http\Controllers;

use App\Models\Testimoni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminTestimoniController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $testimoni = Testimoni::when($search, fn($q) => $q->where('nama', 'like', "%{$search}%")->orWhere('pekerjaan', 'like', "%{$search}%"))
            ->orderBy('created_at', 'desc')
            ->paginate(25)
            ->withQueryString();
        return view('admin.testimoni.index', compact('testimoni', 'search'));
    }

    public function create()
    {
        $daftarTestimoni = Testimoni::orderBy('created_at', 'desc')->limit(8)->get();
        return view('admin.testimoni.create', compact('daftarTestimoni'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alumni_tahun' => 'required|string|max:4',
            'pekerjaan' => 'required|string|max:255',
            'kutipan' => 'required|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('testimoni', 'public');
        }

        Testimoni::create([
            'nama' => $request->nama,
            'alumni_tahun' => $request->alumni_tahun,
            'pekerjaan' => $request->pekerjaan,
            'kutipan' => $request->kutipan,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('admin.testimoni.index')->with('success', 'Testimoni berhasil ditambahkan.');
    }

    public function edit(Testimoni $testimoni)
    {
        $daftarTestimoni = Testimoni::orderBy('created_at', 'desc')->limit(8)->get();
        return view('admin.testimoni.edit', compact('testimoni', 'daftarTestimoni'));
    }

    public function update(Request $request, Testimoni $testimoni)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alumni_tahun' => 'required|string|max:4',
            'pekerjaan' => 'required|string|max:255',
            'kutipan' => 'required|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = [
            'nama' => $request->nama,
            'alumni_tahun' => $request->alumni_tahun,
            'pekerjaan' => $request->pekerjaan,
            'kutipan' => $request->kutipan,
        ];

        if ($request->hasFile('foto')) {
            if ($testimoni->foto) {
                Storage::disk('public')->delete($testimoni->foto);
            }
            $data['foto'] = $request->file('foto')->store('testimoni', 'public');
        }

        $testimoni->update($data);

        return redirect()->route('admin.testimoni.index')->with('success', 'Testimoni berhasil diperbarui.');
    }

    public function destroy(Testimoni $testimoni)
    {
        if ($testimoni->foto) {
            Storage::disk('public')->delete($testimoni->foto);
        }
        $testimoni->delete();

        return redirect()->route('admin.testimoni.index')->with('success', 'Testimoni berhasil dihapus.');
    }
}
