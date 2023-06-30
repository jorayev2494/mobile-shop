<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Country>
 */
class CountryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'value' => $this->faker->country,
            'iso' => $this->faker->countryISOAlpha3(),
            // 'is_active' => $this->faker->boolean,
        ];
    }
}
