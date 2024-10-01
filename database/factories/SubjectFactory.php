<?php
// database/factories/SubjectFactory.php

namespace Database\Factories;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubjectFactory extends Factory
{
    protected $model = Subject::class;

    public function definition()
    {
        // List of specific subjects
        $subjects = [
            'English',
            'Urdu',
            'Math',
            'Science',
            'Pakistan Studies',
            'Geography',
            'History',
            'Drawing',
        ];

        return [
            'subject_name' => $this->faker->randomElement($subjects), // Randomly choose from the predefined subjects
            'type' => $this->faker->randomElement(['optional', 'mandatory']), // Randomly choose between optional and mandatory
            'pass_marks' => $this->faker->numberBetween(30, 100), // Pass marks between 30 and 100
            'final_marks' => $this->faker->numberBetween(100, 200), // Final marks between 100 and 200
            'sub_code' => strtoupper($this->faker->lexify('SUB???')), // Generate a subject code like 'SUB123'
        ];
    }
}
