<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <!-- Section: Main Overview -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="fas fa-gauge-high menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        <!-- Section: Academic -->
        <span class="erp-sidebar-section-title">Academic & Learning</span>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#academic-menu" aria-expanded="false" aria-controls="academic-menu">
                <i class="fas fa-graduation-cap menu-icon"></i>
                <span class="menu-title">Academic</span>
                <i class="fas fa-chevron-right menu-arrow"></i>
            </a>
            <div class="collapse" id="academic-menu" data-parent="#sidebar">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="{{ route('subject_show') }}">Subjects</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('class-list') }}">Classes</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('section-list') }}">Sections</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('syllabus_show') }}">Syllabus</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('assignment_show') }}">Assignments</a></li>
                </ul>
            </div>
        </li>

        <!-- Section: User Management -->
        <span class="erp-sidebar-section-title">User Management</span>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#user-mgmt-menu" aria-expanded="false" aria-controls="user-mgmt-menu">
                <i class="fas fa-users-gear menu-icon"></i>
                <span class="menu-title">User Management</span>
                <i class="fas fa-chevron-right menu-arrow"></i>
            </a>
            <div class="collapse" id="user-mgmt-menu" data-parent="#sidebar">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="{{ route('designation_view') }}">Designation</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('employee_view') }}">Employees & Staff</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('student-list') }}">Students</a></li>
                </ul>
            </div>
        </li>

        <!-- Section: Schedules, Attendance & Exams -->
        <span class="erp-sidebar-section-title">Schedule & Evaluation</span>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#timetable-menu" aria-expanded="false" aria-controls="timetable-menu">
                <i class="fas fa-calendar-days menu-icon"></i>
                <span class="menu-title">TimeTable</span>
                <i class="fas fa-chevron-right menu-arrow"></i>
            </a>
            <div class="collapse" id="timetable-menu" data-parent="#sidebar">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="{{ route('timeTable') }}">Master TimeTable</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('timeTable_show') }}">Class TimeTable</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('teacher_timeTable_show') }}">Teacher TimeTable</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#attendance-menu" aria-expanded="false" aria-controls="attendance-menu">
                <i class="fas fa-user-check menu-icon"></i>
                <span class="menu-title">Attendance</span>
                <i class="fas fa-chevron-right menu-arrow"></i>
            </a>
            <div class="collapse" id="attendance-menu" data-parent="#sidebar">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="{{ route('employee_attendence') }}">Employee Attendance</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('students_attendence') }}">Student Attendance</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#exam-menu" aria-expanded="false" aria-controls="exam-menu">
                <i class="fas fa-file-pen menu-icon"></i>
                <span class="menu-title">Exams & Results</span>
                <i class="fas fa-chevron-right menu-arrow"></i>
            </a>
            <div class="collapse" id="exam-menu" data-parent="#sidebar">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="{{ route('exam-list') }}">Exams</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('exam-schedule-list') }}">Exam Schedules</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('result') }}">Enter Results</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('result-list') }}">Result Sheet</a></li>
                </ul>
            </div>
        </li>

        <!-- Section: Finance & Billing -->
        <span class="erp-sidebar-section-title">Finance & Billing</span>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#payment-menu" aria-expanded="false" aria-controls="payment-menu">
                <i class="fas fa-hand-holding-dollar menu-icon"></i>
                <span class="menu-title">Student Fee</span>
                <i class="fas fa-chevron-right menu-arrow"></i>
            </a>
            <div class="collapse" id="payment-menu" data-parent="#sidebar">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="{{ route('transaction.types') }}">Fee Categories</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('transaction.view') }}">Fee Transactions</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('fee.index') }}">Collect Fee</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('taxes.create') }}">Create Taxes</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('taxe.index') }}">Manage Taxes</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#finance-menu" aria-expanded="false" aria-controls="finance-menu">
                <i class="fas fa-wallet menu-icon"></i>
                <span class="menu-title">Finance & Salary</span>
                <i class="fas fa-chevron-right menu-arrow"></i>
            </a>
            <div class="collapse" id="finance-menu" data-parent="#sidebar">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="{{ route('finance') }}">Finance Records</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('finance.salary') }}">Employee Salaries</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('balanceSheet') }}">
                <i class="fas fa-scale-balanced menu-icon"></i>
                <span class="menu-title">Balance Sheet</span>
            </a>
        </li>

        <!-- Section: Administration & Inventory -->
        <span class="erp-sidebar-section-title">Logistics & Reports</span>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#inventory-menu" aria-expanded="false" aria-controls="inventory-menu">
                <i class="fas fa-boxes-stacked menu-icon"></i>
                <span class="menu-title">Inventory</span>
                <i class="fas fa-chevron-right menu-arrow"></i>
            </a>
            <div class="collapse" id="inventory-menu" data-parent="#sidebar">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="{{ route('inventory.category') }}">Categories</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('inventory.subCatagory') }}">Sub-Categories</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('inventory.expences') }}">School Expenses</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#report-menu" aria-expanded="false" aria-controls="report-menu">
                <i class="fas fa-chart-pie menu-icon"></i>
                <span class="menu-title">Reports</span>
                <i class="fas fa-chevron-right menu-arrow"></i>
            </a>
            <div class="collapse" id="report-menu" data-parent="#sidebar">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="{{ route('admissionReport') }}">Admission Report</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('resultReport') }}">Result Report</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('inventory.expences') }}">Expenses Report</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.student') }}">
                <i class="fas fa-timeline menu-icon"></i>
                <span class="menu-title">Student History</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.notification') }}">
                <i class="fas fa-bell menu-icon"></i>
                <span class="menu-title">System Alerts</span>
            </a>
        </li>
    </ul>
</nav>
