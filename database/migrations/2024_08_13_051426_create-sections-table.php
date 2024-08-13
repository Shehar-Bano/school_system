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
        Schema::create('sections', function (Blueprint $table) {
            $table->id();  // Primary key of the sections table
            $table->string('name');
            $table->string('capacity');

            // Define the foreign key columns
            $table->unsignedBigInteger('employ');
            $table->foreign('employ')  // Correctly reference the 'employ' column
                  ->references('id')
                  ->on('employees')
                  ->cascadeOnDelete();

            $table->unsignedBigInteger('class');
            $table->foreign('class')  // Correctly reference the 'class' column
                  ->references('id')
                  ->on('classes')
                  ->cascadeOnDelete();

            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
