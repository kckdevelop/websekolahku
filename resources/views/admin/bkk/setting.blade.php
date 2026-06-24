@extends('layouts.admin')
@section('title', 'Pengaturan Halaman BKK')
@section('subtitle', 'Kelola konten, layanan, mitra, dan informasi kontak Bursa Kerja Khusus')

@section('content')
<div class="max-w-5xl">

  {{-- Tab Navigation --}}
  <div class="flex gap-2 mb-6 flex-wrap">
    <button onclick="switchTab('hero')" id="tab-hero" class="tab-btn active-tab">
      <i class="fas fa-image mr-1"></i> Hero & Tentang
    </button>
    <button onclick="switchTab('statistik')" id="tab-statistik" class="tab-btn">
      <i class="fas fa-chart-bar mr-1"></i> Statistik
    </button>
    <button onclick="switchTab('layanan')" id="tab-layanan" class="tab-btn">
      <i class="fas fa-cogs mr-1"></i> Layanan
    </button>
    <button onclick="switchTab('mitra')" id="tab-mitra" class="tab-btn">
      <i class="fas fa-handshake mr-1"></i> Mitra Perusahaan
    </button>
    <button onclick="switchTab('kontak')" id="tab-kontak" class="tab-btn">
      <i class="fas fa-phone mr-1"></i> Kontak & CTA
    </button>
  </div>

  <form method="POST" action="{{ route('admin.bkk.setting.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    {{-- ===== TAB 1: HERO & TENTANG ===== --}}
    <div id="panel-hero" class="tab-panel">
      <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 space-y-6">
        <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider pb-2 border-b border-slate-100">
          <i class="fas fa-image mr-1 text-primary"></i> Banner Hero
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label for="hero_title" class="block text-sm font-medium text-slate-700 mb-1.5">Judul Banner <span class="text-red-500">*</span></label>
            <input type="text" id="hero_title" name="hero_title" value="{{ old('hero_title', $bkk->hero_title) }}" required
              class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
            @error('hero_title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          </div>
          <div>
            <label for="hero_subtitle" class="block text-sm font-medium text-slate-700 mb-1.5">Subjudul Banner <span class="text-red-500">*</span></label>
            <input type="text" id="hero_subtitle" name="hero_subtitle" value="{{ old('hero_subtitle', $bkk->hero_subtitle) }}" required
              class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
            @error('hero_subtitle') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          </div>
          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Gambar Banner Hero</label>
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
              <div class="w-64 h-32 rounded-xl overflow-hidden border border-slate-200 bg-slate-50 flex items-center justify-center">
                <img id="hero-preview" src="{{ $bkk->hero_gambar_src }}" alt="Preview" class="w-full h-full object-cover">
              </div>
              <div class="space-y-2">
                <label class="cursor-pointer inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 hover:border-primary hover:bg-orange-50 transition-all text-sm text-slate-600 hover:text-primary font-medium">
                  <i class="fas fa-cloud-upload-alt text-base"></i>
                  <span id="hero-label">Ganti Banner</span>
                  <input type="file" id="hero_gambar" name="hero_gambar" accept="image/*" class="hidden" onchange="previewImg(this,'hero-preview','hero-label')">
                </label>
                <p class="text-slate-400 text-xs">Rekomendasi rasio 16:5 (1920x600). Maks: 3MB</p>
              </div>
            </div>
            @error('hero_gambar') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          </div>
        </div>

        <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider pb-2 border-b border-slate-100">
          <i class="fas fa-info-circle mr-1 text-primary"></i> Tentang BKK
        </h3>
        <div class="space-y-4">
          <div>
            <label for="tentang_judul" class="block text-sm font-medium text-slate-700 mb-1.5">Judul Tentang <span class="text-red-500">*</span></label>
            <input type="text" id="tentang_judul" name="tentang_judul" value="{{ old('tentang_judul', $bkk->tentang_judul) }}" required
              class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
            @error('tentang_judul') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          </div>
          <div>
            <label for="tentang_deskripsi" class="block text-sm font-medium text-slate-700 mb-1.5">Deskripsi Tentang BKK</label>
            <textarea id="tentang_deskripsi" name="tentang_deskripsi" rows="5"
              class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm resize-none"
              placeholder="Deskripsi singkat tentang BKK sekolah...">{{ old('tentang_deskripsi', $bkk->tentang_deskripsi) }}</textarea>
          </div>
        </div>

        <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
          <button type="submit" class="inline-flex items-center gap-2 bg-primary hover:bg-secondary text-white font-semibold px-6 py-3 rounded-xl transition-all hover:shadow-lg hover:shadow-primary/30">
            <i class="fas fa-save"></i> Simpan Perubahan
          </button>
        </div>
      </div>
    </div>

    {{-- ===== TAB 2: STATISTIK ===== --}}
    <div id="panel-statistik" class="tab-panel hidden">
      <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider pb-2 border-b border-slate-100 mb-4">
          <i class="fas fa-chart-bar mr-1 text-primary"></i> Statistik BKK (Angka Pencapaian)
        </h3>
        <div id="statistik-container" class="space-y-3">
          @php $statistik = old('statistik', $bkk->statistik ?? []); @endphp
          @foreach($statistik as $i => $item)
          <div class="statistik-row flex items-center gap-3 p-3 bg-slate-50 rounded-xl border border-slate-100">
            <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0">
              <i class="{{ $item['ikon'] ?? 'fa-star' }} text-primary text-sm"></i>
            </div>
            <div class="flex-1 grid grid-cols-3 gap-3">
              <input type="text" name="statistik[{{ $i }}][label]" value="{{ $item['label'] }}" placeholder="Label (contoh: Lulusan Tersalurkan)" required
                class="col-span-1 px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-xs">
              <input type="text" name="statistik[{{ $i }}][nilai]" value="{{ $item['nilai'] }}" placeholder="Nilai (contoh: 850+)" required
                class="col-span-1 px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-xs">
              <input type="text" name="statistik[{{ $i }}][ikon]" value="{{ $item['ikon'] }}" placeholder="FA Icon (fa-users)" required
                class="col-span-1 px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-xs">
            </div>
            <button type="button" onclick="removeRow(this, 'statistik-container', 1)" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition">
              <i class="fas fa-trash text-sm"></i>
            </button>
          </div>
          @endforeach
        </div>
        <button type="button" onclick="addStatistik()" class="mt-3 inline-flex items-center gap-1 text-xs text-primary hover:text-secondary font-semibold bg-orange-50 hover:bg-orange-100 px-3 py-2 rounded-lg transition">
          <i class="fas fa-plus"></i> Tambah Statistik
        </button>

        <div class="flex items-center gap-3 pt-6 border-t border-slate-100 mt-6">
          <button type="submit" class="inline-flex items-center gap-2 bg-primary hover:bg-secondary text-white font-semibold px-6 py-3 rounded-xl transition-all hover:shadow-lg hover:shadow-primary/30">
            <i class="fas fa-save"></i> Simpan Perubahan
          </button>
        </div>
      </div>
    </div>

    {{-- ===== TAB 3: LAYANAN ===== --}}
    <div id="panel-layanan" class="tab-panel hidden">
      <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider pb-2 border-b border-slate-100 mb-4">
          <i class="fas fa-cogs mr-1 text-primary"></i> Layanan BKK
        </h3>
        <div id="layanan-container" class="space-y-4">
          @php $layanan = old('layanan', $bkk->layanan ?? []); @endphp
          @foreach($layanan as $i => $item)
          <div class="layanan-row p-4 bg-slate-50 rounded-xl border border-slate-100 relative">
            <button type="button" onclick="removeRow(this, 'layanan-container', 1)" class="absolute top-2 right-2 p-1.5 text-red-500 hover:bg-red-100 rounded-lg transition">
              <i class="fas fa-trash text-xs"></i>
            </button>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
              <input type="text" name="layanan[{{ $i }}][judul]" value="{{ $item['judul'] }}" placeholder="Judul layanan" required
                class="px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
              <input type="text" name="layanan[{{ $i }}][ikon]" value="{{ $item['ikon'] }}" placeholder="FA icon (fa-briefcase)" required
                class="px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
              <textarea name="layanan[{{ $i }}][deskripsi]" rows="2" placeholder="Deskripsi layanan..." required
                class="md:col-span-3 w-full px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm resize-none">{{ $item['deskripsi'] }}</textarea>
            </div>
          </div>
          @endforeach
        </div>
        <button type="button" onclick="addLayanan()" class="mt-3 inline-flex items-center gap-1 text-xs text-primary hover:text-secondary font-semibold bg-orange-50 hover:bg-orange-100 px-3 py-2 rounded-lg transition">
          <i class="fas fa-plus"></i> Tambah Layanan
        </button>

        <div class="flex items-center gap-3 pt-6 border-t border-slate-100 mt-6">
          <button type="submit" class="inline-flex items-center gap-2 bg-primary hover:bg-secondary text-white font-semibold px-6 py-3 rounded-xl transition-all hover:shadow-lg hover:shadow-primary/30">
            <i class="fas fa-save"></i> Simpan Perubahan
          </button>
        </div>
      </div>
    </div>

    {{-- ===== TAB 4: MITRA PERUSAHAAN ===== --}}
    <div id="panel-mitra" class="tab-panel hidden">
      <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider pb-2 border-b border-slate-100 mb-4">
          <i class="fas fa-handshake mr-1 text-primary"></i> Mitra Perusahaan
        </h3>
        <div id="mitra-container" class="grid grid-cols-1 md:grid-cols-2 gap-4">
          @php $mitras = old('mitra_perusahaan', $bkk->mitra_perusahaan ?? []); @endphp
          @foreach($mitras as $i => $item)
          <div class="mitra-row p-4 bg-slate-50 rounded-xl border border-slate-100 relative flex items-center gap-4">
            <button type="button" onclick="removeRow(this, 'mitra-container', 1)" class="absolute top-2 right-2 p-1.5 text-red-500 hover:bg-red-100 rounded-lg transition z-10">
              <i class="fas fa-trash text-xs"></i>
            </button>
            <div class="w-14 h-14 rounded-xl overflow-hidden border border-slate-200 bg-white flex items-center justify-center flex-shrink-0">
              @if(!empty($item['logo']))
                <img src="{{ asset('storage/'.$item['logo']) }}" alt="{{ $item['nama'] }}" class="w-full h-full object-contain mitra-logo-preview">
              @else
                <i class="fas fa-building text-slate-300 text-xl mitra-logo-preview-icon"></i>
              @endif
            </div>
            <div class="flex-1 space-y-2">
              <input type="hidden" name="mitra_perusahaan[{{ $i }}][existing]" value="{{ $item['logo'] ?? '' }}">
              <input type="text" name="mitra_perusahaan[{{ $i }}][nama]" value="{{ $item['nama'] }}" placeholder="Nama Perusahaan" required
                class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
              <label class="cursor-pointer inline-flex items-center gap-1.5 text-xs text-slate-500 hover:text-primary font-medium">
                <i class="fas fa-upload"></i> Upload Logo
                <input type="file" name="mitra_perusahaan[{{ $i }}][logo]" accept="image/*" class="hidden mitra-logo-input" onchange="previewMitraLogo(this)">
              </label>
            </div>
          </div>
          @endforeach
        </div>
        <button type="button" onclick="addMitra()" class="mt-4 inline-flex items-center gap-1 text-xs text-primary hover:text-secondary font-semibold bg-orange-50 hover:bg-orange-100 px-3 py-2 rounded-lg transition">
          <i class="fas fa-plus"></i> Tambah Mitra
        </button>

        <div class="flex items-center gap-3 pt-6 border-t border-slate-100 mt-6">
          <button type="submit" class="inline-flex items-center gap-2 bg-primary hover:bg-secondary text-white font-semibold px-6 py-3 rounded-xl transition-all hover:shadow-lg hover:shadow-primary/30">
            <i class="fas fa-save"></i> Simpan Perubahan
          </button>
        </div>
      </div>
    </div>

    {{-- ===== TAB 5: KONTAK & CTA ===== --}}
    <div id="panel-kontak" class="tab-panel hidden">
      <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 space-y-6">
        <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider pb-2 border-b border-slate-100">
          <i class="fas fa-phone mr-1 text-primary"></i> Informasi Kontak BKK
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label for="kontak_nama" class="block text-sm font-medium text-slate-700 mb-1.5">Nama / Jabatan Koordinator</label>
            <input type="text" id="kontak_nama" name="kontak_nama" value="{{ old('kontak_nama', $bkk->kontak_nama) }}"
              class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm" placeholder="Koordinator BKK ...">
          </div>
          <div>
            <label for="kontak_telepon" class="block text-sm font-medium text-slate-700 mb-1.5">Nomor Telepon / WhatsApp</label>
            <input type="text" id="kontak_telepon" name="kontak_telepon" value="{{ old('kontak_telepon', $bkk->kontak_telepon) }}"
              class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm" placeholder="0274-XXXXXX">
          </div>
          <div>
            <label for="kontak_email" class="block text-sm font-medium text-slate-700 mb-1.5">Email BKK</label>
            <input type="email" id="kontak_email" name="kontak_email" value="{{ old('kontak_email', $bkk->kontak_email) }}"
              class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm" placeholder="bkk@sekolah.sch.id">
          </div>
          <div>
            <label for="kontak_jam_operasional" class="block text-sm font-medium text-slate-700 mb-1.5">Jam Operasional</label>
            <input type="text" id="kontak_jam_operasional" name="kontak_jam_operasional" value="{{ old('kontak_jam_operasional', $bkk->kontak_jam_operasional) }}"
              class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm" placeholder="Senin – Jumat, 08.00 – 14.00 WIB">
          </div>
          <div class="md:col-span-2">
            <label for="kontak_lokasi" class="block text-sm font-medium text-slate-700 mb-1.5">Lokasi / Alamat</label>
            <input type="text" id="kontak_lokasi" name="kontak_lokasi" value="{{ old('kontak_lokasi', $bkk->kontak_lokasi) }}"
              class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm" placeholder="Jl. ... , Bantul, Yogyakarta">
          </div>
        </div>

        <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider pb-2 border-b border-slate-100">
          <i class="fas fa-bullhorn mr-1 text-primary"></i> Call To Action
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label for="cta_title" class="block text-sm font-medium text-slate-700 mb-1.5">Judul CTA <span class="text-red-500">*</span></label>
            <input type="text" id="cta_title" name="cta_title" value="{{ old('cta_title', $bkk->cta_title) }}" required
              class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
          </div>
          <div>
            <label for="cta_subtitle" class="block text-sm font-medium text-slate-700 mb-1.5">Deskripsi CTA <span class="text-red-500">*</span></label>
            <input type="text" id="cta_subtitle" name="cta_subtitle" value="{{ old('cta_subtitle', $bkk->cta_subtitle) }}" required
              class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
          </div>
        </div>

        <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
          <button type="submit" class="inline-flex items-center gap-2 bg-primary hover:bg-secondary text-white font-semibold px-6 py-3 rounded-xl transition-all hover:shadow-lg hover:shadow-primary/30">
            <i class="fas fa-save"></i> Simpan Perubahan
          </button>
        </div>
      </div>
    </div>

  </form>
</div>

<style>
  .tab-btn {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 8px 16px; border-radius: 10px;
    font-size: 13px; font-weight: 600;
    border: 1px solid #e2e8f0;
    background: #fff; color: #64748b;
    cursor: pointer; transition: all 0.2s;
  }
  .tab-btn:hover { border-color: #f97316; color: #f97316; background: #fff7ed; }
  .active-tab { background: #f97316 !important; color: #fff !important; border-color: #f97316 !important; }
</style>
@endsection

@section('scripts')
<script>
  // ─── Tab Switching ───────────────────────────────────────────────
  function switchTab(name) {
    document.querySelectorAll('.tab-panel').forEach(p => p.classList.add('hidden'));
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active-tab'));
    document.getElementById('panel-' + name).classList.remove('hidden');
    document.getElementById('tab-' + name).classList.add('active-tab');
  }

  // ─── Image Preview ───────────────────────────────────────────────
  function previewImg(input, previewId, labelId) {
    const file = input.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = e => {
        document.getElementById(previewId).src = e.target.result;
        if (labelId) document.getElementById(labelId).textContent = file.name;
      };
      reader.readAsDataURL(file);
    }
  }

  function previewMitraLogo(input) {
    const file = input.files[0];
    if (!file) return;
    const row = input.closest('.mitra-row');
    const reader = new FileReader();
    reader.onload = e => {
      // Replace icon with img
      const container = row.querySelector('.w-14');
      container.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-contain">`;
    };
    reader.readAsDataURL(file);
  }

  // ─── Remove Row ──────────────────────────────────────────────────
  function removeRow(btn, containerId, minRows) {
    const container = document.getElementById(containerId);
    const rows = container.querySelectorAll('[class*="-row"]');
    if (rows.length <= minRows) {
      alert('Minimal harus ada ' + minRows + ' item.');
      return;
    }
    btn.closest('[class*="-row"]').remove();
    reindexAll();
  }

  // ─── Add Statistik ───────────────────────────────────────────────
  function addStatistik() {
    const container = document.getElementById('statistik-container');
    const index = container.querySelectorAll('.statistik-row').length;
    const div = document.createElement('div');
    div.className = 'statistik-row flex items-center gap-3 p-3 bg-slate-50 rounded-xl border border-slate-100';
    div.innerHTML = `
      <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0">
        <i class="fas fa-star text-primary text-sm"></i>
      </div>
      <div class="flex-1 grid grid-cols-3 gap-3">
        <input type="text" name="statistik[${index}][label]" placeholder="Label" required class="col-span-1 px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-xs">
        <input type="text" name="statistik[${index}][nilai]" placeholder="Nilai (850+)" required class="col-span-1 px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-xs">
        <input type="text" name="statistik[${index}][ikon]" placeholder="FA icon (fa-users)" required class="col-span-1 px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-xs">
      </div>
      <button type="button" onclick="removeRow(this,'statistik-container',1)" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition">
        <i class="fas fa-trash text-sm"></i>
      </button>`;
    container.appendChild(div);
  }

  // ─── Add Layanan ─────────────────────────────────────────────────
  function addLayanan() {
    const container = document.getElementById('layanan-container');
    const index = container.querySelectorAll('.layanan-row').length;
    const div = document.createElement('div');
    div.className = 'layanan-row p-4 bg-slate-50 rounded-xl border border-slate-100 relative';
    div.innerHTML = `
      <button type="button" onclick="removeRow(this,'layanan-container',1)" class="absolute top-2 right-2 p-1.5 text-red-500 hover:bg-red-100 rounded-lg transition">
        <i class="fas fa-trash text-xs"></i>
      </button>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
        <input type="text" name="layanan[${index}][judul]" placeholder="Judul layanan" required class="px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
        <input type="text" name="layanan[${index}][ikon]" placeholder="FA icon (fa-briefcase)" required class="px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
        <textarea name="layanan[${index}][deskripsi]" rows="2" placeholder="Deskripsi layanan..." required class="md:col-span-3 w-full px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm resize-none"></textarea>
      </div>`;
    container.appendChild(div);
  }

  // ─── Add Mitra ───────────────────────────────────────────────────
  function addMitra() {
    const container = document.getElementById('mitra-container');
    const index = container.querySelectorAll('.mitra-row').length;
    const div = document.createElement('div');
    div.className = 'mitra-row p-4 bg-slate-50 rounded-xl border border-slate-100 relative flex items-center gap-4';
    div.innerHTML = `
      <button type="button" onclick="removeRow(this,'mitra-container',1)" class="absolute top-2 right-2 p-1.5 text-red-500 hover:bg-red-100 rounded-lg transition z-10">
        <i class="fas fa-trash text-xs"></i>
      </button>
      <div class="w-14 h-14 rounded-xl overflow-hidden border border-slate-200 bg-white flex items-center justify-center flex-shrink-0">
        <i class="fas fa-building text-slate-300 text-xl"></i>
      </div>
      <div class="flex-1 space-y-2">
        <input type="hidden" name="mitra_perusahaan[${index}][existing]" value="">
        <input type="text" name="mitra_perusahaan[${index}][nama]" placeholder="Nama Perusahaan" required class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
        <label class="cursor-pointer inline-flex items-center gap-1.5 text-xs text-slate-500 hover:text-primary font-medium">
          <i class="fas fa-upload"></i> Upload Logo
          <input type="file" name="mitra_perusahaan[${index}][logo]" accept="image/*" class="hidden mitra-logo-input" onchange="previewMitraLogo(this)">
        </label>
      </div>`;
    container.appendChild(div);
  }

  // ─── Reindex all input names after removal ────────────────────────
  function reindexAll() {
    ['statistik', 'layanan'].forEach(key => {
      const c = document.getElementById(key + '-container');
      if (!c) return;
      c.querySelectorAll('[class*="-row"]').forEach((row, i) => {
        row.querySelectorAll('input, textarea').forEach(el => {
          el.name = el.name.replace(/\[\d+\]/, `[${i}]`);
        });
      });
    });

    // Mitra reindex
    const mc = document.getElementById('mitra-container');
    if (mc) {
      mc.querySelectorAll('.mitra-row').forEach((row, i) => {
        row.querySelectorAll('input').forEach(el => {
          el.name = el.name.replace(/\[\d+\]/, `[${i}]`);
        });
      });
    }
  }
</script>
@endsection
