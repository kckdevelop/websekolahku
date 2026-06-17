<?php

namespace App\Http\Controllers;

use App\Models\SiswaAkun;
use App\Services\NoboxService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SiswaAuthController extends Controller
{
    // ──────────────────────────────────────────────
    // REGISTER
    // ──────────────────────────────────────────────

    public function showRegister()
    {
        // Jika sudah login, redirect ke formulir
        if (session('siswa_akun_id')) {
            return redirect()->route('spmb.formulir');
        }
        return view('pages.spmb.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'no_wa'                 => 'required|string|min:10|max:15',
            'password'              => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ], [
            'no_wa.required'             => 'Nomor WhatsApp wajib diisi.',
            'no_wa.min'                  => 'Nomor WhatsApp minimal 10 digit.',
            'password.required'          => 'Password wajib diisi.',
            'password.min'               => 'Password minimal 8 karakter.',
            'password.confirmed'         => 'Konfirmasi password tidak cocok.',
            'password_confirmation.required' => 'Konfirmasi password wajib diisi.',
        ]);

        // Format nomor WA ke 62xxx
        $noWa = NoboxService::formatNomor($request->no_wa);

        // Cek apakah nomor sudah terdaftar di tahun aktif
        $existing = SiswaAkun::where('no_wa', $noWa)
            ->where('tahun_aktif', date('Y'))
            ->first();

        if ($existing) {
            if ($existing->is_verified) {
                return back()->withErrors(['no_wa' => 'Nomor WA ini sudah terdaftar. Silakan login.'])->withInput();
            }
            // Sudah ada tapi belum verifikasi — lanjut ke OTP
            $siswa = $existing;
        } else {
            $siswa = SiswaAkun::create([
                'no_wa'       => $noWa,
                'password'    => Hash::make($request->password),
                'is_verified' => false,
                'tahun_aktif' => date('Y'),
            ]);
        }

        // Kirim OTP
        $otp = NoboxService::generateOTP();
        $siswa->update([
            'otp_code'         => $otp,
            'otp_expires_at'   => now()->addMinutes(5),
            'last_otp_sent_at' => now(),
        ]);

        $service = new NoboxService();
        $sent = $service->sendOTP($noWa, $otp);

        // Simpan ID di session untuk lanjut ke verifikasi
        session(['siswa_pending_id' => $siswa->id]);

        $setting = \App\Models\NoboxSetting::getSingle();
        $otpViaLog = $setting->otp_via_log;

        if ($otpViaLog) {
            // Mode dev / bypass: tampilkan OTP di pesan
            return redirect()->route('spmb.verifikasi')
                ->with('warning', "OTP Anda: <strong>{$otp}</strong> — Masukkan kode ini untuk melanjutkan.");
        }

        if (!$sent) {
            return redirect()->route('spmb.verifikasi')
                ->with('warning', 'Gagal mengirim OTP via WhatsApp. Coba kirim ulang jika tidak menerima pesan.');
        }

        return redirect()->route('spmb.verifikasi')
            ->with('success', 'Kode OTP telah dikirim ke WhatsApp ' . $this->maskNomor($noWa) . '. Cek WA Anda.');
    }

    // ──────────────────────────────────────────────
    // VERIFIKASI OTP
    // ──────────────────────────────────────────────

    public function showVerifikasi()
    {
        $siswaId = session('siswa_pending_id');
        if (!$siswaId) {
            return redirect()->route('spmb.register');
        }
        $siswa = SiswaAkun::find($siswaId);
        if (!$siswa || $siswa->is_verified) {
            return redirect()->route('spmb.login');
        }
        return view('pages.spmb.verifikasi', ['noWaMasked' => $this->maskNomor($siswa->no_wa)]);
    }

    public function verifikasi(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ], [
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.size'     => 'Kode OTP harus 6 digit.',
        ]);

        $siswaId = session('siswa_pending_id');
        if (!$siswaId) {
            return redirect()->route('spmb.register');
        }

        $siswa = SiswaAkun::findOrFail($siswaId);

        if (!$siswa->isOtpValid($request->otp)) {
            return back()->withErrors(['otp' => 'Kode OTP tidak valid atau sudah kedaluwarsa.']);
        }

        // Tandai verified & login
        $siswa->update([
            'is_verified'    => true,
            'otp_code'       => null,
            'otp_expires_at' => null,
        ]);

        session()->forget('siswa_pending_id');
        session(['siswa_akun_id' => $siswa->id]);

        return redirect()->route('spmb.formulir')
            ->with('success', 'Akun berhasil diverifikasi! Silakan isi formulir pendaftaran.');
    }

    public function resendOTP(Request $request)
    {
        $siswaId = session('siswa_pending_id');
        if (!$siswaId) {
            return response()->json(['success' => false, 'message' => 'Sesi tidak valid.'], 422);
        }

        $siswa = SiswaAkun::findOrFail($siswaId);

        if (!$siswa->canResendOtp()) {
            $sisaDetik = 60 - $siswa->last_otp_sent_at->diffInSeconds(now());
            return response()->json([
                'success' => false,
                'message' => "Tunggu {$sisaDetik} detik sebelum kirim ulang OTP.",
            ], 429);
        }

        $otp = NoboxService::generateOTP();
        $siswa->update([
            'otp_code'         => $otp,
            'otp_expires_at'   => now()->addMinutes(5),
            'last_otp_sent_at' => now(),
        ]);

        $service = new NoboxService();
        $sent = $service->sendOTP($siswa->no_wa, $otp);

        $setting = \App\Models\NoboxSetting::getSingle();
        $otpViaLog = $setting->otp_via_log;

        return response()->json([
            'success' => true,
            'message' => $otpViaLog
                ? "OTP baru: {$otp} — masukkan kode ini."
                : ($sent ? 'OTP berhasil dikirim ulang ke WhatsApp Anda.' : 'Gagal kirim OTP. Coba lagi nanti.'),
        ]);
    }

    // ──────────────────────────────────────────────
    // LOGIN
    // ──────────────────────────────────────────────

    public function showLogin()
    {
        if (session('siswa_akun_id')) {
            return redirect()->route('spmb.formulir');
        }
        return view('pages.spmb.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'no_wa'    => 'required|string',
            'password' => 'required|string',
        ], [
            'no_wa.required'    => 'Nomor WhatsApp wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $noWa = NoboxService::formatNomor($request->no_wa);

        $siswa = SiswaAkun::where('no_wa', $noWa)
            ->where('tahun_aktif', date('Y'))
            ->first();

        if (!$siswa || !Hash::check($request->password, $siswa->password)) {
            return back()->withErrors(['no_wa' => 'Nomor WA atau password salah.'])->withInput();
        }

        if (!$siswa->is_verified) {
            session(['siswa_pending_id' => $siswa->id]);
            return redirect()->route('spmb.verifikasi')
                ->with('warning', 'Akun belum terverifikasi. Silakan masukkan kode OTP yang dikirim ke WhatsApp Anda.');
        }

        session(['siswa_akun_id' => $siswa->id]);

        // Jika sudah ada pendaftaran, redirect ke sukses
        if ($siswa->pendaftaran) {
            return redirect()->route('spmb.sukses', $siswa->pendaftaran->id)
                ->with('info', 'Anda sudah melakukan pendaftaran. Berikut bukti pendaftaran Anda.');
        }

        return redirect()->route('spmb.formulir')
            ->with('success', 'Login berhasil! Silakan lanjutkan mengisi formulir pendaftaran.');
    }

    public function logout(Request $request)
    {
        session()->forget(['siswa_akun_id', 'siswa_pending_id', 'spmb_form_data']);
        return redirect()->route('spmb.daftar')
            ->with('success', 'Anda telah berhasil logout.');
    }

    // ──────────────────────────────────────────────
    // HELPER
    // ──────────────────────────────────────────────

    private function maskNomor(string $no): string
    {
        // Tampilkan: 628x*****789
        if (strlen($no) < 6) return $no;
        return substr($no, 0, 5) . str_repeat('*', strlen($no) - 8) . substr($no, -3);
    }
}
