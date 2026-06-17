@extends('layouts.app')
@section('title', 'Verifikasi OTP WhatsApp - SPMB')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-blue-950 to-slate-900 flex items-center py-12 relative overflow-hidden">
  <div class="absolute -top-32 -right-32 w-80 h-80 bg-green-500/20 rounded-full blur-3xl pointer-events-none"></div>
  <div class="absolute -bottom-32 -left-32 w-80 h-80 bg-primary/10 rounded-full blur-3xl pointer-events-none"></div>

  <div class="relative z-10 w-full max-w-md mx-auto px-4">

    <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 shadow-2xl text-center">

      {{-- Icon --}}
      <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center text-white text-3xl mx-auto mb-6 shadow-lg shadow-green-500/30 animate-pulse-slow">
        <i class="fab fa-whatsapp"></i>
      </div>

      <h1 class="text-2xl font-extrabold text-white mb-2">Verifikasi WhatsApp</h1>
      <p class="text-slate-400 text-sm mb-2">
        Kode OTP telah dikirim ke nomor WhatsApp:
      </p>
      <div class="inline-flex items-center gap-2 bg-white/10 rounded-xl px-4 py-2 text-white font-mono font-bold text-lg mb-6">
        <i class="fab fa-whatsapp text-green-400"></i>
        +{{ $noWaMasked }}
      </div>

      {{-- Alerts --}}
      @if (session('success'))
        <div class="bg-emerald-500/20 border border-emerald-400/30 text-emerald-300 p-3 rounded-xl mb-4 text-sm">
          <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
      @endif
      @if (session('warning'))
        <div class="bg-amber-500/20 border border-amber-400/30 text-amber-200 p-3 rounded-xl mb-4 text-sm">
          <i class="fas fa-exclamation-triangle mr-2"></i>{!! session('warning') !!}
        </div>
      @endif
      @if ($errors->any())
        <div class="bg-red-500/20 border border-red-400/30 text-red-300 p-3 rounded-xl mb-4 text-sm">
          {{ $errors->first() }}
        </div>
      @endif

      {{-- OTP Form --}}
      <form action="{{ route('spmb.verifikasi.post') }}" method="POST" id="form-otp">
        @csrf
        <div class="mb-6">
          <label class="block text-sm font-semibold text-slate-300 mb-3">Masukkan 6 Digit Kode OTP</label>
          {{-- OTP Digits Input --}}
          <div class="flex gap-2 justify-center" id="otp-inputs">
            @for ($i = 0; $i < 6; $i++)
              <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]"
                class="otp-digit w-12 h-14 text-center text-xl font-bold bg-white/10 border-2 border-white/20 rounded-xl text-white focus:ring-2 focus:ring-primary/50 focus:border-primary outline-none transition"
                autocomplete="one-time-code">
            @endfor
          </div>
          <input type="hidden" name="otp" id="otp-hidden">
        </div>

        {{-- Countdown Timer --}}
        <div class="text-sm text-slate-400 mb-4">
          Kode berlaku: <span id="countdown" class="font-bold text-white">5:00</span>
        </div>

        <button type="submit" id="btn-verify"
          class="w-full bg-gradient-to-r from-green-500 to-emerald-600 hover:from-emerald-600 hover:to-green-500 text-white font-bold py-3.5 rounded-xl transition-all shadow-lg shadow-green-500/30 flex items-center justify-center gap-2 mb-4">
          <i class="fas fa-check-circle"></i> Verifikasi Kode OTP
        </button>
      </form>

      {{-- Resend OTP --}}
      <div id="resend-area">
        <p class="text-slate-400 text-sm">
          Tidak menerima kode?
          <button id="btn-resend" class="text-primary hover:text-orange-400 font-semibold transition-colors disabled:opacity-50 disabled:cursor-not-allowed" disabled>
            Kirim Ulang OTP
          </button>
          <span id="resend-timer" class="text-slate-500 text-xs ml-1"></span>
        </p>
      </div>

      <div class="mt-6 pt-4 border-t border-white/10">
        <a href="{{ route('spmb.register') }}" class="text-slate-400 hover:text-white text-xs transition-colors">
          <i class="fas fa-arrow-left mr-1"></i> Kembali & ubah nomor WA
        </a>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script>
  // OTP digit inputs behavior
  const digits = document.querySelectorAll('.otp-digit');
  const hiddenInput = document.getElementById('otp-hidden');

  digits.forEach((input, idx) => {
    input.addEventListener('input', function(e) {
      this.value = this.value.replace(/[^0-9]/g, '');
      updateHidden();
      if (this.value && idx < 5) digits[idx + 1].focus();
    });
    input.addEventListener('keydown', function(e) {
      if (e.key === 'Backspace' && !this.value && idx > 0) {
        digits[idx - 1].focus();
        digits[idx - 1].value = '';
        updateHidden();
      }
    });
    input.addEventListener('paste', function(e) {
      e.preventDefault();
      const pasted = e.clipboardData.getData('text').replace(/\D/g, '').slice(0, 6);
      [...pasted].forEach((char, i) => { if (digits[i]) digits[i].value = char; });
      updateHidden();
      if (digits[pasted.length - 1]) digits[pasted.length - 1].focus();
    });
  });

  function updateHidden() {
    hiddenInput.value = [...digits].map(d => d.value).join('');
  }

  // Focus first digit on load
  digits[0].focus();

  // Countdown timer 5 minutes
  let secondsLeft = 300;
  const countdownEl = document.getElementById('countdown');
  const resendBtn = document.getElementById('btn-resend');
  const resendTimer = document.getElementById('resend-timer');
  let resendCountdown = 60;

  const countdownInterval = setInterval(() => {
    secondsLeft--;
    const m = Math.floor(secondsLeft / 60);
    const s = secondsLeft % 60;
    countdownEl.textContent = `${m}:${s.toString().padStart(2, '0')}`;
    if (secondsLeft <= 60) countdownEl.classList.add('text-red-400');
    if (secondsLeft <= 0) {
      clearInterval(countdownInterval);
      countdownEl.textContent = 'Kedaluwarsa';
      countdownEl.classList.add('text-red-500');
    }
  }, 1000);

  // Resend timer (60 detik)
  const resendInterval = setInterval(() => {
    resendCountdown--;
    resendTimer.textContent = `(${resendCountdown}d)`;
    if (resendCountdown <= 0) {
      clearInterval(resendInterval);
      resendBtn.disabled = false;
      resendTimer.textContent = '';
    }
  }, 1000);

  // Resend OTP via AJAX
  resendBtn.addEventListener('click', async function() {
    this.disabled = true;
    this.textContent = 'Mengirim...';
    try {
      const res = await fetch('{{ route("spmb.resend.otp") }}', {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Content-Type': 'application/json',
          'Accept': 'application/json',
        }
      });
      const data = await res.json();
      alert(data.message);
      if (data.success) {
        // Reset countdown
        secondsLeft = 300;
        resendCountdown = 60;
        resendTimer.textContent = `(60d)`;
        const newResendInterval = setInterval(() => {
          resendCountdown--;
          resendTimer.textContent = `(${resendCountdown}d)`;
          if (resendCountdown <= 0) {
            clearInterval(newResendInterval);
            resendBtn.textContent = 'Kirim Ulang OTP';
            resendBtn.disabled = false;
            resendTimer.textContent = '';
          }
        }, 1000);
      } else {
        this.textContent = 'Kirim Ulang OTP';
        this.disabled = false;
      }
    } catch (e) {
      alert('Terjadi kesalahan. Coba lagi.');
      this.textContent = 'Kirim Ulang OTP';
      this.disabled = false;
    }
  });

  // Submit loading
  document.getElementById('form-otp').addEventListener('submit', function(e) {
    updateHidden();
    if (hiddenInput.value.length < 6) {
      e.preventDefault();
      alert('Masukkan 6 digit kode OTP terlebih dahulu.');
      return;
    }
    const btn = document.getElementById('btn-verify');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memverifikasi...';
  });
</script>
@endsection
