<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $amount = fake()->randomFloat(2, 50, 2000);
        $taxAmount = $amount * 0.23;
        $totalAmount = $amount + $taxAmount;

        return [
            'customer_name' => fake()->name(),
            'customer_email' => fake()->unique()->safeEmail(),
            'customer_phone' => fake()->optional()->phoneNumber(),
            'product_name' => fake()->randomElement([
                'Pacote de Viagem Lisboa',
                'Hotel 5 Estrelas Porto',
                'Tour Cultural Sintra',
                'Experiência Gastronómica',
                'Transfer Aeroporto',
                'Seguro de Viagem',
                'Excursão Douro',
                'City Break Coimbra',
            ]),
            'product_description' => fake()->optional()->sentence(),
            'amount' => $amount,
            'tax_amount' => $taxAmount,
            'total_amount' => $totalAmount,
            'currency' => 'EUR',
            'status' => fake()->randomElement(['pending', 'completed', 'cancelled']),
            'payment_method' => fake()->randomElement(['credit_card', 'paypal', 'bank_transfer', 'cash']),
            'payment_status' => fake()->randomElement(['pending', 'paid', 'failed', 'refunded']),
            'sale_date' => fake()->dateTimeBetween('-6 months', 'now'),
            'metadata' => [
                'source' => fake()->randomElement(['website', 'phone', 'email', 'walk_in']),
                'agent_id' => fake()->optional()->numberBetween(1, 10),
                'notes' => fake()->optional()->sentence(),
            ],
        ];
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'payment_status' => 'paid',
        ]);
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'payment_status' => 'pending',
        ]);
    }

    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'cancelled',
            'payment_status' => 'refunded',
        ]);
    }
}
