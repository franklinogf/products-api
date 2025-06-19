<?php

declare(strict_types=1);

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductPriceController;
use Illuminate\Support\Facades\Route;

Route::apiResource('products', ProductController::class);

Route::get('/products/{product}/prices', [ProductPriceController::class, 'index'])
    ->name('products.prices.index');
Route::post('/products/{product}/prices', [ProductPriceController::class, 'store'])
    ->name('products.prices.store');
