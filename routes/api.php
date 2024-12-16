<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

// Routes untuk otentikasi
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Routes untuk produk
Route::get('/products', [ProductController::class, 'index']);

// Routes untuk pesanan (perlu autentikasi)
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/orders', [OrderController::class, 'create']);
    Route::post('/user/request-bind', [OrderController::class, 'requestBind']);
    Route::post('/user/request-payment', [OrderController::class, 'requestPayment']);
});