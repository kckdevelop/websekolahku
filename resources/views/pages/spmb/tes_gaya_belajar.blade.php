<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('storage/logomusaba.png') }}" type="image/png">
    <title>Kuesioner Gaya Belajar | SPMB</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .modal-overlay { transition: opacity 0.3s ease; }
        .modal-container { transition: opacity 0.3s ease, transform 0.3s ease; }
        .hidden-modal { opacity: 0; pointer-events: none; }
        .hidden-modal .modal-container { transform: scale(0.95); opacity: 0; }
        /* Animasi pulse untuk perhatian */
        @keyframes pulse-subtle {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }
        .animate-pulse-subtle { animation: pulse-subtle 2s infinite; }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-100 to-slate-200 min-h-screen py-8 px-4 font-sans text-gray-800">

    <div class="max-w-3xl mx-auto">
        
        <!-- Header -->
        <header class="text-center mb-8">
            <div class="inline-flex items-center gap-2 bg-indigo-100 text-indigo-700 px-4 py-2 rounded-full text-sm font-medium mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Session: {{ $pendaftaran->no_daftar }}
            </div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600 mb-2">
                🎓 Kuesioner Gaya Belajar
            </h1>
            <p class="text-gray-500">Kenali cara belajarmu untuk hasil lebih optimal</p>
        </header>

        <!-- Info Box untuk User -->
        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg mb-6">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-blue-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="text-sm text-blue-800">
                    <p class="font-semibold">Petunjuk Pengisian:</p>
                    <ul class="list-disc list-inside mt-1 space-y-1">
                        <li>Jawab semua <strong>24 pertanyaan</strong> dengan jujur</li>
                        <li>Pilih: <strong>Sering</strong> (3 poin), <strong>Kadang</strong> (2 poin), <strong>Tidak Pernah</strong> (1 poin)</li>
                        <li>Setelah kirim, hasil akan muncul di popup</li>
                        <li class="text-blue-600 font-medium">⚠️ Klik "Tutup & Keluar" untuk mengakhiri sesi</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Form Container -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <form id="quizForm" action="{{ route('spmb.tes-gaya-belajar.simpan') }}" method="POST">
                @csrf
                
                <!-- Identitas Section -->
                <div class="p-6 bg-indigo-50 border-b border-indigo-100 space-y-4">
                    <h2 class="font-bold text-indigo-800 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Data Diri Siswa
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Nomor Pendaftaran
                            </label> 
                            <div class="px-4 py-2 bg-gray-100 rounded-lg text-gray-800 font-medium">
                                {{ $pendaftaran->no_daftar }}
                            </div>
                            <input type="hidden" name="no_daftar" value="{{ $pendaftaran->no_daftar }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Nama Lengkap
                            </label>
                            <div class="px-4 py-2 bg-gray-100 rounded-lg text-gray-800 font-medium">
                                {{ $pendaftaran->nama_lengkap }}
                            </div>
                            <input type="hidden" name="nama" value="{{ $pendaftaran->nama_lengkap }}">
                            <input type="hidden" name="kelas" value="SPMB">
                        </div>
                    </div>
                </div>

                <!-- Loading State (hidden by default) -->
                <div id="loading-state" class="hidden p-8 text-center">
                    <div class="inline-flex items-center gap-3 text-indigo-600">
                        <svg class="animate-spin h-6 w-6" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="font-medium">Memproses jawaban Anda...</span>
                    </div>
                </div>

                <!-- Daftar Pertanyaan -->
                <div class="p-6 space-y-6 divide-y divide-gray-100" id="question-container">
                    <!-- Pertanyaan akan di-render oleh JavaScript -->
                </div>
                
                <!-- Cita-cita Section -->
                <div class="p-6 bg-gradient-to-r from-emerald-50 to-teal-50 border-y border-emerald-100" id="cita-cita-section">
                    <h3 class="font-bold text-emerald-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Potensi Karier / Cita-Cita Masa Depan <span class="text-red-500">*</span>
                    </h3>
                    
                    <div class="max-w-md">
                        <label for="cita_cita" class="block text-sm font-medium text-gray-700 mb-2">
                            Apa rencana Anda setelah lulus?
                        </label>
                        
                        <div class="relative">
                            <select 
                                name="cita_cita" 
                                id="cita_cita" 
                                required
                                class="w-full px-4 py-3 pr-10 bg-white border border-gray-300 rounded-xl text-gray-800 
                                       focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 
                                       appearance-none cursor-pointer transition-shadow hover:border-gray-400"
                            >
                                <option value="" disabled selected>Pilih salah satu...</option>
                                <option value="Bekerja">💼 Bekerja</option>
                                <option value="Melanjutkan Kuliah">🎓 Melanjutkan Kuliah</option>
                                <option value="Wirausaha">🚀 Wirausaha</option>
                                <option value="TNI/Polri">🛡️ TNI/Polri</option>
                            </select>
                            
                            <!-- Custom dropdown arrow -->
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <p class="text-xs text-gray-400 mt-2 ml-1">
                            Pilihan ini membantu kami memberikan rekomendasi yang lebih relevan untuk masa depan Anda.
                        </p>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="p-6 bg-gray-50 border-t border-gray-100">
                    <button type="submit" id="submit-btn" class="w-full py-4 px-6 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white text-lg font-bold rounded-xl shadow-lg transform transition hover:-translate-y-1 focus:outline-none focus:ring-4 focus:ring-indigo-300">
                        ✅ Kirim Jawaban & Lihat Hasil
                    </button>
                    <p class="text-xs text-gray-400 text-center mt-3">
                        Data Anda aman dan hanya digunakan untuk analisis gaya belajar
                    </p>
                </div>
            </form>
        </div>

        <!-- Footer Info -->
        <footer class="text-center mt-8 text-sm text-gray-400">
            <p>© 2026 Sistem Penerimaan Siswa Baru | <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-indigo-500 hover:underline">Keluar Sekarang</a></p>
        </footer>
    </div>

    <!-- Hidden Logout Form -->
    <form id="logout-form" action="{{ route('spmb.tes-gaya-belajar.logout') }}" method="POST" class="hidden">
        @csrf
    </form>

    <!-- 🔔 Modal Popup Hasil -->
    <div id="result-modal" class="fixed inset-0 z-50 overflow-y-auto hidden-modal modal-overlay flex items-center justify-center min-h-screen px-4" role="dialog" aria-modal="true" aria-labelledby="modal-title">
        <div class="fixed inset-0 bg-gray-800 bg-opacity-75 transition-opacity" onclick="closeModal()"></div>
        
        <div class="modal-container inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-2xl relative">
            
            <!-- Tombol Close (X) -->
            <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 hover:bg-gray-100 p-2 rounded-full transition" aria-label="Tutup dan keluar">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <!-- Header Modal -->
            <div class="text-center mb-6">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 id="modal-title" class="text-2xl font-bold text-gray-900">🎉 Hasil Tersimpan!</h3>
                <p class="text-sm text-gray-500 mt-1">Terima kasih telah mengisi kuesioner</p>
            </div>

            <!-- Nama Peserta -->
            <div class="bg-gray-50 rounded-xl p-4 mb-6 text-center">
                <p class="text-sm text-gray-500">Hasil untuk:</p>
                <p class="text-lg font-semibold text-gray-800" id="result-name">-</p>
            </div>

            <!-- Score Bars -->
            <div class="space-y-5 mb-6">
                <!-- Visual -->
                <div>
                    <div class="flex justify-between mb-2">
                        <span class="font-semibold text-blue-700 flex items-center gap-2">
                            <span class="w-3 h-3 bg-blue-500 rounded-full"></span> Visual
                        </span>
                        <span id="res-visual" class="font-bold text-blue-700 bg-blue-50 px-2 py-0.5 rounded">0</span>
                    </div>
                    <div class="w-full bg-blue-100 rounded-full h-3 overflow-hidden">
                        <div id="bar-visual" class="bg-blue-500 h-3 rounded-full transition-all duration-700 ease-out" style="width: 0%"></div>
                    </div>
                </div>
                
                <!-- Auditori -->
                <div>
                    <div class="flex justify-between mb-2">
                        <span class="font-semibold text-orange-600 flex items-center gap-2">
                            <span class="w-3 h-3 bg-orange-500 rounded-full"></span> Auditori
                        </span>
                        <span id="res-auditori" class="font-bold text-orange-600 bg-orange-50 px-2 py-0.5 rounded">0</span>
                    </div>
                    <div class="w-full bg-orange-100 rounded-full h-3 overflow-hidden">
                        <div id="bar-auditori" class="bg-orange-500 h-3 rounded-full transition-all duration-700 ease-out" style="width: 0%"></div>
                    </div>
                </div>
                
                <!-- Kinestetik -->
                <div>
                    <div class="flex justify-between mb-2">
                        <span class="font-semibold text-green-600 flex items-center gap-2">
                            <span class="w-3 h-3 bg-green-500 rounded-full"></span> Kinestetik
                        </span>
                        <span id="res-kinestetik" class="font-bold text-green-600 bg-green-50 px-2 py-0.5 rounded">0</span>
                    </div>
                    <div class="w-full bg-green-100 rounded-full h-3 overflow-hidden">
                        <div id="bar-kinestetik" class="bg-green-500 h-3 rounded-full transition-all duration-700 ease-out" style="width: 0%"></div>
                    </div>
                </div>
            </div>

            <!-- Dominant Style Box -->
            <div class="bg-gradient-to-r from-indigo-50 to-purple-50 p-5 rounded-xl text-center border border-indigo-100 mb-5">
                <p class="text-xs uppercase tracking-wide text-indigo-600 font-semibold mb-2">✨ Gaya Belajar Dominan Anda</p>
                <div id="res-dominan" class="text-3xl font-extrabold text-indigo-700 my-1">-</div>
                <p id="res-deskripsi" class="text-gray-600 text-sm leading-relaxed"></p>
                <p id="res-potensi" class="text-green-600 text-sm leading-relaxed mt-2"></p>
            </div>

            <!-- ⚠️ User Explanation Box -->
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-6">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-amber-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <div class="text-sm text-amber-800">
                        <p class="font-semibold">Perhatian:</p>
                        <p class="mt-1">
                            Klik tombol <strong>"Tutup & Keluar"</strong> di bawah untuk mengakhiri sesi Anda. 
                            Setelah itu, Anda akan diarahkan ke halaman login.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Tombol Tutup & Keluar -->
            <button onclick="closeModal()" 
                    class="w-full py-4 bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white font-semibold rounded-xl transition shadow-md flex items-center justify-center gap-2 focus:outline-none focus:ring-4 focus:ring-gray-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                Tutup & Keluar dari Sistem
            </button>
            
            <!-- Secondary info -->
            <p class="text-xs text-gray-400 text-center mt-4">
                Atau <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-indigo-500 hover:underline font-medium">klik di sini</a> untuk keluar sekarang
            </p>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // 📋 Data Soal - 24 pertanyaan VARK
        const questionsData = [
            { id: 1, text: "Saya lebih mudah mengingat informasi jika melihat gambar, diagram, atau grafik.", type: "V" },
            { id: 2, text: "Saat belajar, saya suka membuat catatan dengan warna-warni atau stabilo.", type: "V" },
            { id: 3, text: "Saya lebih suka membaca buku teks sendiri daripada mendengarkan penjelasan guru.", type: "V" },
            { id: 4, text: "Saya mudah terganggu jika ada gerakan yang menarik perhatian di sekitar saya.", type: "V" },
            { id: 5, text: "Saya lebih memilih presentasi yang menggunakan slide atau video.", type: "V" },
            { id: 6, text: "Saya sering melihat ke atas atau ke samping saat berpikir.", type: "V" },
            { id: 7, text: "Saya lebih suka mengerjakan tugas yang berbentuk teks atau tulisan.", type: "V" },
            { id: 8, text: "Saya mudah mengingat wajah seseorang, tetapi sering lupa namanya.", type: "V" },
            { id: 9, text: "Saya lebih mudah memahami pelajaran jika guru menjelaskan secara lisan.", type: "A" },
            { id: 10, text: "Saya suka mendengarkan musik saat belajar.", type: "A" },
            { id: 11, text: "Saya sering membaca buku dengan bersuara atau bergumam sendiri.", type: "A" },
            { id: 12, text: "Saya mudah terganggu oleh suara bising di sekitar saya.", type: "A" },
            { id: 13, text: "Saya lebih suka mendengarkan podcast daripada membaca.", type: "A" },
            { id: 14, text: "Saya lebih suka berdiskusi untuk memahami materi.", type: "A" },
            { id: 15, text: "Saya mudah mengingat nama seseorang daripada wajahnya.", type: "A" },
            { id: 16, text: "Saat menjawab pertanyaan, saya cenderung menatap ke bawah atau ke samping.", type: "A" },
            { id: 17, text: "Saya sulit duduk diam dalam waktu yang lama.", type: "K" },
            { id: 18, text: "Saya lebih suka praktikum daripada mendengarkan teori.", type: "K" },
            { id: 19, text: "Saya belajar lebih baik sambil berjalan atau melakukan sesuatu.", type: "K" },
            { id: 20, text: "Saya suka menyentuh benda-benda saat belajar.", type: "K" },
            { id: 21, text: "Saya cenderung menggunakan gerakan tangan saat berbicara.", type: "K" },
            { id: 22, text: "Saya lebih menyukai pelajaran yang dinamis seperti Olahraga atau Seni.", type: "K" },
            { id: 23, text: "Saat belajar hal baru, saya harus langsung mencobanya sendiri.", type: "K" },
            { id: 24, text: "Saya mengingat sesuatu berdasarkan apa yang saya lakukan.", type: "K" }
        ];

        // 🔀 Fisher-Yates Shuffle - acak soal
        function shuffleArray(array) {
            const shuffled = [...array];
            for (let i = shuffled.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [shuffled[i], shuffled[j]] = [shuffled[j], shuffled[i]];
            }
            return shuffled;
        }

        // 🎨 Render Soal ke HTML
        function renderQuestions() {
            const container = document.getElementById('question-container');
            const shuffled = shuffleArray(questionsData);
            let html = '';

            shuffled.forEach((q, index) => {
                html += `
                    <div class="question-card py-6 first:pt-0" id="q-card-${q.id}">
                        <div class="flex items-start gap-4 mb-4">
                            <span class="flex-shrink-0 w-8 h-8 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center font-bold text-sm">
                                ${index + 1}
                            </span>
                            <p class="text-gray-700 font-medium leading-relaxed">${q.text}</p>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-3 pl-12">
                            <label class="flex-1 cursor-pointer group">
                                <input type="radio" name="q${q.id}" value="3" class="hidden peer" required>
                                <div class="w-full text-center py-2.5 px-3 rounded-lg border-2 border-gray-200 text-gray-600 
                                            peer-checked:border-green-500 peer-checked:bg-green-50 peer-checked:text-green-700 
                                            peer-checked:font-semibold group-hover:bg-gray-50 transition-all text-sm">
                                    Sering
                                </div>
                            </label>
                            <label class="flex-1 cursor-pointer group">
                                <input type="radio" name="q${q.id}" value="2" class="hidden peer">
                                <div class="w-full text-center py-2.5 px-3 rounded-lg border-2 border-gray-200 text-gray-600 
                                            peer-checked:border-yellow-500 peer-checked:bg-yellow-50 peer-checked:text-yellow-700 
                                            peer-checked:font-semibold group-hover:bg-gray-50 transition-all text-sm">
                                    Kadang
                                </div>
                            </label>
                            <label class="flex-1 cursor-pointer group">
                                <input type="radio" name="q${q.id}" value="1" class="hidden peer">
                                <div class="w-full text-center py-2.5 px-3 rounded-lg border-2 border-gray-200 text-gray-600 
                                            peer-checked:border-red-400 peer-checked:bg-red-50 peer-checked:text-red-700 
                                            peer-checked:font-semibold group-hover:bg-gray-50 transition-all text-sm">
                                    Tidak Pernah
                                </div>
                            </label>
                        </div>
                    </div>
                `;
            });
            container.innerHTML = html;
        }

        // 🔓 Modal: Buka
        function openModal() {
            const modal = document.getElementById('result-modal');
            modal.classList.remove('hidden-modal');
            document.body.style.overflow = 'hidden'; // Prevent scroll behind modal
        }

        // 🚪 Modal: Tutup + Redirect ke logout
        function closeModal() {
            // Efek fade out halus sebelum redirect
            const modal = document.getElementById('result-modal');
            modal.style.opacity = '0';
            modal.style.pointerEvents = 'none';
            
            // Redirect setelah animasi selesai (300ms)
            setTimeout(() => {
                document.getElementById('logout-form').submit();
            }, 300);
        }

        // 📤 Handle Form Submit
        document.getElementById('quizForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validasi: semua pertanyaan harus terjawab
            const totalQuestions = questionsData.length;
            const answeredCount = document.querySelectorAll('input[type="radio"]:checked').length;
            
            if (answeredCount < totalQuestions) {
                // Highlight pertanyaan yang belum dijawab
                alert(`⚠️ Mohon jawab semua ${totalQuestions} pertanyaan sebelum mengirim.`);
                
                // Scroll ke pertanyaan pertama yang belum dijawab
                for (let q of questionsData) {
                    const checked = document.querySelector(`input[name="q${q.id}"]:checked`);
                    if (!checked) {
                        document.getElementById(`q-card-${q.id}`)?.scrollIntoView({behavior: 'smooth', block: 'center'});
                        break;
                    }
                }
                return;
            }

            // Tampilkan loading state
            const submitBtn = document.getElementById('submit-btn');
            const loadingState = document.getElementById('loading-state');
            const questionContainer = document.getElementById('question-container');
            const citaCitaSection = document.getElementById('cita-cita-section');
            
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            questionContainer.classList.add('hidden');
            citaCitaSection.classList.add('hidden');
            loadingState.classList.remove('hidden');

            const formData = new FormData(this);

            // Kirim ke backend
            fetch(this.action, {
                method: 'POST',
                headers: { 'Accept': 'application/json' },
                body: formData
            })
            .then(async response => {
                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    throw new Error('Response server tidak valid');
                }
                return response.json();
            })
            .then(data => {
                if (data.status === 'success') {
                    // Update modal dengan hasil
                    document.getElementById('result-name').textContent = data.nama;
                    document.getElementById('res-visual').textContent = data.visual;
                    document.getElementById('res-auditori').textContent = data.auditori;
                    document.getElementById('res-kinestetik').textContent = data.kinestetik;
                    document.getElementById('res-dominan').textContent = data.dominan;
                    document.getElementById('res-deskripsi').textContent = data.deskripsi;
                    document.getElementById('res-potensi').textContent = data.potensi;

                    // Animasi progress bar
                    const maxScore = 24; // 8 soal × 3 poin
                    setTimeout(() => {
                        document.getElementById('bar-visual').style.width = Math.min(100, (data.visual/maxScore)*100) + '%';
                        document.getElementById('bar-auditori').style.width = Math.min(100, (data.auditori/maxScore)*100) + '%';
                        document.getElementById('bar-kinestetik').style.width = Math.min(100, (data.kinestetik/maxScore)*100) + '%';
                    }, 150);

                    openModal();
                } else {
                    throw new Error(data.message || 'Terjadi kesalahan pada server');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert(`❌ Gagal menyimpan: ${error.message}\n\nSilakan periksa koneksi internet atau hubungi admin.`);
                
                // Restore UI
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                questionContainer.classList.remove('hidden');
                citaCitaSection.classList.remove('hidden');
                loadingState.classList.add('hidden');
            });
        });

        // 🚀 Init: Render soal saat halaman siap
        document.addEventListener('DOMContentLoaded', renderQuestions);

        // ⌨️ Keyboard shortcut: Esc untuk tutup modal + logout
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('result-modal');
                if (!modal.classList.contains('hidden-modal')) {
                    closeModal();
                }
            }
        });
    </script>
</body>
</html>
