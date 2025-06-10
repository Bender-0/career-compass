<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $count = rand(10, 30);
        Task::factory()->count($count)->create();
    }
}
