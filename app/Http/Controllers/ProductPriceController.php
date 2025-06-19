<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\AddProductPriceAction;
use App\Http\Requests\StoreProductPriceRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

final class ProductPriceController extends Controller
{
    public function index(Product $product)
    {
        // Logic to retrieve product prices
        return $product->prices->load('currency')->toResourceCollection();
    }

    public function store(StoreProductPriceRequest $request, Product $product, AddProductPriceAction $action): JsonResponse
    {
        $validated = $request->validated();

        $action->handle($product, $validated);

        return response()->json([
            'success' => true,
            'message' => 'Product price added successfully',
            'data' => $product->prices->last()->toResource(),
        ], 201);

    }
}
