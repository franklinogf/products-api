<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\CreateProductAction;
use App\Actions\DeleteProductAction;
use App\Actions\UpdateProductAction;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

final class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResource
    {
        $products = Product::with('currency')->paginate();

        return $products->toResourceCollection();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request, CreateProductAction $action): JsonResponse
    {
        /**
         * @var array{name: string, description: string|null, price: float, currency_id: int, tax_cost: float, manufacturing_cost: float} $validated
         */
        $validated = $request->validated();

        $product = $action->handle($validated);

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'data' => $product->load('currency')->toResource(),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $product->load('currency')->toResource(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product, UpdateProductAction $action): JsonResponse
    {
        /**
         * @var array{name: string, description: string|null, price: float, currency_id: int, tax_cost: float, manufacturing_cost: float} $validated
         */
        $validated = $request->validated();

        $product = $action->handle($product, $validated);

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'data' => $product->load('currency')->toResource(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, DeleteProductAction $action): JsonResponse
    {
        $action->handle($product);

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully',
        ]);
    }
}
