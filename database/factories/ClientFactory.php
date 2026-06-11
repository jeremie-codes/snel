<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => null,
            'name' => fake()->name(),
            'phone' => fake()->phoneNumber(),
            'reference' => fake()->unique()->bothify('CLI-####'),
            'status' => 'active',
        ];
    }

    public function withUser(): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => User::factory(),
        ]);
    }
}
