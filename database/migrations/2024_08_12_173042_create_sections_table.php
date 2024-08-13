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
            $table->id();
            $table->string('name');
            $table->string('capacity');

            $table->unsignedBigInteger('teacher');
            $table->foreign('teacher')->references('id')->on('teachers')->cascadeOnDelete();
            $table->unsignedBigInteger('class');
            $table->foreign('class')->references('id')->on('classess')->cascadeOnDelete();
            $table->string('note');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
