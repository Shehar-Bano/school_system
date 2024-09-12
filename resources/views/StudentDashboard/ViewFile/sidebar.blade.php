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
        <a class="nav-link" data-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
          <i class="fas fa-clock menu-icon"></i>
          <span class="menu-title">TimeTable</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="tables">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{route('timetable.student')}}">Class TimeTable</a></li>
          </ul>
        </div>
    </li>



       
    </ul>
  </nav>
