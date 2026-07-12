<?php

namespace App\Http\Controllers;

use App\Models\TefaSetting;
use App\Models\TefaProduct;
use App\Models\JurusanContent;
use Illuminate\Http\Request;

class TefaController extends Controller
{
    public function index()
    {
        $setting  = TefaSetting::getSingle();

        // Ambil semua jurusan aktif
        $jurusans = JurusanContent::aktif()->get();

        // Produk aktif dengan relasi jurusan, diurutkan
        $products = TefaProduct::active()
            ->with('jurusanContent')
            ->orderBy('jurusan_content_id')
            ->orderBy('urutan')
            ->orderBy('id')
            ->get();

        // Group produk per jurusan (id => collection)
        $productsByJurusan = $products->groupBy('jurusan_content_id');

        // Jurusan yang benar-benar punya produk aktif
        $jurusansWithProducts = $jurusans->filter(
            fn($j) => isset($productsByJurusan[$j->id]) && $productsByJurusan[$j->id]->count() > 0
        );

        // Produk tanpa jurusan (umum)
        $productsTanpaJurusan = $productsByJurusan->get(null) ?? collect();

        return view('pages.tefa.index', compact(
            'setting',
            'products',
            'jurusans',
            'jurusansWithProducts',
            'productsByJurusan',
            'productsTanpaJurusan'
        ));
    }

    public function show(TefaProduct $product)
    {
        if (!$product->aktif) {
            abort(404);
        }

        $setting = TefaSetting::getSingle();

        // Produk terkait dari jurusan yang sama, kecuali produk ini
        $related = TefaProduct::active()
            ->with('jurusanContent')
            ->where('id', '!=', $product->id)
            ->when($product->jurusan_content_id,
                fn($q) => $q->where('jurusan_content_id', $product->jurusan_content_id),
                fn($q) => $q->whereNull('jurusan_content_id')
            )
            ->orderBy('urutan')
            ->limit(4)
            ->get();

        $product->load('jurusanContent');

        return view('pages.tefa.show', compact('product', 'setting', 'related'));
    }
}
