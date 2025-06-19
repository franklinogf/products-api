<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Product;
use Illuminate\Database\Seeder;

final class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a few products without additional prices
        Product::factory(5)->create();

        // Create a few products with a specific currency and price
        Product::factory(5)->hasPrices(2)->create();
    }
}
