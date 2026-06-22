<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Http\Resources\BeritaResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BeritaController extends Controller
{
    /**
     * Display a listing of the news (berita).
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $query = Berita::where('draft', false)
            ->orderBy('tanggal', 'desc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('konten', 'like', "%{$search}%");
            });
        }

        $berita = $query->paginate($request->query('limit', 10));

        return BeritaResource::collection($berita);
    }

    /**
     * Display the specified news (berita).
     */
    public function show(string $id_or_slug): JsonResponse|BeritaResource
    {
        // Try searching by slug first, then by ID if it's numeric
        $berita = Berita::where('draft', false)
            ->where(function ($q) use ($id_or_slug) {
                $q->where('slug', $id_or_slug);
                if (is_numeric($id_or_slug)) {
                    $q->orWhere('id', $id_or_slug);
                }
            })
            ->first();

        if (!$berita) {
            return response()->json([
                'success' => false,
                'message' => 'Berita tidak ditemukan.'
            ], 404);
        }

        return new BeritaResource($berita);
    }
}
