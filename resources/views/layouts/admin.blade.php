<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" href="{{ asset('storage/logomusaba.png') }}" type="image/png">
  <title>{{ trim(strip_tags(View::yieldContent('title', 'Admin'))) }} - Admin SMK Muhammadiyah 1 Bantul</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#f97316',
            secondary: '#ea580c',
          },
          fontSize: {
            'xxs': '0.65rem',
          },
          fontFamily: {
            sans: ['Inter', 'sans-serif'],
          }
        }
      }
    }
  </script>
  <style>
    body { font-family: 'Inter', sans-serif; }

    /* Sidebar link base */
    .nav-link {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 10px 14px;
      border-radius: 10px;
      color: #94a3b8;
      text-decoration: none;
      font-size: 14px;
      font-weight: 500;
      transition: background 0.2s, color 0.2s;
      width: 100%;
    }
    .nav-link:hover {
      background: rgba(255,255,255,0.08);
      color: #fff;
    }
    .nav-link.active {
      background: rgba(249,115,22,0.15);
      color: #f97316;
      font-weight: 600;
    }
    .nav-link .nav-icon {
      width: 18px;
      text-align: center;
      flex-shrink: 0;
    }
    .nav-label {
      display: inline-block;
      flex: 1;
    }
    .nav-section {
      font-size: 10px;
      font-weight: 700;
      color: #475569;
      text-transform: uppercase;
      letter-spacing: 0.08em;
      padding: 16px 14px 6px;
    }
  </style>
  <!-- Cropper CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
  @yield('styles')
</head>
<body style="background:#f1f5f9; min-height:100vh;">

