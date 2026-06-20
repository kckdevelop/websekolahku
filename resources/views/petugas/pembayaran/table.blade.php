<div id="pembayaran-table-container">
  <div class="overflow-x-auto">
    <table class="w-full text-left border-collapse text-slate-700">
      <thead>
        <tr class="bg-slate-50 border-b border-slate-100 text-slate-500 text-xxs uppercase tracking-wider font-bold">
          <th class="py-3 px-5">#</th>
          <th class="py-3 px-5">No Daftar / Bayar</th>
          <th class="py-3 px-5">Nama Calon Siswa</th>
          <th class="py-3 px-5">Jurusan Diterima</th>
          <th class="py-3 px-5 text-right">Total Tagihan</th>
          <th class="py-3 px-5 text-right">Terbayar</th>
          <th class="py-3 px-5 text-right">Sisa</th>
          <th class="py-3 px-5 text-center">Progress</th>
          <th class="py-3 px-5 text-center">Status</th>
          <th class="py-3 px-5 text-center">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-50 text-xs">
        @forelse($pendaftarans as $p)
        @php
          $terbayar    = $p->total_terbayar;
          $sisa        = $p->sisa_tagihan;
          $persen      = $p->persen_bayar;
          $statusBayar = $p->status_bayar;
        @endphp
        <tr class="hover:bg-slate-50/50 transition">
          <td class="py-4 px-5 text-slate-400">{{ $pendaftarans->firstItem() + $loop->index }}</td>
          <td class="py-4 px-5">
            <span class="font-mono font-bold text-blue-600 block">{{ $p->no_daftar }}</span>
            <span class="text-slate-400 text-xxs font-mono block mt-0.5" title="Nomor Pembayaran">{{ $p->nomor_pembayaran ?? '-' }}</span>
          </td>
          <td class="py-4 px-5">
            <span class="font-bold text-slate-800 block">{{ $p->nama_lengkap }}</span>
            <span class="text-slate-400 text-xxs">{{ $p->asal_sekolah }}</span>
          </td>
          <td class="py-4 px-5">
            <span class="inline-flex items-center px-2 py-0.5 rounded text-xxs font-bold bg-purple-50 text-purple-700 border border-purple-100 uppercase">
              {{ $p->diterima_di_jurusan ?? '-' }}
            </span>
          </td>
          <td class="py-4 px-5 text-right font-semibold text-slate-700">
            @if($p->total_tagihan)
              Rp {{ number_format($p->total_tagihan, 0, ',', '.') }}
            @else
              <span class="text-slate-300 italic text-xxs">Belum diatur</span>
            @endif
          </td>
          <td class="py-4 px-5 text-right font-bold text-emerald-600">
            Rp {{ number_format($terbayar, 0, ',', '.') }}
          </td>
          <td class="py-4 px-5 text-right font-bold {{ $sisa > 0 ? 'text-rose-500' : 'text-slate-300' }}">
            Rp {{ number_format($sisa, 0, ',', '.') }}
          </td>
          <td class="py-4 px-5">
            <div class="w-full bg-slate-100 rounded-full h-2 min-w-[60px]">
              <div class="h-2 rounded-full {{ $statusBayar === 'lunas' ? 'bg-emerald-500' : ($statusBayar === 'cicilan' ? 'bg-blue-500' : 'bg-rose-300') }}"
                   style="width: {{ $persen }}%"></div>
            </div>
            <span class="text-xxs text-slate-400 block text-center mt-0.5">{{ $persen }}%</span>
          </td>
          <td class="py-4 px-5 text-center">
            @if($statusBayar === 'lunas')
              <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xxs font-bold bg-emerald-100 text-emerald-700">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Lunas
              </span>
            @elseif($statusBayar === 'cicilan')
              <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xxs font-bold bg-blue-100 text-blue-700">
                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span> Cicilan
              </span>
            @else
              <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xxs font-bold bg-rose-100 text-rose-700">
                <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse"></span> Belum
              </span>
            @endif
          </td>
          <td class="py-4 px-5 text-center">
            <a href="{{ route('petugas.pembayaran.show', $p->id) }}"
               class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-600 rounded-lg text-xs font-bold transition">
              <i class="fas fa-wallet"></i> Bayar
            </a>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="10" class="py-10 text-center text-slate-400">Tidak ada data pendaftar ditemukan.</td>
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
