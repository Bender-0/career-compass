<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->count(1)->create([
            'name' => fake()->name(),
            'email' => 'user@example.com',
        ]);
    }
}
