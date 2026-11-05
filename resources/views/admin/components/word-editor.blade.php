@props([
    'name' => 'deskripsi',
    'id' => 'deskripsi',
    'value' => '',
    'label' => 'Deskripsi Produk',
    'placeholder' => 'Ketik atau tempel deskripsi di sini layaknya menggunakan Microsoft Word...'
])

<div class="word-editor-wrapper" id="wrapper-{{ $id }}">
  @if($label)
    <label class="block text-sm font-medium text-slate-700 mb-1.5 flex items-center justify-between">
      <span>{{ $label }}</span>
      <span class="text-xs text-slate-400 font-normal flex items-center gap-1.5">
        <i class="fas fa-file-word text-[#185abd]"></i> Tampilan Editor Microsoft Word
      </span>
    </label>
  @endif

  {{-- Hidden Input for Form Submission --}}
  <textarea id="{{ $id }}" name="{{ $name }}" class="hidden">{{ $value }}</textarea>

  {{-- Word Application Container --}}
  <div class="border border-slate-300 rounded-xl overflow-hidden shadow-sm bg-slate-100 flex flex-col font-sans">
    
    {{-- 1. Word Title & Ribbon Tabs Bar --}}
    <div class="bg-[#185abd] text-white px-3 py-1.5 flex items-center justify-between text-xs select-none">
      <div class="flex items-center gap-2">
        <div class="w-5 h-5 bg-white text-[#185abd] font-bold rounded flex items-center justify-center text-[11px] shadow-sm">
          W
        </div>
        <span class="font-semibold tracking-wide">Dokumen Deskripsi - Microsoft Word</span>
        <div class="hidden sm:flex items-center gap-1 ml-3 pl-3 border-l border-white/20">
          <button type="button" class="w-6 h-6 hover:bg-white/10 rounded flex items-center justify-center text-white/90" title="Simpan Cepat (Form)" onclick="document.getElementById('{{ $id }}').closest('form')?.requestSubmit?.() || document.getElementById('{{ $id }}').closest('form')?.submit()">
            <i class="fas fa-save text-[11px]"></i>
          </button>
          <button type="button" class="w-6 h-6 hover:bg-white/10 rounded flex items-center justify-center text-white/90" title="Undo (Ctrl+Z)" onclick="execWordCmd('{{ $id }}', 'undo')">
            <i class="fas fa-undo text-[11px]"></i>
          </button>
          <button type="button" class="w-6 h-6 hover:bg-white/10 rounded flex items-center justify-center text-white/90" title="Redo (Ctrl+Y)" onclick="execWordCmd('{{ $id }}', 'redo')">
            <i class="fas fa-redo text-[11px]"></i>
          </button>
        </div>
      </div>
      <div class="flex items-center gap-1">
        <span class="text-[10px] bg-white/15 px-2 py-0.5 rounded text-white/90">Autosave Aktif</span>
      </div>
    </div>

    {{-- Ribbon Menu Tabs --}}
    <div class="bg-[#f3f4f6] border-b border-slate-200 px-3 pt-1 flex items-center gap-1 text-xs select-none">
      <button type="button" class="px-3 py-1 font-semibold text-[#185abd] border-b-2 border-[#185abd] bg-white rounded-t-md shadow-xs">
        Beranda (Home)
      </button>
      <button type="button" class="px-3 py-1 text-slate-600 hover:text-slate-900 font-medium rounded-t-md hover:bg-slate-200/60 transition-colors" onclick="focusEditorTab('{{ $id }}', 'insert')">
        Sisipkan (Insert)
      </button>
      <button type="button" class="px-3 py-1 text-slate-600 hover:text-slate-900 font-medium rounded-t-md hover:bg-slate-200/60 transition-colors" onclick="focusEditorTab('{{ $id }}', 'view')">
        Tampilan
      </button>
    </div>

    {{-- 2. Word Ribbon Toolbar --}}
    <div class="bg-[#f8fafc] border-b border-slate-200 p-2 sm:p-2.5 flex flex-wrap items-center gap-x-2 gap-y-1.5 text-slate-700 select-none text-xs">
      
      {{-- Group 1: Undo / Redo / Clear --}}
      <div class="flex items-center gap-0.5 pr-2 border-r border-slate-300">
        <button type="button" class="word-btn" title="Undo (Ctrl+Z)" onclick="execWordCmd('{{ $id }}', 'undo')">
          <i class="fas fa-undo"></i>
        </button>
        <button type="button" class="word-btn" title="Redo (Ctrl+Y)" onclick="execWordCmd('{{ $id }}', 'redo')">
          <i class="fas fa-redo"></i>
        </button>
        <button type="button" class="word-btn" title="Hapus Format (Clear Formatting)" onclick="execWordCmd('{{ $id }}', 'removeFormat')">
          <i class="fas fa-remove-format text-red-500"></i>
        </button>
      </div>

      {{-- Group 2: Font Family & Style Dropdown --}}
      <div class="flex items-center gap-1.5 pr-2 border-r border-slate-300">
        {{-- Gaya Paragraf / Heading --}}
        <select class="word-select w-28 sm:w-32" onchange="applyWordFormatBlock('{{ $id }}', this.value); this.selectedIndex=0;" title="Gaya Teks / Heading">
          <option value="" disabled selected>Gaya Teks...</option>
          <option value="p">Normal (Paragraf)</option>
          <option value="h1">Judul 1 (Heading 1)</option>
          <option value="h2">Judul 2 (Heading 2)</option>
          <option value="h3">Judul 3 (Heading 3)</option>
          <option value="h4">Judul 4 (Sub Judul)</option>
          <option value="blockquote">Kutipan (Quote)</option>
        </select>

        {{-- Font Family --}}
        <select class="word-select w-24 sm:w-28" onchange="execWordCmd('{{ $id }}', 'fontName', this.value); this.selectedIndex=0;" title="Font">
          <option value="" disabled selected>Font...</option>
          <option value="Calibri, sans-serif">Calibri</option>
          <option value="Aptos, sans-serif">Aptos</option>
          <option value="Arial, sans-serif">Arial</option>
          <option value="'Times New Roman', serif">Times New Roman</option>
          <option value="'Segoe UI', sans-serif">Segoe UI</option>
          <option value="Georgia, serif">Georgia</option>
          <option value="'Courier New', monospace">Courier New</option>
        </select>

        {{-- Font Size --}}
        <select class="word-select w-16" onchange="execWordCmd('{{ $id }}', 'fontSize', this.value); this.selectedIndex=0;" title="Ukuran Font">
          <option value="" disabled selected>Size</option>
          <option value="1">10 pt (Kecil)</option>
          <option value="2">11 pt</option>
          <option value="3">12 pt (Standar)</option>
          <option value="4">14 pt</option>
          <option value="5">18 pt (Besar)</option>
          <option value="6">24 pt</option>
          <option value="7">36 pt (Sangat Besar)</option>
        </select>
      </div>

      {{-- Group 3: Bold, Italic, Underline, Strikethrough, Sub/Sup --}}
      <div class="flex items-center gap-0.5 pr-2 border-r border-slate-300">
        <button type="button" class="word-btn font-bold text-slate-800" title="Tebal / Bold (Ctrl+B)" onclick="execWordCmd('{{ $id }}', 'bold')">
          <i class="fas fa-bold"></i>
        </button>
        <button type="button" class="word-btn italic text-slate-800" title="Miring / Italic (Ctrl+I)" onclick="execWordCmd('{{ $id }}', 'italic')">
          <i class="fas fa-italic"></i>
        </button>
        <button type="button" class="word-btn underline text-slate-800" title="Garis Bawah / Underline (Ctrl+U)" onclick="execWordCmd('{{ $id }}', 'underline')">
          <i class="fas fa-underline"></i>
        </button>
        <button type="button" class="word-btn line-through text-slate-800" title="Coret / Strikethrough" onclick="execWordCmd('{{ $id }}', 'strikeThrough')">
          <i class="fas fa-strikethrough"></i>
        </button>
        <button type="button" class="word-btn" title="Subscript" onclick="execWordCmd('{{ $id }}', 'subscript')">
          <span class="font-bold text-[11px]">X<sub class="text-[9px]">2</sub></span>
        </button>
        <button type="button" class="word-btn" title="Superscript" onclick="execWordCmd('{{ $id }}', 'superscript')">
          <span class="font-bold text-[11px]">X<sup class="text-[9px]">2</sup></span>
        </button>
      </div>

      {{-- Group 4: Text Color & Highlight --}}
      <div class="flex items-center gap-1 pr-2 border-r border-slate-300">
        {{-- Font Color --}}
        <div class="relative flex items-center" title="Warna Teks (Font Color)">
          <label class="word-btn cursor-pointer flex flex-col items-center justify-center p-0 w-7 h-7">
            <span class="font-bold text-[11px] leading-none">A</span>
            <span id="font-color-bar-{{ $id }}" class="w-4 h-1 bg-red-600 rounded-xs mt-0.5"></span>
            <input type="color" class="opacity-0 absolute inset-0 w-full h-full cursor-pointer" value="#000000" onchange="execWordCmd('{{ $id }}', 'foreColor', this.value); document.getElementById('font-color-bar-{{ $id }}').style.backgroundColor = this.value;">
          </label>
        </div>

        {{-- Text Highlight / Stabilo --}}
        <div class="relative flex items-center" title="Warna Sorotan Teks (Highlight)">
          <label class="word-btn cursor-pointer flex flex-col items-center justify-center p-0 w-7 h-7">
            <i class="fas fa-highlighter text-[10px] leading-none text-amber-500"></i>
            <span id="bg-color-bar-{{ $id }}" class="w-4 h-1 bg-yellow-300 rounded-xs mt-0.5"></span>
            <input type="color" class="opacity-0 absolute inset-0 w-full h-full cursor-pointer" value="#fef08a" onchange="execWordCmd('{{ $id }}', 'hiliteColor', this.value); document.getElementById('bg-color-bar-{{ $id }}').style.backgroundColor = this.value;">
          </label>
        </div>
      </div>

      {{-- Group 5: Alignment & Lists --}}
      <div class="flex items-center gap-0.5 pr-2 border-r border-slate-300">
        <button type="button" class="word-btn" title="Rata Kiri (Align Left)" onclick="execWordCmd('{{ $id }}', 'justifyLeft')">
          <i class="fas fa-align-left"></i>
        </button>
        <button type="button" class="word-btn" title="Rata Tengah (Align Center)" onclick="execWordCmd('{{ $id }}', 'justifyCenter')">
          <i class="fas fa-align-center"></i>
        </button>
        <button type="button" class="word-btn" title="Rata Kanan (Align Right)" onclick="execWordCmd('{{ $id }}', 'justifyRight')">
          <i class="fas fa-align-right"></i>
        </button>
        <button type="button" class="word-btn" title="Rata Kanan Kiri (Justify)" onclick="execWordCmd('{{ $id }}', 'justifyFull')">
          <i class="fas fa-align-justify"></i>
        </button>
        <button type="button" class="word-btn" title="Daftar Simbol (Bulleted List)" onclick="execWordCmd('{{ $id }}', 'insertUnorderedList')">
          <i class="fas fa-list-ul"></i>
        </button>
        <button type="button" class="word-btn" title="Daftar Angka (Numbered List)" onclick="execWordCmd('{{ $id }}', 'insertOrderedList')">
          <i class="fas fa-list-ol"></i>
        </button>
        <button type="button" class="word-btn" title="Kurangi Indent" onclick="execWordCmd('{{ $id }}', 'outdent')">
          <i class="fas fa-outdent"></i>
        </button>
        <button type="button" class="word-btn" title="Tambah Indent" onclick="execWordCmd('{{ $id }}', 'indent')">
          <i class="fas fa-indent"></i>
        </button>
      </div>

      {{-- Group 6: Insert Objects (Link, Table, Line) --}}
      <div class="flex items-center gap-0.5">
        <button type="button" class="word-btn" title="Sisipkan Tautan (Link)" onclick="insertWordLink('{{ $id }}')">
          <i class="fas fa-link text-blue-600"></i>
        </button>
        <button type="button" class="word-btn" title="Sisipkan Tabel (Insert Table)" onclick="insertWordTable('{{ $id }}')">
          <i class="fas fa-table text-emerald-600"></i>
        </button>
        <button type="button" class="word-btn" title="Garis Pembatas (Horizontal Line)" onclick="execWordCmd('{{ $id }}', 'insertHorizontalRule')">
          <i class="fas fa-minus text-slate-500"></i>
        </button>
        <button type="button" class="word-btn" title="Kutipan / Blockquote" onclick="applyWordFormatBlock('{{ $id }}', 'blockquote')">
          <i class="fas fa-quote-left text-slate-500"></i>
        </button>
      </div>

    </div>

    {{-- 3. Realistic Word Ruler Bar --}}
    <div class="bg-[#e5e7eb] border-b border-slate-300 h-4 flex items-center px-8 sm:px-16 select-none relative overflow-hidden">
      <div class="absolute left-6 w-2 h-2 border-b-2 border-r-2 border-slate-500 rotate-45" title="Margin Kiri"></div>
      <div class="w-full flex justify-between text-[9px] text-slate-500 font-mono tracking-widest opacity-60">
        <span>|</span><span>1</span><span>|</span><span>2</span><span>|</span><span>3</span><span>|</span><span>4</span><span>|</span><span>5</span><span>|</span><span>6</span><span>|</span><span>7</span><span>|</span><span>8</span><span>|</span><span>9</span><span>|</span><span>10</span><span>|</span>
      </div>
      <div class="absolute right-6 w-2 h-2 border-b-2 border-l-2 border-slate-500 -rotate-45" title="Margin Kanan"></div>
    </div>

    {{-- 4. Word Document Page Canvas --}}
    <div class="bg-[#eaedf1] p-3 sm:p-6 overflow-x-auto min-h-[340px] flex justify-center items-start">
      {{-- White Sheet of Paper --}}
      <div class="bg-white w-full max-w-3xl rounded-sm border border-slate-300 shadow-[0_4px_16px_rgba(0,0,0,0.08)] p-6 sm:p-10 transition-all min-h-[300px] flex flex-col">
        <div id="editor-{{ $id }}" 
             contenteditable="true" 
             class="word-editable-content outline-none text-slate-800 text-[14px] leading-relaxed flex-grow min-h-[240px]"
             data-placeholder="{{ $placeholder }}"
             oninput="syncWordContent('{{ $id }}')"
             onblur="syncWordContent('{{ $id }}')"
             style="font-family: 'Segoe UI', Calibri, Arial, sans-serif;">
          {!! $value ?: '' !!}
        </div>
      </div>
    </div>

    {{-- 5. Word Status Bar at the Bottom --}}
    <div class="bg-[#185abd] text-white px-3 sm:px-4 py-1.5 flex items-center justify-between text-[11px] select-none">
      <div class="flex items-center gap-3">
        <span class="flex items-center gap-1.5 opacity-95">
          <i class="far fa-file-alt text-[10px]"></i> Halaman 1 dari 1
        </span>
        <span class="opacity-40">|</span>
        <span class="flex items-center gap-1 opacity-95">
          <i class="fas fa-language text-[10px]"></i> Bahasa Indonesia
        </span>
      </div>

      <div class="flex items-center gap-3">
        <span class="font-medium bg-white/15 px-2 py-0.5 rounded text-white tracking-wide">
          <span id="word-count-{{ $id }}">0</span> Kata &bull; <span id="char-count-{{ $id }}">0</span> Karakter
        </span>
        <span class="opacity-40 hidden sm:inline">|</span>
        <span class="hidden sm:inline-flex items-center gap-1.5 opacity-90">
          <i class="fas fa-desktop text-[10px]"></i> Tata Letak Dokumen
        </span>
        <span class="opacity-40 hidden sm:inline">|</span>
        <span class="font-semibold text-[10px] hidden sm:inline">100%</span>
      </div>
    </div>

  </div>
