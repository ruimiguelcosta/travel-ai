<?php

namespace Database\Seeders;

use App\Models\Budget;
use Illuminate\Database\Seeder;

class BudgetSeeder extends Seeder
{
    public function run(): void
    {
        Budget::factory()->count(10)->create();

        Budget::factory()->count(5)->potential()->create();
        Budget::factory()->count(3)->client()->create();
        Budget::factory()->count(2)->approved()->create();
    }
}
