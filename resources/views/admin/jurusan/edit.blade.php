@extends('layouts.admin')
@section('title')
<span class="inline-flex items-center gap-2">
  <a href="{{ route('admin.jurusan.index') }}" class="text-slate-400 hover:text-slate-600 transition-colors mr-1">
    <i class="fas fa-arrow-left text-base"></i>
  </a>
  <span>Edit Halaman Jurusan: {{ $jurusan->nama_jurusan }}</span>
</span>
@endsection
@section('subtitle', 'Ubah data visual banner dan narasi profil kompetensi keahlian')

@section('content')
<div class="max-w-4xl">
  <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <form method="POST" action="{{ route('admin.jurusan.update', $jurusan) }}" enctype="multipart/form-data" class="p-6 space-y-6">
      @csrf
      @method('PUT')

      <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider pb-2 border-b border-slate-100"><i class="fas fa-image mr-1 text-primary"></i> Banner & Header Halaman</h3>
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Nama Jurusan --}}
        <div>
          <label for="nama_jurusan" class="block text-sm font-medium text-slate-700 mb-1.5">Nama Kompetensi Keahlian <span class="text-red-500">*</span></label>
          <input type="text" id="nama_jurusan" name="nama_jurusan" value="{{ old('nama_jurusan', $jurusan->nama_jurusan) }}" required
            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
          @error('nama_jurusan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Slug (readonly) --}}
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1.5">Slug URL <span class="text-xs text-slate-400 font-normal">(tidak bisa diubah)</span></label>
          <div class="flex items-center gap-2 px-4 py-3 rounded-xl border border-slate-100 bg-slate-50 text-sm text-slate-500">
            <span class="text-slate-400">/jurusan/</span>
            <span class="font-mono font-semibold text-slate-700">{{ $jurusan->slug }}</span>
          </div>
        </div>

        {{-- Hero Judul --}}
        <div>
          <label for="hero_judul" class="block text-sm font-medium text-slate-700 mb-1.5">Judul Banner (Hero) <span class="text-red-500">*</span></label>
          <input type="text" id="hero_judul" name="hero_judul" value="{{ old('hero_judul', $jurusan->hero_judul) }}" required
            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
          @error('hero_judul') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Hero Subjudul --}}
        <div>
          <label for="hero_subjudul" class="block text-sm font-medium text-slate-700 mb-1.5">Subjudul Banner (Hero)</label>
          <input type="text" id="hero_subjudul" name="hero_subjudul" value="{{ old('hero_subjudul', $jurusan->hero_subjudul) }}"
            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
          @error('hero_subjudul') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Icon & Urutan & Aktif --}}
        <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-4">
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Ikon Font Awesome</label>
            <div class="flex items-center gap-2">
              <div id="icon-preview" class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center text-primary flex-shrink-0">
                <i class="{{ old('icon', $jurusan->icon ?? 'fas fa-graduation-cap') }}"></i>
              </div>
              <input type="text" name="icon" id="icon-input" value="{{ old('icon', $jurusan->icon ?? 'fas fa-graduation-cap') }}"
                     placeholder="fas fa-graduation-cap"
                     class="flex-1 px-3 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm font-mono">
            </div>
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Urutan Tampil</label>
            <input type="number" name="urutan" value="{{ old('urutan', $jurusan->urutan ?? 0) }}" min="0"
                   class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Status</label>
            <label class="flex items-center gap-3 cursor-pointer bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 hover:border-primary/50 transition">
              <input type="checkbox" name="aktif" value="1" {{ old('aktif', $jurusan->aktif) ? 'checked' : '' }}
                     class="w-4 h-4 text-primary rounded focus:ring-primary/40">
              <span class="text-sm text-slate-700">Aktif & tampil di website</span>
            </label>
          </div>
        </div>

        {{-- Hero Gambar --}}
        <div class="md:col-span-2">
          <label class="block text-sm font-medium text-slate-700 mb-1.5">Gambar Banner (Hero)</label>
          <div class="flex items-center gap-4">
            <div id="preview-container" class="w-40 h-24 rounded-xl overflow-hidden border border-slate-200">
              @if($jurusan->hero_gambar)
                <img id="image-preview" src="{{ asset('storage/' . $jurusan->hero_gambar) }}" alt="Preview" class="w-full h-full object-cover">
              @else
                <img id="image-preview" src="https://picsum.photos/seed/tkr-hero/1920/600" alt="Preview" class="w-full h-full object-cover">
              @endif
            </div>
            <label class="cursor-pointer flex items-center gap-2 px-4 py-3 rounded-xl border-2 border-dashed border-slate-200 hover:border-primary hover:bg-orange-50 transition-all text-sm text-slate-500 hover:text-primary">
              <i class="fas fa-cloud-upload-alt text-lg"></i>
              <span id="file-label">Ganti Gambar Banner</span>
              <input type="file" id="hero_gambar" name="hero_gambar" accept="image/*" class="hidden" onchange="previewImage(this)">
            </label>
          </div>
          @error('hero_gambar') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
      </div>

      <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider pb-2 border-b border-slate-100 pt-6"><i class="fas fa-align-left mr-1 text-primary"></i> Deskripsi & Profil Jurusan</h3>

      <div class="space-y-6">
        {{-- Deskripsi 1 --}}
        <div>
          <label for="deskripsi_1" class="block text-sm font-medium text-slate-700 mb-1.5">Deskripsi Paragraf 1 <span class="text-red-500">*</span></label>
          <textarea id="deskripsi_1" name="deskripsi_1" rows="5" required
            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">{{ old('deskripsi_1', $jurusan->deskripsi_1) }}</textarea>
          @error('deskripsi_1') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Deskripsi 2 --}}
        <div>
          <label for="deskripsi_2" class="block text-sm font-medium text-slate-700 mb-1.5">Deskripsi Paragraf 2</label>
          <textarea id="deskripsi_2" name="deskripsi_2" rows="5"
            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">{{ old('deskripsi_2', $jurusan->deskripsi_2) }}</textarea>
          @error('deskripsi_2') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
      </div>

      <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider pb-2 border-b border-slate-100 pt-6"><i class="fas fa-check-double mr-1 text-primary"></i> Poin Unggulan</h3>

      <div class="space-y-3">
        <label class="block text-sm font-medium text-slate-700">Daftar Poin Kelebihan / Fasilitas Utama</label>
        <div id="points-container" class="space-y-2.5">
          @php
            $points = old('poin_unggulan', $jurusan->poin_unggulan ?? []);
          @endphp
          @forelse($points as $point)
            <div class="flex items-center gap-2 point-row">
              <input type="text" name="poin_unggulan[]" value="{{ $point }}"
                class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm"
                placeholder="Contoh: Praktik langsung di bengkel sekolah...">
              <button type="button" onclick="removePoint(this)" class="p-2.5 text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 rounded-xl transition-colors">
                <i class="fas fa-trash-alt"></i>
              </button>
            </div>
          @empty
            <div class="flex items-center gap-2 point-row">
              <input type="text" name="poin_unggulan[]" value=""
                class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm"
                placeholder="Contoh: Praktik langsung di bengkel sekolah...">
              <button type="button" onclick="removePoint(this)" class="p-2.5 text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 rounded-xl transition-colors">
                <i class="fas fa-trash-alt"></i>
              </button>
            </div>
          @endforelse
        </div>
        <button type="button" onclick="addPoint()" class="mt-2 inline-flex items-center gap-1 text-xs text-primary hover:text-secondary font-semibold bg-orange-50 hover:bg-orange-100 px-3 py-2 rounded-lg transition-colors">
          <i class="fas fa-plus"></i> Tambah Poin Baru
        </button>
      </div>

      <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider pb-2 border-b border-slate-100 pt-6"><i class="fas fa-images mr-1 text-primary"></i> Galeri Kegiatan Jurusan</h3>

      <div class="space-y-4">
        <label class="block text-sm font-medium text-slate-700">Daftar Foto Kegiatan & Deskripsi</label>
        <div id="photos-container" class="space-y-3.5">
          @php
            $photos = old('foto_kegiatan', $jurusan->foto_kegiatan ?? []);
          @endphp
          @foreach($photos as $index => $photo)
            <div class="photo-row grid grid-cols-1 md:grid-cols-12 gap-4 items-center bg-slate-50 dark:bg-slate-800/40 p-4 rounded-xl border border-slate-100 dark:border-slate-700/50">
              <div class="md:col-span-3">
                <div class="w-full h-24 rounded-lg overflow-hidden border border-slate-200 bg-white flex items-center justify-center">
                  @if(!empty($photo['gambar']))
                    <img class="photo-preview w-full h-full object-cover" src="{{ Str::startsWith($photo['gambar'], 'http') ? $photo['gambar'] : asset('storage/' . $photo['gambar']) }}" alt="Preview">
                  @else
                    <img class="photo-preview w-full h-full object-cover hidden" src="" alt="Preview">
                    <span class="photo-placeholder text-slate-400 text-xs"><i class="fas fa-image text-lg mb-1 block text-center"></i>Pilih Foto</span>
                  @endif
                </div>
              </div>
              <div class="md:col-span-8 space-y-2">
                @if(!empty($photo['gambar']))
                  <input type="hidden" name="foto_kegiatan[{{ $index }}][existing]" value="{{ $photo['gambar'] }}">
                @endif
                <label class="cursor-pointer inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 hover:border-primary hover:bg-orange-50 transition-all text-xs text-slate-500 hover:text-primary">
                  <i class="fas fa-upload"></i>
                  <span>Ganti File</span>
                  <input type="file" name="foto_kegiatan[{{ $index }}][file]" accept="image/*" class="hidden" onchange="previewPhoto(this)">
                </label>
                <input type="text" name="foto_kegiatan[{{ $index }}][deskripsi]" value="{{ $photo['deskripsi'] ?? '' }}"
                  class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-xs"
                  placeholder="Tulis deskripsi/caption foto kegiatan...">
              </div>
              <div class="md:col-span-1 text-right">
                <button type="button" onclick="removePhoto(this)" class="p-2 text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
                  <i class="fas fa-trash-alt"></i>
                </button>
              </div>
            </div>
          @endforeach
        </div>
        <button type="button" onclick="addPhoto()" class="mt-2 inline-flex items-center gap-1 text-xs text-primary hover:text-secondary font-semibold bg-orange-50 hover:bg-orange-100 px-3 py-2 rounded-lg transition-colors">
          <i class="fas fa-plus"></i> Tambah Foto Baru
        </button>
      </div>

      {{-- Buttons --}}
      <div class="flex items-center gap-3 border-t border-slate-100 pt-6">
        <button type="submit"
          class="inline-flex items-center gap-2 bg-primary hover:bg-secondary text-white font-semibold px-6 py-3 rounded-xl transition-all hover:shadow-lg hover:shadow-primary/30">
          <i class="fas fa-save"></i> Perbarui Halaman
        </button>
        <a href="{{ route('admin.jurusan.index') }}"
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
  function previewImage(input) {
    const file = input.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = (e) => {
        document.getElementById('image-preview').src = e.target.result;
        document.getElementById('file-label').textContent = file.name;
      };
      reader.readAsDataURL(file);
    }
  }

  function addPoint() {
    const container = document.getElementById('points-container');
    const newRow = document.createElement('div');
    newRow.className = 'flex items-center gap-2 point-row';
    newRow.innerHTML = `
      <input type="text" name="poin_unggulan[]" value=""
        class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm"
        placeholder="Contoh: Praktik langsung di bengkel sekolah...">
      <button type="button" onclick="removePoint(this)" class="p-2.5 text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 rounded-xl transition-colors">
        <i class="fas fa-trash-alt"></i>
      </button>
    `;
    container.appendChild(newRow);
  }

  function removePoint(button) {
    const row = button.closest('.point-row');
    const container = document.getElementById('points-container');
    if (container.querySelectorAll('.point-row').length > 1) {
      row.remove();
    } else {
      row.querySelector('input').value = '';
    }
  }

  function addPhoto() {
    const container = document.getElementById('photos-container');
    const index = container.querySelectorAll('.photo-row').length;
    const newRow = document.createElement('div');
    newRow.className = 'photo-row grid grid-cols-1 md:grid-cols-12 gap-4 items-center bg-slate-50 dark:bg-slate-800/40 p-4 rounded-xl border border-slate-100 dark:border-slate-700/50';
    newRow.innerHTML = `
      <div class="md:col-span-3">
        <div class="w-full h-24 rounded-lg overflow-hidden border border-slate-200 bg-white flex items-center justify-center">
          <img class="photo-preview w-full h-full object-cover hidden" src="" alt="Preview">
          <span class="photo-placeholder text-slate-400 text-xs"><i class="fas fa-image text-lg mb-1 block text-center"></i>Pilih Foto</span>
        </div>
      </div>
      <div class="md:col-span-8 space-y-2">
        <label class="cursor-pointer inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 hover:border-primary hover:bg-orange-50 transition text-xs text-slate-500 hover:text-primary">
          <i class="fas fa-upload"></i>
          <span>Upload File</span>
          <input type="file" name="foto_kegiatan[${index}][file]" accept="image/*" class="hidden" onchange="previewPhoto(this)">
        </label>
        <input type="text" name="foto_kegiatan[${index}][deskripsi]" value=""
          class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-xs"
          placeholder="Tulis deskripsi/caption foto kegiatan...">
      </div>
      <div class="md:col-span-1 text-right">
        <button type="button" onclick="removePhoto(this)" class="p-2 text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
          <i class="fas fa-trash-alt"></i>
        </button>
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
      const fileInput = row.querySelector('input[type="file"]');
      if (fileInput) fileInput.name = `foto_kegiatan[${index}][file]`;
      
      const descInput = row.querySelector('input[type="text"]');
      if (descInput) descInput.name = `foto_kegiatan[${index}][deskripsi]`;
      
      const existingInput = row.querySelector('input[type="hidden"]');
      if (existingInput) existingInput.name = `foto_kegiatan[${index}][existing]`;
    });
  }

  function previewPhoto(input) {
    const file = input.files[0];
    const row = input.closest('.photo-row');
    const preview = row.querySelector('.photo-preview');
    const placeholder = row.querySelector('.photo-placeholder');
    
    if (file) {
      const reader = new FileReader();
      reader.onload = (e) => {
        preview.src = e.target.result;
        preview.classList.remove('hidden');
        if (placeholder) placeholder.classList.add('hidden');
      };
      reader.readAsDataURL(file);
    }
  }

  // Icon Preview Live
  const iconInput = document.getElementById('icon-input');
  if (iconInput) {
    iconInput.addEventListener('input', function() {
      const iconEl = document.querySelector('#icon-preview i');
      if (iconEl) iconEl.className = this.value || 'fas fa-graduation-cap';
    });
  }
</script>
@endsection
