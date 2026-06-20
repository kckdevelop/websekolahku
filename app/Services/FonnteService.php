<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * FonnteService — Kirim WhatsApp via Fonnte (api.fonnte.com)
 *
 * Endpoint: POST https://api.fonnte.com/send
 * Header  : Authorization: <token>
 *
 * KONFIGURASI diambil dari tabel nobox_settings (kolom api_key sebagai token).
 * Atau dari config/services.php => 'fonnte.token'
 */
class FonnteService
{
    protected const API_URL = 'https://api.fonnte.com/send';

    protected string $token;
    protected bool   $otpViaLog;

    public function __construct()
    {
        try {
            $setting = \App\Models\NoboxSetting::getSingle();
            $this->token     = $setting->api_key ?: config('services.fonnte.token', '');
            $this->otpViaLog = (bool) ($setting->otp_via_log ?? false);
        } catch (\Exception $e) {
            $this->token     = config('services.fonnte.token', '');
            $this->otpViaLog = false;
        }
    }

    /**
     * Format nomor WA ke format internasional (62xxx).
     */
    public static function formatNomor(string $no): string
    {
        $no = preg_replace('/\D/', '', $no);
        if (str_starts_with($no, '0')) {
            $no = '62' . substr($no, 1);
        } elseif (!str_starts_with($no, '62')) {
            $no = '62' . $no;
        }
        return $no;
    }

    /**
     * Generate OTP 6 digit angka.
     */
    public static function generateOTP(): string
    {
        return str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    /**
     * Kirim OTP via WhatsApp.
     */
    public function sendOTP(string $noWa, string $otp): bool
    {
        if ($this->otpViaLog) {
            Log::info("FonnteService [BYPASS LOG MODE]: OTP for {$noWa} is {$otp}");
            return true;
        }

        if (empty($this->token)) {
            Log::warning('FonnteService: Token Fonnte belum dikonfigurasi di pengaturan.');
            return false;
        }

        $noWa    = self::formatNomor($noWa);
        $message = "🔐 *Kode OTP SPMB SMK Muhammadiyah 1 Bantul*\n\n"
                 . "Kode verifikasi Anda: *{$otp}*\n\n"
                 . "⏱ Kode berlaku selama *5 menit*.\n"
                 . "Jangan bagikan kode ini kepada siapapun.";

        return $this->sendMessage($noWa, $message);
    }

    /**
     * Kirim pesan WhatsApp via Fonnte API.
     *
     * @param string $noWa    Nomor tujuan (format 62xxx atau 08xxx)
     * @param string $message Isi pesan teks
     */
    public function sendMessage(string $noWa, string $message): bool
    {
        $noWa = self::formatNomor($noWa);

        if (empty($this->token)) {
            Log::warning('FonnteService: Token Fonnte belum dikonfigurasi.');
            return false;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->token,
            ])
            ->timeout(15)
            ->asForm()
            ->post(self::API_URL, [
                'target'  => $noWa,
                'message' => $message,
            ]);

            Log::info('FonnteService: Kirim pesan', [
                'to'     => $noWa,
                'status' => $response->status(),
                'body'   => $response->body(),
                'token'  => substr($this->token, 0, 8) . '...',
            ]);

            $body = $response->json();

            // Fonnte mengembalikan {"status":true} jika berhasil
            if ($response->successful() && isset($body['status']) && $body['status'] === true) {
                return true;
            }

            Log::error('FonnteService: Kirim pesan gagal', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
            return false;

        } catch (\Exception $e) {
            Log::error('FonnteService: Exception: ' . $e->getMessage());
            return false;
        }
    }
}
