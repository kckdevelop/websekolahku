@extends('layouts.petugas')
@section('title', 'Verifikasi: ' . $pendaftaran->no_daftar)
@section('subtitle', 'Cek berkas, ambil foto siswa, dan cetak kartu')

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
<div class="mb-4 flex items-center gap-3">
  <a href="{{ route('petugas.dashboard') }}" class="text-slate-500 hover:text-slate-700 flex items-center gap-1 text-sm">
    <i class="fas fa-arrow-left"></i> Kembali
  </a>
  <span class="text-slate-300">/</span>
  <span class="text-slate-700 font-semibold text-sm">{{ $pendaftaran->no_daftar }}</span>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

  {{-- LEFT: Data Siswa --}}
  <div class="xl:col-span-1 space-y-5">

    {{-- Kartu Info --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
      <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-5 py-4">
        <div class="flex items-center justify-between">
          <h3 class="font-bold text-white text-sm">Data Calon Siswa</h3>
          @if($pendaftaran->verified_at)
            <span class="text-xs bg-green-400/20 text-green-200 px-2 py-0.5 rounded-full font-semibold">
              ✓ Terverifikasi
            </span>
          @else
            <span class="text-xs bg-orange-400/20 text-orange-200 px-2 py-0.5 rounded-full font-semibold">
              Pending
            </span>
          @endif
        </div>
        <p class="text-blue-100 text-xs mt-1 font-mono">{{ $pendaftaran->no_daftar }}</p>
      </div>

      <div class="p-5">
        {{-- Foto Siswa Preview --}}
        <div class="text-center mb-5">
          @if($pendaftaran->foto_siswa)
            <img src="{{ asset('storage/' . $pendaftaran->foto_siswa) }}"
                 alt="Foto {{ $pendaftaran->nama_lengkap }}"
                 class="w-28 h-36 object-cover mx-auto rounded-xl border-4 border-blue-100 shadow-sm">
            <p class="text-xs text-green-600 mt-1 font-medium"><i class="fas fa-check-circle"></i> Foto tersedia</p>
          @else
            <div class="w-28 h-36 bg-slate-100 mx-auto rounded-xl border-2 border-dashed border-slate-300 flex flex-col items-center justify-center">
              <i class="fas fa-user text-slate-300 text-3xl mb-1"></i>
              <span class="text-xs text-slate-400">Belum difoto</span>
            </div>
          @endif
        </div>

        @php
          $rows = [
            ['Nama Lengkap', $pendaftaran->nama_lengkap],
            ['Jenis Kelamin', $pendaftaran->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan'],
            ['Tempat, Tgl Lahir', $pendaftaran->tempat_lahir . ', ' . ($pendaftaran->tanggal_lahir?->format('d/m/Y') ?? '-')],
            ['Agama', ucfirst($pendaftaran->agama)],
            ['Asal Sekolah', $pendaftaran->asal_sekolah],
            ['No. HP Siswa', $pendaftaran->no_hp_siswa],
            ['Nama Ortu', $pendaftaran->nama_ortu],
            ['No. HP Ortu', $pendaftaran->no_hp_ortu],
            ['Alamat', ($pendaftaran->jalan_tinggal ? $pendaftaran->jalan_tinggal . ', ' : '') .
                       ($pendaftaran->dusun_tinggal ? 'Dsn. ' . $pendaftaran->dusun_tinggal . ', ' : '') .
                       'RT ' . $pendaftaran->rt_tinggal . ($pendaftaran->rw_tinggal ? '/RW ' . $pendaftaran->rw_tinggal : '') . ', ' .
                       $pendaftaran->desa_tinggal . ', ' . $pendaftaran->kecamatan_tinggal . ', ' . $pendaftaran->kabupaten_tinggal],
            ['Pil. Jurusan I', $pendaftaran->pil1],
            ['Pil. Jurusan II', $pendaftaran->pil2],
            ['Pil. Jurusan III', $pendaftaran->pil3],
            ['Gelombang', $pendaftaran->gelombang ?? '-'],
          ];
        @endphp

        <table class="w-full text-xs">
          @foreach($rows as [$label, $value])
          <tr class="border-b border-slate-50 last:border-0">
            <td class="py-1.5 text-slate-500 w-2/5">{{ $label }}</td>
            <td class="py-1.5 font-semibold text-slate-800">{{ $value }}</td>
          </tr>
          @endforeach
        </table>

        <div class="mt-4 flex gap-2">
          <a href="{{ route('petugas.kartu', $pendaftaran) }}" target="_blank"
             class="flex-1 text-center py-2.5 bg-slate-800 text-white text-xs rounded-xl hover:bg-slate-900 transition font-semibold">
            <i class="fas fa-print mr-1"></i> Cetak Kartu
          </a>
          <button type="button" id="btn-show-detail" data-id="{{ $pendaftaran->id }}"
             class="flex-1 text-center py-2.5 bg-slate-100 text-slate-600 text-xs rounded-xl hover:bg-slate-200 transition font-semibold">
            <i class="fas fa-eye mr-1"></i> Detail
          </button>
        </div>
      </div>
    </div>

  </div>

  {{-- RIGHT: Webcam + Berkas --}}
  <div class="xl:col-span-2 space-y-5">

    {{-- Webcam Foto --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
      <div class="border-b border-slate-100 px-5 py-4 bg-slate-50 flex items-center gap-2">
        <i class="fas fa-camera text-blue-600"></i>
        <h3 class="font-bold text-slate-800 text-sm">Ambil Foto Siswa (Webcam)</h3>
      </div>
      <div class="p-5">

        <div id="webcam-alert" class="hidden mb-4 p-3 rounded-xl text-sm"></div>

        <div class="flex flex-col md:flex-row gap-5 items-start">
          <div class="flex-1">
            <video id="webcam-feed" autoplay playsinline class="aspect-[4/3]"></video>
            <img id="foto-preview" alt="Foto Siswa" class="aspect-[4/3]">

            <div class="flex gap-2 mt-3">
              <button id="btn-start-cam" onclick="startCamera()"
                class="flex-1 py-2.5 bg-blue-600 text-white text-sm rounded-xl hover:bg-blue-700 transition font-semibold">
                <i class="fas fa-video mr-1"></i> Aktifkan Kamera
              </button>
              <button id="btn-capture" onclick="capturePhoto()" style="display:none;"
                class="flex-1 py-2.5 bg-green-600 text-white text-sm rounded-xl hover:bg-green-700 transition font-semibold">
                <i class="fas fa-camera mr-1"></i> Ambil Foto
              </button>
              <button id="btn-retake" onclick="retakePhoto()" style="display:none;"
                class="flex-1 py-2.5 bg-orange-500 text-white text-sm rounded-xl hover:bg-orange-600 transition font-semibold">
                <i class="fas fa-redo mr-1"></i> Ulangi
              </button>
            </div>
          </div>

          <div class="flex-1">
            <canvas id="canvas-capture" style="display:none;"></canvas>

            <div id="save-section" style="display:none;" class="space-y-3">
              <p class="text-sm font-semibold text-slate-700">Pratinjau Foto:</p>
              <div class="p-3 bg-green-50 rounded-xl border border-green-200 text-xs text-green-700">
                <i class="fas fa-info-circle mr-1"></i>
                Pastikan wajah siswa terlihat jelas, pencahayaan cukup, dan latar belakang netral.
              </div>
              <button onclick="savePhoto()" id="btn-save"
                class="w-full py-3 bg-green-600 text-white text-sm rounded-xl hover:bg-green-700 transition font-bold">
                <i class="fas fa-save mr-1"></i> Simpan Foto
              </button>
            </div>

            @if($pendaftaran->foto_siswa)
            <div class="mt-3 p-3 bg-blue-50 rounded-xl border border-blue-200">
              <p class="text-xs font-semibold text-blue-700 mb-2">
                <i class="fas fa-image mr-1"></i> Foto Tersimpan Saat Ini:
              </p>
              <img src="{{ asset('storage/' . $pendaftaran->foto_siswa) }}"
            </div>
            @endif
          </div>
        </div>

      </div>
    </div>

    {{-- Checklist Berkas --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
      <div class="border-b border-slate-100 px-5 py-4 bg-slate-50 flex items-center gap-2">
        <i class="fas fa-clipboard-list text-blue-600"></i>
        <h3 class="font-bold text-slate-800 text-sm">Kelengkapan Berkas</h3>
      </div>

      <form method="POST" action="{{ route('petugas.update.berkas', $pendaftaran) }}" class="p-5">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-5">
          @foreach($berkasItems as $key => $label)
          <label class="berkas-item">
            <input type="checkbox" name="berkas[]" value="{{ $key }}"
              {{ in_array($key, $berkasLengkap) ? 'checked' : '' }}>
            <span class="text-sm text-slate-700">{{ $label }}</span>
          </label>
          @endforeach
        </div>

        {{-- Catatan Petugas --}}
        <div class="mb-5">
          <label class="block text-sm font-medium text-slate-700 mb-1.5">
            <i class="fas fa-sticky-note text-blue-400 mr-1"></i> Catatan Petugas
          </label>
          <textarea name="catatan_petugas" rows="3" placeholder="Catatan kelengkapan, kondisi berkas, dll..."
            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-300 focus:border-blue-500 outline-none text-sm resize-none">{{ $pendaftaran->catatan_petugas }}</textarea>
        </div>

        {{-- Tandai Verifikasi --}}
        <div class="p-4 bg-emerald-50 rounded-xl border border-emerald-200 flex items-center justify-between mb-5">
          <div>
            <p class="font-semibold text-emerald-800 text-sm">Tandai Sudah Diverifikasi</p>
            <p class="text-xs text-emerald-600 mt-0.5">Berkas sudah dicek, foto sudah diambil, siap cetak kartu.</p>
          </div>
          <label class="relative inline-flex items-center cursor-pointer flex-shrink-0">
            <input type="checkbox" name="tandai_verifikasi" value="1" class="sr-only peer"
              {{ $pendaftaran->verified_at ? 'checked' : '' }}>
            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
          </label>
        </div>

        <button type="submit"
          class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-xl transition">
          <i class="fas fa-save mr-1"></i> Simpan Kelengkapan Berkas
        </button>
      </form>
    </div>

  </div>
</div>

{{-- Dynamic Modal for Detail & Edit --}}
<div id="pendaftaran-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 backdrop-blur-sm p-4 overflow-y-auto">
  <div class="bg-white rounded-3xl max-w-5xl w-full shadow-2xl overflow-hidden flex flex-col my-8 max-h-[90vh] transform scale-95 opacity-0 transition-all duration-300" id="modal-content">
    
    {{-- Modal Header --}}
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center justify-between flex-shrink-0">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
          <i id="modal-title-icon" class="fas fa-eye text-lg"></i>
        </div>
        <div>
          <h3 id="modal-title" class="font-bold text-slate-800 text-base sm:text-lg">Detail Calon Siswa</h3>
          <p id="modal-subtitle" class="text-xs text-slate-400"></p>
        </div>
      </div>
      <div class="flex items-center gap-3">
        {{-- View / Edit Mode Switcher --}}
        <button type="button" id="modal-mode-toggle" class="bg-primary/10 text-primary hover:bg-primary/20 text-xs font-bold px-4 py-2 rounded-xl transition flex items-center gap-1.5">
          <i class="fas fa-edit"></i> <span id="modal-mode-text">Ubah Data</span>
        </button>
        <button type="button" onclick="closePendaftaranModal()" class="text-slate-400 hover:text-slate-600 text-2xl font-bold leading-none p-1">&times;</button>
      </div>
    </div>
    
    {{-- Modal Body (Scrollable) --}}
    <div class="flex-grow overflow-y-auto custom-scrollbar">
      
      {{-- Loading Spinner State --}}
      <div id="modal-loading-state" class="py-20 flex flex-col items-center justify-center text-slate-400">
        <i class="fas fa-spinner fa-spin text-4xl text-primary mb-3"></i>
        <p class="text-sm font-medium">Memuat data pendaftar...</p>
      </div>
      
      {{-- Detail View Content --}}
      <div id="modal-detail-view" class="p-6 md:p-8 space-y-8 hidden">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
          {{-- Left Side: Photo & Status --}}
          <div class="md:col-span-1 flex flex-col items-center text-center space-y-4 border-b md:border-b-0 md:border-r border-slate-100 pb-6 md:pb-0 md:pr-6">
            <div class="w-36 h-48 rounded-xl bg-slate-50 border border-slate-200 shadow-inner overflow-hidden flex items-center justify-center relative group">
              <img id="detail-foto-siswa" src="" class="w-full h-full object-cover hidden">
              <div id="detail-foto-placeholder" class="text-slate-300 flex flex-col items-center justify-center">
                <i class="fas fa-user-circle text-7xl"></i>
                <span class="text-xxs mt-2 text-slate-400">Belum ada foto</span>
              </div>
            </div>
            
            <div class="w-full">
              <div id="detail-status-badge" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold capitalize font-mono"></div>
            </div>
            
            <div class="w-full space-y-2 pt-2">
              <a id="detail-link-cetak" href="#" target="_blank" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold py-2.5 rounded-xl transition flex items-center justify-center gap-1.5 border border-slate-200 shadow-sm">
                <i class="fas fa-print"></i> Cetak Kartu Pendaftaran
              </a>
            </div>
          </div>
          
          {{-- Right Side: Fields Grid --}}
          <div class="md:col-span-3 space-y-8">
            {{-- Data Diri --}}
            <div>
              <h4 class="text-xs font-bold text-primary uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                <i class="fas fa-user"></i> Data Diri Calon Siswa
              </h4>
              <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5">
                <div>
                  <span class="text-xxs font-bold text-slate-400 uppercase block">Nama Lengkap</span>
                  <span id="d-nama" class="text-sm font-semibold text-slate-800 block mt-1"></span>
                </div>
                <div>
                  <span class="text-xxs font-bold text-slate-400 uppercase block">Tempat, Tgl Lahir</span>
                  <span id="d-ttl" class="text-sm font-semibold text-slate-800 block mt-1"></span>
                </div>
                <div>
                  <span class="text-xxs font-bold text-slate-400 uppercase block">Jenis Kelamin</span>
                  <span id="d-jk" class="text-sm font-semibold text-slate-800 block mt-1"></span>
                </div>
                <div>
                  <span class="text-xxs font-bold text-slate-400 uppercase block">Agama</span>
                  <span id="d-agama" class="text-sm font-semibold text-slate-800 block mt-1 capitalize"></span>
                </div>
                <div>
                  <span class="text-xxs font-bold text-slate-400 uppercase block">No. HP Siswa</span>
                  <span id="d-hp-siswa" class="text-sm font-semibold text-slate-800 block mt-1"></span>
                </div>
                <div>
                  <span class="text-xxs font-bold text-slate-400 uppercase block">Asal Sekolah</span>
                  <span id="d-asal-sekolah" class="text-sm font-semibold text-slate-800 block mt-1"></span>
                </div>
                <div class="sm:col-span-2 md:col-span-3">
                  <span class="text-xxs font-bold text-slate-400 uppercase block">Alamat Sekolah Asal</span>
                  <span id="d-alamat-sekolah" class="text-sm font-semibold text-slate-800 block mt-1"></span>
                </div>
                <div class="sm:col-span-2 md:col-span-3">
                  <span class="text-xxs font-bold text-slate-400 uppercase block">Prestasi</span>
                  <span id="d-prestasi" class="text-sm font-semibold text-slate-800 block mt-1 italic"></span>
                </div>
              </div>
            </div>
            
            {{-- Data Orang Tua --}}
            <div>
              <h4 class="text-xs font-bold text-primary uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                <i class="fas fa-users"></i> Orang Tua / Wali
              </h4>
              <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div>
                  <span class="text-xxs font-bold text-slate-400 uppercase block">Nama Orang Tua</span>
                  <span id="d-nama-ortu" class="text-sm font-semibold text-slate-800 block mt-1"></span>
                </div>
                <div>
                  <span class="text-xxs font-bold text-slate-400 uppercase block">Pekerjaan Orang Tua</span>
                  <span id="d-pekerjaan-ortu" class="text-sm font-semibold text-slate-800 block mt-1"></span>
                </div>
                <div>
                  <span class="text-xxs font-bold text-slate-400 uppercase block">No. HP Orang Tua</span>
                  <span id="d-hp-ortu" class="text-sm font-semibold text-slate-800 block mt-1"></span>
                </div>
              </div>
            </div>
            
            {{-- Alamat --}}
            <div>
              <h4 class="text-xs font-bold text-primary uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                <i class="fas fa-map-marked-alt"></i> Informasi Alamat
              </h4>
              <div class="space-y-4">
                <div>
                  <span class="text-xxs font-bold text-slate-400 uppercase block">Alamat Asal (Sesuai KK)</span>
                  <p id="d-alamat-asal" class="text-sm font-semibold text-slate-800 mt-1.5 bg-slate-50 p-4 rounded-2xl border border-slate-100 leading-relaxed"></p>
                </div>
                <div>
                  <span class="text-xxs font-bold text-slate-400 uppercase block">Alamat Tempat Tinggal Sekarang</span>
                  <p id="d-alamat-tinggal" class="text-sm font-semibold text-slate-800 mt-1.5 bg-slate-50 p-4 rounded-2xl border border-slate-100 leading-relaxed"></p>
                </div>
              </div>
            </div>
            
            {{-- Pilihan Jurusan --}}
            <div>
              <h4 class="text-xs font-bold text-primary uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                <i class="fas fa-graduation-cap"></i> Pilihan Jurusan (Pilihan Kompetensi Keahlian)
              </h4>
              <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-blue-50/50 border border-blue-100 rounded-2xl p-4">
                  <span class="text-xxs font-bold text-blue-500 uppercase block">Jurusan Ke-I</span>
                  <span id="d-pil1" class="text-sm font-bold text-blue-800 block mt-1"></span>
                </div>
                <div class="bg-slate-50 border border-slate-150 rounded-2xl p-4">
                  <span class="text-xxs font-bold text-slate-400 uppercase block">Jurusan Ke-II</span>
                  <span id="d-pil2" class="text-sm font-semibold text-slate-700 block mt-1"></span>
                </div>
                <div class="bg-slate-50 border border-slate-150 rounded-2xl p-4">
                  <span class="text-xxs font-bold text-slate-400 uppercase block">Jurusan Ke-III</span>
                  <span id="d-pil3" class="text-sm font-semibold text-slate-700 block mt-1"></span>
                </div>
              </div>
            </div>
            
            {{-- Berkas Unggahan --}}
            <div>
              <h4 class="text-xs font-bold text-primary uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                <i class="fas fa-file-pdf"></i> Berkas Unggahan
              </h4>
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="border border-slate-200 rounded-2xl p-4 flex items-center justify-between bg-white">
                  <div>
                    <span class="text-xs font-bold text-slate-700 block">Akta Kelahiran</span>
                    <span id="d-akta-status" class="text-xxs block mt-1"></span>
                  </div>
                  <a id="d-akta-link" href="#" target="_blank" class="bg-primary/10 text-primary hover:bg-primary/20 text-xs font-bold px-3 py-1.5 rounded-lg transition-colors flex items-center gap-1">
                    <i class="fas fa-external-link-alt"></i> Lihat File
                  </a>
                </div>
                <div class="border border-slate-200 rounded-2xl p-4 flex items-center justify-between bg-white">
                  <div>
                    <span class="text-xs font-bold text-slate-700 block">Kartu Keluarga [KK]</span>
                    <span id="d-kk-status" class="text-xxs block mt-1"></span>
                  </div>
                  <a id="d-kk-link" href="#" target="_blank" class="bg-primary/10 text-primary hover:bg-primary/20 text-xs font-bold px-3 py-1.5 rounded-lg transition-colors flex items-center gap-1">
                    <i class="fas fa-external-link-alt"></i> Lihat File
                  </a>
                </div>
              </div>
            </div>
            
          </div>
        </div>
      </div>
      
      {{-- Edit Form Content --}}
      <div id="modal-edit-view" class="p-6 md:p-8 hidden">
        <form id="modal-edit-form" class="space-y-8" novalidate>
          <input type="hidden" name="_method" value="PUT">
          
          {{-- Section 1: Data Calon Siswa --}}
          <div class="space-y-5">
            <h4 class="text-xs font-bold text-primary uppercase tracking-wider pb-2 border-b border-slate-100 flex items-center gap-2">
              <i class="fas fa-user"></i> Data Calon Siswa
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
              <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="nama_lengkap" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition text-sm">
                <span class="error-msg text-red-500 text-xs mt-1 block hidden"></span>
              </div>
              <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Tempat Lahir <span class="text-red-500">*</span></label>
                <input type="text" name="tempat_lahir" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition text-sm">
                <span class="error-msg text-red-500 text-xs mt-1 block hidden"></span>
              </div>
              <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Tanggal Lahir <span class="text-red-500">*</span></label>
                <div class="grid grid-cols-3 gap-2">
                  <select name="tgl" required class="px-3 py-2.5 rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-sm">
                    <option value="">Tgl</option>
                    @for($i = 1; $i <= 31; $i++)
                      <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                  </select>
                  <select name="bulan" required class="px-3 py-2.5 rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-sm">
                    <option value="">Bulan</option>
                    @foreach(['01'=>'Januari', '02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni', '07'=>'Juli', '08'=>'Agustus', '09'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Desember'] as $key => $name)
                      <option value="{{ $key }}">{{ $name }}</option>
                    @endforeach
                  </select>
                  <select name="tahun" required class="px-3 py-2.5 rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-sm">
                    <option value="">Tahun</option>
                    @for($y = 2000; $y <= 2020; $y++)
                      <option value="{{ $y }}">{{ $y }}</option>
                    @endfor
                  </select>
                </div>
                <span class="error-msg text-red-500 text-xs mt-1 block hidden"></span>
              </div>
              <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Jenis Kelamin <span class="text-red-500">*</span></label>
                <select name="jenkel" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition text-sm">
                  <option value="">-- Pilih Jenis Kelamin --</option>
                  <option value="L">Laki-Laki</option>
                  <option value="P">Perempuan</option>
                </select>
                <span class="error-msg text-red-500 text-xs mt-1 block hidden"></span>
              </div>
              <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Agama <span class="text-red-500">*</span></label>
                <select name="agama" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition text-sm">
                  <option value="islam">Islam</option>
                  <option value="kristen">Kristen</option>
                  <option value="katolik">Katolik</option>
                  <option value="hindu">Hindu</option>
                  <option value="budha">Budha</option>
                </select>
                <span class="error-msg text-red-500 text-xs mt-1 block hidden"></span>
              </div>
              <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">No. HP Siswa <span class="text-red-500">*</span></label>
                <input type="text" name="no_hp_siswa" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition text-sm">
                <span class="error-msg text-red-500 text-xs mt-1 block hidden"></span>
              </div>
              <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Asal Sekolah <span class="text-red-500">*</span></label>
                <input type="text" name="asal_sekolah" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition text-sm">
                <span class="error-msg text-red-500 text-xs mt-1 block hidden"></span>
              </div>
              <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Alamat Sekolah Asal</label>
                <textarea name="alamat_sekolah" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition text-sm resize-none"></textarea>
                <span class="error-msg text-red-500 text-xs mt-1 block hidden"></span>
              </div>
              <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Prestasi yang Pernah Diraih</label>
                <textarea name="prestasi" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition text-sm resize-none"></textarea>
                <span class="error-msg text-red-500 text-xs mt-1 block hidden"></span>
              </div>
            </div>
          </div>
          
          {{-- Section 2: Data Orang Tua --}}
          <div class="space-y-5">
            <h4 class="text-xs font-bold text-primary uppercase tracking-wider pb-2 border-b border-slate-100 flex items-center gap-2">
              <i class="fas fa-users"></i> Data Orang Tua / Wali
            </h4>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
              <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Orang Tua <span class="text-red-500">*</span></label>
                <input type="text" name="nama_ortu" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition text-sm">
                <span class="error-msg text-red-500 text-xs mt-1 block hidden"></span>
              </div>
              <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Pekerjaan Orang Tua <span class="text-red-500">*</span></label>
                <input type="text" name="pekerjaan_ortu" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition text-sm">
                <span class="error-msg text-red-500 text-xs mt-1 block hidden"></span>
              </div>
              <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">No. HP Orang Tua <span class="text-red-500">*</span></label>
                <input type="text" name="no_hp_ortu" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition text-sm">
                <span class="error-msg text-red-500 text-xs mt-1 block hidden"></span>
              </div>
            </div>
          </div>
          
          {{-- Section 3: Alamat --}}
          <div class="space-y-5">
            <h4 class="text-xs font-bold text-primary uppercase tracking-wider pb-2 border-b border-slate-100 flex items-center gap-2">
              <i class="fas fa-map-marked-alt"></i> Alamat Lengkap
            </h4>
            
            {{-- Alamat Asal --}}
            <div>
              <h5 class="text-xs font-bold text-slate-600 mb-3 uppercase tracking-wide">Alamat Asal (Sesuai KK)</h5>
              <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                  <label class="block text-xs font-semibold text-slate-500 mb-1">Jalan</label>
                  <input type="text" name="jalan_asal" id="m_jalan_asal" class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none">
                </div>
                <div>
                  <label class="block text-xs font-semibold text-slate-500 mb-1">Dusun</label>
                  <input type="text" name="dusun_asal" id="m_dusun_asal" class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none">
                </div>
                <div class="grid grid-cols-2 gap-2">
                  <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1">RT <span class="text-red-500">*</span></label>
                    <input type="text" name="rt_asal" id="m_rt_asal" required class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none" placeholder="00">
                  </div>
                  <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1">RW</label>
                    <input type="text" name="rw_asal" id="m_rw_asal" class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none" placeholder="00">
                  </div>
                </div>
                <div>
                  <label class="block text-xs font-semibold text-slate-500 mb-1">Desa <span class="text-red-500">*</span></label>
                  <input type="text" name="desa_asal" id="m_desa_asal" required class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none">
                </div>
                <div>
                  <label class="block text-xs font-semibold text-slate-500 mb-1">Kecamatan <span class="text-red-500">*</span></label>
                  <input type="text" name="kecamatan_asal" id="m_kecamatan_asal" required class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none">
                </div>
                <div>
                  <label class="block text-xs font-semibold text-slate-500 mb-1">Kabupaten <span class="text-red-500">*</span></label>
                  <input type="text" name="kabupaten_asal" id="m_kabupaten_asal" required class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none">
                </div>
                <div>
                  <label class="block text-xs font-semibold text-slate-500 mb-1">Provinsi <span class="text-red-500">*</span></label>
                  <input type="text" name="provinsi_asal" id="m_provinsi_asal" required class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none">
                </div>
              </div>
            </div>
            
            <div class="flex items-center bg-slate-50 p-4 rounded-xl border border-slate-100">
              <input type="checkbox" id="m_copy_address" class="h-4 w-4 text-primary border-slate-300 rounded focus:ring-primary cursor-pointer">
              <label for="m_copy_address" class="ml-3 text-sm font-semibold text-slate-700 cursor-pointer">
                Centang jika Alamat Tinggal Sekarang sama dengan Alamat Asal
              </label>
            </div>
            
            {{-- Alamat Tinggal --}}
            <div>
              <h5 class="text-xs font-bold text-slate-600 mb-3 uppercase tracking-wide">Alamat Tinggal Sekarang</h5>
              <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                  <label class="block text-xs font-semibold text-slate-500 mb-1">Jalan</label>
                  <input type="text" name="jalan_tinggal" id="m_jalan_tinggal" class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none">
                </div>
                <div>
                  <label class="block text-xs font-semibold text-slate-500 mb-1">Dusun</label>
                  <input type="text" name="dusun_tinggal" id="m_dusun_tinggal" class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none">
                </div>
                <div class="grid grid-cols-2 gap-2">
                  <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1">RT <span class="text-red-500">*</span></label>
                    <input type="text" name="rt_tinggal" id="m_rt_tinggal" required class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none" placeholder="00">
                  </div>
                  <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1">RW</label>
                    <input type="text" name="rw_tinggal" id="m_rw_tinggal" class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none" placeholder="00">
                  </div>
                </div>
                <div>
                  <label class="block text-xs font-semibold text-slate-500 mb-1">Desa <span class="text-red-500">*</span></label>
                  <input type="text" name="desa_tinggal" id="m_desa_tinggal" required class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none">
                </div>
                <div>
                  <label class="block text-xs font-semibold text-slate-500 mb-1">Kecamatan <span class="text-red-500">*</span></label>
                  <input type="text" name="kecamatan_tinggal" id="m_kecamatan_tinggal" required class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none">
                </div>
                <div>
                  <label class="block text-xs font-semibold text-slate-500 mb-1">Kabupaten <span class="text-red-500">*</span></label>
                  <input type="text" name="kabupaten_tinggal" id="m_kabupaten_tinggal" required class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none">
                </div>
                <div>
                  <label class="block text-xs font-semibold text-slate-500 mb-1">Provinsi <span class="text-red-500">*</span></label>
                  <input type="text" name="provinsi_tinggal" id="m_provinsi_tinggal" required class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none">
                </div>
              </div>
            </div>
          </div>
          
          {{-- Section 4: Pilihan Jurusan --}}
          <div class="space-y-5">
            <h4 class="text-xs font-bold text-primary uppercase tracking-wider pb-2 border-b border-slate-100 flex items-center gap-2">
              <i class="fas fa-graduation-cap"></i> Pilihan Kompetensi Keahlian (Jurusan)
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
              @php
                $jurusans = [
                  'TKR' => 'Teknik Kendaraan Ringan (Otomotif)',
                  'TPM' => 'Teknik Permesinan',
                  'TAV' => 'Teknik Audio Video (Elektronika)',
                  'TBSM' => 'Teknik Bisnis Sepeda Motor',
                  'RPL' => 'Rekayasa Perangkat Lunak (Komputer)'
                ];
              @endphp
              <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Pilihan I <span class="text-red-500">*</span></label>
                <select name="pil1" id="m_pil1" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition text-sm">
                  <option value="">-- Pilihan Jurusan I --</option>
                  @foreach($jurusans as $code => $name)
                    <option value="{{ $code }}">{{ $name }}</option>
                  @endforeach
                </select>
              </div>
              <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Pilihan II <span class="text-red-500">*</span></label>
                <select name="pil2" id="m_pil2" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition text-sm">
                  <option value="">-- Pilihan Jurusan II --</option>
                  @foreach($jurusans as $code => $name)
                    <option value="{{ $code }}">{{ $name }}</option>
                  @endforeach
                </select>
              </div>
              <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Pilihan III <span class="text-red-500">*</span></label>
                <select name="pil3" id="m_pil3" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition text-sm">
                  <option value="">-- Pilihan Jurusan III --</option>
                  @foreach($jurusans as $code => $name)
                    <option value="{{ $code }}">{{ $name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <p id="m_jurusan-error" class="hidden text-xs text-red-500 font-medium"><i class="fas fa-exclamation-circle mr-1"></i> Pilihan jurusan tidak boleh ada yang sama!</p>
          </div>
          
          {{-- Section 5: Status & Berkas --}}
          <div class="space-y-5">
            <h4 class="text-xs font-bold text-primary uppercase tracking-wider pb-2 border-b border-slate-100 flex items-center gap-2">
              <i class="fas fa-file-upload"></i> Berkas & Status
            </h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-5">
              <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Gelombang Pendaftaran <span class="text-red-500">*</span></label>
                <select name="gelombang_id" id="m_gelombang_id" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition text-sm">
                  {{-- populated dynamically --}}
                </select>
              </div>
              <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Status Pendaftaran <span class="text-red-500">*</span></label>
                <select name="status" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition text-sm">
                  <option value="pending">Pending</option>
                  <option value="verifikasi">Verifikasi</option>
                  <option value="diterima">Diterima</option>
                  <option value="ditolak">Ditolak</option>
                </select>
              </div>
              <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Akta Kelahiran</label>
                <input type="file" name="foto_akta" accept="image/*,application/pdf" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 cursor-pointer mb-2">
                <span id="m_akta_helper" class="text-xs text-emerald-600 font-medium block"></span>
              </div>
              <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Kartu Keluarga [KK]</label>
                <input type="file" name="foto_kk" accept="image/*,application/pdf" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 cursor-pointer mb-2">
                <span id="m_kk_helper" class="text-xs text-emerald-600 font-medium block"></span>
              </div>
            </div>
          </div>
        </form>
      </div>
      
    </div>
    
    {{-- Modal Footer --}}
    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex items-center justify-end gap-3 flex-shrink-0">
      <button type="button" id="modal-cancel-btn" onclick="closePendaftaranModal()" class="px-5 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold rounded-xl text-sm transition">Tutup</button>
      <button type="button" id="modal-save-btn" class="px-5 py-2.5 bg-primary hover:bg-secondary text-white font-semibold rounded-xl text-sm transition shadow-lg shadow-primary/20 flex items-center gap-2 hidden">
        <i class="fas fa-save"></i> Simpan Perubahan
      </button>
    </div>
    
  </div>
</div>

@endsection

@push('scripts')
<script>
  let stream = null;
  let capturedBlob = null;

  function showAlert(msg, type = 'success') {
    const el = document.getElementById('webcam-alert');
    el.className = 'mb-4 p-3 rounded-xl text-sm ' +
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
      video.style.display = 'block';
      document.getElementById('foto-preview').style.display = 'none';
      document.getElementById('btn-start-cam').style.display = 'none';
      document.getElementById('btn-capture').style.display = 'block';
      document.getElementById('save-section').style.display = 'none';
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
    preview.style.display = 'block';
    video.style.display = 'none';

    capturedBlob = dataUrl;

    document.getElementById('btn-capture').style.display = 'none';
    document.getElementById('btn-retake').style.display = 'block';
    document.getElementById('save-section').style.display = 'block';

    // Stop stream
    if (stream) stream.getTracks().forEach(t => t.stop());
  }

  function retakePhoto() {
    document.getElementById('foto-preview').style.display = 'none';
    document.getElementById('webcam-feed').style.display = 'block';
    document.getElementById('btn-retake').style.display = 'none';
    document.getElementById('btn-capture').style.display = 'block';
    document.getElementById('save-section').style.display = 'none';
    capturedBlob = null;
    startCamera();
  }

  async function savePhoto() {
    if (!capturedBlob) return;

    const btn = document.getElementById('btn-save');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Menyimpan...';

    try {
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

  let currentPendaftaranId = null;
  let modalMode = 'detail'; // 'detail' or 'edit'
  let originalData = null; // store current fetched data
  let originalGelombangs = []; // store current fetched gelombangs

  function openPendaftaranModal(id, mode = 'detail') {
    currentPendaftaranId = id;
    modalMode = mode;
    
    const modal = document.getElementById('pendaftaran-modal');
    const modalContent = document.getElementById('modal-content');
    
    // Reset UI states
    document.getElementById('modal-loading-state').classList.remove('hidden');
    document.getElementById('modal-detail-view').classList.add('hidden');
    document.getElementById('modal-edit-view').classList.add('hidden');
    document.getElementById('modal-save-btn').classList.add('hidden');
    document.getElementById('modal-cancel-btn').textContent = 'Tutup';
    
    // Open modal container
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    setTimeout(() => {
      modalContent.classList.remove('scale-95', 'opacity-0');
      modalContent.classList.add('scale-100', 'opacity-100');
    }, 10);
    
    // Fetch details
    fetch(`/petugas/pendaftaran/${id}`, {
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json'
      }
    })
    .then(res => res.json())
    .then(res => {
      if (res.success) {
        originalData = res.data;
        originalGelombangs = res.gelombangs;
        
        // Populate Detail View
        populateDetailView(res.data);
        
        // Populate Edit View
        populateEditView(res.data, res.gelombangs);
        
        // Toggle to correct mode
        setModalMode(modalMode);
      } else {
        alert('Gagal mengambil data pendaftar.');
        closePendaftaranModal();
      }
    })
    .catch(err => {
      console.error(err);
      alert('Terjadi kesalahan koneksi.');
      closePendaftaranModal();
    });
  }

  function populateDetailView(data) {
    document.getElementById('modal-subtitle').textContent = `No. Daftar: ${data.no_daftar} • Tahun: ${data.tahun_aktif}`;
    
    // Foto Siswa
    const fotoImg = document.getElementById('detail-foto-siswa');
    const fotoPl = document.getElementById('detail-foto-placeholder');
    if (data.foto_siswa) {
      fotoImg.src = `/storage/${data.foto_siswa}`;
      fotoImg.classList.remove('hidden');
      fotoPl.classList.add('hidden');
    } else {
      fotoImg.src = '';
      fotoImg.classList.add('hidden');
      fotoPl.classList.remove('hidden');
    }
    
    // Status Badge
    const statusBadge = document.getElementById('detail-status-badge');
    statusBadge.className = 'inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold capitalize ';
    if (data.status === 'pending') {
      statusBadge.classList.add('bg-yellow-100', 'text-yellow-700');
    } else if (data.status === 'verifikasi') {
      statusBadge.classList.add('bg-blue-100', 'text-blue-700');
    } else if (data.status === 'diterima') {
      statusBadge.classList.add('bg-green-100', 'text-green-700');
    } else if (data.status === 'ditolak') {
      statusBadge.classList.add('bg-red-100', 'text-red-700');
    }
    statusBadge.textContent = data.status;
    
    // Cetak Link
    document.getElementById('detail-link-cetak').href = `/petugas/pendaftaran/${data.id}/kartu`;
    
    // Data Diri
    document.getElementById('d-nama').textContent = data.nama_lengkap || '-';
    
    // TTL
    const options = { day: 'numeric', month: 'short', year: 'numeric' };
    const birthDate = data.tanggal_lahir ? new Date(data.tanggal_lahir).toLocaleDateString('id-ID', options) : '-';
    document.getElementById('d-ttl').textContent = `${data.tempat_lahir || ''}, ${birthDate}`;
    
    document.getElementById('d-jk').textContent = data.jenis_kelamin === 'L' ? 'Laki-Laki' : (data.jenis_kelamin === 'P' ? 'Perempuan' : '-');
    document.getElementById('d-agama').textContent = data.agama || '-';
    document.getElementById('d-hp-siswa').textContent = data.no_hp_siswa || '-';
    document.getElementById('d-asal-sekolah').textContent = data.asal_sekolah || '-';
    document.getElementById('d-alamat-sekolah').textContent = data.alamat_sekolah || '-';
    document.getElementById('d-prestasi').textContent = data.prestasi || '-';
    
    // Ortu
    document.getElementById('d-nama-ortu').textContent = data.nama_ortu || '-';
    document.getElementById('d-pekerjaan-ortu').textContent = data.pekerjaan_ortu || '-';
    document.getElementById('d-hp-ortu').textContent = data.no_hp_ortu || '-';
    
    // Alamat
    const formatAddress = (jalan, dusun, rt, rw, desa, kec, kab, prov) => {
      let parts = [];
      if (jalan) parts.push(jalan);
      if (dusun) parts.push('Dsn. ' + dusun);
      if (rt) {
        let rtrw = 'RT ' + rt;
        if (rw) rtrw += ' / RW ' + rw;
        parts.push(rtrw);
      }
      if (desa) parts.push('Kel. ' + desa);
      if (kec) parts.push('Kec. ' + kec);
      if (kab) parts.push('Kab. ' + kab);
      if (prov) parts.push('Prov. ' + prov);
      return parts.join(', ') || '-';
    };
    
    document.getElementById('d-alamat-asal').textContent = formatAddress(
      data.jalan_asal, data.dusun_asal, data.rt_asal, data.rw_asal, data.desa_asal, data.kecamatan_asal, data.kabupaten_asal, data.provinsi_asal
    );
    document.getElementById('d-alamat-tinggal').textContent = formatAddress(
      data.jalan_tinggal, data.dusun_tinggal, data.rt_tinggal, data.rw_tinggal, data.desa_tinggal, data.kecamatan_tinggal, data.kabupaten_tinggal, data.provinsi_tinggal
    );
    
    // Jurusan
    const jurusansMap = {
      'TKR': 'Teknik Kendaraan Ringan (Otomotif)',
      'TPM': 'Teknik Permesinan',
      'TAV': 'Teknik Audio Video (Elektronika)',
      'TBSM': 'Teknik Bisnis Sepeda Motor',
      'RPL': 'Rekayasa Perangkat Lunak (Komputer)'
    };
    document.getElementById('d-pil1').textContent = jurusansMap[data.pil1] || data.pil1 || '-';
    document.getElementById('d-pil2').textContent = jurusansMap[data.pil2] || data.pil2 || '-';
    document.getElementById('d-pil3').textContent = jurusansMap[data.pil3] || data.pil3 || '-';
    
    // Berkas Status & Link
    const setBerkasLink = (linkId, statusId, path) => {
      const link = document.getElementById(linkId);
      const status = document.getElementById(statusId);
      if (path) {
        link.href = `/storage/${path}`;
        link.classList.remove('hidden');
        status.className = 'text-xxs text-emerald-600 font-semibold mt-0.5';
        status.innerHTML = '<i class="fas fa-check-circle"></i> Berkas Terlampir';
      } else {
        link.href = '#';
        link.classList.add('hidden');
        status.className = 'text-xxs text-slate-400 font-semibold mt-0.5';
        status.textContent = 'Belum diupload';
      }
    };
    setBerkasLink('d-akta-link', 'd-akta-status', data.foto_akta);
    setBerkasLink('d-kk-link', 'd-kk-status', data.foto_kk);
  }

  function populateEditView(data, gelombangs) {
    const form = document.getElementById('modal-edit-form');
    clearErrors();
    
    form.nama_lengkap.value = data.nama_lengkap || '';
    form.tempat_lahir.value = data.tempat_lahir || '';
    
    // Tanggal Lahir
    if (data.tanggal_lahir) {
      const dateParts = data.tanggal_lahir.split('-');
      if (dateParts.length === 3) {
        form.tgl.value = parseInt(dateParts[2]);
        form.bulan.value = dateParts[1];
        form.tahun.value = dateParts[0];
      }
    } else {
      form.tgl.value = '';
      form.bulan.value = '';
      form.tahun.value = '';
    }
    
    form.jenkel.value = data.jenis_kelamin || '';
    form.agama.value = data.agama || 'islam';
    form.no_hp_siswa.value = data.no_hp_siswa || '';
    form.asal_sekolah.value = data.asal_sekolah || '';
    form.alamat_sekolah.value = data.alamat_sekolah || '';
    form.prestasi.value = data.prestasi || '';
    
    form.nama_ortu.value = data.nama_ortu || '';
    form.pekerjaan_ortu.value = data.pekerjaan_ortu || '';
    form.no_hp_ortu.value = data.no_hp_ortu || '';
    
    // Alamat
    form.jalan_asal.value = data.jalan_asal || '';
    form.dusun_asal.value = data.dusun_asal || '';
    form.rt_asal.value = data.rt_asal || '';
    form.rw_asal.value = data.rw_asal || '';
    form.desa_asal.value = data.desa_asal || '';
    form.kecamatan_asal.value = data.kecamatan_asal || '';
    form.kabupaten_asal.value = data.kabupaten_asal || '';
    form.provinsi_asal.value = data.provinsi_asal || '';
    
    // Check if alamat tinggal is identical to asal
    const isIdentical = (
      data.jalan_asal === data.jalan_tinggal &&
      data.dusun_asal === data.dusun_tinggal &&
      data.rt_asal === data.rt_tinggal &&
      data.rw_asal === data.rw_tinggal &&
      data.desa_asal === data.desa_tinggal &&
      data.kecamatan_asal === data.kecamatan_tinggal &&
      data.kabupaten_asal === data.kabupaten_tinggal &&
      data.provinsi_asal === data.provinsi_tinggal
    );
    
    document.getElementById('m_copy_address').checked = isIdentical;
    
    form.jalan_tinggal.value = data.jalan_tinggal || '';
    form.dusun_tinggal.value = data.dusun_tinggal || '';
    form.rt_tinggal.value = data.rt_tinggal || '';
    form.rw_tinggal.value = data.rw_tinggal || '';
    form.desa_tinggal.value = data.desa_tinggal || '';
    form.kecamatan_tinggal.value = data.kecamatan_tinggal || '';
    form.kabupaten_tinggal.value = data.kabupaten_tinggal || '';
    form.provinsi_tinggal.value = data.provinsi_tinggal || '';
    
    if (isIdentical) {
      const fields = ['jalan', 'dusun', 'rt', 'rw', 'desa', 'kecamatan', 'kabupaten', 'provinsi'];
      fields.forEach(f => {
        const el = document.getElementById('m_' + f + '_tinggal');
        if (el) {
          el.setAttribute('readonly', 'readonly');
          el.classList.add('bg-slate-50', 'cursor-not-allowed');
        }
      });
    } else {
      const fields = ['jalan', 'dusun', 'rt', 'rw', 'desa', 'kecamatan', 'kabupaten', 'provinsi'];
      fields.forEach(f => {
        const el = document.getElementById('m_' + f + '_tinggal');
        if (el) {
          el.removeAttribute('readonly');
          el.classList.remove('bg-slate-50', 'cursor-not-allowed');
        }
      });
    }
    
    // Jurusan
    form.pil1.value = data.pil1 || '';
    form.pil2.value = data.pil2 || '';
    form.pil3.value = data.pil3 || '';
    m_validateJurusan();
    
    // Gelombang
    const gelSelect = document.getElementById('m_gelombang_id');
    gelSelect.innerHTML = '';
    gelombangs.forEach(g => {
      const opt = document.createElement('option');
      opt.value = g.id;
      opt.textContent = `${g.nama_gelombang} (${g.tahun_ajaran})${g.is_aktif ? ' — Aktif' : ''}`;
      if (data.gelombang === g.nama_gelombang) {
        opt.selected = true;
      } else if (!data.gelombang && g.is_aktif) {
        opt.selected = true;
      }
      gelSelect.appendChild(opt);
    });
    
    // Status
    form.status.value = data.status || 'pending';
    
    // Clear file input values
    form.foto_akta.value = '';
    form.foto_kk.value = '';
    
    // Show file upload helpers
    const aktaHelper = document.getElementById('m_akta_helper');
    const kkHelper = document.getElementById('m_kk_helper');
    if (data.foto_akta) {
      aktaHelper.innerHTML = `<i class="fas fa-check"></i> File Akta Terupload: <a href="/storage/${data.foto_akta}" target="_blank" class="text-primary hover:underline font-bold">Lihat File</a>`;
    } else {
      aktaHelper.textContent = '';
    }
    if (data.foto_kk) {
      kkHelper.innerHTML = `<i class="fas fa-check"></i> File KK Terupload: <a href="/storage/${data.foto_kk}" target="_blank" class="text-primary hover:underline font-bold">Lihat File</a>`;
    } else {
      kkHelper.textContent = '';
    }
  }

  function setModalMode(mode) {
    modalMode = mode;
    document.getElementById('modal-loading-state').classList.add('hidden');
    
    const detailView = document.getElementById('modal-detail-view');
    const editView = document.getElementById('modal-edit-view');
    const toggleBtn = document.getElementById('modal-mode-toggle');
    const toggleText = document.getElementById('modal-mode-text');
    const toggleIcon = toggleBtn.querySelector('i');
    
    const saveBtn = document.getElementById('modal-save-btn');
    const cancelBtn = document.getElementById('modal-cancel-btn');
    const title = document.getElementById('modal-title');
    const titleIcon = document.getElementById('modal-title-icon');
    
    if (mode === 'detail') {
      detailView.classList.remove('hidden');
      editView.classList.add('hidden');
      saveBtn.classList.add('hidden');
      cancelBtn.textContent = 'Tutup';
      
      title.textContent = 'Detail Calon Siswa';
      titleIcon.className = 'fas fa-eye text-lg';
      
      toggleText.textContent = 'Ubah Data';
      toggleIcon.className = 'fas fa-edit';
      toggleBtn.classList.remove('bg-slate-100', 'text-slate-700', 'hover:bg-slate-200');
      toggleBtn.classList.add('bg-primary/10', 'text-primary', 'hover:bg-primary/20');
    } else {
      detailView.classList.add('hidden');
      editView.classList.remove('hidden');
      saveBtn.classList.remove('hidden');
      cancelBtn.textContent = 'Batal';
      
      title.textContent = 'Ubah Data Pendaftar';
      titleIcon.className = 'fas fa-edit text-lg';
      
      toggleText.textContent = 'Detail Siswa';
      toggleIcon.className = 'fas fa-eye';
      toggleBtn.classList.remove('bg-primary/10', 'text-primary', 'hover:bg-primary/20');
      toggleBtn.classList.add('bg-slate-100', 'text-slate-700', 'hover:bg-slate-200');
    }
  }

  function closePendaftaranModal() {
    const modal = document.getElementById('pendaftaran-modal');
    const modalContent = document.getElementById('modal-content');
    
    modalContent.classList.remove('scale-100', 'opacity-100');
    modalContent.classList.add('scale-95', 'opacity-0');
    
    setTimeout(() => {
      modal.classList.add('hidden');
      modal.classList.remove('flex');
      currentPendaftaranId = null;
    }, 150);
  }

  function clearErrors() {
    document.querySelectorAll('#modal-edit-form .error-msg').forEach(el => {
      el.textContent = '';
      el.classList.add('hidden');
    });
    document.querySelectorAll('#modal-edit-form input, #modal-edit-form select, #modal-edit-form textarea').forEach(el => {
      el.classList.remove('border-red-400');
    });
  }

  function m_copyAddressFields() {
    const isChecked = document.getElementById('m_copy_address').checked;
    const fields = ['jalan', 'dusun', 'rt', 'rw', 'desa', 'kecamatan', 'kabupaten', 'provinsi'];
    
    fields.forEach(field => {
      const sourceInput = document.getElementById('m_' + field + '_asal');
      const targetInput = document.getElementById('m_' + field + '_tinggal');
      if (sourceInput && targetInput) {
        if (isChecked) {
          targetInput.value = sourceInput.value;
          targetInput.setAttribute('readonly', 'readonly');
          targetInput.classList.add('bg-slate-50', 'cursor-not-allowed');
        } else {
          targetInput.removeAttribute('readonly');
          targetInput.classList.remove('bg-slate-50', 'cursor-not-allowed');
        }
      }
    });
  }

  function m_validateJurusan() {
    const pil1 = document.getElementById('m_pil1');
    const pil2 = document.getElementById('m_pil2');
    const pil3 = document.getElementById('m_pil3');
    if (!pil1 || !pil2 || !pil3) return;

    const pil1Val = pil1.value;
    const pil2Val = pil2.value;
    const pil3Val = pil3.value;

    function setSelectEnabled(select, enabled) {
      const disabledClass = ['bg-slate-100', 'text-slate-400', 'cursor-not-allowed'];
      const enabledClass  = ['bg-white', 'text-slate-800'];
      if (enabled) {
        select.disabled = false;
        select.classList.remove(...disabledClass);
        select.classList.add(...enabledClass);
      } else {
        select.disabled = true;
        select.value = '';
        select.classList.remove(...enabledClass);
        select.classList.add(...disabledClass);
      }
    }

    // Sequential enable/disable
    setSelectEnabled(pil2, pil1Val !== '');
    setSelectEnabled(pil3, pil1Val !== '' && pil2Val !== '');

    // Cascade reset
    if (pil1Val === '') { pil2.value = ''; pil3.value = ''; }
    if (pil2.value === '') { pil3.value = ''; }

    // Hide duplicate options
    const selects = [pil1, pil2, pil3];
    selects.forEach((select, index) => {
      const otherVals = selects
        .filter((_, idx) => idx !== index)
        .map(s => s.value)
        .filter(v => v !== '');

      Array.from(select.options).forEach(option => {
        if (option.value === '') return;
        if (otherVals.includes(option.value)) {
          option.disabled = true;
          option.classList.add('hidden');
        } else {
          option.disabled = false;
          option.classList.remove('hidden');
        }
      });
    });
    
    // Show error if there's duplicate
    const errorMsg = document.getElementById('m_jurusan-error');
    if ((pil1Val && pil2Val && pil1Val === pil2Val) || (pil1Val && pil3Val && pil1Val === pil3Val) || (pil2Val && pil3Val && pil2Val === pil3Val)) {
      errorMsg.classList.remove('hidden');
    } else {
      errorMsg.classList.add('hidden');
    }
  }

  // Bind events on DOM ready
  document.addEventListener('DOMContentLoaded', () => {
    // Detail button on show page click handler
    const btnDetail = document.getElementById('btn-show-detail');
    if (btnDetail) {
      btnDetail.addEventListener('click', (e) => {
        e.preventDefault();
        const id = btnDetail.getAttribute('data-id');
        openPendaftaranModal(id, 'detail');
      });
    }
    
    // Modal toggle mode click handler
    document.getElementById('modal-mode-toggle').addEventListener('click', () => {
      if (modalMode === 'detail') {
        setModalMode('edit');
      } else {
        populateEditView(originalData, originalGelombangs);
        setModalMode('detail');
      }
    });
    
    // Copy address sync checkboxes
    const copyCheck = document.getElementById('m_copy_address');
    if (copyCheck) {
      copyCheck.addEventListener('change', m_copyAddressFields);
    }
    
    const fields = ['jalan', 'dusun', 'rt', 'rw', 'desa', 'kecamatan', 'kabupaten', 'provinsi'];
    fields.forEach(field => {
      const sourceInput = document.getElementById('m_' + field + '_asal');
      if (sourceInput) {
        sourceInput.addEventListener('input', () => {
          if (document.getElementById('m_copy_address').checked) {
            const targetInput = document.getElementById('m_' + field + '_tinggal');
            if (targetInput) targetInput.value = sourceInput.value;
          }
        });
      }
    });
    
    // Validate jurusan choices inside modal
    ['m_pil1', 'm_pil2', 'm_pil3'].forEach(id => {
      const el = document.getElementById(id);
      if (el) {
        el.addEventListener('change', m_validateJurusan);
      }
    });
    
    // Modal save button AJAX submission
    document.getElementById('modal-save-btn').addEventListener('click', () => {
      const form = document.getElementById('modal-edit-form');
      const saveBtn = document.getElementById('modal-save-btn');
      
      const originalSaveHtml = saveBtn.innerHTML;
      saveBtn.disabled = true;
      saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Menyimpan...';
      
      clearErrors();
      
      const formData = new FormData(form);
      
      fetch(`/petugas/pendaftaran/${currentPendaftaranId}`, {
        method: 'POST', // POST with _method=PUT is required for file uploads in PHP/Laravel via AJAX FormData
        body: formData,
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Accept': 'application/json'
        }
      })
      .then(async res => {
        saveBtn.disabled = false;
        saveBtn.innerHTML = originalSaveHtml;
        
        if (res.ok) {
          const result = await res.json();
          alert(result.message || 'Data berhasil disimpan.');
          // Reload the page to synchronize all fields in show page (webcam, checklist status, left data card, etc.)
          location.reload();
        } else if (res.status === 422) {
          const errs = await res.json();
          
          Object.keys(errs.errors).forEach(field => {
            let input = form.querySelector(`[name="${field}"]`);
            if (!input && (field === 'tgl' || field === 'bulan' || field === 'tahun')) {
              input = form.querySelector('[name="tgl"]');
            }
            if (input) {
              input.classList.add('border-red-400');
              const errorSpan = input.closest('div').querySelector('.error-msg');
              if (errorSpan) {
                errorSpan.textContent = errs.errors[field][0];
                errorSpan.classList.remove('hidden');
              }
            }
          });
          
          const firstError = form.querySelector('.border-red-400');
          if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
          }
        } else {
          const text = await res.text();
          console.error(text);
          alert('Gagal memperbarui data. Silakan periksa format file atau log server.');
        }
      })
      .catch(err => {
        console.error(err);
        saveBtn.disabled = false;
        saveBtn.innerHTML = originalSaveHtml;
        alert('Terjadi kesalahan koneksi.');
      });
    });
  });
</script>
@endpush
