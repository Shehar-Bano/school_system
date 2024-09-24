<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Skydash Admin</title>
    <!-- plugins:')}} -->
    <link rel="stylesheet" href="{{ asset('assesst/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assesst/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assesst/vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- Plugin ')}} for this page -->
    <link rel="stylesheet" href="{{ asset('assesst/vendors/datatables.net-bs4/dataTables.bootstrap4.') }}">
    <link rel="stylesheet" href="{{ asset('assesst/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" type="text/')}}" href="{{ asset('assesst/js/select.dataTables.min.') }}">
    <!-- End plugin ')}} for this page -->
    <!-- inject:')}} -->
    <link rel="stylesheet" href="{{ asset('assesst/css/vertical-layout-light/style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('assesst/images/favicon.png') }}" />
    {{-- cdn for fontawsome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Include SweetAlert CSS and JS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            border: 1px rgb(56, 56, 56);
            box-shadow: 0 2px 10px rgba(114, 114, 114, 0.1);
        }

        .header {
            background-color: #4B49AC;
            color: white;
            padding: 10px;
            border-radius: 8px 8px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h4 {
            margin: 0;
            display: flex;
            align-items: center;
        }

        .header h4 i {
            margin-right: 10px;
        }

        .header a {
            color: whitesmoke;
            text-decoration: none;
        }

        .dropdown-toggle::after {
            display: none;
        }
    </style>
</head>

<body>
    <div class="container-scroller">
        {{-- navebar --}}
        <!-- Navbar with notifications -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand brand-logo mr-5" href="index.html"><img
                        src="{{ asset('assesst/images/logo.svg') }}" class="mr-2" alt="logo" /></a>
                <a class="navbar-brand brand-logo-mini" href="index.html"><img
                        src="{{ asset('assesst/images/logo-mini.svg') }}" alt="logo" /></a>
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
                            <input type="text" class="form-control" id="navbar-search-input" placeholder="Search now"
                                aria-label="search" aria-describedby="search">
                        </div>
                    </li>
                </ul>
                <ul class="navbar-nav navbar-nav-right">
                    <!-- Notifications -->
                    <li class="nav-item dropdown">
                        <a class="nav-link count-indicator" id="notificationDropdown"
                            href="{{ route('employee.notifications') }}">
                            <i class="icon-bell mx-0"></i>
                            <!-- Display the count of unread notifications in a red circular badge -->
                            @if ($unreadNotifications->count() > 0)
                                <span class="badge badge-danger badge-pill position-absolute" style="top: 0; right: 0;">
                                    {{ $unreadNotifications->count() }}
                                </span>
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                            aria-labelledby="notificationDropdown">
                            <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>

                            <!-- Loop through the unread notifications -->
                            @forelse($unreadNotifications as $notification)
                                <a class="dropdown-item preview-item"
                                    href="{{ route('notifications.read', $notification->id) }}">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-success">
                                            <i class="ti-info-alt mx-0"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <h6 class="preview-subject font-weight-normal">
                                            {{ $notification->data['title'] }}</h6>
                                        <p class="font-weight-light small-text mb-0 text-muted">
                                            {{ $notification->data['message'] }}
                                        </p>
                                        <small>Received: {{ $notification->created_at->diffForHumans() }}</small>
                                    </div>
                                </a>
                            @empty
                                <a class="dropdown-item preview-item">
                                    <div class="preview-item-content">
                                        <p class="font-weight-normal mb-0">No new notifications</p>
                                    </div>
                                </a>
                            @endforelse
                        </div>
                    </li>


                    <!-- Profile and Logout -->
                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                            <img src="{{ asset('assesst/images/faces/face28.jpg') }}" alt="profile" />
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                            aria-labelledby="profileDropdown">
                            <a class="dropdown-item">
                                <form method="POST" action="{{ route('employee.logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('employee.logout')"
                                        onclick="event.preventDefault();
                                          this.closest('form').submit();"
                                        style="color: black">
                                        <i class="ti-power-off text-primary"></i> {{ __('Log Out') }}
                                    </x-dropdown-link>
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
            </div>
        </nav>




        <!--sidebar-->
        <div class="container-fluid page-body-wrapper">
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <!-- Dashboard Item -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('employee.dashboard') }}">
                            <i class="icon-grid menu-icon"></i>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </li>

                    <!-- Profile Item -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('profile.employee') }}">
                            <i class="fas fa-user menu-icon"></i>
                            <span class="menu-title">Profile</span>
                        </a>
                    </li>

                    <!-- Exam Item with Collapse -->
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false"
                            aria-controls="ui-basic">
                            <i class="icon-layout menu-icon"></i>
                            <span class="menu-title">Exam</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="ui-basic">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"><a class="nav-link"
                                        href="{{ route('employee.exams') }}">Exam</a></li>
                                <li class="nav-item"><a class="nav-link"
                                        href="{{ route('employee.exam.schedules') }}">Exam Schedule</a></li>
                                <li class="nav-item"><a class="nav-link"
                                        href="{{ route('employee.exam.result.add') }}">Result</a></li>
                                <li class="nav-item"><a class="nav-link"
                                        href="{{ route('employee.exam.result') }}">Result List</a></li>
                            </ul>
                        </div>
                    </li>

                    <!-- Attendance Item -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('attendance.employee') }}">
                            <i class="fas fa-calendar-check menu-icon"></i>
                            <span class="menu-title">Attendance</span>
                        </a>
                    </li>

                    <!-- Time Table Item -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('timetable.employee') }}">
                            <i class="fas fa-calendar-week menu-icon"></i>
                            <span class="menu-title">Time Table</span>
                        </a>
                    </li>

                    <!-- Incentives Item -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('incentives.employee') }}">
                            <i class="fas fa-award menu-icon"></i>
                            <span class="menu-title">Incentives</span>
                        </a>
                    </li>

                </ul>
            </nav>




            @yield('content')
        </div>
    </div>
    <!-- plugins:js -->
    <script src="{{ asset('assesst/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{ asset('assesst/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('assesst/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assesst/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('js/dataTables.select.min.js') }}"></script>

    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('assesst/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assesst/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('assesst/js/template.js') }}"></script>
    <script src="{{ asset('assesst/js/settings.js') }}"></script>
    <script src="{{ asset('assesst/js/todolist.js') }}"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="{{ asset('assesst/js/dashboard.js') }}"></script>
    <script src="{{ asset('assesst/js/Chart.roundedBarCharts.js') }}"></script>
    <!-- End custom js for this page-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <!-- jsPDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <!-- SheetJS (Excel) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
    <!-- clipboard.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.10/clipboard.min.js"></script>
    <!-- jsPDF AutoTable Plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


</body>

</html>
