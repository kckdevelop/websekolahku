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
          <i class="fas fa-list-ol mr-1 text-primary"></i> 3. Alur Pendaftaran
        </h3>
        <div id="alur-container" class="space-y-4">
          @php
            $alurList = old('alur_pendaftaran', $spmbContent->alur_pendaftaran ?? []);
          @endphp
          @foreach ($alurList as $index => $step)
            <div class="alur-row p-4 bg-slate-50 rounded-xl border border-slate-100 flex items-start gap-4 relative">
              <button type="button" onclick="removeAlur(this)" class="absolute top-2 right-2 p-1 text-red-500 hover:text-red-700 bg-red-55/20 hover:bg-red-100 rounded-lg transition-colors" title="Hapus Tahapan">
                <i class="fas fa-trash-alt text-xs"></i>
              </button>
              <span class="alur-number w-8 h-8 rounded-full bg-primary text-white font-bold flex items-center justify-center flex-shrink-0">{{ $index + 1 }}</span>
              <div class="flex-1 grid grid-cols-1 md:grid-cols-3 gap-4 mt-2 md:mt-0">
                <div class="md:col-span-1">
                  <label class="block text-xs font-semibold text-slate-600 mb-1">Judul Tahapan</label>
                  <input type="text" name="alur_pendaftaran[{{ $index }}][judul]" value="{{ $step['judul'] ?? '' }}" required
                    class="alur-judul w-full px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-xs">
                </div>
                <div class="md:col-span-2">
                  <label class="block text-xs font-semibold text-slate-600 mb-1">Deskripsi Singkat</label>
                  <input type="text" name="alur_pendaftaran[{{ $index }}][deskripsi]" value="{{ $step['deskripsi'] ?? '' }}" required
                    class="alur-desc w-full px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-xs">
                </div>
              </div>
            </div>
          @endforeach
        </div>
        <button type="button" onclick="addAlur()" class="mt-4 inline-flex items-center gap-1 text-xs text-primary hover:text-secondary font-semibold bg-orange-50 hover:bg-orange-100 px-4 py-2.5 rounded-xl transition-colors">
          <i class="fas fa-plus"></i> Tambah Tahapan Baru
        </button>
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

