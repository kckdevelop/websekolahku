@extends('layouts.admin')
@section('title')
<span class="inline-flex items-center gap-2">
  <a href="{{ route('admin.prestasi.index') }}" class="text-slate-400 hover:text-slate-600 transition-colors mr-1">
    <i class="fas fa-arrow-left text-base"></i>
  </a>
  <span>Tambah Prestasi Baru</span>
</span>
@endsection
@section('subtitle', 'Tambahkan data prestasi dan penghargaan baru')

@section('content')
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

  {{-- KOLOM KIRI: Form Tambah --}}
  <div class="xl:col-span-2">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">

      <form method="POST" action="{{ route('admin.prestasi.store') }}" enctype="multipart/form-data" class="p-6 space-y-5">
        @csrf
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1.5">Judul Prestasi <span class="text-red-500">*</span></label>
          <input type="text" name="judul" value="{{ old('judul') }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm" placeholder="Juara 1 Lomba Robotik Nasional">
          @error('judul') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Kategori <span class="text-red-500">*</span></label>
            <input type="text" name="kategori" value="{{ old('kategori') }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm" placeholder="Akademik / Non-Akademik">
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Tingkat <span class="text-red-500">*</span></label>
            <select name="tingkat" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
              <option value="">-- Pilih Tingkat --</option>
              <option value="Kecamatan" {{ old('tingkat') == 'Kecamatan' ? 'selected' : '' }}>Kecamatan</option>
              <option value="Kabupaten" {{ old('tingkat') == 'Kabupaten' ? 'selected' : '' }}>Kabupaten</option>
              <option value="Provinsi" {{ old('tingkat') == 'Provinsi' ? 'selected' : '' }}>Provinsi</option>
              <option value="Nasional" {{ old('tingkat') == 'Nasional' ? 'selected' : '' }}>Nasional</option>
              <option value="Internasional" {{ old('tingkat') == 'Internasional' ? 'selected' : '' }}>Internasional</option>
            </select>
          </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Peraih <span class="text-red-500">*</span></label>
            <input type="text" name="peraih" value="{{ old('peraih') }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm" placeholder="Nama siswa atau tim">
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Tanggal <span class="text-red-500">*</span></label>
            <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
          </div>
        </div>
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1.5">Deskripsi <span class="text-red-500">*</span></label>
          <textarea name="deskripsi" required rows="4" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm resize-none" placeholder="Deskripsi singkat tentang prestasi ini...">{{ old('deskripsi') }}</textarea>
          @error('deskripsi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1.5">Foto Dokumentasi</label>
          <input type="file" name="foto" accept="image/*" data-aspect-ratio="4/3" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-orange-50 file:text-primary hover:file:bg-orange-100 transition">
          @error('foto') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="flex gap-3 pt-2">
          <button type="submit" class="inline-flex items-center gap-2 bg-primary hover:bg-secondary text-white font-semibold px-6 py-3 rounded-xl transition-all hover:shadow-lg hover:shadow-primary/30"><i class="fas fa-save"></i> Simpan</button>
          <a href="{{ route('admin.prestasi.index') }}" class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-6 py-3 rounded-xl transition-all">Batal</a>
        </div>
      </form>
    </div>
  </div>

  {{-- KOLOM KANAN: Daftar Prestasi --}}
  <div class="xl:col-span-1">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden sticky top-6">
      <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
        <h3 class="font-semibold text-slate-800 text-sm">Daftar Prestasi</h3>
        <a href="{{ route('admin.prestasi.index') }}" class="text-xs text-primary hover:underline">Lihat Semua</a>
      </div>
      <div class="divide-y divide-slate-50">
        @forelse($daftarPrestasi as $item)
        <div class="px-5 py-3 flex items-start gap-3 hover:bg-slate-50 transition-colors group">
          @if($item->foto)
            <img src="{{ asset('storage/' . $item->foto) }}" class="w-10 h-10 rounded-lg object-cover flex-shrink-0 mt-0.5">
          @else
            <div class="w-10 h-10 rounded-lg bg-yellow-100 flex items-center justify-center flex-shrink-0 mt-0.5">
              <i class="fas fa-trophy text-yellow-500 text-sm"></i>
            </div>
          @endif
          <div class="flex-1 min-w-0">
            <p class="text-sm font-medium text-slate-800 line-clamp-2 leading-tight">{{ $item->judul }}</p>
            <p class="text-xs text-slate-400 mt-0.5">{{ $item->peraih }} &bull; {{ $item->tanggal->format('d M Y') }}</p>
            <div class="flex items-center gap-2 mt-1.5 opacity-0 group-hover:opacity-100 transition-opacity">
              <a href="{{ route('admin.prestasi.edit', $item) }}" class="text-xs text-blue-600 hover:text-blue-800 font-medium">
                <i class="fas fa-edit"></i> Edit
              </a>
              <form method="POST" action="{{ route('admin.prestasi.destroy', $item) }}" onsubmit="return confirm('Hapus prestasi ini?')" class="inline">
                @csrf @method('DELETE')
                <button type="submit" class="text-xs text-red-500 hover:text-red-700 font-medium">
                  <i class="fas fa-trash"></i> Hapus
                </button>
              </form>
            </div>
          </div>
          <span class="flex-shrink-0 inline-flex px-1.5 py-0.5 rounded text-xs bg-blue-100 text-blue-600">{{ $item->tingkat }}</span>
        </div>
        @empty
        <div class="px-5 py-8 text-center text-slate-400">
          <i class="fas fa-trophy text-2xl mb-2 block"></i>
          <p class="text-sm">Belum ada prestasi</p>
        </div>
        @endforelse
      </div>
    </div>
  </div>

</div>
@endsection
