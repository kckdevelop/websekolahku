<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
use App\Models\SchoolSetting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS jika diakses lewat SSL / Reverse Proxy
        if (request()->server('HTTP_X_FORWARDED_PROTO') == 'https' || request()->isSecure()) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Set Carbon locale ke Bahasa Indonesia
        Carbon::setLocale('id');
        setlocale(LC_TIME, 'id_ID.UTF-8', 'id_ID', 'Indonesian');

        // Inject $schoolSetting ke semua view (layout admin, app, petugas)
        View::composer('*', function ($view) {
            try {
                $view->with('schoolSetting', SchoolSetting::getSingle());
            } catch (\Exception $e) {
                // Jika tabel belum ada (misal saat fresh migrate), buat fallback object
                $view->with('schoolSetting', new SchoolSetting([
                    'nama_sekolah' => 'SMK Muhammadiyah 1 Bantul',
                    'singkatan'    => 'SMK MUSABA',
                    'logo'         => null,
                    'favicon'      => null,
                ]));
            }
        });
    }
}
