<nav class="navbar p-0 fixed-top d-flex flex-row">
    <!-- Brand Logo Area -->
    <div class="navbar-brand-wrapper d-flex align-items-center justify-content-start">
        <a class="erp-brand" href="{{ route('dashboard') }}">
            <div class="erp-brand-logo">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div class="erp-brand-text">
                <span class="erp-brand-title">EduSuite</span>
                <span class="erp-brand-subtitle">School ERP</span>
            </div>
        </a>
    </div>

    <!-- Header Actions & Navigation Menu Wrapper -->
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between">
        <!-- Left: Toggle Button & Breadcrumbs -->
        <div class="d-flex align-items-center">
            <button class="erp-toggle-btn navbar-toggler align-self-center mr-2" type="button" data-toggle="minimize" title="Toggle Sidebar">
                <i class="fas fa-bars-staggered"></i>
            </button>

            <div class="erp-breadcrumbs d-none d-md-flex">
                <a href="{{ route('dashboard') }}"><i class="fas fa-home mr-1"></i> Dashboard</a>
                <span class="divider"><i class="fas fa-chevron-right"></i></span>
                <span class="current">Administration Portal</span>
            </div>
        </div>

        <!-- Center: Global Quick Search Input -->
        <div class="d-none d-lg-block">
            <div class="erp-header-search">
                <i class="fas fa-magnifying-glass search-icon"></i>
                <input type="text" id="global-erp-search" placeholder="Search students, teachers, records..." autocomplete="off">
                <span class="search-badge">⌘K</span>
            </div>
        </div>

        <!-- Right: Actions, Term Badge, Notifications & Profile -->
        <div class="erp-header-actions">
            <!-- Academic Term Badge -->
            <div class="erp-term-badge d-none d-sm-inline-flex">
                <span class="dot"></span>
                <span>Session 2026-27</span>
            </div>

            <!-- Notifications Dropdown -->
            <div class="dropdown">
                <button class="erp-icon-btn dropdown-toggle" type="button" id="erpNotificationDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Notifications">
                    <i class="fas fa-bell"></i>
                    <span class="badge-dot"></span>
                </button>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list p-2 shadow-sm" style="width: 290px; border-radius: 8px; border: 1px solid #e2e8f0;" aria-labelledby="erpNotificationDropdown">
                    <div class="d-flex align-items-center justify-content-between px-2 py-1 mb-2 border-bottom">
                        <span class="font-weight-bold text-xs text-uppercase text-muted">Notifications</span>
                        <a href="{{ route('admin.notification') }}" class="text-xs font-weight-bold">View All</a>
                    </div>
                    <a class="dropdown-item py-2 px-2 d-flex align-items-start gap-2 rounded" href="{{ route('admin.notification') }}">
                        <div class="erp-stat-icon-wrapper success" style="width: 28px; height: 28px; font-size: 11px;">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="lh-sm">
                            <p class="mb-0 font-weight-semibold text-xs text-dark">New Admission Registered</p>
                            <small class="text-muted" style="font-size: 10px;">5 mins ago</small>
                        </div>
                    </a>
                    <a class="dropdown-item py-2 px-2 d-flex align-items-start gap-2 rounded" href="{{ route('admin.notification') }}">
                        <div class="erp-stat-icon-wrapper warning" style="width: 28px; height: 28px; font-size: 11px;">
                            <i class="fas fa-receipt"></i>
                        </div>
                        <div class="lh-sm">
                            <p class="mb-0 font-weight-semibold text-xs text-dark">Fee Collection Recorded</p>
                            <small class="text-muted" style="font-size: 10px;">1 hour ago</small>
                        </div>
                    </a>
                </div>
            </div>

            <!-- User Profile Chip & Dropdown -->
            <div class="dropdown">
                <div class="erp-user-chip dropdown-toggle" id="erpProfileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="erp-user-avatar">
                        {{ strtoupper(substr(Auth::user()->name ?? 'SA', 0, 2)) }}
                    </div>
                    <div class="erp-user-info d-none d-md-flex">
                        <span class="erp-user-name">{{ Auth::user()->name ?? 'Super Admin' }}</span>
                        <span class="erp-user-role">{{ ucfirst(Auth::user()->usertype ?? 'Administrator') }}</span>
                    </div>
                    <i class="fas fa-chevron-down ml-1 text-muted" style="font-size: 9px;"></i>
                </div>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown shadow-sm p-1" style="border-radius: 8px; border: 1px solid #e2e8f0; min-width: 170px;" aria-labelledby="erpProfileDropdown">
                    <div class="px-3 py-2 border-bottom mb-1">
                        <div class="font-weight-semibold text-xs text-dark">{{ Auth::user()->name ?? 'Super Admin' }}</div>
                        <div class="text-muted" style="font-size: 10.5px;">{{ Auth::user()->email ?? 'admin@admin.com' }}</div>
                    </div>
                    <a class="dropdown-item py-2 px-3 text-xs d-flex align-items-center gap-2 rounded" href="{{ route('profile.edit') }}">
                        <i class="fas fa-user-gear text-muted" style="width: 14px;"></i> My Profile
                    </a>
                    <a class="dropdown-item py-2 px-3 text-xs d-flex align-items-center gap-2 rounded" href="{{ route('admin.notification') }}">
                        <i class="fas fa-bell text-muted" style="width: 14px;"></i> System Alerts
                    </a>
                    <div class="dropdown-divider my-1"></div>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="dropdown-item py-2 px-3 text-xs text-danger d-flex align-items-center gap-2 rounded font-weight-medium">
                            <i class="fas fa-arrow-right-from-bracket" style="width: 14px;"></i> Log Out
                        </button>
                    </form>
                </div>
            </div>

            <!-- Mobile Drawer Toggler -->
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center er-toggle-btn ml-1" type="button" data-toggle="offcanvas">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>
</nav>