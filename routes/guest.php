<?php

Route::resource('payments', \App\Http\Controllers\Guest\PaymentController::class)->only('create', 'store');
Route::resource('transactions', \App\Http\Controllers\Guest\TransactionController::class)->only('show');
