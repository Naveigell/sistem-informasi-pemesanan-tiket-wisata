<?php

Route::resource('payments', \App\Http\Controllers\Guest\PaymentController::class)->only('create', 'store');
