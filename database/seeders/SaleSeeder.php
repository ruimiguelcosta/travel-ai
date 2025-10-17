<?php

namespace Database\Seeders;

use App\Models\Sale;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    public function run(): void
    {
        Sale::factory()
            ->count(150)
            ->completed()
            ->create();

        Sale::factory()
            ->count(30)
            ->pending()
            ->create();

        Sale::factory()
            ->count(20)
            ->cancelled()
            ->create();
    }
}
