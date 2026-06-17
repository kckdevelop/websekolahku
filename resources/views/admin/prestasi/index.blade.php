@extends('layouts.admin')
@section('title', 'Daftar Prestasi')
@section('subtitle', 'Kelola data prestasi dan penghargaan sekolah')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
  <div class="px-6 py-4 border-b border-slate-100">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
      <div>
        <h2 class="font-semibold text-slate-800">Semua Prestasi</h2>
        <p class="text-xs text-slate-400 mt-0.5">Total: {{ $prestasi->total() }} data{{ $search ? ' ditemukan' : '' }}</p>
      </div>
      <div class="flex items-center gap-2">
        <form method="GET" action="{{ route('admin.prestasi.index') }}" class="flex items-center gap-2">
          <div class="relative">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari judul / peraih..."
              class="pl-8 pr-4 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary w-52">
          </div>
          <button type="submit" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-sm transition-colors">Cari</button>
          @if($search)
            <a href="{{ route('admin.prestasi.index') }}" class="px-3 py-2 text-sm text-red-500 hover:text-red-700 transition-colors" title="Reset"><i class="fas fa-times"></i></a>
          @endif
        </form>
        <a href="{{ route('admin.prestasi.create') }}"
           class="inline-flex items-center gap-2 bg-primary hover:bg-secondary text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors">
          <i class="fas fa-plus"></i> Tambah Prestasi
        </a>
      </div>
    </div>
  </div>
  <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-slate-100">
      <thead class="bg-slate-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">No</th>
          <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Judul</th>
          <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Peraih</th>
          <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Tingkat</th>
          <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Tanggal</th>
          <th class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase">Aksi</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-slate-100">
        @forelse($prestasi as $index => $item)
        <tr class="hover:bg-slate-50">
          <td class="px-6 py-4 text-sm text-slate-500">{{ $prestasi->firstItem() + $index }}</td>
          <td class="px-6 py-4">
            <div class="flex items-center gap-3">
              @if($item->foto)
                <img src="{{ asset('storage/' . $item->foto) }}" class="w-10 h-10 rounded-lg object-cover flex-shrink-0">
              @else
                <div class="w-10 h-10 rounded-lg bg-yellow-100 flex items-center justify-center flex-shrink-0"><i class="fas fa-trophy text-yellow-500"></i></div>
              @endif
              <div>
                <p class="text-sm font-medium text-slate-800 line-clamp-1">{{ $item->judul }}</p>
                <p class="text-xs text-slate-400">{{ $item->kategori }}</p>
              </div>
            </div>
          </td>
          <td class="px-6 py-4 text-sm text-slate-600">{{ $item->peraih }}</td>
          <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">{{ $item->tingkat }}</span></td>
          <td class="px-6 py-4 text-sm text-slate-500">{{ $item->tanggal->format('d M Y') }}</td>
          <td class="px-6 py-4 text-right">
            <div class="flex items-center justify-end gap-2">
              <a href="{{ route('admin.prestasi.edit', $item) }}" class="inline-flex items-center gap-1 text-xs text-blue-600 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors"><i class="fas fa-edit"></i> Edit</a>
              <form method="POST" action="{{ route('admin.prestasi.destroy', $item) }}" onsubmit="return confirm('Hapus prestasi ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="inline-flex items-center gap-1 text-xs text-red-600 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-colors"><i class="fas fa-trash"></i> Hapus</button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="6" class="px-6 py-12 text-center text-slate-400"><i class="fas fa-trophy text-4xl mb-3 block"></i><p>Belum ada data prestasi</p></td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="px-6 py-4 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
    <p class="text-xs text-slate-400">
      Menampilkan {{ $prestasi->firstItem() ?? 0 }}–{{ $prestasi->lastItem() ?? 0 }} dari {{ $prestasi->total() }} data
    </p>
    @if($prestasi->hasPages()){{ $prestasi->links() }}@endif
  </div>
</div>
@endsection
