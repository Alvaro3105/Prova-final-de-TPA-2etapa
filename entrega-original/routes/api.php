<?php

use App\Http\Controllers\OrderController;
use App\Models\order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/order', [OrderController::class, 'index'] );
Route::post('/order', [OrderController::class, 'store'] );
Route::get('/order/{id}', [OrderController::class, 'update'] );
Route::put('/order/{id}', [OrderController::class, 'show'] );
Route::delete('/order/{id}', [OrderController::class, 'destroy'] );
