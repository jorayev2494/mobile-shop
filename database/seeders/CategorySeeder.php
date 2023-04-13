<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    private array $categories = [
        'chair',
        'table',
        'armchair',
        'bed',
        'sofa',
    ];

    public function run(): void
    {
        Category::factory()->createMany(
            array_map(
                static fn (string $value): array => compact('value'),
                $this->categories
            )
        );
    }
}
