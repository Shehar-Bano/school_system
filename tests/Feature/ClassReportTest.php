<?php

// tests/Feature/ClassReportTest.php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Student;
use App\Models\Result;
use App\Models\Exam;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClassReportTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_generate_a_class_report()
    {
        // Arrange: Create the necessary data
        $classId = 1; // Assuming class_id = 1
        $exam = Exam::factory()->create();
        
        Student::factory()->count(3)->create(['class_id' => $classId]); // Create 3 students in the class
        foreach (Student::all() as $student) {
            Result::factory()->create([
                'student_id' => $student->id,
                'exam_id' => $exam->id,
                'obt_marks' => 75,
                'total' => 100,
                'grades' => 'B'
            ]);
        }

        // Act: Generate the report
        $report = new \App\Reports\ClassReport($classId, $exam->id);
        $data = $report->generate();

        // Assert: Check the report contains the expected data
        $this->assertCount(3, $data); // Should return results for all 3 students
    }
}

