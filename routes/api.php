<?php

declare(strict_types=1);

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductPriceController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'store'])->name('login');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::delete('/logout', [AuthController::class, 'destroy'])->name('logout');
    Route::apiResource('products', ProductController::class);

    Route::get('/products/{product}/prices', [ProductPriceController::class, 'index'])->name('products.prices.index');

    Route::post('/products/{product}/prices', [ProductPriceController::class, 'store'])->name('products.prices.store');

});
