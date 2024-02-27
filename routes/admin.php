<?php


use Illuminate\Support\Facades\Route;

Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard.index');
Route::resource('tickets', \App\Http\Controllers\Admin\TicketController::class)->except('show');

