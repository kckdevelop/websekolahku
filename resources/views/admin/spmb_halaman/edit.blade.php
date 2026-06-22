@extends('layouts.admin')
@section('title', 'Kelola Halaman SPMB')
@section('subtitle', 'Ubah data visual banner, kuota kelas, alur pendaftaran, persyaratan, dan galeri halaman SPMB')

@section('content')
<div class="max-w-4xl">
  <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <form method="POST" action="{{ route('admin.spmb-halaman.update') }}" enctype="multipart/form-data" class="p-6 space-y-8">
      @csrf
      @method('PUT')

      {{-- Section 1: Hero Banner --}}
      <div>
        <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider pb-2 border-b border-slate-100 mb-4">
          <i class="fas fa-image mr-1 text-primary"></i> 1. Banner Hero Halaman
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label for="hero_title" class="block text-sm font-medium text-slate-700 mb-1.5">Judul Banner <span class="text-red-500">*</span></label>
            <input type="text" id="hero_title" name="hero_title" value="{{ old('hero_title', $spmbContent->hero_title) }}" required
              class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
            @error('hero_title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          </div>

          <div>
            <label for="hero_subtitle" class="block text-sm font-medium text-slate-700 mb-1.5">Subjudul Banner <span class="text-red-500">*</span></label>
            <input type="text" id="hero_subtitle" name="hero_subtitle" value="{{ old('hero_subtitle', $spmbContent->hero_subtitle) }}" required
              class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
            @error('hero_subtitle') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          </div>

          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Gambar Banner (Hero)</label>
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
              <div id="hero-preview-container" class="w-64 h-32 rounded-xl overflow-hidden border border-slate-200 bg-slate-50 flex items-center justify-center">
                <img id="hero-preview" src="{{ $spmbContent->hero_gambar_src }}" alt="Preview" class="w-full h-full object-cover">
              </div>
              <div class="space-y-2">
                <label class="cursor-pointer inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 hover:border-primary hover:bg-orange-50 transition-all text-sm text-slate-600 hover:text-primary font-medium">
                  <i class="fas fa-cloud-upload-alt text-base"></i>
                  <span id="hero-label">Ganti Banner</span>
                  <input type="file" id="hero_gambar" name="hero_gambar" accept="image/*" class="hidden" onchange="previewHeroImage(this)">
                </label>
                <p class="text-slate-400 text-xs">Rekomendasi rasio banner 1920x600 px. Maks: 3MB</p>
              </div>
            </div>
            @error('hero_gambar') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          </div>
        </div>
      </div>

      {{-- Section 2: Daya Tampung / Kuota --}}
      <div>
        <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider pb-2 border-b border-slate-100 mb-4">
          <i class="fas fa-chart-pie mr-1 text-primary"></i> 2. Kuota Program Keahlian
        </h3>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
          <div>
            <label for="kuota_tkro" class="block text-xs font-semibold text-slate-600 mb-1">TKRO / TKR <span class="text-red-500">*</span></label>
            <input type="text" id="kuota_tkro" name="kuota_tkro" value="{{ old('kuota_tkro', $spmbContent->kuota_tkro) }}" required
              class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
            @error('kuota_tkro') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          </div>
          <div>
            <label for="kuota_tbsm" class="block text-xs font-semibold text-slate-600 mb-1">TBSM <span class="text-red-500">*</span></label>
            <input type="text" id="kuota_tbsm" name="kuota_tbsm" value="{{ old('kuota_tbsm', $spmbContent->kuota_tbsm) }}" required
              class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
            @error('kuota_tbsm') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          </div>
          <div>
            <label for="kuota_tpm" class="block text-xs font-semibold text-slate-600 mb-1">TPM <span class="text-red-500">*</span></label>
            <input type="text" id="kuota_tpm" name="kuota_tpm" value="{{ old('kuota_tpm', $spmbContent->kuota_tpm) }}" required
              class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
            @error('kuota_tpm') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          </div>
          <div>
            <label for="kuota_tav" class="block text-xs font-semibold text-slate-600 mb-1">TAV <span class="text-red-500">*</span></label>
            <input type="text" id="kuota_tav" name="kuota_tav" value="{{ old('kuota_tav', $spmbContent->kuota_tav) }}" required
              class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
            @error('kuota_tav') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          </div>
          <div>
            <label for="kuota_rpl" class="block text-xs font-semibold text-slate-600 mb-1">RPL <span class="text-red-500">*</span></label>
            <input type="text" id="kuota_rpl" name="kuota_rpl" value="{{ old('kuota_rpl', $spmbContent->kuota_rpl) }}" required
              class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
            @error('kuota_rpl') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          </div>
        </div>
      </div>

      {{-- Section 3: Alur Pendaftaran --}}
      <div>
        <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider pb-2 border-b border-slate-100 mb-4">
          <i class="fas fa-list-ol mr-1 text-primary"></i> 3. Alur Pendaftaran (5 Tahapan)
        </h3>
        <div class="space-y-4">
          @for ($i = 0; $i < 5; $i++)
            <div class="p-4 bg-slate-50 rounded-xl border border-slate-100 flex items-start gap-4">
              <span class="w-8 h-8 rounded-full bg-primary text-white font-bold flex items-center justify-center flex-shrink-0">{{ $i + 1 }}</span>
              <div class="flex-1 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-1">
                  <label class="block text-xs font-semibold text-slate-600 mb-1">Judul Tahapan</label>
                  <input type="text" name="alur_pendaftaran[{{ $i }}][judul]" value="{{ old("alur_pendaftaran.$i.judul", $spmbContent->alur_pendaftaran[$i]['judul'] ?? '') }}" required
                    class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-xs">
                </div>
                <div class="md:col-span-2">
                  <label class="block text-xs font-semibold text-slate-600 mb-1">Deskripsi Singkat</label>
                  <input type="text" name="alur_pendaftaran[{{ $i }}][deskripsi]" value="{{ old("alur_pendaftaran.$i.deskripsi", $spmbContent->alur_pendaftaran[$i]['deskripsi'] ?? '') }}" required
                    class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-xs">
                </div>
              </div>
            </div>
          @endfor
        </div>
      </div>

      {{-- Section 4: Persyaratan --}}
      <div>
        <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider pb-2 border-b border-slate-100 mb-4">
          <i class="fas fa-list-check mr-1 text-primary"></i> 4. Persyaratan Pendaftaran
        </h3>
        <div class="space-y-3">
          <div id="persyaratan-container" class="space-y-2">
            @php
              $persyaratan = old('persyaratan', $spmbContent->persyaratan ?? []);
            @endphp
            @forelse($persyaratan as $index => $item)
              <div class="flex items-center gap-2 persyaratan-row">
                <input type="text" name="persyaratan[]" value="{{ $item }}" required
                  class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm"
                  placeholder="Contoh: Mengisi formulir pendaftaran...">
                <button type="button" onclick="removePersyaratan(this)" class="p-2.5 text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 rounded-xl transition-colors">
                  <i class="fas fa-trash-alt"></i>
                </button>
              </div>
            @empty
              <div class="flex items-center gap-2 persyaratan-row">
                <input type="text" name="persyaratan[]" value="" required
                  class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm"
                  placeholder="Contoh: Mengisi formulir pendaftaran...">
                <button type="button" onclick="removePersyaratan(this)" class="p-2.5 text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 rounded-xl transition-colors">
                  <i class="fas fa-trash-alt"></i>
                </button>
              </div>
            @endforelse
          </div>
          <button type="button" onclick="addPersyaratan()" class="mt-2 inline-flex items-center gap-1 text-xs text-primary hover:text-secondary font-semibold bg-orange-50 hover:bg-orange-100 px-3 py-2 rounded-lg transition-colors">
            <i class="fas fa-plus"></i> Tambah Persyaratan
          </button>
        </div>
      </div>

      {{-- Section 5: Galeri Dokumentasi --}}
      <div>
        <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider pb-2 border-b border-slate-100 mb-4">
          <i class="fas fa-images mr-1 text-primary"></i> 5. Dokumentasi Kegiatan SPMB
        </h3>
        <div id="photos-container" class="grid grid-cols-1 md:grid-cols-2 gap-6">
          @php
            $galeri = old('foto_galeri', $spmbContent->foto_galeri ?? []);
          @endphp
          @foreach($galeri as $index => $photo)
            @php
              $imgSrc = !empty($photo['gambar']) ? (Str::startsWith($photo['gambar'], 'http') ? $photo['gambar'] : asset('storage/' . $photo['gambar'])) : 'https://picsum.photos/seed/spmb'.($index+1).'/400/300';
            @endphp
            <div class="photo-row p-4 bg-slate-50 rounded-xl border border-slate-100 space-y-3 relative">
              <button type="button" onclick="removePhoto(this)" class="absolute top-2 right-2 p-1.5 text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 rounded-lg transition-colors z-10" title="Hapus Foto">
                <i class="fas fa-trash-alt text-sm"></i>
              </button>
              <span class="photo-label text-xs font-bold text-slate-500 uppercase">Foto #{{ $index + 1 }}</span>
              <div class="w-full h-40 rounded-lg overflow-hidden border border-slate-200 bg-white flex items-center justify-center relative">
                <img class="photo-preview w-full h-full object-cover" src="{{ $imgSrc }}" alt="Preview">
              </div>
              <div class="space-y-2">
                @if(!empty($photo['gambar']))
                  <input type="hidden" name="foto_galeri[{{ $index }}][existing]" value="{{ $photo['gambar'] }}">
                @endif
                <label class="cursor-pointer inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 hover:border-primary hover:bg-orange-50 transition text-xs text-slate-500 hover:text-primary">
                  <i class="fas fa-upload"></i>
                  <span>Upload Foto</span>
                  <input type="file" name="foto_galeri[{{ $index }}][file]" accept="image/*" class="hidden" onchange="previewGaleriPhoto(this)">
                </label>
                <input type="text" name="foto_galeri[{{ $index }}][deskripsi]" value="{{ $photo['deskripsi'] ?? '' }}" required
                  class="photo-desc w-full px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-xs"
                  placeholder="Keterangan foto...">
              </div>
            </div>
          @endforeach
        </div>
        <button type="button" onclick="addPhoto()" class="mt-4 inline-flex items-center gap-1 text-xs text-primary hover:text-secondary font-semibold bg-orange-50 hover:bg-orange-100 px-4 py-2.5 rounded-xl transition-colors">
          <i class="fas fa-plus"></i> Tambah Foto Baru
        </button>
      </div>

      {{-- Section 6: Call To Action --}}
      <div>
        <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider pb-2 border-b border-slate-100 mb-4">
          <i class="fas fa-bullhorn mr-1 text-primary"></i> 6. Call To Action (Siap Bergabung?)
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label for="cta_title" class="block text-sm font-medium text-slate-700 mb-1.5">Judul CTA <span class="text-red-500">*</span></label>
            <input type="text" id="cta_title" name="cta_title" value="{{ old('cta_title', $spmbContent->cta_title) }}" required
              class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
            @error('cta_title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          </div>

          <div>
            <label for="cta_subtitle" class="block text-sm font-medium text-slate-700 mb-1.5">Subjudul / Deskripsi CTA <span class="text-red-500">*</span></label>
            <input type="text" id="cta_subtitle" name="cta_subtitle" value="{{ old('cta_subtitle', $spmbContent->cta_subtitle) }}" required
              class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
            @error('cta_subtitle') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          </div>
        </div>
      </div>

      {{-- Action Buttons --}}
      <div class="flex items-center gap-3 pt-6 border-t border-slate-100">
        <button type="submit"
          class="inline-flex items-center gap-2 bg-primary hover:bg-secondary text-white font-semibold px-6 py-3 rounded-xl transition-all hover:shadow-lg hover:shadow-primary/30">
          <i class="fas fa-save"></i> Simpan Konten SPMB
        </button>
        <a href="{{ route('admin.dashboard') }}"
          class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-6 py-3 rounded-xl transition-all">
          Batal
        </a>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script>
  function previewHeroImage(input) {
    const file = input.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = (e) => {
        document.getElementById('hero-preview').src = e.target.result;
        document.getElementById('hero-label').textContent = file.name;
      };
      reader.readAsDataURL(file);
    }
  }

  function previewGaleriPhoto(input) {
    const file = input.files[0];
    const row = input.closest('.photo-row');
    const preview = row.querySelector('.photo-preview');
    if (file) {
      const reader = new FileReader();
      reader.onload = (e) => {
        preview.src = e.target.result;
      };
      reader.readAsDataURL(file);
    }
  }

  function addPhoto() {
    const container = document.getElementById('photos-container');
    const index = container.querySelectorAll('.photo-row').length;
    const newRow = document.createElement('div');
    newRow.className = 'photo-row p-4 bg-slate-50 rounded-xl border border-slate-100 space-y-3 relative';
    newRow.innerHTML = `
      <button type="button" onclick="removePhoto(this)" class="absolute top-2 right-2 p-1.5 text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 rounded-lg transition-colors z-10" title="Hapus Foto">
        <i class="fas fa-trash-alt text-sm"></i>
      </button>
      <span class="photo-label text-xs font-bold text-slate-500 uppercase">Foto #\${index + 1}</span>
      <div class="w-full h-40 rounded-lg overflow-hidden border border-slate-200 bg-white flex items-center justify-center relative">
        <img class="photo-preview w-full h-full object-cover" src="https://picsum.photos/seed/spmb\${index + 1}/400/300" alt="Preview">
      </div>
      <div class="space-y-2">
        <label class="cursor-pointer inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 hover:border-primary hover:bg-orange-50 transition text-xs text-slate-500 hover:text-primary">
          <i class="fas fa-upload"></i>
          <span>Upload Foto</span>
          <input type="file" name="foto_galeri[\${index}][file]" accept="image/*" class="hidden" onchange="previewGaleriPhoto(this)">
        </label>
        <input type="text" name="foto_galeri[\${index}][deskripsi]" value="" required
          class="photo-desc w-full px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-xs"
          placeholder="Keterangan foto...">
      </div>
    `;
    container.appendChild(newRow);
    reindexPhotos();
  }

  function removePhoto(button) {
    const row = button.closest('.photo-row');
    row.remove();
    reindexPhotos();
  }

  function reindexPhotos() {
    const container = document.getElementById('photos-container');
    container.querySelectorAll('.photo-row').forEach((row, index) => {
      row.querySelector('.photo-label').textContent = `Foto #${index + 1}`;
      
      const fileInput = row.querySelector('input[type="file"]');
      if (fileInput) fileInput.name = `foto_galeri[\${index}][file]`;
      
      const descInput = row.querySelector('.photo-desc');
      if (descInput) descInput.name = `foto_galeri[\${index}][deskripsi]`;
      
      const existingInput = row.querySelector('input[type="hidden"]');
      if (existingInput) existingInput.name = `foto_galeri[\${index}][existing]`;
    });
  }

  function addPersyaratan() {
    const container = document.getElementById('persyaratan-container');
    const newRow = document.createElement('div');
    newRow.className = 'flex items-center gap-2 persyaratan-row';
    newRow.innerHTML = `
      <input type="text" name="persyaratan[]" value="" required
        class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm"
        placeholder="Contoh: Mengisi formulir pendaftaran...">
      <button type="button" onclick="removePersyaratan(this)" class="p-2.5 text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 rounded-xl transition-colors">
        <i class="fas fa-trash-alt"></i>
      </button>
    `;
    container.appendChild(newRow);
  }

  function removePersyaratan(button) {
    const row = button.closest('.persyaratan-row');
    const container = document.getElementById('persyaratan-container');
    if (container.querySelectorAll('.persyaratan-row').length > 1) {
      row.remove();
    } else {
      row.querySelector('input').value = '';
    }
  }
</script>
@endsection
