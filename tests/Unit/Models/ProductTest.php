<?php

declare(strict_types=1);

use App\Models\Currency;
use App\Models\Price;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

it('has the expected properties', function () {
    $product = Product::factory()->create()->fresh();

    expect(array_keys($product->toArray()))->toBe([
        'id',
        'name',
        'description',
        'price',
        'currency_id',
        'tax_cost',
        'manufacturing_cost',
        'created_at',
        'updated_at',
    ]);

});

it('has the expected relationships', function () {
    $product = Product::factory()->hasPrices(3)->create()->fresh();

    expect($product->currency)->toBeInstanceOf(Currency::class);
    expect($product->prices)->toBeInstanceOf(Collection::class);
    expect($product->prices->first())->toBeInstanceOf(Price::class);
});
