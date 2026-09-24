<?php

namespace Database\Seeders;

use App\Models\Classe;
use App\Models\Syllabus;
use Illuminate\Database\Seeder;

class SyllabusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classes = Classe::all();

        if ($classes->isEmpty()) {
            return;
        }

        foreach ($classes as $class) {
            Syllabus::updateOrCreate(
                [
                    'title' => 'Annual Syllabus 2026-27 - ' . $class->name,
                    'class_id' => $class->id,
                ],
                [
                    'description' => 'Complete annual academic syllabus and coursework outline for ' . $class->name,
                    'file' => 'syllabus_' . $class->id . '.pdf',
                    'uploader' => 'Academic Coordinator',
                    'date' => now()->toDateString(),
                ]
            );
        }
    }
}
