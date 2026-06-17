@extends('layouts.admin')
@section('title')
<span class="inline-flex items-center gap-2">
  <a href="{{ route('admin.berita.index') }}" class="text-slate-400 hover:text-slate-600 transition-colors mr-1">
    <i class="fas fa-arrow-left text-base"></i>
  </a>
  <span>Tambah Berita Baru</span>
</span>
@endsection
@section('subtitle', 'Buat artikel berita baru untuk website sekolah')

@section('content')
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

  {{-- KOLOM KIRI: Form Tambah --}}
  <div class="xl:col-span-2">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">


      <form method="POST" action="{{ route('admin.berita.store') }}" enctype="multipart/form-data" class="p-6 space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          {{-- Judul --}}
          <div class="md:col-span-2">
            <label for="judul" class="block text-sm font-medium text-slate-700 mb-1.5">Judul Berita <span class="text-red-500">*</span></label>
            <input type="text" id="judul" name="judul" value="{{ old('judul') }}" required
              class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm @error('judul') border-red-400 @enderror"
              placeholder="Judul berita yang menarik...">
            @error('judul') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          </div>

          {{-- Tanggal --}}
          <div>
            <label for="tanggal" class="block text-sm font-medium text-slate-700 mb-1.5">Tanggal <span class="text-red-500">*</span></label>
            <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required
              class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
            @error('tanggal') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          </div>

          {{-- Status Draft --}}
          <div class="flex items-start pt-7">
            <div class="flex items-center h-5">
              <input id="draft" name="draft" type="checkbox" value="1" {{ old('draft') ? 'checked' : '' }}
                class="h-4 w-4 text-primary border-slate-300 rounded focus:ring-primary">
            </div>
            <div class="ml-3 text-sm">
              <label for="draft" class="font-medium text-slate-700">Simpan sebagai Draft</label>
              <p class="text-slate-500 text-xs">Draft tidak akan ditampilkan di website</p>
            </div>
          </div>
        </div>

        {{-- Gambar --}}
        <div>
          <label for="gambar" class="block text-sm font-medium text-slate-700 mb-1.5">Gambar Utama</label>
          <div class="flex items-center gap-4">
            <div id="preview-container" class="hidden w-24 h-24 rounded-xl overflow-hidden border border-slate-200">
              <img id="image-preview" src="" alt="Preview" class="w-full h-full object-cover">
            </div>
            <label class="cursor-pointer flex items-center gap-2 px-4 py-3 rounded-xl border-2 border-dashed border-slate-200 hover:border-primary hover:bg-orange-50 transition-all text-sm text-slate-500 hover:text-primary">
              <i class="fas fa-cloud-upload-alt text-lg"></i>
              <span id="file-label">Pilih Gambar (JPG, PNG, maks. 2MB)</span>
              <input type="file" id="gambar" name="gambar" accept="image/*" class="hidden" data-aspect-ratio="16/9" onchange="previewImage(this)">
            </label>
          </div>
          @error('gambar') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Konten (CKEditor) --}}
        <div>
          <label for="konten" class="block text-sm font-medium text-slate-700 mb-1.5">Konten Berita <span class="text-red-500">*</span></label>
          <textarea id="konten" name="konten" class="w-full">{{ old('konten') }}</textarea>
          @error('konten') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Buttons --}}
        <div class="flex items-center gap-3 pt-2">
          <button type="submit"
            class="inline-flex items-center gap-2 bg-primary hover:bg-secondary text-white font-semibold px-6 py-3 rounded-xl transition-all hover:shadow-lg hover:shadow-primary/30">
            <i class="fas fa-save"></i> Simpan Berita
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
        <div class="px-5 py-3 flex items-start gap-3 hover:bg-slate-50 transition-colors group">
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
{{-- CKEditor 5 CDN --}}
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
      heading: {
        options: [
          { model: 'paragraph', title: 'Paragraf', class: 'ck-heading_paragraph' },
          { model: 'heading1', view: 'h1', title: 'Judul 1', class: 'ck-heading_heading1' },
          { model: 'heading2', view: 'h2', title: 'Judul 2', class: 'ck-heading_heading2' },
          { model: 'heading3', view: 'h3', title: 'Judul 3', class: 'ck-heading_heading3' },
        ]
      },
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
        document.getElementById('file-label').textContent = file.name;
      };
      reader.readAsDataURL(file);
    }
  }
</script>
@endsection
