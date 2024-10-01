<?php

namespace Database\Seeders;

use App\Models\classe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        classe::factory()->count(10)->create();  // Creates 10 records
    }
}
