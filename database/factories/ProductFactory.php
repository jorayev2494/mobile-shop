<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->title,
            'price' => $this->faker->numberBetween(50, 500),
            'discount_percentage' => $this->faker->boolean ? $this->faker->numberBetween(5, 90) : null,
            'description' => $this->faker->realText(),
            // 'is_active' => $this->faker->boolean,
        ];
    }
}
