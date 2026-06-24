@extends('layouts.admin')
@section('title', 'Lowongan Kerja (BKK)')
@section('subtitle', 'Kelola informasi lowongan pekerjaan dari mitra industri sekolah')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
  <div class="px-6 py-4 border-b border-slate-100">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
      <div>
        <h2 class="font-semibold text-slate-800">Semua Lowongan Kerja</h2>
        <p class="text-xs text-slate-400 mt-0.5">Total: {{ $lowongans->count() }} data</p>
      </div>
      <div>
        <a href="{{ route('admin.bkk.lowongan.create') }}" class="inline-flex items-center gap-2 bg-primary hover:bg-secondary text-white text-sm font-medium px-4 py-2.5 rounded-xl transition-colors">
          <i class="fas fa-plus"></i> Tambah Lowongan
        </a>
      </div>
    </div>
  </div>

  @if(session('success'))
    <div class="mx-6 mt-4 p-4 bg-emerald-50 border border-emerald-100 text-emerald-600 rounded-xl text-sm flex items-center gap-2">
      <i class="fas fa-check-circle"></i>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-slate-100">
      <thead class="bg-slate-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">No</th>
          <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Perusahaan</th>
          <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Posisi / Tipe</th>
          <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Jurusan</th>
          <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Batas Lamaran</th>
          <th class="px-6 py-3 text-center text-xs font-semibold text-slate-500 uppercase">Status</th>
          <th class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase">Aksi</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-slate-100">
        @forelse($lowongans as $index => $item)
        <tr class="hover:bg-slate-50 transition-colors">
          <td class="px-6 py-4 text-sm text-slate-500">{{ $index + 1 }}</td>
          <td class="px-6 py-4">
            <div class="flex items-center gap-3">
              <img src="{{ $item->logo_src }}" class="w-10 h-10 rounded-xl object-cover border border-slate-100 flex-shrink-0 bg-slate-50">
              <div>
                <p class="text-sm font-semibold text-slate-800">{{ $item->nama_perusahaan }}</p>
                <p class="text-xs text-slate-400"><i class="fas fa-map-marker-alt mr-1"></i>{{ $item->lokasi }}</p>
              </div>
            </div>
          </td>
          <td class="px-6 py-4">
            <p class="text-sm font-semibold text-slate-800">{{ $item->posisi }}</p>
            <span class="inline-block px-2.5 py-0.5 bg-orange-50 text-orange-600 rounded-full text-xxs font-semibold mt-1">
              {{ $item->tipe_pekerjaan }}
            </span>
          </td>
          <td class="px-6 py-4">
            <span class="text-sm text-slate-600 font-medium bg-slate-100 px-2 py-1 rounded-lg">
              {{ $item->jurusan_relevan ?? 'Semua Jurusan' }}
            </span>
          </td>
          <td class="px-6 py-4">
            <p class="text-sm font-medium text-slate-700">{{ $item->batas_lamaran->format('d M Y') }}</p>
            @if($item->is_open)
              <span class="inline-block text-xxs text-emerald-600 font-semibold"><i class="fas fa-hourglass-half mr-1"></i>Aktif</span>
            @else
              <span class="inline-block text-xxs text-rose-600 font-semibold"><i class="fas fa-calendar-times mr-1"></i>Tutup</span>
            @endif
          </td>
          <td class="px-6 py-4 text-center">
            <form method="POST" action="{{ route('admin.bkk.lowongan.toggle-aktif', $item) }}">
              @csrf
              <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold transition {{ $item->aktif ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100' : 'bg-slate-50 text-slate-400 border border-slate-200 hover:bg-slate-100' }}">
                <span class="w-1.5 h-1.5 rounded-full {{ $item->aktif ? 'bg-emerald-500' : 'bg-slate-300' }}"></span>
                {{ $item->aktif ? 'Tampilkan' : 'Sembunyikan' }}
              </button>
            </form>
          </td>
          <td class="px-6 py-4 text-right">
            <div class="flex items-center justify-end gap-2">
              <a href="{{ route('admin.bkk.lowongan.edit', $item) }}" class="inline-flex items-center gap-1 text-xs text-blue-600 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors">
                <i class="fas fa-edit"></i> Edit
              </a>
              <form method="POST" action="{{ route('admin.bkk.lowongan.destroy', $item) }}" onsubmit="return confirm('Hapus lowongan kerja ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="inline-flex items-center gap-1 text-xs text-red-600 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-colors">
                  <i class="fas fa-trash"></i> Hapus
                </button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="7" class="px-6 py-16 text-center text-slate-400">
            <i class="fas fa-briefcase text-4xl mb-3 block text-slate-300"></i>
            <p class="font-medium text-slate-500">Belum ada lowongan kerja</p>
            <p class="text-xs text-slate-400 mt-1">Gunakan tombol di atas untuk menambahkan postingan pertama.</p>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
