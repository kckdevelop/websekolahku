<?php

namespace App\Http\Controllers;

use App\Models\GaleriVideo;
use Illuminate\Http\Request;

class AdminGaleriVideoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $galeriVideo = GaleriVideo::when($search, fn($q) => $q->where('judul', 'like', "%{$search}%"))
            ->orderBy('tanggal', 'desc')
            ->paginate(25)
            ->withQueryString();
        return view('admin.galeri_video.index', compact('galeriVideo', 'search'));
    }

    public function create()
    {
        $daftarVideo = GaleriVideo::orderBy('tanggal', 'desc')->limit(8)->get();
        return view('admin.galeri_video.create', compact('daftarVideo'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'url' => 'required|url',
            'kategori' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'durasi' => 'nullable|string|max:50',
        ]);

        $youtubeId = $this->getYoutubeId($request->url);

        GaleriVideo::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'youtube_id' => $youtubeId,
            'kategori' => $request->kategori,
            'tanggal' => $request->tanggal,
            'durasi' => $request->durasi,
            'views' => 0,
        ]);

        return redirect()->route('admin.galeri_video.index')->with('success', 'Video galeri berhasil ditambahkan.');
    }

    public function edit(GaleriVideo $galeriVideo)
    {
        $daftarVideo = GaleriVideo::orderBy('tanggal', 'desc')->limit(8)->get();
        return view('admin.galeri_video.edit', compact('galeriVideo', 'daftarVideo'));
    }

    public function update(Request $request, GaleriVideo $galeriVideo)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'url' => 'required|url',
            'kategori' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'durasi' => 'nullable|string|max:50',
        ]);

        $youtubeId = $this->getYoutubeId($request->url);

        $galeriVideo->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'youtube_id' => $youtubeId,
            'kategori' => $request->kategori,
            'tanggal' => $request->tanggal,
            'durasi' => $request->durasi,
        ]);

        return redirect()->route('admin.galeri_video.index')->with('success', 'Video galeri berhasil diperbarui.');
    }

    public function destroy(GaleriVideo $galeriVideo)
    {
        $galeriVideo->delete();
        return redirect()->route('admin.galeri_video.index')->with('success', 'Video galeri berhasil dihapus.');
    }

    private function getYoutubeId($url)
    {
        $regExp = '/^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/';
        preg_match($regExp, $url, $matches);
        return (isset($matches[2]) && strlen($matches[2]) == 11) ? $matches[2] : $url;
    }
}
