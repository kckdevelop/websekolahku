@extends('layouts.admin')

@section('title', 'Foto Kegiatan Dojo SMK')
@section('subtitle', 'Daftar dokumentasi foto pelatihan, K3, pengelasan, perakitan, dan pembentukan budaya kerja')

@section('content')
<div class="space-y-6">
  <!-- Top Bar: Search, Filter & Add Button -->
  <div class="bg-white p-4 md:p-6 rounded-2xl shadow-sm border border-slate-200/80 flex flex-col md:flex-row items-center justify-between gap-4">
    <form action="{{ route('admin.dojo.photos.index') }}" method="GET" class="w-full md:w-auto flex flex-col sm:flex-row items-center gap-3 flex-grow">
      <div class="relative w-full sm:w-72">
        <input type="text" name="search" value="{{ $search }}" placeholder="Cari judul atau deskripsi..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
        <i class="fas fa-search absolute left-3.5 top-3.5 text-slate-400 text-sm"></i>
      </div>

      <select name="unit" onchange="this.form.submit()" class="w-full sm:w-48 px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
        <option value="">-- Semua Unit Dojo --</option>
        @foreach($unitList as $u)
          <option value="{{ $u }}" {{ $unit === $u ? 'selected' : '' }}>{{ $u }}</option>
        @endforeach
      </select>

      @if($search || $unit)
        <a href="{{ route('admin.dojo.photos.index') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-semibold">
          Reset
        </a>
      @endif
    </form>

    <a href="{{ route('admin.dojo.photos.create') }}" class="w-full md:w-auto px-5 py-2.5 bg-primary hover:bg-secondary text-white font-bold rounded-xl shadow-md shadow-primary/20 transition flex items-center justify-center gap-2 text-sm">
      <i class="fas fa-plus"></i>
      <span>Upload Foto Kegiatan</span>
    </a>
  </div>

  <!-- Photos Grid -->
  @if($photos->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
      @foreach($photos as $p)
        <div class="bg-white rounded-2xl overflow-hidden border border-slate-200/80 shadow-sm hover:shadow-md transition flex flex-col justify-between group">
          <div>
            <div class="relative aspect-video bg-slate-900 overflow-hidden">
              <img src="{{ $p->foto_src }}" alt="{{ $p->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
              <span class="absolute top-2.5 left-2.5 bg-slate-900/80 backdrop-blur-md text-white text-xs font-bold px-2.5 py-1 rounded-full border border-white/20">
                {{ $p->unit_dojo }}
              </span>
            </div>
            
            <div class="p-4">
              <h4 class="font-bold text-slate-800 text-sm mb-1.5 line-clamp-2 leading-snug">
                {{ $p->judul }}
              </h4>
              @if($p->deskripsi)
                <p class="text-slate-500 text-xs line-clamp-2 mb-3">
                  {{ $p->deskripsi }}
                </p>
              @endif

              <div class="flex items-center justify-between text-xs text-slate-400 pt-2 border-t border-slate-100">
                <span>Urutan: <strong>{{ $p->urutan }}</strong></span>
                <form action="{{ route('admin.dojo.photos.toggle-aktif', $p->id) }}" method="POST">
                  @csrf
                  <button type="submit" class="font-semibold px-2 py-0.5 rounded-md text-[11px] {{ $p->aktif ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                    {{ $p->aktif ? 'Aktif' : 'Non-Aktif' }}
                  </button>
                </form>
              </div>
            </div>
          </div>

          <!-- Actions -->
          <div class="p-3 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-2">
            <a href="{{ route('admin.dojo.photos.edit', $p->id) }}" class="p-2 bg-white hover:bg-slate-100 border border-slate-200 text-blue-600 rounded-lg text-xs font-semibold transition" title="Edit">
              <i class="fas fa-edit"></i>
            </a>
            <form action="{{ route('admin.dojo.photos.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto kegiatan ini?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="p-2 bg-white hover:bg-red-50 border border-slate-200 text-red-600 rounded-lg text-xs font-semibold transition" title="Hapus">
                <i class="fas fa-trash-alt"></i>
              </button>
            </form>
          </div>
        </div>
      @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-6">
      {{ $photos->links() }}
    </div>
  @else
    <div class="bg-white p-12 rounded-2xl border border-slate-200/80 text-center">
      <div class="w-16 h-16 bg-orange-50 text-primary rounded-full flex items-center justify-center text-2xl mx-auto mb-3">
        <i class="fas fa-images"></i>
      </div>
      <h3 class="font-bold text-slate-800 text-base">Belum Ada Foto Kegiatan</h3>
      <p class="text-slate-500 text-xs mt-1 mb-4">Silakan unggah foto dokumentasi kegiatan Dojo SMK untuk ditampilkan pada halaman publik.</p>
      <a href="{{ route('admin.dojo.photos.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-xl text-xs font-bold">
        <i class="fas fa-plus"></i> Upload Foto Pertama
      </a>
    </div>
  @endif
</div>
@endsection
