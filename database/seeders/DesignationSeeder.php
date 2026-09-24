<?php

namespace Database\Seeders;

use App\Models\Designation;
use Illuminate\Database\Seeder;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $designations = [
            'Principal',
            'Vice Principal',
            'Senior Teacher',
            'Junior Teacher',
            'Accountant',
            'Admin Officer',
            'Lab Assistant',
            'Librarian',
        ];

        foreach ($designations as $name) {
            Designation::firstOrCreate(['name' => $name]);
        }
    }
}
