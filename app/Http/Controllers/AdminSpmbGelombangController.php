<?php

namespace App\Http\Controllers;

use App\Models\SpmbGelombang;
use Illuminate\Http\Request;

class AdminSpmbGelombangController extends Controller
{
    /**
     * Tampilkan daftar gelombang pendaftaran.
     */
    public function index()
    {
        $gelombangs = SpmbGelombang::orderBy('tanggal_mulai', 'asc')->get();
        return view('admin.gelombang.index', compact('gelombangs'));
    }

    /**
     * Simpan gelombang baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_gelombang'     => 'required|string|max:100',
            'kode_gelombang'     => 'required|integer|min:1|max:99',
            'tahun_ajaran'       => 'required|string|max:20',
            'tanggal_mulai'      => 'nullable|date',
            'tanggal_selesai'    => 'nullable|date|after_or_equal:tanggal_mulai',
            'keterangan'         => 'nullable|string|max:255',
            'biaya_pendaftaran'  => 'nullable|numeric|min:0',
            'biaya_zakat_default'=> 'nullable|numeric|min:0',
            'potongan_subsidi'   => 'nullable|numeric|min:0',
        ], [
            'nama_gelombang.required'  => 'Nama gelombang wajib diisi.',
            'kode_gelombang.required'  => 'Kode gelombang wajib diisi.',
            'kode_gelombang.integer'   => 'Kode gelombang harus berupa angka.',
            'kode_gelombang.min'       => 'Kode gelombang minimal 1.',
            'tahun_ajaran.required'    => 'Tahun ajaran wajib diisi.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai.',
        ]);

        // Jika ini gelombang pertama, atau jika is_aktif dicentang
        $isFirst = SpmbGelombang::count() === 0;
        $shouldBeActive = $isFirst || $request->has('is_aktif');

        $gelombang = SpmbGelombang::create([
            'nama_gelombang'      => $request->nama_gelombang,
            'kode_gelombang'      => $request->kode_gelombang,
            'tahun_ajaran'        => $request->tahun_ajaran,
            'tanggal_mulai'       => $request->tanggal_mulai,
            'tanggal_selesai'     => $request->tanggal_selesai,
            'is_aktif'            => false,
            'keterangan'          => $request->keterangan,
            'biaya_pendaftaran'   => $request->biaya_pendaftaran ?? 0,
            'biaya_zakat_default' => $request->biaya_zakat_default ?? 0,
            'potongan_subsidi'    => $request->potongan_subsidi ?? 0,
        ]);

        if ($shouldBeActive) {
            $gelombang->activate();
        }

        return redirect()->route('admin.gelombang.index')
            ->with('success', 'Gelombang pendaftaran berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit gelombang.
     */
    public function edit(SpmbGelombang $gelombang)
    {
        $gelombangs = SpmbGelombang::orderBy('tanggal_mulai', 'asc')->get();
        return view('admin.gelombang.index', compact('gelombangs', 'gelombang'));
    }

    /**
     * Update data gelombang.
     */
    public function update(Request $request, SpmbGelombang $gelombang)
    {
        $request->validate([
            'nama_gelombang'     => 'required|string|max:100',
            'kode_gelombang'     => 'required|integer|min:1|max:99',
            'tahun_ajaran'       => 'required|string|max:20',
            'tanggal_mulai'      => 'nullable|date',
            'tanggal_selesai'    => 'nullable|date|after_or_equal:tanggal_mulai',
            'keterangan'         => 'nullable|string|max:255',
            'biaya_pendaftaran'  => 'nullable|numeric|min:0',
            'biaya_zakat_default'=> 'nullable|numeric|min:0',
            'potongan_subsidi'   => 'nullable|numeric|min:0',
        ], [
            'nama_gelombang.required'  => 'Nama gelombang wajib diisi.',
            'kode_gelombang.required'  => 'Kode gelombang wajib diisi.',
            'kode_gelombang.integer'   => 'Kode gelombang harus berupa angka.',
            'kode_gelombang.min'       => 'Kode gelombang minimal 1.',
            'tahun_ajaran.required'    => 'Tahun ajaran wajib diisi.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai.',
        ]);

        $gelombang->update([
            'nama_gelombang'      => $request->nama_gelombang,
            'kode_gelombang'      => $request->kode_gelombang,
            'tahun_ajaran'        => $request->tahun_ajaran,
            'tanggal_mulai'       => $request->tanggal_mulai,
            'tanggal_selesai'     => $request->tanggal_selesai,
            'keterangan'          => $request->keterangan,
            'biaya_pendaftaran'   => $request->biaya_pendaftaran ?? 0,
            'biaya_zakat_default' => $request->biaya_zakat_default ?? 0,
            'potongan_subsidi'    => $request->potongan_subsidi ?? 0,
        ]);

        if ($request->has('is_aktif')) {
            $gelombang->activate();
        }

        return redirect()->route('admin.gelombang.index')
            ->with('success', 'Gelombang pendaftaran berhasil diperbarui!');
    }

    /**
     * Hapus gelombang pendaftaran.
     */
    public function destroy(SpmbGelombang $gelombang)
    {
        $wasActive = $gelombang->is_aktif;
        $gelombang->delete();

        // Jika yang dihapus aktif, aktifkan gelombang lain yang ada (jika ada)
        if ($wasActive) {
            $nextActive = SpmbGelombang::first();
            if ($nextActive) {
                $nextActive->activate();
            }
        }

        return redirect()->route('admin.gelombang.index')
            ->with('success', 'Gelombang pendaftaran berhasil dihapus.');
    }

    /**
     * Ubah gelombang aktif secara langsung.
     */
    public function toggleActive(SpmbGelombang $gelombang)
    {
        $gelombang->activate();

        return redirect()->route('admin.gelombang.index')
            ->with('success', 'Gelombang "' . $gelombang->nama_gelombang . '" sekarang menjadi gelombang aktif!');
    }
}
