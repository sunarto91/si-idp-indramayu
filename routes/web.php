<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OpdController;
use App\Http\Controllers\DashboardController;

// Halaman utama
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Halaman untuk pengguna yang belum login
Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.process');

});

// Halaman yang membutuhkan autentikasi
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Master OPD
    Route::resource('opds', OpdController::class);

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

});
