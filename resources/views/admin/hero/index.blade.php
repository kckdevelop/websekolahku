@extends('layouts.admin')
@section('title', 'Manajemen Hero Slideshow')
@section('subtitle', 'Kelola gambar dan teks utama yang tampil pada halaman depan (Beranda)')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
  {{-- Header --}}
  <div class="px-6 py-4 border-b border-slate-100">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
      <div>
        <h2 class="font-semibold text-slate-800">Daftar Hero Slides</h2>
        <p class="text-xs text-slate-400 mt-0.5">Total: {{ $heroes->count() }} slide</p>
      </div>
      <div>
        <a href="{{ route('admin.hero.create') }}"
           class="inline-flex items-center gap-2 bg-primary hover:bg-secondary text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors">
          <i class="fas fa-plus"></i> Tambah Slide
        </a>
      </div>
    </div>
  </div>

  {{-- Table --}}
  <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-slate-100">
      <thead class="bg-slate-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Urutan</th>
          <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Gambar</th>
          <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Konten / Teks</th>
          <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
          <th class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-slate-100">
        @forelse($heroes as $item)
        <tr class="hover:bg-slate-50 transition-colors">
          <td class="px-6 py-4 text-sm font-semibold text-slate-600">#{{ $item->urutan }}</td>
          <td class="px-6 py-4">
            <div class="w-24 h-14 rounded-lg overflow-hidden border border-slate-100">
              <img src="{{ $item->gambar_src }}" alt="{{ $item->judul }}" class="w-full h-full object-cover">
            </div>
          </td>
          <td class="px-6 py-4">
            <div class="max-w-md">
              <p class="text-sm font-semibold text-slate-800">{{ $item->judul }}</p>
              @if($item->deskripsi)
                <p class="text-xs text-slate-500 line-clamp-1 mt-0.5">{{ $item->deskripsi }}</p>
              @endif
              <div class="flex items-center gap-2 mt-1.5">
                <span class="inline-flex px-1.5 py-0.5 rounded text-xxs bg-slate-100 text-slate-600">Button: {{ $item->label_tombol }}</span>
                <span class="inline-flex px-1.5 py-0.5 rounded text-xxs bg-slate-100 text-slate-600 truncate max-w-[150px]">Link: {{ $item->link_tombol }}</span>
              </div>
            </div>
          </td>
          <td class="px-6 py-4">
            @if($item->aktif)
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">Aktif</span>
            @else
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">Non-Aktif</span>
            @endif
          </td>
          <td class="px-6 py-4 text-right">
            <div class="flex items-center justify-end gap-2">
              <a href="{{ route('admin.hero.edit', $item) }}"
                 class="inline-flex items-center gap-1 text-xs text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors">
                <i class="fas fa-edit"></i> Edit
              </a>
              <form method="POST" action="{{ route('admin.hero.destroy', $item) }}"
                    onsubmit="return confirm('Hapus hero slide ini?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                  class="inline-flex items-center gap-1 text-xs text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-colors">
                  <i class="fas fa-trash"></i> Hapus
                </button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="5" class="px-6 py-12 text-center text-slate-400">
            <i class="fas fa-images text-4xl mb-3 block"></i>
            <p class="font-medium">Belum ada slide hero</p>
            <p class="text-xs text-slate-400 mt-1">Slide hero fallback bawaan akan ditampilkan jika kosong</p>
            <a href="{{ route('admin.hero.create') }}" class="text-primary hover:underline text-sm mt-3 inline-block font-semibold">Tambah slide pertama</a>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
