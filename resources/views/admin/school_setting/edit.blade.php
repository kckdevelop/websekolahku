@extends('layouts.admin')
@section('title', 'Identitas Sekolah')
@section('subtitle', 'Kelola nama, singkatan, logo, dan favicon sekolah yang tampil di seluruh halaman')

@section('content')
<div class="max-w-4xl space-y-6">

  {{-- ── FORM IDENTITAS ── --}}
  <form method="POST" action="{{ route('admin.school-setting.update') }}"
        enctype="multipart/form-data" id="school-form">
    @csrf
    @method('PUT')

    {{-- Nama & Singkatan --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
      <div class="border-b border-slate-100 px-6 py-4 bg-slate-50 flex items-center gap-2">
        <i class="fas fa-school text-primary"></i>
        <h3 class="font-bold text-slate-800">Nama Sekolah</h3>
      </div>
      <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label for="nama_sekolah" class="block text-sm font-medium text-slate-700 mb-1.5">
            Nama Lengkap Sekolah <span class="text-red-500">*</span>
          </label>
          <input type="text" id="nama_sekolah" name="nama_sekolah"
            value="{{ old('nama_sekolah', $setting->nama_sekolah) }}" required
            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm @error('nama_sekolah') border-red-400 @enderror"
            placeholder="Contoh: SMK Muhammadiyah 1 Bantul">
          <p class="text-slate-400 text-xs mt-1">Nama lengkap yang tampil di footer dan dokumen.</p>
          @error('nama_sekolah') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
          <label for="singkatan" class="block text-sm font-medium text-slate-700 mb-1.5">
            Singkatan / Nama Pendek <span class="text-red-500">*</span>
          </label>
          <input type="text" id="singkatan" name="singkatan"
            value="{{ old('singkatan', $setting->singkatan) }}" required
            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm @error('singkatan') border-red-400 @enderror"
            placeholder="Contoh: SMK MUSABA">
          <p class="text-slate-400 text-xs mt-1">Nama singkat yang tampil di navbar dan sidebar.</p>
          @error('singkatan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
      </div>
    </div>

    {{-- Logo Utama --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
      <div class="border-b border-slate-100 px-6 py-4 bg-slate-50 flex items-center gap-2">
        <i class="fas fa-image text-primary"></i>
        <h3 class="font-bold text-slate-800">Logo Sekolah</h3>
      </div>
      <div class="p-6">
        <div class="flex flex-col sm:flex-row items-start gap-6">

          {{-- Preview Logo --}}
          <div class="flex-shrink-0 text-center">
            <div id="logo-preview-wrap"
              class="w-32 h-32 rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50 flex items-center justify-center overflow-hidden shadow-sm">
              @if($setting->logo)
                <img id="logo-preview" src="{{ $setting->logo_url }}" alt="Logo Sekolah"
                     class="w-full h-full object-contain p-2">
              @else
                <div id="logo-placeholder" class="flex flex-col items-center gap-1 text-slate-300">
                  <i class="fas fa-image text-3xl"></i>
                  <span class="text-xs">Belum ada</span>
                </div>
                <img id="logo-preview" src="" alt="" class="w-full h-full object-contain p-2 hidden">
              @endif
            </div>
            <p class="text-xs text-slate-400 mt-2">Preview Logo</p>
          </div>

          {{-- Upload Controls --}}
          <div class="flex-1 space-y-3">
            <label class="cursor-pointer inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 hover:border-primary hover:bg-orange-50 transition-all text-sm text-slate-600 hover:text-primary font-medium">
              <i class="fas fa-cloud-upload-alt"></i>
              <span id="logo-file-label">Pilih File Logo</span>
              <input type="file" id="logo-input" name="logo" accept="image/*" class="hidden"
                     onchange="previewFile(this, 'logo-preview', 'logo-placeholder', 'logo-file-label')">
            </label>

            <p class="text-slate-400 text-xs leading-relaxed">
              <i class="fas fa-info-circle mr-1"></i>
              Format: PNG, JPG, SVG, WebP. Maksimal 2MB.<br>
              Rekomendasi: PNG transparan, rasio 1:1, minimal 256×256px.<br>
              Logo digunakan di navbar, sidebar admin, favicon, dan kartu identitas.
            </p>

            @if($setting->logo)
              <label class="inline-flex items-center gap-2 cursor-pointer text-xs text-red-500 hover:text-red-700">
                <input type="checkbox" name="hapus_logo" value="1" class="rounded">
                Hapus logo yang ada (akan kembali ke logo default)
              </label>
            @endif

            @error('logo') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
          </div>
        </div>
      </div>
    </div>

    {{-- Favicon --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
      <div class="border-b border-slate-100 px-6 py-4 bg-slate-50 flex items-center gap-2">
        <i class="fas fa-star text-primary text-sm"></i>
        <h3 class="font-bold text-slate-800">Favicon</h3>
      </div>
      <div class="p-6">
        <div class="flex flex-col sm:flex-row items-start gap-6">

          {{-- Preview Favicon --}}
          <div class="flex-shrink-0 text-center">
            <div class="w-16 h-16 rounded-xl border-2 border-dashed border-slate-200 bg-slate-50 flex items-center justify-center overflow-hidden shadow-sm">
              @if($setting->favicon || $setting->logo)
                <img id="favicon-preview" src="{{ $setting->favicon_url }}" alt="Favicon"
                     class="w-full h-full object-contain p-1">
              @else
                <div id="favicon-placeholder" class="flex flex-col items-center gap-0.5 text-slate-300">
                  <i class="fas fa-star text-xl"></i>
                  <span class="text-[9px]">Belum ada</span>
                </div>
                <img id="favicon-preview" src="" alt="" class="w-full h-full object-contain p-1 hidden">
              @endif
            </div>
            <p class="text-xs text-slate-400 mt-1">Preview</p>
          </div>

          {{-- Upload Controls --}}
          <div class="flex-1 space-y-3">
            <label class="cursor-pointer inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 hover:border-primary hover:bg-orange-50 transition-all text-sm text-slate-600 hover:text-primary font-medium">
              <i class="fas fa-cloud-upload-alt"></i>
              <span id="favicon-file-label">Pilih File Favicon</span>
              <input type="file" id="favicon-input" name="favicon" accept="image/*" class="hidden"
                     onchange="previewFile(this, 'favicon-preview', 'favicon-placeholder', 'favicon-file-label')">
            </label>

            <p class="text-slate-400 text-xs leading-relaxed">
              <i class="fas fa-info-circle mr-1"></i>
              Format: PNG, ICO, SVG, WebP. Maksimal 512KB.<br>
              Rekomendasi: PNG transparan 32×32px atau 64×64px.<br>
              Jika tidak diisi, favicon menggunakan logo utama.
            </p>

            @if($setting->favicon)
              <label class="inline-flex items-center gap-2 cursor-pointer text-xs text-red-500 hover:text-red-700">
                <input type="checkbox" name="hapus_favicon" value="1" class="rounded">
                Hapus favicon (akan menggunakan logo sebagai favicon)
              </label>
            @endif

            @error('favicon') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
          </div>
        </div>
      </div>
    </div>

    {{-- Preview Penggunaan --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
      <div class="border-b border-slate-100 px-6 py-4 bg-slate-50">
        <h3 class="font-bold text-slate-800 text-sm flex items-center gap-2">
          <i class="fas fa-eye text-slate-400"></i> Preview Tampilan Navbar & Sidebar
        </h3>
      </div>
      <div class="p-6 space-y-4">
        {{-- Preview Navbar Publik --}}
        <div>
          <p class="text-xs font-semibold text-slate-500 mb-2 uppercase tracking-wider">Navbar Publik</p>
          <div class="flex items-center gap-3 bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl px-4 py-3 w-fit">
            <div class="w-9 h-9 bg-white rounded-full flex items-center justify-center overflow-hidden shadow">
              <img id="preview-navbar-logo" src="{{ $setting->logo_url }}" alt="Logo"
                   class="w-7 h-7 object-contain">
            </div>
            <span id="preview-navbar-name" class="font-bold text-white text-sm">{{ $setting->singkatan }}</span>
          </div>
        </div>
        {{-- Preview Sidebar Admin --}}
        <div>
          <p class="text-xs font-semibold text-slate-500 mb-2 uppercase tracking-wider">Sidebar Admin</p>
          <div class="flex items-center gap-3 bg-slate-900 rounded-xl px-4 py-3 w-fit">
            <div class="w-9 h-9 bg-white rounded-lg flex items-center justify-center overflow-hidden shadow">
              <img id="preview-sidebar-logo" src="{{ $setting->logo_url }}" alt="Logo"
                   class="w-7 h-7 object-contain">
            </div>
            <div>
              <p class="text-white font-bold text-xs">Admin Panel</p>
              <p id="preview-sidebar-name" class="text-slate-400 text-[10px]">{{ $setting->singkatan }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Action Buttons --}}
    <div class="flex items-center gap-3">
      <button type="submit"
        class="inline-flex items-center gap-2 bg-primary hover:bg-secondary text-white font-semibold px-6 py-3 rounded-xl transition-all hover:shadow-lg hover:shadow-primary/30">
        <i class="fas fa-save"></i> Simpan Perubahan
      </button>
      <a href="{{ route('admin.dashboard') }}"
        class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-6 py-3 rounded-xl transition-all">
        Batal
      </a>
    </div>

  </form>
</div>
@endsection

@section('scripts')
<script>
  function previewFile(input, previewId, placeholderId, labelId) {
    const file = input.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = (e) => {
      const preview = document.getElementById(previewId);
      const placeholder = document.getElementById(placeholderId);
      const label = document.getElementById(labelId);

      if (preview) {
        preview.src = e.target.result;
        preview.classList.remove('hidden');
      }
      if (placeholder) placeholder.classList.add('hidden');
      if (label) label.textContent = file.name.length > 22 ? file.name.substring(0, 22) + '...' : file.name;

      // Update live previews
      if (previewId === 'logo-preview') {
        document.getElementById('preview-navbar-logo').src = e.target.result;
        document.getElementById('preview-sidebar-logo').src = e.target.result;
      }
    };
    reader.readAsDataURL(file);
  }

  // Live preview nama
  document.getElementById('singkatan').addEventListener('input', function() {
    document.getElementById('preview-navbar-name').textContent = this.value || 'SMK MUSABA';
    document.getElementById('preview-sidebar-name').textContent = this.value || 'SMK MUSABA';
  });
</script>
@endsection
