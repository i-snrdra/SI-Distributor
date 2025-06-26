<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanController;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('suppliers', SupplierController::class);
    Route::apiResource('products', ProductController::class);
    Route::apiResource('pembelians', PembelianController::class);
    Route::apiResource('penjualans', PenjualanController::class);
});
Route::post('login', [AuthController::class, 'login']); 