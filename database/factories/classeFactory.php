<?php
// database/factories/ClassModelFactory.php

namespace Database\Factories;

use App\Models\classe;
use Illuminate\Database\Eloquent\Factories\Factory;

class classeFactory extends Factory
{
    protected $model = classe::class;
    public function definition()
    {
        static $classNumber = 1;
    
        // Convert number to words dynamically
        $formatter = new \NumberFormatter("en", \NumberFormatter::SPELLOUT);
        $className = ucfirst($formatter->format($classNumber)); // "One", "Two", etc.
    
        $classNumber++;
    
        return [
            'name' => $className,
            'tution_fee' => $this->faker->randomFloat(2, 1000, 5000),
            'note' => $this->faker->sentence,
        ];
    }
    
}

