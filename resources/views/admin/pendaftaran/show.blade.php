@extends('layouts.admin')
@section('title', 'Detail Pendaftaran')
@section('subtitle', 'Informasi lengkap pendaftar siswa baru')

@push('styles')
<style>
  #webcam-feed { width: 100%; max-width: 400px; border-radius: 12px; background: #0f172a; }
  #foto-preview { width: 100%; max-width: 400px; border-radius: 12px; display: none; border: 3px solid #22c55e; }
  .berkas-item {
    display: flex; align-items: center; gap: 12px;
    padding: 10px 14px; border-radius: 10px;
    border: 1px solid #e2e8f0; margin-bottom: 8px;
    transition: all 0.15s; cursor: pointer;
  }
  .berkas-item:has(input:checked) {
    background: #f0fdf4; border-color: #86efac;
  }
  .berkas-item input[type="checkbox"] {
    width: 18px; height: 18px; accent-color: #16a34a; flex-shrink: 0;
  }
</style>
@endpush

@section('content')
<div class="max-w-6xl space-y-6">
  <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    
    {{-- Header --}}
    <div class="px-6 py-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
      <div class="flex items-center gap-3">
        <a href="{{ route('admin.pendaftaran.index') }}" class="text-slate-400 hover:text-slate-600 transition-colors">
          <i class="fas fa-arrow-left"></i>
        </a>
        <div>
          <h2 class="font-semibold text-slate-800">Detail Pendaftar ({{ $pendaftaran->no_daftar }})</h2>
          <p class="text-xs text-slate-400">Daftar: {{ $pendaftaran->created_at->format('d M Y, H:i') }} • Tahun: {{ $pendaftaran->tahun_aktif }} • {{ $pendaftaran->gelombang ?? '-' }}</p>
        </div>
      </div>

      {{-- Quick Status Change --}}
      <form method="POST" action="{{ route('admin.pendaftaran.updateStatus', $pendaftaran) }}" class="flex items-center gap-2">
        @csrf @method('PATCH')
        <select name="status" class="text-sm border border-slate-200 rounded-lg px-3 py-1.5 bg-white focus:outline-none focus:ring-2 focus:ring-primary/30">
          @foreach(['pending','verifikasi','diterima','ditolak'] as $s)
            <option value="{{ $s }}" {{ $pendaftaran->status == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
          @endforeach
        </select>
        <button type="submit" class="bg-primary hover:bg-secondary text-white text-sm font-semibold px-4 py-1.5 rounded-lg transition-colors">Update</button>
      </form>
    </div>


    {{-- Details Grid --}}
    <div class="p-6 sm:p-8">
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- LEFT COLUMN: Foto & Webcam --}}
        <div class="lg:col-span-1 space-y-6">
          {{-- Preview Foto Siswa --}}
          <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Foto Calon Siswa</h4>
            <div class="text-center mb-5">
              @if($pendaftaran->foto_siswa)
                <img id="current-siswa-foto" src="{{ asset('storage/' . $pendaftaran->foto_siswa) }}" alt="Foto {{ $pendaftaran->nama_lengkap }}" class="w-28 h-36 object-cover mx-auto rounded-xl border-4 border-orange-100 shadow-sm">
                <p class="text-xs text-green-600 mt-2 font-medium"><i class="fas fa-check-circle text-xs"></i> Foto tersedia</p>
              @else
                <div class="w-28 h-36 bg-slate-50 mx-auto rounded-xl border-2 border-dashed border-slate-200 flex flex-col items-center justify-center">
                  <i class="fas fa-user text-slate-300 text-3xl mb-1"></i>
                  <span class="text-xs text-slate-400">Belum difoto</span>
                </div>
              @endif
            </div>
          </div>

          {{-- Webcam Box --}}
          <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="border-b border-slate-100 px-5 py-4 bg-slate-50 flex items-center gap-2">
              <i class="fas fa-camera text-primary"></i>
              <h3 class="font-bold text-slate-800 text-sm">Ambil Foto Siswa (Webcam)</h3>
            </div>
            <div class="p-5 space-y-4">
              <div id="webcam-alert" class="hidden p-3 rounded-xl text-xs"></div>
              
              <div class="flex flex-col items-center gap-3">
                <video id="webcam-feed" autoplay playsinline class="w-full aspect-[4/3] rounded-xl object-cover hidden"></video>
                <img id="foto-preview" alt="Foto Siswa" class="w-full aspect-[4/3] rounded-xl object-cover hidden">
                
                <canvas id="canvas-capture" class="hidden"></canvas>
                
                <div class="w-full flex gap-2">
                  <button id="btn-start-cam" onclick="startCamera()" class="w-full py-2 bg-primary hover:bg-secondary text-white text-xs font-bold rounded-xl transition flex items-center justify-center gap-1.5 shadow-sm">
                    <i class="fas fa-video"></i> Aktifkan Kamera
                  </button>
                  <button id="btn-capture" onclick="capturePhoto()" class="w-full py-2 bg-green-600 hover:bg-green-700 text-white text-xs font-bold rounded-xl transition flex items-center justify-center gap-1.5 shadow-sm hidden">
                    <i class="fas fa-camera"></i> Ambil Foto
                  </button>
                  <button id="btn-retake" onclick="retakePhoto()" class="w-full py-2 bg-orange-500 hover:bg-orange-600 text-white text-xs font-bold rounded-xl transition flex items-center justify-center gap-1.5 shadow-sm hidden">
                    <i class="fas fa-redo"></i> Ulangi
                  </button>
                </div>

                <div id="save-section" class="w-full hidden">
                  <button onclick="savePhoto()" id="btn-save" class="w-full py-2.5 bg-green-600 hover:bg-green-700 text-white text-xs font-bold rounded-xl transition flex items-center justify-center gap-1.5 shadow-sm">
                    <i class="fas fa-save"></i> Simpan Foto Siswa
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        {{-- RIGHT COLUMN: Data detail --}}
        <div class="lg:col-span-2 space-y-8">
          
          {{-- Section 1: Data Calon Siswa --}}
          <div>
            <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
              <i class="fas fa-user text-primary text-xs"></i> Data Diri Calon Siswa
            </h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div>
            <p class="text-xxs font-bold text-slate-400 uppercase">Nama Lengkap</p>
            <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ $pendaftaran->nama_lengkap }}</p>
          </div>
          <div>
            <p class="text-xxs font-bold text-slate-400 uppercase">Tempat, Tanggal Lahir</p>
            <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ $pendaftaran->tempat_lahir }}, {{ $pendaftaran->tanggal_lahir ? $pendaftaran->tanggal_lahir->format('d M Y') : '-' }}</p>
          </div>
          <div>
            <p class="text-xxs font-bold text-slate-400 uppercase">Jenis Kelamin</p>
            <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ $pendaftaran->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}</p>
          </div>
          <div>
            <p class="text-xxs font-bold text-slate-400 uppercase">Agama</p>
            <p class="text-sm font-semibold text-slate-800 mt-0.5 text-capitalize">{{ $pendaftaran->agama }}</p>
          </div>
          <div>
            <p class="text-xxs font-bold text-slate-400 uppercase">No. HP Siswa</p>
            <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ $pendaftaran->no_hp_siswa }}</p>
          </div>
          <div>
            <p class="text-xxs font-bold text-slate-400 uppercase">Asal Sekolah</p>
            <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ $pendaftaran->asal_sekolah }}</p>
          </div>
          <div class="md:col-span-3">
            <p class="text-xxs font-bold text-slate-400 uppercase">Alamat Sekolah Asal</p>
            <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ $pendaftaran->alamat_sekolah ?? '-' }}</p>
          </div>
          <div class="md:col-span-3">
            <p class="text-xxs font-bold text-slate-400 uppercase">Prestasi yang Pernah Diraih</p>
            <p class="text-sm font-semibold text-slate-800 mt-0.5 italic">{{ $pendaftaran->prestasi ?? '-' }}</p>
          </div>
        </div>
      </div>

      {{-- Section 2: Data Orang Tua --}}
      <div>
        <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
          <i class="fas fa-users text-primary text-xs"></i> Orang Tua / Wali
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div>
            <p class="text-xxs font-bold text-slate-400 uppercase">Nama Orang Tua</p>
            <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ $pendaftaran->nama_ortu }}</p>
          </div>
          <div>
            <p class="text-xxs font-bold text-slate-400 uppercase">Pekerjaan Orang Tua</p>
            <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ $pendaftaran->pekerjaan_ortu }}</p>
          </div>
          <div>
            <p class="text-xxs font-bold text-slate-400 uppercase">No. HP Orang Tua</p>
            <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ $pendaftaran->no_hp_ortu }}</p>
          </div>
        </div>
      </div>

      {{-- Section 3: Alamat --}}
      <div>
        <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
          <i class="fas fa-map-marked-alt text-primary text-xs"></i> Informasi Alamat
        </h3>
        <div class="space-y-4">
          <div>
            <p class="text-xxs font-bold text-slate-400 uppercase">Alamat Asal (Sesuai KK)</p>
            <p class="text-sm font-semibold text-slate-800 mt-1 bg-slate-50 p-3.5 rounded-xl border border-slate-100">
              {{ $pendaftaran->jalan_asal ? $pendaftaran->jalan_asal . ', ' : '' }}
              {{ $pendaftaran->dusun_asal ? 'Dsn. ' . $pendaftaran->dusun_asal . ', ' : '' }}
              RT {{ $pendaftaran->rt_asal }} {{ $pendaftaran->rw_asal ? 'RW ' . $pendaftaran->rw_asal : '' }},
              Kel. {{ $pendaftaran->desa_asal }}, Kec. {{ $pendaftaran->kecamatan_asal }},
              Kab. {{ $pendaftaran->kabupaten_asal }}, Prov. {{ $pendaftaran->provinsi_asal }}
            </p>
          </div>
          <div>
            <p class="text-xxs font-bold text-slate-400 uppercase">Alamat Tempat Tinggal Sekarang</p>
            <p class="text-sm font-semibold text-slate-800 mt-1 bg-slate-50 p-3.5 rounded-xl border border-slate-100">
              {{ $pendaftaran->jalan_tinggal ? $pendaftaran->jalan_tinggal . ', ' : '' }}
              {{ $pendaftaran->dusun_tinggal ? 'Dsn. ' . $pendaftaran->dusun_tinggal . ', ' : '' }}
              RT {{ $pendaftaran->rt_tinggal }} {{ $pendaftaran->rw_tinggal ? 'RW ' . $pendaftaran->rw_tinggal : '' }},
              Kel. {{ $pendaftaran->desa_tinggal }}, Kec. {{ $pendaftaran->kecamatan_tinggal }},
              Kab. {{ $pendaftaran->kabupaten_tinggal }}, Prov. {{ $pendaftaran->provinsi_tinggal }}
            </p>
          </div>
        </div>
      </div>

      {{-- Section 4: Minat Jurusan --}}
      <div>
        <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
          <i class="fas fa-graduation-cap text-primary text-xs"></i> Pilihan Kompetensi Keahlian
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          @php
            $jurusans = ['TKR'=>'Teknik Kendaraan Ringan (Otomotif)', 'TPM'=>'Teknik Permesinan', 'TAV'=>'Teknik Audio Video', 'TBSM'=>'Teknik Bisnis Sepeda Motor', 'RPL'=>'Rekayasa Perangkat Lunak'];
          @endphp
          <div class="bg-blue-50/50 border border-blue-100 rounded-xl p-4">
            <p class="text-xxs font-bold text-blue-500 uppercase">Jurusan Ke-I</p>
            <p class="text-sm font-bold text-blue-800 mt-0.5">{{ $jurusans[$pendaftaran->pil1] ?? $pendaftaran->pil1 }}</p>
          </div>
          <div class="bg-slate-50 border border-slate-150 rounded-xl p-4">
            <p class="text-xxs font-bold text-slate-400 uppercase">Jurusan Ke-II</p>
            <p class="text-sm font-semibold text-slate-700 mt-0.5">{{ $jurusans[$pendaftaran->pil2] ?? $pendaftaran->pil2 }}</p>
          </div>
          <div class="bg-slate-50 border border-slate-150 rounded-xl p-4">
            <p class="text-xxs font-bold text-slate-400 uppercase">Jurusan Ke-III</p>
            <p class="text-sm font-semibold text-slate-700 mt-0.5">{{ $jurusans[$pendaftaran->pil3] ?? $pendaftaran->pil3 }}</p>
          </div>
        </div>
      </div>

      {{-- Section 5: Hasil Pemeriksaan Kesehatan (UKS) --}}
      <div>
        <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
          <i class="fas fa-heartbeat text-emerald-500 text-xs"></i> Pemeriksaan Kesehatan (UKS)
        </h3>
        @if($pendaftaran->kesehatan_verified_at)
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6 bg-slate-50/50 p-5 rounded-2xl border border-slate-100">
            <div>
              <p class="text-xxs font-bold text-slate-400 uppercase">Tinggi / Berat Badan</p>
              <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ $pendaftaran->kesehatan_tinggi_badan ?? '-' }} cm / {{ $pendaftaran->kesehatan_berat_badan ?? '-' }} kg</p>
            </div>
            <div>
              <p class="text-xxs font-bold text-slate-400 uppercase">Golongan Darah</p>
              <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ $pendaftaran->kesehatan_golongan_darah ?? '-' }}</p>
            </div>
            <div>
              <p class="text-xxs font-bold text-slate-400 uppercase">Buta Warna</p>
              <p class="text-sm font-semibold mt-0.5 {{ $pendaftaran->kesehatan_buta_warna === 'ya' ? 'text-rose-600' : 'text-emerald-600' }}">
                {{ $pendaftaran->kesehatan_buta_warna === 'ya' ? 'Ya (Buta Warna)' : 'Tidak (Normal)' }}
              </p>
            </div>
            <div>
              <p class="text-xxs font-bold text-slate-400 uppercase">Mata Minus (Kanan/Kiri)</p>
              <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ $pendaftaran->kesehatan_mata_minus ?? '-' }}</p>
            </div>
            <div>
              <p class="text-xxs font-bold text-slate-400 uppercase">Tato & Tindik</p>
              <p class="text-sm font-semibold text-slate-800 mt-0.5">
                @if($pendaftaran->kesehatan_tato_tindik === 'tidak')
                  Tidak bertato/tindik
                @elseif($pendaftaran->kesehatan_tato_tindik === 'tato')
                  Ada Tato
                @elseif($pendaftaran->kesehatan_tato_tindik === 'tindik')
                  Ada Tindik
                @elseif($pendaftaran->kesehatan_tato_tindik === 'tato_tindik')
                  Tato & Tindik
                @else
                  -
                @endif
              </p>
            </div>
            <div>
              <p class="text-xxs font-bold text-slate-400 uppercase">Riwayat Penyakit</p>
              <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ $pendaftaran->kesehatan_riwayat_penyakit ?? 'Tidak ada' }}</p>
            </div>
            <div>
              <p class="text-xxs font-bold text-slate-400 uppercase">Petugas / Waktu Periksa</p>
              <p class="text-xs font-semibold text-slate-550 mt-0.5">
                {{ $pendaftaran->kesehatan_petugas ?? '-' }}<br>
                <span class="text-xxs text-slate-400">{{ $pendaftaran->kesehatan_verified_at ? $pendaftaran->kesehatan_verified_at->format('d M Y, H:i') : '' }}</span>
              </p>
            </div>
            <div class="md:col-span-3">
              <p class="text-xxs font-bold text-slate-400 uppercase">Catatan Kesehatan</p>
              <p class="text-sm font-semibold text-slate-800 mt-0.5 bg-white p-3 rounded-xl border border-slate-100 italic">{{ $pendaftaran->kesehatan_catatan ?? '-' }}</p>
            </div>
          </div>
        @else
          <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 text-center text-xs text-slate-500 italic">
            <i class="fas fa-info-circle mr-1"></i> Belum ada data pemeriksaan kesehatan dari petugas UKS.
          </div>
        @endif
      </div>

      {{-- Section 6: Hasil Wawancara & Gaya Belajar --}}
      <div>
        <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
          <i class="fas fa-comments text-purple-500 text-xs"></i> Wawancara, Minat Bakat &amp; Gaya Belajar
        </h3>
        @if($pendaftaran->wawancara_verified_at || $pendaftaran->gaya_belajar_verified_at)
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6 bg-slate-50/50 p-5 rounded-2xl border border-slate-100">
            <div>
              <p class="text-xxs font-bold text-slate-400 uppercase">Tipe Gaya Belajar</p>
              <p class="text-sm font-bold text-purple-800 mt-0.5 capitalize">{{ $pendaftaran->gaya_belajar_tipe ?? '-' }}</p>
            </div>
            <div class="md:col-span-2">
              <p class="text-xxs font-bold text-slate-400 uppercase">Minat Bakat / Hobi</p>
              <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ $pendaftaran->gaya_belajar_minat_bakat ?? '-' }}</p>
            </div>
            <div>
              <p class="text-xxs font-bold text-slate-400 uppercase">Baca Tulis Al-Qur'an</p>
              <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ $pendaftaran->wawancara_baca_tulis_alquran ?? '-' }}</p>
            </div>
            <div>
              <p class="text-xxs font-bold text-slate-400 uppercase">Sholat 5 Waktu</p>
              <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ $pendaftaran->wawancara_solat_fardhu ?? '-' }}</p>
            </div>
            <div>
              <p class="text-xxs font-bold text-slate-400 uppercase">Kepribadian / Sikap</p>
              <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ $pendaftaran->wawancara_kepribadian ?? '-' }}</p>
            </div>
            @if($pendaftaran->status_yatim_piatu)
            <div>
              <p class="text-xxs font-bold text-slate-400 uppercase">Status Yatim/Piatu</p>
              <p class="text-sm font-semibold text-slate-800 mt-0.5 capitalize">{{ str_replace('_', ' ', $pendaftaran->status_yatim_piatu) }}</p>
            </div>
            @endif
            <div class="md:col-span-2">
              <p class="text-xxs font-bold text-slate-400 uppercase">Catatan Gaya Belajar</p>
              <p class="text-sm font-semibold text-slate-800 mt-0.5 italic">{{ $pendaftaran->gaya_belajar_catatan ?? '-' }}</p>
            </div>
            <div>
              <p class="text-xxs font-bold text-slate-400 uppercase">Petugas / Waktu Wawancara</p>
              <p class="text-xs font-semibold text-slate-550 mt-0.5">
                {{ $pendaftaran->wawancara_petugas ?? $pendaftaran->gaya_belajar_petugas ?? '-' }}<br>
                <span class="text-xxs text-slate-400">
                  @if($pendaftaran->wawancara_verified_at)
                    {{ $pendaftaran->wawancara_verified_at->format('d M Y, H:i') }}
                  @elseif($pendaftaran->gaya_belajar_verified_at)
                    {{ $pendaftaran->gaya_belajar_verified_at->format('d M Y, H:i') }}
                  @endif
                </span>
              </p>
            </div>
            <div class="md:col-span-3">
              <p class="text-xxs font-bold text-slate-400 uppercase">Catatan Wawancara</p>
              <p class="text-sm font-semibold text-slate-800 mt-0.5 bg-white p-3 rounded-xl border border-slate-100 italic">{{ $pendaftaran->wawancara_catatan ?? '-' }}</p>
            </div>
          </div>
        @else
          <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 text-center text-xs text-slate-500 italic">
            <i class="fas fa-info-circle mr-1"></i> Belum ada data wawancara dan tes gaya belajar.
          </div>
        @endif
      </div>

      {{-- Section 7: Keuangan & Pembayaran --}}
      <div>
        <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
          <i class="fas fa-coins text-yellow-500 text-xs"></i> Pembayaran Pendaftaran (Keuangan)
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 bg-slate-50/50 p-5 rounded-2xl border border-slate-100">
          <div>
            <p class="text-xxs font-bold text-slate-400 uppercase">Status Pembayaran</p>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold mt-1.5
              {{ $pendaftaran->pembayaran_status === 'lunas' ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
              <i class="fas {{ $pendaftaran->pembayaran_status === 'lunas' ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
              {{ $pendaftaran->pembayaran_status === 'lunas' ? 'LUNAS' : 'BELUM BAYAR' }}
            </span>
          </div>
          <div>
            <p class="text-xxs font-bold text-slate-400 uppercase">Nominal Transaksi</p>
            <p class="text-sm font-bold text-slate-850 mt-1 font-mono">Rp {{ number_format($pendaftaran->pembayaran_nominal ?? 0, 0, ',', '.') }}</p>
          </div>
          <div>
            <p class="text-xxs font-bold text-slate-400 uppercase">Petugas / Waktu Transaksi</p>
            <p class="text-xs font-semibold text-slate-550 mt-0.5">
              {{ $pendaftaran->pembayaran_petugas ?? '-' }}<br>
              <span class="text-xxs text-slate-400">{{ $pendaftaran->pembayaran_verified_at ? $pendaftaran->pembayaran_verified_at->format('d M Y, H:i') : '' }}</span>
            </p>
          </div>
          <div class="md:col-span-3">
            <p class="text-xxs font-bold text-slate-400 uppercase">Catatan Pembayaran</p>
            <p class="text-sm font-semibold text-slate-800 mt-0.5 bg-white p-3 rounded-xl border border-slate-100 italic">{{ $pendaftaran->pembayaran_keterangan ?? '-' }}</p>
          </div>
        </div>
      </div>

      {{-- Section 8: Berkas --}}
      <div>
        <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
          <i class="fas fa-file-pdf text-primary text-xs"></i> Berkas Unggahan
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="border rounded-xl p-4 flex items-center justify-between bg-white shadow-xs">
            <div>
              <p class="text-xs font-bold text-slate-700">Akta Kelahiran</p>
              @if($pendaftaran->foto_akta)
                <p class="text-xxs text-emerald-600 font-semibold mt-0.5"><i class="fas fa-check-circle"></i> Berkas Terlampir</p>
              @else
                <p class="text-xxs text-slate-400 font-semibold mt-0.5">Belum diupload</p>
              @endif
            </div>
            @if($pendaftaran->foto_akta)
              <a href="{{ asset('storage/' . $pendaftaran->foto_akta) }}" target="_blank" class="bg-primary/10 text-primary hover:bg-primary/20 text-xs font-bold px-3 py-1.5 rounded-lg transition-colors flex items-center gap-1">
                <i class="fas fa-external-link-alt"></i> Lihat File
              </a>
            @endif
          </div>

          <div class="border rounded-xl p-4 flex items-center justify-between bg-white shadow-xs">
            <div>
              <p class="text-xs font-bold text-slate-700">Kartu Keluarga [KK]</p>
              @if($pendaftaran->foto_kk)
                <p class="text-xxs text-emerald-600 font-semibold mt-0.5"><i class="fas fa-check-circle"></i> Berkas Terlampir</p>
              @else
                <p class="text-xxs text-slate-400 font-semibold mt-0.5">Belum diupload</p>
              @endif
            </div>
            @if($pendaftaran->foto_kk)
              <a href="{{ asset('storage/' . $pendaftaran->foto_kk) }}" target="_blank" class="bg-primary/10 text-primary hover:bg-primary/20 text-xs font-bold px-3 py-1.5 rounded-lg transition-colors flex items-center gap-1">
                <i class="fas fa-external-link-alt"></i> Lihat File
              </a>
            @endif
          </div>
        </div>
      </div>

      {{-- Section 9: Verifikasi Kelengkapan Berkas Fisik --}}
      <div>
        <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
          <i class="fas fa-check-double text-primary text-xs"></i> Verifikasi & Kelengkapan Berkas Fisik
        </h3>
        @php
          $berkasItems = [
              'ijazah_asli'   => 'Ijazah / SKHUN Asli',
              'ijazah_copy'   => 'Fotocopy Ijazah / SKHUN',
              'formulir'      => 'Formulir Pendataan',
              'foto_3x4'      => 'Foto 3x4 (3 lembar)',
              'akta_copy'     => 'Fotocopy Akta Kelahiran',
              'kk_copy'       => 'Fotocopy Kartu Keluarga (KK)',
              'rapor_copy'    => 'Fotocopy Rapor SMP/MTs Semester V',
          ];
          $berkasLengkap = $pendaftaran->berkas_lengkap ?? [];
        @endphp
        <form method="POST" action="{{ route('admin.pendaftaran.updateStatus', $pendaftaran) }}" class="bg-slate-50/50 p-6 rounded-2xl border border-slate-100 space-y-4">
          @csrf @method('PATCH')
          <input type="hidden" name="action_type" value="verifikasi_berkas">
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            @foreach($berkasItems as $key => $label)
              <label class="flex items-center gap-3 p-3 bg-white border border-slate-150 rounded-xl hover:bg-slate-50 transition-colors cursor-pointer">
                <input type="checkbox" name="berkas[]" value="{{ $key }}" {{ in_array($key, $berkasLengkap) ? 'checked' : '' }} class="h-4 w-4 text-primary border-slate-350 rounded focus:ring-primary">
                <span class="text-xs font-semibold text-slate-700">{{ $label }}</span>
              </label>
            @endforeach
          </div>

          <div class="space-y-1.5 mt-4">
            <label class="block text-xs font-bold text-slate-550 uppercase">Catatan Petugas</label>
            <textarea name="catatan_petugas" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition text-xs resize-none" placeholder="Masukkan catatan kelengkapan berkas...">{{ $pendaftaran->catatan_petugas }}</textarea>
          </div>

          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-3 border-t border-slate-100">
            <label class="flex items-center gap-3 cursor-pointer">
              <input type="checkbox" name="tandai_verifikasi" value="1" {{ $pendaftaran->verified_at ? 'checked' : '' }} class="h-4 w-4 text-emerald-500 border-slate-350 rounded focus:ring-emerald-500">
              <span class="text-xs font-bold text-emerald-600">Tandai data pendaftar ini sebagai "Terverifikasi" (verified)</span>
            </label>
            
            <button type="submit" class="bg-primary hover:bg-secondary text-white text-xs font-bold px-4 py-2.5 rounded-xl transition-colors shadow-sm flex items-center gap-1.5">
              <i class="fas fa-save"></i> Simpan Verifikasi Berkas
            </button>
          </div>
        </form>
      </div>

        </div> {{-- End of RIGHT COLUMN --}}
      </div> {{-- End of Grid --}}
    </div> {{-- End of Details Grid --}}

    {{-- Footer Actions --}}
    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex flex-wrap items-center justify-between gap-4">
      <div class="flex items-center gap-2">
        <a href="{{ route('admin.pendaftaran.index') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-650 hover:text-slate-800"><i class="fas fa-chevron-left text-xs"></i> Kembali ke Daftar</a>
      </div>
      <div class="flex items-center gap-2">
        {{-- Cetak --}}
        <a href="{{ route('admin.pendaftaran.cetak', $pendaftaran) }}" target="_blank" class="bg-slate-200 hover:bg-slate-300 text-slate-700 text-sm font-semibold px-4 py-2 rounded-xl transition-colors inline-flex items-center gap-1.5">
          <i class="fas fa-print"></i> Cetak Kartu
        </a>
        {{-- Edit --}}
        <a href="{{ route('admin.pendaftaran.edit', $pendaftaran) }}" class="bg-yellow-500 hover:bg-yellow-650 text-white text-sm font-semibold px-4 py-2 rounded-xl transition-colors inline-flex items-center gap-1.5">
          <i class="fas fa-edit"></i> Edit Data
        </a>
        {{-- Delete --}}
        <form method="POST" action="{{ route('admin.pendaftaran.destroy', $pendaftaran) }}" id="delete-form-detail">
          @csrf @method('DELETE')
          <button type="button" id="btn-delete-detail" class="bg-red-500 hover:bg-red-650 text-white text-sm font-semibold px-4 py-2 rounded-xl transition-colors inline-flex items-center gap-1.5" data-nama="{{ $pendaftaran->nama_lengkap }}" data-no="{{ $pendaftaran->no_daftar }}">
            <i class="fas fa-trash"></i> Hapus
          </button>
        </form>
      </div>
    </div>

  </div>
</div>
@endsection

@section('scripts')
<script>
  // Script Hapus Data
  document.getElementById('btn-delete-detail')?.addEventListener('click', function(e) {
    e.preventDefault();
    const nama = this.getAttribute('data-nama');
    const no = this.getAttribute('data-no');
    const form = document.getElementById('delete-form-detail');
    
    const message = `PENTING! Menghapus data ini akan menghapus secara PERMANEN seluruh data pendaftaran atas nama ${nama} (${no}), termasuk data kesehatan (UKS), wawancara, berkas/foto, dan pembayaran.\n\nTindakan ini tidak dapat dibatalkan.\n\nApakah Anda yakin ingin melanjutkan?`;
    
    if (confirm(message)) {
      form.submit();
    }
  });

  // Script Webcam Kamera
  let stream = null;
  let capturedBlob = null;

  function showAlert(msg, type = 'success') {
    const el = document.getElementById('webcam-alert');
    el.className = 'p-3 rounded-xl text-xs ' +
      (type === 'success' ? 'bg-green-50 border border-green-200 text-green-700' : 'bg-red-50 border border-red-200 text-red-700');
    el.textContent = msg;
    el.classList.remove('hidden');
    setTimeout(() => el.classList.add('hidden'), 5000);
  }

  async function startCamera() {
    try {
      stream = await navigator.mediaDevices.getUserMedia({
        video: { width: { ideal: 640 }, height: { ideal: 480 }, facingMode: 'user' }
      });
      const video = document.getElementById('webcam-feed');
      video.srcObject = stream;
      video.classList.remove('hidden');
      document.getElementById('foto-preview').classList.add('hidden');
      document.getElementById('btn-start-cam').classList.add('hidden');
      document.getElementById('btn-capture').classList.remove('hidden');
      document.getElementById('save-section').classList.add('hidden');
    } catch (err) {
      showAlert('Tidak bisa mengakses kamera: ' + err.message, 'error');
    }
  }

  function capturePhoto() {
    const video = document.getElementById('webcam-feed');
    const canvas = document.getElementById('canvas-capture');
    const preview = document.getElementById('foto-preview');

    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    canvas.getContext('2d').drawImage(video, 0, 0);

    const dataUrl = canvas.toDataURL('image/jpeg', 0.9);
    preview.src = dataUrl;
    preview.classList.remove('hidden');
    video.classList.add('hidden');

    capturedBlob = dataUrl;

    document.getElementById('btn-capture').classList.add('hidden');
    document.getElementById('btn-retake').classList.remove('hidden');
    document.getElementById('save-section').classList.remove('hidden');

    // Stop stream
    if (stream) stream.getTracks().forEach(t => t.stop());
  }

  function retakePhoto() {
    document.getElementById('foto-preview').classList.add('hidden');
    document.getElementById('webcam-feed').classList.remove('hidden');
    document.getElementById('btn-retake').classList.add('hidden');
    document.getElementById('btn-capture').classList.remove('hidden');
    document.getElementById('save-section').classList.add('hidden');
    capturedBlob = null;
    startCamera();
  }

  async function savePhoto() {
    if (!capturedBlob) return;

    const btn = document.getElementById('btn-save');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Menyimpan...';

    try {
      // Kita panggil route upload foto dari PetugasController (petugas.upload.foto) karena endpoint-nya sudah fungsional menerima base64.
      const response = await fetch("{{ route('petugas.upload.foto', $pendaftaran) }}", {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Content-Type': 'application/json',
          'Accept': 'application/json',
        },
        body: JSON.stringify({ foto_data: capturedBlob }),
      });

      const data = await response.json();

      if (data.success) {
        showAlert('✅ ' + data.message);
        setTimeout(() => location.reload(), 1500);
      } else {
        showAlert('❌ ' + data.message, 'error');
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-save mr-1"></i> Simpan Foto';
      }
    } catch (err) {
      showAlert('❌ Terjadi kesalahan jaringan.', 'error');
      btn.disabled = false;
      btn.innerHTML = '<i class="fas fa-save mr-1"></i> Simpan Foto';
    }
  }
</script>
@endsection
