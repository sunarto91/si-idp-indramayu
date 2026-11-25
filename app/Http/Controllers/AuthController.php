<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Memproses login pengguna
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $key = Str::lower($request->input('email'))
            . '|' . $request->ip();

        // Membatasi percobaan login
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);

            return back()->withErrors([
                'email' => "Terlalu banyak percobaan login.
                Silakan coba lagi dalam {$seconds} detik.",
            ])->onlyInput('email');
        }

        // Memeriksa email dan password
        if (Auth::attempt([
                'email' => $credentials['email'],
                'password' => $credentials['password'],
                'is_active' => true,
            ])) {

            RateLimiter::clear($key);


            // Catat waktu login terakhir.
            $request->user()->forceFill([
                'last_login_at' => now(),
            ])->save();

             // Regenerasi session untuk keamanan.
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        RateLimiter::hit($key, 60);

        return back()->withErrors([
            'email' => 'Email atau password tidak sesuai.',
        ])->onlyInput('email');
    }

    // Memproses logout pengguna
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
