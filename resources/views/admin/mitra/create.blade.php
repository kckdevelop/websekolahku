@extends('layouts.admin')
@section('title')
<span class="inline-flex items-center gap-2">
  <a href="{{ route('admin.mitra.index') }}" class="text-slate-400 hover:text-slate-600 transition-colors mr-1">
    <i class="fas fa-arrow-left text-base"></i>
  </a>
  <span>Tambah Mitra Industri</span>
</span>
@endsection
@section('subtitle', 'Tambahkan logo mitra industri baru ke halaman utama')

@section('content')
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6 items-start">

  {{-- ============ FORM (Kiri / 2/3) ============ --}}
  <div class="xl:col-span-2">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
      <form method="POST" action="{{ route('admin.mitra.store') }}" enctype="multipart/form-data" class="p-6 space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          {{-- Nama Mitra --}}
          <div class="md:col-span-2">
            <label for="nama" class="block text-sm font-medium text-slate-700 mb-1.5">Nama Mitra <span class="text-red-500">*</span></label>
            <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required
              class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm @error('nama') border-red-400 @enderror"
              placeholder="Contoh: PT Astra Honda Motor...">
            @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          </div>

          {{-- Tautan Link --}}
          <div class="md:col-span-2">
            <label for="link" class="block text-sm font-medium text-slate-700 mb-1.5">Tautan Website Mitra</label>
            <input type="text" id="link" name="link" value="{{ old('link', '#') }}"
              class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm @error('link') border-red-400 @enderror"
              placeholder="Contoh: https://www.astra-honda.com">
            @error('link') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          </div>

          {{-- Urutan --}}
          <div>
            <label for="urutan" class="block text-sm font-medium text-slate-700 mb-1.5">Urutan Tampil <span class="text-red-500">*</span></label>
            <input type="number" id="urutan" name="urutan" value="{{ old('urutan', $allMitras->count() + 1) }}" required
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
              <label for="aktif" class="font-medium text-slate-700">Mitra Aktif</label>
              <p class="text-slate-500 text-xs">Logo mitra akan langsung ditampilkan di website jika dicentang</p>
            </div>
          </div>
        </div>

        {{-- Logo Upload --}}
        <div class="border-t border-slate-100 pt-6">
          <label class="block text-sm font-medium text-slate-700 mb-1.5">Unggah Logo Mitra</label>
          <div class="flex items-center gap-4">
            <div id="preview-container" class="hidden w-28 h-14 rounded border border-slate-200 bg-slate-50 flex items-center justify-center p-1 overflow-hidden flex-shrink-0">
              <img id="image-preview" src="" alt="Preview" class="max-w-full max-h-full object-contain">
            </div>
            <label class="cursor-pointer flex items-center gap-2 px-4 py-3 rounded-xl border-2 border-dashed border-slate-200 hover:border-primary hover:bg-orange-50 transition-all text-sm text-slate-500 hover:text-primary">
              <i class="fas fa-cloud-upload-alt text-lg"></i>
              <span id="file-label">Pilih Logo Mitra (Maks. 2MB)</span>
              <input type="file" id="logo" name="logo" accept="image/*" class="hidden">
            </label>
          </div>
          @error('logo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Logo URL Alternatif --}}
        <div>
          <label for="logo_url" class="block text-sm font-medium text-slate-700 mb-1.5">Atau gunakan URL Logo Eksternal</label>
          <input type="url" id="logo_url" name="logo_url" value="{{ old('logo_url') }}"
            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm"
            placeholder="https://upload.wikimedia.org/wikipedia/commons/e/e4/Honda_logo.svg">
          <p class="text-slate-400 text-xs mt-1">Gunakan URL jika Anda tidak ingin mengunggah file dari komputer Anda.</p>
          @error('logo_url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Buttons --}}
        <div class="flex items-center gap-3 border-t border-slate-100 pt-6">
          <button type="submit"
            class="inline-flex items-center gap-2 bg-primary hover:bg-secondary text-white font-semibold px-6 py-3 rounded-xl transition-all hover:shadow-lg hover:shadow-primary/30">
            <i class="fas fa-save"></i> Simpan Mitra
          </button>
          <a href="{{ route('admin.mitra.index') }}"
            class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-6 py-3 rounded-xl transition-all">
            Batal
          </a>
        </div>
      </form>
    </div>
  </div>

  {{-- ============ DAFTAR MITRA (Kanan / 1/3) ============ --}}
  <div class="xl:col-span-1">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden sticky top-6">
      <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
        <div>
          <h3 class="font-semibold text-slate-800 text-sm">Daftar Mitra Saat Ini</h3>
          <p class="text-xs text-slate-400 mt-0.5">{{ $allMitras->count() }} mitra terdaftar</p>
        </div>
        <a href="{{ route('admin.mitra.index') }}" class="text-xs text-primary hover:underline">Lihat semua</a>
      </div>

      @if($allMitras->isEmpty())
        <div class="px-5 py-10 text-center text-slate-400">
          <i class="fas fa-handshake text-3xl mb-2 block"></i>
          <p class="text-sm">Belum ada mitra terdaftar</p>
        </div>
      @else
        <ul class="divide-y divide-slate-50 max-h-[480px] overflow-y-auto">
          @foreach($allMitras as $item)
          <li class="flex items-center gap-3 px-5 py-3 hover:bg-slate-50 transition-colors group">
            {{-- Logo --}}
            <div class="w-14 h-8 rounded border border-slate-100 bg-slate-50 flex items-center justify-center p-1 overflow-hidden flex-shrink-0">
              <img src="{{ $item->logo_src }}" alt="{{ $item->nama }}" class="max-w-full max-h-full object-contain">
            </div>
            {{-- Info --}}
            <div class="flex-1 min-w-0">
              <p class="text-sm font-medium text-slate-700 truncate">{{ $item->nama }}</p>
              <div class="flex items-center gap-1.5 mt-0.5">
                <span class="text-xs text-slate-400">#{{ $item->urutan }}</span>
                @if($item->aktif)
                  <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-[10px] font-medium bg-green-100 text-green-700">Aktif</span>
                @else
                  <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-[10px] font-medium bg-slate-100 text-slate-500">Nonaktif</span>
                @endif
              </div>
            </div>
            {{-- Actions --}}
            <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity flex-shrink-0">
              <a href="{{ route('admin.mitra.edit', $item) }}"
                class="p-1.5 text-blue-500 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                <i class="fas fa-edit text-xs"></i>
              </a>
              <form method="POST" action="{{ route('admin.mitra.destroy', $item) }}" onsubmit="return confirm('Hapus mitra {{ $item->nama }}?')">
                @csrf @method('DELETE')
                <button type="submit" class="p-1.5 text-red-400 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                  <i class="fas fa-trash text-xs"></i>
                </button>
              </form>
            </div>
          </li>
          @endforeach
        </ul>
        <div class="px-5 py-3 border-t border-slate-50 bg-slate-50/50">
          <p class="text-xs text-slate-400 text-center">Hover pada baris untuk aksi edit / hapus</p>
        </div>
      @endif
    </div>
  </div>

</div>
@endsection
