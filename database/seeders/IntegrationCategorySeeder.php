<?php

namespace Database\Seeders;

use App\Models\IntegrationCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IntegrationCategorySeeder extends Seeder
{
    public function run(): void
    {
        IntegrationCategory::query()->create([
            'name' => 'Hotéis',
            'slug' => 'hoteis',
            'description' => 'Integrações para reservas de hotéis e hospedagem',
            'is_active' => true,
        ]);

        IntegrationCategory::query()->create([
            'name' => 'Rent-a-car',
            'slug' => 'rent-a-car',
            'description' => 'Integrações para aluguel de veículos',
            'is_active' => true,
        ]);
    }
}