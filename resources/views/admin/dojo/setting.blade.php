@extends('layouts.admin')

@section('title', 'Pengaturan Halaman Dojo SMK')
@section('subtitle', 'Kelola informasi hero, deskripsi utama, fungsi, dan unit Dojo')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
  <form action="{{ route('admin.dojo.setting.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- Section 1: Hero & Deskripsi Utama -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 md:p-8 mb-6">
      <div class="flex items-center gap-3 border-b border-slate-100 pb-4 mb-6">
        <div class="w-10 h-10 rounded-xl bg-orange-100 text-primary flex items-center justify-center font-bold text-lg">
          <i class="fas fa-desktop"></i>
        </div>
        <div>
          <h3 class="text-lg font-bold text-slate-800">Banner Hero & Pengertian Dojo</h3>
          <p class="text-xs text-slate-500">Pengaturan judul utama dan gambaran umum fasilitas Dojo SMK</p>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-2">Judul Hero <span class="text-red-500">*</span></label>
          <input type="text" name="hero_title" value="{{ old('hero_title', $setting->hero_title) }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition text-sm">
          @error('hero_title')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-2">Sub-Judul Hero <span class="text-red-500">*</span></label>
          <input type="text" name="hero_subtitle" value="{{ old('hero_subtitle', $setting->hero_subtitle) }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition text-sm">
          @error('hero_subtitle')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
          @enderror
        </div>

        <div class="md:col-span-2">
          <label class="block text-sm font-semibold text-slate-700 mb-2">Gambar Background Hero</label>
          <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
            <div class="w-40 h-24 bg-slate-100 rounded-xl border border-slate-200 overflow-hidden flex-shrink-0 relative">
              <img id="image-preview" src="{{ $setting->hero_gambar_src }}" class="w-full h-full object-cover">
            </div>
            <div class="flex-grow">
              <input type="file" name="hero_gambar" id="hero_gambar_input" accept="image/*" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-orange-50 file:text-primary hover:file:bg-orange-100 cursor-pointer">
              <p class="text-xs text-slate-400 mt-1">Format: JPG, PNG, WEBP. Maks 5MB. Disarankan rasio 16:9.</p>
              @error('hero_gambar')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
              @enderror
            </div>
          </div>
        </div>

        <div class="md:col-span-2">
          <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi Utama (Apa itu Dojo SMK?) <span class="text-red-500">*</span></label>
          <textarea name="deskripsi_utama" rows="4" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition text-sm leading-relaxed">{{ old('deskripsi_utama', $setting->deskripsi_utama) }}</textarea>
          @error('deskripsi_utama')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
          @enderror
        </div>
      </div>
    </div>

    <!-- Section 2: 3 Fungsi Utama Dojo -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 md:p-8 mb-6">
      <div class="flex items-center gap-3 border-b border-slate-100 pb-4 mb-6">
        <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-lg">
          <i class="fas fa-list-check"></i>
        </div>
        <div>
          <h3 class="text-lg font-bold text-slate-800">3 Fungsi Utama Dojo</h3>
          <p class="text-xs text-slate-500">Judul dan deskripsi dari 3 pilar fungsi utama pelatihan Dojo</p>
        </div>
      </div>

      <div class="space-y-6">
        <!-- Fungsi 1 -->
        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/60">
          <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Fungsi 1</label>
          <input type="text" name="fungsi_1_judul" value="{{ old('fungsi_1_judul', $setting->fungsi_1_judul) }}" required class="w-full px-4 py-2 rounded-xl border border-slate-200 mb-3 text-sm font-semibold">
          <textarea name="fungsi_1_deskripsi" rows="2" class="w-full px-4 py-2 rounded-xl border border-slate-200 text-sm" placeholder="Penjelasan fungsi 1...">{{ old('fungsi_1_deskripsi', $setting->fungsi_1_deskripsi) }}</textarea>
        </div>

        <!-- Fungsi 2 -->
        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/60">
          <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Fungsi 2</label>
          <input type="text" name="fungsi_2_judul" value="{{ old('fungsi_2_judul', $setting->fungsi_2_judul) }}" required class="w-full px-4 py-2 rounded-xl border border-slate-200 mb-3 text-sm font-semibold">
          <textarea name="fungsi_2_deskripsi" rows="2" class="w-full px-4 py-2 rounded-xl border border-slate-200 text-sm" placeholder="Penjelasan fungsi 2...">{{ old('fungsi_2_deskripsi', $setting->fungsi_2_deskripsi) }}</textarea>
        </div>

        <!-- Fungsi 3 -->
        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/60">
          <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Fungsi 3</label>
          <input type="text" name="fungsi_3_judul" value="{{ old('fungsi_3_judul', $setting->fungsi_3_judul) }}" required class="w-full px-4 py-2 rounded-xl border border-slate-200 mb-3 text-sm font-semibold">
          <textarea name="fungsi_3_deskripsi" rows="2" class="w-full px-4 py-2 rounded-xl border border-slate-200 text-sm" placeholder="Penjelasan fungsi 3...">{{ old('fungsi_3_deskripsi', $setting->fungsi_3_deskripsi) }}</textarea>
        </div>
      </div>
    </div>

    <!-- Section 3: Deskripsi 4 Unit Pelatihan Dojo -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 md:p-8 mb-6">
      <div class="flex items-center gap-3 border-b border-slate-100 pb-4 mb-6">
        <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold text-lg">
          <i class="fas fa-layer-group"></i>
        </div>
        <div>
          <h3 class="text-lg font-bold text-slate-800">Detail 4 Unit Pelatihan Dojo</h3>
          <p class="text-xs text-slate-500">Penjelasan mengenai Dojo Safety, Dojo Welding, Dojo Assembling, dan Dojo Behavior</p>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block text-sm font-bold text-red-600 mb-2"><i class="fas fa-hard-hat mr-1.5"></i> Dojo Safety</label>
          <textarea name="safety_deskripsi" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm leading-relaxed">{{ old('safety_deskripsi', $setting->safety_deskripsi) }}</textarea>
        </div>

        <div>
          <label class="block text-sm font-bold text-amber-600 mb-2"><i class="fas fa-fire-burner mr-1.5"></i> Dojo Welding</label>
          <textarea name="welding_deskripsi" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm leading-relaxed">{{ old('welding_deskripsi', $setting->welding_deskripsi) }}</textarea>
        </div>

        <div>
          <label class="block text-sm font-bold text-blue-600 mb-2"><i class="fas fa-cogs mr-1.5"></i> Dojo Assembling</label>
          <textarea name="assembling_deskripsi" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm leading-relaxed">{{ old('assembling_deskripsi', $setting->assembling_deskripsi) }}</textarea>
        </div>

        <div>
          <label class="block text-sm font-bold text-emerald-600 mb-2"><i class="fas fa-user-check mr-1.5"></i> Dojo Behavior</label>
          <textarea name="behavior_deskripsi" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm leading-relaxed">{{ old('behavior_deskripsi', $setting->behavior_deskripsi) }}</textarea>
        </div>
      </div>
    </div>

    <!-- Section 4: Informasi Kerja Sama -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 md:p-8 mb-6">
      <div class="flex items-center gap-3 border-b border-slate-100 pb-4 mb-6">
        <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center font-bold text-lg">
          <i class="fas fa-handshake"></i>
        </div>
        <div>
          <h3 class="text-lg font-bold text-slate-800">Kerja Sama Industri & Penutup</h3>
          <p class="text-xs text-slate-500">Informasi program kemitraan dengan industri otomotif/pabrik</p>
        </div>
      </div>

      <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Informasi Kerja Sama Industri</label>
        <textarea name="kerjasama_info" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm leading-relaxed">{{ old('kerjasama_info', $setting->kerjasama_info) }}</textarea>
      </div>
    </div>

    <!-- Submit Button -->
    <div class="flex justify-end">
      <button type="submit" class="px-8 py-3.5 bg-primary hover:bg-secondary text-white font-bold rounded-xl shadow-lg shadow-primary/30 hover:shadow-primary/50 transition-all flex items-center gap-2">
        <i class="fas fa-save"></i>
        <span>Simpan Pengaturan</span>
      </button>
    </div>
  </form>
</div>
@endsection
