<?php

declare(strict_types=1);

use App\Actions\UpdateProductAction;
use App\Models\Currency;
use App\Models\Product;

test('it updates a product', function () {

    $currentCurrency = Currency::factory()->create();
    $newCurrency = Currency::factory()->create();

    $product = Product::factory()->create([
        'name' => 'Original Product',
        'description' => 'Original description',
        'price' => 10.00,
        'currency_id' => $currentCurrency->id,
        'tax_cost' => 1.00,
        'manufacturing_cost' => 3.00,
    ]);

    $newCurrency = Currency::factory()->create()->fresh();

    $data = [
        'name' => 'Updated Product',
        'description' => 'Updated description',
        'price' => 29.99,
        'currency_id' => $newCurrency->id,
        'tax_cost' => 2.99,
        'manufacturing_cost' => 8.99,
    ];

    $action = new UpdateProductAction();

    $updatedProduct = $action->handle($product, $data);

    expect($updatedProduct)->toBeInstanceOf(Product::class)
        ->and($updatedProduct->id)->toBe($product->id)
        ->and($updatedProduct->name)->toBe('Updated Product')
        ->and($updatedProduct->description)->toBe('Updated description')
        ->and($updatedProduct->price)->toBe(29.99)
        ->and($updatedProduct->currency_id)->toBe($newCurrency->id)
        ->and($updatedProduct->tax_cost)->toBe(2.99)
        ->and($updatedProduct->manufacturing_cost)->toBe(8.99);

    $this->assertDatabaseHas('products', [
        'id' => $product->id,
        'name' => 'Updated Product',
        'description' => 'Updated description',
        'price' => 29.99,
        'currency_id' => $newCurrency->id,
        'tax_cost' => 2.99,
        'manufacturing_cost' => 8.99,
    ]);
});
