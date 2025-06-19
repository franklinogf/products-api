<?php

declare(strict_types=1);

use App\Models\User;

it('has the expected properties', function () {
    $currency = User::factory()->create()->fresh();

    expect(array_keys($currency->toArray()))->toBe([
        'id',
        'name',
        'email',
        'email_verified_at',
        'created_at',
        'updated_at',
    ]);

});
