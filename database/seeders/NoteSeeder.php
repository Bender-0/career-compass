<?php

namespace Database\Seeders;

use App\Models\Note;
use Illuminate\Database\Seeder;

class NoteSeeder extends Seeder
{
    public function run(): void
    {
        $count = rand(10, 30);
        Note::factory()->count($count)->create();
    }
}
