@extends('layouts.admin')
@section('title', 'Download Data Pendaftaran')
@section('subtitle', 'Pilih data yang ingin diunduh, pratinjau tabel, lalu download Excel')

@section('content')
<style>
/* ========== BASE ========== */
.dl-wrap { display:flex; gap:24px; align-items:flex-start; }
.dl-sidebar { width:320px; flex-shrink:0; display:flex; flex-direction:column; gap:16px; }
.dl-main    { flex:1; min-width:0; display:flex; flex-direction:column; gap:16px; }

.card {
  background:#0f172a;
  border:1px solid rgba(255,255,255,0.06);
  border-radius:16px;
  padding:22px 24px;
}

.card-title {
  color:#f1f5f9; font-size:14px; font-weight:700;
  display:flex; align-items:center; gap:8px; margin:0 0 16px;
}
.card-title i { color:#f97316; font-size:12px; }

/* ========== FILTER ========== */
.filter-grid { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
.fl-label {
  display:block; color:#64748b; font-size:11px; font-weight:600;
  text-transform:uppercase; letter-spacing:.05em; margin-bottom:6px;
}
.fl-select {
  width:100%; background:#1e293b; border:1px solid rgba(255,255,255,0.08);
  border-radius:8px; padding:9px 12px; color:#e2e8f0; font-size:13px;
  outline:none; transition:border-color .2s;
}
.fl-select:focus { border-color:#f97316; }

/* ========== GROUP CHECKLIST ========== */
.group-grid { display:flex; flex-direction:column; gap:8px; }

.group-item {
  display:flex; align-items:center; gap:10px;
  background:#1e293b; border:1.5px solid rgba(255,255,255,0.06);
  border-radius:10px; padding:10px 12px; cursor:pointer;
  transition:all .2s; user-select:none;
}
.group-item:hover { border-color:rgba(249,115,22,0.3); background:#263146; }
.group-item.checked { border-color:rgba(249,115,22,0.5); background:rgba(249,115,22,0.07); }

.group-check {
  width:18px; height:18px; border-radius:5px;
  border:2px solid rgba(255,255,255,0.2);
  display:flex; align-items:center; justify-content:center;
  flex-shrink:0; transition:all .2s;
  background:transparent;
}
.group-item.checked .group-check {
  background:#f97316; border-color:#f97316;
}
.group-check i { color:#fff; font-size:9px; display:none; }
.group-item.checked .group-check i { display:block; }

.group-icon {
  width:30px; height:30px; border-radius:7px;
  display:flex; align-items:center; justify-content:center;
  flex-shrink:0;
}
.group-info { flex:1; min-width:0; }
.group-name { color:#e2e8f0; font-size:13px; font-weight:600; }
.group-count { color:#64748b; font-size:11px; margin-top:1px; }

/* Toggle all */
.toggle-all {
  display:flex; align-items:center; justify-content:space-between;
  margin-bottom:10px;
}
.toggle-all span { color:#94a3b8; font-size:12px; }
.toggle-btn {
  background:none; border:1px solid rgba(249,115,22,0.3);
  color:#f97316; font-size:11px; font-weight:600;
  border-radius:6px; padding:4px 10px; cursor:pointer;
  transition:all .15s;
}
.toggle-btn:hover { background:rgba(249,115,22,0.1); }

/* ========== STATS ========== */
.stat-row { display:flex; gap:10px; }
.stat-box {
  flex:1; background:#1e293b; border-radius:10px;
  padding:12px 14px; text-align:center; border:1px solid rgba(255,255,255,0.05);
}
.stat-num { color:#f1f5f9; font-size:20px; font-weight:800; }
.stat-lbl { color:#64748b; font-size:10px; text-transform:uppercase; letter-spacing:.05em; margin-top:2px; }

/* ========== COL COUNT BADGE ========== */
.col-badge {
  background:rgba(249,115,22,0.1); border:1px solid rgba(249,115,22,0.2);
  color:#f97316; font-size:11px; font-weight:700;
  border-radius:20px; padding:2px 8px;
}

/* ========== PREVIEW TABLE ========== */
.preview-wrap {
  overflow:auto;
  border-radius:10px;
  border:1px solid rgba(255,255,255,0.07);
  max-height:420px;
}
.preview-table {
  width:100%; border-collapse:collapse;
  font-size:12px; white-space:nowrap;
}
.preview-table thead th {
  background:#1e293b; color:#94a3b8; font-size:10px;
  font-weight:700; text-transform:uppercase; letter-spacing:.05em;
  padding:9px 12px; border-bottom:1px solid rgba(255,255,255,0.07);
  position:sticky; top:0; z-index:2;
}
.preview-table thead th:first-child {
  position:sticky; left:0; z-index:3; background:#1e293b;
}
.preview-table tbody td {
  padding:8px 12px; border-bottom:1px solid rgba(255,255,255,0.04);
  color:#cbd5e1; vertical-align:top; max-width:160px;
  overflow:hidden; text-overflow:ellipsis;
}
.preview-table tbody tr:hover td { background:rgba(249,115,22,0.04); }
.preview-table tbody td:first-child {
  position:sticky; left:0; background:#0f172a; z-index:1;
  font-weight:700; color:#f97316;
}
.preview-table tbody tr:hover td:first-child { background:#111c2e; }

.group-sep-th {
  background:rgba(249,115,22,0.08) !important;
  color:#f97316 !important; font-size:10px !important;
  text-transform:uppercase !important; padding:6px 12px !important;
  letter-spacing:.05em; border-top:1px solid rgba(249,115,22,0.15) !important;
}

/* Empty preview */
.preview-empty {
  text-align:center; padding:48px 24px; color:#475569;
}
.preview-empty i { font-size:32px; margin-bottom:12px; display:block; }

/* ========== DOWNLOAD BTN ========== */
.dl-btn {
  display:inline-flex; align-items:center; gap:10px;
  background:linear-gradient(135deg,#16a34a,#22c55e);
  color:#fff; border:none; border-radius:10px;
  padding:13px 32px; font-size:14px; font-weight:700;
  cursor:pointer; transition:all .2s;
  box-shadow:0 4px 16px rgba(34,197,94,.3);
  width:100%; justify-content:center;
}
.dl-btn:hover { transform:translateY(-1px); box-shadow:0 6px 24px rgba(34,197,94,.4); }
.dl-btn:disabled { opacity:.5; cursor:not-allowed; transform:none; }

.preview-btn {
  display:inline-flex; align-items:center; gap:8px;
  background:#1e293b; border:1px solid rgba(255,255,255,0.1);
  color:#94a3b8; border-radius:8px; padding:8px 18px;
  font-size:13px; font-weight:600; cursor:pointer;
  transition:all .2s; width:100%; justify-content:center;
}
.preview-btn:hover { border-color:#f97316; color:#f97316; }

/* ========== RESPONSIVE ========== */
@media(max-width:900px){
  .dl-wrap { flex-direction:column; }
  .dl-sidebar { width:100%; }
  .filter-grid { grid-template-columns:1fr; }
}
</style>

<form id="dlForm" method="GET" action="{{ route('admin.download.pendaftaran.excel') }}">

<div class="dl-wrap">

  {{-- ===== LEFT SIDEBAR ===== --}}
  <div class="dl-sidebar">

    {{-- Filter --}}
    <div class="card">
      <p class="card-title"><i class="fas fa-filter"></i> Filter Data</p>
      <div class="filter-grid">
        <div>
          <label class="fl-label">Gelombang</label>
          <select name="gelombang" class="fl-select" id="selGelombang">
            <option value="">Semua Gelombang</option>
            @foreach($gelombangs as $g)
              <option value="{{ $g->nama_gelombang }}" {{ request('gelombang') === $g->nama_gelombang ? 'selected' : '' }}>
                {{ $g->nama_gelombang }}
              </option>
            @endforeach
          </select>
        </div>
        <div>
          <label class="fl-label">Status</label>
          <select name="status" class="fl-select" id="selStatus">
            <option value="">Semua Status</option>
            <option value="pending"     {{ request('status') === 'pending'     ? 'selected' : '' }}>Pending</option>
            <option value="verifikasi"  {{ request('status') === 'verifikasi'  ? 'selected' : '' }}>Verifikasi</option>
            <option value="diterima"    {{ request('status') === 'diterima'    ? 'selected' : '' }}>Diterima</option>
            <option value="ditolak"     {{ request('status') === 'ditolak'     ? 'selected' : '' }}>Ditolak</option>
          </select>
        </div>
      </div>
      <button type="button" id="btnApplyFilter" class="preview-btn" style="margin-top:12px;">
        <i class="fas fa-sync-alt"></i> Terapkan Filter & Pratinjau
      </button>
    </div>

    {{-- Stats --}}
    <div class="card" style="padding:16px 20px;">
      <div class="stat-row">
        <div class="stat-box">
          <div class="stat-num">{{ $totalPendaftar }}</div>
          <div class="stat-lbl">Total</div>
        </div>
        <div class="stat-box" id="statFiltered">
          <div class="stat-num" id="statFilteredNum">{{ $totalFiltered }}</div>
          <div class="stat-lbl">Terfilter</div>
        </div>
        <div class="stat-box">
          <div class="stat-num" id="statColNum">0</div>
          <div class="stat-lbl">Kolom</div>
        </div>
      </div>
    </div>

    {{-- Column group checklist --}}
    <div class="card">
      <p class="card-title" style="margin-bottom:8px;"><i class="fas fa-check-square"></i> Pilih Grup Kolom</p>
      <div class="toggle-all">
        <span id="selectedInfo">Semua terpilih</span>
        <button type="button" class="toggle-btn" id="btnToggleAll">Batal Semua</button>
      </div>
      <div class="group-grid" id="groupGrid">
        @php
          $groupMeta = [
            'pendaftaran' => ['icon'=>'fas fa-id-card',       'color'=>'#f97316', 'count'=>5],
            'pribadi'     => ['icon'=>'fas fa-user',          'color'=>'#3b82f6', 'count'=>6],
            'sekolah'     => ['icon'=>'fas fa-school',        'color'=>'#8b5cf6', 'count'=>3],
            'ortu'        => ['icon'=>'fas fa-users',         'color'=>'#ec4899', 'count'=>3],
            'alamat'      => ['icon'=>'fas fa-map-marker-alt','color'=>'#14b8a6', 'count'=>14],
            'jurusan'     => ['icon'=>'fas fa-graduation-cap','color'=>'#f59e0b', 'count'=>5],
            'kesehatan'   => ['icon'=>'fas fa-heartbeat',     'color'=>'#ef4444', 'count'=>10],
            'gaya_belajar'=> ['icon'=>'fas fa-brain',         'color'=>'#a855f7', 'count'=>5],
            'wawancara'   => ['icon'=>'fas fa-comments',      'color'=>'#06b6d4', 'count'=>6],
            'biaya'       => ['icon'=>'fas fa-money-bill-wave','color'=>'#22c55e','count'=>6],
            'pembayaran'  => ['icon'=>'fas fa-credit-card',   'color'=>'#f43f5e', 'count'=>6],
          ];
          $groupLabels = [
            'pendaftaran'=>'Data Pendaftaran','pribadi'=>'Data Pribadi','sekolah'=>'Asal Sekolah',
            'ortu'=>'Orang Tua','alamat'=>'Alamat','jurusan'=>'Pilihan Jurusan',
            'kesehatan'=>'Kesehatan','gaya_belajar'=>'Gaya Belajar','wawancara'=>'Wawancara',
            'biaya'=>'Biaya','pembayaran'=>'Pembayaran',
          ];
        @endphp

        @foreach($groupLabels as $gid => $glabel)
          @php $meta = $groupMeta[$gid]; $isChecked = in_array($gid, $selectedGroups); @endphp
          <label class="group-item {{ $isChecked ? 'checked' : '' }}"
                 data-group="{{ $gid }}" data-count="{{ $meta['count'] }}">
            <input type="checkbox" name="groups[]" value="{{ $gid }}"
                   {{ $isChecked ? 'checked' : '' }}
                   style="position:absolute;opacity:0;width:0;height:0;">
            <div class="group-check"><i class="fas fa-check"></i></div>
            <div class="group-icon" style="background:{{ $meta['color'] }}18;">
              <i class="{{ $meta['icon'] }}" style="color:{{ $meta['color'] }}; font-size:13px;"></i>
            </div>
            <div class="group-info">
              <div class="group-name">{{ $glabel }}</div>
              <div class="group-count">{{ $meta['count'] }} kolom</div>
            </div>
          </label>
        @endforeach
      </div>
    </div>

    {{-- Download Button --}}
    <button type="submit" class="dl-btn" id="btnDownload">
      <i class="fas fa-file-excel"></i>
      Download Excel
    </button>

  </div>{{-- /sidebar --}}

  {{-- ===== RIGHT MAIN AREA ===== --}}
  <div class="dl-main">

    {{-- Preview Header --}}
    <div class="card" style="padding:16px 20px;">
      <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px;">
        <div>
          <p class="card-title" style="margin:0;">
            <i class="fas fa-table"></i> Pratinjau Data
            <span class="col-badge" id="colBadge">+1 kolom No</span>
          </p>
          <p style="color:#64748b; font-size:12px; margin:4px 0 0;">
            Menampilkan <strong style="color:#94a3b8;" id="previewCount">{{ $previewRows->count() }}</strong>
            dari <strong style="color:#94a3b8;" id="totalCount">{{ $totalFiltered }}</strong> data.
            Kolom <em>No</em> selalu disertakan.
          </p>
        </div>
        <div style="display:flex; align-items:center; gap:8px;">
          <span style="color:#64748b; font-size:12px;"><i class="fas fa-arrows-alt-h" style="margin-right:4px;"></i>Geser untuk melihat semua kolom</span>
        </div>
      </div>
    </div>

    {{-- Preview Table --}}
    <div class="card" style="padding:0; overflow:hidden;">
      <div class="preview-wrap" id="previewWrap">
        @if($previewRows->isEmpty())
          <div class="preview-empty">
            <i class="fas fa-inbox"></i>
            Tidak ada data yang cocok dengan filter.
          </div>
        @else
          <table class="preview-table" id="previewTable">
            <thead id="previewHead">
              <tr>
                <th>No</th>
                @foreach($groups as $gid => $group)
                  @if(in_array($gid, $selectedGroups))
                    @foreach(array_keys($group['cols']) as $colName)
                      <th>{{ $colName }}</th>
                    @endforeach
                  @endif
                @endforeach
              </tr>
            </thead>
            <tbody id="previewBody">
              @foreach($previewRows as $i => $p)
                @php
                  $jk = $p->jenis_kelamin === 'L' ? 'Laki-laki' : ($p->jenis_kelamin === 'P' ? 'Perempuan' : ($p->jenis_kelamin ?? ''));
                  $pewawancara = $p->petugasWawancara ? $p->petugasWawancara->nama : ($p->wawancara_petugas ?? '');
                  // Pre-compute all cell values as a flat map
                  $allCells = [
                    'pendaftaran' => [
                      $p->no_daftar ?? '', $p->gelombang ?? '', $p->tahun_aktif ?? '',
                      ucfirst($p->status ?? ''),
                      $p->created_at ? $p->created_at->format('d/m/Y H:i') : '',
                    ],
                    'pribadi' => [
                      $p->nama_lengkap ?? '', $p->tempat_lahir ?? '',
                      $p->tanggal_lahir ? $p->tanggal_lahir->format('d/m/Y') : '',
                      $jk, $p->agama ?? '', $p->no_hp_siswa ?? '',
                    ],
                    'sekolah' => [ $p->asal_sekolah ?? '', $p->alamat_sekolah ?? '', $p->prestasi ?? '' ],
                    'ortu'    => [ $p->nama_ortu ?? '', $p->pekerjaan_ortu ?? '', $p->no_hp_ortu ?? '' ],
                    'alamat'  => [
                      $p->jalan_asal ?? '', $p->dusun_asal ?? '',
                      ($p->rt_asal ?? '') . ($p->rw_asal ? '/'.$p->rw_asal : ''),
                      $p->desa_asal ?? '', $p->kecamatan_asal ?? '', $p->kabupaten_asal ?? '', $p->provinsi_asal ?? '',
                      $p->jalan_tinggal ?? '', $p->dusun_tinggal ?? '',
                      ($p->rt_tinggal ?? '') . ($p->rw_tinggal ? '/'.$p->rw_tinggal : ''),
                      $p->desa_tinggal ?? '', $p->kecamatan_tinggal ?? '', $p->kabupaten_tinggal ?? '', $p->provinsi_tinggal ?? '',
                    ],
                    'jurusan' => [
                      $p->pil1 ?? '', $p->pil2 ?? '', $p->pil3 ?? '',
                      $p->diterima_di_jurusan ?? '', $p->ukuran_seragam ?? '',
                    ],
                    'kesehatan' => [
                      $p->kesehatan_tinggi_badan ?? '', $p->kesehatan_berat_badan ?? '',
                      $p->kesehatan_golongan_darah ?? '', $p->kesehatan_buta_warna ?? '',
                      $p->kesehatan_mata_minus ?? '', $p->kesehatan_tato_tindik ?? '',
                      $p->kesehatan_riwayat_penyakit ?? '', $p->kesehatan_catatan ?? '',
                      $p->kesehatan_petugas ?? '',
                      $p->kesehatan_verified_at ? $p->kesehatan_verified_at->format('d/m/Y H:i') : '',
                    ],
                    'gaya_belajar' => [
                      $p->gaya_belajar_tipe ?? '', $p->gaya_belajar_minat_bakat ?? '',
                      $p->gaya_belajar_catatan ?? '', $p->gaya_belajar_petugas ?? '',
                      $p->gaya_belajar_verified_at ? $p->gaya_belajar_verified_at->format('d/m/Y H:i') : '',
                    ],
                    'wawancara' => [
                      $p->wawancara_baca_tulis_alquran ?? '', $p->wawancara_solat_fardhu ?? '',
                      $p->wawancara_kepribadian ?? '', $p->wawancara_catatan ?? '', $pewawancara,
                      $p->wawancara_verified_at ? $p->wawancara_verified_at->format('d/m/Y H:i') : '',
                    ],
                    'biaya' => [
                      $p->biaya_spp ? number_format((float)$p->biaya_spp,0,',','.') : '',
                      $p->biaya_dana_awal_tahun ? number_format((float)$p->biaya_dana_awal_tahun,0,',','.') : '',
                      $p->biaya_infaq ? number_format((float)$p->biaya_infaq,0,',','.') : '',
                      $p->biaya_potongan ? number_format((float)$p->biaya_potongan,0,',','.') : '',
                      $p->total_tagihan ? number_format((float)$p->total_tagihan,0,',','.') : '',
                      $p->biaya_petugas ?? '',
                    ],
                    'pembayaran' => [
                      number_format($p->total_terbayar,0,',','.'),
                      number_format($p->sisa_tagihan,0,',','.'),
                      ucfirst(str_replace('_',' ',$p->status_bayar ?? '')),
                      $p->pembayaran_keterangan ?? '', $p->pembayaran_petugas ?? '',
                      $p->pembayaran_verified_at ? $p->pembayaran_verified_at->format('d/m/Y H:i') : '',
                    ],
                  ];
                @endphp
                <tr data-row="{{ $i + 1 }}"
                    data-cells="{{ json_encode($allCells) }}"
                    class="preview-data-row">
                  <td>{{ $i + 1 }}</td>
                  @foreach($groups as $gid => $group)
                    @if(in_array($gid, $selectedGroups))
                      @foreach($allCells[$gid] as $cell)
                        <td title="{{ $cell }}">{{ Str::limit($cell, 30) }}</td>
                      @endforeach
                    @endif
                  @endforeach
                </tr>
              @endforeach
            </tbody>
          </table>
        @endif
      </div>

      {{-- More data note --}}
      @if($totalFiltered > 10)
      <div style="padding:12px 18px; border-top:1px solid rgba(255,255,255,0.05); display:flex; align-items:center; gap:8px;">
        <i class="fas fa-info-circle" style="color:#f97316; font-size:12px;"></i>
        <span style="color:#64748b; font-size:12px;">Pratinjau hanya menampilkan 10 baris pertama. File Excel akan memuat semua <strong style="color:#94a3b8;" id="totalNote">{{ $totalFiltered }}</strong> data.</span>
      </div>
      @endif
    </div>

  </div>{{-- /main --}}
</div>{{-- /wrap --}}

</form>

<script>
(function(){
  // ========== Group definitions (order matters) ==========
  const GROUPS = {
    pendaftaran:  { label:'Data Pendaftaran', cols:['No. Daftar','Gelombang','Tahun Aktif','Status','Tgl. Daftar'] },
    pribadi:      { label:'Data Pribadi',     cols:['Nama Lengkap','Tempat Lahir','Tanggal Lahir','Jenis Kelamin','Agama','No HP Siswa'] },
    sekolah:      { label:'Asal Sekolah',     cols:['Asal Sekolah','Alamat Sekolah','Prestasi'] },
    ortu:         { label:'Orang Tua',        cols:['Nama Orang Tua','Pekerjaan Ortu','No HP Orang Tua'] },
    alamat:       { label:'Alamat',           cols:['Jalan Asal','Dusun Asal','RT/RW Asal','Desa Asal','Kecamatan Asal','Kabupaten Asal','Provinsi Asal','Jalan Tinggal','Dusun Tinggal','RT/RW Tinggal','Desa Tinggal','Kecamatan Tinggal','Kabupaten Tinggal','Provinsi Tinggal'] },
    jurusan:      { label:'Pilihan Jurusan',  cols:['Pilihan 1','Pilihan 2','Pilihan 3','Diterima di Jurusan','Ukuran Seragam'] },
    kesehatan:    { label:'Kesehatan',        cols:['Tinggi Badan (cm)','Berat Badan (kg)','Golongan Darah','Buta Warna','Mata Minus','Tato/Tindik','Riwayat Penyakit','Catatan Kesehatan','Petugas Kesehatan','Tgl. Verif. Kesehatan'] },
    gaya_belajar: { label:'Gaya Belajar',     cols:['Tipe Gaya Belajar','Minat Bakat','Catatan Gaya Belajar','Petugas Gaya Belajar','Tgl. Verif. Gaya Belajar'] },
    wawancara:    { label:'Wawancara',        cols:['Baca Tulis Al-Quran','Sholat Fardhu','Kepribadian','Catatan Wawancara','Pewawancara','Tgl. Verif. Wawancara'] },
    biaya:        { label:'Biaya',            cols:['Biaya SPP (Rp)','Dana Awal Tahun (Rp)','Biaya Infaq (Rp)','Potongan (Rp)','Total Tagihan (Rp)','Petugas Biaya'] },
    pembayaran:   { label:'Pembayaran',       cols:['Total Terbayar (Rp)','Sisa Tagihan (Rp)','Status Bayar','Keterangan Pembayaran','Petugas Pembayaran','Tgl. Verif. Pembayaran'] },
  };

  const groupItems  = document.querySelectorAll('.group-item');
  const btnToggle   = document.getElementById('btnToggleAll');
  const colBadge    = document.getElementById('colBadge');
  const statColNum  = document.getElementById('statColNum');
  const selectedInfo= document.getElementById('selectedInfo');
  const previewHead = document.getElementById('previewHead');
  const previewBody = document.getElementById('previewBody');
  const btnDownload = document.getElementById('btnDownload');

  // ---------- Helpers ----------
  function getChecked() {
    return [...groupItems].filter(el => el.classList.contains('checked')).map(el => el.dataset.group);
  }

  function totalCols(checked) {
    return checked.reduce((s, g) => s + (GROUPS[g]?.cols.length || 0), 0);
  }

  function updateStats() {
    const checked = getChecked();
    const n = totalCols(checked);
    colBadge.textContent  = '+' + n + ' kolom';
    statColNum.textContent = 1 + n; // +1 for No
    selectedInfo.textContent = checked.length + ' dari ' + Object.keys(GROUPS).length + ' grup';
    btnDownload.disabled = checked.length === 0;
    btnToggle.textContent = checked.length === Object.keys(GROUPS).length ? 'Batal Semua' : 'Pilih Semua';
    updatePreviewTable(checked);
  }

  function updatePreviewTable(checked) {
    if (!previewHead || !previewBody) return;

    // Build headers
    let headHtml = '<tr><th>No</th>';
    for (const gid of checked) {
      const g = GROUPS[gid];
      if (!g) continue;
      headHtml += '<th colspan="' + g.cols.length + '" class="group-sep-th" style="background:rgba(249,115,22,0.08); color:#f97316;">' + g.label + '</th>';
    }
    headHtml += '</tr><tr><th></th>';
    for (const gid of checked) {
      const g = GROUPS[gid];
      if (!g) continue;
      for (const col of g.cols) {
        headHtml += '<th>' + col + '</th>';
      }
    }
    headHtml += '</tr>';
    previewHead.innerHTML = headHtml;

    // Build body from data-cells attributes
    const rows = document.querySelectorAll('.preview-data-row');
    rows.forEach(row => {
      const cells = JSON.parse(row.dataset.cells || '{}');
      let html = '<td>' + row.dataset.row + '</td>';
      for (const gid of checked) {
        const groupCells = cells[gid] || [];
        for (const cell of groupCells) {
          const short = cell.length > 28 ? cell.substring(0, 28) + '…' : cell;
          html += '<td title="' + escHtml(cell) + '">' + escHtml(short) + '</td>';
        }
      }
      row.innerHTML = html;
    });

    // Empty state
    const wrap = document.getElementById('previewWrap');
    if (checked.length === 0) {
      wrap.innerHTML = '<div class="preview-empty"><i class="fas fa-table" style="color:#1e293b;"></i>Pilih minimal satu grup kolom untuk melihat pratinjau.</div>';
    }
  }

  function escHtml(s) {
    return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
  }

  // ---------- Events ----------
  groupItems.forEach(item => {
    item.addEventListener('click', () => {
      const cb = item.querySelector('input[type=checkbox]');
      cb.checked = !cb.checked;
      item.classList.toggle('checked', cb.checked);
      updateStats();
    });
  });

  btnToggle.addEventListener('click', () => {
    const allChecked = getChecked().length === Object.keys(GROUPS).length;
    groupItems.forEach(item => {
      const cb = item.querySelector('input[type=checkbox]');
      cb.checked = !allChecked;
      item.classList.toggle('checked', !allChecked);
    });
    updateStats();
  });

  // Apply filter reloads the page with filter params + selected groups
  document.getElementById('btnApplyFilter').addEventListener('click', () => {
    const form   = document.getElementById('dlForm');
    const params = new URLSearchParams();
    const gel    = document.getElementById('selGelombang').value;
    const stat   = document.getElementById('selStatus').value;
    if (gel)  params.set('gelombang', gel);
    if (stat) params.set('status', stat);
    getChecked().forEach(g => params.append('groups[]', g));
    window.location.href = '{{ route("admin.download.pendaftaran") }}?' + params.toString();
  });

  // On submit (download), do nothing special — form submits normally
  // but check at least 1 group selected
  document.getElementById('dlForm').addEventListener('submit', function(e) {
    if (getChecked().length === 0) {
      e.preventDefault();
      alert('Pilih minimal satu grup kolom untuk diunduh.');
    }
  });

  // Init
  updateStats();
})();
</script>
@endsection
