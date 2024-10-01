<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <i class="icon-layout menu-icon"></i>
                <span class="menu-title">Exam</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('exam-list') }}">Exam</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('exam-schedule-list') }}">Exam Schedule</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('result') }}">Result</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('result-list') }}">Result List</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('employee_view') }}">
                <i class="fas fa-users menu-icon"></i>
                <span class="menu-title">Employees</span>

            </a>

            <div class="collapse" id="form-elements">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="pages/forms/basic_elements.html">Basic Elements</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/student/list') }}">
                <i class="fas fa-briefcase menu-icon"></i>
                <span class="menu-title">Student</span>

            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('designation_view') }}">
                <i class="fas fa-briefcase menu-icon"></i>
                <span class="menu-title">Designation</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
                <i class="fas fa-school menu-icon"></i>
                <span class="menu-title">Academic</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="charts">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('subject_show') }}">Subject</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('class-list') }}">Class</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('section-list') }}">Section</a></li>

                    <li class="nav-item"> <a class="nav-link" href="{{ route('syllabus_show') }}">Syllabus</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('assignment_show') }}">Assignment</a></li>

                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
                <i class="fas fa-clock menu-icon"></i>
                <span class="menu-title">TimeTable</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="tables">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('timeTable') }}">TimeTable</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('timeTable_show') }}">Class TimeTable</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('teacher_timeTable_show') }}">Teacher
                            TimeTable</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#icons" aria-expanded="false" aria-controls="icons">
                <i class="fas fa-user-check menu-icon"></i>
                <span class="menu-title">Attendance</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="icons">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('employee_attendence') }}">Employee
                            Attendence</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('students_attendence') }}">Student
                            Attendence</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                <i class="fas  fa-balance-scale menu-icon"></i>
                <span class="menu-title">Finance Management</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="auth">
                <ul class="nav flex-column sub-menu">
                    {{-- <li class="nav-item"> <a class="nav-link" href="{{ route('salary') }}"> Manage Salary </a></li> --}}
                    <li class="nav-item"> <a class="nav-link" href="{{ route('finance') }}">Manage Transactions </a>
                    </li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('finance.salary') }}">Manage Salary
                        </a></li>

                </ul>
            </div>
        </li>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#error" aria-expanded="false" aria-controls="error">
                <i class="fa-solid fa-money-bill menu-icon"></i>
                <span class="menu-title">Student Payment</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="error">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('transaction.types') }}">Transaction
                            Categories </a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('transaction.view') }}">Manage
                            Transactions </a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('fee.index') }}">Manage Fee </a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('taxes.create') }}">Taxe's </a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('taxe.index') }}">Manage Taxe's </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#inventory" aria-expanded="false"
                aria-controls="inventory">
                <i class="fas fa-boxes menu-icon"></i>
                <span class="menu-title">Inventory</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="inventory">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('inventory.category') }}">Category</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link"
                            href="{{ route('inventory.subCatagory') }}">SubCategory</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('inventory.expences') }}">Expences</a>
                    </li>

                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.student') }}">
                <i class="icon-paper menu-icon"></i>
                <span class="menu-title">History</span>
                <a class="nav-link" href="{{ route('admin.notification') }}">
                    <i class="icon-paper menu-icon"></i>
                    <span class="menu-title">notifications</span>
                </a>
        </li>
        <!-- Add Balance Sheet li -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('balanceSheet') }}">
                <i class="fas fa-balance-scale menu-icon"></i>
                <span class="menu-title">Balance Sheet</span>
            </a>
        </li>


    <li class="nav-item">

        <a class="nav-link" data-toggle="collapse" href="#report" aria-expanded="false">

            <i class="icon-paper menu-icon"></i>

            <span class="menu-title">Report</span>

            <i class="menu-arrow"></i>

        </a>

        <div class="collapse" id="report">

            <ul class="nav flex-column sub-menu">

                <li class="nav-item"> <a class="nav-link" href="{{ route('admissionReport') }}">Admission Report</a>
                </li>

                <li class="nav-item"> <a class="nav-link" href="{{ route('resultReport') }}">Result Report</a></li>

                <li class="nav-item"> <a class="nav-link" href="{{ route('inventory.expences') }}">Expences</a></li>

                {{-- <li class="nav-item"> <a class="nav-link" href="{{ route('inventory.suppliers') }}">Suppliers</a></li>

                  <li class="nav-item"> <a class="nav-link" href="{{ route('inventory.purchase') }}">Purchase</a></li> --}}

            </ul>

        </div>

    </li>

    </ul>
</ul>
</nav>
</nav>
