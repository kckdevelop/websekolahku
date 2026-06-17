@extends('layouts.admin')
@section('title')
<span class="inline-flex items-center gap-2">
  <a href="{{ route('admin.testimoni.index') }}" class="text-slate-400 hover:text-slate-600 transition-colors mr-1">
    <i class="fas fa-arrow-left text-base"></i>
  </a>
  <span>Edit Testimoni</span>
</span>
@endsection
@section('subtitle', 'Perbarui data testimoni alumni atau orang tua siswa')

@section('content')
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

  {{-- KOLOM KIRI: Form Edit --}}
  <div class="xl:col-span-2">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">

      <form method="POST" action="{{ route('admin.testimoni.update', $testimoni) }}" enctype="multipart/form-data" class="p-6 space-y-5">
        @csrf @method('PUT')
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
          <input type="text" name="nama" value="{{ old('nama', $testimoni->nama) }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
          @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Tahun Alumni <span class="text-red-500">*</span></label>
            <input type="text" name="alumni_tahun" value="{{ old('alumni_tahun', $testimoni->alumni_tahun) }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
            @error('alumni_tahun') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Pekerjaan / Jabatan Sekarang <span class="text-red-500">*</span></label>
            <input type="text" name="pekerjaan" value="{{ old('pekerjaan', $testimoni->pekerjaan) }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
            @error('pekerjaan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          </div>
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1.5">Kutipan Testimoni <span class="text-red-500">*</span></label>
          <textarea name="kutipan" required rows="4" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm resize-none">{{ old('kutipan', $testimoni->kutipan) }}</textarea>
          @error('kutipan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1.5">Ganti Foto Profil</label>
          @if($testimoni->foto)
            <img src="{{ asset('storage/' . $testimoni->foto) }}" class="w-16 h-16 rounded-full object-cover mb-2 border border-slate-200">
          @endif
          <input type="file" name="foto" accept="image/*" data-aspect-ratio="1" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-orange-50 file:text-primary hover:file:bg-orange-100 transition">
          @error('foto') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          <p class="text-xs text-slate-400 mt-1">Kosongkan jika tidak ingin mengganti foto</p>
        </div>

        <div class="flex gap-3 pt-2">
          <button type="submit" class="inline-flex items-center gap-2 bg-primary hover:bg-secondary text-white font-semibold px-6 py-3 rounded-xl transition-all hover:shadow-lg hover:shadow-primary/30"><i class="fas fa-save"></i> Simpan Perubahan</button>
          <a href="{{ route('admin.testimoni.index') }}" class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-6 py-3 rounded-xl transition-all">Batal</a>
        </div>
      </form>
    </div>
  </div>

  {{-- KOLOM KANAN: Daftar Testimoni --}}
  <div class="xl:col-span-1">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden sticky top-6">
      <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
        <h3 class="font-semibold text-slate-800 text-sm">Daftar Testimoni</h3>
        <a href="{{ route('admin.testimoni.index') }}" class="text-xs text-primary hover:underline">Lihat Semua</a>
      </div>
      <div class="divide-y divide-slate-50">
        @forelse($daftarTestimoni as $item)
        <div class="px-5 py-3 flex items-start gap-3 hover:bg-slate-50 transition-colors group {{ $item->id === $testimoni->id ? 'bg-orange-50 border-l-2 border-primary' : '' }}">
          {{-- Avatar --}}
          @if($item->foto)
            <img src="{{ asset('storage/' . $item->foto) }}" class="w-10 h-10 rounded-full object-cover flex-shrink-0 mt-0.5 border border-slate-200">
          @else
            <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0 mt-0.5 text-primary font-bold text-sm">
              {{ strtoupper(substr($item->nama, 0, 1)) }}
            </div>
          @endif
          <div class="flex-1 min-w-0">
            <p class="text-sm font-semibold text-slate-800">{{ $item->nama }}</p>
            <p class="text-xs text-slate-400 mt-0.5">Alumni {{ $item->alumni_tahun }} &bull; {{ $item->pekerjaan }}</p>
            <p class="text-xs text-slate-500 italic mt-1 line-clamp-2">"{{ $item->kutipan }}"</p>
            <div class="flex items-center gap-2 mt-1.5 opacity-0 group-hover:opacity-100 transition-opacity">
              <a href="{{ route('admin.testimoni.edit', $item) }}" class="text-xs text-blue-600 hover:text-blue-800 font-medium">
                <i class="fas fa-edit"></i> Edit
              </a>
              <form method="POST" action="{{ route('admin.testimoni.destroy', $item) }}" onsubmit="return confirm('Hapus testimoni ini?')" class="inline">
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
          <i class="fas fa-comment-alt text-2xl mb-2 block"></i>
          <p class="text-sm">Belum ada testimoni</p>
        </div>
        @endforelse
      </div>
    </div>
  </div>

</div>
@endsection
