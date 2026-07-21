<?php

namespace App\Http\Controllers;

use App\Models\SchoolSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminSchoolSettingController extends Controller
{
    public function edit()
    {
        $setting = SchoolSetting::getSingle();
        return view('admin.school_setting.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'singkatan'    => 'required|string|max:100',
            'logo'         => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:2048',
            'favicon'      => 'nullable|image|mimes:png,jpg,jpeg,ico,svg,webp|max:512',
        ], [
            'nama_sekolah.required' => 'Nama sekolah wajib diisi.',
            'singkatan.required'    => 'Singkatan/nama pendek wajib diisi.',
            'logo.image'            => 'Logo harus berupa file gambar.',
            'logo.max'              => 'Ukuran logo maksimal 2MB.',
            'favicon.max'           => 'Ukuran favicon maksimal 512KB.',
        ]);

        $setting = SchoolSetting::getSingle();

        $data = [
            'nama_sekolah' => $request->nama_sekolah,
            'singkatan'    => $request->singkatan,
        ];

        // Upload logo baru
        if ($request->hasFile('logo')) {
            if ($setting->logo) {
                Storage::disk('public')->delete($setting->logo);
            }
            $data['logo'] = $request->file('logo')->store('school', 'public');
        }

        // Upload favicon baru
        if ($request->hasFile('favicon')) {
            if ($setting->favicon) {
                Storage::disk('public')->delete($setting->favicon);
            }
            $data['favicon'] = $request->file('favicon')->store('school', 'public');
        }

        // Hapus logo
        if ($request->has('hapus_logo') && $setting->logo) {
            Storage::disk('public')->delete($setting->logo);
            $data['logo'] = null;
        }

        // Hapus favicon
        if ($request->has('hapus_favicon') && $setting->favicon) {
            Storage::disk('public')->delete($setting->favicon);
            $data['favicon'] = null;
        }

        $setting->update($data);

        return redirect()->route('admin.school-setting.edit')
            ->with('success', 'Identitas sekolah berhasil diperbarui!');
    }
}
