@extends('layouts.admin')
@section('title', 'Atur Gelombang Pendaftaran')
@section('subtitle', 'Kelola gelombang pendaftaran SPMB dan tandai gelombang yang sedang aktif')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

  {{-- Kolom Kiri: Daftar Gelombang --}}
  <div class="lg:col-span-2 space-y-6">

    {{-- Banner: Pendaftaran Ditutup --}}
    @if(!$isPendaftaranOpen)
    <div class="flex items-start gap-4 bg-red-50 border border-red-200 rounded-2xl px-5 py-4">
      <div class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center flex-shrink-0">
        <i class="fas fa-ban text-red-500"></i>
      </div>
      <div class="flex-1">
        <p class="font-bold text-red-700 text-sm">Pendaftaran Sedang Ditutup</p>
        <p class="text-xs text-red-500 mt-0.5">Semua gelombang telah dinonaktifkan. Tombol aktivasi gelombang tidak dapat digunakan. Buka kembali pendaftaran melalui menu <a href="{{ route('admin.spmb-status.edit') }}" class="font-semibold underline hover:text-red-700">Status Pendaftaran</a> terlebih dahulu.</p>
      </div>
      <a href="{{ route('admin.spmb-status.edit') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold bg-red-100 hover:bg-red-200 text-red-700 px-3 py-2 rounded-lg transition-colors flex-shrink-0">
        <i class="fas fa-toggle-on"></i> Buka
      </a>
    </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
      <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
        <h3 class="font-bold text-slate-800 flex items-center gap-2">
          <i class="fas fa-layer-group text-primary"></i> Daftar Gelombang
        </h3>
        <span class="text-xs text-slate-400">Total: {{ $gelombangs->count() }} gelombang</span>
      </div>

      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-100 table-auto">
          <thead class="bg-slate-50">
            <tr class="text-xs font-semibold text-slate-500 uppercase tracking-wider text-left">
              <th class="px-4 py-3">Nama Gelombang</th>
              <th class="px-4 py-3 text-center">Kode</th>
              <th class="px-4 py-3">Tahun Ajaran</th>
              <th class="px-4 py-3">Periode</th>
              <th class="px-4 py-3 text-right">Biaya & Potongan</th>
              <th class="px-4 py-3 text-center">Status</th>
              <th class="px-4 py-3 text-right">Aksi</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-slate-100 text-sm">
            @forelse($gelombangs as $item)
            <tr class="hover:bg-slate-50 transition-colors {{ $item->is_aktif ? 'bg-orange-50/20' : '' }}">
              <td class="px-4 py-4">
                <div class="font-semibold text-slate-800">{{ $item->nama_gelombang }}</div>
                @if($item->keterangan)
                  <div class="text-xxs text-slate-400 mt-0.5">{{ $item->keterangan }}</div>
                @endif
              </td>
              <td class="px-4 py-4 text-center">
                @if($item->kode_gelombang)
                  <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-primary/10 text-primary font-bold text-sm">
                    {{ str_pad($item->kode_gelombang, 2, '0', STR_PAD_LEFT) }}
                  </span>
                @else
                  <span class="text-slate-300 text-xs italic">–</span>
                @endif
              </td>
              <td class="px-4 py-4 text-slate-600 font-medium">{{ $item->tahun_ajaran }}</td>
              <td class="px-4 py-4 text-slate-500 text-xs">
                @if($item->tanggal_mulai && $item->tanggal_selesai)
                  {{ $item->tanggal_mulai->translatedFormat('d M Y') }} – {{ $item->tanggal_selesai->translatedFormat('d M Y') }}
                @else
                  <span class="text-slate-300 italic">Belum diatur</span>
                @endif
              </td>
              <td class="px-4 py-4 text-right text-xs space-y-0.5">
                <div class="text-slate-600"><span class="text-slate-400">Dana Awal:</span> Rp {{ number_format($item->biaya_zakat_default, 0, ',', '.') }}</div>
                @if($item->potongan_subsidi > 0)
                  <div class="text-emerald-600 font-semibold"><span class="text-slate-400">Potongan:</span> Rp {{ number_format($item->potongan_subsidi, 0, ',', '.') }}</div>
                @endif
              </td>
              <td class="px-4 py-4 text-center">
                @if(!$isPendaftaranOpen)
                  {{-- Pendaftaran ditutup: semua tampil Non-Aktif (tertutup) --}}
                  <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-500">
                    <i class="fas fa-ban text-xs"></i> Ditutup
                  </span>
                @elseif($item->is_aktif)
                  <div class="flex flex-col items-center gap-1">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 shadow-sm shadow-green-100/50">
                      <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>Aktif
                    </span>
                    @php
                      $yr = '26';
                      if (preg_match('/^(\d{4})/', $item->tahun_ajaran ?? '', $ym)) { $yr = substr($ym[1], -2); }
                      $kd = str_pad((int)$item->kode_gelombang, 2, '0', STR_PAD_LEFT);
                      $pfx = 'MSB'.$yr.'-'.$kd.'-';
                      $lastP = \App\Models\Pendaftaran::where('no_daftar','like',$pfx.'%')->orderBy('no_daftar','desc')->first();
                      $nxt = $lastP ? ((int)substr($lastP->no_daftar,-3)+1) : 1;
                      $previewNo = $pfx . str_pad($nxt, 3, '0', STR_PAD_LEFT);
                    @endphp
                    <span class="font-mono text-xxs text-slate-400" title="No pendaftaran berikutnya">{{ $previewNo }}</span>
                  </div>
                @else
                  <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-650">Non-Aktif</span>
                @endif
              </td>
              <td class="px-4 py-4 text-right">
                <div class="flex items-center justify-end gap-1.5">
                  @if(!$isPendaftaranOpen)
                    {{-- Pendaftaran ditutup: tombol play dinonaktifkan --}}
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-300 border border-slate-200 cursor-not-allowed" title="Buka pendaftaran terlebih dahulu untuk mengaktifkan gelombang">
                      <i class="fas fa-play text-xs"></i>
                    </span>
                  @elseif(!$item->is_aktif)
                    <form id="form-aktif-{{ $item->id }}" method="POST" action="{{ route('admin.gelombang.toggleActive', $item) }}">
                      @csrf
                      <button type="button"
                        onclick="showAktifModal({{ $item->id }}, '{{ addslashes($item->nama_gelombang) }}', '{{ $item->tahun_ajaran }}', '{{ str_pad($item->kode_gelombang,2,'0',STR_PAD_LEFT) }}')"
                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-red-500 hover:text-white hover:bg-red-500 border border-red-200 hover:border-red-500 transition-all" title="Set sebagai gelombang aktif">
                        <i class="fas fa-play text-xs"></i>
                      </button>
                    </form>
                  @else
                    <span class="text-xs text-green-600 font-semibold px-2.5 py-1.5"><i class="fas fa-lock mr-1"></i>Aktif</span>
                  @endif
                  <a href="{{ route('admin.gelombang.edit', $item) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-650 hover:text-yellow-600 hover:bg-yellow-50 transition-colors">
                    <i class="fas fa-edit"></i>
                  </a>
                  @if(!$item->is_aktif)
                    <form method="POST" action="{{ route('admin.gelombang.destroy', $item) }}" onsubmit="return confirm('Hapus gelombang \'{{ $item->nama_gelombang }}\'? Tindakan ini tidak dapat dibatalkan.')">
                      @csrf @method('DELETE')
                      <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-650 hover:text-red-600 hover:bg-red-50 transition-colors">
                        <i class="fas fa-trash"></i>
                      </button>
                    </form>
                  @else
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-300 cursor-not-allowed" title="Gelombang aktif tidak dapat dihapus">
                      <i class="fas fa-trash"></i>
                    </span>
                  @endif
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="7" class="px-4 py-12 text-center text-slate-400">
                <i class="fas fa-layer-group text-4xl mb-3 block"></i>
                <p>Belum ada data gelombang pendaftaran.</p>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  {{-- Kolom Kanan: Form Tambah / Edit --}}
  <div class="lg:col-span-1">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden sticky top-24">
      <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
        <h3 class="font-bold text-slate-800 flex items-center gap-2">
          @if(isset($gelombang))
            <i class="fas fa-edit text-yellow-500"></i> Ubah Gelombang
          @else
            <i class="fas fa-plus text-primary"></i> Tambah Gelombang
          @endif
        </h3>
        <p class="text-xxs text-slate-400 mt-0.5">
          @if(isset($gelombang)) Perbarui detail gelombang terpilih
          @else Buat dan konfigurasikan gelombang baru
          @endif
        </p>
      </div>

      <form method="POST" action="{{ isset($gelombang) ? route('admin.gelombang.update', $gelombang) : route('admin.gelombang.store') }}" class="p-6 space-y-4">
        @csrf
        @if(isset($gelombang)) @method('PUT') @endif

        <div>
          <label for="nama_gelombang" class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Gelombang <span class="text-red-500">*</span></label>
          <input type="text" id="nama_gelombang" name="nama_gelombang" value="{{ old('nama_gelombang', $gelombang->nama_gelombang ?? '') }}" required
            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm @error('nama_gelombang') border-red-400 @enderror"
            placeholder="Contoh: Gelombang I">
          @error('nama_gelombang') <p class="text-red-500 text-xxs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label for="kode_gelombang" class="block text-xs font-semibold text-slate-700 mb-1.5">
            Kode Gelombang <span class="text-red-500">*</span>
          </label>
          <div class="flex items-center gap-2">
            <input type="number" id="kode_gelombang" name="kode_gelombang"
              value="{{ old('kode_gelombang', $gelombang->kode_gelombang ?? '') }}"
              min="1" max="99" required
              class="w-24 px-3.5 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm font-mono text-center @error('kode_gelombang') border-red-400 @enderror"
              placeholder="1">
            <p class="text-xxs text-slate-400 leading-relaxed">
              Dipakai di nomor pendaftaran:<br>
              <span class="font-mono text-primary">MSB26-<strong>0X</strong>-001</span><br>
              Misal kode <strong>1</strong> → <span class="font-mono">MSB26-01-001</span>
            </p>
          </div>
          @error('kode_gelombang') <p class="text-red-500 text-xxs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label for="tahun_ajaran" class="block text-xs font-semibold text-slate-700 mb-1.5">Tahun Ajaran <span class="text-red-500">*</span></label>
          <input type="text" id="tahun_ajaran" name="tahun_ajaran" value="{{ old('tahun_ajaran', $gelombang->tahun_ajaran ?? date('Y').'/'.(date('Y')+1)) }}" required
            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm"
            placeholder="Contoh: 2026/2027">
        </div>

        <div class="grid grid-cols-2 gap-3">
          <div>
            <label for="tanggal_mulai" class="block text-xs font-semibold text-slate-700 mb-1.5">Tanggal Mulai</label>
            <input type="date" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai', isset($gelombang) && $gelombang->tanggal_mulai ? $gelombang->tanggal_mulai->format('Y-m-d') : '') }}"
              class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
          </div>
          <div>
            <label for="tanggal_selesai" class="block text-xs font-semibold text-slate-700 mb-1.5">Tanggal Selesai</label>
            <input type="date" id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai', isset($gelombang) && $gelombang->tanggal_selesai ? $gelombang->tanggal_selesai->format('Y-m-d') : '') }}"
              class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
          </div>
        </div>

        <div>
          <label for="keterangan" class="block text-xs font-semibold text-slate-700 mb-1.5">Keterangan</label>
          <input type="text" id="keterangan" name="keterangan" value="{{ old('keterangan', $gelombang->keterangan ?? '') }}"
            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm"
            placeholder="Contoh: Jalur Minat & Prestasi">
        </div>

        {{-- Separator biaya --}}
        <div class="pt-2 border-t border-slate-100">
          <p class="text-xxs font-bold text-slate-500 uppercase tracking-wider mb-3"><i class="fas fa-money-bill-wave mr-1 text-emerald-500"></i> Penetapan Biaya Gelombang</p>

          <div class="space-y-3">
            <div>
              <label for="biaya_zakat_default" class="block text-xs font-semibold text-slate-700 mb-1">Nominal Biaya Pendidikan Default (Rp)</label>
              <input type="text" inputmode="numeric" id="biaya_zakat_default" name="biaya_zakat_default"
                value="{{ old('biaya_zakat_default', isset($gelombang) ? (int) $gelombang->biaya_zakat_default : 0) }}"
                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-200 focus:border-emerald-500 outline-none transition text-sm font-mono format-rupiah"
                placeholder="0">
            </div>
            <div>
              <label for="potongan_subsidi" class="block text-xs font-semibold text-slate-700 mb-1">
                Potongan Subsidi Sekolah (Rp) <span class="text-emerald-600 font-normal">— diskon untuk gelombang ini</span>
              </label>
              <input type="text" inputmode="numeric" id="potongan_subsidi" name="potongan_subsidi"
                value="{{ old('potongan_subsidi', isset($gelombang) ? (int) $gelombang->potongan_subsidi : 0) }}"
                class="w-full px-3.5 py-2.5 rounded-xl border border-emerald-200 focus:ring-2 focus:ring-emerald-200 focus:border-emerald-500 outline-none transition text-sm font-mono bg-emerald-50/50 format-rupiah"
                placeholder="0">
              <p class="text-xxs text-slate-400 mt-1"><i class="fas fa-info-circle"></i> Total Tagihan = Dana Awal Tahun + Infaq − Potongan Subsidi</p>
            </div>
          </div>
        </div>

        @if(!isset($gelombang) || !$gelombang->is_aktif)
        <div class="flex items-center gap-2 pt-1">
          <input type="checkbox" id="is_aktif" name="is_aktif" value="1"
            class="rounded border-slate-300 text-primary focus:ring-primary/30 w-4 h-4">
          <label for="is_aktif" class="text-xs font-semibold text-slate-650 cursor-pointer select-none">Jadikan Gelombang Aktif</label>
        </div>
        @endif

        <div class="flex items-center gap-2 pt-3 border-t border-slate-100">
          <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 bg-primary hover:bg-secondary text-white font-semibold py-2.5 rounded-xl transition-all shadow-sm">
            <i class="fas fa-save text-sm"></i> Simpan
          </button>
          @if(isset($gelombang))
            <a href="{{ route('admin.gelombang.index') }}" class="inline-flex items-center justify-center bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-4 py-2.5 rounded-xl transition-all">Batal</a>
          @endif
        </div>
      </form>
    </div>
  </div>

