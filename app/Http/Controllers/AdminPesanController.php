<?php

namespace App\Http\Controllers;

use App\Models\Pesan;
use Illuminate\Http\Request;

class AdminPesanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $pesans = Pesan::when($search, function($q) use ($search) {
            $q->where('nama', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('subjek', 'like', "%{$search}%")
              ->orWhere('pesan', 'like', "%{$search}%");
        })
        ->orderBy('created_at', 'desc')
        ->paginate(20)
        ->withQueryString();

        return view('admin.pesan.index', compact('pesans', 'search'));
    }

    public function show(Pesan $pesan)
    {
        return view('admin.pesan.show', compact('pesan'));
    }

    public function destroy(Pesan $pesan)
    {
        $pesan->delete();
        return redirect()->route('admin.pesan.index')->with('success', 'Pesan berhasil dihapus.');
    }
}
