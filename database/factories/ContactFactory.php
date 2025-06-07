<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Application;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $firstName = $this->faker->firstName();
        $lastName = $this->faker->lastName();
        
        return [
            'application_id' => Application::all()->random()->id,
            'name' => "$firstName $lastName",
            'email' => strtolower("$firstName.$lastName") . $this->faker->randomNumber(2) . '@example.com',
            'phone' => $this->faker->phoneNumber(),
            'linkedin_profile' => 'linkedin.com/in/' . strtolower("$firstName-$lastName") . $this->faker->randomNumber(2),
        ];
    }
}
