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
       
        Schema::create('classes', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name');
            $table->unsignedBigInteger('employee_id'); // Foreign key column
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade'); // Correct foreign key constraint
            $table->string('note');
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
