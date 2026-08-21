@extends('layouts.admin')

@section('title', 'Edit Foto Kegiatan Dojo')
@section('subtitle', 'Ubah data dan foto dokumentasi kegiatan Dojo SMK')

@section('content')
<div class="max-w-3xl mx-auto">
  <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 md:p-8">
    <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-6">
      <h3 class="text-lg font-bold text-slate-800">Form Edit Foto Kegiatan</h3>
      <a href="{{ route('admin.dojo.photos.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-semibold">
        <i class="fas fa-arrow-left mr-1"></i> Kembali
      </a>
    </div>

    <form action="{{ route('admin.dojo.photos.update', $photo->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
      @csrf
      @method('PUT')

      <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Judul Foto Kegiatan <span class="text-red-500">*</span></label>
        <input type="text" name="judul" value="{{ old('judul', $photo->judul) }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-sm">
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-2">Kategori Unit Dojo <span class="text-red-500">*</span></label>
          <select name="unit_dojo" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-sm">
            @foreach($unitList as $u)
              <option value="{{ $u }}" {{ old('unit_dojo', $photo->unit_dojo) === $u ? 'selected' : '' }}>{{ $u }}</option>
            @endforeach
          </select>
        </div>

        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-2">Urutan Tampil</label>
          <input type="number" name="urutan" value="{{ old('urutan', $photo->urutan) }}" min="0" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-sm">
        </div>
      </div>

      <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Foto Kegiatan Saat Ini</label>
        <div class="flex items-center gap-4 mb-3">
          <img src="{{ $photo->foto_src }}" alt="{{ $photo->judul }}" class="w-32 h-20 object-cover rounded-xl border border-slate-200">
        </div>
        
        <label class="block text-sm font-semibold text-slate-700 mb-2">Ganti Foto (Opsional)</label>
        <input type="file" name="foto" accept="image/*" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-orange-50 file:text-primary hover:file:bg-orange-100 cursor-pointer">
        <p class="text-xs text-slate-400 mt-1">Kosongkan jika tidak ingin mengganti foto saat ini.</p>
      </div>

      <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi / Penjelasan Singkat</label>
        <textarea name="deskripsi" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-sm leading-relaxed">{{ old('deskripsi', $photo->deskripsi) }}</textarea>
      </div>

      <div class="flex items-center gap-2">
        <input type="checkbox" name="aktif" id="aktif" value="1" {{ old('aktif', $photo->aktif) ? 'checked' : '' }} class="w-4 h-4 text-primary rounded border-slate-300 focus:ring-primary">
        <label for="aktif" class="text-sm font-medium text-slate-700">Tampilkan Foto ini di Halaman Publik</label>
      </div>

      <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
        <a href="{{ route('admin.dojo.photos.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-sm font-semibold">
          Batal
        </a>
        <button type="submit" class="px-6 py-2.5 bg-primary hover:bg-secondary text-white font-bold rounded-xl shadow-md shadow-primary/20 text-sm">
          Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
