<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Currency;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class ProductSeeder extends Seeder
{
    private readonly Collection $currencies;
    private readonly Collection $categories;

    public function __construct()
    {
        $this->currencies = Currency::all();
        $this->categories = Category::all();
    }

    public function run(): void
    {        
        for ($i = 0; $i < 50; $i++) {
            Product::factory()->create([
                'category_uuid' => $this->categories->random(1)->first()->uuid,
                'currency_uuid' => $this->currencies->random(1)->first()->uuid,
            ]);
        }
    }
}
