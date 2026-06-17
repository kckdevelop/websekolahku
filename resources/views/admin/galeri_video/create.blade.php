@extends('layouts.admin')
@section('title')
<span class="inline-flex items-center gap-2">
  <a href="{{ route('admin.galeri_video.index') }}" class="text-slate-400 hover:text-slate-600 transition-colors mr-1">
    <i class="fas fa-arrow-left text-base"></i>
  </a>
  <span>Tambah Video Galeri</span>
</span>
@endsection
@section('subtitle', 'Tambahkan video YouTube ke galeri sekolah')

@section('content')
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

  {{-- KOLOM KIRI: Form Tambah --}}
  <div class="xl:col-span-2">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">

      <form method="POST" action="{{ route('admin.galeri_video.store') }}" enctype="multipart/form-data" class="p-6 space-y-5">
        @csrf
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1.5">Judul Video <span class="text-red-500">*</span></label>
          <input type="text" name="judul" value="{{ old('judul') }}" required
            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm"
            placeholder="Judul video...">
          @error('judul') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1.5">URL Video (YouTube) <span class="text-red-500">*</span></label>
          <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400"><i class="fab fa-youtube text-red-500"></i></span>
            <input type="url" name="url" value="{{ old('url') }}" required
              class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm"
              placeholder="https://www.youtube.com/watch?v=...">
          </div>
          @error('url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Kategori <span class="text-red-500">*</span></label>
            <select name="kategori" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
              <option value="">-- Pilih --</option>
              @foreach(['kegiatan','profil-sekolah','prestasi','ekstrakurikuler'] as $k)
                <option value="{{ $k }}" {{ old('kategori') == $k ? 'selected' : '' }}>{{ ucwords(str_replace('-',' ',$k)) }}</option>
              @endforeach
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Tanggal <span class="text-red-500">*</span></label>
            <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required
              class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
          </div>
        </div>
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1.5">Deskripsi</label>
          <textarea name="deskripsi" rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm resize-none" placeholder="Deskripsi singkat video...">{{ old('deskripsi') }}</textarea>
        </div>
        <div class="flex gap-3 pt-4">
          <button type="submit" class="inline-flex items-center gap-2 bg-primary hover:bg-secondary text-white font-semibold px-6 py-3 rounded-xl transition-all hover:shadow-lg hover:shadow-primary/30"><i class="fas fa-save"></i> Simpan</button>
          <a href="{{ route('admin.galeri_video.index') }}" class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-6 py-3 rounded-xl">Batal</a>
        </div>
      </form>
    </div>
  </div>

  {{-- KOLOM KANAN: Daftar Video --}}
  <div class="xl:col-span-1">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden sticky top-6">
      <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
        <h3 class="font-semibold text-slate-800 text-sm">Daftar Video</h3>
        <a href="{{ route('admin.galeri_video.index') }}" class="text-xs text-primary hover:underline">Lihat Semua</a>
      </div>
      <div class="divide-y divide-slate-50">
        @forelse($daftarVideo as $item)
        <div class="px-5 py-3 flex items-start gap-3 hover:bg-slate-50 transition-colors group">
          <img src="https://img.youtube.com/vi/{{ $item->youtube_id }}/mqdefault.jpg"
               class="w-14 h-10 rounded-lg object-cover flex-shrink-0 mt-0.5">
          <div class="flex-1 min-w-0">
            <p class="text-sm font-medium text-slate-800 line-clamp-2 leading-tight">{{ $item->judul }}</p>
            <p class="text-xs text-slate-400 mt-0.5">{{ ucwords(str_replace('-',' ',$item->kategori)) }} &bull; {{ $item->tanggal->format('d M Y') }}</p>
            <div class="flex items-center gap-2 mt-1.5 opacity-0 group-hover:opacity-100 transition-opacity">
              <a href="{{ route('admin.galeri_video.edit', $item) }}" class="text-xs text-blue-600 hover:text-blue-800 font-medium">
                <i class="fas fa-edit"></i> Edit
              </a>
              <form method="POST" action="{{ route('admin.galeri_video.destroy', $item) }}" onsubmit="return confirm('Hapus video ini?')" class="inline">
                @csrf @method('DELETE')
                <button type="submit" class="text-xs text-red-500 hover:text-red-700 font-medium">
                  <i class="fas fa-trash"></i> Hapus
                </button>
              </form>
            </div>
          </div>
        </div>
        @empty
        <div class="px-5 py-8 text-center text-slate-400">
          <i class="fas fa-video text-2xl mb-2 block"></i>
          <p class="text-sm">Belum ada video</p>
        </div>
        @endforelse
      </div>
    </div>
  </div>

</div>
@endsection
