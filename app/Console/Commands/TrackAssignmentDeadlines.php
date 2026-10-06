<?php

namespace App\Console\Commands;

use App\Models\Assignment;
use App\Models\Notification;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Console\Command;

class TrackAssignmentDeadlines extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'assignments:track-deadlines';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Track student assignment submissions, calculate submission statistics, and check approaching or passed deadlines';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting Assignment Deadline Tracking...');

        $assignments = Assignment::with(['class', 'section', 'subject', 'submissions'])->get();
        $now = Carbon::now();

        $processed = 0;
        foreach ($assignments as $assignment) {
            $deadline = Carbon::parse($assignment->deadline)->endOfDay();
            $students = Student::where('class_id', $assignment->class_id)
                ->where('section_id', $assignment->section_id)
                ->get();

            $totalStudents = $students->count();
            $submittedStudentIds = $assignment->submissions->pluck('student_id')->toArray();
            $submittedCount = count($submittedStudentIds);
            $pendingCount = max(0, $totalStudents - $submittedCount);

            $this->line("Assignment #{$assignment->id} [{$assignment->title}]: Total={$totalStudents}, Submitted={$submittedCount}, Pending={$pendingCount}");

            $isExpired = $now->isAfter($deadline);
            $isApproaching = !$isExpired && $now->diffInHours($deadline, false) <= 24;

            if ($isApproaching && $pendingCount > 0) {
                $this->warn("Deadline approaching within 24h for Assignment #{$assignment->id}. Pending: {$pendingCount} students.");
            } elseif ($isExpired) {
                $this->comment("Deadline passed for Assignment #{$assignment->id}. Final Submission: {$submittedCount}/{$totalStudents}");
            }

            $processed++;
        }

        $this->info("Completed tracking for {$processed} assignments.");
        return 0;
    }
}
