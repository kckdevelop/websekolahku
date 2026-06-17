@extends('layouts.admin')
@section('title', 'Pesan Masuk')
@section('subtitle', 'Daftar pesan dari formulir Hubungi Kami')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
  {{-- Header --}}
  <div class="px-6 py-4 border-b border-slate-100">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
      <div>
        <h2 class="font-semibold text-slate-800">Semua Pesan</h2>
        <p class="text-xs text-slate-400 mt-0.5">Total: {{ $pesans->total() }} pesan{{ $search ? ' ditemukan' : '' }}</p>
      </div>
      <div class="flex items-center gap-2">
        <form method="GET" action="{{ route('admin.pesan.index') }}" class="flex items-center gap-2">
          <div class="relative">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari pesan..."
              class="pl-8 pr-4 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary w-52">
          </div>
          <button type="submit" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-sm transition-colors">Cari</button>
          @if($search)
            <a href="{{ route('admin.pesan.index') }}" class="px-3 py-2 text-sm text-red-500 hover:text-red-700 transition-colors" title="Reset pencarian"><i class="fas fa-times"></i></a>
          @endif
        </form>
      </div>
    </div>
  </div>

  {{-- Table --}}
  <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-slate-100">
      <thead class="bg-slate-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">No</th>
          <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Pengirim</th>
          <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Subjek</th>
          <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Tanggal Masuk</th>
          <th class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-slate-100">
        @forelse($pesans as $index => $item)
        <tr class="hover:bg-slate-50 transition-colors">
          <td class="px-6 py-4 text-sm text-slate-500">{{ $pesans->firstItem() + $index }}</td>
          <td class="px-6 py-4">
            <div>
              <p class="text-sm font-medium text-slate-800">{{ $item->nama }}</p>
              <p class="text-xs text-slate-400"><i class="far fa-envelope text-[10px]"></i> {{ $item->email }}</p>
            </div>
          </td>
          <td class="px-6 py-4">
            <span class="text-sm text-slate-700 font-medium line-clamp-1" title="{{ $item->subjek }}">{{ $item->subjek }}</span>
            <p class="text-xs text-slate-400 line-clamp-1">{{ Str::limit($item->pesan, 60) }}</p>
          </td>
          <td class="px-6 py-4 text-sm text-slate-500">
            {{ $item->created_at->translatedFormat('d M Y, H:i') }}
            <p class="text-xxs text-slate-400">{{ $item->created_at->diffForHumans() }}</p>
          </td>
          <td class="px-6 py-4 text-right">
            <div class="flex items-center justify-end gap-2">
              <a href="{{ route('admin.pesan.show', $item) }}"
                 class="inline-flex items-center gap-1 text-xs text-orange-600 hover:text-orange-850 bg-orange-50 hover:bg-orange-100 px-3 py-1.5 rounded-lg transition-colors">
                <i class="fas fa-eye"></i> Detail
              </a>
              <form method="POST" action="{{ route('admin.pesan.destroy', $item) }}"
                    onsubmit="return confirm('Hapus pesan dari {{ $item->nama }}?')">
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
            <i class="fas fa-envelope-open text-4xl mb-3 block"></i>
            <p class="font-medium">Kotak Masuk Kosong</p>
            <p class="text-xs text-slate-400 mt-1">Belum ada pesan yang masuk dari pengunjung website.</p>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="px-6 py-4 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
    <p class="text-xs text-slate-400">
      Menampilkan {{ $pesans->firstItem() ?? 0 }}–{{ $pesans->lastItem() ?? 0 }} dari {{ $pesans->total() }} data
    </p>
    @if($pesans->hasPages())
      {{ $pesans->links() }}
    @endif
  </div>
</div>
@endsection
