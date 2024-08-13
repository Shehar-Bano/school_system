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
            $table->enum('gurdian',['father','mother','otherFamilyMember']);
            $table->string('admissiondate');
            $table->string('dob');
            $table->enum('gender',['male','female','other']);
            $table->string('religion');
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->unsignedBigInteger('class');
            $table->foreign('class')->references('id')->on('classes')->cascadeOnDelete();
            $table->unsignedBigInteger('section');
            $table->foreign('section')->references('id')->on('sections')->cascadeOnDelete();
            $table->enum('group',['arts','science','commerce']);
            $table->string('registration');
            $table->string('username');
            $table->string('password');
            $table->string('image');
            

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
