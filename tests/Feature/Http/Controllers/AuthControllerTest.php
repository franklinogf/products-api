<?php

declare(strict_types=1);

use App\Models\User;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    $this->user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => 'password123',
    ]);
});

it('can login with valid credentials', function () {
    $response = $this->postJson('/api/login', [
        'email' => 'test@example.com',
        'password' => 'password123',
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'token',
            ],
        ])
        ->assertJson([
            'success' => true,
            'message' => 'Login successful',
        ]);
});

it('rejects login with invalid credentials', function () {
    $response = $this->postJson('/api/login', [
        'email' => 'test@example.com',
        'password' => 'wrong-password',
    ]);

    $response->assertStatus(401)
        ->assertJson([
            'success' => false,
            'message' => 'Invalid credentials',
        ]);
});

it('requires email and password to login', function () {
    $response = $this->postJson('/api/login', []);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['email', 'password']);
});

it('can logout successfully', function () {
    Sanctum::actingAs($this->user);

    $response = $this->deleteJson('/api/logout');

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => 'Logout successful',
        ]);

    $this->assertDatabaseCount('personal_access_tokens', 0);
});

it('requires authentication to logout', function () {
    $response = $this->deleteJson('/api/logout');

    $response->assertStatus(401);
});
