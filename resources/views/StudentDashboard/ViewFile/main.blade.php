<div class="main-panel">
    <div class="content-wrapper">
        <!-- Dashboard Top Header / Welcome & Quick Actions -->
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-3 gap-2">
            <div>
                <h2 class="h3 font-bold mb-1 d-flex align-items-center gap-2">
                    Welcome back, {{ $student->name ?? 'Student' }}
                    <span class="badge badge-soft-primary" style="font-size: 11px;">Student Portal</span>
                </h2>
                <p class="text-muted mb-0 text-xs">
                    Class: <strong>{{ $student->class->name ?? 'Class' }} ({{ $student->section->name ?? 'Sec' }})</strong> • 
                    Roll / Reg: <strong>{{ $student->registration ?? $student->username }}</strong> • 
                    Stream: <strong>{{ ucfirst($student->group ?? 'Science') }}</strong> • 
                    Today is <strong>{{ date('l, F j, Y') }}</strong>
                </p>
            </div>

            <!-- Quick Action Buttons -->
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <a href="{{ route('timetable.student') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-calendar-alt"></i> Timetable
                </a>
                <a href="{{ route('student.assignments') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-tasks"></i> Assignments
                </a>
                <a href="{{ route('fee.student') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-receipt"></i> Fee Voucher
                </a>
            </div>
        </div>

        <!-- 4 Key Metric ERP Stat Cards Grid -->
        <div class="row g-3 mb-3">
            <!-- 1. Attendance Rate -->
            <div class="col-sm-6 col-xl-3">
                <div class="erp-stat-card">
                    <div class="erp-stat-content">
                        <span class="erp-stat-label">Attendance Rate</span>
                        <div class="erp-stat-value text-dark">{{ number_format($attendancePercentage, 1) }}%</div>
                        <span class="erp-stat-trend positive">
                            <i class="fas fa-check"></i> {{ $totalPresent }} Days Present ({{ $totalAbsent }} Absent)
                        </span>
                    </div>
                    <div class="erp-stat-icon-wrapper success">
                        <i class="fas fa-user-check"></i>
                    </div>
                </div>
            </div>

            <!-- 2. Assignments / Homework -->
            <div class="col-sm-6 col-xl-3">
                <div class="erp-stat-card">
                    <div class="erp-stat-content">
                        <span class="erp-stat-label">Homework & Tasks</span>
                        <div class="erp-stat-value text-dark">
                            {{ $pendingAssignmentsCount }} <span style="font-size: 13px; font-weight: 500; color: #64748b;">Pending</span>
                        </div>
                        <span class="erp-stat-trend {{ $pendingAssignmentsCount == 0 ? 'positive' : 'neutral' }}">
                            <i class="fas fa-tasks"></i> {{ $submittedAssignmentsCount }} of {{ $totalAssignmentsCount }} tasks submitted
                        </span>
                    </div>
                    <div class="erp-stat-icon-wrapper primary">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                </div>
            </div>

            <!-- 3. Today's Routine / Schedule -->
            <div class="col-sm-6 col-xl-3">
                <div class="erp-stat-card">
                    <div class="erp-stat-content">
                        <span class="erp-stat-label">Today's Routine</span>
                        <div class="erp-stat-value text-dark">
                            {{ $todayTimetable->count() }} <span style="font-size: 13px; font-weight: 500; color: #64748b;">Lectures</span>
                        </div>
                        <span class="erp-stat-trend neutral">
                            <i class="fas fa-calendar-day"></i> {{ now()->format('l') }} Schedule
                        </span>
                    </div>
                    <div class="erp-stat-icon-wrapper purple">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
            </div>

            <!-- 4. Monthly Tuition Fee -->
            <div class="col-sm-6 col-xl-3">
                <div class="erp-stat-card">
                    <div class="erp-stat-content">
                        <span class="erp-stat-label">Tuition Fee</span>
                        <div class="erp-stat-value text-dark" style="white-space: nowrap;">
                            Rs. {{ number_format($student->tution_fee ?? 3500) }}
                        </div>
                        <span class="erp-stat-trend positive">
                            <i class="fas fa-file-invoice-dollar"></i> Monthly Tuition Due
                        </span>
                    </div>
                    <div class="erp-stat-icon-wrapper warning">
                        <i class="fas fa-money-check-dollar"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts & Analytics Section -->
        <div class="row g-3 mb-3">
            <!-- Left: Academic Activity & Attendance Breakdown (Bar Chart) -->
            <div class="col-12 col-xl-8 mb-3">
                <div class="card h-100 mb-0">
                    <div class="card-header d-flex align-items-center justify-content-between py-2">
                        <div>
                            <h4 class="card-title">Academic & Attendance Overview</h4>
                            <div class="card-subtitle">Coursework activity breakdown and academic engagement</div>
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            <span class="badge badge-soft-success">Present: {{ $totalPresent }} Days</span>
                            <span class="badge badge-soft-danger">Absent: {{ $totalAbsent }} Days</span>
                        </div>
                    </div>
                    <div class="card-body py-2">
                        <div style="height: 220px; position: relative;">
                            <canvas id="student-academic-chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Attendance Summary (Doughnut) -->
            <div class="col-12 col-xl-4 mb-3">
                <div class="card h-100 mb-0">
                    <div class="card-header d-flex align-items-center justify-content-between py-2">
                        <div>
                            <h4 class="card-title">Attendance Ratio</h4>
                            <div class="card-subtitle">Overall presence & leave distribution</div>
                        </div>
                        <a href="{{ route('attendence.student') }}" class="btn btn-sm btn-outline-primary" style="padding: 2px 8px; font-size: 11px;">View Log</a>
                    </div>
                    <div class="card-body py-2 d-flex flex-column align-items-center justify-content-center">
                        <div style="height: 160px; width: 160px; position: relative;" class="my-1">
                            <canvas id="student-attendance-chart"></canvas>
                        </div>
                        <div class="d-flex justify-content-center gap-3 mt-2 flex-wrap">
                            <span class="d-flex align-items-center gap-1 text-xs"><span class="badge-dot" style="width: 8px; height: 8px; border-radius: 50%; background: #10b981; display: inline-block;"></span> Present ({{ $totalPresent }})</span>
                            <span class="d-flex align-items-center gap-1 text-xs"><span class="badge-dot" style="width: 8px; height: 8px; border-radius: 50%; background: #ef4444; display: inline-block;"></span> Absent ({{ $totalAbsent }})</span>
                            <span class="d-flex align-items-center gap-1 text-xs"><span class="badge-dot" style="width: 8px; height: 8px; border-radius: 50%; background: #f59e0b; display: inline-block;"></span> Leave ({{ $totalLeave }})</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Grid: Coursework Table & Quick Action Hub -->
        <div class="row g-3">
            <!-- Left: Active Homework & Routine Tables -->
            <div class="col-12 col-xl-8 mb-3">
                <!-- 1. Active Homework & Coursework Table -->
                <div class="card mb-3">
                    <div class="card-header d-flex align-items-center justify-content-between py-2">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-tasks text-primary"></i>
                            <h4 class="card-title">Active Homework & Assignments</h4>
                        </div>
                        <a href="{{ route('student.assignments') }}" class="btn btn-sm btn-outline-primary">View All Assignments</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive" style="border: none;">
                            <table class="table table-hover align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Subject</th>
                                        <th>Assignment Title</th>
                                        <th>Instructor</th>
                                        <th>Deadline</th>
                                        <th>Status</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($assignments ?? [] as $assign)
                                        @php
                                            $isSubmitted = $assign->submissions->isNotEmpty();
                                            $userSub = $assign->submissions->first();
                                            $deadline = \Carbon\Carbon::parse($assign->deadline)->endOfDay();
                                            $isOverdue = now()->isAfter($deadline);
                                        @endphp
                                        <tr>
                                            <td>
                                                <span class="badge badge-soft-secondary">{{ $assign->subject->subject_name ?? 'General' }}</span>
                                            </td>
                                            <td>
                                                <div class="font-weight-semibold text-dark">{{ $assign->title }}</div>
                                                <small class="text-muted">Total Marks: {{ $assign->total_marks ?? 100 }} Pts</small>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center gap-1">
                                                    <i class="fas fa-user-tie text-muted text-xs"></i>
                                                    <span class="text-xs">{{ $assign->teacher->name ?? $assign->uploader ?? 'Teacher' }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-xs font-weight-medium">{{ \Carbon\Carbon::parse($assign->deadline)->format('M d, Y') }}</span>
                                            </td>
                                            <td>
                                                @if($isSubmitted)
                                                    @if($userSub->marks !== null)
                                                        <span class="badge badge-soft-success">Graded: {{ $userSub->marks }}/{{ $assign->total_marks ?? 100 }}</span>
                                                    @else
                                                        <span class="badge badge-soft-info">Submitted</span>
                                                    @endif
                                                @else
                                                    @if($isOverdue)
                                                        <span class="badge badge-soft-danger">Overdue</span>
                                                    @else
                                                        <span class="badge badge-soft-warning">Due {{ \Carbon\Carbon::parse($assign->deadline)->diffForHumans() }}</span>
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                <div class="erp-table-actions justify-content-end">
                                                    <a href="{{ route('student.assignment.detail', ['id' => $assign->id]) }}" class="btn btn-xs btn-primary" title="View Details">
                                                        {{ $isSubmitted ? 'View' : 'Submit' }} <i class="fas fa-arrow-right ms-1"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4 text-muted">
                                                <i class="fas fa-clipboard-check mb-2" style="font-size: 24px;"></i>
                                                <div>No pending assignments. You are all caught up!</div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- 2. Today's Class Timetable Routine -->
                <div class="card mb-0">
                    <div class="card-header d-flex align-items-center justify-content-between py-2">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-calendar-day text-purple"></i>
                            <h4 class="card-title">Today's Class Timetable ({{ date('l') }})</h4>
                        </div>
                        <a href="{{ route('timetable.student') }}" class="btn btn-sm btn-outline-primary">Full Weekly Routine</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive" style="border: none;">
                            <table class="table table-hover align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Period / Time</th>
                                        <th>Subject</th>
                                        <th>Instructor / Teacher</th>
                                        <th class="text-right">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($todayTimetable ?? [] as $slot)
                                        <tr>
                                            <td>
                                                <span class="font-weight-semibold text-primary">
                                                    <i class="fas fa-clock text-muted mr-1"></i> {{ $slot->start_time }} - {{ $slot->end_time }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge badge-soft-primary">{{ $slot->subject->subject_name ?? 'Subject' }}</span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="erp-user-avatar" style="width: 24px; height: 24px; font-size: 10px;">
                                                        {{ strtoupper(substr($slot->teacher->name ?? 'T', 0, 1)) }}
                                                    </div>
                                                    <span class="font-weight-semibold">{{ $slot->teacher->name ?? 'Instructor' }}</span>
                                                </div>
                                            </td>
                                            <td class="text-right">
                                                <span class="badge badge-soft-success">
                                                    <i class="fas fa-circle-dot" style="font-size: 8px;"></i> Scheduled
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-muted">
                                                <i class="fas fa-mug-hot mb-2" style="font-size: 24px;"></i>
                                                <div>No lectures scheduled for today. Check your full weekly timetable.</div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Quick Action Hub & Upcoming Highlights -->
            <div class="col-12 col-xl-4 mb-3">
                <div class="card mb-0">
                    <div class="card-header py-2">
                        <h4 class="card-title"><i class="fas fa-bolt text-warning mr-1"></i> Quick Action Hub</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2" style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                            <a href="{{ route('timetable.student') }}" class="p-2 border rounded text-center text-decoration-none d-flex flex-column align-items-center justify-content-center bg-light" style="transition: all 0.15s ease;">
                                <i class="fas fa-calendar-alt text-primary mb-1" style="font-size: 16px;"></i>
                                <span class="font-weight-semibold text-xs text-dark">TimeTable</span>
                            </a>
                            <a href="{{ route('result.student') }}" class="p-2 border rounded text-center text-decoration-none d-flex flex-column align-items-center justify-content-center bg-light" style="transition: all 0.15s ease;">
                                <i class="fas fa-file-signature text-purple mb-1" style="font-size: 16px;"></i>
                                <span class="font-weight-semibold text-xs text-dark">Exam Results</span>
                            </a>
                            <a href="{{ route('student.assignments') }}" class="p-2 border rounded text-center text-decoration-none d-flex flex-column align-items-center justify-content-center bg-light" style="transition: all 0.15s ease;">
                                <i class="fas fa-tasks text-success mb-1" style="font-size: 16px;"></i>
                                <span class="font-weight-semibold text-xs text-dark">Assignments</span>
                            </a>
                            <a href="{{ route('fee.student') }}" class="p-2 border rounded text-center text-decoration-none d-flex flex-column align-items-center justify-content-center bg-light" style="transition: all 0.15s ease;">
                                <i class="fas fa-receipt text-info mb-1" style="font-size: 16px;"></i>
                                <span class="font-weight-semibold text-xs text-dark">Fee Voucher</span>
                            </a>
                        </div>

                        <div class="border-top mt-3 pt-3">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="font-weight-bold text-xs text-uppercase text-muted">Upcoming Events & Notices</span>
                                <a href="{{ route('student.notifications') }}" class="text-xs font-weight-semibold">Notices</a>
                            </div>
                            <div class="d-flex flex-column gap-2">
                                <div class="p-2 rounded border-left border-primary bg-light" style="border-left-width: 3px !important;">
                                    <div class="font-weight-semibold text-xs text-dark">Mid-Term Examination 2026</div>
                                    <small class="text-muted">Grade {{ $student->class->name ?? 'Level' }} • Starting next week</small>
                                </div>
                                <div class="p-2 rounded border-left border-success bg-light" style="border-left-width: 3px !important;">
                                    <div class="font-weight-semibold text-xs text-dark">Monthly Fee Submission Deadline</div>
                                    <small class="text-muted">Due by 10th of every month</small>
                                </div>
                                <div class="p-2 rounded border-left border-warning bg-light" style="border-left-width: 3px !important;">
                                    <div class="font-weight-semibold text-xs text-dark">Annual Science Exhibition</div>
                                    <small class="text-muted">Register project with class incharge</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Compact Footer -->
    <footer class="footer">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <span>© 2026 <strong>EduSuite School Management ERP</strong>. All rights reserved.</span>
            <span class="text-muted">Student Portal v2.5</span>
        </div>
    </footer>
</div>

<style>
    /* Metric Statistics Card (Spacious & Modern) */
    .erp-stat-card {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 18px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        transition: all 0.2s ease;
        height: 100%;
    }
    .erp-stat-card:hover {
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.06);
        transform: translateY(-2px);
        border-color: #cbd5e1;
    }
    .erp-stat-content {
        display: flex;
        flex-direction: column;
        justify-content: center;
        min-width: 0;
        flex: 1;
        margin-right: 12px;
    }
    .erp-stat-label {
        font-size: 11.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #64748b;
        margin-bottom: 4px;
    }
    .erp-stat-value {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
        letter-spacing: -0.02em;
        margin-bottom: 4px;
    }
    .erp-stat-trend {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 11.5px;
        font-weight: 500;
        line-height: 1.3;
    }
    .erp-stat-trend.positive { color: #10b981; }
    .erp-stat-trend.negative { color: #ef4444; }
    .erp-stat-trend.neutral { color: #64748b; }
    .erp-stat-icon-wrapper {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }
    .erp-stat-icon-wrapper.primary { background-color: #eef2ff; color: #4f46e5; }
    .erp-stat-icon-wrapper.success { background-color: #ecfdf5; color: #10b981; }
    .erp-stat-icon-wrapper.warning { background-color: #fffbeb; color: #f59e0b; }
    .erp-stat-icon-wrapper.danger { background-color: #fef2f2; color: #ef4444; }
    .erp-stat-icon-wrapper.info { background-color: #f0f9ff; color: #0ea5e9; }
    .erp-stat-icon-wrapper.purple { background-color: #f5f3ff; color: #8b5cf6; }
</style>
