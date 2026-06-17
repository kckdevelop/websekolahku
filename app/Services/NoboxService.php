<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * NoboxService — Kirim WhatsApp via Nobox.ai (id.nobox.ai)
 *
 * Endpoint: POST https://id.nobox.ai/Inbox/Send
 *
 * KONFIGURASI di .env:
 *   NOBOX_ACCOUNT_IDS = 812975583269637              (Account ID dari dashboard Nobox)
 *   NOBOX_API_KEY     = Nobox-621029bdae6e454bb671d96c9b7bbc91  (x-api-key dari Postman)
 *   NOBOX_API_URL     = https://id.nobox.ai
 *   NOBOX_CHANNEL_ID  = 1
 */
class NoboxService
{
    protected string $accountIds;
    protected string $baseUrl;
    protected string $channelId;
    protected string $apiKey;

    public function __construct()
    {
        try {
            $setting = \App\Models\NoboxSetting::getSingle();
            $this->accountIds = $setting->account_ids ?: config('services.nobox.account_ids', '812975583269637');
            $this->baseUrl    = rtrim($setting->url ?: config('services.nobox.url', 'https://id.nobox.ai'), '/');
            $this->channelId  = $setting->channel_id ?: config('services.nobox.channel_id', '1');
            $this->apiKey     = $setting->api_key ?: config('services.nobox.api_key', '');
        } catch (\Exception $e) {
            $this->accountIds = config('services.nobox.account_ids', '812975583269637');
            $this->baseUrl    = rtrim(config('services.nobox.url', 'https://id.nobox.ai'), '/');
            $this->channelId  = config('services.nobox.channel_id', '1');
            $this->apiKey     = config('services.nobox.api_key', '');
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
     * Kirim OTP via WhatsApp menggunakan endpoint /Inbox/Send.
     */
    public function sendOTP(string $noWa, string $otp): bool
    {
        if (empty($this->accountIds)) {
            Log::warning('NoboxService: NOBOX_ACCOUNT_IDS belum dikonfigurasi di .env');
            return false;
        }

        $noWa = self::formatNomor($noWa);

        $message = "🔐 *Kode OTP SPMB SMK Muhammadiyah 1 Bantul*\n\n"
                 . "Kode verifikasi Anda: *{$otp}*\n\n"
                 . "⏱ Kode berlaku selama *5 menit*.\n"
                 . "Jangan bagikan kode ini kepada siapapun.";

        return $this->sendMessage($noWa, $message);
    }

    /**
     * Kirim pesan WhatsApp via endpoint /Inbox/Send.
     *
     * @param string $noWa    Nomor tujuan (format 62xxx atau 08xxx)
     * @param string $message Isi pesan teks
     */
    public function sendMessage(string $noWa, string $message): bool
    {
        $noWa = self::formatNomor($noWa);

        // Bangun headers — x-api-key wajib ada
        $headers = [
            'Content-Type' => 'application/json',
            'Accept'       => 'application/json',
        ];

        if (!empty($this->apiKey)) {
            $headers['x-api-key'] = $this->apiKey;
        } else {
            Log::warning('NoboxService: NOBOX_API_KEY belum dikonfigurasi di .env');
        }

        try {
            $response = Http::withHeaders($headers)
                ->timeout(15)
                ->post($this->baseUrl . '/Inbox/Send', [
                    'ExtId'      => $noWa,
                    'ChannelId'  => $this->channelId,
                    'AccountIds' => $this->accountIds,
                    'BodyType'   => 'Text',
                    'Body'       => $message,
                    'Attachment' => '',
                ]);

            Log::info('NoboxService: Kirim pesan', [
                'to'         => $noWa,
                'status'     => $response->status(),
                'body'       => $response->body(),
                'accountIds' => $this->accountIds,
                'apiKey'     => substr($this->apiKey, 0, 12) . '...',
            ]);

            if ($response->successful()) {
                return true;
            }

            Log::error('NoboxService: Kirim pesan gagal', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
            return false;

        } catch (\Exception $e) {
            Log::error('NoboxService: Exception: ' . $e->getMessage());
            return false;
        }
    }
}
