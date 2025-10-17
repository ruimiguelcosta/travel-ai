<?php

namespace Database\Factories;

use App\Models\Budget;
use Illuminate\Database\Eloquent\Factories\Factory;

class BudgetFactory extends Factory
{
    protected $model = Budget::class;

    public function definition(): array
    {
        $amount = fake()->randomFloat(2, 1000, 50000);
        $taxAmount = $amount * 0.1;
        $totalAmount = $amount + $taxAmount;

        return [
            'client_name' => fake()->name(),
            'client_email' => fake()->unique()->safeEmail(),
            'client_phone' => fake()->phoneNumber(),
            'client_company' => fake()->company(),
            'client_type' => fake()->randomElement(['potential', 'client']),
            'service_description' => fake()->sentence(),
            'amount' => $amount,
            'tax_amount' => $taxAmount,
            'total_amount' => $totalAmount,
            'currency' => 'BRL',
            'status' => fake()->randomElement(['draft', 'sent', 'approved', 'rejected', 'expired']),
            'valid_until' => fake()->dateTimeBetween('now', '+30 days'),
            'metadata' => [
                'notes' => fake()->paragraph(),
                'priority' => fake()->randomElement(['low', 'medium', 'high']),
            ],
        ];
    }

    public function potential(): static
    {
        return $this->state(fn (array $attributes) => [
            'client_type' => 'potential',
        ]);
    }

    public function client(): static
    {
        return $this->state(fn (array $attributes) => [
            'client_type' => 'client',
        ]);
    }

    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'approved',
        ]);
    }

    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'draft',
        ]);
    }
}
