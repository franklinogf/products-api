<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Product;

final readonly class DeleteProductAction
{
    /**
     * Execute the action.
     */
    public function handle(Product $product): void
    {
        $product->delete();
    }
}
