<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OpdController;
use App\Http\Controllers\OpdImportController;
use App\Http\Controllers\OpdExportController;

/*
|--------------------------------------------------------------------------
| Halaman Utama
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

/*
|--------------------------------------------------------------------------
| Halaman Guest (Belum Login)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.process');

});

/*
|--------------------------------------------------------------------------
| Halaman yang Membutuhkan Login
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'active.user'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Master OPD — Super Admin dan Operator
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:super_admin,operator')
        ->group(function () {

            // Form Import Excel
            Route::get('/opds/import', [OpdImportController::class, 'create'])
                ->name('opds.import.create');

            // Proses Upload Excel
            Route::post('/opds/import', [OpdImportController::class, 'store'])
                ->name('opds.import.store');

            // Preview Excel
            Route::get('/opds/import/preview', [OpdImportController::class, 'preview'])
                ->name('opds.import.preview');

            // Konfirmasi Import ke MySQL
            Route::post('/opds/import/confirm', [OpdImportController::class, 'confirm'])
                ->name('opds.import.confirm');

            // Export Excel
            Route::get('/opds/export', [OpdExportController::class, 'export'])
                ->name('opds.export');

            // CRUD Master OPD
            Route::resource('opds', OpdController::class);

        });

    /*
    |--------------------------------------------------------------------------
    | Logout — Semua Pengguna Login
    |--------------------------------------------------------------------------
    */

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

});
