<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
      <a class="navbar-brand brand-logo mr-5" href="{{ route('student.dashboard') }}">
        <div class="d-flex align-items-center gap-2">
          <div style="width: 32px; height: 32px; background: #4f46e5; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white;">
            <i class="fas fa-graduation-cap"></i>
          </div>
          <span style="font-weight: 800; font-size: 18px; color: #1e1b4b; letter-spacing: -0.5px;">EduSuite</span>
        </div>
      </a>
      <a class="navbar-brand brand-logo-mini" href="{{ route('student.dashboard') }}">
        <div style="width: 32px; height: 32px; background: #4f46e5; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white;">
          <i class="fas fa-graduation-cap"></i>
        </div>
      </a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
      <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
        <span class="icon-menu"></span>
      </button>
      <ul class="navbar-nav mr-lg-2">
        <li class="nav-item nav-search d-none d-lg-block">
          <div class="input-group">
            <div class="input-group-prepend hover-cursor" id="navbar-search-icon">
              <span class="input-group-text" id="search">
                <i class="icon-search"></i>
              </span>
            </div>
            <input type="text" class="form-control" id="navbar-search-input" placeholder="Search coursework, assignments, timetable..." aria-label="search" aria-describedby="search">
          </div>
        </li>
      </ul>
      <ul class="navbar-nav navbar-nav-right">
        <!-- Notifications -->
        <li class="nav-item dropdown">
          <a class="nav-link count-indicator" id="notificationDropdown" href="{{ route('student.notifications') }}">
              <i class="icon-bell mx-0"></i>
              @if(isset($unreadNotifications) && $unreadNotifications->count() > 0)
                  <span class="badge badge-danger badge-pill position-absolute" style="top: 0; right: 0;">
                      {{ $unreadNotifications->count() }}
                  </span>
              @endif
          </a>
        </li>
        <li class="nav-item nav-profile dropdown">
          <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" data-toggle="dropdown" id="profileDropdown">
            @php $navStudent = Auth::guard('student')->user(); @endphp
            @if($navStudent && $navStudent->image && $navStudent->image !== 'default.png')
              <img src="{{ asset('storage/' . $navStudent->image) }}" alt="profile" style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover;"/>
            @else
              <div style="width: 36px; height: 36px; border-radius: 50%; background: #4f46e5; color: white; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: bold;">
                {{ $navStudent ? strtoupper(substr($navStudent->name, 0, 1)) : 'S' }}
              </div>
            @endif
          </a>
          <div class="dropdown-menu dropdown-menu-right navbar-dropdown shadow-sm" aria-labelledby="profileDropdown" style="border-radius: 12px; min-width: 180px;">
            <a class="dropdown-item py-2" href="{{ route('profile.student') }}">
              <i class="fas fa-user-pen text-primary me-2"></i> My Profile
            </a>
            <a class="dropdown-item py-2" href="{{ route('student.assignments') }}">
              <i class="fas fa-clipboard-list text-success me-2"></i> Assignments
            </a>
            <a class="dropdown-item py-2" href="{{ route('timetable.student') }}">
              <i class="fas fa-calendar-week text-purple me-2"></i> Timetable
            </a>
            <div class="dropdown-divider my-1"></div>
            <a class="dropdown-item py-2">
              <form method="POST" action="{{ route('student.logout') }}" class="m-0">
                  @csrf
                  <button type="submit" class="dropdown-item p-0 border-0 bg-transparent text-danger font-weight-semibold">
                       <i class="fas fa-arrow-right-from-bracket me-2"></i> {{ __('Log Out') }}
                  </button>
              </form>
            </a>
          </div>
        </li>
        <li class="nav-item nav-settings d-none d-lg-flex">
          <a class="nav-link" href="#">
            <i class="icon-ellipsis"></i>
          </a>
        </li>
      </ul>
      <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
        <span class="icon-menu"></span>
      </button>
    </div>
  </nav>
