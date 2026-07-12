@extends('layouts.app')
@section('title', 'Teaching Factory (Tefa) - ' . config('app.name'))
@section('meta_description', 'Teaching Factory (Tefa) adalah program unit produksi berbasis kompetensi yang menghasilkan produk dan jasa berkualitas industri.')

@section('content')

{{-- ===== HERO SECTION ===== --}}
<section class="relative min-h-[52vh] flex items-center justify-center overflow-hidden bg-gradient-to-br from-slate-900 via-orange-950 to-slate-900">
  @if($setting->hero_gambar)
  <div class="absolute inset-0">
    <img src="{{ asset('storage/' . $setting->hero_gambar) }}" alt="Tefa Hero" class="w-full h-full object-cover opacity-30">
    <div class="absolute inset-0 bg-gradient-to-br from-slate-900/70 via-orange-900/40 to-slate-900/70"></div>
  </div>
  @endif

  <div class="absolute top-10 right-20 w-64 h-64 bg-orange-500/10 rounded-full blur-3xl"></div>
  <div class="absolute bottom-10 left-10 w-80 h-80 bg-amber-500/10 rounded-full blur-3xl"></div>

  <div class="relative z-10 text-center px-4 py-16 max-w-3xl mx-auto">
    <div class="inline-flex items-center gap-2 bg-orange-500/20 backdrop-blur border border-orange-400/30 text-orange-300 text-xs font-semibold px-4 py-1.5 rounded-full mb-5">
      <i class="fas fa-industry text-xs"></i> Teaching Factory
    </div>
    <h1 class="text-4xl sm:text-5xl font-extrabold text-white leading-tight mb-4">
      {{ $setting->hero_title ?? 'Teaching Factory' }}
    </h1>
    <p class="text-lg text-orange-100/80 max-w-xl mx-auto">
      {{ $setting->hero_subtitle ?? 'Unit produksi berbasis kompetensi yang menghasilkan produk dan jasa berkualitas industri' }}
    </p>
  </div>
</section>

{{-- ===== TENTANG TEFA ===== --}}
<section class="py-16 bg-white">
  <div class="container mx-auto px-4 max-w-5xl">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
      <div>
        <span class="inline-block text-xs font-bold text-primary uppercase tracking-widest mb-3">Tentang Kami</span>
        <h2 class="text-3xl font-extrabold text-slate-800 mb-5 leading-tight">
          {{ $setting->tentang_judul ?? 'Apa itu Teaching Factory?' }}
        </h2>
        <div class="space-y-3 text-slate-600 leading-relaxed">
          @foreach(explode("\n", $setting->tentang_deskripsi ?? 'Teaching Factory (Tefa) adalah program yang mengintegrasikan proses pembelajaran dengan kegiatan produksi nyata.') as $para)
            @if(trim($para))
              <p>{{ $para }}</p>
            @endif
          @endforeach
        </div>
      </div>
      <div class="grid grid-cols-2 gap-4">
        <div class="bg-gradient-to-br from-orange-50 to-amber-50 rounded-2xl p-6 text-center border border-orange-100">
          <div class="w-12 h-12 bg-orange-100 text-primary rounded-xl flex items-center justify-center mx-auto mb-3">
            <i class="fas fa-industry text-xl"></i>
          </div>
          <p class="font-bold text-slate-800 text-sm">Produksi Nyata</p>
          <p class="text-xs text-slate-500 mt-1">Produk &amp; jasa berkualitas industri</p>
        </div>
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 text-center border border-blue-100">
          <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mx-auto mb-3">
            <i class="fas fa-graduation-cap text-xl"></i>
          </div>
          <p class="font-bold text-slate-800 text-sm">Berbasis Kompetensi</p>
          <p class="text-xs text-slate-500 mt-1">Mengasah skill siswa langsung</p>
        </div>
        <div class="bg-gradient-to-br from-emerald-50 to-green-50 rounded-2xl p-6 text-center border border-emerald-100">
          <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center mx-auto mb-3">
            <i class="fas fa-handshake text-xl"></i>
          </div>
          <p class="font-bold text-slate-800 text-sm">Kemitraan Industri</p>
          <p class="text-xs text-slate-500 mt-1">Standar kerja profesional</p>
        </div>
        <div class="bg-gradient-to-br from-purple-50 to-violet-50 rounded-2xl p-6 text-center border border-purple-100">
          <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center mx-auto mb-3">
            <i class="fas fa-award text-xl"></i>
          </div>
          <p class="font-bold text-slate-800 text-sm">Kualitas Terjamin</p>
          <p class="text-xs text-slate-500 mt-1">Pengawasan ketat &amp; standar tinggi</p>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ===== PRODUK PER PROGRAM KEAHLIAN ===== --}}
