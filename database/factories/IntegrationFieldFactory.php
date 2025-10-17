<?php

namespace Database\Factories;

use App\Models\Integration;
use App\Models\IntegrationField;
use Illuminate\Database\Eloquent\Factories\Factory;

class IntegrationFieldFactory extends Factory
{
    protected $model = IntegrationField::class;

    public function definition(): array
    {
        return [
            'integration_id' => Integration::factory(),
            'name' => fake()->unique()->word(),
            'label' => fake()->sentence(2),
            'type' => fake()->randomElement(['text', 'email', 'password', 'number', 'url', 'tel', 'textarea', 'select', 'checkbox', 'radio']),
            'required' => fake()->boolean(),
            'placeholder' => fake()->sentence(),
            'help_text' => fake()->paragraph(),
            'sort_order' => fake()->numberBetween(0, 100),
            'is_active' => true,
        ];
    }
}
