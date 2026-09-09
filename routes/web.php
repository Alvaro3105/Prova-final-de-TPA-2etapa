<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'aplicacao' => 'Prova TPA - Pedidos',
        'api' => '/api/orders',
    ]);
});
