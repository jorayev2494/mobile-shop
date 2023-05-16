<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\City>
 */
class CityFactory extends Factory
{
    public function definition(): array
    {
        return [
            'value' => $this->faker->city(),
            'country_uuid' => null,
            // 'is_active' => $this->faker->boolean,
        ];
    }
}
