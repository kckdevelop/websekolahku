@extends('layouts.admin')
@section('title', 'Manajemen Halaman Program Keahlian')
@section('subtitle', 'Tambah, ubah, dan hapus program keahlian/jurusan sekolah')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
  {{-- Header --}}
  <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
    <div>
      <h2 class="font-semibold text-slate-800">Daftar Program Keahlian</h2>
      <p class="text-xs text-slate-400 mt-0.5">Edit isi profil, keunggulan, dan visualisasi masing-masing jurusan</p>
    </div>
    <a href="{{ route('admin.jurusan.create') }}"
       class="inline-flex items-center gap-2 bg-primary hover:bg-secondary text-white text-sm font-semibold px-4 py-2 rounded-xl transition-colors shadow-sm shadow-primary/30">
      <i class="fas fa-plus"></i> Tambah Jurusan
    </a>
  </div>

  {{-- Table --}}
  <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-slate-100">
      <thead class="bg-slate-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Kompetensi Keahlian</th>
          <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Slug / URL</th>
          <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Hero Banner</th>
          <th class="px-4 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Urutan</th>
          <th class="px-4 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
          <th class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-slate-100">
        @forelse($jurusanContents as $item)
        <tr class="hover:bg-slate-50 transition-colors">
          <td class="px-6 py-4">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center text-primary flex-shrink-0">
                <i class="{{ $item->icon ?? 'fas fa-graduation-cap' }} text-lg"></i>
              </div>
              <div>
                <p class="text-sm font-semibold text-slate-800">{{ $item->nama_jurusan }}</p>
                <p class="text-xs text-slate-400">Diupdate: {{ $item->updated_at->diffForHumans() }}</p>
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
          <td class="px-4 py-4 text-center">
            <span class="text-sm font-semibold text-slate-600">{{ $item->urutan }}</span>
          </td>
          <td class="px-4 py-4 text-center">
            @if($item->aktif)
              <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-50 text-green-700 border border-green-200">
                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Aktif
              </span>
            @else
              <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-500 border border-slate-200">
                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Nonaktif
              </span>
            @endif
          </td>
          <td class="px-6 py-4 text-right">
            <div class="flex items-center justify-end gap-2">
              <a href="{{ route('admin.jurusan.edit', $item) }}"
                 class="inline-flex items-center gap-1 text-xs text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors font-medium">
                <i class="fas fa-edit"></i> Edit
              </a>
              <a href="{{ url('/jurusan/' . $item->slug) }}" target="_blank"
                 class="inline-flex items-center gap-1 text-xs text-slate-600 hover:text-slate-800 bg-slate-50 hover:bg-slate-100 px-3 py-1.5 rounded-lg transition-colors">
                <i class="fas fa-external-link-alt"></i> Lihat
              </a>
              <button type="button"
                      onclick="confirmDelete('{{ $item->nama_jurusan }}', '{{ route('admin.jurusan.destroy', $item) }}')"
                      class="inline-flex items-center gap-1 text-xs text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-colors font-medium">
                <i class="fas fa-trash"></i> Hapus
              </button>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="px-6 py-16 text-center">
            <div class="flex flex-col items-center gap-3 text-slate-400">
              <i class="fas fa-graduation-cap text-4xl"></i>
              <p class="text-sm">Belum ada program keahlian. <a href="{{ route('admin.jurusan.create') }}" class="text-primary underline">Tambah sekarang</a></p>
            </div>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

{{-- Delete Confirm Modal --}}
<div id="delete-modal" class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/40 backdrop-blur-sm">
  <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 overflow-hidden">
    <div class="px-6 py-5 border-b border-slate-100 flex items-center gap-3">
      <div class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center flex-shrink-0">
        <i class="fas fa-exclamation-triangle text-red-500"></i>
      </div>
      <div>
        <h3 class="font-bold text-slate-800">Hapus Jurusan</h3>
        <p class="text-xs text-slate-400">Tindakan ini tidak dapat dibatalkan</p>
      </div>
    </div>
    <div class="px-6 py-5">
      <p class="text-sm text-slate-600">Anda akan menghapus jurusan <strong id="delete-name" class="text-slate-800"></strong> beserta semua foto dan kontennya. Lanjutkan?</p>
    </div>
    <div class="px-6 py-4 bg-slate-50 flex justify-end gap-3">
      <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 text-sm font-medium rounded-xl hover:bg-slate-100 transition">Batal</button>
      <form id="delete-form" method="POST">
        @csrf @method('DELETE')
        <button type="submit" class="px-5 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-xl transition shadow-sm">
          <i class="fas fa-trash mr-1"></i> Ya, Hapus
        </button>
      </form>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
  function confirmDelete(name, url) {
    document.getElementById('delete-name').textContent = name;
    document.getElementById('delete-form').action = url;
    const modal = document.getElementById('delete-modal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
  }
  function closeDeleteModal() {
    const modal = document.getElementById('delete-modal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }
  document.getElementById('delete-modal').addEventListener('click', function(e) {
    if (e.target === this) closeDeleteModal();
  });
</script>
@endsection
