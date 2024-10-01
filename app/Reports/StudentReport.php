<?php
// app/Reports/StudentReport.php

namespace App\Reports;


use App\Models\Result;

class StudentReport implements ExamReportInterface
{
    protected $studentId;
    protected $examId;

    public function __construct($studentId, $examId)
    {
        $this->studentId = $studentId;
        $this->examId = $examId;
    }

    public function generate()
    {
        return Result::with(['student', 'exam', 'section', 'subject'])
            ->where('student_id', $this->studentId)
            ->where('exam_id', $this->examId)
            ->get();
    }
}
