<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->title(),
            'full_name' => $this->faker->firstName() . ' ' . $this->faker->lastName(),
            'client_uuid' => null,
            'first_address' => $this->faker->streetAddress(),
            'second_address' => $this->faker->boolean ? $this->faker->streetAddress() : null,
            'zip_code' => $this->faker->numberBetween(00000, 99999),
            'country_uuid' => null,
            'city_uuid' => null,
            'district' => $this->faker->randomLetter(),
            'is_active' => true,
        ];
    }
}
