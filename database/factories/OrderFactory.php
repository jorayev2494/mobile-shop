<?php

namespace Database\Factories;

use App\Models\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{

    public function definition(): array
    {
        $statuses = array_map(static fn (OrderStatus $oStatus): string => $oStatus->value, OrderStatus::cases());

        return [
            'client_uuid' => null,
            'email' => $this->faker->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'card_uuid' => null,
            'address_uuid' => null,
            'description' => $this->faker->boolean ? $this->faker->realText() : null,
            'status' => $this->faker->randomElement($statuses),
            // 'is_active' => $this->faker->boolean,
        ];
    }
}
