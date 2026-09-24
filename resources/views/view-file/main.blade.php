<div class="main-panel">
    <div class="content-wrapper">
        <!-- Dashboard Top Header / Welcome & Quick Actions -->
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-3 gap-2">
            <div>
                <h2 class="h3 font-bold mb-1 d-flex align-items-center gap-2">
                    Welcome back, {{ Auth::user()->name ?? 'Administrator' }}
                    <span class="badge badge-soft-primary" style="font-size: 11px;">Admin Dashboard</span>
                </h2>
                <p class="text-muted mb-0 text-xs">Here is what is happening across your school today, <strong>{{ date('l, F j, Y') }}</strong>.</p>
            </div>

            <!-- Quick Action Buttons -->
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <a href="{{ route('student') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-user-plus"></i> New Student
                </a>
                <a href="{{ route('employees_create') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-user-tie"></i> Add Staff
                </a>
                <a href="{{ route('fee.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-receipt"></i> Collect Fee
                </a>
            </div>
        </div>

        <!-- 6 Compact Metric Cards Grid -->
        <div class="row g-2 mb-3">
            <!-- 1. Total Students -->
            <div class="col-6 col-md-4 col-xl-2 mb-2">
                <div class="erp-stat-card">
                    <div class="erp-stat-content">
                        <span class="erp-stat-label">Students</span>
                        <div class="erp-stat-value">{{ $students ?? 0 }}</div>
                        <span class="erp-stat-trend positive">
                            <i class="fas fa-arrow-up"></i> Active
                        </span>
                    </div>
                    <div class="erp-stat-icon-wrapper primary">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                </div>
            </div>

            <!-- 2. Total Faculty / Employees -->
            <div class="col-6 col-md-4 col-xl-2 mb-2">
                <div class="erp-stat-card">
                    <div class="erp-stat-content">
                        <span class="erp-stat-label">Faculty</span>
                        <div class="erp-stat-value">{{ $employee ?? 0 }}</div>
                        <span class="erp-stat-trend neutral">
                            <i class="fas fa-users"></i> Staff
                        </span>
                    </div>
                    <div class="erp-stat-icon-wrapper info">
                        <i class="fas fa-chalkboard-user"></i>
                    </div>
                </div>
            </div>

            <!-- 3. Classes & Sections -->
            <div class="col-6 col-md-4 col-xl-2 mb-2">
                <div class="erp-stat-card">
                    <div class="erp-stat-content">
                        <span class="erp-stat-label">Classes</span>
                        <div class="erp-stat-value">{{ $classes_count ?? 10 }}</div>
                        <span class="erp-stat-trend neutral">
                            {{ $sections_count ?? 20 }} Sections
                        </span>
                    </div>
                    <div class="erp-stat-icon-wrapper purple">
                        <i class="fas fa-school"></i>
                    </div>
                </div>
            </div>

            <!-- 4. Fee Inflow -->
            <div class="col-6 col-md-4 col-xl-2 mb-2">
                <div class="erp-stat-card">
                    <div class="erp-stat-content">
                        <span class="erp-stat-label">Fee Income</span>
                        <div class="erp-stat-value" style="font-size: 16px;">Rs. {{ number_format($income ?? 0) }}</div>
                        <span class="erp-stat-trend positive">
                            <i class="fas fa-arrow-up"></i> Inflow
                        </span>
                    </div>
                    <div class="erp-stat-icon-wrapper success">
                        <i class="fas fa-money-check-dollar"></i>
                    </div>
                </div>
            </div>

            <!-- 5. Total Expenses & Salary -->
            <div class="col-6 col-md-4 col-xl-2 mb-2">
                <div class="erp-stat-card">
                    <div class="erp-stat-content">
                        <span class="erp-stat-label">Expenses</span>
                        <div class="erp-stat-value" style="font-size: 16px;">Rs. {{ number_format(($expence ?? 0) + ($totalSalary ?? 0)) }}</div>
                        <span class="erp-stat-trend negative">
                            <i class="fas fa-arrow-down"></i> Outflow
                        </span>
                    </div>
                    <div class="erp-stat-icon-wrapper danger">
                        <i class="fas fa-receipt"></i>
                    </div>
                </div>
            </div>

            <!-- 6. Net Surplus / Balance -->
            <div class="col-6 col-md-4 col-xl-2 mb-2">
                <div class="erp-stat-card">
                    <div class="erp-stat-content">
                        <span class="erp-stat-label">Net Balance</span>
                        @php
                            $netBalance = ($income ?? 0) - (($expence ?? 0) + ($totalSalary ?? 0));
                        @endphp
                        <div class="erp-stat-value" style="font-size: 16px; color: {{ $netBalance >= 0 ? 'var(--erp-success)' : 'var(--erp-danger)' }};">
                            Rs. {{ number_format($netBalance) }}
                        </div>
                        <span class="erp-stat-trend {{ $netBalance >= 0 ? 'positive' : 'negative' }}">
                            {{ $netBalance >= 0 ? 'Surplus' : 'Deficit' }}
                        </span>
                    </div>
                    <div class="erp-stat-icon-wrapper warning">
                        <i class="fas fa-scale-balanced"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts & Analytics Section -->
        <div class="row g-3 mb-3">
            <!-- Left: Financial Analysis (Line/Bar) -->
            <div class="col-12 col-xl-8 mb-3">
                <div class="card h-100 mb-0">
                    <div class="card-header d-flex align-items-center justify-content-between py-2">
                        <div>
                            <h4 class="card-title">Financial Performance Overview</h4>
                            <div class="card-subtitle">Fee collection vs operating expenses and staff salaries</div>
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            <span class="badge badge-soft-success">In: Rs. {{ number_format($income ?? 0) }}</span>
                            <span class="badge badge-soft-danger">Out: Rs. {{ number_format(($expence ?? 0) + ($totalSalary ?? 0)) }}</span>
                        </div>
                    </div>
                    <div class="card-body py-2">
                        <div style="height: 220px; position: relative;">
                            <canvas id="revenue-chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Attendance Summary (Doughnut) -->
            <div class="col-12 col-xl-4 mb-3">
                <div class="card h-100 mb-0">
                    <div class="card-header d-flex align-items-center justify-content-between py-2">
                        <div>
                            <h4 class="card-title">Daily Attendance</h4>
                            <div class="card-subtitle">Today's overall student and staff presence</div>
                        </div>
                        <a href="{{ route('students_attendence') }}" class="btn btn-sm btn-outline-primary" style="padding: 2px 8px; font-size: 11px;">View All</a>
                    </div>
                    <div class="card-body py-2 d-flex flex-column align-items-center justify-content-center">
                        <div style="height: 160px; width: 160px; position: relative;" class="my-1">
                            <canvas id="student-attendance-chart"></canvas>
                        </div>
                        <div class="d-flex justify-content-center gap-3 mt-2 flex-wrap">
                            <span class="d-flex align-items-center gap-1 text-xs"><span class="badge-dot" style="width: 8px; height: 8px; border-radius: 50%; background: #10b981; display: inline-block;"></span> Present ({{ $studentAttendance->sum('present') }})</span>
                            <span class="d-flex align-items-center gap-1 text-xs"><span class="badge-dot" style="width: 8px; height: 8px; border-radius: 50%; background: #ef4444; display: inline-block;"></span> Absent ({{ $studentAttendance->sum('absent') }})</span>
                            <span class="d-flex align-items-center gap-1 text-xs"><span class="badge-dot" style="width: 8px; height: 8px; border-radius: 50%; background: #f59e0b; display: inline-block;"></span> Leave ({{ $studentAttendance->sum('leave') }})</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Grid: Recent Admissions & Quick Actions -->
        <div class="row g-3">
            <!-- Recent Student Admissions Table -->
            <div class="col-12 col-xl-8 mb-3">
                <div class="card mb-0">
                    <div class="card-header d-flex align-items-center justify-content-between py-2">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-user-graduate text-primary"></i>
                            <h4 class="card-title">Recently Enrolled Students</h4>
                        </div>
                        <a href="{{ route('student-list') }}" class="btn btn-sm btn-outline-primary">View Full Directory</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive" style="border: none;">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Registration</th>
                                        <th>Student Name</th>
                                        <th>Class & Section</th>
                                        <th>Guardian</th>
                                        <th>Fee</th>
                                        <th>Status</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentStudents ?? [] as $st)
                                    <tr>
                                        <td>
                                            <span class="font-weight-semibold text-primary">{{ $st->registration }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="erp-user-avatar" style="width: 24px; height: 24px; font-size: 10px;">
                                                    {{ strtoupper(substr($st->name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="font-weight-semibold">{{ $st->name }}</div>
                                                    <small class="text-muted">{{ $st->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-secondary">{{ $st->class->name ?? 'Class' }} - {{ $st->section->name ?? 'Sec' }}</span>
                                        </td>
                                        <td>{{ ucfirst($st->gurdian ?? 'Father') }}</td>
                                        <td>Rs. {{ number_format($st->tution_fee ?? 0) }}</td>
                                        <td>
                                            <span class="badge badge-soft-success">{{ ucfirst($st->status ?? 'Active') }}</span>
                                        </td>
                                        <td class="text-right">
                                            <div class="erp-table-actions justify-content-end">
                                                <a href="{{ route('student-edit', $st->id) }}" class="erp-action-btn edit" title="Edit Student">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                <a href="{{ route('student-list') }}" class="erp-action-btn view" title="View Profile">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">
                                            <i class="fas fa-folder-open mb-2" style="font-size: 24px;"></i>
                                            <div>No student records found.</div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Quick Modules & Upcoming Highlights -->
            <div class="col-12 col-xl-4 mb-3">
                <div class="card mb-0">
                    <div class="card-header py-2">
                        <h4 class="card-title"><i class="fas fa-bolt text-warning mr-1"></i> Quick Action Hub</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2" style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                            <a href="{{ route('timeTable') }}" class="p-2 border rounded text-center text-decoration-none d-flex flex-column align-items-center justify-content-center bg-light" style="transition: all 0.15s ease;">
                                <i class="fas fa-calendar-alt text-primary mb-1" style="font-size: 16px;"></i>
                                <span class="font-weight-semibold text-xs text-dark">TimeTable</span>
                            </a>
                            <a href="{{ route('exam-list') }}" class="p-2 border rounded text-center text-decoration-none d-flex flex-column align-items-center justify-content-center bg-light" style="transition: all 0.15s ease;">
                                <i class="fas fa-file-signature text-purple mb-1" style="font-size: 16px;"></i>
                                <span class="font-weight-semibold text-xs text-dark">Exams</span>
                            </a>
                            <a href="{{ route('syllabus_show') }}" class="p-2 border rounded text-center text-decoration-none d-flex flex-column align-items-center justify-content-center bg-light" style="transition: all 0.15s ease;">
                                <i class="fas fa-book-open text-info mb-1" style="font-size: 16px;"></i>
                                <span class="font-weight-semibold text-xs text-dark">Syllabus</span>
                            </a>
                            <a href="{{ route('assignment_show') }}" class="p-2 border rounded text-center text-decoration-none d-flex flex-column align-items-center justify-content-center bg-light" style="transition: all 0.15s ease;">
                                <i class="fas fa-tasks text-success mb-1" style="font-size: 16px;"></i>
                                <span class="font-weight-semibold text-xs text-dark">Assignments</span>
                            </a>
                        </div>

                        <div class="border-top mt-3 pt-3">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="font-weight-bold text-xs text-uppercase text-muted">Upcoming Events & Exams</span>
                                <a href="{{ route('exam-schedule-list') }}" class="text-xs font-weight-semibold">Schedules</a>
                            </div>
                            <div class="d-flex flex-column gap-2">
                                <div class="p-2 rounded border-left border-primary bg-light" style="border-left-width: 3px !important;">
                                    <div class="font-weight-semibold text-xs text-dark">Mid-Term Examination 2026</div>
                                    <small class="text-muted">Grade 1 to 10 • Starting next Monday</small>
                                </div>
                                <div class="p-2 rounded border-left border-success bg-light" style="border-left-width: 3px !important;">
                                    <div class="font-weight-semibold text-xs text-dark">Monthly Fee Submission Deadline</div>
                                    <small class="text-muted">Due by 10th of every month</small>
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
            <span class="text-muted">Enterprise School Management Platform v2.5</span>
        </div>
    </footer>
</div>
