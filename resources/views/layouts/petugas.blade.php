<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="{{ $schoolSetting->favicon_url }}" type="image/png">
  <title>@yield('title', 'Panel Petugas') — PPDB {{ $schoolSetting->singkatan }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#1d4ed8',
            secondary: '#1e40af',
          },
          fontSize: {
            'xxs': '0.65rem',
          },
          fontFamily: { sans: ['Inter', 'sans-serif'] }
        }
      }
    }
  </script>
  <style>
    body { font-family: 'Inter', sans-serif; background: #f1f5f9; }
    .nav-link {
      display: flex; align-items: center; gap: 10px;
      padding: 10px 16px; border-radius: 10px;
      color: rgba(255,255,255,0.7); font-size: 13.5px; font-weight: 500;
      text-decoration: none; transition: all 0.15s;
      width: 100%; box-sizing: border-box;
    }
    .nav-link:hover, .nav-link.active {
      background: rgba(255,255,255,0.12); color: #fff;
    }
    .nav-link .nav-icon { width: 18px; text-align: center; font-size: 14px; flex-shrink: 0; }
    .nav-section {
      font-size: 10px; font-weight: 700; letter-spacing: 1.2px;
      text-transform: uppercase; color: rgba(255,255,255,0.35);
      padding: 16px 16px 4px; margin: 0;
    }

    /* ===== DROPDOWN SUB-MENU ===== */
    .dropdown-menu-petugas {
      overflow: hidden;
      max-height: 0;
      opacity: 0;
      transition: max-height 0.3s ease, opacity 0.25s ease;
    }
    .dropdown-menu-petugas.open {
      max-height: 300px;
      opacity: 1;
    }
    .dropdown-chevron-petugas {
      transition: transform 0.25s ease;
      margin-left: auto;
      flex-shrink: 0;
      font-size: 11px;
    }
    .dropdown-chevron-petugas.rotated { transform: rotate(90deg); }
    .sub-nav-link {
      display: flex; align-items: center; gap: 8px;
      padding: 7px 16px 7px 44px; border-radius: 8px;
      color: rgba(255,255,255,0.6); font-size: 12.5px; font-weight: 400;
      text-decoration: none; transition: all 0.15s;
    }
    .sub-nav-link:hover { background: rgba(255,255,255,0.1); color: #fff; }
    .sub-nav-link.active { background: rgba(255,255,255,0.12); color: #fff; font-weight: 500; }
    .sub-nav-link .dot {
      width: 5px; height: 5px; border-radius: 50%;
      background: currentColor; flex-shrink: 0;
    }

    /* ===== MOBILE RESPONSIVE ===== */
    #sidebar-petugas {
      transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    #sidebar-overlay-petugas {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0,0,0,0.5);
      z-index: 35;
      backdrop-filter: blur(2px);
    }
    #sidebar-overlay-petugas.active { display: block; }
    #hamburger-btn-petugas {
      display: none;
    }

    @media (max-width: 768px) {
      #sidebar-petugas {
        transform: translateX(-100%);
      }
      #sidebar-petugas.open {
        transform: translateX(0);
      }
      #main-content-petugas {
        margin-left: 0 !important;
      }
      #hamburger-btn-petugas {
        display: flex;
      }
      #topbar-date-petugas {
        display: none;
      }
    }
  </style>
  @stack('styles')
