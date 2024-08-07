<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/login', '/auth/login');
Route::get('/', \App\Http\Controllers\Customer\HomeController::class)->name('home.index');
Route::get('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'create'])->name('register.index');
Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'store'])->name('register.store');
Route::resource('tickets', \App\Http\Controllers\Customer\TicketController::class)->only('index', 'create', 'store');
Route::resource('galleries', \App\Http\Controllers\Customer\GalleryController::class)->only('index');

Route::middleware('redirect.if.not.authenticated', 'must.have.role:customer')->group(function () {
    Route::resource('profile', \App\Http\Controllers\Customer\ProfileController::class)->only('create', 'store');
    Route::patch('profile/password', [\App\Http\Controllers\Customer\ProfileController::class, 'password'])->name('profile.password');
});
