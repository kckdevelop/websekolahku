<?php

namespace App\Http\Controllers;

use App\Models\Hero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminHeroController extends Controller
{
    public function index()
    {
        $heroes = Hero::orderBy('urutan', 'asc')->get();
        return view('admin.hero.index', compact('heroes'));
    }

    public function create()
    {
        return view('admin.hero.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|max:2048',
            'gambar_url' => 'nullable|url',
            'label_tombol' => 'nullable|string|max:100',
            'link_tombol' => 'nullable|string|max:255',
            'urutan' => 'required|integer',
            'aktif' => 'nullable|boolean',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('hero', 'public');
        }

        Hero::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambarPath,
            'gambar_url' => $request->gambar_url,
            'label_tombol' => $request->label_tombol ?? 'Selengkapnya',
            'link_tombol' => $request->link_tombol ?? '#',
            'urutan' => $request->urutan,
            'aktif' => $request->has('aktif'),
        ]);

        return redirect()->route('admin.hero.index')->with('success', 'Hero slide berhasil ditambahkan.');
    }

    public function edit(Hero $hero)
    {
        return view('admin.hero.edit', compact('hero'));
    }

    public function update(Request $request, Hero $hero)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|max:2048',
            'gambar_url' => 'nullable|url',
            'label_tombol' => 'nullable|string|max:100',
            'link_tombol' => 'nullable|string|max:255',
            'urutan' => 'required|integer',
            'aktif' => 'nullable|boolean',
        ]);

        $data = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'gambar_url' => $request->gambar_url,
            'label_tombol' => $request->label_tombol ?? 'Selengkapnya',
            'link_tombol' => $request->link_tombol ?? '#',
            'urutan' => $request->urutan,
            'aktif' => $request->has('aktif'),
        ];

        if ($request->hasFile('gambar')) {
            if ($hero->gambar) {
                Storage::disk('public')->delete($hero->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('hero', 'public');
        }

        $hero->update($data);

        return redirect()->route('admin.hero.index')->with('success', 'Hero slide berhasil diperbarui.');
    }

    public function destroy(Hero $hero)
    {
        if ($hero->gambar) {
            Storage::disk('public')->delete($hero->gambar);
        }
        $hero->delete();

        return redirect()->route('admin.hero.index')->with('success', 'Hero slide berhasil dihapus.');
    }
}
