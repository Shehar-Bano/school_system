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
        // Add teacher_id and total_marks to assignments table if not present
        Schema::table('assignments', function (Blueprint $table) {
            if (!Schema::hasColumn('assignments', 'teacher_id')) {
                $table->unsignedBigInteger('teacher_id')->nullable()->after('subject_id');
            }
            if (!Schema::hasColumn('assignments', 'total_marks')) {
                $table->integer('total_marks')->default(100)->after('deadline');
            }
        });

        // Create assignment_submissions table
        if (!Schema::hasTable('assignment_submissions')) {
            Schema::create('assignment_submissions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('assignment_id');
                $table->foreign('assignment_id')->references('id')->on('assignments')->cascadeOnDelete();
                $table->unsignedBigInteger('student_id');
                $table->foreign('student_id')->references('id')->on('students')->cascadeOnDelete();
                $table->string('submission_file')->nullable();
                $table->text('submission_text')->nullable();
                $table->dateTime('submitted_at');
                $table->string('status')->default('submitted'); // submitted, late, graded, resubmitted
                $table->decimal('marks', 8, 2)->nullable();
                $table->text('feedback')->nullable();
                $table->string('graded_by')->nullable();
                $table->timestamps();

                $table->unique(['assignment_id', 'student_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignment_submissions');

        Schema::table('assignments', function (Blueprint $table) {
            if (Schema::hasColumn('assignments', 'teacher_id')) {
                $table->dropColumn('teacher_id');
            }
            if (Schema::hasColumn('assignments', 'total_marks')) {
                $table->dropColumn('total_marks');
            }
        });
    }
};
