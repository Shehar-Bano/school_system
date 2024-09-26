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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('gurdian', ['father', 'mother', 'otherFamilyMember']);
            $table->string('admissiondate');
            $table->string('dob');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('religion');
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->unsignedBigInteger('class_id');
            $table->unsignedBigInteger('section_id');
            $table->enum('group', ['arts', 'science', 'commerce']);
            $table->string('registration');
            $table->string('image');
            $table->string('status')->default('active');
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');

    }
};
