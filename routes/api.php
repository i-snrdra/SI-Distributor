<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;

Route::apiResource('suppliers', SupplierController::class);
Route::apiResource('products', ProductController::class);
Route::post('login', [AuthController::class, 'login']); 