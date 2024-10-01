<?php
// app/Reports/TeacherReport.php

namespace App\Reports;

use App\Models\Result;

class TeacherReport implements ExamReportInterface
{
    protected $teacherId;
    protected $examId;

    public function __construct($teacherId, $examId)
    {
        $this->teacherId = $teacherId;
        $this->examId = $examId;
    }

    public function generate()
    {
        return Result::with(['student', 'exam', 'section', 'subject'])
            ->whereHas('section', function ($query) {
                $query->where('employee_id', $this->teacherId);
            })
            ->where('exam_id', $this->examId)
            ->get();
    }
}
