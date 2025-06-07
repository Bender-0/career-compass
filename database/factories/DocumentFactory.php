<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Document>
 */
class DocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fileTypes = ['resume', 'cover_letter', 'portfolio', 'certificate', 'other'];
        $extensions = ['pdf', 'docx', 'doc', 'txt'];
        $fileType = $this->faker->randomElement($fileTypes);
        $extension = $this->faker->randomElement($extensions);
        $fileName = str_replace(' ', '_', strtolower($fileType)) . '_' . $this->faker->uuid() . '.' . $extension;
        
        return [
            'user_id' => User::factory(),
            'application_id' => Application::factory(),
            'file_name' => $fileName,
            'file_path' => 'documents/' . $this->faker->uuid() . '/' . $fileName,
            'file_type' => $fileType,
            'file_size' => $this->faker->numberBetween(100000, 5000000), // 100KB to 5MB
        ];
    }
}
