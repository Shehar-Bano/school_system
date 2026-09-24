<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleAndPermissionSeeder::class,
            DesignationSeeder::class,
            EmployeeSeeder::class,
            ClasseSeeder::class,
            SectionSeeder::class,
            SubjectSeeder::class,
            StudentSeeder::class,
            SyllabusSeeder::class,
            AssignmentSeeder::class,
        ]);
    }
}
