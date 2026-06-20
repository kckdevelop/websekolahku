<div id="pendaftar-table-container">
  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead class="bg-slate-50 border-b border-slate-100">
        <tr>
          <th class="text-left py-3 px-4 font-semibold text-slate-600 text-xs">#</th>
          <th class="text-left py-3 px-4 font-semibold text-slate-600 text-xs">No. Daftar</th>
          <th class="text-left py-3 px-4 font-semibold text-slate-600 text-xs">Nama Lengkap</th>
          <th class="text-left py-3 px-4 font-semibold text-slate-600 text-xs">Gelombang</th>
          <th class="text-center py-3 px-4 font-semibold text-slate-600 text-xs">Foto</th>
          <th class="text-center py-3 px-4 font-semibold text-slate-600 text-xs">Berkas</th>
          <th class="text-center py-3 px-4 font-semibold text-slate-600 text-xs">Verifikasi</th>
          <th class="text-center py-3 px-4 font-semibold text-slate-600 text-xs">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-50">
        @forelse($pendaftarans as $p)
        <tr class="hover:bg-slate-50/50 transition-colors">
          <td class="py-3 px-4 text-slate-400 text-xs">{{ $pendaftarans->firstItem() + $loop->index }}</td>
          <td class="py-3 px-4">
            <span class="font-mono font-bold text-blue-700 text-xs bg-blue-50 px-2 py-0.5 rounded">
              {{ $p->no_daftar }}
            </span>
          </td>
          <td class="py-3 px-4">
            <p class="font-semibold text-slate-800 text-sm">{{ $p->nama_lengkap }}</p>
            <p class="text-xs text-slate-400">{{ $p->asal_sekolah }}</p>
          </td>
          <td class="py-3 px-4 text-xs text-slate-500">{{ $p->gelombang ?? '-' }}</td>
          <td class="py-3 px-4 text-center">
            @if($p->foto_siswa)
              <span class="inline-flex items-center gap-1 text-xs font-medium text-green-700 bg-green-50 px-2 py-0.5 rounded-full">
                <i class="fas fa-check text-[10px]"></i> Ada
              </span>
            @else
              <span class="inline-flex items-center gap-1 text-xs font-medium text-red-600 bg-red-50 px-2 py-0.5 rounded-full">
                <i class="fas fa-times text-[10px]"></i> Belum
              </span>
            @endif
          </td>
          <td class="py-3 px-4 text-center">
            @php $berkas = $p->berkas_lengkap ?? []; @endphp
            @if(count($berkas) >= 4)
              <span class="text-xs font-medium text-green-700 bg-green-50 px-2 py-0.5 rounded-full">Lengkap</span>
            @elseif(count($berkas) > 0)
              <span class="text-xs font-medium text-orange-700 bg-orange-50 px-2 py-0.5 rounded-full">Sebagian</span>
            @else
              <span class="text-xs font-medium text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full">Belum</span>
            @endif
          </td>
          <td class="py-3 px-4 text-center">
            @if($p->verified_at)
              <span class="text-xs font-medium text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full">
                <i class="fas fa-check-circle text-[10px]"></i> {{ $p->verified_at->format('d/m') }}
              </span>
            @else
              <span class="text-xs font-medium text-slate-400 bg-slate-100 px-2 py-0.5 rounded-full">Pending</span>
            @endif
          </td>
          <td class="py-3 px-4 text-center">
            <div class="flex items-center justify-center gap-1">
              <a href="{{ route('petugas.show', $p) }}"
                 class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-600 text-white text-xs rounded-lg hover:bg-blue-700 transition font-medium">
                <i class="fas fa-edit text-[10px]"></i> Proses
              </a>
              <a href="{{ route('petugas.kartu', $p) }}" target="_blank"
                 class="inline-flex items-center gap-1 px-3 py-1.5 bg-slate-700 text-white text-xs rounded-lg hover:bg-slate-800 transition font-medium">
                <i class="fas fa-print text-[10px]"></i> Kartu
              </a>
              <button type="button"
                class="btn-delete inline-flex items-center gap-1 px-3 py-1.5 bg-red-600 text-white text-xs rounded-lg hover:bg-red-700 transition font-medium"
                data-nama="{{ $p->nama_lengkap }}"
                data-no="{{ $p->no_daftar }}"
                data-url="{{ route('petugas.destroy', $p) }}">
                <i class="fas fa-trash text-[10px]"></i> Hapus
              </button>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="8" class="py-12 text-center text-slate-400">
            <i class="fas fa-inbox text-3xl mb-2 block"></i>
            Tidak ada data pendaftaran yang ditemukan.
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if($pendaftarans->hasPages())
  <div class="px-4 py-3 border-t border-slate-100 pagination-container">
    {{ $pendaftarans->links() }}
  </div>
  @endif
</div>
