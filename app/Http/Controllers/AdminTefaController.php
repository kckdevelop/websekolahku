<?php

namespace App\Http\Controllers;

use App\Models\TefaSetting;
use App\Models\TefaProduct;
use App\Models\JurusanContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminTefaController extends Controller
{
    // === PAGE SETTINGS ===

    public function editSetting()
    {
        $setting = TefaSetting::getSingle();
        return view('admin.tefa.setting', compact('setting'));
    }

    public function updateSetting(Request $request)
    {
        $setting = TefaSetting::getSingle();

        $request->validate([
            'hero_title' => 'required|string|max:255',
            'hero_subtitle' => 'required|string|max:255',
            'hero_gambar' => 'nullable|image|max:2048',
            'tentang_judul' => 'required|string|max:255',
            'tentang_deskripsi' => 'required|string',
            'telepon_wa' => 'nullable|string|max:50',
        ]);

        $data = [
            'hero_title' => $request->hero_title,
            'hero_subtitle' => $request->hero_subtitle,
            'tentang_judul' => $request->tentang_judul,
            'tentang_deskripsi' => $request->tentang_deskripsi,
            'telepon_wa' => $request->telepon_wa,
        ];

        if ($request->hasFile('hero_gambar')) {
            if ($setting->hero_gambar) {
                Storage::disk('public')->delete($setting->hero_gambar);
            }
            $data['hero_gambar'] = $request->file('hero_gambar')->store('tefa', 'public');
        }

        $setting->update($data);

        return redirect()->route('admin.tefa.setting')->with('success', 'Pengaturan halaman Tefa berhasil diperbarui.');
    }

    // === PRODUCT CRUD ===

    public function indexProducts(Request $request)
    {
        $search = $request->input('search');
        $jurusanId = $request->input('jurusan_id');
        $jurusans = JurusanContent::aktif()->get();

        $products = TefaProduct::with('jurusanContent')
            ->when($search, fn($q) => $q->where('nama', 'like', "%{$search}%"))
            ->when($jurusanId, fn($q) => $q->where('jurusan_content_id', $jurusanId))
            ->orderBy('id', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('admin.tefa.products.index', compact('products', 'search', 'jurusans', 'jurusanId'));
    }

    public function createProduct()
    {
        $jurusans = JurusanContent::aktif()->get();
        return view('admin.tefa.products.create', compact('jurusans'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'nama'               => 'required|string|max:255',
            'deskripsi'          => 'nullable|string',
            'harga'              => 'nullable|integer|min:0',
            'gambar'             => 'nullable|image|max:3072',
            'gambar_tambahan.*'  => 'nullable|image|max:3072',
            'aktif'              => 'nullable|boolean',
            'jurusan_content_id' => 'nullable|exists:jurusan_contents,id',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('tefa/products', 'public');
        }

        $gambarTambahan = [];
        if ($request->hasFile('gambar_tambahan')) {
            foreach ($request->file('gambar_tambahan') as $file) {
                $gambarTambahan[] = $file->store('tefa/products', 'public');
            }
        }

        TefaProduct::create([
            'nama'               => $request->nama,
            'deskripsi'          => $request->deskripsi,
            'harga'              => $request->harga,
            'gambar'             => $gambarPath,
            'gambar_tambahan'    => count($gambarTambahan) ? $gambarTambahan : null,
            'aktif'              => $request->has('aktif'),
            'jurusan_content_id' => $request->jurusan_content_id,
        ]);

        return redirect()->route('admin.tefa.products.index')->with('success', 'Produk Tefa berhasil ditambahkan.');
    }

    public function editProduct(TefaProduct $product)
    {
        $jurusans = JurusanContent::aktif()->get();
        return view('admin.tefa.products.edit', compact('product', 'jurusans'));
    }

    public function updateProduct(Request $request, TefaProduct $product)
    {
        $request->validate([
            'nama'               => 'required|string|max:255',
            'deskripsi'          => 'nullable|string',
            'harga'              => 'nullable|integer|min:0',
            'gambar'             => 'nullable|image|max:3072',
            'gambar_tambahan.*'  => 'nullable|image|max:3072',
            'hapus_gambar'       => 'nullable|array',
            'aktif'              => 'nullable|boolean',
            'jurusan_content_id' => 'nullable|exists:jurusan_contents,id',
        ]);

        $data = [
            'nama'               => $request->nama,
            'deskripsi'          => $request->deskripsi,
            'harga'              => $request->harga,
            'aktif'              => $request->has('aktif'),
            'jurusan_content_id' => $request->jurusan_content_id,
        ];

        // Update gambar utama
        if ($request->hasFile('gambar')) {
            if ($product->gambar) {
                Storage::disk('public')->delete($product->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('tefa/products', 'public');
        }

        // Kelola gambar tambahan
        $existing = $product->gambar_tambahan ?? [];

        // Hapus gambar yang dicentang untuk dihapus
        if ($request->has('hapus_gambar')) {
            foreach ($request->hapus_gambar as $path) {
                Storage::disk('public')->delete($path);
                $existing = array_values(array_filter($existing, fn($p) => $p !== $path));
            }
        }

        // Tambah gambar baru
        if ($request->hasFile('gambar_tambahan')) {
            foreach ($request->file('gambar_tambahan') as $file) {
                $existing[] = $file->store('tefa/products', 'public');
            }
        }

        $data['gambar_tambahan'] = count($existing) ? array_values($existing) : null;

        $product->update($data);

        return redirect()->route('admin.tefa.products.index')->with('success', 'Produk Tefa berhasil diperbarui.');
    }

    public function destroyProduct(TefaProduct $product)
    {
        if ($product->gambar) {
            Storage::disk('public')->delete($product->gambar);
        }
        if ($product->gambar_tambahan) {
            foreach ($product->gambar_tambahan as $path) {
                Storage::disk('public')->delete($path);
            }
        }
        $product->delete();

        return redirect()->route('admin.tefa.products.index')->with('success', 'Produk Tefa berhasil dihapus.');
    }
}