</head>
<body>
<div style="display:flex; min-height:100vh;">

  <!-- Mobile overlay backdrop -->
  <div id="sidebar-overlay-petugas" onclick="closeSidebarPetugas()"></div>

  {{-- SIDEBAR --}}
  <aside id="sidebar-petugas" style="
    width: 240px; flex-shrink: 0;
    background: linear-gradient(180deg,#1e3a8a 0%,#1d4ed8 60%,#2563eb 100%);
    display: flex; flex-direction: column;
    position: fixed; top: 0; left: 0; bottom: 0; z-index: 40;
    box-shadow: 4px 0 20px rgba(30,58,138,0.25);
  ">
    {{-- Logo --}}
    <a href="/" style="padding:20px 16px 16px; border-bottom:1px solid rgba(255,255,255,0.1); text-decoration:none; display:block;" class="group">
      <div style="display:flex; align-items:center; gap:10px;">
        <div style="width:38px; height:38px; background:#fff; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0; overflow:hidden;">
          <img src="{{ $schoolSetting->logo_url }}" alt="Logo {{ $schoolSetting->singkatan }}" style="width:30px; height:30px; object-fit:contain;">
        </div>
        <div>
          <p style="color:#fff; font-size:13px; font-weight:700; margin:0;">
            @if(auth()->user()->role === 'petugas_kesehatan') UKS &amp; Kesehatan
            @elseif(auth()->user()->role === 'petugas_wawancara') Wawancara &amp; Minat
            @elseif(auth()->user()->role === 'petugas_pembayaran') Pembayaran PPDB
            @else Panel Petugas
            @endif
          </p>
          <p style="color:rgba(255,255,255,0.5); font-size:10px; margin:0;">PPDB {{ $schoolSetting->singkatan }}</p>
        </div>
      </div>
    </a>

    {{-- Nav --}}
    <nav style="flex:1; padding:12px 8px; overflow-y:auto;">
      <p class="nav-section">Menu Utama</p>

      @php
        $dashboardRoute = 'petugas.dashboard';
        if (auth()->user()->role === 'petugas_kesehatan') {
            $dashboardRoute = 'petugas.kesehatan.dashboard';
        } elseif (auth()->user()->role === 'petugas_wawancara') {
            $dashboardRoute = 'petugas.wawancara.dashboard';
        } elseif (auth()->user()->role === 'petugas_pembayaran') {
            $dashboardRoute = 'petugas.pembayaran.dashboard';
        }
      @endphp

      <a href="{{ route($dashboardRoute) }}"
         class="nav-link {{ request()->routeIs('petugas.*.dashboard') || request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
        <i class="fas fa-th-large nav-icon"></i>
        <span>Dashboard</span>
      </a>

      @if(in_array(auth()->user()->role, ['admin', 'super_admin']))
      <p class="nav-section">Akses Semua Ketugasan</p>

      {{-- Loket 1: Pendaftaran & Berkas --}}
      @php $isLoket1 = request()->routeIs('petugas.pendaftar*') || request()->is('petugas/pendaftar*') || request()->is('petugas/pendaftaran*') || request()->routeIs('petugas.laporan'); @endphp
      <div class="dropdown-container-petugas">
        <button type="button" onclick="toggleDropdownPetugas(this)"
          class="nav-link {{ $isLoket1 ? 'active' : '' }}"
          style="border:none; cursor:pointer;">
          <i class="fas fa-users nav-icon"></i>
          <span style="flex:1; text-align:left;">1. Loket Pendaftaran</span>
          <i class="fas fa-chevron-right dropdown-chevron-petugas {{ $isLoket1 ? 'rotated' : '' }}"></i>
        </button>
        <div class="dropdown-menu-petugas {{ $isLoket1 ? 'open' : '' }}">
          <a href="{{ route('petugas.pendaftar') }}" class="sub-nav-link {{ request()->routeIs('petugas.pendaftar') && !request()->routeIs('petugas.laporan') ? 'active' : '' }}">
            <span class="dot"></span> Dashboard Loket
          </a>
          <a href="{{ route('petugas.laporan') }}" class="sub-nav-link {{ request()->routeIs('petugas.laporan') ? 'active' : '' }}">
            <span class="dot"></span> Laporan Pendaftaran
          </a>
        </div>
      </div>

      {{-- Loket 2: UKS & Kesehatan --}}
      @php $isLoket2 = request()->is('petugas/kesehatan*'); @endphp
      <div class="dropdown-container-petugas">
        <button type="button" onclick="toggleDropdownPetugas(this)"
          class="nav-link {{ $isLoket2 ? 'active' : '' }}"
          style="border:none; cursor:pointer;">
          <i class="fas fa-heartbeat nav-icon"></i>
          <span style="flex:1; text-align:left;">2. Loket UKS &amp; Kesehatan</span>
          <i class="fas fa-chevron-right dropdown-chevron-petugas {{ $isLoket2 ? 'rotated' : '' }}"></i>
        </button>
        <div class="dropdown-menu-petugas {{ $isLoket2 ? 'open' : '' }}">
          <a href="{{ route('petugas.kesehatan.dashboard') }}" class="sub-nav-link {{ request()->routeIs('petugas.kesehatan.dashboard') ? 'active' : '' }}">
            <span class="dot"></span> Dashboard Loket
          </a>
          <a href="{{ route('petugas.kesehatan.laporan') }}" class="sub-nav-link {{ request()->routeIs('petugas.kesehatan.laporan') ? 'active' : '' }}">
            <span class="dot"></span> Laporan Kesehatan
          </a>
        </div>
      </div>

      {{-- Loket 3: Wawancara --}}
      @php $isLoket3 = request()->is('petugas/wawancara*'); @endphp
      <div class="dropdown-container-petugas">
        <button type="button" onclick="toggleDropdownPetugas(this)"
          class="nav-link {{ $isLoket3 ? 'active' : '' }}"
          style="border:none; cursor:pointer;">
          <i class="fas fa-comments nav-icon"></i>
          <span style="flex:1; text-align:left;">3. Loket Wawancara</span>
          <i class="fas fa-chevron-right dropdown-chevron-petugas {{ $isLoket3 ? 'rotated' : '' }}"></i>
        </button>
        <div class="dropdown-menu-petugas {{ $isLoket3 ? 'open' : '' }}">
          <a href="{{ route('petugas.wawancara.dashboard') }}" class="sub-nav-link {{ request()->routeIs('petugas.wawancara.dashboard') ? 'active' : '' }}">
            <span class="dot"></span> Dashboard Loket
          </a>
          <a href="{{ route('petugas.wawancara.laporan') }}" class="sub-nav-link {{ request()->routeIs('petugas.wawancara.laporan') ? 'active' : '' }}">
            <span class="dot"></span> Laporan Wawancara
          </a>
        </div>
      </div>

      {{-- Loket 4: Kasir & Pembayaran --}}
      @php $isLoket4 = request()->is('petugas/pembayaran*'); @endphp
      <div class="dropdown-container-petugas">
        <button type="button" onclick="toggleDropdownPetugas(this)"
          class="nav-link {{ $isLoket4 ? 'active' : '' }}"
          style="border:none; cursor:pointer;">
          <i class="fas fa-cash-register nav-icon"></i>
          <span style="flex:1; text-align:left;">4. Loket Kasir &amp; Pembayaran</span>
          <i class="fas fa-chevron-right dropdown-chevron-petugas {{ $isLoket4 ? 'rotated' : '' }}"></i>
        </button>
        <div class="dropdown-menu-petugas {{ $isLoket4 ? 'open' : '' }}">
          <a href="{{ route('petugas.pembayaran.dashboard') }}" class="sub-nav-link {{ request()->routeIs('petugas.pembayaran.dashboard') ? 'active' : '' }}">
            <span class="dot"></span> Dashboard Loket
          </a>
          <a href="{{ route('petugas.pembayaran.laporan') }}" class="sub-nav-link {{ request()->routeIs('petugas.pembayaran.laporan') ? 'active' : '' }}">
            <span class="dot"></span> Laporan Pembayaran
          </a>
        </div>
      </div>

      @else
        @if(auth()->user()->role === 'petugas')
        <a href="{{ route('petugas.pendaftar') }}"
           class="nav-link {{ request()->routeIs('petugas.pendaftar') || request()->is('petugas/pendaftar*') ? 'active' : '' }}">
          <i class="fas fa-users nav-icon"></i>
          <span>Data Pendaftar</span>
        </a>

        <a href="{{ route('petugas.laporan') }}"
           class="nav-link {{ request()->routeIs('petugas.laporan') ? 'active' : '' }}">
          <i class="fas fa-chart-line nav-icon"></i>
          <span>Laporan Pendaftaran</span>
        </a>
        @endif

        @if(auth()->user()->role === 'petugas_kesehatan')
        <a href="{{ route('petugas.kesehatan.laporan') }}" class="nav-link {{ request()->routeIs('petugas.kesehatan.laporan') ? 'active' : '' }}">
          <i class="fas fa-chart-line nav-icon"></i>
          <span>Laporan Kesehatan</span>
        </a>
        @endif

        @if(auth()->user()->role === 'petugas_wawancara')
        <a href="{{ route('petugas.wawancara.laporan') }}" class="nav-link {{ request()->routeIs('petugas.wawancara.laporan') ? 'active' : '' }}">
          <i class="fas fa-chart-line nav-icon"></i>
          <span>Laporan Wawancara</span>
        </a>
        @endif

        @if(auth()->user()->role === 'petugas_pembayaran')
        <a href="{{ route('petugas.pembayaran.laporan') }}" class="nav-link {{ request()->routeIs('petugas.pembayaran.laporan') ? 'active' : '' }}">
          <i class="fas fa-chart-line nav-icon"></i>
          <span>Laporan Pembayaran</span>
        </a>
        @endif
      @endif

      <p class="nav-section">Sistem</p>

      @if(auth()->user()->isAdmin())
      <a href="{{ route('admin.dashboard') }}" class="nav-link">
        <i class="fas fa-shield-alt nav-icon"></i>
        <span>Panel Admin Utama</span>
      </a>
      @endif
    </nav>

    {{-- User Info --}}
    <div style="border-top:1px solid rgba(255,255,255,0.1); padding:14px;">
      <div style="display:flex; align-items:center; gap:10px; margin-bottom:10px;">
        <div style="width:34px; height:34px; background:rgba(255,255,255,0.15); border-radius:50%; display:flex; align-items:center; justify-content:center;">
          <i class="fas fa-user" style="color:#fff; font-size:12px;"></i>
        </div>
        <div style="flex:1; min-width:0;">
          <p style="color:#fff; font-size:12px; font-weight:600; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ auth()->user()->name }}</p>
          <p style="color:rgba(255,255,255,0.7); font-size:10px;">
            @if(auth()->user()->role === 'super_admin') Super Administrator
            @elseif(auth()->user()->role === 'admin') Administrator
            @elseif(auth()->user()->role === 'petugas_kesehatan') Bagian Kesehatan
            @elseif(auth()->user()->role === 'petugas_wawancara') Bagian Wawancara/Tes
            @elseif(auth()->user()->role === 'petugas_pembayaran') Bagian Keuangan/Kasir
            @else Bagian Pendaftaran
            @endif
          </p>
        </div>
      </div>
      <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button type="submit" style="
          width:100%; display:flex; align-items:center; justify-content:center; gap:6px;
          padding:7px 12px; background:rgba(239,68,68,0.15); color:#fca5a5;
          border:none; border-radius:8px; font-size:12px; font-weight:500; cursor:pointer;
        ">
          <i class="fas fa-sign-out-alt"></i> Logout
        </button>
      </form>
    </div>
  </aside>

  {{-- MAIN CONTENT --}}
  <div id="main-content-petugas" style="flex:1; margin-left:240px; display:flex; flex-direction:column; min-height:100vh;">

    <header style="
      position:sticky; top:0; z-index:30;
      background:#fff; border-bottom:1px solid #e2e8f0;
      box-shadow:0 1px 3px rgba(0,0,0,0.06);
      padding:12px 20px; display:flex; align-items:center; justify-content:space-between; gap:12px;
    ">
      <div style="display:flex; align-items:center; gap:12px; min-width:0;">
        <!-- Hamburger button (mobile only) -->
        <button id="hamburger-btn-petugas" onclick="toggleSidebarPetugas()"
          style="width:36px; height:36px; border:none; background:#f1f5f9; border-radius:8px; cursor:pointer; align-items:center; justify-content:center; flex-shrink:0; color:#1e293b;"
          aria-label="Buka menu">
          <i class="fas fa-bars" style="font-size:15px;"></i>
        </button>
        <div style="min-width:0;">
          <h1 style="font-size:16px; font-weight:700; color:#1e293b; margin:0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">@yield('title', 'Dashboard Petugas')</h1>
          <p style="font-size:11px; color:#94a3b8; margin:2px 0 0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
            @yield('subtitle', 'Panel PPDB SMK Muhammadiyah 1 Bantul')
          </p>
        </div>
      </div>
      <div id="topbar-date-petugas" style="display:flex; align-items:center; gap:10px; flex-shrink:0;">
        <span style="font-size:12px; color:#94a3b8;">{{ now()->translatedFormat('d F Y') }}</span>
        <div style="width:7px; height:7px; background:#22c55e; border-radius:50%;"></div>
        <span style="font-size:11px; color:#64748b;">Online</span>
      </div>
    </header>

    {{-- Alert Flash --}}
    @if(session('success'))
    <div style="margin:16px 24px 0; padding:12px 16px; background:#dcfce7; border:1px solid #86efac; border-radius:10px; color:#166534; font-size:13px; display:flex; align-items:center; gap:8px;">
      <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div style="margin:16px 24px 0; padding:12px 16px; background:#fee2e2; border:1px solid #fca5a5; border-radius:10px; color:#991b1b; font-size:13px; display:flex; align-items:center; gap:8px;">
      <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
    </div>
    @endif

    {{-- Page Content --}}
    <main style="flex:1; padding:24px;">
      @yield('content')
    </main>

  </div>
</div>
@stack('scripts')
<script>
  // ===== Dropdown Toggle =====
  function toggleDropdownPetugas(btn) {
    const container = btn.closest('.dropdown-container-petugas');
    const menu      = container.querySelector('.dropdown-menu-petugas');
    const chevron   = container.querySelector('.dropdown-chevron-petugas');
    const isOpen    = menu.classList.contains('open');
    menu.classList.toggle('open', !isOpen);
    chevron.classList.toggle('rotated', !isOpen);
  }

  function toggleSidebarPetugas() {
    document.getElementById('sidebar-petugas').classList.toggle('open');
    document.getElementById('sidebar-overlay-petugas').classList.toggle('active');
  }

  function closeSidebarPetugas() {
    document.getElementById('sidebar-petugas').classList.remove('open');
    document.getElementById('sidebar-overlay-petugas').classList.remove('active');
  }

  // Auto-close sidebar on nav link click (mobile)
  document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar-petugas');
    if (!sidebar) return;
    sidebar.querySelectorAll('a.nav-link, a.sub-nav-link').forEach(function(link) {
      link.addEventListener('click', function() {
        if (window.innerWidth <= 768) closeSidebarPetugas();
      });
    });
  });
</script>
</body>
</html>
