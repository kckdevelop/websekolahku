<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetugasAuth
{
    /**
     * Middleware untuk panel petugas pendaftaran.
     * Memperbolehkan akses bagi user yang sudah login dengan role 'petugas' ATAU 'admin'.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        if (!in_array($user->role, ['petugas', 'admin'])) {
            Auth::logout();
            return redirect()->route('login')
                ->with('error', 'Akun Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
