<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DocumentSeeder extends Seeder
{
    public function run(): void
    {
        User::with('applications')->get()->each(function ($user) {
            $user->applications->each(function ($application) use ($user) {
                // Create 1-2 documents per application
                $documentCount = rand(1, 2);
                
                // Use the factory to create documents
                \App\Models\Document::factory()
                    ->count($documentCount)
                    ->for($user)
                    ->for($application)
                    ->create();
            });
        });
    }
}