</div>

<style>
  /* Button in Word Ribbon */
  .word-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    border-radius: 4px;
    border: 1px solid transparent;
    background: transparent;
    color: #334155;
    font-size: 12px;
    cursor: pointer;
    transition: all 0.15s ease;
  }
  .word-btn:hover {
    background: #e2e8f0;
    border-color: #cbd5e1;
    color: #0f172a;
  }
  .word-btn:active, .word-btn.active {
    background: #cbd5e1;
    border-color: #94a3b8;
    color: #185abd;
  }

  /* Dropdown in Word Ribbon */
  .word-select {
    height: 28px;
    border-radius: 4px;
    border: 1px solid #cbd5e1;
    background-color: #ffffff;
    color: #334155;
    font-size: 11px;
    padding: 2px 6px;
    outline: none;
    cursor: pointer;
    transition: border-color 0.15s;
  }
  .word-select:hover, .word-select:focus {
    border-color: #185abd;
  }

  /* Document Content Styling (Inside the sheet of paper) */
  .word-editable-content:empty:before {
    content: attr(data-placeholder);
    color: #94a3b8;
    font-style: italic;
    pointer-events: none;
    display: block;
  }
  .word-editable-content p {
    margin-bottom: 0.75rem;
    line-height: 1.6;
  }
  .word-editable-content h1 {
    font-size: 1.65rem;
    font-weight: 700;
    color: #1e3a8a;
    margin-top: 1.25rem;
    margin-bottom: 0.5rem;
    border-bottom: 1px solid #e2e8f0;
    padding-bottom: 0.25rem;
  }
  .word-editable-content h2 {
    font-size: 1.35rem;
    font-weight: 700;
    color: #1e40af;
    margin-top: 1rem;
    margin-bottom: 0.5rem;
  }
  .word-editable-content h3 {
    font-size: 1.15rem;
    font-weight: 600;
    color: #1d4ed8;
    margin-top: 0.75rem;
    margin-bottom: 0.35rem;
  }
  .word-editable-content h4 {
    font-size: 1rem;
    font-weight: 600;
    color: #334155;
    margin-top: 0.5rem;
    margin-bottom: 0.25rem;
  }
  .word-editable-content ul {
    list-style-type: disc;
    margin-left: 1.5rem;
    margin-bottom: 0.75rem;
  }
  .word-editable-content ol {
    list-style-type: decimal;
    margin-left: 1.5rem;
    margin-bottom: 0.75rem;
  }
  .word-editable-content li {
    margin-bottom: 0.25rem;
  }
  .word-editable-content blockquote {
    border-left: 4px solid #185abd;
    padding-left: 1rem;
    color: #475569;
    font-style: italic;
    margin: 1rem 0;
    background: #f8fafc;
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
    border-radius: 0 6px 6px 0;
  }
  .word-editable-content a {
    color: #185abd;
    text-decoration: underline;
  }
  .word-editable-content hr {
    border: 0;
    border-top: 1.5px solid #cbd5e1;
    margin: 1.25rem 0;
  }
  .word-editable-content table {
    width: 100%;
    border-collapse: collapse;
    margin: 1rem 0;
    font-size: 13px;
  }
  .word-editable-content table, 
  .word-editable-content th, 
  .word-editable-content td {
    border: 1px solid #cbd5e1;
  }
  .word-editable-content th {
    background-color: #f1f5f9;
    color: #1e293b;
    font-weight: 600;
    padding: 8px 12px;
    text-align: left;
  }
  .word-editable-content td {
    padding: 8px 12px;
    color: #334155;
  }
  .word-editable-content tr:nth-child(even) td {
    background-color: #f8fafc;
  }
