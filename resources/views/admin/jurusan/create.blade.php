@extends('layouts.admin')
@section('title', 'Tambah Program Keahlian Baru')
@section('subtitle', 'Buat halaman program keahlian / jurusan baru')

@section('content')
<form action="{{ route('admin.jurusan.store') }}" method="POST" enctype="multipart/form-data">
  @csrf

  <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

    {{-- ==================== KOLOM KIRI ==================== --}}
    <div class="xl:col-span-2 space-y-6">

      {{-- Informasi Dasar --}}
      <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100">
          <h2 class="font-semibold text-slate-800 flex items-center gap-2"><i class="fas fa-info-circle text-primary"></i> Informasi Dasar</h2>
        </div>
        <div class="px-6 py-5 space-y-4">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-semibold text-slate-500 mb-1.5 uppercase tracking-wide">Nama Jurusan <span class="text-red-400">*</span></label>
              <input type="text" name="nama_jurusan" value="{{ old('nama_jurusan') }}"
                     placeholder="Contoh: Teknik Kendaraan Ringan"
                     class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition @error('nama_jurusan') border-red-400 @enderror">
              @error('nama_jurusan')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
              <label class="block text-xs font-semibold text-slate-500 mb-1.5 uppercase tracking-wide">Slug (URL) <span class="text-red-400">*</span></label>
              <div class="flex items-center gap-2 border border-slate-200 rounded-xl px-3.5 py-2.5 focus-within:ring-2 focus-within:ring-primary/30 focus-within:border-primary transition @error('slug') border-red-400 @enderror">
                <span class="text-slate-400 text-sm flex-shrink-0">/jurusan/</span>
                <input type="text" name="slug" id="slug-input" value="{{ old('slug') }}"
                       placeholder="tkr"
                       class="flex-1 text-sm outline-none font-mono">
              </div>
              @error('slug')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
              <p class="text-xs text-slate-400 mt-1">Huruf kecil, angka, tanda hubung. Contoh: <code class="bg-slate-100 px-1 rounded">teknik-kendaraan-ringan</code></p>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-semibold text-slate-500 mb-1.5 uppercase tracking-wide">Ikon Font Awesome</label>
              <div class="flex items-center gap-2">
                <div id="icon-preview" class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center text-primary flex-shrink-0">
                  <i class="fas fa-graduation-cap"></i>
                </div>
                <input type="text" name="icon" id="icon-input" value="{{ old('icon', 'fas fa-graduation-cap') }}"
                       placeholder="fas fa-graduation-cap"
                       class="flex-1 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition font-mono">
              </div>
              <p class="text-xs text-slate-400 mt-1">Cari ikon di <a href="https://fontawesome.com/icons" target="_blank" class="text-primary underline">fontawesome.com</a>. Contoh: <code class="bg-slate-100 px-1 rounded">fas fa-car</code></p>
            </div>
            <div>
              <label class="block text-xs font-semibold text-slate-500 mb-1.5 uppercase tracking-wide">Urutan Tampil <span class="text-red-400">*</span></label>
              <input type="number" name="urutan" value="{{ old('urutan', $nextUrutan) }}" min="0"
                     class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition">
              <p class="text-xs text-slate-400 mt-1">Angka terkecil tampil paling atas/pertama di navbar</p>
            </div>
          </div>

          {{-- Aktif Toggle --}}
          <div class="flex items-center gap-3 bg-slate-50 rounded-xl px-4 py-3">
            <input type="checkbox" name="aktif" id="aktif" value="1" {{ old('aktif', true) ? 'checked' : '' }}
                   class="w-4 h-4 text-primary rounded focus:ring-primary/40">
            <div>
              <label for="aktif" class="text-sm font-semibold text-slate-700 cursor-pointer">Aktif & tampil di website</label>
              <p class="text-xs text-slate-400">Jika dinonaktifkan, jurusan tidak muncul di menu dan halaman publik</p>
            </div>
          </div>
        </div>
      </div>

      {{-- Hero Section --}}
      <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100">
          <h2 class="font-semibold text-slate-800 flex items-center gap-2"><i class="fas fa-image text-primary"></i> Hero / Banner Halaman</h2>
        </div>
        <div class="px-6 py-5 space-y-4">
          <div>
            <label class="block text-xs font-semibold text-slate-500 mb-1.5 uppercase tracking-wide">Judul Hero <span class="text-red-400">*</span></label>
            <input type="text" name="hero_judul" value="{{ old('hero_judul') }}"
                   placeholder="Contoh: Teknik Kendaraan Ringan (TKR)"
                   class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition @error('hero_judul') border-red-400 @enderror">
            @error('hero_judul')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
          </div>
          <div>
            <label class="block text-xs font-semibold text-slate-500 mb-1.5 uppercase tracking-wide">Subjudul Hero</label>
            <input type="text" name="hero_subjudul" value="{{ old('hero_subjudul') }}"
                   placeholder="Contoh: Mencetak Teknisi Otomotif Profesional dan Siap Kerja"
                   class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition">
          </div>
          <div>
            <label class="block text-xs font-semibold text-slate-500 mb-1.5 uppercase tracking-wide">Foto Hero Banner</label>
            <div class="border-2 border-dashed border-slate-200 rounded-xl p-4 text-center hover:border-primary/50 transition cursor-pointer" onclick="document.getElementById('hero_gambar').click()">
              <div id="preview-container" class="hidden mb-3">
                <img id="image-preview" src="" class="max-h-40 mx-auto rounded-lg object-cover">
              </div>
              <div id="upload-placeholder">
                <i class="fas fa-cloud-upload-alt text-2xl text-slate-300 mb-2"></i>
                <p class="text-sm text-slate-400">Klik untuk upload foto hero</p>
                <p class="text-xs text-slate-300 mt-1">PNG, JPG, WebP — maks. 5MB</p>
              </div>
              <span id="file-label" class="text-xs text-primary font-medium hidden mt-2 block"></span>
            </div>
            <input type="file" name="hero_gambar" id="hero_gambar" accept="image/*" class="hidden" data-aspect-ratio="16/9">
            @error('hero_gambar')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
          </div>
        </div>
      </div>

      {{-- Deskripsi --}}
      <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100">
          <h2 class="font-semibold text-slate-800 flex items-center gap-2"><i class="fas fa-align-left text-primary"></i> Deskripsi Jurusan</h2>
        </div>
        <div class="px-6 py-5 space-y-4">
          <div>
            <label class="block text-xs font-semibold text-slate-500 mb-1.5 uppercase tracking-wide">Paragraf Pertama <span class="text-red-400">*</span></label>
            <textarea name="deskripsi_1" rows="4"
                      placeholder="Deskripsikan program keahlian ini secara umum..."
                      class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition resize-none @error('deskripsi_1') border-red-400 @enderror">{{ old('deskripsi_1') }}</textarea>
            @error('deskripsi_1')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
          </div>
          <div>
            <label class="block text-xs font-semibold text-slate-500 mb-1.5 uppercase tracking-wide">Paragraf Kedua (Opsional)</label>
            <textarea name="deskripsi_2" rows="4"
                      placeholder="Tambahkan informasi lebih lanjut (opsional)..."
                      class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition resize-none">{{ old('deskripsi_2') }}</textarea>
          </div>
        </div>
      </div>

      {{-- Poin Unggulan --}}
      <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
          <h2 class="font-semibold text-slate-800 flex items-center gap-2"><i class="fas fa-star text-primary"></i> Poin Unggulan</h2>
          <button type="button" id="add-poin-btn"
                  class="inline-flex items-center gap-1.5 text-xs text-primary hover:text-secondary bg-orange-50 hover:bg-orange-100 px-3 py-1.5 rounded-lg transition font-medium">
            <i class="fas fa-plus"></i> Tambah Poin
          </button>
        </div>
        <div id="poin-container" class="px-6 py-5 space-y-3">
          @forelse(old('poin_unggulan', ['']) as $i => $p)
          <div class="poin-item flex items-center gap-2">
            <div class="w-6 h-6 rounded-full bg-orange-100 flex items-center justify-center flex-shrink-0">
              <i class="fas fa-check text-primary text-xxs"></i>
            </div>
            <input type="text" name="poin_unggulan[]" value="{{ $p }}"
                   placeholder="Contoh: Praktik langsung di bengkel sekolah"
                   class="flex-1 border border-slate-200 rounded-xl px-3.5 py-2 text-sm focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition">
            <button type="button" onclick="this.closest('.poin-item').remove()"
                    class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition flex-shrink-0">
              <i class="fas fa-times text-xs"></i>
            </button>
          </div>
          @endforelse
        </div>
      </div>

      {{-- Foto Kegiatan --}}
      <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
          <h2 class="font-semibold text-slate-800 flex items-center gap-2"><i class="fas fa-images text-primary"></i> Foto Kegiatan</h2>
          <button type="button" id="add-foto-btn"
                  class="inline-flex items-center gap-1.5 text-xs text-primary hover:text-secondary bg-orange-50 hover:bg-orange-100 px-3 py-1.5 rounded-lg transition font-medium">
            <i class="fas fa-plus"></i> Tambah Foto
          </button>
        </div>
        <div id="foto-container" class="px-6 py-5 grid grid-cols-1 sm:grid-cols-2 gap-4">
          {{-- Foto items akan ditambah via JS --}}
        </div>
      </div>
    </div>

    {{-- ==================== KOLOM KANAN ==================== --}}
    <div class="space-y-6">
      {{-- Submit Card --}}
      <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100">
          <h2 class="font-semibold text-slate-800">Simpan</h2>
        </div>
        <div class="px-6 py-5 space-y-3">
          <button type="submit"
                  class="w-full bg-primary hover:bg-secondary text-white font-semibold py-3 px-4 rounded-xl transition shadow-md shadow-primary/30 flex items-center justify-center gap-2">
            <i class="fas fa-save"></i> Simpan Jurusan Baru
          </button>
          <a href="{{ route('admin.jurusan.index') }}"
             class="w-full flex items-center justify-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium py-2.5 px-4 rounded-xl transition text-sm">
            <i class="fas fa-arrow-left"></i> Batal
          </a>
        </div>
      </div>

      {{-- Tips --}}
      <div class="bg-blue-50 border border-blue-100 rounded-2xl p-5">
        <h3 class="text-sm font-semibold text-blue-800 mb-2 flex items-center gap-2"><i class="fas fa-lightbulb text-blue-500"></i> Tips</h3>
        <ul class="text-xs text-blue-700 space-y-1.5 list-disc pl-4">
          <li>Slug harus unik dan tidak bisa diubah setelah dibuat</li>
          <li>Gunakan slug singkat, misal: <code class="bg-blue-100 px-1 rounded">tkr</code> atau <code class="bg-blue-100 px-1 rounded">rpl</code></li>
          <li>Ikon dari <a href="https://fontawesome.com/icons" target="_blank" class="underline">Font Awesome 6</a> — format: <code class="bg-blue-100 px-1 rounded">fas fa-car</code></li>
          <li>Urutan terkecil tampil pertama di menu navigasi</li>
        </ul>
      </div>
    </div>
  </div>
