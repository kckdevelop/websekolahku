<?php

namespace App\Http\Controllers;

use App\Models\Prestasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPrestasiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $prestasi = Prestasi::when($search, fn($q) => $q->where('judul', 'like', "%{$search}%")->orWhere('peraih', 'like', "%{$search}%"))
            ->orderBy('tanggal', 'desc')
            ->paginate(25)
            ->withQueryString();
        return view('admin.prestasi.index', compact('prestasi', 'search'));
    }

    public function create()
    {
        $daftarPrestasi = Prestasi::orderBy('tanggal', 'desc')->limit(8)->get();
        return view('admin.prestasi.create', compact('daftarPrestasi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kategori' => 'required|string|max:255',
            'tingkat' => 'required|string|max:255',
            'peraih' => 'required|string|max:255',
            'foto' => 'nullable|image|max:2048',
            'tanggal' => 'required|date',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('prestasi', 'public');
        }

        Prestasi::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'kategori' => $request->kategori,
            'tingkat' => $request->tingkat,
            'peraih' => $request->peraih,
            'foto' => $fotoPath,
            'tanggal' => $request->tanggal,
        ]);

        return redirect()->route('admin.prestasi.index')->with('success', 'Prestasi berhasil ditambahkan.');
    }

    public function edit(Prestasi $prestasi)
    {
        $daftarPrestasi = Prestasi::orderBy('tanggal', 'desc')->limit(8)->get();
        return view('admin.prestasi.edit', compact('prestasi', 'daftarPrestasi'));
    }

    public function update(Request $request, Prestasi $prestasi)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kategori' => 'required|string|max:255',
            'tingkat' => 'required|string|max:255',
            'peraih' => 'required|string|max:255',
            'foto' => 'nullable|image|max:2048',
            'tanggal' => 'required|date',
        ]);

        $data = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'kategori' => $request->kategori,
            'tingkat' => $request->tingkat,
            'peraih' => $request->peraih,
            'tanggal' => $request->tanggal,
        ];

        if ($request->hasFile('foto')) {
            if ($prestasi->foto) {
                Storage::disk('public')->delete($prestasi->foto);
            }
            $data['foto'] = $request->file('foto')->store('prestasi', 'public');
        }

        $prestasi->update($data);

        return redirect()->route('admin.prestasi.index')->with('success', 'Prestasi berhasil diperbarui.');
    }

    public function destroy(Prestasi $prestasi)
    {
        if ($prestasi->foto) {
            Storage::disk('public')->delete($prestasi->foto);
        }
        $prestasi->delete();

        return redirect()->route('admin.prestasi.index')->with('success', 'Prestasi berhasil dihapus.');
    }
}
