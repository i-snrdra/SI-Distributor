<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductController;

Route::apiResource('suppliers', SupplierController::class);
Route::apiResource('products', ProductController::class); 