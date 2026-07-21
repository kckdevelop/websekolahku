<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model konfigurasi WhatsApp Gateway via Fonnte.
 *
 * Tabel: whatsapp_settings
 * Hanya 1 baris (id = 1), diakses via getSingle().
 */
class WhatsappSetting extends Model
{
    use HasFactory;

    protected $table = 'whatsapp_settings';

    protected $fillable = [
        'api_key',
        'otp_via_log',
    ];

    protected $casts = [
        'otp_via_log' => 'boolean',
    ];

    /**
     * Ambil satu-satunya record pengaturan, atau buat default jika belum ada.
     */
    public static function getSingle(): self
    {
        return self::firstOrCreate(
            ['id' => 1],
            [
                'api_key'     => env('FONNTE_TOKEN', ''),
                'otp_via_log' => (bool) env('OTP_VIA_LOG', false),
            ]
        );
    }

    /**
     * Cek apakah token Fonnte sudah dikonfigurasi.
     */
    public function isConfigured(): bool
    {
        return !empty($this->api_key);
    }
}
