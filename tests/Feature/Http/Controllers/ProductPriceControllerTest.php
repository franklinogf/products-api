<?php

declare(strict_types=1);

use App\Models\Currency;
use App\Models\Product;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->currency = Currency::factory()->create();
    $this->product = Product::factory()->create([
        'currency_id' => $this->currency->id,
    ]);

    Sanctum::actingAs($this->user);
});

it('can list all prices for a product', function () {
    // Create some additional currencies
    $currencies = Currency::factory()->count(3)->create();

    // Add prices for different currencies
    foreach ($currencies as $currency) {
        $this->product->prices()->create([
            'price' => fake()->randomFloat(2, 10, 1000),
            'currency_id' => $currency->id,
        ]);
    }

    $response = $this->getJson('/api/products/'.$this->product->id.'/prices');

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
        ])
        ->assertJsonStructure([
            'success',
            'data' => [
                '*' => [
                    'id',
                    'productId',
                    'currencyId',
                    'price',
                    'createdAt',
                    'updatedAt',
                ],
            ],
        ]);

    $response->assertJsonCount(3, 'data');
});

it('can add a price to a product', function () {
    $newCurrency = Currency::factory()->create();

    $priceData = [
        'price' => 99.99,
        'currency_id' => $newCurrency->id,
    ];

    $response = $this->postJson("/api/products/{$this->product->id}/prices", $priceData);

    $response->assertStatus(201)
        ->assertJson([
            'success' => true,
            'message' => 'Product price added successfully',
        ])
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'id',
                'productId',
                'price',
                'currencyId',
                'createdAt',
                'updatedAt',
            ],
        ]);

    $this->assertDatabaseHas('prices', [
        'product_id' => $this->product->id,
        'price' => 99.99,
        'currency_id' => $newCurrency->id,
    ]);
});

it('validates price data', function () {
    $response = $this->postJson("/api/products/{$this->product->id}/prices", []);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['price', 'currency_id']);
});

it('returns 404 when product not found for prices', function () {
    $response = $this->getJson('/api/products/999/prices');

    $response->assertStatus(404);
});
