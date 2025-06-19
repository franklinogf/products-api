<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Product;

final readonly class CreateProductAction
{
    /**
     * Execute the action.
     *
     * @param  array{name: string, description: string|null, price: float, currency_id: int, tax_cost: float, manufacturing_cost: float}  $data
     */
    public function handle(array $data): Product
    {
        return Product::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'currency_id' => $data['currency_id'],
            'tax_cost' => $data['tax_cost'],
            'manufacturing_cost' => $data['manufacturing_cost'],
        ]);

    }
}
