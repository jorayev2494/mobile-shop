<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    private array $categories = [
        'chair',
        'table',
        'armchair',
        'bed',
        'sofa',
    ];

    public function definition(): array
    {
        return [
            'value' => $this->faker->randomElement($this->categories),
            // 'is_active' => $this->faker->boolean,
        ];
    }
}
