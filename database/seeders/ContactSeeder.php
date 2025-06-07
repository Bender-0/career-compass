<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        $count = rand(1, 6);
        Contact::factory()->count($count)->create();
    }
}
