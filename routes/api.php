<?php

use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

// O Laravel aplica o prefixo /api automaticamente a este arquivo.
Route::apiResource('orders', OrderController::class);
