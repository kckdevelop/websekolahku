<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminBeritaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $berita = Berita::when($search, fn($q) => $q->where('judul', 'like', "%{$search}%"))
            ->orderBy('tanggal', 'desc')
            ->paginate(25)
            ->withQueryString();
        return view('admin.berita.index', compact('berita', 'search'));
    }

    public function create()
    {
        $daftarBerita = Berita::orderBy('tanggal', 'desc')->limit(8)->get();
        return view('admin.berita.create', compact('daftarBerita'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'tanggal' => 'required|date',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:10240',
            'draft' => 'nullable|boolean',
        ]);

        $slug = Str::slug($request->judul);
        
        // Ensure slug is unique
        $originalSlug = $slug;
        $count = 1;
        while (Berita::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('berita', 'public');
        }

        Berita::create([
            'judul' => $request->judul,
            'slug' => $slug,
            'konten' => $request->konten,
            'gambar' => $gambarPath,
            'tanggal' => $request->tanggal,
            'draft' => $request->has('draft'),
        ]);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(Berita $berita)
    {
        $daftarBerita = Berita::orderBy('tanggal', 'desc')->limit(8)->get();
        return view('admin.berita.edit', compact('berita', 'daftarBerita'));
    }

    public function update(Request $request, Berita $berita)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'tanggal' => 'required|date',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:10240',
            'draft' => 'nullable|boolean',
        ]);

        $data = [
            'judul' => $request->judul,
            'konten' => $request->konten,
            'tanggal' => $request->tanggal,
            'draft' => $request->has('draft'),
        ];

        // Only regenerate slug if title changes
        if ($request->judul !== $berita->judul) {
            $slug = Str::slug($request->judul);
            $originalSlug = $slug;
            $count = 1;
            while (Berita::where('slug', $slug)->where('id', '!=', $berita->id)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }
            $data['slug'] = $slug;
        }

        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($berita->gambar && !Str::startsWith($berita->gambar, ['http://', 'https://'])) {
                $cleanPath = ltrim(str_replace('public/', '', $berita->gambar), '/');
                if (Str::startsWith($cleanPath, 'storage/')) {
                    $cleanPath = substr($cleanPath, 8);
                }
                if (Storage::disk('public')->exists($cleanPath)) {
                    Storage::disk('public')->delete($cleanPath);
                }
            }
            $data['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        $berita->update($data);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Berita $berita)
    {
        if ($berita->gambar && !Str::startsWith($berita->gambar, ['http://', 'https://'])) {
            $cleanPath = ltrim(str_replace('public/', '', $berita->gambar), '/');
            if (Str::startsWith($cleanPath, 'storage/')) {
                $cleanPath = substr($cleanPath, 8);
            }
            if (Storage::disk('public')->exists($cleanPath)) {
                Storage::disk('public')->delete($cleanPath);
            }
        }
        $berita->delete();

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus.');
    }
}
