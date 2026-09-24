<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            [
                'subject_name' => 'English Compulsory',
                'type' => 'Theory',
                'pass_marks' => '33',
                'final_marks' => '100',
                'sub_code' => 'ENG-101',
            ],
            [
                'subject_name' => 'Mathematics',
                'type' => 'Theory',
                'pass_marks' => '33',
                'final_marks' => '100',
                'sub_code' => 'MATH-102',
            ],
            [
                'subject_name' => 'General Science',
                'type' => 'Theory',
                'pass_marks' => '33',
                'final_marks' => '100',
                'sub_code' => 'SCI-103',
            ],
            [
                'subject_name' => 'Urdu Lazmi',
                'type' => 'Theory',
                'pass_marks' => '33',
                'final_marks' => '100',
                'sub_code' => 'URD-104',
            ],
            [
                'subject_name' => 'Islamiyat Compulsory',
                'type' => 'Theory',
                'pass_marks' => '17',
                'final_marks' => '50',
                'sub_code' => 'ISL-105',
            ],
            [
                'subject_name' => 'Pakistan Studies',
                'type' => 'Theory',
                'pass_marks' => '17',
                'final_marks' => '50',
                'sub_code' => 'PST-106',
            ],
            [
                'subject_name' => 'Computer Science',
                'type' => 'Practical',
                'pass_marks' => '25',
                'final_marks' => '75',
                'sub_code' => 'CS-107',
            ],
            [
                'subject_name' => 'Physics',
                'type' => 'Theory & Practical',
                'pass_marks' => '25',
                'final_marks' => '75',
                'sub_code' => 'PHY-108',
            ],
            [
                'subject_name' => 'Chemistry',
                'type' => 'Theory & Practical',
                'pass_marks' => '25',
                'final_marks' => '75',
                'sub_code' => 'CHEM-109',
            ],
            [
                'subject_name' => 'Biology',
                'type' => 'Theory & Practical',
                'pass_marks' => '25',
                'final_marks' => '75',
                'sub_code' => 'BIO-110',
            ],
        ];

        foreach ($subjects as $data) {
            Subject::updateOrCreate(
                ['sub_code' => $data['sub_code']],
                $data
            );
        }
    }
}
