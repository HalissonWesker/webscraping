<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CurrencyController;

Route::post('/currency', [CurrencyController::class, 'getCurrencyData']);

