<?php
// app/Reports/ClassReport.php

namespace App\Reports;

use App\Models\Result;

class ClassReport implements ExamReportInterface
{
    protected $classId;
    protected $examId;

    public function __construct($classId, $examId)
    {
        $this->classId = $classId;
        $this->examId = $examId;
    }

    public function generate()
    {
        return Result::with(['student', 'exam', 'section', 'subject'])
            ->whereHas('student', function ($query) {
                $query->where('class_id', $this->classId);
            })
            ->where('exam_id', $this->examId)
            ->get();
    }
}
