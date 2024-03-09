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
Route::view('/', 'customer.pages.home.index')->name('home.index');
Route::resource('tickets', \App\Http\Controllers\Customer\TicketController::class)->only('index', 'create', 'store');