@if($products->count() > 0)
<section class="py-16 bg-slate-50">
  <div class="container mx-auto px-4 max-w-6xl">

    <div class="text-center mb-10">
      <span class="inline-block text-xs font-bold text-primary uppercase tracking-widest mb-3">Katalog</span>
      <h2 class="text-3xl font-extrabold text-slate-800">Produk &amp; Jasa Tefa</h2>
      <p class="text-slate-500 mt-2 max-w-xl mx-auto">Diproduksi langsung oleh siswa di bawah bimbingan guru pengampu program keahlian</p>
    </div>

    {{-- TAB NAVIGATION --}}
    <div class="flex flex-wrap gap-2 justify-center mb-8" id="tefa-tabs" role="tablist">
      {{-- Tab: Semua --}}
      <button
        role="tab"
        aria-selected="true"
        data-tab="semua"
        onclick="switchTab('semua', this)"
        class="tab-btn active-tab px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-200 border
               bg-primary text-white border-primary shadow-sm">
        <i class="fas fa-th-large mr-1.5"></i> Semua
        <span class="ml-1.5 bg-white/30 text-white text-xs px-2 py-0.5 rounded-full">{{ $products->count() }}</span>
      </button>

      {{-- Tab per Jurusan --}}
      @foreach($jurusansWithProducts as $j)
      <button
        role="tab"
        aria-selected="false"
        data-tab="jurusan-{{ $j->id }}"
        onclick="switchTab('jurusan-{{ $j->id }}', this)"
        class="tab-btn px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-200 border
               bg-white text-slate-600 border-slate-200 hover:border-primary hover:text-primary">
        <i class="{{ $j->icon ?? 'fas fa-tools' }} mr-1.5"></i>
        {{ $j->nama_jurusan }}
        <span class="ml-1.5 bg-slate-100 text-slate-500 text-xs px-2 py-0.5 rounded-full">{{ $productsByJurusan[$j->id]->count() }}</span>
      </button>
      @endforeach

      {{-- Tab: Umum (jika ada produk tanpa jurusan) --}}
      @if($productsTanpaJurusan->count() > 0)
      <button
        role="tab"
        aria-selected="false"
        data-tab="umum"
        onclick="switchTab('umum', this)"
        class="tab-btn px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-200 border
               bg-white text-slate-600 border-slate-200 hover:border-primary hover:text-primary">
        <i class="fas fa-box mr-1.5"></i> Umum
        <span class="ml-1.5 bg-slate-100 text-slate-500 text-xs px-2 py-0.5 rounded-full">{{ $productsTanpaJurusan->count() }}</span>
      </button>
      @endif
    </div>

    {{-- TAB PANEL: SEMUA --}}
    <div id="panel-semua" class="tab-panel">
      @if($jurusansWithProducts->count() > 0)
        @foreach($jurusansWithProducts as $j)
          {{-- Section Header per Jurusan --}}
          <div class="flex items-center gap-3 mb-5 mt-8 first:mt-0">
            <div class="w-9 h-9 rounded-xl bg-orange-100 text-primary flex items-center justify-center flex-shrink-0">
              <i class="{{ $j->icon ?? 'fas fa-tools' }} text-sm"></i>
            </div>
            <div>
              <h3 class="font-extrabold text-slate-800 text-lg leading-tight">{{ $j->nama_jurusan }}</h3>
              <p class="text-xs text-slate-400">{{ $productsByJurusan[$j->id]->count() }} produk tersedia</p>
            </div>
            <div class="flex-1 h-px bg-slate-200 ml-2"></div>
          </div>
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-4">
            @foreach($productsByJurusan[$j->id] as $product)
              @include('pages.tefa._product_card', ['product' => $product, 'setting' => $setting])
            @endforeach
          </div>
        @endforeach

        @if($productsTanpaJurusan->count() > 0)
          <div class="flex items-center gap-3 mb-5 mt-8">
            <div class="w-9 h-9 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center flex-shrink-0">
              <i class="fas fa-box text-sm"></i>
            </div>
            <div>
              <h3 class="font-extrabold text-slate-800 text-lg">Umum</h3>
              <p class="text-xs text-slate-400">{{ $productsTanpaJurusan->count() }} produk</p>
            </div>
            <div class="flex-1 h-px bg-slate-200 ml-2"></div>
          </div>
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($productsTanpaJurusan as $product)
              @include('pages.tefa._product_card', ['product' => $product, 'setting' => $setting])
            @endforeach
          </div>
        @endif
      @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
          @foreach($products as $product)
            @include('pages.tefa._product_card', ['product' => $product, 'setting' => $setting])
          @endforeach
        </div>
      @endif
    </div>

    {{-- TAB PANEL per Jurusan --}}
    @foreach($jurusansWithProducts as $j)
    <div id="panel-jurusan-{{ $j->id }}" class="tab-panel hidden">
      <div class="flex items-center gap-3 mb-6">
        <div class="w-10 h-10 rounded-xl bg-orange-100 text-primary flex items-center justify-center">
          <i class="{{ $j->icon ?? 'fas fa-tools' }}"></i>
        </div>
        <div>
          <h3 class="font-extrabold text-slate-800 text-xl">{{ $j->nama_jurusan }}</h3>
          <p class="text-sm text-slate-400">{{ $productsByJurusan[$j->id]->count() }} produk tersedia</p>
        </div>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($productsByJurusan[$j->id] as $product)
          @include('pages.tefa._product_card', ['product' => $product, 'setting' => $setting])
        @endforeach
      </div>
    </div>
    @endforeach

    {{-- TAB PANEL: UMUM --}}
    @if($productsTanpaJurusan->count() > 0)
    <div id="panel-umum" class="tab-panel hidden">
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($productsTanpaJurusan as $product)
          @include('pages.tefa._product_card', ['product' => $product, 'setting' => $setting])
        @endforeach
      </div>
    </div>
    @endif

  </div>
