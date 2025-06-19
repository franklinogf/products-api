<?php

declare(strict_types=1);

use App\Models\Currency;
use App\Models\Price;

it('has the expected properties', function () {
    $price = Price::factory()->create()->fresh();

    expect(array_keys($price->toArray()))->toBe([
        'id',
        'product_id',
        'currency_id',
        'price',
        'created_at',
        'updated_at',
    ]);

});

it('has the expected relationships', function () {
    $price = Price::factory()->create()->fresh();

    expect($price->product)->toBeInstanceOf(App\Models\Product::class);
    expect($price->currency)->toBeInstanceOf(Currency::class);
});