<div style="display:flex; min-height:100vh;">

  {{-- ===================== SIDEBAR ===================== --}}
  <aside style="
    position: fixed;
    top: 0; left: 0;
    height: 100%;
    width: 256px;
    background: #0f172a;
    display: flex;
    flex-direction: column;
    z-index: 40;
    overflow: hidden;
  ">
    {{-- Logo --}}
    <a href="/" style="display:flex; align-items:center; gap:12px; padding:20px 24px; border-bottom:1px solid rgba(255,255,255,0.08); text-decoration:none;" class="group">
      <div style="width:38px; height:38px; background:#fff; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0; overflow:hidden;">
        <img src="{{ asset('storage/logomusaba.png') }}" alt="Logo" style="width:30px; height:30px; object-fit:contain;">
      </div>
      <div>
        <p style="color:#fff; font-weight:700; font-size:14px; line-height:1.2;">Admin Panel</p>
        <p style="color:#64748b; font-size:11px;">SMK Muh. 1 Bantul</p>
      </div>
    </a>

    {{-- Navigation --}}
    <nav style="flex:1; padding:12px; overflow-y:auto; display:flex; flex-direction:column; gap:2px;">

      <a href="{{ route('admin.dashboard') }}"
         class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="fas fa-tachometer-alt nav-icon"></i>
        <span class="nav-label">Dashboard</span>
      </a>

      @if(auth()->user()->role === 'admin')
      <p class="nav-section">Konten</p>

      {{-- Dropdown 1: Informasi --}}
      <div class="dropdown-container">
        <button type="button" class="nav-link w-full text-left dropdown-toggle {{ request()->routeIs('admin.berita.*', 'admin.prestasi.*') ? 'active' : '' }}" onclick="toggleDropdown(this)">
          <i class="fas fa-newspaper nav-icon"></i>
          <span class="nav-label">Informasi Sekolah</span>
          <i class="fas fa-chevron-right dropdown-chevron text-xs transition-transform duration-200 ml-auto {{ request()->routeIs('admin.berita.*', 'admin.prestasi.*') ? 'rotate-90' : '' }}"></i>
        </button>
        <div class="dropdown-menu pl-4 space-y-1 mt-1 transition-all duration-300 {{ request()->routeIs('admin.berita.*', 'admin.prestasi.*') ? '' : 'hidden' }}">
          <a href="{{ route('admin.berita.index') }}" class="nav-link py-2 {{ request()->routeIs('admin.berita.*') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon text-xxs scale-75"></i>
            <span class="nav-label text-xs">Berita</span>
          </a>
          <a href="{{ route('admin.prestasi.index') }}" class="nav-link py-2 {{ request()->routeIs('admin.prestasi.*') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon text-xxs scale-75"></i>
            <span class="nav-label text-xs">Prestasi</span>
          </a>
        </div>
      </div>

      {{-- Dropdown 2: Galeri --}}
      <div class="dropdown-container">
        <button type="button" class="nav-link w-full text-left dropdown-toggle {{ request()->routeIs('admin.galeri_foto.*', 'admin.galeri_video.*') ? 'active' : '' }}" onclick="toggleDropdown(this)">
          <i class="fas fa-images nav-icon"></i>
          <span class="nav-label">Galeri Sekolah</span>
          <i class="fas fa-chevron-right dropdown-chevron text-xs transition-transform duration-200 ml-auto {{ request()->routeIs('admin.galeri_foto.*', 'admin.galeri_video.*') ? 'rotate-90' : '' }}"></i>
        </button>
        <div class="dropdown-menu pl-4 space-y-1 mt-1 transition-all duration-300 {{ request()->routeIs('admin.galeri_foto.*', 'admin.galeri_video.*') ? '' : 'hidden' }}">
          <a href="{{ route('admin.galeri_foto.index') }}" class="nav-link py-2 {{ request()->routeIs('admin.galeri_foto.*') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon text-xxs scale-75"></i>
            <span class="nav-label text-xs">Galeri Foto</span>
          </a>
          <a href="{{ route('admin.galeri_video.index') }}" class="nav-link py-2 {{ request()->routeIs('admin.galeri_video.*') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon text-xxs scale-75"></i>
            <span class="nav-label text-xs">Galeri Video</span>
          </a>
        </div>
      </div>

      {{-- Dropdown 3: Tampilan Beranda --}}
      <div class="dropdown-container">
        <button type="button" class="nav-link w-full text-left dropdown-toggle {{ request()->routeIs('admin.hero.*', 'admin.sambutan.*', 'admin.testimoni.*', 'admin.jurusan.*', 'admin.mitra.*') ? 'active' : '' }}" onclick="toggleDropdown(this)">
          <i class="fas fa-sliders-h nav-icon"></i>
          <span class="nav-label">Tampilan Beranda</span>
          <i class="fas fa-chevron-right dropdown-chevron text-xs transition-transform duration-200 ml-auto {{ request()->routeIs('admin.hero.*', 'admin.sambutan.*', 'admin.testimoni.*', 'admin.jurusan.*', 'admin.mitra.*') ? 'rotate-90' : '' }}"></i>
        </button>
        <div class="dropdown-menu pl-4 space-y-1 mt-1 transition-all duration-300 {{ request()->routeIs('admin.hero.*', 'admin.sambutan.*', 'admin.testimoni.*', 'admin.jurusan.*', 'admin.mitra.*') ? '' : 'hidden' }}">
          <a href="{{ route('admin.hero.index') }}" class="nav-link py-2 {{ request()->routeIs('admin.hero.*') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon text-xxs scale-75"></i>
            <span class="nav-label text-xs">Hero Slideshow</span>
          </a>
          <a href="{{ route('admin.sambutan.edit') }}" class="nav-link py-2 {{ request()->routeIs('admin.sambutan.*') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon text-xxs scale-75"></i>
            <span class="nav-label text-xs">Sambutan Kepala</span>
          </a>
          <a href="{{ route('admin.testimoni.index') }}" class="nav-link py-2 {{ request()->routeIs('admin.testimoni.*') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon text-xxs scale-75"></i>
            <span class="nav-label text-xs">Testimoni Alumni</span>
          </a>
          <a href="{{ route('admin.jurusan.index') }}" class="nav-link py-2 {{ request()->routeIs('admin.jurusan.*') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon text-xxs scale-75"></i>
            <span class="nav-label text-xs">Halaman Jurusan</span>
          </a>
          <a href="{{ route('admin.mitra.index') }}" class="nav-link py-2 {{ request()->routeIs('admin.mitra.*') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon text-xxs scale-75"></i>
            <span class="nav-label text-xs">Mitra Industri</span>
          </a>
        </div>
      </div>

      {{-- Dropdown 4: Bursa Kerja (BKK) --}}
      <div class="dropdown-container">
        <button type="button" class="nav-link w-full text-left dropdown-toggle {{ request()->routeIs('admin.bkk.*') ? 'active' : '' }}" onclick="toggleDropdown(this)">
          <i class="fas fa-briefcase nav-icon"></i>
          <span class="nav-label">Bursa Kerja (BKK)</span>
          <i class="fas fa-chevron-right dropdown-chevron text-xs transition-transform duration-200 ml-auto {{ request()->routeIs('admin.bkk.*') ? 'rotate-90' : '' }}"></i>
        </button>
        <div class="dropdown-menu pl-4 space-y-1 mt-1 transition-all duration-300 {{ request()->routeIs('admin.bkk.*') ? '' : 'hidden' }}">
          <a href="{{ route('admin.bkk.setting') }}" class="nav-link py-2 {{ request()->routeIs('admin.bkk.setting') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon text-xxs scale-75"></i>
            <span class="nav-label text-xs">Pengaturan BKK</span>
          </a>
          <a href="{{ route('admin.bkk.lowongan.index') }}" class="nav-link py-2 {{ request()->routeIs('admin.bkk.lowongan.*') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon text-xxs scale-75"></i>
            <span class="nav-label text-xs">Lowongan Kerja</span>
          </a>
        </div>
      </div>

      <p class="nav-section">Sistem</p>

      <a href="{{ route('admin.nobox.edit') }}"
         class="nav-link {{ request()->routeIs('admin.nobox.*') ? 'active' : '' }}">
        <i class="fab fa-whatsapp nav-icon"></i>
        <span class="nav-label">Pengaturan WhatsApp</span>
      </a>

      <a href="{{ route('admin.users.index') }}"
         class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
        <i class="fas fa-users-cog nav-icon"></i>
        <span class="nav-label">Kelola User</span>
      </a>

      <a href="{{ route('admin.pesan.index') }}"
         class="nav-link {{ request()->routeIs('admin.pesan.*') ? 'active' : '' }}"
         style="position:relative;">
        <i class="fas fa-envelope nav-icon"></i>
        <span class="nav-label">Pesan Masuk</span>
        @php $totalPesan = \App\Models\Pesan::count(); @endphp
        @if($totalPesan > 0)
          <span style="background:#f97316; color:#fff; font-size:10px; border-radius:999px; padding:1px 7px; font-weight:700; flex-shrink:0;">{{ $totalPesan }}</span>
        @endif
      </a>
      @endif

      @if(auth()->user()->role === 'admin_pendaftaran')
      <p class="nav-section">SPMB</p>

      @php $spmbStatusContent = \App\Models\SpmbPageContent::getSingle(); @endphp
      <a href="{{ route('admin.spmb-status.edit') }}"
         class="nav-link {{ request()->routeIs('admin.spmb-status.*') ? 'active' : '' }}">
        <i class="fas fa-toggle-on nav-icon"></i>
        <span class="nav-label">Status Pendaftaran</span>
        @if ($spmbStatusContent->is_pendaftaran_open)
          <span style="background:#22c55e; color:#fff; font-size:10px; border-radius:999px; padding:1px 8px; font-weight:700; flex-shrink:0; margin-left:auto;">Buka</span>
        @else
          <span style="background:#ef4444; color:#fff; font-size:10px; border-radius:999px; padding:1px 8px; font-weight:700; flex-shrink:0; margin-left:auto;">Tutup</span>
        @endif
      </a>

      <a href="{{ route('admin.spmb-halaman.edit') }}"
         class="nav-link {{ request()->routeIs('admin.spmb-halaman.*') ? 'active' : '' }}">
        <i class="fas fa-sliders-h nav-icon"></i>
        <span class="nav-label">Konten Halaman SPMB</span>
      </a>

      <a href="{{ route('admin.gelombang.index') }}"
         class="nav-link {{ request()->routeIs('admin.gelombang.*') ? 'active' : '' }}">
        <i class="fas fa-layer-group nav-icon"></i>
        <span class="nav-label">Atur Gelombang</span>
      </a>

      {{-- Dropdown: Manajemen PPDB --}}
      <div class="dropdown-container">
        <button type="button"
          class="nav-link w-full text-left dropdown-toggle {{ request()->routeIs('admin.pendaftaran.*', 'admin.petugas-wawancara.*', 'admin.download.*', 'admin.reset.*') ? 'active' : '' }}"
          onclick="toggleDropdown(this)">
          <i class="fas fa-school nav-icon"></i>
          <span class="nav-label">Manajemen PPDB</span>
          @php $pendingPpdb = \App\Models\Pendaftaran::where('status','pending')->count(); @endphp
          @if($pendingPpdb > 0)
            <span style="background:#ef4444; color:#fff; font-size:10px; border-radius:999px; padding:1px 7px; font-weight:700; flex-shrink:0;">{{ $pendingPpdb }}</span>
          @endif
          <i class="fas fa-chevron-right dropdown-chevron text-xs transition-transform duration-200 ml-auto {{ request()->routeIs('admin.pendaftaran.*', 'admin.petugas-wawancara.*', 'admin.download.*', 'admin.reset.*') ? 'rotate-90' : '' }}"></i>
        </button>
        <div class="dropdown-menu pl-4 space-y-1 mt-1 transition-all duration-300 {{ request()->routeIs('admin.pendaftaran.*', 'admin.petugas-wawancara.*', 'admin.download.*', 'admin.reset.*') ? '' : 'hidden' }}">

          <a href="{{ route('admin.pendaftaran.index') }}"
             class="nav-link py-2 {{ (request()->routeIs('admin.pendaftaran.*') && !request()->routeIs('admin.pendaftaran.laporan')) ? 'active' : '' }}"
             style="position:relative;">
            <i class="far fa-circle nav-icon text-xxs scale-75"></i>
            <span class="nav-label text-xs">Pendaftaran</span>
            @php $pending = \App\Models\Pendaftaran::where('status','pending')->count(); @endphp
            @if($pending > 0)
              <span style="background:#ef4444; color:#fff; font-size:10px; border-radius:999px; padding:1px 7px; font-weight:700; flex-shrink:0;">{{ $pending }}</span>
            @endif
          </a>

          <a href="{{ route('admin.petugas-wawancara.index') }}"
             class="nav-link py-2 {{ request()->routeIs('admin.petugas-wawancara.*') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon text-xxs scale-75"></i>
            <span class="nav-label text-xs">Petugas Pewawancara</span>
          </a>

          <a href="{{ route('admin.pendaftaran.laporan') }}"
             class="nav-link py-2 {{ request()->routeIs('admin.pendaftaran.laporan') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon text-xxs scale-75"></i>
            <span class="nav-label text-xs">Laporan Pendaftaran</span>
          </a>

          <a href="{{ route('admin.download.pendaftaran') }}"
             class="nav-link py-2 {{ request()->routeIs('admin.download.pendaftaran') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon text-xxs scale-75"></i>
            <span class="nav-label text-xs">Download Excel</span>
          </a>

          <a href="{{ route('admin.reset.index') }}"
             class="nav-link py-2 {{ request()->routeIs('admin.reset.*') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon text-xxs scale-75"></i>
            <span class="nav-label text-xs">Reset Pendaftaran</span>
          </a>

        </div>
      </div>
      @endif

      <p class="nav-section">Website</p>

      <a href="{{ url('/') }}" target="_blank" class="nav-link">
        <i class="fas fa-external-link-alt nav-icon"></i>
        <span class="nav-label">Lihat Website</span>
      </a>

    </nav>

    {{-- User Info --}}
    <div style="border-top:1px solid rgba(255,255,255,0.08); padding:16px;">
      <div style="display:flex; align-items:center; gap:12px; margin-bottom:12px;">
        <div style="width:36px; height:36px; background:rgba(249,115,22,0.15); border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
          <i class="fas fa-user" style="color:#f97316; font-size:13px;"></i>
        </div>
        <div style="flex:1; min-width:0;">
          <p style="color:#fff; font-size:13px; font-weight:600; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ auth()->user()->name }}</p>
          <p style="color:#64748b; font-size:11px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ auth()->user()->email }}</p>
        </div>
      </div>
      <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button type="submit" style="
          width:100%;
          display:flex;
          align-items:center;
          justify-content:center;
          gap:8px;
          padding:8px 16px;
          background:rgba(239,68,68,0.1);
          color:#f87171;
          border:none;
          border-radius:8px;
          font-size:13px;
          font-weight:500;
          cursor:pointer;
          transition:background 0.2s;
        "
        onmouseover="this.style.background='rgba(239,68,68,0.2)'"
        onmouseout="this.style.background='rgba(239,68,68,0.1)'">
          <i class="fas fa-sign-out-alt"></i> Logout
        </button>
      </form>
    </div>
  </aside>

  {{-- ===================== MAIN CONTENT ===================== --}}
  <div style="flex:1; margin-left:256px; display:flex; flex-direction:column; min-height:100vh;">

    {{-- Topbar --}}
    <header style="
      position:sticky;
      top:0;
      z-index:30;
      background:#fff;
      border-bottom:1px solid #e2e8f0;
      box-shadow:0 1px 3px rgba(0,0,0,0.06);
      padding:16px 24px;
      display:flex;
      align-items:center;
      justify-content:space-between;
    ">
      <div>
        <h1 style="font-size:17px; font-weight:700; color:#1e293b; margin:0;">@yield('title', 'Dashboard')</h1>
        <p style="font-size:12px; color:#94a3b8; margin:2px 0 0;">@yield('subtitle', 'Panel Manajemen SMK Muhammadiyah 1 Bantul')</p>
      </div>
      <div style="display:flex; align-items:center; gap:12px;">
        <span style="font-size:13px; color:#94a3b8;">{{ now()->translatedFormat('d F Y') }}</span>
        <div style="width:8px; height:8px; background:#22c55e; border-radius:50%;"></div>
        <span style="font-size:12px; color:#64748b;">Online</span>
      </div>
    </header>

    {{-- Flash Messages + Content --}}
    <main style="flex:1; padding:24px;">
      @if(session('success'))
        <div style="display:flex; align-items:center; gap:12px; background:#f0fdf4; border:1px solid #bbf7d0; color:#16a34a; padding:12px 16px; border-radius:10px; margin-bottom:16px; font-size:14px;">
          <i class="fas fa-check-circle"></i>
          <span style="flex:1;">{{ session('success') }}</span>
          <button type="button" onclick="this.parentElement.remove()" style="background:none; border:none; color:#16a34a; cursor:pointer; font-size:16px;">&times;</button>
        </div>
      @endif
      @if(session('error'))
        <div style="display:flex; align-items:center; gap:12px; background:#fef2f2; border:1px solid #fecaca; color:#dc2626; padding:12px 16px; border-radius:10px; margin-bottom:16px; font-size:14px;">
          <i class="fas fa-exclamation-circle"></i>
          <span style="flex:1;">{{ session('error') }}</span>
          <button type="button" onclick="this.parentElement.remove()" style="background:none; border:none; color:#dc2626; cursor:pointer; font-size:16px;">&times;</button>
        </div>
      @endif

      @yield('content')
    </main>
  </div>

