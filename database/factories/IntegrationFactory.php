<?php

namespace Database\Factories;

use App\Models\Integration;
use App\Models\IntegrationCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class IntegrationFactory extends Factory
{
    protected $model = Integration::class;

    public function definition(): array
    {
        return [
            'integration_category_id' => IntegrationCategory::factory(),
            'name' => fake()->company(),
            'slug' => fake()->unique()->slug(),
            'description' => fake()->paragraph(),
            'base_url' => fake()->url(),
            'configuration' => null,
            'is_active' => true,
        ];
    }
}
