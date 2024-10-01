<?php
// tests/Feature/TeacherReportTest.php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Student;
use App\Models\Result;
use App\Models\Exam;
use App\Models\Section;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeacherReportTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_generate_a_teacher_report()
    {
        // Arrange: Create the necessary data
        $teacherId = 1; // Assuming teacher_id = 1
        $exam = Exam::factory()->create();
        $section = Section::factory()->create(['employee_id' => $teacherId]);
        
        Student::factory()->count(3)->create(['section_id' => $section->id]); // Create students in the section
        foreach (Student::all() as $student) {
            Result::factory()->create([
                'student_id' => $student->id,
                'exam_id' => $exam->id,
                'obt_marks' => 90,
                'total' => 100,
                'grades' => 'A+'
            ]);
        }

        // Act: Generate the report
        $report = new \App\Reports\TeacherReport($teacherId, $exam->id);
        $data = $report->generate();

        // Assert: Check the report contains the expected data
        $this->assertCount(3, $data); // Should return results for all 3 students
    }
}
