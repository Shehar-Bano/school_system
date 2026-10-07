<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('student.dashboard') }}">
        <i class="icon-grid menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>

    <li class="nav-item {{ request()->routeIs('profile.student') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('profile.student') }}">
        <i class="fas fa-id-card menu-icon"></i>
        <span class="menu-title">My Profile</span>
      </a>
    </li>

    <li class="nav-item {{ request()->routeIs('student.assignments*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('student.assignments') }}">
        <i class="fas fa-clipboard-list menu-icon"></i>
        <span class="menu-title">Assignments</span>
      </a>
    </li>

    <li class="nav-item {{ request()->routeIs('timetable.student') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('timetable.student') }}">
        <i class="fas fa-calendar-week menu-icon"></i>
        <span class="menu-title">Timetable</span>
      </a>
    </li>

    <li class="nav-item {{ request()->routeIs('attendence.student') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('attendence.student') }}">
        <i class="fas fa-user-check menu-icon"></i>
        <span class="menu-title">Attendance</span>
      </a>
    </li>

    <li class="nav-item {{ request()->routeIs('result.student') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('result.student') }}">
        <i class="fas fa-award menu-icon"></i>
        <span class="menu-title">Exam Results</span>
      </a>
    </li>

    <li class="nav-item {{ request()->routeIs('fee.student') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('fee.student') }}">
        <i class="fas fa-file-invoice-dollar menu-icon"></i>
        <span class="menu-title">Fee Vouchers</span>
      </a>
    </li>

    <li class="nav-item {{ request()->routeIs('student.history*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('student.history') }}">
        <i class="fas fa-clock-rotate-left menu-icon"></i>
        <span class="menu-title">Academic History</span>
      </a>
    </li>
  </ul>
</nav>
