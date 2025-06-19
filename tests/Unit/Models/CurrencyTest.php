<?php

declare(strict_types=1);

use App\Models\Currency;

it('has the expected properties', function () {
    $currency = Currency::factory()->create()->fresh();

    expect(array_keys($currency->toArray()))->toBe([
        'id',
        'name',
        'symbol',
        'exchange_rate',
        'created_at',
        'updated_at',
    ]);

});

it('has the expected relationships', function () {
    $currency = Currency::factory()->hasProducts(3)->create()->fresh();

    expect($currency->products)->toBeInstanceOf(Illuminate\Database\Eloquent\Collection::class);
    expect($currency->products->first())->toBeInstanceOf(App\Models\Product::class);
});
