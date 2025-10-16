<?php

namespace Database\Seeders;

use App\Models\Integration;
use App\Models\IntegrationCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IntegrationSeeder extends Seeder
{
    public function run(): void
    {
        $hotelCategory = IntegrationCategory::query()->where('slug', 'hoteis')->first();
        $rentCarCategory = IntegrationCategory::query()->where('slug', 'rent-a-car')->first();

        Integration::query()->create([
            'integration_category_id' => $hotelCategory->id,
            'name' => 'Hotelbeds',
            'slug' => 'hotelbeds',
            'description' => 'Plataforma B2B líder mundial para distribuição de hospedagem, mobilidade e experiências',
            'base_url' => 'https://hotelbeds.com',
            'configuration' => [
                'api_version' => 'v1',
                'timeout' => 30,
                'retry_attempts' => 3,
            ],
            'is_active' => true,
        ]);

        Integration::query()->create([
            'integration_category_id' => $rentCarCategory->id,
            'name' => 'SG Rentals',
            'slug' => 'sg-rentals',
            'description' => 'Especialista em aluguel de carros com as melhores tarifas e frotas',
            'base_url' => 'https://sgrentals.com.br',
            'configuration' => [
                'api_version' => 'v1',
                'timeout' => 30,
                'retry_attempts' => 3,
            ],
            'is_active' => true,
        ]);
    }
}