
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OpdController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('opds', OpdController::class);
