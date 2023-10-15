<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Card>
 */
class CardFactory extends Factory
{
    public function definition(): array
    {
        $types = [
            'Visa',
            'MasterCard',
        ];

        return [
            'client_uuid' => null,
            'type' => $type = $this->faker->randomElement($types),
            'holder_name' => $this->faker->firstName() . ' ' . $this->faker->lastName(),
            'number' => $this->faker->creditCardNumber($type, true, '-'),
            'cvv' => $this->faker->numberBetween(100, 999),
            'expiration_date' => $this->faker->creditCardExpirationDateString(),
            // 'is_active' => true,
        ];
    }
}
