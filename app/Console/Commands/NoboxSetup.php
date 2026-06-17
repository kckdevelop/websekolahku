<?php

namespace App\Console\Commands;

use App\Services\NoboxService;
use Illuminate\Console\Command;

class NoboxSetup extends Command
{
    protected $signature = 'nobox:test
                            {nomor : Nomor WA tujuan test (format: 08xxx atau 62xxx)}
                            {--account-ids= : Override NOBOX_ACCOUNT_IDS (opsional)}';

    protected $description = 'Test kirim pesan WhatsApp via Nobox.ai (endpoint /Inbox/Send)';

    public function handle(): int
    {
        $nomor = $this->argument('nomor');
        $accountIds = $this->option('account-ids')
            ?? config('services.nobox.account_ids', '812975583269637');

        $noWa = NoboxService::formatNomor($nomor);
        $otp = NoboxService::generateOTP();

        $this->info("\n🔧 Nobox.ai Test Tool");
        $this->line("─────────────────────────────────────");
        $this->line("  Endpoint  : " . config('services.nobox.url') . "/Inbox/Send");
        $this->line("  AccountIds: " . $accountIds);
        $this->line("  Tujuan    : " . $noWa);
        $this->line("  OTP Test  : " . $otp);
        $this->line("─────────────────────────────────────");
        $this->newLine();

        if (!$this->confirm("Kirim pesan test ke $noWa?", true)) {
            $this->warn('Dibatalkan.');
            return self::FAILURE;
        }

        $this->info("📡 Mengirim pesan...");

        $service = new NoboxService();

        // Override accountIds jika ada opsi
        if ($this->option('account-ids')) {
            // Buat instance dengan refleksi untuk override protected property
            $reflection = new \ReflectionProperty($service, 'accountIds');
            $reflection->setAccessible(true);
            $reflection->setValue($service, $accountIds);
        }

        $sent = $service->sendOTP($noWa, $otp);

        $this->newLine();
        if ($sent) {
            $this->info("✅ Pesan berhasil dikirim ke WhatsApp $noWa!");
            $this->line("   OTP: $otp");
        } else {
            $this->error("❌ Gagal kirim pesan. Cek log Laravel untuk detail.");
            $this->warn("   Jalankan: php artisan tail  atau cek storage/logs/laravel.log");
            $this->newLine();
            $this->line("Pastikan:");
            $this->line("  1. NOBOX_ACCOUNT_IDS di .env sudah benar (saat ini: $accountIds)");
            $this->line("  2. Nomor WA $noWa aktif dan bisa menerima pesan");
            $this->line("  3. Akun Nobox sudah aktif di https://id.nobox.ai");
        }

        return $sent ? self::SUCCESS : self::FAILURE;
    }
}
