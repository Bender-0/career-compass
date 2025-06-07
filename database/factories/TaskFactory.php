<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['personal', 'professional', 'other'];
        $titles = [
            'Follow up on application status',
            'Prepare for technical interview',
            'Send thank you email after interview',
            'Research company culture',
            'Update resume and cover letter'
        ];
        
        $descriptions = [
            'Reach out to the hiring manager for an update.',
            'Review data structures and algorithms for the technical round.',
            'Send a thank you note to the interview panel.',
            'Look up recent news and updates about the company.',
            'Update resume with latest projects and experiences.'
        ];
        
        return [
            'application_id' => Application::all()->random()->id,
            'title' => $this->faker->randomElement($titles),
            'description' => $this->faker->randomElement($descriptions),
            'type' => $this->faker->randomElement($types),
            'due_date' => $this->faker->dateTimeBetween('now', '+30 days'),
            'is_completed' => $this->faker->boolean(30), // 30% chance of being completed
        ];
    }
}
