<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class SiswaAkun extends Model
{
    use HasFactory;

    protected $table = 'siswa_akuns';

    protected $fillable = [
        'no_wa',
        'password',
        'is_verified',
        'otp_code',
        'otp_expires_at',
        'last_otp_sent_at',
        'tahun_aktif',
    ];

    protected $hidden = [
        'password',
        'otp_code',
    ];

    protected $casts = [
        'is_verified'      => 'boolean',
        'otp_expires_at'   => 'datetime',
        'last_otp_sent_at' => 'datetime',
    ];

    /**
     * Relasi ke pendaftaran (1 akun = max 1 pendaftaran per tahun).
     */
    public function pendaftaran()
    {
        return $this->hasOne(Pendaftaran::class, 'siswa_akun_id');
    }

    /**
     * Cek apakah OTP masih valid.
     */
    public function isOtpValid(string $otp): bool
    {
        return $this->otp_code === $otp
            && $this->otp_expires_at
            && $this->otp_expires_at->isFuture();
    }

    /**
     * Cek apakah boleh kirim OTP lagi (rate limit 60 detik).
     */
    public function canResendOtp(): bool
    {
        if (!$this->last_otp_sent_at) {
            return true;
        }
        return $this->last_otp_sent_at->diffInSeconds(now()) >= 60;
    }
}
