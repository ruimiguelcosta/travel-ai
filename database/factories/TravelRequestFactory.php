<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TravelRequest>
 */
class TravelRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $checkinDate = fake()->dateTimeBetween('+1 week', '+1 month');
        $checkoutDate = fake()->dateTimeBetween($checkinDate, '+2 months');

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'checkin_date' => $checkinDate,
            'checkout_date' => $checkoutDate,
            'destination_country' => fake()->country(),
            'destination_city' => fake()->city(),
            'preferences' => fake()->randomElements(['beach', 'mountain', 'city', 'adventure', 'culture'], 3),
            'adults' => fake()->numberBetween(1, 4),
            'children' => fake()->numberBetween(0, 3),
            'budget' => fake()->numberBetween(500, 5000),
            'status' => 'pending',
        ];
    }
}
