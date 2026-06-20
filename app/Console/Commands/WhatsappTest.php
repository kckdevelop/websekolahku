<?php

namespace App\Console\Commands;

use App\Services\FonnteService;
use Illuminate\Console\Command;

class WhatsappTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:test
                            {nomor : Nomor WA tujuan test (format: 08xxx atau 62xxx)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test kirim pesan WhatsApp via Fonnte API';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $nomor = $this->argument('nomor');
        $noWa = FonnteService::formatNomor($nomor);
        $otp = FonnteService::generateOTP();

        $this->info("\n🔧 Fonnte WhatsApp Test Tool");
        $this->line("─────────────────────────────────────");
        $this->line("  Tujuan    : " . $noWa);
        $this->line("  OTP Test  : " . $otp);
        $this->line("─────────────────────────────────────");
        $this->newLine();

        if (!$this->confirm("Kirim pesan test ke $noWa?", true)) {
            $this->warn('Dibatalkan.');
            return self::FAILURE;
        }

        $this->info("📡 Mengirim pesan...");

        $service = new FonnteService();
        $sent = $service->sendOTP($noWa, $otp);

        $this->newLine();
        if ($sent) {
            $this->info("✅ Pesan berhasil dikirim ke WhatsApp $noWa!");
            $this->line("   OTP: $otp");
        } else {
            $this->error("❌ Gagal kirim pesan. Cek log Laravel untuk detail.");
            $this->warn("   Jalankan: php artisan tail atau cek storage/logs/laravel.log");
        }

        return $sent ? self::SUCCESS : self::FAILURE;
    }
}
