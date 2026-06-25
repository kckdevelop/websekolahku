@extends('layouts.admin')
@section('title')
<span class="inline-flex items-center gap-2">
  <a href="{{ route('admin.berita.index') }}" class="text-slate-400 hover:text-slate-600 transition-colors mr-1">
    <i class="fas fa-arrow-left text-base"></i>
  </a>
  <span>Edit Berita</span>
</span>
@endsection
@section('subtitle', 'Perbarui artikel berita yang sudah ada')

@section('content')
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

  {{-- KOLOM KIRI: Form Edit --}}
  <div class="xl:col-span-2">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">


      <form method="POST" action="{{ route('admin.berita.update', $berita) }}" enctype="multipart/form-data" class="p-6 space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          {{-- Judul --}}
          <div class="md:col-span-2">
            <label for="judul" class="block text-sm font-medium text-slate-700 mb-1.5">Judul Berita <span class="text-red-500">*</span></label>
            <input type="text" id="judul" name="judul" value="{{ old('judul', $berita->judul) }}" required
              class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm @error('judul') border-red-400 @enderror">
            @error('judul') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          </div>

          <div>
            <label for="tanggal" class="block text-sm font-medium text-slate-700 mb-1.5">Tanggal <span class="text-red-500">*</span></label>
            <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', $berita->tanggal->format('Y-m-d')) }}" required
              class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
          </div>

          <div class="flex items-start pt-7">
            <input id="draft" name="draft" type="checkbox" value="1" {{ old('draft', $berita->draft) ? 'checked' : '' }}
              class="h-4 w-4 text-primary border-slate-300 rounded focus:ring-primary mt-0.5">
            <div class="ml-3 text-sm">
              <label for="draft" class="font-medium text-slate-700">Simpan sebagai Draft</label>
              <p class="text-slate-500 text-xs">Draft tidak akan ditampilkan di website</p>
            </div>
          </div>
        </div>

        {{-- Gambar --}}
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1.5">Gambar Utama</label>
          
          <div id="drop-zone" class="border-2 border-dashed border-slate-200 hover:border-primary/50 rounded-2xl p-6 transition-all cursor-pointer text-center bg-slate-50/50 hover:bg-slate-50 relative">
            <input type="file" id="gambar" name="gambar" accept="image/*" data-aspect-ratio="16/9" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="previewImage(this)">
            
            <div class="space-y-2 pointer-events-none">
              <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-orange-50 text-primary mb-1">
                <i class="fas fa-cloud-upload-alt text-xl"></i>
              </div>
              
              <p class="text-sm font-medium text-slate-700">
                <span class="text-primary font-semibold">Klik untuk ubah gambar</span> atau seret dan lepas gambar ke sini
              </p>
              
              <p id="file-label" class="text-xs text-slate-400">
                Ganti Gambar (Biarkan kosong untuk tetap yang lama)
              </p>
              
              <!-- Recommended Image Size Description -->
              <div class="inline-block mt-2 bg-orange-50 border border-orange-100 px-3 py-1 rounded-full text-[11.5px] text-orange-600 font-medium">
                <i class="fas fa-info-circle mr-1"></i> Ukuran disarankan: 1280x720 px (Rasio 16:9)
              </div>
              
              <!-- Preview Container -->
              <div id="preview-container" class="mt-3">
                <img id="image-preview" src="{{ $berita->gambar ? asset('storage/' . $berita->gambar) : '' }}" class="mx-auto w-48 h-27 object-cover rounded-lg border border-slate-200 shadow-sm">
              </div>
            </div>
          </div>
          
          @error('gambar') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
        </div>

        {{-- Konten (CKEditor) --}}
        <div>
          <label for="konten" class="block text-sm font-medium text-slate-700 mb-1.5">Konten Berita <span class="text-red-500">*</span></label>
          <textarea id="konten" name="konten" class="w-full">{{ old('konten', $berita->konten) }}</textarea>
          @error('konten') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center gap-3 pt-2">
          <button type="submit"
            class="inline-flex items-center gap-2 bg-primary hover:bg-secondary text-white font-semibold px-6 py-3 rounded-xl transition-all hover:shadow-lg hover:shadow-primary/30">
            <i class="fas fa-save"></i> Simpan Perubahan
          </button>
          <a href="{{ route('admin.berita.index') }}"
            class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-6 py-3 rounded-xl transition-all">
            Batal
          </a>
        </div>
      </form>
    </div>
  </div>

  {{-- KOLOM KANAN: Daftar Berita --}}
  <div class="xl:col-span-1">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden sticky top-6">
      <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
        <h3 class="font-semibold text-slate-800 text-sm">Daftar Berita</h3>
        <a href="{{ route('admin.berita.index') }}" class="text-xs text-primary hover:underline">Lihat Semua</a>
      </div>
      <div class="divide-y divide-slate-50">
        @forelse($daftarBerita as $item)
        <div class="px-5 py-3 flex items-start gap-3 hover:bg-slate-50 transition-colors group {{ $item->id === $berita->id ? 'bg-orange-50 border-l-2 border-primary' : '' }}">
          {{-- Thumbnail --}}
          @if($item->gambar)
            <img src="{{ asset('storage/' . $item->gambar) }}" class="w-10 h-10 rounded-lg object-cover flex-shrink-0 mt-0.5">
          @else
            <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center flex-shrink-0 mt-0.5">
              <i class="fas fa-newspaper text-primary text-sm"></i>
            </div>
          @endif
          <div class="flex-1 min-w-0">
            <p class="text-sm font-medium text-slate-800 line-clamp-2 leading-tight">{{ $item->judul }}</p>
            <p class="text-xs text-slate-400 mt-0.5">{{ $item->tanggal->format('d M Y') }}</p>
            <div class="flex items-center gap-2 mt-1.5 opacity-0 group-hover:opacity-100 transition-opacity">
              <a href="{{ route('admin.berita.edit', $item) }}" class="text-xs text-blue-600 hover:text-blue-800 font-medium">
                <i class="fas fa-edit"></i> Edit
              </a>
              <form method="POST" action="{{ route('admin.berita.destroy', $item) }}" onsubmit="return confirm('Hapus berita ini?')" class="inline">
                @csrf @method('DELETE')
                <button type="submit" class="text-xs text-red-500 hover:text-red-700 font-medium">
                  <i class="fas fa-trash"></i> Hapus
                </button>
              </form>
            </div>
          </div>
          @if($item->draft)
            <span class="flex-shrink-0 inline-flex px-1.5 py-0.5 rounded text-xs bg-slate-100 text-slate-500">Draft</span>
          @else
            <span class="flex-shrink-0 inline-flex px-1.5 py-0.5 rounded text-xs bg-green-100 text-green-600">Publish</span>
          @endif
        </div>
        @empty
        <div class="px-5 py-8 text-center text-slate-400">
          <i class="fas fa-newspaper text-2xl mb-2 block"></i>
          <p class="text-sm">Belum ada berita</p>
        </div>
        @endforelse
      </div>
    </div>
  </div>

