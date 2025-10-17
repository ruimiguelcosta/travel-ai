<?php

namespace Database\Factories;

use App\Models\IntegrationCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class IntegrationCategoryFactory extends Factory
{
    protected $model = IntegrationCategory::class;

    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'slug' => fake()->unique()->slug(),
            'description' => fake()->sentence(),
            'is_active' => true,
        ];
    }
}
