<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

final class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Currency::factory()->create([
            'name' => 'US Dollar',
            'symbol' => '$',
            'exchange_rate' => 1.0,
        ]);

        Currency::factory()->create([
            'name' => 'Euro',
            'symbol' => '€',
            'exchange_rate' => 0.85,
        ]);

        Currency::factory()->create([
            'name' => 'British Pound',
            'symbol' => '£',
            'exchange_rate' => 0.75,
        ]);
    }
}
