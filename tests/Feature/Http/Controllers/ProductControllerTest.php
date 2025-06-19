<?php

declare(strict_types=1);

use App\Models\Currency;
use App\Models\Product;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->currency = Currency::factory()->create();

    Sanctum::actingAs($this->user);
});

it('can list all products', function () {
    // Create some products
    Product::factory()->count(3)->create();

    $response = $this->getJson(route('products.index'));

    $response->assertStatus(200);
    $response->assertJsonCount(3, 'data');
    $response->assertJsonStructure([
        'data' => [
            '*' => [
                'id',
                'name',
                'description',
                'price',
                'taxCost',
                'manufacturingCost',
                'baseCurrency',
                'createdAt',
                'updatedAt',
            ],
        ],
        'links',
        'meta',
    ]);
});

it('can create a new product', function () {
    $productData = [
        'name' => 'Test Product',
        'description' => 'This is a test product',
        'price' => 100.00,
        'currency_id' => $this->currency->id,
        'tax_cost' => 10.00,
        'manufacturing_cost' => 50.00,
    ];

    $response = $this->postJson(route('products.index'), $productData);

    $response->assertStatus(201)
        ->assertJson([
            'success' => true,
            'message' => 'Product created successfully',
        ])
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'id',
                'name',
                'description',
                'price',
                'baseCurrency',
                'taxCost',
                'manufacturingCost',
                'createdAt',
                'updatedAt',
            ],
        ]);

    $this->assertDatabaseHas('products', [
        'name' => 'Test Product',
        'description' => 'This is a test product',
        'price' => 100.00,
        'tax_cost' => 10.00,
        'manufacturing_cost' => 50.00,
    ]);
});

it('validates product data', function () {
    $response = $this->postJson(route('products.index'), []);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['name', 'price', 'currency_id']);
});

it('can show a specific product', function () {
    $product = Product::factory()->create([
        'currency_id' => $this->currency->id,
    ]);

    $response = $this->getJson(route('products.show', $product->id));

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'data' => [
                'id' => $product->id,
                'name' => $product->name,
            ],
        ]);
});

it('can update a product', function () {
    $product = Product::factory()->create([
        'currency_id' => $this->currency->id,
    ]);

    $updatedData = [
        'name' => 'Updated Product',
        'description' => 'This is an updated description',
        'price' => 150.00,
        'currency_id' => $this->currency->id,
        'tax_cost' => 15.00,
        'manufacturing_cost' => 75.00,
    ];

    $response = $this->putJson(route('products.update', $product->id), $updatedData);

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => 'Product updated successfully',
            'data' => [
                'name' => 'Updated Product',
                'description' => 'This is an updated description',
                'price' => 150.00,
            ],
        ]);

    $this->assertDatabaseHas('products', [
        'id' => $product->id,
        'name' => 'Updated Product',
        'description' => 'This is an updated description',
    ]);
});

it('validates product update data', function () {
    $product = Product::factory()->create();

    $response = $this->putJson(route('products.update', $product->id), []);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['name', 'price', 'currency_id']);
});

it('can delete a product', function () {
    $product = Product::factory()->create();

    $response = $this->deleteJson(route('products.destroy', $product->id));

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => 'Product deleted successfully',
        ]);

    $this->assertDatabaseMissing('products', [
        'id' => $product->id,
    ]);
});

it('returns 404 when product not found', function () {
    $response = $this->getJson(route('products.show', 999));

    $response->assertStatus(404);
});
