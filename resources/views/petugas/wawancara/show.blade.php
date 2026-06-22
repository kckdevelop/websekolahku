@extends('layouts.petugas')
@section('title', 'Wawancara & Tes: ' . $pendaftaran->no_daftar)
@section('subtitle', 'Uji keagamaan, kepribadian, gaya belajar, minat bakat, dan penetapan biaya calon siswa')

@section('content')
<div class="space-y-6">

  <div class="flex items-center gap-3 mb-4">
    <a href="{{ route('petugas.wawancara.dashboard') }}" class="text-slate-500 hover:text-slate-700 flex items-center gap-1 text-sm font-semibold">
      <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
    </a>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    {{-- Detail Siswa --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 space-y-4">
      <div class="text-center pb-4 border-b border-slate-50">
        @if($pendaftaran->foto_siswa)
          <img src="{{ asset('storage/' . $pendaftaran->foto_siswa) }}" class="w-28 h-36 object-cover mx-auto rounded-xl border-4 border-slate-100 shadow-sm">
        @else
          <div class="w-28 h-36 bg-slate-100 mx-auto rounded-xl border-2 border-dashed border-slate-200 flex flex-col items-center justify-center">
            <i class="fas fa-user text-slate-300 text-3xl mb-1"></i>
            <span class="text-xxs text-slate-400">Belum difoto</span>
          </div>
        @endif
        <h3 class="font-bold text-slate-800 text-sm mt-3">{{ $pendaftaran->nama_lengkap }}</h3>
        <p class="text-slate-400 text-xxs font-mono mt-1">{{ $pendaftaran->no_daftar }}</p>
        <span class="inline-block mt-2 px-2.5 py-1 rounded-full text-xxs font-bold
          {{ $pendaftaran->gelombang ? 'bg-orange-100 text-orange-700' : 'bg-slate-100 text-slate-500' }}">
          {{ $pendaftaran->gelombang ?? 'Gelombang -' }}
        </span>
      </div>

      <div class="space-y-2.5 text-xs">
        <div>
          <span class="text-slate-400 block font-semibold uppercase text-xxs">Asal Sekolah</span>
          <span class="text-slate-800 font-bold mt-0.5 block">{{ $pendaftaran->asal_sekolah }}</span>
        </div>
        <div>
          <span class="text-slate-400 block font-semibold uppercase text-xxs">Jenis Kelamin</span>
          <span class="text-slate-800 font-bold mt-0.5 block">{{ $pendaftaran->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}</span>
        </div>
        <div>
          <span class="text-slate-400 block font-semibold uppercase text-xxs">Status Pendaftaran</span>
          @if($pendaftaran->status === 'diterima')
            <span class="inline-block mt-1 px-2.5 py-0.5 rounded-full text-xxs font-bold bg-emerald-100 text-emerald-700">DITERIMA</span>
          @elseif($pendaftaran->status === 'ditolak')
            <span class="inline-block mt-1 px-2.5 py-0.5 rounded-full text-xxs font-bold bg-rose-100 text-rose-700">DITOLAK</span>
          @elseif($pendaftaran->status === 'verifikasi')
            <span class="inline-block mt-1 px-2.5 py-0.5 rounded-full text-xxs font-bold bg-blue-100 text-blue-700">DIVERIFIKASI</span>
          @else
            <span class="inline-block mt-1 px-2.5 py-0.5 rounded-full text-xxs font-bold bg-slate-100 text-slate-500 uppercase">{{ $pendaftaran->status }}</span>
          @endif
        </div>
        <div>
          <span class="text-slate-400 block font-semibold uppercase text-xxs">Pilihan Jurusan I</span>
          <span class="text-blue-700 font-bold mt-0.5 block">{{ $pendaftaran->pil1 }}</span>
        </div>
        @if($pendaftaran->diterima_di_jurusan)
        <div>
          <span class="text-purple-500 block font-semibold uppercase text-xxs">Diterima di Jurusan</span>
          <span class="text-purple-700 font-bold mt-0.5 block">{{ $pendaftaran->diterima_di_jurusan }}</span>
        </div>
        @endif
        @if($pendaftaran->ukuran_seragam)
        <div>
          <span class="text-purple-500 block font-semibold uppercase text-xxs">Ukuran Seragam</span>
          <span class="text-purple-700 font-bold mt-0.5 block">{{ $pendaftaran->ukuran_seragam }}</span>
        </div>
        @endif
        @if($pendaftaran->petugasWawancara)
        <div>
          <span class="text-slate-400 block font-semibold uppercase text-xxs">Petugas Pewawancara</span>
          <span class="text-slate-800 font-bold mt-0.5 block">{{ $pendaftaran->petugasWawancara->nama }}</span>
        </div>
        @endif
        @if($pendaftaran->status_yatim_piatu && $pendaftaran->status_yatim_piatu !== 'normal')
        <div>
          <span class="text-slate-400 block font-semibold uppercase text-xxs">Status Yatim/Piatu</span>
          <span class="inline-block mt-1 px-2.5 py-0.5 rounded-full text-xxs font-bold bg-amber-100 text-amber-700 uppercase">
            {{ str_replace('_', ' ', $pendaftaran->status_yatim_piatu) }}
          </span>
        </div>
        @endif
        @if($pendaftaran->total_tagihan)
        <div class="pt-2 border-t border-slate-50">
          <span class="text-slate-400 block font-semibold uppercase text-xxs">Total Tagihan</span>
          <span class="text-emerald-700 font-bold text-base mt-0.5 block">Rp {{ number_format($pendaftaran->total_tagihan, 0, ',', '.') }}</span>
          <span class="text-xxs text-slate-400">Ditetapkan: {{ $pendaftaran->biaya_petugas }}</span>
        </div>
        @endif
      </div>
    </div>

    {{-- Form Wawancara --}}
    <div class="md:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
      <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center gap-2">
        <i class="fas fa-comments text-purple-600"></i>
        <h4 class="font-bold text-slate-850 text-sm">Formulir Wawancara, Gaya Belajar & Penetapan Biaya</h4>
      </div>

      @if(session('success'))
        <div class="mx-6 mt-4 px-4 py-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm flex items-center gap-2">
          <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
      @endif

      <form method="POST" action="{{ route('petugas.wawancara.update', $pendaftaran->id) }}" class="p-6 space-y-6">
        @csrf @method('PUT')

        {{-- Section I: Gaya Belajar --}}
        <div class="space-y-4">
          <h5 class="text-xs font-bold text-purple-700 uppercase tracking-wider pb-1.5 border-b border-slate-100">
            I. Gaya Belajar &amp; Pemetaan Jurusan
          </h5>
          
          {{-- Hidden inputs to pass data to backend since visible inputs are disabled --}}
          <input type="hidden" name="gaya_belajar_tipe" value="{{ $pendaftaran->gaya_belajar_tipe }}">
          <input type="hidden" name="gaya_belajar_minat_bakat" value="{{ $pendaftaran->gaya_belajar_minat_bakat }}">
          <input type="hidden" name="gaya_belajar_catatan" value="{{ $pendaftaran->gaya_belajar_catatan }}">

          <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="sm:col-span-1">
              <label class="block text-xs font-bold text-slate-700 mb-1.5">Tipe Gaya Belajar <span class="text-slate-400">(Diisi mandiri oleh siswa)</span></label>
              <select disabled class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 cursor-not-allowed outline-none text-sm text-slate-800">
                <option value="">-- Pilih Tipe --</option>
                <option value="visual" {{ old('gaya_belajar_tipe', $pendaftaran->gaya_belajar_tipe) === 'visual' ? 'selected' : '' }}>Visual</option>
                <option value="auditori" {{ old('gaya_belajar_tipe', $pendaftaran->gaya_belajar_tipe) === 'auditori' ? 'selected' : '' }}>Auditori</option>
                <option value="kinestetik" {{ old('gaya_belajar_tipe', $pendaftaran->gaya_belajar_tipe) === 'kinestetik' ? 'selected' : '' }}>Kinestetik</option>
              </select>
            </div>
            <div class="sm:col-span-2">
              <label class="block text-xs font-bold text-slate-700 mb-1.5">Minat Bakat / Hobi <span class="text-slate-400">(Diisi mandiri oleh siswa)</span></label>
              <input type="text" disabled value="{{ old('gaya_belajar_minat_bakat', $pendaftaran->gaya_belajar_minat_bakat) }}"
                     class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 cursor-not-allowed outline-none text-sm text-slate-800">
            </div>
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5">Catatan Gaya Belajar &amp; Minat</label>
            <textarea disabled rows="2"
                      class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 cursor-not-allowed outline-none text-sm text-slate-800 resize-none">{{ old('gaya_belajar_catatan', $pendaftaran->gaya_belajar_catatan) }}</textarea>
          </div>
        </div>

        {{-- Section II: Wawancara --}}
        <div class="space-y-4">
          <h5 class="text-xs font-bold text-purple-700 uppercase tracking-wider pb-1.5 border-b border-slate-100">
            II. Wawancara Keagamaan &amp; Kepribadian
          </h5>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-bold text-slate-700 mb-1.5">Kemampuan Baca Tulis Al-Qur'an <span class="text-red-500">*</span></label>
              <input type="text" name="wawancara_baca_tulis_alquran" required value="{{ old('wawancara_baca_tulis_alquran', $pendaftaran->wawancara_baca_tulis_alquran) }}"
                     placeholder="Contoh: Lancar / Iqra / Belum bisa"
                     class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-purple-100 focus:border-purple-500 outline-none text-sm text-slate-800">
            </div>
            <div>
              <label class="block text-xs font-bold text-slate-700 mb-1.5">Kedisiplinan Sholat 5 Waktu <span class="text-red-500">*</span></label>
              <input type="text" name="wawancara_solat_fardhu" required value="{{ old('wawancara_solat_fardhu', $pendaftaran->wawancara_solat_fardhu) }}"
                     placeholder="Contoh: Rajin / Kadang-kadang / Jarang"
                     class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-purple-100 focus:border-purple-500 outline-none text-sm text-slate-800">
            </div>
          </div>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-bold text-slate-700 mb-1.5">Hasil Pengamatan Kepribadian / Sikap <span class="text-red-500">*</span></label>
              <input type="text" name="wawancara_kepribadian" required value="{{ old('wawancara_kepribadian', $pendaftaran->wawancara_kepribadian) }}"
                     placeholder="Contoh: Sopan, Santun, Percaya diri, Pemalu"
                     class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-purple-100 focus:border-purple-500 outline-none text-sm text-slate-800">
            </div>
            <div>
              <label class="block text-xs font-bold text-slate-700 mb-1.5">Pilih Pewawancara <span class="text-red-500">*</span></label>
              <select name="petugas_wawancara_id" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-purple-100 focus:border-purple-500 outline-none text-sm text-slate-800 bg-white">
                <option value="">-- Pilih Pewawancara --</option>
                @foreach($pewawancaras as $pewawancara)
                  <option value="{{ $pewawancara->id }}" {{ old('petugas_wawancara_id', $pendaftaran->petugas_wawancara_id) == $pewawancara->id ? 'selected' : '' }}>
                    {{ $pewawancara->nama }} @if($pewawancara->jabatan) ({{ $pewawancara->jabatan }}) @endif
                  </option>
                @endforeach
              </select>
            </div>
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5">Catatan Wawancara Khusus</label>
            <textarea name="wawancara_catatan" rows="3" placeholder="Catatan khusus kesepakatan orang tua, komitmen kepatuhan tata tertib sekolah, dll..."
                      class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-purple-100 focus:border-purple-500 outline-none text-sm text-slate-800 resize-none">{{ old('wawancara_catatan', $pendaftaran->wawancara_catatan) }}</textarea>
          </div>
        </div>

        {{-- Section III: Status Kelulusan, Program Keahlian Diterima & Seragam --}}
        <div class="space-y-4">
          <h5 class="text-xs font-bold text-purple-700 uppercase tracking-wider pb-1.5 border-b border-slate-100">
            III. Status Kelulusan, Program Keahlian Diterima &amp; Seragam
          </h5>
          <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
              <label class="block text-xs font-bold text-slate-700 mb-1.5">Status Kelulusan Siswa <span class="text-red-500">*</span></label>
              <select name="status" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-purple-100 focus:border-purple-500 outline-none text-sm text-slate-800 bg-white">
                <option value="diterima" {{ old('status', $pendaftaran->status) === 'diterima' || !in_array($pendaftaran->status, ['diterima', 'ditolak']) ? 'selected' : '' }}>Diterima</option>
                <option value="ditolak" {{ old('status', $pendaftaran->status) === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
              </select>
            </div>
            <div>
              <label class="block text-xs font-bold text-slate-700 mb-1.5">Program Keahlian Diterima <span class="text-red-500">*</span></label>
              <select name="diterima_di_jurusan" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-purple-100 focus:border-purple-500 outline-none text-sm text-slate-800 bg-white">
                <option value="">-- Pilih Jurusan --</option>
                @foreach([
                  'TKR' => 'Teknik Kendaraan Ringan (Otomotif)',
                  'TPM' => 'Teknik Permesinan',
                  'TAV' => 'Teknik Audio Video (Elektronika)',
                  'TBSM' => 'Teknik Bisnis Sepeda Motor',
                  'RPL' => 'Rekayasa Perangkat Lunak (Komputer)'
                ] as $code => $name)
                  <option value="{{ $code }}" {{ old('diterima_di_jurusan', $pendaftaran->diterima_di_jurusan ?? $pendaftaran->pil1) === $code ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
              </select>
            </div>
            <div>
              <label class="block text-xs font-bold text-slate-700 mb-1.5">Ukuran Seragam <span class="text-red-500">*</span></label>
              <select name="ukuran_seragam" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-purple-100 focus:border-purple-500 outline-none text-sm text-slate-800 bg-white">
                <option value="">-- Pilih Ukuran Seragam --</option>
                @foreach(['S', 'M', 'L', 'XL', '2XL', '3XL', '4XL', '5XL', '6XL', 'Jumbo'] as $sz)
                  <option value="{{ $sz }}" {{ old('ukuran_seragam', $pendaftaran->ukuran_seragam) === $sz ? 'selected' : '' }}>{{ $sz }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>

        {{-- Section IV: Penetapan Biaya --}}
        <div class="space-y-4">
          <h5 class="text-xs font-bold text-emerald-700 uppercase tracking-wider pb-1.5 border-b border-emerald-100">
            <i class="fas fa-money-bill-wave mr-1"></i> IV. Penetapan Biaya Pendaftaran
          </h5>

          @if($gelombangAktif && $gelombangAktif->potongan_subsidi > 0)
          <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-3 text-xs text-emerald-700 flex items-start gap-2">
            <i class="fas fa-tag mt-0.5"></i>
            <div>
              <span class="font-bold">Subsidi Gelombang Aktif ({{ $gelombangAktif->nama_gelombang }}):</span>
              Potongan sebesar <strong>Rp {{ number_format($gelombangAktif->potongan_subsidi, 0, ',', '.') }}</strong> akan diaplikasikan otomatis.
            </div>
          </div>
          @endif

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-bold text-slate-700 mb-1.5">Nominal SPP (Rp) <span class="text-red-500">*</span></label>
              <input type="text" inputmode="numeric" name="biaya_spp" id="biaya_spp" required
                     value="{{ old('biaya_spp', isset($pendaftaran->biaya_spp) ? (int) $pendaftaran->biaya_spp : '') }}"
                     placeholder="Masukkan nominal SPP"
                     class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-100 focus:border-emerald-500 outline-none text-sm font-mono text-slate-800 format-rupiah"
                     oninput="hitungTotal()">
            </div>
            <div>
              <label class="block text-xs font-bold text-slate-700 mb-1.5">Dana Awal Tahun (Rp) <span class="text-red-500">*</span></label>
              <input type="text" inputmode="numeric" name="biaya_dana_awal_tahun" id="biaya_dana_awal_tahun" required
                     value="{{ old('biaya_dana_awal_tahun', isset($pendaftaran->biaya_dana_awal_tahun) ? (int) $pendaftaran->biaya_dana_awal_tahun : (isset($gelombangAktif) ? (int) $gelombangAktif->biaya_zakat_default : 0)) }}"
                     class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-100 focus:border-emerald-500 outline-none text-sm font-mono text-slate-800 format-rupiah"
                     oninput="hitungTotal()">
            </div>
            <div>
              <label class="block text-xs font-bold text-slate-700 mb-1.5">Nominal Infaq (Rp) <span class="text-red-500">*</span></label>
              <input type="text" inputmode="numeric" name="biaya_infaq" id="biaya_infaq" required
                     value="{{ old('biaya_infaq', isset($pendaftaran->biaya_infaq) ? (int) $pendaftaran->biaya_infaq : 0) }}"
                     class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-100 focus:border-emerald-500 outline-none text-sm font-mono text-slate-800 format-rupiah"
                     oninput="hitungTotal()">
            </div>
            <div>
              <label class="block text-xs font-bold text-slate-700 mb-1.5">Potongan Subsidi (Rp) <span class="text-slate-400">(Berdasarkan Gelombang)</span></label>
              <input type="text" inputmode="numeric" id="biaya_potongan" readonly
                     value="{{ (isset($pendaftaran->biaya_potongan) && $pendaftaran->biaya_potongan > 0) ? (int) $pendaftaran->biaya_potongan : (isset($gelombangAktif) ? (int) $gelombangAktif->potongan_subsidi : 0) }}"
                     class="w-full px-4 py-2.5 rounded-xl border border-slate-250 bg-slate-50 cursor-not-allowed outline-none text-sm font-mono text-slate-500 format-rupiah">
            </div>
            <div class="sm:col-span-2">
              <label class="block text-xs font-bold text-slate-700 mb-1.5">Status Yatim/Piatu <span class="text-red-500">*</span></label>
              <select name="status_yatim_piatu" id="status_yatim_piatu" required
                      class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-100 focus:border-emerald-500 outline-none text-sm text-slate-800 bg-white"
                      onchange="updateBiayaStatus()">
                <option value="normal" {{ old('status_yatim_piatu', $pendaftaran->status_yatim_piatu ?? 'normal') === 'normal' ? 'selected' : '' }}>Bukan Yatim/Piatu (Normal)</option>
                <option value="yatim" {{ old('status_yatim_piatu', $pendaftaran->status_yatim_piatu) === 'yatim' ? 'selected' : '' }}>Yatim (SPP Bulanan 0)</option>
                <option value="piatu" {{ old('status_yatim_piatu', $pendaftaran->status_yatim_piatu) === 'piatu' ? 'selected' : '' }}>Piatu (SPP 50%)</option>
                <option value="yatim_piatu" {{ old('status_yatim_piatu', $pendaftaran->status_yatim_piatu) === 'yatim_piatu' ? 'selected' : '' }}>Yatim Piatu (Sumbangan 0, SPP 50%, Biaya Pendidikan 50%)</option>
              </select>
            </div>
          </div>

          {{-- Preview Total Tagihan --}}
          <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 flex items-center justify-between">
            <div class="text-xs text-slate-500">
              <span id="preview_formula">Dana Awal Tahun + Infaq − Potongan = <strong>Total Tagihan</strong></span>
            </div>
            <div class="text-right">
              <span class="text-xxs text-slate-400 block">Total Tagihan Siswa</span>
              <span id="preview_total" class="text-2xl font-bold text-emerald-600">Rp 0</span>
            </div>
          </div>
        </div>

        <button type="submit" class="w-full py-3 bg-purple-600 hover:bg-purple-700 text-white font-bold rounded-xl text-sm transition shadow-sm">
          <i class="fas fa-save mr-2"></i> Simpan Hasil Wawancara, Tes &amp; Biaya
        </button>
      </form>
    </div>

  </div>

</div>

<script>
const defaultSpp = {{ $gelombangAktif->biaya_spp_default ?? 0 }};
const defaultBiayaPendidikan = {{ $gelombangAktif->biaya_zakat_default ?? 0 }};

function formatRupiahGlobal(value) {
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

function updateBiayaStatus() {
  const status = document.getElementById('status_yatim_piatu').value;
  const sppInput = document.getElementById('biaya_spp');
  const datInput = document.getElementById('biaya_dana_awal_tahun');
  const infaqInput = document.getElementById('biaya_infaq');
  
  if (status === 'yatim') {
    sppInput.value = '0';
    datInput.value = formatRupiahGlobal(defaultBiayaPendidikan);
  } else if (status === 'piatu') {
    sppInput.value = formatRupiahGlobal(Math.round(defaultSpp * 0.5));
    datInput.value = formatRupiahGlobal(defaultBiayaPendidikan);
  } else if (status === 'yatim_piatu') {
    sppInput.value = formatRupiahGlobal(Math.round(defaultSpp * 0.5));
    datInput.value = formatRupiahGlobal(Math.round(defaultBiayaPendidikan * 0.5));
    infaqInput.value = '0';
  } else {
    sppInput.value = formatRupiahGlobal(defaultSpp);
    datInput.value = formatRupiahGlobal(defaultBiayaPendidikan);
  }
  
  hitungTotal();
}

function hitungTotal() {
  const sppStr   = document.getElementById('biaya_spp').value || '';
  const datStr   = document.getElementById('biaya_dana_awal_tahun').value || '';
  const infaqStr = document.getElementById('biaya_infaq').value || '';
  const potStr   = document.getElementById('biaya_potongan').value || '';

  const spp      = parseFloat(sppStr.replace(/\./g, '')) || 0;
  const dat      = parseFloat(datStr.replace(/\./g, '')) || 0;
  const infaq    = parseFloat(infaqStr.replace(/\./g, '')) || 0;
  const potongan = parseFloat(potStr.replace(/\./g, '')) || 0;

  const total    = Math.max(0, dat + infaq - potongan);

  document.getElementById('preview_total').textContent = 'Rp ' + total.toLocaleString('id-ID');
  document.getElementById('preview_formula').innerHTML =
    'Dana Awal (Rp ' + dat.toLocaleString('id-ID') + ') + Infaq (Rp ' + infaq.toLocaleString('id-ID') + ') − Potongan (Rp ' + potongan.toLocaleString('id-ID') + ') = <strong>Total Tagihan: Rp ' + total.toLocaleString('id-ID') + '</strong><br><span class="text-slate-400">(SPP Rp ' + spp.toLocaleString('id-ID') + ' Terpisah)</span>';
}

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
            
            // Trigger recalculation on input
            hitungTotal();
        });
    });

    // Recalculate on load (since formatRupiah is applied first)
    hitungTotal();

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
@endsection
