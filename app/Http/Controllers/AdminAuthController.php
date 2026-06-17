<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'petugas_kesehatan') {
                return redirect()->route('petugas.kesehatan.dashboard');
            } elseif ($user->role === 'petugas_wawancara') {
                return redirect()->route('petugas.wawancara.dashboard');
            } elseif ($user->role === 'petugas_pembayaran') {
                return redirect()->route('petugas.pembayaran.dashboard');
            }
            return redirect()->route('petugas.dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => ['required'],
            'password' => ['required'],
        ]);

        $loginInput = $request->email;
        $credentials = [
            'password' => $request->password
        ];

        // Map usernames to their respective emails
        $usernameMap = [
            'kesehatan'  => 'kesehatan@admin.com',
            'wawancara'  => 'wawancara@admin.com',
            'pembayaran' => 'pembayaran@admin.com',
            'admin'      => 'admin@admin.com'
        ];

        if (array_key_exists(strtolower($loginInput), $usernameMap)) {
            $credentials['email'] = $usernameMap[strtolower($loginInput)];
        } else {
            $credentials['email'] = $loginInput;
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->role !== 'admin') {
                // All other roles redirect to their respective routes
                if ($user->role === 'petugas_kesehatan') {
                    return redirect()->route('petugas.kesehatan.dashboard');
                } elseif ($user->role === 'petugas_wawancara') {
                    return redirect()->route('petugas.wawancara.dashboard');
                } elseif ($user->role === 'petugas_pembayaran') {
                    return redirect()->route('petugas.pembayaran.dashboard');
                }
                return redirect()->route('petugas.dashboard');
            }
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Username/Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
