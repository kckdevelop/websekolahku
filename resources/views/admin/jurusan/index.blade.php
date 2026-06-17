@extends('layouts.admin')
@section('title', 'Manajemen Halaman Program Keahlian')
@section('subtitle', 'Ubah konten statis pada halaman program keahlian/jurusan sekolah')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
  {{-- Header --}}
  <div class="px-6 py-4 border-b border-slate-100">
    <div>
      <h2 class="font-semibold text-slate-800">Daftar Halaman Program Keahlian</h2>
      <p class="text-xs text-slate-400 mt-0.5">Edit isi profil, keunggulan, dan visualisasi masing-masing jurusan</p>
    </div>
  </div>

  {{-- Table --}}
  <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-slate-100">
      <thead class="bg-slate-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Kompetensi Keahlian</th>
          <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Slug</th>
          <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Hero Banner</th>
          <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Poin Unggulan</th>
          <th class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-slate-100">
        @foreach($jurusanContents as $item)
        <tr class="hover:bg-slate-50 transition-colors">
          <td class="px-6 py-4">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center text-primary flex-shrink-0">
                <i class="fas fa-graduation-cap text-lg"></i>
              </div>
              <div>
                <p class="text-sm font-semibold text-slate-800">{{ $item->nama_jurusan }}</p>
                <p class="text-xs text-slate-400">Terakhir diupdate: {{ $item->updated_at->diffForHumans() }}</p>
              </div>
            </div>
          </td>
          <td class="px-6 py-4 text-sm font-mono text-slate-500">/jurusan/{{ $item->slug }}</td>
          <td class="px-6 py-4">
            <div class="max-w-xs">
              <p class="text-sm font-medium text-slate-800 truncate">{{ $item->hero_judul }}</p>
              @if($item->hero_subjudul)
                <p class="text-xs text-slate-400 truncate mt-0.5">{{ $item->hero_subjudul }}</p>
              @endif
            </div>
          </td>
          <td class="px-6 py-4">
            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-600">
              {{ is_array($item->poin_unggulan) ? count($item->poin_unggulan) : 0 }} Poin
            </span>
          </td>
          <td class="px-6 py-4 text-right">
            <div class="flex items-center justify-end gap-2">
              <a href="{{ route('admin.jurusan.edit', $item) }}"
                 class="inline-flex items-center gap-1 text-xs text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors font-medium">
                <i class="fas fa-edit"></i> Edit Halaman
              </a>
              <a href="{{ url('/jurusan/' . $item->slug) }}" target="_blank"
                 class="inline-flex items-center gap-1 text-xs text-slate-600 hover:text-slate-800 bg-slate-50 hover:bg-slate-100 px-3 py-1.5 rounded-lg transition-colors">
                <i class="fas fa-external-link-alt"></i> Lihat
              </a>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
