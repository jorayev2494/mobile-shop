<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin>
 */
class AdminFactory extends Factory
{
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '12345Secret_',
            'remember_token' => Str::random(10),
            'role_id' => 1,
        ];
    }

    public function withRole(): static
    {
        return $this->state(fn (array $attributes): array => [
            'role_id' => Role::query()->first()->value('id'),
        ]);
    }

    public function moderator(): static
    {
        return $this->state(static fn (array $attributes) => [
            'role_id' => 2,
        ]);
    }
}
