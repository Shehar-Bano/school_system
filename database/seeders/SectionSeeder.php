<?php

namespace Database\Seeders;

use App\Models\Classe;
use App\Models\Employee;
use App\Models\Section;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classes = Classe::all();
        $teachers = Employee::all();

        if ($classes->isEmpty() || $teachers->isEmpty()) {
            return;
        }

        $sectionNames = ['Section A', 'Section B'];

        foreach ($classes as $class) {
            foreach ($sectionNames as $index => $secName) {
                $teacher = $teachers[$index % $teachers->count()];
                Section::updateOrCreate(
                    [
                        'name' => $secName,
                        'classe_id' => $class->id,
                    ],
                    [
                        'capacity' => 35,
                        'employee_id' => $teacher->id,
                        'note' => $class->name . ' - ' . $secName,
                    ]
                );
            }
        }
    }
}
