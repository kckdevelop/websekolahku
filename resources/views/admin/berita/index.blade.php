@extends('layouts.admin')
@section('title', 'Daftar Berita')
@section('subtitle', 'Kelola artikel dan berita sekolah')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
  {{-- Header --}}
  <div class="px-6 py-4 border-b border-slate-100">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
      <div>
        <h2 class="font-semibold text-slate-800">Semua Berita</h2>
        <p class="text-xs text-slate-400 mt-0.5">Total: {{ $berita->total() }} artikel{{ $search ? ' ditemukan' : '' }}</p>
      </div>
      <div class="flex items-center gap-2">
        <form method="GET" action="{{ route('admin.berita.index') }}" class="flex items-center gap-2">
          <div class="relative">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari judul berita..."
              class="pl-8 pr-4 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary w-52">
          </div>
          <button type="submit" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-sm transition-colors">Cari</button>
          @if($search)
            <a href="{{ route('admin.berita.index') }}" class="px-3 py-2 text-sm text-red-500 hover:text-red-700 transition-colors" title="Reset pencarian"><i class="fas fa-times"></i></a>
          @endif
        </form>
        <a href="{{ route('admin.berita.create') }}"
           class="inline-flex items-center gap-2 bg-primary hover:bg-secondary text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors">
          <i class="fas fa-plus"></i> Tambah Berita
        </a>
      </div>
    </div>
  </div>

  {{-- Table --}}
  <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-slate-100">
      <thead class="bg-slate-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">No</th>
          <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Judul</th>
          <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Tanggal</th>
          <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
          <th class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-slate-100">
        @forelse($berita as $index => $item)
        <tr class="hover:bg-slate-50 transition-colors">
          <td class="px-6 py-4 text-sm text-slate-500">{{ $berita->firstItem() + $index }}</td>
          <td class="px-6 py-4">
            <div class="flex items-center gap-3">
              @if($item->gambar)
                <img src="{{ asset('storage/' . $item->gambar) }}" class="w-10 h-10 rounded-lg object-cover flex-shrink-0">
              @else
                <div class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center flex-shrink-0">
                  <i class="fas fa-newspaper text-slate-400"></i>
                </div>
              @endif
              <div>
                <p class="text-sm font-medium text-slate-800 line-clamp-1">{{ $item->judul }}</p>
                <p class="text-xs text-slate-400">{{ $item->slug }}</p>
              </div>
            </div>
          </td>
          <td class="px-6 py-4 text-sm text-slate-500">{{ $item->tanggal->format('d M Y') }}</td>
          <td class="px-6 py-4">
            @if($item->draft)
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">Draft</span>
            @else
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">Publish</span>
            @endif
          </td>
          <td class="px-6 py-4 text-right">
            <div class="flex items-center justify-end gap-2">
              <a href="{{ route('admin.berita.edit', $item) }}"
                 class="inline-flex items-center gap-1 text-xs text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors">
                <i class="fas fa-edit"></i> Edit
              </a>
              <form method="POST" action="{{ route('admin.berita.destroy', $item) }}"
                    onsubmit="return confirm('Hapus berita ini?')">
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
            <i class="fas fa-newspaper text-4xl mb-3 block"></i>
            <p class="font-medium">Belum ada berita</p>
            <a href="{{ route('admin.berita.create') }}" class="text-primary hover:underline text-sm mt-1 inline-block">Tambah sekarang</a>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="px-6 py-4 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
    <p class="text-xs text-slate-400">
      Menampilkan {{ $berita->firstItem() ?? 0 }}–{{ $berita->lastItem() ?? 0 }} dari {{ $berita->total() }} data
    </p>
    @if($berita->hasPages())
      {{ $berita->links() }}
    @endif
  </div>
</div>
@endsection
