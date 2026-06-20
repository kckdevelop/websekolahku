@extends('layouts.petugas')
@section('title', 'Pembayaran: ' . $pendaftaran->no_daftar)
@section('subtitle', 'Rekap tagihan dan riwayat transaksi titip bayar calon siswa')

@section('content')
<div class="space-y-6">

  <div class="flex items-center justify-between gap-3 mb-2 flex-wrap">
    <a href="{{ route('petugas.pembayaran.dashboard') }}" class="text-slate-500 hover:text-slate-700 flex items-center gap-1 text-sm font-semibold">
      <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
    </a>
    <a href="{{ route('petugas.pembayaran.kartu', $pendaftaran->id) }}" target="_blank" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition flex items-center gap-2 shadow-md shadow-blue-600/10">
      <i class="fas fa-print"></i> Cetak Kartu Pembayaran
    </a>
  </div>

  @if(session('success'))
    <div class="px-4 py-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm flex items-center gap-2">
      <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
  @endif

  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    {{-- Kolom Kiri: Info Siswa + Ringkasan Tagihan --}}
    <div class="space-y-5">

      {{-- Profil Siswa --}}
      <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
        <div class="text-center pb-4 border-b border-slate-50">
          @if($pendaftaran->foto_siswa)
            <img src="{{ asset('storage/' . $pendaftaran->foto_siswa) }}" class="w-24 h-32 object-cover mx-auto rounded-xl border-4 border-slate-100 shadow-sm">
          @else
            <div class="w-24 h-32 bg-slate-100 mx-auto rounded-xl border-2 border-dashed border-slate-200 flex flex-col items-center justify-center">
              <i class="fas fa-user text-slate-300 text-3xl mb-1"></i>
              <span class="text-xxs text-slate-400">Belum difoto</span>
            </div>
          @endif
          <h3 class="font-bold text-slate-800 text-sm mt-3">{{ $pendaftaran->nama_lengkap }}</h3>
          <p class="text-slate-400 text-xxs font-mono mt-1">{{ $pendaftaran->no_daftar }}</p>
        </div>
        <div class="space-y-2.5 text-xs pt-3">
          <div><span class="text-slate-400 block text-xxs uppercase font-semibold">Jurusan Pilihan</span><span class="font-bold text-blue-700">{{ $pendaftaran->pil1 }}</span></div>
          @if($pendaftaran->diterima_di_jurusan)
          <div><span class="text-purple-500 block text-xxs uppercase font-semibold">Diterima di Jurusan</span><span class="font-bold text-purple-700">{{ $pendaftaran->diterima_di_jurusan }}</span></div>
          @endif
          @if($pendaftaran->ukuran_seragam)
          <div><span class="text-purple-500 block text-xxs uppercase font-semibold">Ukuran Seragam</span><span class="font-bold text-purple-700">{{ $pendaftaran->ukuran_seragam }}</span></div>
          @endif
          <div><span class="text-slate-400 block text-xxs uppercase font-semibold">Asal Sekolah</span><span class="font-semibold text-slate-700">{{ $pendaftaran->asal_sekolah }}</span></div>
          <div><span class="text-slate-400 block text-xxs uppercase font-semibold">Gelombang</span><span class="font-semibold text-slate-700">{{ $pendaftaran->gelombang ?? '-' }}</span></div>
        </div>
      </div>

      {{-- Rekap Tagihan --}}
      <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 space-y-3">
        <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center gap-1.5">
          <i class="fas fa-receipt text-emerald-500"></i> Rekap Tagihan
        </h4>

        @if($pendaftaran->total_tagihan !== null)
          <div class="space-y-3 text-sm">
            <div class="bg-slate-50 p-3 rounded-xl border border-slate-100 space-y-1.5">
              <span class="text-xxs font-bold text-slate-400 uppercase block">Rincian Tagihan</span>
              <div class="flex justify-between text-xs text-slate-650">
                <span class="text-slate-500">Dana Awal Tahun</span>
                <span class="font-semibold text-slate-700">Rp {{ number_format($pendaftaran->biaya_dana_awal_tahun, 0, ',', '.') }}</span>
              </div>
              <div class="flex justify-between text-xs text-slate-650 border-b border-dashed border-slate-200 pb-1.5">
                <span class="text-slate-500">Infaq</span>
                <span class="font-semibold text-slate-700">Rp {{ number_format($pendaftaran->biaya_infaq, 0, ',', '.') }}</span>
              </div>
              @if($pendaftaran->biaya_potongan > 0)
              <div class="flex justify-between text-xs text-emerald-600">
                <span>Potongan Subsidi</span>
                <span class="font-semibold">− Rp {{ number_format($pendaftaran->biaya_potongan, 0, ',', '.') }}</span>
              </div>
              @endif
              <div class="flex justify-between border-t border-slate-200/60 pt-1.5 font-bold text-slate-800">
                <span>Total Tagihan</span>
                <span>Rp {{ number_format($pendaftaran->total_tagihan, 0, ',', '.') }}</span>
              </div>
            </div>

            <div class="bg-purple-50/50 p-3 rounded-xl border border-purple-100 flex justify-between items-center">
              <div>
                <span class="text-xxs font-bold text-purple-600 uppercase block">SPP Bulanan</span>
                <span class="text-xxs text-purple-550 block">Dibayarkan terpisah bulanan</span>
              </div>
              <span class="font-bold text-purple-700">Rp {{ number_format($pendaftaran->biaya_spp, 0, ',', '.') }}</span>
            </div>
          </div>

          {{-- Progress Bar --}}
          @php
            $persen = $pendaftaran->persen_bayar;
            $terbayar = $pendaftaran->total_terbayar;
            $sisa = $pendaftaran->sisa_tagihan;
            $statusBayar = $pendaftaran->status_bayar;
          @endphp
          <div class="pt-3 border-t border-slate-100 space-y-2">
            <div class="flex justify-between text-xs mb-1">
              <span class="text-slate-500">Progress Pembayaran</span>
              <span class="font-bold {{ $statusBayar === 'lunas' ? 'text-emerald-600' : ($statusBayar === 'cicilan' ? 'text-blue-600' : 'text-rose-500') }}">{{ $persen }}%</span>
            </div>
            <div class="w-full bg-slate-100 rounded-full h-2.5">
              <div class="h-2.5 rounded-full transition-all duration-500
                {{ $statusBayar === 'lunas' ? 'bg-emerald-500' : ($statusBayar === 'cicilan' ? 'bg-blue-500' : 'bg-rose-400') }}"
                style="width: {{ $persen }}%"></div>
            </div>
            <div class="flex justify-between text-xs">
              <div><span class="text-slate-400">Terbayar:</span> <span class="font-bold text-emerald-600">Rp {{ number_format($terbayar, 0, ',', '.') }}</span></div>
              <div><span class="text-slate-400">Sisa:</span> <span class="font-bold text-rose-500">Rp {{ number_format($sisa, 0, ',', '.') }}</span></div>
            </div>
          </div>

          {{-- Status Badge --}}
          <div class="text-center pt-1">
            @if($statusBayar === 'lunas')
              <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span> LUNAS
              </span>
            @elseif($statusBayar === 'cicilan')
              <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-bold bg-blue-100 text-blue-700">
                <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span> CICILAN
              </span>
            @else
              <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-bold bg-rose-100 text-rose-700">
                <span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span> BELUM BAYAR
              </span>
            @endif
          </div>

        @else
          <div class="text-center py-6 text-slate-400">
            <i class="fas fa-exclamation-triangle text-2xl mb-2 text-amber-400 block"></i>
            <p class="text-xs">Biaya belum ditetapkan.</p>
            <p class="text-xxs mt-1">Lakukan proses wawancara terlebih dahulu untuk menetapkan biaya.</p>
          </div>
        @endif
      </div>

    </div>

    {{-- Kolom Kanan: Form Titip Bayar + Riwayat --}}
    <div class="md:col-span-2 space-y-5">

      {{-- Form Titip Bayar --}}
      @if($pendaftaran->total_tagihan && $pendaftaran->status_bayar !== 'lunas')
      <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-emerald-50 flex items-center gap-2">
          <i class="fas fa-hand-holding-usd text-emerald-600"></i>
          <h4 class="font-bold text-slate-800 text-sm">Catat Transaksi Titip Bayar</h4>
          @if($pendaftaran->sisa_tagihan > 0)
            <span class="ml-auto text-xs font-semibold text-rose-500 bg-rose-50 px-2.5 py-1 rounded-full">
              Sisa: Rp {{ number_format($pendaftaran->sisa_tagihan, 0, ',', '.') }}
            </span>
          @endif
        </div>
        <form method="POST" action="{{ route('petugas.pembayaran.update', $pendaftaran->id) }}" class="p-6">
          @csrf @method('PUT')
          <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="sm:col-span-2">
              <label class="block text-xs font-bold text-slate-700 mb-1.5">Nominal Pembayaran (Rp) <span class="text-red-500">*</span></label>
              <input type="text" inputmode="numeric" name="nominal" required
                     value="{{ old('nominal') }}"
                     placeholder="Masukkan nominal yang diterima..."
                     class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-100 focus:border-emerald-500 outline-none text-base font-mono font-bold text-slate-800 format-rupiah @error('nominal') border-red-400 @enderror">
              @error('nominal') <p class="text-red-500 text-xxs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
              <label class="block text-xs font-bold text-slate-700 mb-1.5">Keterangan</label>
              <input type="text" name="keterangan" value="{{ old('keterangan') }}"
                     placeholder="Opsional..."
                     class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-100 focus:border-emerald-500 outline-none text-sm text-slate-800">
            </div>
          </div>
          <button type="submit" class="mt-4 w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-sm transition shadow-lg shadow-emerald-200 flex items-center justify-center gap-2">
            <i class="fas fa-plus-circle"></i> Tambah Pembayaran
          </button>
        </form>
      </div>
      @elseif($pendaftaran->status_bayar === 'lunas')
      <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-5 flex items-center gap-4">
        <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center flex-shrink-0">
          <i class="fas fa-check-double text-emerald-600 text-xl"></i>
        </div>
        <div>
          <p class="font-bold text-emerald-800">Pembayaran Lunas!</p>
          <p class="text-xs text-emerald-600 mt-0.5">Semua tagihan telah terbayar. Total: Rp {{ number_format($pendaftaran->total_tagihan, 0, ',', '.') }}</p>
        </div>
      </div>
      @else
      <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5 flex items-center gap-4">
        <div class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center flex-shrink-0">
          <i class="fas fa-exclamation-triangle text-amber-600 text-xl"></i>
        </div>
        <div>
          <p class="font-bold text-amber-800">Biaya Belum Ditetapkan</p>
          <p class="text-xs text-amber-600 mt-0.5">Lakukan wawancara dan tetapkan biaya terlebih dahulu sebelum mencatat pembayaran.</p>
        </div>
      </div>
      @endif

      {{-- Tabel Riwayat Pembayaran --}}
      <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
          <h4 class="font-bold text-slate-800 text-sm flex items-center gap-2">
            <i class="fas fa-history text-blue-500"></i> Riwayat Pembayaran
          </h4>
          <span class="text-xs text-slate-400">{{ $riwayat->count() }} transaksi</span>
        </div>

        @if($riwayat->count() > 0)
        <div class="overflow-x-auto">
          <table class="w-full text-left text-xs">
            <thead class="bg-slate-50 text-slate-500 uppercase text-xxs font-bold tracking-wider">
              <tr>
                <th class="px-5 py-3">No</th>
                <th class="px-5 py-3">Tanggal</th>
                <th class="px-5 py-3">Nominal</th>
                <th class="px-5 py-3">Keterangan</th>
                <th class="px-5 py-3">Kasir</th>
                <th class="px-5 py-3 text-center">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
              @foreach($riwayat as $i => $r)
              <tr class="hover:bg-slate-50/50 transition">
                <td class="px-5 py-3.5 text-slate-400">{{ $i + 1 }}</td>
                <td class="px-5 py-3.5 text-slate-600">
                  <div>{{ $r->created_at->translatedFormat('d M Y') }}</div>
                  <div class="text-xxs text-slate-400">{{ $r->created_at->format('H:i') }} WIB</div>
                </td>
                <td class="px-5 py-3.5 font-bold text-emerald-600 font-mono">
                  Rp {{ number_format($r->nominal, 0, ',', '.') }}
                </td>
                <td class="px-5 py-3.5 text-slate-600">{{ $r->keterangan ?: '-' }}</td>
                <td class="px-5 py-3.5 text-slate-500">{{ $r->petugas }}</td>
                <td class="px-5 py-3.5 text-center">
                  <div class="flex items-center justify-center gap-1.5">
                    <a href="{{ route('petugas.pembayaran.riwayat.bukti', $r->id) }}" target="_blank"
                       class="inline-flex items-center justify-center gap-1 px-2.5 py-1.5 rounded-lg text-xxs font-bold bg-blue-50 text-blue-600 hover:bg-blue-100 transition" title="Cetak Bukti">
                      <i class="fas fa-print"></i> Bukti
                    </a>
                    <form method="POST" action="{{ route('petugas.pembayaran.riwayat.destroy', $r->id) }}"
                          onsubmit="return confirm('Hapus transaksi Rp {{ number_format($r->nominal, 0, ',', '.') }} ini?')">
                      @csrf @method('DELETE')
                      <button type="submit" class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition-colors" title="Hapus">
                        <i class="fas fa-trash text-xs"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
            <tfoot class="bg-slate-50 border-t-2 border-slate-200">
              <tr>
                <td colspan="2" class="px-5 py-3 text-xs font-bold text-slate-700 uppercase">Total Terbayar</td>
                <td class="px-5 py-3 font-bold text-emerald-600 font-mono text-sm">
                  Rp {{ number_format($pendaftaran->total_terbayar, 0, ',', '.') }}
                </td>
                <td colspan="3"></td>
              </tr>
            </tfoot>
          </table>
        </div>
        @else
        <div class="px-6 py-10 text-center text-slate-400">
          <i class="fas fa-inbox text-4xl mb-3 block"></i>
          <p class="text-sm font-medium">Belum ada riwayat pembayaran</p>
          <p class="text-xs mt-1">Catat transaksi pertama menggunakan form di atas.</p>
        </div>
        @endif
      </div>

    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    function formatRupiah(value) {
        if (!value && value !== 0) return '';
        let str = value.toString();
        
        if (str.endsWith('.00')) {
            str = str.slice(0, -3);
        }
        
        let clean = str.replace(/[^0-9]/g, '');
        
        if (clean.length > 1) {
            clean = clean.replace(/^0+/, '');
            if (clean === '') {
                clean = '0';
            }
        }
        
        return clean.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    const inputs = document.querySelectorAll('.format-rupiah');
    inputs.forEach(input => {
        if (input.value) {
            input.value = formatRupiah(input.value);
        }

        input.addEventListener('input', function() {
            let cursorPosition = this.selectionStart;
            let originalLength = this.value.length;
            
            let formatted = formatRupiah(this.value);
            this.value = formatted;
            
            let newLength = formatted.length;
            cursorPosition = cursorPosition + (newLength - originalLength);
            this.setSelectionRange(cursorPosition, cursorPosition);
        });
    });

    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            form.querySelectorAll('.format-rupiah').forEach(input => {
                input.value = input.value.replace(/\./g, '');
            });
        });
    });
});
</script>
@endpush
