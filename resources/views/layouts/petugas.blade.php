<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="{{ asset('storage/logomusaba.png') }}" type="image/png">
  <title>@yield('title', 'Panel Petugas') — PPDB SMK Muh 1 Bantul</title>
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
    }
    .nav-link:hover, .nav-link.active {
      background: rgba(255,255,255,0.12); color: #fff;
    }
    .nav-link .nav-icon { width: 18px; text-align: center; font-size: 14px; }
    .nav-section {
      font-size: 10px; font-weight: 700; letter-spacing: 1.2px;
      text-transform: uppercase; color: rgba(255,255,255,0.35);
      padding: 16px 16px 4px; margin: 0;
    }
  </style>
  @stack('styles')
</head>
<body>
<div style="display:flex; min-height:100vh;">

  {{-- SIDEBAR --}}
  <aside style="
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
          <img src="{{ asset('storage/logomusaba.png') }}" alt="Logo" style="width:30px; height:30px; object-fit:contain;">
        </div>
        <div>
          <p style="color:#fff; font-size:13px; font-weight:700; margin:0;">
            @if(auth()->user()->role === 'petugas_kesehatan') UKS &amp; Kesehatan
            @elseif(auth()->user()->role === 'petugas_wawancara') Wawancara &amp; Minat
            @elseif(auth()->user()->role === 'petugas_pembayaran') Pembayaran PPDB
            @else Panel Petugas
            @endif
          </p>
          <p style="color:rgba(255,255,255,0.5); font-size:10px; margin:0;">PPDB SMK Muh 1 Bantul</p>
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

      @if(auth()->user()->role === 'admin' || auth()->user()->role === 'petugas')
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

      <p class="nav-section">Sistem</p>

      @if(auth()->user()->isAdmin())
      <a href="{{ route('admin.dashboard') }}" class="nav-link">
        <i class="fas fa-shield-alt nav-icon"></i>
        <span>Panel Admin</span>
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
          <p style="color:rgba(255,255,255,0.45); font-size:10px;">
            @if(auth()->user()->role === 'petugas_kesehatan') Bagian Kesehatan
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
  <div style="flex:1; margin-left:240px; display:flex; flex-direction:column; min-height:100vh;">

    {{-- Topbar --}}
    <header style="
      position:sticky; top:0; z-index:30;
      background:#fff; border-bottom:1px solid #e2e8f0;
      box-shadow:0 1px 3px rgba(0,0,0,0.06);
      padding:14px 24px; display:flex; align-items:center; justify-content:space-between;
    ">
      <div>
        <h1 style="font-size:16px; font-weight:700; color:#1e293b; margin:0;">@yield('title', 'Dashboard Petugas')</h1>
        <p style="font-size:11px; color:#94a3b8; margin:2px 0 0;">
          @yield('subtitle', 'Panel PPDB SMK Muhammadiyah 1 Bantul')
        </p>
      </div>
      <div style="display:flex; align-items:center; gap:10px;">
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
</body>
</html>