</div>
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
  ClassicEditor
    .create(document.querySelector('#konten'), {
      toolbar: {
        items: [
          'heading', '|',
          'bold', 'italic', 'underline', 'strikethrough', '|',
          'fontSize', 'fontColor', 'fontBackgroundColor', '|',
          'alignment', '|',
          'bulletedList', 'numberedList', 'todoList', '|',
          'outdent', 'indent', '|',
          'link', 'blockQuote', 'insertTable', '|',
          'undo', 'redo'
        ]
      },
      language: 'id',
    })
    .then(editor => {
      editor.model.document.on('change:data', () => {
        document.querySelector('#konten').value = editor.getData();
      });
    })
    .catch(error => console.error(error));

  function previewImage(input) {
    const file = input.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = (e) => {
        document.getElementById('image-preview').src = e.target.result;
        document.getElementById('preview-container').classList.remove('hidden');
        const fileLabel = document.getElementById('file-label');
        if (!file.name.includes('(cropped)')) {
            fileLabel.textContent = file.name + ' (' + (file.size / 1024 / 1024).toFixed(2) + ' MB)';
            fileLabel.classList.remove('text-slate-400');
            fileLabel.classList.add('text-primary', 'font-semibold');
        } else {
            fileLabel.textContent = file.name;
        }
      };
      reader.readAsDataURL(file);
    }
  }

  document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('gambar');
    const dropZone = document.getElementById('drop-zone');
    
    if (dropZone && fileInput) {
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
            }, false);
        });
        
        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.classList.add('border-primary', 'bg-orange-50/10');
                dropZone.classList.remove('border-slate-200', 'bg-slate-50/50');
            }, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.classList.remove('border-primary', 'bg-orange-50/10');
                dropZone.classList.add('border-slate-200', 'bg-slate-50/50');
            }, false);
        });
        
        dropZone.addEventListener('drop', function(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            if (files && files.length > 0) {
                fileInput.files = files;
                const event = new Event('change', { bubbles: true });
                fileInput.dispatchEvent(event);
            }
        }, false);
    }
  });
</script>
@endsection
