<?php

declare(strict_types=1);

use App\Actions\DeleteProductAction;
use App\Models\Product;

test('it deletes a product', function () {
    $product = Product::factory()->create();

    $productId = $product->id;

    $action = new DeleteProductAction();

    $action->handle($product);

    $this->assertDatabaseMissing('products', [
        'id' => $productId,
    ]);

    expect(Product::find($productId))->toBeNull();
});
