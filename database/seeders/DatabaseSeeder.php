<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Cria o admin inicial
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'role' => UserRole::ADMIN,
        ]);

        // Cria 5 vendedores para popular
        User::factory()->count(5)->create([
            'role' => UserRole::SELLER,
        ]);
    }
}
