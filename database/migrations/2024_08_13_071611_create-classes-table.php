<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
<<<<<<<< HEAD:database/migrations/2024_08_13_092745_create_designations_table.php
        Schema::create('designations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
========
        Schema::create('classes', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name');
            $table->unsignedBigInteger('employee_id'); // Foreign key column
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade'); // Correct foreign key constraint
            $table->string('note');
>>>>>>>> dce162f9a0de2321197afcaf509e5ca518eb8157:database/migrations/2024_08_13_071611_create-classes-table.php
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
<<<<<<<< HEAD:database/migrations/2024_08_13_092745_create_designations_table.php
        Schema::dropIfExists('designations');
========
        //
>>>>>>>> dce162f9a0de2321197afcaf509e5ca518eb8157:database/migrations/2024_08_13_071611_create-classes-table.php
    }
};