</form>
@endsection

@section('scripts')
<script>
// Icon Preview Live
document.getElementById('icon-input').addEventListener('input', function() {
  const iconEl = document.querySelector('#icon-preview i');
  iconEl.className = this.value || 'fas fa-graduation-cap';
});

// Auto-generate slug from nama
document.querySelector('[name="nama_jurusan"]').addEventListener('input', function() {
  const slugInput = document.getElementById('slug-input');
  if (!slugInput.dataset.manual) {
    slugInput.value = this.value.toLowerCase().replace(/[^a-z0-9\s-]/g, '').trim().replace(/\s+/g, '-');
  }
});
document.getElementById('slug-input').addEventListener('input', function() {
  this.dataset.manual = true;
  this.value = this.value.toLowerCase().replace(/[^a-z0-9-]/g, '');
});

// Image preview
document.getElementById('hero_gambar').addEventListener('change', function() {
  if (this.files[0]) {
    const reader = new FileReader();
    reader.onload = e => {
      document.getElementById('image-preview').src = e.target.result;
      document.getElementById('preview-container').classList.remove('hidden');
      document.getElementById('upload-placeholder').classList.add('hidden');
      document.getElementById('file-label').textContent = this.files[0].name;
      document.getElementById('file-label').classList.remove('hidden');
    };
    reader.readAsDataURL(this.files[0]);
  }
});