{{-- Confirmation Delete Modal --}}
<div id="confirm-modal" class="fixed inset-0 z-[9999] flex items-center justify-center hidden">
  {{-- Backdrop --}}
  <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeConfirmModal()"></div>
  {{-- Modal Box --}}
  <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm mx-4 p-6 transform transition-all duration-200" id="confirm-modal-box">
    <div class="flex flex-col items-center text-center">
      <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center mb-4">
        <i class="fas fa-trash-alt text-red-500 text-xl"></i>
      </div>
      <h3 class="text-slate-800 font-bold text-lg mb-1" id="confirm-modal-title">Hapus Item?</h3>
      <p class="text-slate-500 text-sm mb-6" id="confirm-modal-desc">Tindakan ini tidak dapat dibatalkan.</p>
      <div class="flex gap-3 w-full">
        <button type="button" onclick="closeConfirmModal()" class="flex-1 py-2.5 px-4 rounded-xl border border-slate-200 text-slate-700 font-semibold text-sm hover:bg-slate-50 transition-colors">
          Batal
        </button>
        <button type="button" id="confirm-modal-action" class="flex-1 py-2.5 px-4 rounded-xl bg-red-500 hover:bg-red-600 text-white font-semibold text-sm transition-colors">
          <i class="fas fa-trash-alt mr-1"></i> Hapus
        </button>
      </div>
    </div>
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
    const label = row.querySelector('.photo-label')?.textContent || 'foto ini';
    openConfirmModal(
      'Hapus Foto?',
      `${label} akan dihapus dari galeri dokumentasi SPMB.`,
      () => {
        row.remove();
        reindexPhotos();
      }
    );
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

  function addAlur() {
    const container = document.getElementById('alur-container');
    const index = container.querySelectorAll('.alur-row').length;
    const newRow = document.createElement('div');
    newRow.className = 'alur-row p-4 bg-slate-50 rounded-xl border border-slate-100 flex items-start gap-4 relative';
    newRow.innerHTML = `
      <button type="button" onclick="removeAlur(this)" class="absolute top-2 right-2 p-1 text-red-500 hover:text-red-700 bg-red-55/20 hover:bg-red-100 rounded-lg transition-colors" title="Hapus Tahapan">
        <i class="fas fa-trash-alt text-xs"></i>
      </button>
      <span class="alur-number w-8 h-8 rounded-full bg-primary text-white font-bold flex items-center justify-center flex-shrink-0">\${index + 1}</span>
      <div class="flex-1 grid grid-cols-1 md:grid-cols-3 gap-4 mt-2 md:mt-0">
        <div class="md:col-span-1">
          <label class="block text-xs font-semibold text-slate-600 mb-1">Judul Tahapan</label>
          <input type="text" name="alur_pendaftaran[\${index}][judul]" value="" required
            class="alur-judul w-full px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-xs">
        </div>
        <div class="md:col-span-2">
          <label class="block text-xs font-semibold text-slate-600 mb-1">Deskripsi Singkat</label>
          <input type="text" name="alur_pendaftaran[\${index}][deskripsi]" value="" required
            class="alur-desc w-full px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-xs">
        </div>
      </div>
    `;
    container.appendChild(newRow);
  }

  // ─── Confirm Modal ───────────────────────────────────────────────
  let _pendingDeleteFn = null;

  function openConfirmModal(title, desc, onConfirm) {
    _pendingDeleteFn = onConfirm;
    document.getElementById('confirm-modal-title').textContent = title;
    document.getElementById('confirm-modal-desc').textContent = desc;
    const modal = document.getElementById('confirm-modal');
    modal.classList.remove('hidden');
    // Animate in
    const box = document.getElementById('confirm-modal-box');
    box.style.opacity = '0';
    box.style.transform = 'scale(0.9)';
    requestAnimationFrame(() => {
      box.style.transition = 'opacity 0.2s ease, transform 0.2s ease';
      box.style.opacity = '1';
      box.style.transform = 'scale(1)';
    });
    document.getElementById('confirm-modal-action').onclick = () => {
      if (_pendingDeleteFn) _pendingDeleteFn();
      closeConfirmModal();
    };
  }

  function closeConfirmModal() {
    const modal = document.getElementById('confirm-modal');
    const box = document.getElementById('confirm-modal-box');
    box.style.transition = 'opacity 0.15s ease, transform 0.15s ease';
    box.style.opacity = '0';
    box.style.transform = 'scale(0.9)';
    setTimeout(() => {
      modal.classList.add('hidden');
      _pendingDeleteFn = null;
    }, 150);
  }

  // Esc key to close
  document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeConfirmModal();
  });

  // ─── Alur Pendaftaran ────────────────────────────────────────────
  function removeAlur(button) {
    const row = button.closest('.alur-row');
    const container = document.getElementById('alur-container');
    const judul = row.querySelector('.alur-judul')?.value || 'tahapan ini';
    if (container.querySelectorAll('.alur-row').length > 1) {
      openConfirmModal(
        'Hapus Tahapan?',
        `Tahapan "${judul}" akan dihapus dari daftar alur pendaftaran.`,
        () => {
          row.remove();
          reindexAlur();
        }
      );
    } else {
      openConfirmModal(
        'Kosongkan Tahapan?',
        'Ini adalah satu-satunya tahapan. Field akan dikosongkan.',
        () => {
          row.querySelector('.alur-judul').value = '';
          row.querySelector('.alur-desc').value = '';
        }
      );
    }
  }

  function reindexAlur() {
    const container = document.getElementById('alur-container');
    container.querySelectorAll('.alur-row').forEach((row, index) => {
      row.querySelector('.alur-number').textContent = index + 1;
      
      const judulInput = row.querySelector('.alur-judul');
      if (judulInput) judulInput.name = `alur_pendaftaran[${index}][judul]`;
      
      const descInput = row.querySelector('.alur-desc');
      if (descInput) descInput.name = `alur_pendaftaran[${index}][deskripsi]`;
    });
  }

  // ─── Persyaratan ────────────────────────────────────────────────
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
    const nilai = row.querySelector('input')?.value || 'persyaratan ini';
    if (container.querySelectorAll('.persyaratan-row').length > 1) {
      openConfirmModal(
        'Hapus Persyaratan?',
        `Persyaratan "${nilai}" akan dihapus dari daftar.`,
        () => row.remove()
      );
    } else {
      openConfirmModal(
        'Kosongkan Persyaratan?',
        'Ini adalah satu-satunya persyaratan. Field akan dikosongkan.',
        () => row.querySelector('input').value = ''
      );
    }
  }
</script>
@endsection
