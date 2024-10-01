<?php

// tests/Feature/StudentReportTest.php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Student;
use App\Models\Result;

use App\Models\Exam;
use Illuminate\Database\Eloquent\Factories\StudentFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StudentReportTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_generate_a_student_report()
    {
        $student = Student::factory()->create();

        $exam = Exam::factory()->create();
        Result::factory()->create([
            'student_id' => $student->id,
            'exam_id' => $exam->id,
            'obt_marks' => 85,
            'total' => 100,
            'grades' => 'A'
        ]);

        // Act: Generate the report
        $report = new \App\Reports\StudentReport($student->id, $exam->id);
        $data = $report->generate();

        // Assert: Check the report contains the expected data
        $this->assertCount(1, $data);
        $this->assertEquals($student->id, $data[0]->student_id);
        $this->assertEquals($exam->id, $data[0]->exam_id);
        $this->assertEquals(85, $data[0]->obt_marks);
        $this->assertEquals('A', $data[0]->grades);
    }
}
