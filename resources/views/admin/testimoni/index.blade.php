@extends('layouts.admin')
@section('title', 'Testimoni')
@section('subtitle', 'Kelola testimoni alumni dan orang tua siswa')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
  <div class="px-6 py-4 border-b border-slate-100">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
      <div>
        <h2 class="font-semibold text-slate-800">Semua Testimoni</h2>
        <p class="text-xs text-slate-400 mt-0.5">Total: {{ $testimoni->total() }} data{{ $search ? ' ditemukan' : '' }}</p>
      </div>
      <div class="flex items-center gap-2">
        <form method="GET" action="{{ route('admin.testimoni.index') }}" class="flex items-center gap-2">
          <div class="relative">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama / pekerjaan..."
              class="pl-8 pr-4 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary w-52">
          </div>
          <button type="submit" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-sm transition-colors">Cari</button>
          @if($search)
            <a href="{{ route('admin.testimoni.index') }}" class="px-3 py-2 text-sm text-red-500 hover:text-red-700 transition-colors" title="Reset"><i class="fas fa-times"></i></a>
          @endif
        </form>
        <a href="{{ route('admin.testimoni.create') }}" class="inline-flex items-center gap-2 bg-primary hover:bg-secondary text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors"><i class="fas fa-plus"></i> Tambah Testimoni</a>
      </div>
    </div>
  </div>
  <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-slate-100">
      <thead class="bg-slate-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">No</th>
          <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Nama & Alumni Tahun</th>
          <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Pekerjaan / Jabatan</th>
          <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Kutipan</th>
          <th class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase">Aksi</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-slate-100">
        @forelse($testimoni as $index => $item)
        <tr class="hover:bg-slate-50">
          <td class="px-6 py-4 text-sm text-slate-500">{{ $testimoni->firstItem() + $index }}</td>
          <td class="px-6 py-4">
            <div class="flex items-center gap-3">
              @if($item->foto)
                <img src="{{ asset('storage/' . $item->foto) }}" class="w-9 h-9 rounded-full object-cover flex-shrink-0 border border-slate-200">
              @else
                <div class="w-9 h-9 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0 text-primary font-bold text-sm">{{ strtoupper(substr($item->nama,0,1)) }}</div>
              @endif
              <div>
                <p class="text-sm font-semibold text-slate-800">{{ $item->nama }}</p>
                <p class="text-xs text-slate-400">Lulusan Tahun: {{ $item->alumni_tahun }}</p>
              </div>
            </div>
          </td>
          <td class="px-6 py-4 text-sm text-slate-600 font-medium">{{ $item->pekerjaan }}</td>
          <td class="px-6 py-4 text-sm text-slate-600 max-w-xs"><p class="line-clamp-2 italic">"{{ $item->kutipan }}"</p></td>
          <td class="px-6 py-4 text-right">
            <div class="flex items-center justify-end gap-2">
              <a href="{{ route('admin.testimoni.edit', $item) }}" class="inline-flex items-center gap-1 text-xs text-blue-600 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors"><i class="fas fa-edit"></i> Edit</a>
              <form method="POST" action="{{ route('admin.testimoni.destroy', $item) }}" onsubmit="return confirm('Hapus testimoni ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="inline-flex items-center gap-1 text-xs text-red-600 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-colors"><i class="fas fa-trash"></i> Hapus</button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="5" class="px-6 py-12 text-center text-slate-400"><i class="fas fa-comment-alt text-4xl mb-3 block"></i><p>Belum ada testimoni</p></td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="px-6 py-4 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
    <p class="text-xs text-slate-400">
      Menampilkan {{ $testimoni->firstItem() ?? 0 }}–{{ $testimoni->lastItem() ?? 0 }} dari {{ $testimoni->total() }} data
    </p>
    @if($testimoni->hasPages()){{ $testimoni->links() }}@endif
  </div>
</div>
@endsection
