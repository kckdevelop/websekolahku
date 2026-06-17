<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoboxSetting extends Model
{
    use HasFactory;

    protected $table = 'nobox_settings';

    protected $fillable = [
        'account_ids',
        'api_key',
        'channel_id',
        'url',
        'otp_via_log',
    ];

    protected $casts = [
        'otp_via_log' => 'boolean',
    ];

    /**
     * Retrieve the single NoboxSetting record, or initialize and return a default one.
     */
    public static function getSingle(): self
    {
        return self::firstOrCreate(
            ['id' => 1],
            [
                'account_ids' => config('services.nobox.account_ids', '812975583269637'),
                'api_key'     => config('services.nobox.api_key', 'Nobox-621029bdae6e454bb671d96c9b7bbc91'),
                'channel_id'  => config('services.nobox.channel_id', '1'),
                'url'         => config('services.nobox.url', 'https://id.nobox.ai'),
                'otp_via_log' => env('OTP_VIA_LOG', false),
            ]
        );
    }
}
