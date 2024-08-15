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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teacher_id');
            $table->foreign('teacher_id')  // Correctly reference the 'employ' column
            ->references('id')
            ->on('employees')
            ->cascadeOnDelete();

            $table->unsignedBigInteger('class_id');
            $table->foreign('class_id')->references('id')->on('classes')->cascadeOnDelete();
            $table->string('subject_name');
            $table->string('type');
            $table->string('pass_marks');
            $table->string('final_marks');
            $table->string('sub_code');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
