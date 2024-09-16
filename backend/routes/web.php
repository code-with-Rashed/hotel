<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SslCommerzController;

Route::controller(SslCommerzController::class)
    ->prefix('sslcommerz') // prefix to avoid conflicts
    ->name('sslc.')
    ->group(function () {
        Route::post('pay', 'pay')->name('pay');
        Route::post('success', 'success')->name('success');
        Route::post('failure', 'failure')->name('failure');
        Route::post('cancel', 'cancel')->name('cancel');
        Route::post('ipn', 'ipn')->name('ipn');
    });
