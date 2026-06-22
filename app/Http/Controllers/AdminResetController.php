<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminResetController extends Controller
{
    public function index()
    {
        return view('admin.reset.index');
    }

    public function reset(Request $request)
    {
        $request->validate([
            'konfirmasi' => 'required|string|in:RESET',
        ], [
            'konfirmasi.in' => 'Kata konfirmasi harus ditulis dengan benar (RESET).',
            'konfirmasi.required' => 'Kata konfirmasi wajib diisi.',
        ]);

        try {
            Schema::disableForeignKeyConstraints();
            
            try {
                // Hapus data riwayat pembayaran
                DB::table('riwayat_pembayarans')->truncate();
                
                // Hapus data pendaftaran
                DB::table('pendaftarans')->truncate();
                
                // Hapus data akun siswa
                DB::table('siswa_akuns')->truncate();
                
                // Hapus data gelombang
                DB::table('spmb_gelombangs')->truncate();
            } finally {
                Schema::enableForeignKeyConstraints();
            }

            // Hapus file berkas & foto pendaftar yang tersimpan di storage public
            if (Storage::disk('public')->exists('pendaftaran')) {
                Storage::disk('public')->deleteDirectory('pendaftaran');
            }

            return redirect()->route('admin.reset.index')
                ->with('success', 'Semua data pendaftaran SPMB (termasuk gelombang, akun siswa, berkas fisik, hasil tes, wawancara, & riwayat pembayaran) berhasil di-reset ke kondisi awal.');

        } catch (\Exception $e) {
            return redirect()->route('admin.reset.index')
                ->with('error', 'Gagal melakukan reset data: ' . $e->getMessage());
        }
    }
}
