<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

final readonly class UpdateProductAction
{
    /**
     * Execute the action.
     *
     * @param  array{name: string, description: string|null, price: float, currency_id: int, tax_cost: float, manufacturing_cost: float}  $data
     */
    public function handle(Product $product, array $data): Product
    {
        return DB::transaction(function () use ($product, $data): Product {
            $product->update([
                'name' => $data['name'],
                'description' => $data['description'],
                'price' => $data['price'],
                'currency_id' => $data['currency_id'],
                'tax_cost' => $data['tax_cost'],
                'manufacturing_cost' => $data['manufacturing_cost'],
            ]);

            return $product->refresh();
        });
    }
}
