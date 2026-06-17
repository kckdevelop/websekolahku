@extends('layouts.admin')
@section('title')
<span class="inline-flex items-center gap-2">
  <a href="{{ route('admin.hero.index') }}" class="text-slate-400 hover:text-slate-600 transition-colors mr-1">
    <i class="fas fa-arrow-left text-base"></i>
  </a>
  <span>Tambah Hero Slide</span>
</span>
@endsection
@section('subtitle', 'Tambahkan slide baru ke carousel halaman utama')

@section('content')
<div class="max-w-3xl">
  <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <form method="POST" action="{{ route('admin.hero.store') }}" enctype="multipart/form-data" class="p-6 space-y-6">
      @csrf

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Judul --}}
        <div class="md:col-span-2">
          <label for="judul" class="block text-sm font-medium text-slate-700 mb-1.5">Judul Utama <span class="text-red-500">*</span></label>
          <input type="text" id="judul" name="judul" value="{{ old('judul') }}" required
            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm @error('judul') border-red-400 @enderror"
            placeholder="Belajar dengan Praktik Nyata...">
          @error('judul') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Deskripsi / Subtitle --}}
        <div class="md:col-span-2">
          <label for="deskripsi" class="block text-sm font-medium text-slate-700 mb-1.5">Deskripsi / Sub-teks</label>
          <textarea id="deskripsi" name="deskripsi" rows="3"
            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm @error('deskripsi') border-red-400 @enderror"
            placeholder="Siswa SMK Muhammadiyah 1 Bantul mengasah keterampilan di bengkel otomotif industri...">{{ old('deskripsi') }}</textarea>
          @error('deskripsi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Urutan --}}
        <div>
          <label for="urutan" class="block text-sm font-medium text-slate-700 mb-1.5">Urutan Tampil <span class="text-red-500">*</span></label>
          <input type="number" id="urutan" name="urutan" value="{{ old('urutan', 0) }}" required
            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
          @error('urutan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Status Aktif --}}
        <div class="flex items-start pt-7">
          <div class="flex items-center h-5">
            <input id="aktif" name="aktif" type="checkbox" value="1" {{ old('aktif', 1) ? 'checked' : '' }}
              class="h-4 w-4 text-primary border-slate-300 rounded focus:ring-primary">
          </div>
          <div class="ml-3 text-sm">
            <label for="aktif" class="font-medium text-slate-700">Slide Aktif</label>
            <p class="text-slate-500 text-xs">Slide akan langsung ditampilkan di website jika dicentang</p>
          </div>
        </div>

        {{-- Tombol Label --}}
        <div>
          <label for="label_tombol" class="block text-sm font-medium text-slate-700 mb-1.5">Teks Tombol</label>
          <input type="text" id="label_tombol" name="label_tombol" value="{{ old('label_tombol', 'Daftar Sekarang') }}"
            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm"
            placeholder="Daftar Sekarang">
          @error('label_tombol') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Tombol Link --}}
        <div>
          <label for="link_tombol" class="block text-sm font-medium text-slate-700 mb-1.5">Link / URL Tombol</label>
          <input type="text" id="link_tombol" name="link_tombol" value="{{ old('link_tombol', '#') }}"
            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm"
            placeholder="#informasi atau https://example.com">
          @error('link_tombol') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
      </div>

      {{-- Gambar Upload --}}
      <div class="border-t border-slate-100 pt-6">
        <label class="block text-sm font-medium text-slate-700 mb-1.5">Unggah Gambar Slide</label>
        <div class="flex items-center gap-4">
          <div id="preview-container" class="hidden w-32 h-20 rounded-xl overflow-hidden border border-slate-200">
            <img id="image-preview" src="" alt="Preview" class="w-full h-full object-cover">
          </div>
          <label class="cursor-pointer flex items-center gap-2 px-4 py-3 rounded-xl border-2 border-dashed border-slate-200 hover:border-primary hover:bg-orange-50 transition-all text-sm text-slate-500 hover:text-primary">
            <i class="fas fa-cloud-upload-alt text-lg"></i>
            <span id="file-label">Pilih File Gambar (Maks. 2MB)</span>
            <input type="file" id="gambar" name="gambar" accept="image/*" class="hidden" data-aspect-ratio="16/9" onchange="previewImage(this)">
          </label>
        </div>
        @error('gambar') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>

      {{-- Gambar URL Alternatif --}}
      <div>
        <label for="gambar_url" class="block text-sm font-medium text-slate-700 mb-1.5">Atau gunakan URL Gambar Eksternal</label>
        <input type="url" id="gambar_url" name="gambar_url" value="{{ old('gambar_url') }}"
          class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm"
          placeholder="https://picsum.photos/id/1031/1920/1080">
        <p class="text-slate-400 text-xs mt-1">Gunakan URL jika Anda tidak ingin mengunggah gambar dari komputer Anda.</p>
        @error('gambar_url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>

      {{-- Buttons --}}
      <div class="flex items-center gap-3 border-t border-slate-100 pt-6">
        <button type="submit"
          class="inline-flex items-center gap-2 bg-primary hover:bg-secondary text-white font-semibold px-6 py-3 rounded-xl transition-all hover:shadow-lg hover:shadow-primary/30">
          <i class="fas fa-save"></i> Simpan Slide
        </button>
        <a href="{{ route('admin.hero.index') }}"
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
        document.getElementById('preview-container').classList.remove('hidden');
        document.getElementById('file-label').textContent = file.name;
      };
      reader.readAsDataURL(file);
    }
  }
</script>
@endsection
