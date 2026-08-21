<?php

namespace App\Http\Controllers;

use App\Models\DojoSetting;
use App\Models\DojoPhoto;
use Illuminate\Http\Request;

class DojoController extends Controller
{
    public function index(Request $request)
    {
        $selectedUnit = $request->query('unit', 'Semua');
        $dojoSetting = DojoSetting::getSingle();

        $query = DojoPhoto::aktif()->orderBy('urutan', 'asc')->orderBy('id', 'desc');

        if ($selectedUnit && $selectedUnit !== 'Semua') {
            $query->where('unit_dojo', $selectedUnit);
        }

        $photos = $query->get();

        $unitList = [
            'Semua',
            'Dojo Safety',
            'Dojo Welding',
            'Dojo Assembling',
            'Dojo Behavior',
        ];

        return view('pages.dojo.index', compact('dojoSetting', 'photos', 'unitList', 'selectedUnit'));
    }
}
