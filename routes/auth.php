<?php

use Illuminate\Support\Facades\Route;

Route::name('login.')->prefix('login')->group(function () {
    Route::post('/', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('store');
    Route::view('/', 'auth.login')->name('index');
});
