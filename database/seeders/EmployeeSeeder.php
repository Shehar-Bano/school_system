<?php

namespace Database\Seeders;

use App\Models\Designation;
use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $principalDesig = Designation::where('name', 'Principal')->first() ?? Designation::first();
        $seniorTeacherDesig = Designation::where('name', 'Senior Teacher')->first() ?? Designation::first();
        $juniorTeacherDesig = Designation::where('name', 'Junior Teacher')->first() ?? Designation::first();
        $accountantDesig = Designation::where('name', 'Accountant')->first() ?? Designation::first();

        $employees = [
            [
                'name' => 'Prof. Muhammad Ahmed',
                'designation_id' => $principalDesig->id,
                'date_of_birth' => '1980-05-15',
                'gender' => 'Male',
                'religion' => 'Islam',
                'email' => 'ahmed.principal@school.com',
                'password' => Hash::make('password'),
                'phone' => '03001234567',
                'address' => 'House 12, Street 4, Lahore',
                'joining_date' => '2015-08-01',
                'salary' => '150000',
                'status' => 'active',
            ],
            [
                'name' => 'Dr. Ayesha Tariq',
                'designation_id' => $seniorTeacherDesig->id,
                'date_of_birth' => '1985-09-20',
                'gender' => 'Female',
                'religion' => 'Islam',
                'email' => 'ayesha.tariq@school.com',
                'password' => Hash::make('password'),
                'phone' => '03011234567',
                'address' => 'Block B, Model Town, Lahore',
                'joining_date' => '2018-09-10',
                'salary' => '85000',
                'status' => 'active',
            ],
            [
                'name' => 'Sir Usman Ali',
                'designation_id' => $seniorTeacherDesig->id,
                'date_of_birth' => '1988-11-12',
                'gender' => 'Male',
                'religion' => 'Islam',
                'email' => 'usman.ali@school.com',
                'password' => Hash::make('password'),
                'phone' => '03021234567',
                'address' => 'Gulberg III, Lahore',
                'joining_date' => '2019-01-15',
                'salary' => '75000',
                'status' => 'active',
            ],
            [
                'name' => 'Miss Fatima Zahra',
                'designation_id' => $juniorTeacherDesig->id,
                'date_of_birth' => '1994-03-25',
                'gender' => 'Female',
                'religion' => 'Islam',
                'email' => 'fatima.zahra@school.com',
                'password' => Hash::make('password'),
                'phone' => '03031234567',
                'address' => 'Johar Town, Lahore',
                'joining_date' => '2021-04-01',
                'salary' => '50000',
                'status' => 'active',
            ],
            [
                'name' => 'Tariq Mehmood',
                'designation_id' => $accountantDesig->id,
                'date_of_birth' => '1990-07-18',
                'gender' => 'Male',
                'religion' => 'Islam',
                'email' => 'accountant@school.com',
                'password' => Hash::make('password'),
                'phone' => '03041234567',
                'address' => 'DHA Phase 5, Lahore',
                'joining_date' => '2020-02-10',
                'salary' => '65000',
                'status' => 'active',
            ],
        ];

        foreach ($employees as $data) {
            $employee = Employee::updateOrCreate(
                ['email' => $data['email']],
                $data
            );
            $employee->assignRole('employee');
        }
    }
}
