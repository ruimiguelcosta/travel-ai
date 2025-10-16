<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $adminRole = Role::query()->firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $agencyRole = Role::query()->firstOrCreate([
            'name' => 'agencia',
            'guard_name' => 'web',
        ]);

        $adminUser1 = User::query()->firstOrCreate([
            'email' => 'admin1@aitravel.com',
        ], [
            'name' => 'Administrador Principal',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        $adminUser2 = User::query()->firstOrCreate([
            'email' => 'admin2@aitravel.com',
        ], [
            'name' => 'Administrador Secundário',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        $agencyUser = User::query()->firstOrCreate([
            'email' => 'agencia@aitravel.com',
        ], [
            'name' => 'Usuário Agência',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        $adminUser1->assignRole('admin');
        $adminUser2->assignRole('admin');
        $agencyUser->assignRole('agencia');
    }
}
