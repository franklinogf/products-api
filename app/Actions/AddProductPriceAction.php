<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Product;

final readonly class AddProductPriceAction
{
    /**
     * Execute the action.
     */
    public function handle(Product $product, array $data): Product
    {
        $product->prices()->create([
            'price' => $data['price'],
            'currency_id' => $data['currency_id'],
        ]);

        return $product->refresh();
    }
}
