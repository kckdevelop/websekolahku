@extends('layouts.admin')
@section('title', 'Atur Gelombang Pendaftaran')
@section('subtitle', 'Kelola gelombang pendaftaran SPMB dan tandai gelombang yang sedang aktif')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

  {{-- Kolom Kiri: Daftar Gelombang (Mencakup 2/3 lebar jika layar besar) --}}
  <div class="lg:col-span-2 space-y-6">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
      <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
        <h3 class="font-bold text-slate-800 flex items-center gap-2">
          <i class="fas fa-layer-group text-primary"></i> Daftar Gelombang
        </h3>
        <span class="text-xs text-slate-400">Total: {{ $gelombangs->count() }} gelombang</span>
      </div>

      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-100 table-auto">
          <thead class="bg-slate-50">
            <tr class="text-xs font-semibold text-slate-500 uppercase tracking-wider text-left">
              <th class="px-4 py-3">Nama Gelombang</th>
              <th class="px-4 py-3">Tahun Ajaran</th>
              <th class="px-4 py-3">Periode</th>
              <th class="px-4 py-3 text-center">Status</th>
              <th class="px-4 py-3 text-right">Aksi</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-slate-100 text-sm">
            @forelse($gelombangs as $item)
            <tr class="hover:bg-slate-50 transition-colors {{ $item->is_aktif ? 'bg-orange-50/20' : '' }}">
              <td class="px-4 py-4">
                <div class="font-semibold text-slate-800">{{ $item->nama_gelombang }}</div>
                @if($item->keterangan)
                  <div class="text-xxs text-slate-400 mt-0.5">{{ $item->keterangan }}</div>
                @endif
              </td>
              <td class="px-4 py-4 text-slate-600 font-medium">{{ $item->tahun_ajaran }}</td>
              <td class="px-4 py-4 text-slate-500 text-xs">
                @if($item->tanggal_mulai && $item->tanggal_selesai)
                  {{ $item->tanggal_mulai->translatedFormat('d M Y') }} – {{ $item->tanggal_selesai->translatedFormat('d M Y') }}
                @else
                  <span class="text-slate-300 italic">Belum diatur</span>
                @endif
              </td>
              <td class="px-4 py-4 text-center">
                @if($item->is_aktif)
                  <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 shadow-sm shadow-green-100/50">
                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                    Aktif
                  </span>
                @else
                  <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-650">
                    Non-Aktif
                  </span>
                @endif
              </td>
              <td class="px-4 py-4 text-right">
                <div class="flex items-center justify-end gap-1.5">
                  {{-- Tombol Aktivasi --}}
                  @if(!$item->is_aktif)
                    <form method="POST" action="{{ route('admin.gelombang.toggleActive', $item) }}">
                      @csrf
                      <button type="submit" class="text-xs font-semibold bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white px-2.5 py-1.5 rounded-lg border border-emerald-250 transition-all" title="Jadikan Gelombang Aktif">
                        Set Aktif
                      </button>
                    </form>
                  @endif

                  {{-- Tombol Edit --}}
                  <a href="{{ route('admin.gelombang.edit', $item) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-650 hover:text-yellow-600 hover:bg-yellow-50 transition-colors" title="Ubah Data">
                    <i class="fas fa-edit"></i>
                  </a>

                  {{-- Tombol Hapus --}}
                  <form method="POST" action="{{ route('admin.gelombang.destroy', $item) }}" onsubmit="return confirm('Hapus gelombang ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-650 hover:text-red-600 hover:bg-red-50 transition-colors" title="Hapus Data">
                      <i class="fas fa-trash"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="5" class="px-4 py-12 text-center text-slate-400">
                <i class="fas fa-layer-group text-4xl mb-3 block"></i>
                <p>Belum ada data gelombang pendaftaran.</p>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  {{-- Kolom Kanan: Form Tambah / Edit --}}
  <div class="lg:col-span-1">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden sticky top-24">
      <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
        <h3 class="font-bold text-slate-800 flex items-center gap-2">
          @if(isset($gelombang))
            <i class="fas fa-edit text-yellow-500"></i> Ubah Gelombang
          @else
            <i class="fas fa-plus text-primary"></i> Tambah Gelombang
          @endif
        </h3>
        <p class="text-xxs text-slate-400 mt-0.5">
          @if(isset($gelombang))
            Perbarui detail informasi gelombang pendaftaran terpilih
          @else
            Buat dan konfigurasikan gelombang pendaftaran baru
          @endif
        </p>
      </div>

      <form method="POST" action="{{ isset($gelombang) ? route('admin.gelombang.update', $gelombang) : route('admin.gelombang.store') }}" class="p-6 space-y-4">
        @csrf
        @if(isset($gelombang))
          @method('PUT')
        @endif

        {{-- Nama Gelombang --}}
        <div>
          <label for="nama_gelombang" class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Gelombang <span class="text-red-500">*</span></label>
          <input type="text" id="nama_gelombang" name="nama_gelombang" value="{{ old('nama_gelombang', $gelombang->nama_gelombang ?? '') }}" required
            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm @error('nama_gelombang') border-red-400 @enderror"
            placeholder="Contoh: Gelombang I">
          @error('nama_gelombang') <p class="text-red-500 text-xxs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Tahun Ajaran --}}
        <div>
          <label for="tahun_ajaran" class="block text-xs font-semibold text-slate-700 mb-1.5">Tahun Ajaran <span class="text-red-500">*</span></label>
          <input type="text" id="tahun_ajaran" name="tahun_ajaran" value="{{ old('tahun_ajaran', $gelombang->tahun_ajaran ?? date('Y').'/'.(date('Y')+1)) }}" required
            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm @error('tahun_ajaran') border-red-400 @enderror"
            placeholder="Contoh: 2026/2027">
          @error('tahun_ajaran') <p class="text-red-500 text-xxs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Tanggal Mulai --}}
        <div>
          <label for="tanggal_mulai" class="block text-xs font-semibold text-slate-700 mb-1.5">Tanggal Mulai</label>
          <input type="date" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai', isset($gelombang) && $gelombang->tanggal_mulai ? $gelombang->tanggal_mulai->format('Y-m-d') : '') }}"
            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm @error('tanggal_mulai') border-red-400 @enderror">
          @error('tanggal_mulai') <p class="text-red-500 text-xxs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Tanggal Selesai --}}
        <div>
          <label for="tanggal_selesai" class="block text-xs font-semibold text-slate-700 mb-1.5">Tanggal Selesai</label>
          <input type="date" id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai', isset($gelombang) && $gelombang->tanggal_selesai ? $gelombang->tanggal_selesai->format('Y-m-d') : '') }}"
            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm @error('tanggal_selesai') border-red-400 @enderror">
          @error('tanggal_selesai') <p class="text-red-500 text-xxs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Keterangan --}}
        <div>
          <label for="keterangan" class="block text-xs font-semibold text-slate-700 mb-1.5">Keterangan / Deskripsi</label>
          <input type="text" id="keterangan" name="keterangan" value="{{ old('keterangan', $gelombang->keterangan ?? '') }}"
            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm @error('keterangan') border-red-400 @enderror"
            placeholder="Contoh: Jalur Minat & Prestasi">
          @error('keterangan') <p class="text-red-500 text-xxs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Checkbox Set Aktif (Hanya saat tambah baru, saat edit bisa dicentang juga) --}}
        @if(!isset($gelombang) || !$gelombang->is_aktif)
        <div class="flex items-center gap-2 pt-2">
          <input type="checkbox" id="is_aktif" name="is_aktif" value="1"
            class="rounded border-slate-300 text-primary focus:ring-primary/30 w-4 h-4">
          <label for="is_aktif" class="text-xs font-semibold text-slate-650 cursor-pointer select-none">Jadikan Gelombang Aktif</label>
        </div>
        @endif

        {{-- Buttons --}}
        <div class="flex items-center gap-2 pt-3 border-t border-slate-100">
          <button type="submit"
            class="flex-1 inline-flex items-center justify-center gap-2 bg-primary hover:bg-secondary text-white font-semibold py-2.5 rounded-xl transition-all shadow-sm">
            <i class="fas fa-save text-sm"></i> Simpan
          </button>
          @if(isset($gelombang))
            <a href="{{ route('admin.gelombang.index') }}"
              class="inline-flex items-center justify-center bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-4 py-2.5 rounded-xl transition-all">
              Batal
            </a>
          @endif
        </div>
      </form>
    </div>
  </div>

</div>
@endsection