</div>

{{-- Modal Konfirmasi Set Aktif --}}
<div id="modal-aktif" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
  {{-- Backdrop --}}
  <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="closeAktifModal()"></div>

  {{-- Card --}}
  <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all scale-95 opacity-0" id="modal-aktif-card">
    {{-- Header --}}
    <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-t-2xl px-6 pt-6 pb-8">
      <div class="flex items-center justify-between mb-4">
        <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center">
          <i class="fas fa-layer-group text-white text-xl"></i>
        </div>
        <button onclick="closeAktifModal()" class="w-8 h-8 rounded-full bg-white/20 hover:bg-white/30 text-white flex items-center justify-center transition-colors">
          <i class="fas fa-times text-sm"></i>
        </button>
      </div>
      <h3 class="text-lg font-bold text-white">Aktifkan Gelombang?</h3>
      <p class="text-emerald-100 text-sm mt-1">Konfirmasi pengalihan gelombang aktif</p>
    </div>

    {{-- Body --}}
    <div class="px-6 py-5 -mt-4">
      <div class="bg-white rounded-xl border border-slate-100 shadow-sm p-4 mb-4">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-lg bg-emerald-50 flex items-center justify-center flex-shrink-0">
            <span id="modal-kode" class="text-emerald-600 font-bold text-sm font-mono">01</span>
          </div>
          <div>
            <p id="modal-nama" class="font-bold text-slate-800 text-sm">Gelombang I</p>
            <p id="modal-tahun" class="text-xs text-slate-400">2026/2027</p>
          </div>
          <span class="ml-auto inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Akan Aktif
          </span>
        </div>
      </div>

      <div class="flex items-start gap-3 bg-amber-50 border border-amber-200 rounded-xl px-4 py-3">
        <i class="fas fa-exclamation-triangle text-amber-500 mt-0.5 flex-shrink-0"></i>
        <p class="text-xs text-amber-700 leading-relaxed">
          <strong>Perhatian:</strong> Gelombang yang sedang aktif akan <strong>dinonaktifkan</strong> secara otomatis. Hanya 1 gelombang yang dapat aktif pada satu waktu.
        </p>
      </div>
    </div>

    {{-- Footer --}}
    <div class="px-6 pb-6 flex gap-3">
      <button onclick="closeAktifModal()"
        class="flex-1 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-semibold text-sm hover:bg-slate-50 transition-colors">
        Batal
      </button>
      <button id="modal-aktif-confirm" onclick="submitAktifForm()"
        class="flex-1 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold text-sm hover:from-emerald-600 hover:to-teal-700 transition-all shadow-sm shadow-emerald-200 flex items-center justify-center gap-2">
        <i class="fas fa-play text-xs"></i> Ya, Aktifkan
      </button>
    </div>
  </div>
</div>

@endsection

@section('scripts')
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

// ── Modal Set Aktif ──────────────────────────────
let _aktifFormId = null;

function showAktifModal(id, nama, tahun, kode) {
  _aktifFormId = id;
  document.getElementById('modal-nama').textContent   = nama;
  document.getElementById('modal-tahun').textContent  = tahun;
  document.getElementById('modal-kode').textContent   = kode;

  const modal = document.getElementById('modal-aktif');
  const card  = document.getElementById('modal-aktif-card');
  modal.classList.remove('hidden');
  modal.classList.add('flex');
  requestAnimationFrame(() => {
    card.classList.remove('scale-95', 'opacity-0');
    card.classList.add('scale-100', 'opacity-100');
  });
}

function closeAktifModal() {
  const modal = document.getElementById('modal-aktif');
  const card  = document.getElementById('modal-aktif-card');
  card.classList.remove('scale-100', 'opacity-100');
  card.classList.add('scale-95', 'opacity-0');
  setTimeout(() => {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    _aktifFormId = null;
  }, 200);
}

function submitAktifForm() {
  if (_aktifFormId) {
    document.getElementById('form-aktif-' + _aktifFormId).submit();
  }
}
</script>
@endsection
