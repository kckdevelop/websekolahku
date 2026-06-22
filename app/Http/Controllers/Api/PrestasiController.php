<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Prestasi;
use App\Http\Resources\PrestasiResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PrestasiController extends Controller
{
    /**
     * Display a listing of achievements (prestasi).
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $kategori = $request->query('kategori');
        $tingkat = $request->query('tingkat');

        $query = Prestasi::orderBy('tanggal', 'desc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhere('peraih', 'like', "%{$search}%");
            });
        }

        if ($kategori) {
            $query->where('kategori', $kategori);
        }

        if ($tingkat) {
            $query->where('tingkat', $tingkat);
        }

        $prestasi = $query->paginate($request->query('limit', 10));

        return PrestasiResource::collection($prestasi);
    }

    /**
     * Display the specified achievement (prestasi).
     */
    public function show(int $id): JsonResponse|PrestasiResource
    {
        $prestasi = Prestasi::find($id);

        if (!$prestasi) {
            return response()->json([
                'success' => false,
                'message' => 'Prestasi tidak ditemukan.'
            ], 404);
        }

        return new PrestasiResource($prestasi);
    }
}
