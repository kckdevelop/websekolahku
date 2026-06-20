<div id="kesehatan-table-container">
  <div class="overflow-x-auto">
    <table class="w-full text-left border-collapse text-slate-700">
      <thead>
        <tr class="bg-slate-50 border-b border-slate-100 text-slate-500 text-xxs uppercase tracking-wider font-bold">
          <th class="py-3 px-5">#</th>
          <th class="py-3 px-5">No Daftar</th>
          <th class="py-3 px-5">Nama Calon Siswa</th>
          <th class="py-3 px-5">Asal Sekolah</th>
          <th class="py-3 px-5">Tinggi / Berat / Gol. Darah</th>
          <th class="py-3 px-5">Buta Warna / Tato</th>
          <th class="py-3 px-5">Status Pemeriksaan</th>
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
            @if($p->kesehatan_verified_at)
              <span class="font-semibold block text-slate-800">TB: {{ $p->kesehatan_tinggi_badan }} cm | BB: {{ $p->kesehatan_berat_badan }} kg</span>
              <span class="text-slate-500 text-xxs block mt-0.5">Gol. Darah: {{ $p->kesehatan_golongan_darah ?? '-' }} | Mata: {{ $p->kesehatan_mata_minus ?? '-' }}</span>
            @else
              <span class="text-slate-400 italic">Belum diperiksa</span>
            @endif
          </td>
          <td class="py-4 px-5">
            @if($p->kesehatan_verified_at)
              <span class="font-semibold block {{ $p->kesehatan_buta_warna === 'ya' ? 'text-rose-600' : 'text-slate-800' }}">
                Buta Warna: {{ $p->kesehatan_buta_warna === 'ya' ? 'Ya' : 'Tidak' }}
              </span>
              <span class="text-slate-500 text-xxs block mt-0.5">Tato/Tindik: {{ ucfirst($p->kesehatan_tato_tindik) }}</span>
            @else
              <span class="text-slate-400 italic">Belum diperiksa</span>
            @endif
          </td>
          <td class="py-4 px-5">
            @if($p->kesehatan_verified_at)
              <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xxs font-bold bg-emerald-100 text-emerald-700">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Sudah Diperiksa
              </span>
            @else
              <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xxs font-bold bg-amber-100 text-amber-700">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-ping"></span> Belum Diperiksa
              </span>
            @endif
          </td>
          <td class="py-4 px-5 text-center">
            <a href="{{ route('petugas.kesehatan.show', $p->id) }}"
               class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg text-xs font-bold transition">
              <i class="fas fa-heartbeat"></i> Periksa
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