// Add Poin Unggulan
let poinIndex = {{ count(old('poin_unggulan', [''])) }};
document.getElementById('add-poin-btn').addEventListener('click', function() {
  const div = document.createElement('div');
  div.className = 'poin-item flex items-center gap-2';
  div.innerHTML = `
    <div class="w-6 h-6 rounded-full bg-orange-100 flex items-center justify-center flex-shrink-0">
      <i class="fas fa-check text-primary text-xxs"></i>
    </div>
    <input type="text" name="poin_unggulan[]"
           placeholder="Masukkan poin unggulan..."
           class="flex-1 border border-slate-200 rounded-xl px-3.5 py-2 text-sm focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition">
    <button type="button" onclick="this.closest('.poin-item').remove()"
            class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition flex-shrink-0">
      <i class="fas fa-times text-xs"></i>
    </button>
  `;
  document.getElementById('poin-container').appendChild(div);
  poinIndex++;
});

// Add Foto Kegiatan
let fotoIndex = 0;
function addFotoItem() {
  const idx = fotoIndex++;
  const container = document.getElementById('foto-container');
  const div = document.createElement('div');
  div.className = 'foto-item bg-slate-50 rounded-xl overflow-hidden border border-slate-200';
  div.dataset.index = idx;
  div.innerHTML = `
    <div class="relative">
      <div class="foto-preview-container hidden">
        <img class="foto-preview w-full h-36 object-cover" src="" alt="">
      </div>
      <div class="foto-upload-placeholder h-36 flex flex-col items-center justify-center cursor-pointer hover:bg-slate-100 transition" onclick="this.closest('.foto-item').querySelector('.foto-file-input').click()">
        <i class="fas fa-image text-2xl text-slate-300 mb-1"></i>
        <p class="text-xs text-slate-400">Klik upload foto</p>
      </div>
      <input type="file" name="foto_kegiatan[${idx}][file]" class="foto-file-input hidden" accept="image/*">
      <button type="button" onclick="this.closest('.foto-item').remove()"
              class="absolute top-2 right-2 w-7 h-7 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600 transition shadow text-xs z-10">
        <i class="fas fa-times"></i>
      </button>
    </div>
    <div class="px-3 py-2">
      <input type="text" name="foto_kegiatan[${idx}][deskripsi]"
             placeholder="Deskripsi foto..."
             class="w-full text-xs border border-slate-200 rounded-lg px-2.5 py-1.5 focus:ring-1 focus:ring-primary/30 focus:border-primary outline-none transition">
    </div>
  `;
  container.appendChild(div);

  // Preview on file select
  div.querySelector('.foto-file-input').addEventListener('change', function() {
    if (this.files[0]) {
      const reader = new FileReader();
      reader.onload = e => {
        div.querySelector('.foto-preview').src = e.target.result;
        div.querySelector('.foto-preview-container').classList.remove('hidden');
        div.querySelector('.foto-upload-placeholder').classList.add('hidden');
      };
      reader.readAsDataURL(this.files[0]);
    }
  });
}

document.getElementById('add-foto-btn').addEventListener('click', addFotoItem);
// Start with 2 foto slots
addFotoItem(); addFotoItem();
</script>
@endsection