</section>
@endif

{{-- ===== CTA SECTION ===== --}}
@if($setting->telepon_wa)
<section class="py-14 bg-gradient-to-r from-orange-500 to-amber-500">
  <div class="container mx-auto px-4 text-center">
    <h2 class="text-2xl font-extrabold text-white mb-3">Tertarik dengan Produk Tefa Kami?</h2>
    <p class="text-orange-100 mb-6">Hubungi kami via WhatsApp untuk informasi lebih lanjut, pemesanan, atau kerjasama.</p>
    <a href="https://wa.me/{{ $setting->telepon_wa }}" target="_blank" rel="noopener"
      class="inline-flex items-center gap-3 bg-white text-orange-600 font-bold px-8 py-4 rounded-2xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all">
      <i class="fab fa-whatsapp text-green-500 text-xl"></i> Hubungi via WhatsApp
    </a>
  </div>
</section>
@endif

@push('scripts')
<script>
function switchTab(tabId, btn) {
  // sembunyikan semua panel
  document.querySelectorAll('.tab-panel').forEach(el => el.classList.add('hidden'));
  // reset semua tombol
  document.querySelectorAll('.tab-btn').forEach(el => {
    el.classList.remove('bg-primary', 'text-white', 'border-primary', 'shadow-sm', 'active-tab');
    el.classList.add('bg-white', 'text-slate-600', 'border-slate-200');
    el.setAttribute('aria-selected', 'false');
  });
  // tampilkan panel aktif
  document.getElementById('panel-' + tabId)?.classList.remove('hidden');
  // aktifkan tombol
  btn.classList.add('bg-primary', 'text-white', 'border-primary', 'shadow-sm', 'active-tab');
  btn.classList.remove('bg-white', 'text-slate-600', 'border-slate-200');
  btn.setAttribute('aria-selected', 'true');
}
</script>
@endpush
@endsection
