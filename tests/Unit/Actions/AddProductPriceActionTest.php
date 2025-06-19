<?php

declare(strict_types=1);

use App\Actions\AddProductPriceAction;
use App\Models\Currency;
use App\Models\Price;
use App\Models\Product;

test('it adds a price to a product', function () {

    $product = Product::factory()->create();
    $currency = Currency::factory()->create();

    $data = [
        'price' => 25.50,
        'currency_id' => $currency->id,
    ];

    $action = new AddProductPriceAction();

    $updatedProduct = $action->handle($product, $data);

    expect($updatedProduct)->toBeInstanceOf(Product::class)
        ->and($updatedProduct->id)->toBe($product->id);

    // Check that the price was added to the product
    $price = $updatedProduct->prices()->latest()->first();
    expect($price)->toBeInstanceOf(Price::class)
        ->and($price->price)->toBe(25.50)
        ->and($price->currency_id)->toBe($currency->id);

    // Verify that the database was updated
    $this->assertDatabaseHas('prices', [
        'product_id' => $product->id,
        'currency_id' => $currency->id,
        'price' => 25.50,
    ]);
});
