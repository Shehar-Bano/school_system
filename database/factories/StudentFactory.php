<?php
// database/factories/StudentFactory.php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'gurdian' => $this->faker->randomElement(['father', 'mother', 'otherFamilyMember']),
            'admissiondate' => $this->faker->date(),
            'dob' => $this->faker->date(),
            'gender' => $this->faker->randomElement(['male', 'female', 'other']),
            'religion' => $this->faker->randomElement(['Islam', 'Christianity', 'Hinduism', 'Judaism', 'Other']),
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'class_id' => \App\Models\classe::factory(), // Assuming you have a ClassModel factory
            'section_id' => \App\Models\Section::factory(),  // Assuming you have a Section factory
            'group' => $this->faker->randomElement(['arts', 'science', 'commerce']),
            'registration' => $this->faker->unique()->word,
            'password' => bcrypt('password'), // or you can hash a default password here
            'image' => $this->faker->imageUrl(640, 480, 'people'), // or you can use a default path for images
            'tution_fee' => $this->faker->randomFloat(2, 1000, 5000), // Random float between 1000 and 5000
            'username' => $this->faker->userName,
        ];
    }
}
