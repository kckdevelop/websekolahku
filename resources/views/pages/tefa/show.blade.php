@extends('layouts.app')
@section('title', $product->nama . ' - Tefa ' . config('app.name'))
@section('meta_description', strip_tags(Str::limit($product->deskripsi, 150)))

@section('content')
<div class="bg-slate-50 min-h-screen py-12">
  <div class="max-w-6xl mx-auto px-4">
    
    {{-- Breadcrumb --}}
    <nav class="flex mb-8 text-sm text-slate-500" aria-label="Breadcrumb">
      <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
          <a href="/" class="hover:text-primary transition-colors flex items-center gap-1">
            <i class="fas fa-home text-xs"></i> Beranda
          </a>
        </li>
        <li>
          <div class="flex items-center">
            <i class="fas fa-chevron-right text-xxs mx-2"></i>
            <a href="{{ route('tefa.index') }}" class="hover:text-primary transition-colors">Tefa</a>
          </div>
        </li>
        <li aria-current="page">
          <div class="flex items-center">
            <i class="fas fa-chevron-right text-xxs mx-2"></i>
            <span class="text-slate-400 truncate max-w-[200px] sm:max-w-xs">{{ $product->nama }}</span>
          </div>
        </li>
      </ol>
    </nav>

    {{-- Main Product Detail Container --}}
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden p-6 md:p-8 mb-12">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
        
        {{-- Left Column: Images Gallery --}}
        <div>
          {{-- Main Image Display --}}
          <div class="relative bg-slate-100 rounded-2xl overflow-hidden aspect-[4/3] mb-4 border border-slate-100 shadow-inner">
            <img id="mainDisplayImage" src="{{ $product->gambar_src }}" alt="{{ $product->nama }}" 
              class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
            
            <div class="absolute top-4 left-4 flex flex-col gap-2 items-start">
              <span class="bg-white/95 backdrop-blur text-primary text-[10px] font-bold px-3 py-1 rounded-full shadow-sm uppercase tracking-wider">
                Produk Tefa
              </span>
              @if($product->jurusanContent)
              <span class="bg-primary text-white text-[10px] font-bold px-3 py-1 rounded-full shadow-sm uppercase tracking-wider">
                {{ $product->jurusanContent->nama_jurusan }}
              </span>
              @endif
            </div>
          </div>

          {{-- Thumbnail Gallery (If there are multiple images) --}}
          @if(count($product->all_gambar) > 1)
          <div class="grid grid-cols-5 gap-3">
            @foreach($product->all_gambar as $index => $url)
            <button type="button" onclick="changeMainImage('{{ $url }}', this)" 
              class="thumbnail-btn relative aspect-square bg-slate-50 rounded-xl overflow-hidden border-2 {{ $index === 0 ? 'border-primary' : 'border-slate-200' }} hover:border-primary/50 transition-all">
              <img src="{{ $url }}" alt="Preview {{ $index + 1 }}" class="w-full h-full object-cover">
            </button>
            @endforeach
          </div>
          @endif
        </div>

        {{-- Right Column: Information --}}
        <div class="flex flex-col justify-between">
          <div>
            @if($product->jurusanContent)
            <p class="text-xs font-bold text-primary uppercase tracking-wider mb-2">
              {{ $product->jurusanContent->nama_jurusan }}
            </p>
            @else
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">
              Umum
            </p>
            @endif

            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-800 mb-4 leading-tight">
              {{ $product->nama }}
            </h1>

            <div class="flex items-center gap-4 py-4 border-y border-slate-100 mb-6">
              <div>
                <p class="text-xs text-slate-400 mb-0.5">Est. Harga / Tarif</p>
                @if($product->harga && $product->harga > 0)
                  <p class="text-2xl font-black text-primary">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                @else
                  <p class="text-xl font-bold text-slate-500 italic">Hubungi Kami</p>
                @endif
              </div>
              <div class="ml-auto">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium {{ $product->aktif ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-slate-100 text-slate-600' }}">
                  <span class="w-2 h-2 rounded-full {{ $product->aktif ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                  {{ $product->aktif ? 'Tersedia' : 'Arsip' }}
                </span>
              </div>
            </div>

            <div class="prose prose-slate max-w-none text-sm text-slate-600 leading-relaxed">
              <h3 class="text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Deskripsi Layanan / Produk:</h3>
              <p class="whitespace-pre-line">{{ $product->deskripsi ?? 'Belum ada deskripsi untuk produk ini.' }}</p>
            </div>
          </div>

          {{-- Action Button --}}
          <div class="mt-8 pt-6 border-t border-slate-100">
            @if($setting->telepon_wa)
              <a href="https://wa.me/{{ $setting->telepon_wa }}?text={{ urlencode('Halo, saya tertarik dengan layanan/produk Tefa: ' . $product->nama . '. Bisa dibantu info lebih lanjut?') }}"
                target="_blank" rel="noopener"
                class="w-full sm:w-auto inline-flex items-center justify-center gap-3 bg-green-500 hover:bg-green-600 text-white font-bold px-8 py-4 rounded-2xl shadow-lg shadow-green-500/20 hover:shadow-green-600/30 hover:-translate-y-0.5 transition-all text-base">
                <i class="fab fa-whatsapp text-xl"></i> Hubungi via WhatsApp
              </a>
            @else
              <button disabled class="w-full sm:w-auto inline-flex items-center justify-center gap-3 bg-slate-300 text-slate-500 font-bold px-8 py-4 rounded-2xl cursor-not-allowed text-base">
                <i class="fas fa-phone-slash"></i> Kontak Belum Tersedia
              </button>
            @endif
          </div>
        </div>

      </div>
    </div>

    {{-- Related Products --}}
    @if(count($related) > 0)
    <div>
      <h2 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-2">
        <span class="w-1.5 h-6 bg-primary rounded-full"></span> Produk / Jasa Lainnya
      </h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($related as $p)
          @include('pages.tefa._product_card', ['product' => $p])
        @endforeach
      </div>
    </div>
    @endif

  </div>
</div>

<script>
  function changeMainImage(url, element) {
    const mainImg = document.getElementById('mainDisplayImage');
    mainImg.src = url;
    
    // Reset borders
    document.querySelectorAll('.thumbnail-btn').forEach(btn => {
      btn.classList.remove('border-primary');
      btn.classList.add('border-slate-200');
    });
    
    // Set border on active thumbnail
    element.classList.remove('border-slate-200');
    element.classList.add('border-primary');
  }
</script>
@endsection
