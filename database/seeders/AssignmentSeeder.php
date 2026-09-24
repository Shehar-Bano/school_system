<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\Classe;
use App\Models\Section;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class AssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classes = Classe::all();
        $subjects = Subject::all();

        if ($classes->isEmpty() || $subjects->isEmpty()) {
            return;
        }

        foreach ($classes->take(5) as $class) {
            $section = Section::where('classe_id', $class->id)->first() ?? Section::first();
            $subject = $subjects->random();

            Assignment::updateOrCreate(
                [
                    'title' => 'Weekly Homework #1 - ' . $subject->subject_name,
                    'class_id' => $class->id,
                    'section_id' => $section ? $section->id : 1,
                    'subject_id' => $subject->id,
                ],
                [
                    'description' => 'Complete chapter review exercises and submit by due date.',
                    'deadline' => now()->addDays(7)->toDateString(),
                    'uploader' => 'Course Teacher',
                    'assignment' => 'assignment_' . $class->id . '.pdf',
                ]
            );
        }
    }
}
