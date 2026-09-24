<?php

namespace Database\Seeders;

use App\Models\Classe;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
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

        $sampleStudents = [
            [
                'name' => 'Ali Raza',
                'gurdian' => 'father',
                'admissiondate' => '2023-08-15',
                'dob' => '2010-04-12',
                'gender' => 'male',
                'religion' => 'Islam',
                'email' => 'ali.raza@student.com',
                'phone' => '03001112233',
                'address' => 'House 45, Street 2, Allama Iqbal Town, Lahore',
                'group' => 'science',
                'registration' => 'REG-2023-001',
                'image' => 'default.png',
                'status' => 'active',
            ],
            [
                'name' => 'Zainab Fatima',
                'gurdian' => 'father',
                'admissiondate' => '2023-08-16',
                'dob' => '2010-08-22',
                'gender' => 'female',
                'religion' => 'Islam',
                'email' => 'zainab.fatima@student.com',
                'phone' => '03002223344',
                'address' => 'House 78, Gulshan-e-Ravi, Lahore',
                'group' => 'science',
                'registration' => 'REG-2023-002',
                'image' => 'default.png',
                'status' => 'active',
            ],
            [
                'name' => 'Hamza Tariq',
                'gurdian' => 'father',
                'admissiondate' => '2023-08-18',
                'dob' => '2009-11-05',
                'gender' => 'male',
                'religion' => 'Islam',
                'email' => 'hamza.tariq@student.com',
                'phone' => '03003334455',
                'address' => 'House 19, Faisal Town, Lahore',
                'group' => 'commerce',
                'registration' => 'REG-2023-003',
                'image' => 'default.png',
                'status' => 'active',
            ],
            [
                'name' => 'Sara Khan',
                'gurdian' => 'mother',
                'admissiondate' => '2023-08-20',
                'dob' => '2011-01-30',
                'gender' => 'female',
                'religion' => 'Islam',
                'email' => 'sara.khan@student.com',
                'phone' => '03004445566',
                'address' => 'House 89, Johar Town, Lahore',
                'group' => 'arts',
                'registration' => 'REG-2023-004',
                'image' => 'default.png',
                'status' => 'active',
            ],
            [
                'name' => 'Bilal Hassan',
                'gurdian' => 'father',
                'admissiondate' => '2023-08-22',
                'dob' => '2008-06-18',
                'gender' => 'male',
                'religion' => 'Islam',
                'email' => 'bilal.hassan@student.com',
                'phone' => '03005556677',
                'address' => 'House 102, Wapda Town, Lahore',
                'group' => 'science',
                'registration' => 'REG-2023-005',
                'image' => 'default.png',
                'status' => 'active',
            ],
        ];

        foreach ($sampleStudents as $index => $data) {
            $class = $classes[$index % $classes->count()];
            $section = Section::where('classe_id', $class->id)->first() ?? Section::first();

            $data['class_id'] = $class->id;
            $data['section_id'] = $section ? $section->id : 1;
            $data['tution_fee'] = $class->tution_fee ?? 4000;

            $student = Student::updateOrCreate(
                ['registration' => $data['registration']],
                $data
            );
            $student->assignRole('student');
        }
    }
}
