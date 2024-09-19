<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <li class="nav-item">
        <a class="nav-link" href="{{route('student.dashboard')}}">
          <i class="icon-grid menu-icon"></i>
          <span class="menu-title">Dashboard</span>
        </a>
      </li>
    </li>
    <li class="nav-item">
     <a class="nav-link" href="{{route('profile.student')}}" >
      <i class="fas fa-briefcase menu-icon"></i>
      <span class="menu-title">Student</span>

    </a>
  </li>

    <li class="nav-item">
        <a class="nav-link" href="{{route('timetable.student')}}" aria-expanded="false" aria-controls="tables">
          <i class="fas fa-clock menu-icon"></i>
          <span class="menu-title">TimeTable</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{route('attendence.student')}}" aria-expanded="false" aria-controls="tables">
            <i class="fas fa-user-check menu-icon"></i>
          <span class="menu-title">Attendence</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('result.student')}}" aria-expanded="false" aria-controls="tables">
            <i class="fas fa-user-check menu-icon"></i>
          <span class="menu-title">Result</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('fee.student')}}" aria-expanded="false" aria-controls="tables">
            <i class="fas fa-user-check menu-icon"></i>
          <span class="menu-title">Fee Voucher</span>
        </a>
    </li>



    </ul>
  </nav>
