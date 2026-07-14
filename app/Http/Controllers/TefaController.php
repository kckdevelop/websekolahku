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

        // Hitung total produk aktif & produk per jurusan untuk badge tab secara keseluruhan
        $activeProductsInfo = TefaProduct::active()->select('id', 'jurusan_content_id')->get();
        $totalActiveCount = $activeProductsInfo->count();
        $countsByJurusan = $activeProductsInfo->groupBy('jurusan_content_id')->map->count();

        // Jurusan yang benar-benar punya produk aktif secara keseluruhan
        $jurusansWithProducts = $jurusans->filter(
            fn($j) => isset($countsByJurusan[$j->id]) && $countsByJurusan[$j->id] > 0
        );

        // Produk tanpa jurusan (umum) secara keseluruhan
        $totalTanpaJurusan = $countsByJurusan->get(null) ?? 0;

        // Produk terpaginasi (hanya 20 produk per halaman)
        $products = TefaProduct::active()
            ->with('jurusanContent')
            ->orderBy('jurusan_content_id')
            ->orderBy('urutan')
            ->orderBy('id')
            ->paginate(20);

        // Group produk halaman ini per jurusan (id => collection)
        $productsByJurusan = $products->groupBy('jurusan_content_id');

        // Produk tanpa jurusan (umum) di halaman ini
        $productsTanpaJurusan = $productsByJurusan->get(null) ?? collect();

        return view('pages.tefa.index', compact(
            'setting',
            'products',
            'jurusans',
            'jurusansWithProducts',
            'productsByJurusan',
            'productsTanpaJurusan',
            'totalActiveCount',
            'countsByJurusan',
            'totalTanpaJurusan'
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
