<div id="wawancara-table-container">
  <div class="overflow-x-auto">
    <table class="w-full text-left border-collapse text-slate-700">
      <thead>
        <tr class="bg-slate-50 border-b border-slate-100 text-slate-500 text-xxs uppercase tracking-wider font-bold">
          <th class="py-3 px-5">#</th>
          <th class="py-3 px-5">No Daftar</th>
          <th class="py-3 px-5">Nama Calon Siswa</th>
          <th class="py-3 px-5">Asal Sekolah</th>
          <th class="py-3 px-5">Gaya Belajar</th>
          <th class="py-3 px-5">Minat Bakat</th>
          <th class="py-3 px-5">Status Uji</th>
          <th class="py-3 px-5 text-center">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-50 text-xs">
        @forelse($pendaftarans as $p)
        <tr class="hover:bg-slate-50/50 transition">
          <td class="py-4 px-5 text-slate-400">{{ $pendaftarans->firstItem() + $loop->index }}</td>
          <td class="py-4 px-5 font-mono font-bold text-blue-600">{{ $p->no_daftar }}</td>
          <td class="py-4 px-5">
            <span class="font-bold text-slate-800 block">{{ $p->nama_lengkap }}</span>
            <span class="text-slate-400 text-xxs block mt-0.5">{{ $p->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}</span>
          </td>
          <td class="py-4 px-5 text-slate-600">{{ $p->asal_sekolah }}</td>
          <td class="py-4 px-5">
            @if($p->gaya_belajar_verified_at)
              <span class="font-bold text-purple-750 px-2 py-0.5 bg-purple-50 rounded-lg text-xxs border border-purple-100 uppercase">
                {{ $p->gaya_belajar_tipe }}
              </span>
            @else
              <span class="text-slate-400 italic">Belum diuji</span>
            @endif
          </td>
          <td class="py-4 px-5">
            @if($p->gaya_belajar_verified_at)
              <span class="font-semibold text-slate-800 truncate block max-w-xs">{{ $p->gaya_belajar_minat_bakat }}</span>
            @else
              <span class="text-slate-400 italic">Belum diuji</span>
            @endif
          </td>
          <td class="py-4 px-5">
            @if($p->gaya_belajar_verified_at && $p->wawancara_verified_at)
              <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xxs font-bold bg-emerald-100 text-emerald-700">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Selesai Wawancara
              </span>
            @else
              <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xxs font-bold bg-amber-100 text-amber-700">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-ping"></span> Belum Wawancara
              </span>
            @endif
          </td>
          <td class="py-4 px-5 text-center">
            <a href="{{ route('petugas.wawancara.show', $p->id) }}" 
               class="inline-flex items-center gap-1 px-3 py-1.5 bg-purple-50 hover:bg-purple-100 text-purple-650 rounded-lg text-xs font-bold transition">
              <i class="fas fa-comments"></i> Wawancara &amp; Tes
            </a>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="8" class="py-12 text-center text-slate-400">
            <i class="fas fa-inbox text-3xl mb-2 block"></i>
            Tidak ada data pendaftar ditemukan.
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if($pendaftarans->hasPages())
  <div class="px-5 py-4 border-t border-slate-100 pagination-container">
    {{ $pendaftarans->links() }}
  </div>
  @endif
</div>
