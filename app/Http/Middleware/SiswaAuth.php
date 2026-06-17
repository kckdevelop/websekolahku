<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SiswaAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('siswa_akun_id')) {
            return redirect()->route('spmb.login')
                ->with('info', 'Silakan login terlebih dahulu untuk mengisi formulir pendaftaran.');
        }

        return $next($request);
    }
}
