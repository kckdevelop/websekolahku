<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'siswa.auth'   => \App\Http\Middleware\SiswaAuth::class,
            'petugas.auth' => \App\Http\Middleware\PetugasAuth::class,
            'petugas.kesehatan.auth'  => \App\Http\Middleware\PetugasKesehatanAuth::class,
            'petugas.wawancara.auth'  => \App\Http\Middleware\PetugasWawancaraAuth::class,
            'petugas.pembayaran.auth' => \App\Http\Middleware\PetugasPembayaranAuth::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
