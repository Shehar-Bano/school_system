<?php

namespace Database\Seeders;

use App\Models\Classe;
use Illuminate\Database\Seeder;

class ClasseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classes = [
            ['name' => 'Grade 1', 'tution_fee' => 3500, 'note' => 'Primary Section'],
            ['name' => 'Grade 2', 'tution_fee' => 3500, 'note' => 'Primary Section'],
            ['name' => 'Grade 3', 'tution_fee' => 4000, 'note' => 'Primary Section'],
            ['name' => 'Grade 4', 'tution_fee' => 4000, 'note' => 'Primary Section'],
            ['name' => 'Grade 5', 'tution_fee' => 4500, 'note' => 'Primary Section'],
            ['name' => 'Grade 6', 'tution_fee' => 5000, 'note' => 'Middle Section'],
            ['name' => 'Grade 7', 'tution_fee' => 5000, 'note' => 'Middle Section'],
            ['name' => 'Grade 8', 'tution_fee' => 5500, 'note' => 'Middle Section'],
            ['name' => 'Grade 9', 'tution_fee' => 6500, 'note' => 'Secondary Section Matric'],
            ['name' => 'Grade 10', 'tution_fee' => 7000, 'note' => 'Secondary Section Matric'],
        ];

        foreach ($classes as $data) {
            Classe::updateOrCreate(
                ['name' => $data['name']],
                $data
            );
        }
    }
}
