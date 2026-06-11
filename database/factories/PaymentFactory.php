<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => Client::factory(),
            'agent_id' => User::factory()->agent(),
            'invoice_number' => fake()->unique()->bothify('FAC-####'),
            'amount' => fake()->randomFloat(2, 10, 5000),
            'currency' => fake()->randomElement(['CDF', 'USD', 'EUR']),
            'payment_method' => fake()->randomElement(['cash', 'mobile_money', 'bank_transfer']),
            'notes' => fake()->optional()->sentence(),
            'paid_at' => now(),
        ];
    }
}
