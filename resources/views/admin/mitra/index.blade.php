@extends('layouts.admin')
@section('title', 'Mitra Industri')
@section('subtitle', 'Kelola logo mitra industri yang tampil di halaman beranda')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
  <div class="px-6 py-4 border-b border-slate-100">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
      <div>
        <h2 class="font-semibold text-slate-800">Semua Mitra</h2>
        <p class="text-xs text-slate-400 mt-0.5">Total: {{ $mitras->total() }} data{{ $search ? ' ditemukan' : '' }}</p>
      </div>
      <div class="flex items-center gap-2">
        <form method="GET" action="{{ route('admin.mitra.index') }}" class="flex items-center gap-2">
          <div class="relative">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama mitra..."
              class="pl-8 pr-4 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary w-52">
          </div>
          <button type="submit" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-sm transition-colors">Cari</button>
          @if($search)
            <a href="{{ route('admin.mitra.index') }}" class="px-3 py-2 text-sm text-red-500 hover:text-red-700 transition-colors" title="Reset"><i class="fas fa-times"></i></a>
          @endif
        </form>
        <a href="{{ route('admin.mitra.create') }}" class="inline-flex items-center gap-2 bg-primary hover:bg-secondary text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors"><i class="fas fa-plus"></i> Tambah Mitra</a>
      </div>
    </div>
  </div>
  <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-slate-100">
      <thead class="bg-slate-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">No</th>
          <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Logo & Nama</th>
          <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Tautan Link</th>
          <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Urutan</th>
          <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Status</th>
          <th class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase">Aksi</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-slate-100">
        @forelse($mitras as $index => $item)
        <tr class="hover:bg-slate-50">
          <td class="px-6 py-4 text-sm text-slate-500">{{ $mitras->firstItem() + $index }}</td>
          <td class="px-6 py-4">
            <div class="flex items-center gap-3">
              <div class="w-16 h-8 rounded border border-slate-200 bg-slate-50 flex items-center justify-center p-1 overflow-hidden flex-shrink-0">
                <img src="{{ $item->logo_src }}" class="max-w-full max-h-full object-contain">
              </div>
              <div>
                <p class="text-sm font-semibold text-slate-800">{{ $item->nama }}</p>
              </div>
            </div>
          </td>
          <td class="px-6 py-4 text-sm text-slate-600 font-medium">
            <a href="{{ $item->link }}" target="_blank" class="text-blue-500 hover:underline inline-flex items-center gap-1">
              {{ Str::limit($item->link, 30) }} <i class="fas fa-external-link-alt text-xxs"></i>
            </a>
          </td>
          <td class="px-6 py-4 text-sm text-slate-600 font-semibold">{{ $item->urutan }}</td>
          <td class="px-6 py-4">
            @if($item->aktif)
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                Aktif
              </span>
            @else
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800">
                Nonaktif
              </span>
            @endif
          </td>
          <td class="px-6 py-4 text-right">
            <div class="flex items-center justify-end gap-2">
              <a href="{{ route('admin.mitra.edit', $item) }}" class="inline-flex items-center gap-1 text-xs text-blue-600 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors"><i class="fas fa-edit"></i> Edit</a>
              <form method="POST" action="{{ route('admin.mitra.destroy', $item) }}" onsubmit="return confirm('Hapus mitra ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="inline-flex items-center gap-1 text-xs text-red-600 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-colors"><i class="fas fa-trash"></i> Hapus</button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="6" class="px-6 py-12 text-center text-slate-400"><i class="fas fa-handshake text-4xl mb-3 block"></i><p>Belum ada mitra industri</p></td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="px-6 py-4 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
    <p class="text-xs text-slate-400">
      Menampilkan {{ $mitras->firstItem() ?? 0 }}–{{ $mitras->lastItem() ?? 0 }} dari {{ $mitras->total() }} data
    </p>
    @if($mitras->hasPages()){{ $mitras->links() }}@endif
  </div>
</div>
@endsection
