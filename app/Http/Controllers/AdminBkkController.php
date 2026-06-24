<?php

namespace App\Http\Controllers;

use App\Models\BkkSetting;
use App\Models\LowonganKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminBkkController extends Controller
{
    // ─── BKK Settings ────────────────────────────────────────────────────────

    public function editSetting()
    {
        $bkk = BkkSetting::getSingle();
        return view('admin.bkk.setting', compact('bkk'));
    }

    public function updateSetting(Request $request)
    {
        $bkk = BkkSetting::getSingle();

        $request->validate([
            'hero_title'             => 'required|string|max:255',
            'hero_subtitle'          => 'required|string|max:255',
            'hero_gambar'            => 'nullable|image|max:3072',
            'tentang_judul'          => 'required|string|max:255',
            'tentang_deskripsi'      => 'nullable|string',
            'statistik'              => 'nullable|array',
            'statistik.*.label'      => 'required|string|max:100',
            'statistik.*.nilai'      => 'required|string|max:50',
            'statistik.*.ikon'       => 'required|string|max:100',
            'layanan'                => 'nullable|array',
            'layanan.*.judul'        => 'required|string|max:255',
            'layanan.*.deskripsi'    => 'required|string',
            'layanan.*.ikon'         => 'required|string|max:100',
            'mitra_perusahaan'       => 'nullable|array',
            'mitra_perusahaan.*.nama'=> 'required|string|max:255',
            'kontak_nama'            => 'nullable|string|max:255',
            'kontak_telepon'         => 'nullable|string|max:50',
            'kontak_email'           => 'nullable|email|max:255',
            'kontak_jam_operasional' => 'nullable|string|max:255',
            'kontak_lokasi'          => 'nullable|string|max:500',
            'cta_title'              => 'required|string|max:255',
            'cta_subtitle'           => 'required|string|max:255',
        ]);

        $data = $request->except(['_token', '_method', 'hero_gambar', 'mitra_perusahaan']);

        // Handle hero image
        if ($request->hasFile('hero_gambar')) {
            if ($bkk->hero_gambar) {
                Storage::disk('public')->delete($bkk->hero_gambar);
            }
            $data['hero_gambar'] = $request->file('hero_gambar')->store('bkk', 'public');
        }

        // Handle mitra perusahaan logos
        $mitraInput  = $request->input('mitra_perusahaan', []);
        $mitraFiles  = $request->file('mitra_perusahaan', []);
        $oldMitra    = $bkk->mitra_perusahaan ?? [];
        $savedMitra  = [];

        foreach ($mitraInput as $i => $item) {
            if (empty($item['nama'])) continue;

            $oldLogo = $oldMitra[$i]['logo'] ?? null;
            $logo    = $item['existing'] ?? $oldLogo;

            if (isset($mitraFiles[$i]['logo']) && $mitraFiles[$i]['logo']->isValid()) {
                // Delete old logo
                if ($logo && !str_starts_with($logo, 'http')) {
                    Storage::disk('public')->delete($logo);
                }
                $logo = $mitraFiles[$i]['logo']->store('bkk/mitra', 'public');
            }

            $savedMitra[] = [
                'nama' => $item['nama'],
                'logo' => $logo,
            ];
        }

        // Delete logos for removed mitra
        $savedLogos = array_column($savedMitra, 'logo');
        foreach ($oldMitra as $old) {
            if (!empty($old['logo']) && !str_starts_with($old['logo'], 'http')) {
                if (!in_array($old['logo'], $savedLogos)) {
                    Storage::disk('public')->delete($old['logo']);
                }
            }
        }

        $data['mitra_perusahaan'] = $savedMitra;

        $bkk->update($data);

        return redirect()->route('admin.bkk.setting')->with('success', 'Pengaturan BKK berhasil diperbarui.');
    }

    // ─── Lowongan Kerja CRUD ─────────────────────────────────────────────────

    public function indexLowongan()
    {
        $lowongans = LowonganKerja::orderBy('urutan')->orderByDesc('created_at')->get();
        return view('admin.bkk.lowongan.index', compact('lowongans'));
    }

    public function createLowongan()
    {
        return view('admin.bkk.lowongan.create');
    }

    public function storeLowongan(Request $request)
    {
        $data = $request->validate([
            'nama_perusahaan'  => 'required|string|max:255',
            'logo_perusahaan'  => 'nullable|file|mimes:jpg,jpeg,png,gif|max:2048',
            'posisi'           => 'required|string|max:255',
            'lokasi'           => 'required|string|max:255',
            'tipe_pekerjaan'   => 'required|string|max:100',
            'jurusan_relevan'  => 'nullable|string|max:255',
            'batas_lamaran'    => 'required|date|after_or_equal:today',
            'deskripsi'        => 'nullable|string',
            'brosur'           => 'nullable|file|mimes:jpg,jpeg,png,gif|max:4096',
            'persyaratan'      => 'nullable|array',
            'persyaratan.*'    => 'nullable|string|max:255',
            'kontak_lamaran'   => 'nullable|string|max:255',
            'aktif'            => 'nullable|boolean',
            'urutan'           => 'nullable|integer',
        ]);

        if ($request->hasFile('logo_perusahaan')) {
            $data['logo_perusahaan'] = $request->file('logo_perusahaan')->store('bkk/logo', 'public');
        }

        if ($request->hasFile('brosur')) {
            $data['brosur'] = $request->file('brosur')->store('bkk/brosur', 'public');
        }

        $data['aktif']       = $request->boolean('aktif', true);
        $data['persyaratan'] = array_values(array_filter($request->input('persyaratan', [])));

        LowonganKerja::create($data);

        return redirect()->route('admin.bkk.lowongan.index')->with('success', 'Lowongan kerja berhasil ditambahkan.');
    }

    public function editLowongan(LowonganKerja $lowongan)
    {
        return view('admin.bkk.lowongan.edit', compact('lowongan'));
    }

    public function updateLowongan(Request $request, LowonganKerja $lowongan)
    {
        $data = $request->validate([
            'nama_perusahaan'  => 'required|string|max:255',
            'logo_perusahaan'  => 'nullable|file|mimes:jpg,jpeg,png,gif|max:2048',
            'posisi'           => 'required|string|max:255',
            'lokasi'           => 'required|string|max:255',
            'tipe_pekerjaan'   => 'required|string|max:100',
            'jurusan_relevan'  => 'nullable|string|max:255',
            'batas_lamaran'    => 'required|date',
            'deskripsi'        => 'nullable|string',
            'brosur'           => 'nullable|file|mimes:jpg,jpeg,png,gif|max:4096',
            'persyaratan'      => 'nullable|array',
            'persyaratan.*'    => 'nullable|string|max:255',
            'kontak_lamaran'   => 'nullable|string|max:255',
            'aktif'            => 'nullable|boolean',
            'urutan'           => 'nullable|integer',
        ]);

        if ($request->hasFile('logo_perusahaan')) {
            if ($lowongan->logo_perusahaan) {
                Storage::disk('public')->delete($lowongan->logo_perusahaan);
            }
            $data['logo_perusahaan'] = $request->file('logo_perusahaan')->store('bkk/logo', 'public');
        }

        if ($request->hasFile('brosur')) {
            if ($lowongan->brosur) {
                Storage::disk('public')->delete($lowongan->brosur);
            }
            $data['brosur'] = $request->file('brosur')->store('bkk/brosur', 'public');
        }

        $data['aktif']       = $request->boolean('aktif', false);
        $data['persyaratan'] = array_values(array_filter($request->input('persyaratan', [])));

        $lowongan->update($data);

        return redirect()->route('admin.bkk.lowongan.index')->with('success', 'Lowongan kerja berhasil diperbarui.');
    }

    public function destroyLowongan(LowonganKerja $lowongan)
    {
        if ($lowongan->logo_perusahaan) {
            Storage::disk('public')->delete($lowongan->logo_perusahaan);
        }
        if ($lowongan->brosur) {
            Storage::disk('public')->delete($lowongan->brosur);
        }
        $lowongan->delete();

        return redirect()->route('admin.bkk.lowongan.index')->with('success', 'Lowongan kerja berhasil dihapus.');
    }

    public function toggleAktifLowongan(LowonganKerja $lowongan)
    {
        $lowongan->update(['aktif' => !$lowongan->aktif]);
        $status = $lowongan->aktif ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Lowongan berhasil {$status}.");
    }
}
