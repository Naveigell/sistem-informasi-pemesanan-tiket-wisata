<?php


use Illuminate\Support\Facades\Route;

// TODO: create transaction for customer
Route::resource('transactions', \App\Http\Controllers\Customer\TransactionController::class);
