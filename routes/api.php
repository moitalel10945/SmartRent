<?php

use App\Http\Controllers\Api\MpesaCallbackController;
use Illuminate\Support\Facades\Route;

Route::post('/mpesa/callback', [MpesaCallbackController::class, 'handle'])
    ->name('mpesa.callback');