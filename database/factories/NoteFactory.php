<?php

namespace Database\Factories;

use App\Models\Application;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Note>
 */
class NoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['personal', 'professional', 'other'];
        $contents = [
            'Followed up with the recruiter about next steps.',
            'Technical interview scheduled for next week.',
            'Received positive feedback from the hiring manager.',
            'Need to prepare for the coding challenge.',
            'Waiting to hear back after the final interview.'
        ];
        
        return [
            'application_id' => Application::all()->random()->id,
            'category' => $this->faker->randomElement($categories),
            'content' => $this->faker->randomElement($contents),
        ];
    }
}
