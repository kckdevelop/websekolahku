@extends('layouts.admin')
@section('title', 'Edit Produk Tefa')
@section('subtitle', 'Perbarui informasi produk atau jasa Teaching Factory')

@section('content')
<div class="max-w-3xl">

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

  <form method="POST" action="{{ route('admin.tefa.products.update', $product) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 space-y-6">
      <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider pb-2 border-b border-slate-100">
        <i class="fas fa-box-open mr-1 text-primary"></i> Informasi Produk
      </h3>

      <div>
        <label for="nama" class="block text-sm font-medium text-slate-700 mb-1.5">Nama Produk / Jasa <span class="text-red-500">*</span></label>
        <input type="text" id="nama" name="nama" value="{{ old('nama', $product->nama) }}" required
          class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
        @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>

      <div>
        <label for="jurusan_content_id" class="block text-sm font-medium text-slate-700 mb-1.5">Program Keahlian (Jurusan)</label>
        <select id="jurusan_content_id" name="jurusan_content_id"
          class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm bg-white">
          <option value="">Umum (Tidak terikat Program Keahlian)</option>
          @foreach($jurusans as $j)
            <option value="{{ $j->id }}" {{ old('jurusan_content_id', $product->jurusan_content_id) == $j->id ? 'selected' : '' }}>
              {{ $j->nama_jurusan }}
            </option>
          @endforeach
        </select>
        @error('jurusan_content_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>

      <div>
        <label for="deskripsi" class="block text-sm font-medium text-slate-700 mb-1.5">Deskripsi Produk</label>
        <textarea id="deskripsi" name="deskripsi" rows="4"
          class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm resize-y">{{ old('deskripsi', $product->deskripsi) }}</textarea>
        @error('deskripsi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>

      <div>
        <label for="harga" class="block text-sm font-medium text-slate-700 mb-1.5">Harga (Rp)</label>
        <div class="flex items-center">
          <span class="px-4 py-3 rounded-l-xl border border-r-0 border-slate-200 bg-slate-50 text-slate-500 text-sm">Rp</span>
          <input type="number" id="harga" name="harga" value="{{ old('harga', $product->harga) }}" min="0" step="1000"
            class="w-full px-4 py-3 rounded-r-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
        </div>
        <p class="text-xs text-slate-400 mt-1">Kosongkan atau isi 0 untuk menampilkan teks "Hubungi kami"</p>
        @error('harga') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-4 border-b border-slate-100">
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1.5">Foto Utama (Cover)</label>
          <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
            <div class="w-32 h-32 rounded-xl overflow-hidden border border-slate-200 bg-slate-50 flex items-center justify-center flex-shrink-0">
              @if($product->gambar)
                <img id="gambar-preview" src="{{ asset('storage/' . $product->gambar) }}" alt="Preview" class="w-full h-full object-cover">
              @else
                <img id="gambar-preview" src="https://placehold.co/160x160/f1f5f9/94a3b8?text=Cover" alt="Preview" class="w-full h-full object-cover">
              @endif
            </div>
            <div class="space-y-2">
              <label class="cursor-pointer inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 hover:border-primary hover:bg-orange-50 transition-all text-sm text-slate-600 hover:text-primary font-medium">
                <i class="fas fa-image text-base"></i>
                <span id="gambar-label">{{ $product->gambar ? 'Ganti Cover' : 'Pilih Cover' }}</span>
                <input type="file" id="gambar" name="gambar" accept="image/*" class="hidden"
                  onchange="document.getElementById('gambar-preview').src=URL.createObjectURL(this.files[0]); document.getElementById('gambar-label').textContent=this.files[0].name;">
              </label>
              <p class="text-slate-400 text-xs">Maks: 3MB. Format: JPG, PNG, WebP</p>
            </div>
          </div>
          @error('gambar') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1.5">Foto Tambahan (Galeri)</label>
          <div class="space-y-3">
            {{-- List existing additional images with delete checkboxes --}}
            @if($product->gambar_tambahan && count($product->gambar_tambahan) > 0)
              <p class="text-xs font-semibold text-slate-500 mb-1">Centang gambar untuk dihapus:</p>
              <div class="grid grid-cols-4 gap-2 mb-3">
                @foreach($product->gambar_tambahan as $path)
                  <label class="relative aspect-square rounded-lg overflow-hidden border border-slate-200 bg-slate-50 cursor-pointer group">
                    <img src="{{ asset('storage/' . $path) }}" class="w-full h-full object-cover group-hover:opacity-75 transition-opacity">
                    <input type="checkbox" name="hapus_gambar[]" value="{{ $path }}" class="absolute top-1 right-1 w-4 h-4 rounded text-red-600 border-slate-300 focus:ring-red-500 z-10">
                    <div class="absolute inset-0 bg-red-950/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center pointer-events-none">
                      <i class="fas fa-trash text-white text-xs"></i>
                    </div>
                  </label>
                @endforeach
              </div>
            @endif

            <label class="cursor-pointer inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 hover:border-primary hover:bg-orange-50 transition-all text-sm text-slate-600 hover:text-primary font-medium">
              <i class="fas fa-images text-base"></i>
              <span>Tambah Gambar Galeri</span>
              <input type="file" id="gambar_tambahan" name="gambar_tambahan[]" accept="image/*" multiple class="hidden"
                onchange="handleMultipleImagesPreview(this)">
            </label>
            <p class="text-slate-400 text-xs">Maks: 3MB per gambar. Gambar baru akan ditambahkan ke galeri.</p>
            
            <div id="galeri-preview-container" class="grid grid-cols-4 gap-2 mt-2">
              {{-- Preview images will render here dynamically --}}
            </div>
          </div>
          @error('gambar_tambahan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
      </div>

      <div class="flex items-center gap-3">
        <input type="checkbox" id="aktif" name="aktif" value="1" {{ old('aktif', $product->aktif) ? 'checked' : '' }}
          class="w-4 h-4 text-primary rounded border-slate-300 focus:ring-primary">
        <label for="aktif" class="text-sm font-medium text-slate-700">Tampilkan produk di halaman publik</label>
      </div>
    </div>

    <div class="flex gap-3 mt-6">
      <button type="submit" class="px-6 py-3 bg-primary text-white rounded-xl font-semibold text-sm hover:bg-orange-600 transition-colors flex items-center gap-2">
        <i class="fas fa-save"></i> Perbarui Produk
      </button>
      <a href="{{ route('admin.tefa.products.index') }}" class="px-6 py-3 border border-slate-200 text-slate-600 rounded-xl font-semibold text-sm hover:bg-slate-50 transition-colors">
        Batal
      </a>
    </div>

  </form>
</div>
@endsection

@section('scripts')
<script>
  function handleMultipleImagesPreview(input) {
    const container = document.getElementById('galeri-preview-container');
    container.innerHTML = ''; // Clear previous previews
    
    if (input.files) {
      Array.from(input.files).forEach(file => {
        const reader = new FileReader();
        reader.onload = function(e) {
          const div = document.createElement('div');
          div.className = 'relative aspect-square rounded-lg overflow-hidden border border-slate-200 bg-slate-50';
          div.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
          container.appendChild(div);
        }
        reader.readAsDataURL(file);
      });
    }
  }
</script>
@endsection
