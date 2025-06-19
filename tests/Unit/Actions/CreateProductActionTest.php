<?php

declare(strict_types=1);

use App\Actions\CreateProductAction;
use App\Models\Currency;
use App\Models\Product;

test('it creates a product', function () {

    $currency = Currency::factory()->create();
    $data = [
        'name' => 'Test Product',
        'description' => 'A test product description',
        'price' => 19.99,
        'currency_id' => $currency->id,
        'tax_cost' => 1.99,
        'manufacturing_cost' => 5.99,
    ];

    $action = new CreateProductAction();

    $product = $action->handle($data);

    expect($product)->toBeInstanceOf(Product::class)
        ->and($product->exists)->toBeTrue()
        ->and($product->name)->toBe('Test Product')
        ->and($product->description)->toBe('A test product description')
        ->and($product->price)->toBe(19.99)
        ->and($product->currency_id)->toBe($currency->id)
        ->and($product->tax_cost)->toBe(1.99)
        ->and($product->manufacturing_cost)->toBe(5.99);
});
