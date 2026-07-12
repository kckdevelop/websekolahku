<div class="group bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col h-full">
  <a href="{{ route('tefa.show', $product) }}" class="relative h-52 bg-slate-100 overflow-hidden block">
    @if($product->gambar)
      <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama }}"
        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
    @else
      <div class="w-full h-full flex flex-col items-center justify-center text-slate-300">
        <i class="fas fa-box-open text-5xl mb-2"></i>
        <span class="text-xs">Foto belum tersedia</span>
      </div>
    @endif
    <div class="absolute top-3 left-3 flex flex-col gap-1 items-start">
      <span class="bg-white/90 backdrop-blur text-primary text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm uppercase tracking-wider">
        Produk Tefa
      </span>
      @if($product->jurusanContent)
      <span class="bg-primary text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm uppercase tracking-wider">
        {{ $product->jurusanContent->nama_jurusan }}
      </span>
      @endif
    </div>
  </a>
  <div class="p-5 flex flex-col justify-between flex-grow">
    <div>
      <h3 class="font-bold text-slate-800 text-base mb-2 group-hover:text-primary transition-colors line-clamp-2">
        <a href="{{ route('tefa.show', $product) }}">{{ $product->nama }}</a>
      </h3>
      @if($product->deskripsi)
        <p class="text-sm text-slate-500 leading-relaxed line-clamp-3 mb-4">
          {{ $product->deskripsi }}
        </p>
      @endif
    </div>
    <div class="flex items-center justify-between pt-3 border-t border-slate-100 mt-auto">
      <div>
        @if($product->harga && $product->harga > 0)
          <p class="text-[10px] text-slate-400 mb-0.5">Harga mulai</p>
          <p class="font-extrabold text-primary text-base">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
        @else
          <p class="text-xs font-semibold text-slate-500 italic">Hubungi kami</p>
        @endif
      </div>
      @if($setting->telepon_wa)
        <a href="https://wa.me/{{ $setting->telepon_wa }}?text={{ urlencode('Halo, saya tertarik dengan produk Tefa: ' . $product->nama) }}"
          target="_blank" rel="noopener"
          class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white text-xs font-semibold px-4 py-2 rounded-xl transition-colors">
          <i class="fab fa-whatsapp"></i> Order
        </a>
      @endif
    </div>
  </div>
</div>
