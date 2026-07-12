@extends('layouts.admin')
@section('title', 'Pengaturan Halaman Tefa')
@section('subtitle', 'Kelola konten dan informasi halaman Teaching Factory (Tefa)')

@section('content')
<div class="max-w-4xl">

  @if(session('success'))
    <div class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl px-5 py-4">
      <i class="fas fa-check-circle text-lg"></i>
      <span class="text-sm font-medium">{{ session('success') }}</span>
    </div>
  @endif

  @if($errors->any())
    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-xl px-5 py-4">
      <p class="font-semibold mb-2 text-sm"><i class="fas fa-exclamation-circle mr-1"></i> Terdapat kesalahan:</p>
      <ul class="list-disc list-inside text-xs space-y-1">
        @foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('admin.tefa.setting.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    {{-- Hero Banner --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6 space-y-6">
      <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider pb-2 border-b border-slate-100">
        <i class="fas fa-image mr-1 text-primary"></i> Banner Hero
      </h3>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label for="hero_title" class="block text-sm font-medium text-slate-700 mb-1.5">Judul Banner <span class="text-red-500">*</span></label>
          <input type="text" id="hero_title" name="hero_title" value="{{ old('hero_title', $setting->hero_title) }}" required
            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
          @error('hero_title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
          <label for="hero_subtitle" class="block text-sm font-medium text-slate-700 mb-1.5">Subjudul Banner <span class="text-red-500">*</span></label>
          <input type="text" id="hero_subtitle" name="hero_subtitle" value="{{ old('hero_subtitle', $setting->hero_subtitle) }}" required
            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
          @error('hero_subtitle') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="md:col-span-2">
          <label class="block text-sm font-medium text-slate-700 mb-1.5">Gambar Banner Hero</label>
          <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
            <div class="w-64 h-32 rounded-xl overflow-hidden border border-slate-200 bg-slate-50 flex items-center justify-center">
              @if($setting->hero_gambar)
                <img id="hero-preview" src="{{ asset('storage/' . $setting->hero_gambar) }}" alt="Preview" class="w-full h-full object-cover">
              @else
                <img id="hero-preview" src="https://placehold.co/640x200/f1f5f9/94a3b8?text=Belum+ada+gambar" alt="Preview" class="w-full h-full object-cover">
              @endif
            </div>
            <div class="space-y-2">
              <label class="cursor-pointer inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 hover:border-primary hover:bg-orange-50 transition-all text-sm text-slate-600 hover:text-primary font-medium">
                <i class="fas fa-cloud-upload-alt text-base"></i>
                <span id="hero-label">{{ $setting->hero_gambar ? 'Ganti Banner' : 'Upload Banner' }}</span>
                <input type="file" id="hero_gambar" name="hero_gambar" accept="image/*" class="hidden"
                  onchange="document.getElementById('hero-preview').src=URL.createObjectURL(this.files[0]); document.getElementById('hero-label').textContent=this.files[0].name;">
              </label>
              <p class="text-slate-400 text-xs">Rekomendasi rasio 16:5 (1920x600). Maks: 2MB</p>
            </div>
          </div>
          @error('hero_gambar') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
      </div>
    </div>

    {{-- Tentang Tefa --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6 space-y-5">
      <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider pb-2 border-b border-slate-100">
        <i class="fas fa-info-circle mr-1 text-primary"></i> Tentang Tefa
      </h3>
      <div>
        <label for="tentang_judul" class="block text-sm font-medium text-slate-700 mb-1.5">Judul Tentang <span class="text-red-500">*</span></label>
        <input type="text" id="tentang_judul" name="tentang_judul" value="{{ old('tentang_judul', $setting->tentang_judul) }}" required
          class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
        @error('tentang_judul') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>
      <div>
        <label for="tentang_deskripsi" class="block text-sm font-medium text-slate-700 mb-1.5">Deskripsi Tefa <span class="text-red-500">*</span></label>
        <textarea id="tentang_deskripsi" name="tentang_deskripsi" rows="6" required
          class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm resize-y">{{ old('tentang_deskripsi', $setting->tentang_deskripsi) }}</textarea>
        <p class="text-xs text-slate-400 mt-1">Gunakan enter untuk membuat paragraf baru.</p>
        @error('tentang_deskripsi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>
    </div>

    {{-- WhatsApp --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6 space-y-4">
      <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider pb-2 border-b border-slate-100">
        <i class="fab fa-whatsapp mr-1 text-green-500"></i> Kontak WhatsApp
      </h3>
      <div>
        <label for="telepon_wa" class="block text-sm font-medium text-slate-700 mb-1.5">Nomor WhatsApp (untuk tombol Order Produk)</label>
        <div class="flex items-center">
          <span class="px-4 py-3 rounded-l-xl border border-r-0 border-slate-200 bg-slate-50 text-slate-500 text-sm">+</span>
          <input type="text" id="telepon_wa" name="telepon_wa" value="{{ old('telepon_wa', $setting->telepon_wa) }}"
            placeholder="628123456789"
            class="w-full px-4 py-3 rounded-r-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
        </div>
        <p class="text-xs text-slate-400 mt-1">Format: 628xxxxxxxxxx (tanpa tanda +)</p>
        @error('telepon_wa') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>
    </div>

    <div class="flex gap-3">
      <button type="submit" class="px-6 py-3 bg-primary text-white rounded-xl font-semibold text-sm hover:bg-orange-600 transition-colors flex items-center gap-2">
        <i class="fas fa-save"></i> Simpan Pengaturan
      </button>
      <a href="{{ route('admin.tefa.products.index') }}" class="px-6 py-3 border border-slate-200 text-slate-600 rounded-xl font-semibold text-sm hover:bg-slate-50 transition-colors flex items-center gap-2">
        <i class="fas fa-box-open"></i> Kelola Produk Tefa
      </a>
    </div>

  </form>
</div>
@endsection