</style>

<script>
  // Execute Document Command
  function execWordCmd(editorId, command, value = null) {
    const editor = document.getElementById('editor-' + editorId);
    if (!editor) return;
    editor.focus();
    document.execCommand(command, false, value);
    syncWordContent(editorId);
  }

  // Apply Paragraph Formatting / Heading
  function applyWordFormatBlock(editorId, tag) {
    const editor = document.getElementById('editor-' + editorId);
    if (!editor) return;
    editor.focus();
    if (tag) {
      document.execCommand('formatBlock', false, tag);
    }
    syncWordContent(editorId);
  }

  // Insert Hyperlink
  function insertWordLink(editorId) {
    const editor = document.getElementById('editor-' + editorId);
    if (!editor) return;
    editor.focus();
    const url = prompt('Masukkan URL tautan (contoh: https://example.com):', 'https://');
    if (url && url !== 'https://' && url.trim() !== '') {
      document.execCommand('createLink', false, url.trim());
      syncWordContent(editorId);
    }
  }

  // Insert Table
  function insertWordTable(editorId) {
    const editor = document.getElementById('editor-' + editorId);
    if (!editor) return;
    editor.focus();
    const rows = prompt('Jumlah Baris Tabel:', '3');
    const cols = prompt('Jumlah Kolom Tabel:', '3');
    const r = parseInt(rows) || 3;
    const c = parseInt(cols) || 3;
    
    let html = '<table style="width:100%; border-collapse:collapse; margin:12px 0;"><thead><tr>';
    for (let j = 1; j <= c; j++) {
      html += `<th style="border:1px solid #cbd5e1; padding:8px 12px; background:#f1f5f9; font-weight:600;">Kolom ${j}</th>`;
    }
    html += '</tr></thead><tbody>';
    for (let i = 1; i <= r - 1; i++) {
      html += '<tr>';
      for (let j = 1; j <= c; j++) {
        html += `<td style="border:1px solid #cbd5e1; padding:8px 12px;">Data ${i},${j}</td>`;
      }
      html += '</tr>';
    }
    html += '</tbody></table><p><br></p>';
    
    document.execCommand('insertHTML', false, html);
    syncWordContent(editorId);
  }

  // Sync content from contenteditable into hidden textarea and update word/char stats
  function syncWordContent(editorId) {
    const editor   = document.getElementById('editor-' + editorId);
    const textarea = document.getElementById(editorId);
    if (!editor || !textarea) return;

    let content = editor.innerHTML;
    // Normalize empty content
    if (content.trim() === '<p><br></p>' || content.trim() === '<br>') {
      content = '';
    }
    textarea.value = content;

    // Word and Character Counts
    const text = editor.innerText || editor.textContent || '';
    const cleanText = text.trim();
    const words = cleanText ? cleanText.split(/\s+/).filter(Boolean).length : 0;
    const chars = cleanText.length;

    const wordEl = document.getElementById('word-count-' + editorId);
    const charEl = document.getElementById('char-count-' + editorId);
    if (wordEl) wordEl.textContent = words;
    if (charEl) charEl.textContent = chars;
  }

  function focusEditorTab(editorId, tab) {
    const editor = document.getElementById('editor-' + editorId);
    if (!editor) return;
    editor.focus();
    if (tab === 'insert') {
      // Prompt quick insert options
      const choice = confirm('Ingin menyisipkan tabel ke dalam dokumen? Klik OK untuk Tabel, Batal untuk Tautan.');
      if (choice) {
        insertWordTable(editorId);
      } else {
        insertWordLink(editorId);
      }
    }
  }

  // Initialize on DOM load
  document.addEventListener('DOMContentLoaded', function () {
    const editorId = '{{ $id }}';
    const editor   = document.getElementById('editor-' + editorId);
    const textarea = document.getElementById(editorId);

    if (editor && textarea) {
      // If textarea had plain text without HTML paragraph tags, format it
      if (textarea.value && !textarea.value.includes('<')) {
        editor.innerHTML = textarea.value.split('\n\n').map(p => `<p>${p.replace(/\n/g, '<br>')}</p>`).join('');
      }
      syncWordContent(editorId);

      // Ensure form submit has the latest value
      const form = textarea.closest('form');
      if (form) {
        form.addEventListener('submit', function () {
          syncWordContent(editorId);
        });
      }
    }
  });
</script>