</div>

<script>
  function toggleDropdown(button) {
    const container = button.closest('.dropdown-container');
    const menu = container.querySelector('.dropdown-menu');
    const chevron = container.querySelector('.dropdown-chevron');
    
    if (menu.classList.contains('hidden')) {
      menu.classList.remove('hidden');
      chevron.classList.add('rotate-90');
    } else {
      menu.classList.add('hidden');
      chevron.classList.remove('rotate-90');
    }
  }
</script>

  <!-- Global Cropper Modal -->
  <div id="cropper-modal" style="display: none;" class="fixed inset-0 z-[9999] items-center justify-center bg-black/60 backdrop-blur-sm p-4">
    <div class="bg-white rounded-3xl max-w-2xl w-full shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
      <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
        <h3 class="font-bold text-slate-800 flex items-center gap-2">
          <i class="fas fa-crop-alt text-primary text-lg"></i> Atur & Potong Foto
        </h3>
        <button type="button" onclick="closeCropperModal()" class="text-slate-400 hover:text-slate-600 text-xl font-bold">&times;</button>
      </div>
      <div class="p-6 flex-grow overflow-hidden flex flex-col md:flex-row gap-6">
        <div class="flex-grow max-h-[50vh] md:max-h-[60vh] bg-slate-900 flex items-center justify-center overflow-hidden rounded-xl border border-slate-100 relative min-h-[250px]">
          <img id="cropper-image" src="" class="max-w-full max-h-full block">
        </div>
        <div class="flex flex-row md:flex-col justify-center gap-3 flex-shrink-0">
          <button type="button" id="crop-rotate-left" class="w-12 h-12 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 flex items-center justify-center transition" title="Putar Kiri"><i class="fas fa-rotate-left"></i></button>
          <button type="button" id="crop-rotate-right" class="w-12 h-12 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 flex items-center justify-center transition" title="Putar Kanan"><i class="fas fa-rotate-right"></i></button>
          <button type="button" id="crop-zoom-in" class="w-12 h-12 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 flex items-center justify-center transition" title="Perbesar"><i class="fas fa-search-plus"></i></button>
          <button type="button" id="crop-zoom-out" class="w-12 h-12 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 flex items-center justify-center transition" title="Perkecil"><i class="fas fa-search-minus"></i></button>
          <button type="button" id="crop-reset" class="w-12 h-12 rounded-xl bg-slate-100 hover:bg-slate-200 text-red-600 flex items-center justify-center transition" title="Reset"><i class="fas fa-history"></i></button>
        </div>
      </div>
      <div class="px-6 py-4 border-t border-slate-100 flex justify-end gap-3 bg-slate-50">
        <button type="button" onclick="closeCropperModal()" class="px-5 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold rounded-xl text-sm transition">Batal</button>
        <button type="button" onclick="useOriginalImage()" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold rounded-xl text-sm transition border border-slate-200">Gunakan Asli</button>
        <button type="button" id="crop-save-btn" class="px-5 py-2.5 bg-primary hover:bg-secondary text-white font-semibold rounded-xl text-sm transition shadow-lg shadow-primary/30">Potong & Simpan</button>
      </div>
    </div>
  </div>

  <!-- Cropper JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
  <script>
    let currentFileInput = null;
    let cropperInstance = null;
    let originalFile = null;

    document.addEventListener('change', function(e) {
      if (e.target && e.target.type === 'file' && e.target.accept && e.target.accept.includes('image')) {
        // Prevent intercepting if we explicitly set data-skip-crop="true"
        if (e.target.getAttribute('data-skip-crop') === 'true') return;
        
        const file = e.target.files[0];
        if (file) {
          // If it's already a cropped file generated by our script, don't crop again
          if (file.name.includes('(cropped)')) return;

          currentFileInput = e.target;
          originalFile = file;
          
          const reader = new FileReader();
          reader.onload = function(event) {
            openCropperModal(event.target.result);
          };
          reader.readAsDataURL(file);
        }
      }
    });

    function openCropperModal(imageSrc) {
      const modal = document.getElementById('cropper-modal');
      const image = document.getElementById('cropper-image');
      image.src = imageSrc;
      modal.style.display = 'flex';

      let aspectRatio = NaN;
      if (currentFileInput) {
        const ratioAttr = currentFileInput.getAttribute('data-aspect-ratio');
        if (ratioAttr) {
          try {
            aspectRatio = eval(ratioAttr);
          } catch(err) {
            aspectRatio = NaN;
          }
        }
      }

      if (cropperInstance) {
        cropperInstance.destroy();
      }

      cropperInstance = new Cropper(image, {
        aspectRatio: aspectRatio,
        viewMode: 1,
        autoCropArea: 0.9,
        responsive: true,
      });
    }

    function closeCropperModal() {
      document.getElementById('cropper-modal').style.display = 'none';
      if (cropperInstance) {
        cropperInstance.destroy();
        cropperInstance = null;
      }
      if (currentFileInput) {
        currentFileInput.value = '';
      }
      currentFileInput = null;
    }

    function useOriginalImage() {
      document.getElementById('cropper-modal').style.display = 'none';
      if (cropperInstance) {
        cropperInstance.destroy();
        cropperInstance = null;
      }
      
      // Update local preview if previewImage function exists on the view
      if (currentFileInput) {
        const fileLabel = document.getElementById('file-label');
        if (fileLabel) {
          fileLabel.textContent = originalFile.name;
        }
        
        // Find preview image element if present in current context
        const previewImg = document.getElementById('image-preview') || currentFileInput.closest('form')?.querySelector('#image-preview');
        const previewContainer = document.getElementById('preview-container') || currentFileInput.closest('form')?.querySelector('#preview-container');
        
        if (previewImg) {
          previewImg.src = URL.createObjectURL(originalFile);
        }
        if (previewContainer) {
          previewContainer.classList.remove('hidden');
        }
      }
      currentFileInput = null;
    }

    document.getElementById('crop-rotate-left')?.addEventListener('click', () => cropperInstance?.rotate(-90));
    document.getElementById('crop-rotate-right')?.addEventListener('click', () => cropperInstance?.rotate(90));
    document.getElementById('crop-zoom-in')?.addEventListener('click', () => cropperInstance?.zoom(0.1));
    document.getElementById('crop-zoom-out')?.addEventListener('click', () => cropperInstance?.zoom(-0.1));
    document.getElementById('crop-reset')?.addEventListener('click', () => cropperInstance?.reset());

    document.getElementById('crop-save-btn')?.addEventListener('click', function() {
      if (!cropperInstance || !currentFileInput) return;

      cropperInstance.getCroppedCanvas({
        maxWidth: 1600,
        maxHeight: 1600,
        imageSmoothingEnabled: true,
        imageSmoothingQuality: 'high',
      }).toBlob((blob) => {
        if (!blob) return;

        // Clean original filename extension and append '(cropped)'
        const nameParts = originalFile.name.split('.');
        const ext = nameParts.pop();
        const baseName = nameParts.join('.');
        const newName = `${baseName}_(cropped).${ext}`;

        const croppedFile = new File([blob], newName, {
          type: originalFile.type,
          lastModified: Date.now()
        });

        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(croppedFile);
        
        const oldFileInput = currentFileInput;
        currentFileInput = null;
        oldFileInput.files = dataTransfer.files;

        // Update preview elements
        const previewImg = document.getElementById('image-preview') || oldFileInput.closest('form')?.querySelector('#image-preview');
        const previewContainer = document.getElementById('preview-container') || oldFileInput.closest('form')?.querySelector('#preview-container');
        const fileLabel = document.getElementById('file-label') || oldFileInput.closest('form')?.querySelector('#file-label');

        if (previewImg) {
          previewImg.src = URL.createObjectURL(croppedFile);
        }
        if (previewContainer) {
          previewContainer.classList.remove('hidden');
        }
        if (fileLabel) {
          fileLabel.textContent = newName;
        }

        document.getElementById('cropper-modal').style.display = 'none';
        if (cropperInstance) {
          cropperInstance.destroy();
          cropperInstance = null;
        }
      }, originalFile.type, 0.9);
    });
  </script>

  @yield('scripts')
</body>
</html>
