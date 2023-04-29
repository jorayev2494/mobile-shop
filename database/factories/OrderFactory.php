<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'client_uuid' => null,
            'email' => $this->faker->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'card_uuid' => null,
            'address_uuid' => null,
            'description' => $this->faker->boolean ? $this->faker->realText() : null,
            'status' => 'created',
            // 'is_active' => $this->faker->boolean,
        ];
    }
}
