<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Application>
 */
class ApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statuses = ['pending', 'interview', 'offer', 'rejected'];
        $appliedDate = $this->faker->dateTimeBetween('-60 days', 'now');
        
        return [
            'user_id' => User::all()->first()->id,
            'job_title' => $this->faker->jobTitle(),
            'company_name' => $this->faker->company(),
            'company_website' => $this->faker->url(),
            'applied_date' => $appliedDate,
            'status' => $this->faker->randomElement($statuses),
            'job_description' => $this->faker->paragraphs(3, true),
            'salary_range' => '$' . $this->faker->numberBetween(50, 150) . 'k - $' . $this->faker->numberBetween(150, 300) . 'k',
            'location' => $this->faker->randomElement(['Remote', 'New York', 'San Francisco', 'Chicago', 'Austin']),
            'application_link' => $this->faker->url(),
            'posted_date' => $this->faker->dateTimeBetween('-90 days', $appliedDate),
            'application_deadline' => $this->faker->dateTimeBetween($appliedDate, '+90 days'),
        ];
    }
}
