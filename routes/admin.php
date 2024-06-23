<?php


use Illuminate\Support\Facades\Route;

Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard.index');
Route::resource('galleries', \App\Http\Controllers\Admin\GalleryController::class)->except('show', 'edit', 'update');
Route::resource('testimonials', \App\Http\Controllers\Admin\TestimonialController::class)->except('show');
Route::resource('tickets', \App\Http\Controllers\Admin\TicketController::class)->except('show');
Route::resource('transactions', \App\Http\Controllers\Admin\TransactionController::class)->except('show');
Route::resource('transactions.payments', \App\Http\Controllers\Admin\PaymentController::class)->only('update');

Route::resource('profile', \App\Http\Controllers\Admin\ProfileController::class)->only('create', 'store');
Route::patch('profile/password', [\App\Http\Controllers\Admin\ProfileController::class, 'password'])->name('profile.password');

Route::prefix('validate')->name('validate.')->group(function () {
    Route::resource('qr', \App\Http\Controllers\Admin\ValidateQrCodeController::class)->only('create', 'store');
});

