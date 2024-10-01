<?php

// app/Reports/ExamReportFactory.php

namespace App\Reports;

use App\Exceptions\InvalidReportTypeException;

class ExamReportFactory
{
    public static function create(string $reportType, array $params)
    {
        // Check for required parameters based on the report type
        if ($reportType === 'student' && !isset($params['student_id'], $params['exam_id'])) {
            throw new InvalidReportTypeException("Missing required parameters for student report.");
        }
        if ($reportType === 'class' && !isset($params['class_id'], $params['exam_id'])) {
            throw new InvalidReportTypeException("Missing required parameters for class report.");
        }
        if ($reportType === 'teacher' && !isset($params['teacher_id'], $params['exam_id'])) {
            throw new InvalidReportTypeException("Missing required parameters for teacher report.");
        }

        switch ($reportType) {
            case 'student':
                return new StudentReport($params['student_id'], $params['exam_id']);
            case 'class':
                return new ClassReport($params['class_id'], $params['exam_id']);
            case 'teacher':
                return new TeacherReport($params['teacher_id'], $params['exam_id']);
            default:
                throw new InvalidReportTypeException("Invalid report type: {$reportType}");
        }
    }
}
