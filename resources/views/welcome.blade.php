<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>EduSuite | Modern School Management & Learning Portal</title>
    <meta name="description" content="Next-generation School ERP and learning management system for students, teachers, parents, and administration.">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Fonts: Plus Jakarta Sans & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome & Feather Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assesst/vendors/feather/feather.css') }}">
    
    <!-- Custom Landing CSS -->
    <link rel="stylesheet" href="{{ asset('assesst/css/front-landing.css') }}?v={{ time() }}">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <!-- Background Dynamic Gradient Mesh -->
    <div class="mesh-bg">
        <div class="mesh-circle mesh-1"></div>
        <div class="mesh-circle mesh-2"></div>
        <div class="mesh-circle mesh-3"></div>
    </div>

    <!-- Navigation Header -->
    <nav class="front-navbar" id="mainNavbar">
        <div class="container d-flex align-items-center justify-content-between">
            <!-- Brand Logo -->
            <a href="{{ url('/') }}" class="brand-logo-wrap">
                <div class="brand-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div>
                    <div class="brand-title">EduSuite</div>
                    <div class="brand-tag">School Management System</div>
                </div>
            </a>

            <!-- Navigation Links -->
            <ul class="nav-links d-none d-lg-flex">
                <li><a href="#hero" class="nav-link-item active">Home</a></li>
                <li><a href="#portals" class="nav-link-item">Portals</a></li>
                <li><a href="#features" class="nav-link-item">Academics & ERP</a></li>
                <li><a href="#stats" class="nav-link-item">Campus Stats</a></li>
                <li><a href="#testimonials" class="nav-link-item">Community</a></li>
            </ul>

            <!-- Header Action Buttons -->
            <div class="d-flex align-items-center gap-2">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-erp btn-erp-primary">
                            <i class="fas fa-gauge-high"></i> Dashboard
                        </a>
                    @else
                        <!-- Direct Portal Dropdown -->
                        <div class="dropdown d-none d-sm-block">
                            <button class="btn-erp btn-erp-outline dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-door-open"></i> Quick Portals
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="border-radius: 10px; font-size: 13px;">
                                <li><a class="dropdown-item py-2" href="{{ route('student.login') }}"><i class="fas fa-user-graduate text-primary me-2"></i> Student Portal</a></li>
                                <li><a class="dropdown-item py-2" href="{{ route('employee.login') }}"><i class="fas fa-chalkboard-user text-success me-2"></i> Teacher & Staff Portal</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item py-2" href="javascript:void(0)" onclick="quickSelectRole('admin')"><i class="fas fa-shield-halved text-purple me-2"></i> Superadmin Sign In</a></li>
                            </ul>
                        </div>
                        <a href="#authSection" class="btn-erp btn-erp-primary" onclick="switchAuthTab('login')">
                            <i class="fas fa-arrow-right-to-bracket"></i> Sign In / Register
                        </a>
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- News & Notification Ticker Bar -->
    <div class="news-ticker-bar" style="margin-top: 76px;">
        <div class="container">
            <div class="ticker-wrap">
                <div class="ticker-badge">
                    <i class="fas fa-bullhorn"></i> Live Updates
                </div>
                <div class="ticker-content">
                    <div class="ticker-item">
                        <i class="fas fa-calendar-check"></i> Mid-term Examinations Date Sheet for Session 2026-27 is now published on the Student Portal.
                    </div>
                    <div class="ticker-item">
                        <i class="fas fa-award"></i> Annual Science & Robotics Exhibition registration opens this Friday.
                    </div>
                    <div class="ticker-item">
                        <i class="fas fa-bell"></i> Parent-Teacher Meeting (PTM) scheduled for upcoming Saturday at 10:00 AM.
                    </div>
                    <div class="ticker-item">
                        <i class="fas fa-laptop-code"></i> New E-Library & Digital Assignment Portal upgraded for all classes.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hero Section with Dual-Action Interactive Auth Card -->
    <section class="hero-section" id="hero">
        <div class="container">
            <div class="row align-items-center gy-5">
                <!-- Left Column: Hero Content & Highlights -->
                <div class="col-lg-6 col-xl-7">
                    <div class="hero-pill">
                        <span class="pulse-dot"></span>
                        <span>Academic Session 2026-27 Active</span>
                    </div>

                    <h1 class="hero-heading">
                        Next-Gen Smart <br>
                        <span class="gradient-text">School ERP</span> & Digital Learning Portal
                    </h1>

                    <p class="hero-desc">
                        Empowering students, faculty, and administration with a unified, cloud-based platform for automated attendance, gradebooks, fee vouchers, and real-time academic collaboration.
                    </p>

                    <!-- Highlights Grid -->
                    <div class="hero-highlights">
                        <div class="highlight-badge">
                            <div class="highlight-icon indigo">
                                <i class="fas fa-user-check"></i>
                            </div>
                            <div class="highlight-text">
                                <h6>Smart Attendance</h6>
                                <p>Real-time tracking & SMS alerts</p>
                            </div>
                        </div>

                        <div class="highlight-badge">
                            <div class="highlight-icon cyan">
                                <i class="fas fa-file-invoice-dollar"></i>
                            </div>
                            <div class="highlight-text">
                                <h6>Digital Fee Portal</h6>
                                <p>Automated receipts & vouchers</p>
                            </div>
                        </div>

                        <div class="highlight-badge">
                            <div class="highlight-icon emerald">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="highlight-text">
                                <h6>Result & Date Sheets</h6>
                                <p>Instant grade generation</p>
                            </div>
                        </div>

                        <div class="highlight-badge">
                            <div class="highlight-icon amber">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="highlight-text">
                                <h6>Smart Timetable</h6>
                                <p>Clash-free automated slots</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <a href="#portals" class="btn-erp btn-erp-primary">
                            <i class="fas fa-compass"></i> Explore Portals
                        </a>
                        <a href="#features" class="btn-erp btn-erp-outline">
                            <i class="fas fa-play"></i> ERP Features Overview
                        </a>
                    </div>
                </div>

                <!-- Right Column: Interactive Animated Auth Card (Login / Register / OTP) -->
                <div class="col-lg-6 col-xl-5" id="authSection">
                    <div class="auth-container-card">
                        <!-- Sliding Tabs (Sign In / Register) -->
                        <div class="auth-header-tabs">
                            <button type="button" class="auth-tab-btn active" id="tabLoginBtn" onclick="switchAuthTab('login')">
                                <i class="fas fa-lock"></i> Sign In
                            </button>
                            <button type="button" class="auth-tab-btn" id="tabRegisterBtn" onclick="switchAuthTab('register')">
                                <i class="fas fa-user-plus"></i> New here? Register
                            </button>
                        </div>

                        <div class="auth-card-body">
                            <!-- Display Session Status / Flash Messages -->
                            @if (session('status'))
                                <div class="alert alert-success d-flex align-items-center gap-2 p-2 mb-3" style="font-size: 12.5px; border-radius: 8px;">
                                    <i class="fas fa-check-circle"></i>
                                    <div>{{ session('status') }}</div>
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger d-flex align-items-center gap-2 p-2 mb-3" style="font-size: 12.5px; border-radius: 8px;">
                                    <i class="fas fa-circle-exclamation"></i>
                                    <div>{{ $errors->first() }}</div>
                                </div>
                            @endif

                            <!-- 1. LOGIN FORM -->
                            <div id="loginFormContainer">
                                <!-- Role Quick Selector Pills -->
                                <div class="role-pills" title="Quick Role Switcher">
                                    <button type="button" class="role-pill-btn active" id="roleBtnAdmin" onclick="quickSelectRole('admin')">
                                        <i class="fas fa-shield-halved"></i> Superadmin
                                    </button>
                                    <button type="button" class="role-pill-btn" id="roleBtnTeacher" onclick="quickSelectRole('teacher')">
                                        <i class="fas fa-chalkboard-user"></i> Faculty
                                    </button>
                                    <button type="button" class="role-pill-btn" id="roleBtnStudent" onclick="quickSelectRole('student')">
                                        <i class="fas fa-user-graduate"></i> Student
                                    </button>
                                </div>

                                <form method="POST" action="{{ route('login') }}" id="loginForm" onsubmit="handleLoginSubmit(event)">
                                    @csrf

                                    <!-- Email / Username Input -->
                                    <div class="form-floating-custom">
                                        <label for="loginEmail" id="loginHandleLabel">Admin Email Address</label>
                                        <div class="input-icon-wrap">
                                            <input type="text" class="form-control-custom" id="loginEmail" name="email" value="{{ old('email', 'admin@admin.com') }}" placeholder="admin@admin.com" required autofocus autocomplete="username">
                                            <i class="fas fa-envelope field-icon" id="loginHandleIcon"></i>
                                        </div>
                                    </div>

                                    <!-- Password Input -->
                                    <div class="form-floating-custom">
                                        <label for="loginPassword">Password</label>
                                        <div class="input-icon-wrap">
                                            <input type="password" class="form-control-custom" id="loginPassword" name="password" value="password" placeholder="Enter password" required autocomplete="current-password">
                                            <i class="fas fa-lock field-icon"></i>
                                            <button type="button" class="toggle-password" onclick="togglePasswordVisibility('loginPassword', this)" title="Show/Hide Password">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Remember Me & Forgot Password Row -->
                                    <div class="form-options-row">
                                        <label class="custom-checkbox" for="remember_me">
                                            <input id="remember_me" type="checkbox" name="remember" checked>
                                            <span>Remember me</span>
                                        </label>

                                        <a href="javascript:void(0)" class="forgot-link" onclick="openOtpWizardModal()">
                                            <i class="fas fa-key me-1"></i> Forgot Password?
                                        </a>
                                    </div>

                                    <!-- Submit Button -->
                                    <button type="submit" class="btn-auth-submit" id="loginSubmitBtn">
                                        <span class="btn-text"><i class="fas fa-arrow-right-to-bracket me-1"></i> Secure Sign In</span>
                                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                    </button>
                                </form>

                                <div class="auth-switch-footer">
                                    <span>New to EduSuite School Portal?</span>
                                    <a href="javascript:void(0)" onclick="switchAuthTab('register')">Create an Account</a>
                                </div>
                            </div>

                            <!-- 2. REGISTER FORM -->
                            <div id="registerFormContainer" style="display: none;">
                                <form method="POST" action="{{ route('register') }}" id="registerForm" onsubmit="handleRegisterSubmit(event)">
                                    @csrf

                                    <!-- Full Name -->
                                    <div class="form-floating-custom">
                                        <label for="regName">Full Name</label>
                                        <div class="input-icon-wrap">
                                            <input type="text" class="form-control-custom" id="regName" name="name" placeholder="John Doe" required autocomplete="name">
                                            <i class="fas fa-user field-icon"></i>
                                        </div>
                                    </div>

                                    <!-- Email Address -->
                                    <div class="form-floating-custom">
                                        <label for="regEmail">Email Address</label>
                                        <div class="input-icon-wrap">
                                            <input type="email" class="form-control-custom" id="regEmail" name="email" placeholder="student@school.com" required autocomplete="email">
                                            <i class="fas fa-envelope field-icon"></i>
                                        </div>
                                    </div>

                                    <!-- User Type / Account Role -->
                                    <div class="form-floating-custom">
                                        <label for="regUserType">Register As</label>
                                        <div class="input-icon-wrap">
                                            <select class="form-control-custom" id="regUserType" name="usertype" style="padding-left: 40px; cursor: pointer;">
                                                <option value="student">Student / Guardian</option>
                                                <option value="employee">Teacher / Faculty Staff</option>
                                                <option value="admin">School Administrator</option>
                                            </select>
                                            <i class="fas fa-id-badge field-icon"></i>
                                        </div>
                                    </div>

                                    <!-- Password -->
                                    <div class="form-floating-custom">
                                        <label for="regPassword">Password</label>
                                        <div class="input-icon-wrap">
                                            <input type="password" class="form-control-custom" id="regPassword" name="password" placeholder="Create strong password" required autocomplete="new-password">
                                            <i class="fas fa-lock field-icon"></i>
                                            <button type="button" class="toggle-password" onclick="togglePasswordVisibility('regPassword', this)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Confirm Password -->
                                    <div class="form-floating-custom">
                                        <label for="regPasswordConfirmation">Confirm Password</label>
                                        <div class="input-icon-wrap">
                                            <input type="password" class="form-control-custom" id="regPasswordConfirmation" name="password_confirmation" placeholder="Repeat your password" required autocomplete="new-password">
                                            <i class="fas fa-shield-check field-icon"></i>
                                        </div>
                                    </div>

                                    <!-- Terms Checkbox -->
                                    <div class="mb-3">
                                        <label class="custom-checkbox" for="regTerms">
                                            <input id="regTerms" type="checkbox" required checked>
                                            <span style="font-size: 11.5px;">I agree to the <a href="javascript:void(0)" class="forgot-link">Academic Policies</a> and Terms of Service.</span>
                                        </label>
                                    </div>

                                    <!-- Submit Button -->
                                    <button type="submit" class="btn-auth-submit" id="regSubmitBtn">
                                        <span class="btn-text"><i class="fas fa-user-plus me-1"></i> Register Account</span>
                                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                    </button>
                                </form>

                                <div class="auth-switch-footer">
                                    <span>Already have an account?</span>
                                    <a href="javascript:void(0)" onclick="switchAuthTab('login')">Sign In here</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Interactive Portals Access Section -->
    <section class="portals-section" id="portals">
        <div class="container">
            <div class="section-header">
                <div class="section-subtitle">
                    <i class="fas fa-shield-alt"></i> Unified Gateways
                </div>
                <h2 class="section-title">Dedicated User Portals</h2>
                <p class="section-desc">Tailored access environments designed specifically for students, teaching faculty, and institutional administrators.</p>
            </div>

            <div class="row g-4">
                <!-- 1. Administrator Portal Card -->
                <div class="col-md-4">
                    <div class="portal-card">
                        <div class="portal-icon-wrap admin">
                            <i class="fas fa-shield-halved"></i>
                        </div>
                        <h3 class="portal-title">Administrator Portal</h3>
                        <p class="portal-desc">Complete administrative control over admissions, employee payroll, fee balance sheets, role matrices, and institutional analytics.</p>
                        
                        <ul class="portal-features-list">
                            <li><i class="fas fa-check"></i> Multi-level RBAC Permissions Matrix</li>
                            <li><i class="fas fa-check"></i> Financial Ledgers & Revenue Reports</li>
                            <li><i class="fas fa-check"></i> Staff Management & Salary Generation</li>
                            <li><i class="fas fa-check"></i> Real-time Dashboard Analytics</li>
                        </ul>

                        <div class="mt-auto">
                            <a href="javascript:void(0)" onclick="quickSelectRole('admin'); document.getElementById('authSection').scrollIntoView({behavior: 'smooth'});" class="btn-erp btn-erp-primary w-100">
                                <i class="fas fa-lock"></i> Admin Sign In
                            </a>
                        </div>
                    </div>
                </div>

                <!-- 2. Teacher & Staff Portal Card -->
                <div class="col-md-4">
                    <div class="portal-card">
                        <div class="portal-icon-wrap teacher">
                            <i class="fas fa-chalkboard-user"></i>
                        </div>
                        <h3 class="portal-title">Faculty & Staff Portal</h3>
                        <p class="portal-desc">Dedicated workspace for educators to manage daily attendance, upload assignments, configure examination schedules, and compile grades.</p>
                        
                        <ul class="portal-features-list">
                            <li><i class="fas fa-check"></i> Daily Class Attendance Register</li>
                            <li><i class="fas fa-check"></i> Digital Exam Marksheets & Grading</li>
                            <li><i class="fas fa-check"></i> Syllabus & Assignment Upload</li>
                            <li><i class="fas fa-check"></i> Personal Timetable & Free Slots</li>
                        </ul>

                        <div class="mt-auto">
                            <a href="{{ route('employee.login') }}" class="btn-erp btn-erp-primary w-100" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                                <i class="fas fa-arrow-right-to-bracket"></i> Faculty Sign In
                            </a>
                        </div>
                    </div>
                </div>

                <!-- 3. Student Portal Card -->
                <div class="col-md-4">
                    <div class="portal-card">
                        <div class="portal-icon-wrap student">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <h3 class="portal-title">Student & Parent Portal</h3>
                        <p class="portal-desc">Empowering students and parents with instant access to report cards, exam date sheets, class timetables, fee vouchers, and notices.</p>
                        
                        <ul class="portal-features-list">
                            <li><i class="fas fa-check"></i> Digital Result Cards & Performance</li>
                            <li><i class="fas fa-check"></i> Examination Schedules & Datesheets</li>
                            <li><i class="fas fa-check"></i> Fee Invoices & Payment Receipts</li>
                            <li><i class="fas fa-check"></i> Attendance Record & Alerts</li>
                        </ul>

                        <div class="mt-auto">
                            <a href="{{ route('student.login') }}" class="btn-erp btn-erp-primary w-100" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);">
                                <i class="fas fa-arrow-right-to-bracket"></i> Student Sign In
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Core ERP Features Grid -->
    <section class="features-section" id="features">
        <div class="container">
            <div class="section-header">
                <div class="section-subtitle">
                    <i class="fas fa-cubes"></i> Comprehensive ERP Suite
                </div>
                <h2 class="section-title">End-to-End Academic Modules</h2>
                <p class="section-desc">Engineered to streamline institutional operations, eliminate paperwork, and enhance learning outcomes.</p>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="feature-box">
                        <div class="feature-icon" style="background: #eef2ff; color: #4f46e5;">
                            <i class="fas fa-id-card"></i>
                        </div>
                        <h4>Student Information System</h4>
                        <p>Complete 360° student lifecycle management from admission records, guardian contact info, sections, and historical academic logs.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="feature-box">
                        <div class="feature-icon" style="background: #ecfeff; color: #0891b2;">
                            <i class="fas fa-clipboard-user"></i>
                        </div>
                        <h4>Automated Attendance</h4>
                        <p>Smart attendance marking for students and faculty with status breakdowns (Present, Absent, Leave, Late) and instant reporting.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="feature-box">
                        <div class="feature-icon" style="background: #f0fdf4; color: #16a34a;">
                            <i class="fas fa-file-lines"></i>
                        </div>
                        <h4>Exams & Digital Results</h4>
                        <p>End-to-end exam creation, datesheet generation, subject marks recording, and automatic generation of printable student result cards.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="feature-box">
                        <div class="feature-icon" style="background: #fffbeb; color: #d97706;">
                            <i class="fas fa-receipt"></i>
                        </div>
                        <h4>Fee Collection & Finance</h4>
                        <p>Automated monthly fee generation, transaction logging, expense trackers, employee salary disbursement, and balance sheets.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="feature-box">
                        <div class="feature-icon" style="background: #faf5ff; color: #9333ea;">
                            <i class="fas fa-calendar-days"></i>
                        </div>
                        <h4>Dynamic Timetable Engine</h4>
                        <p>Clash-free class scheduling, teacher slot assignments, room allocation, and interactive timetable viewers for students.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="feature-box">
                        <div class="feature-icon" style="background: #fef2f2; color: #dc2626;">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <h4>Syllabus & Assignments</h4>
                        <p>Centralized digital curriculum repository with downloadable course materials, homework assignments, and deadline trackers.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Counter Banner -->
    <section class="stats-counter-section" id="stats">
        <div class="container">
            <div class="row g-4">
                <div class="col-6 col-md-3">
                    <div class="stat-item-box">
                        <div class="stat-number">4,250+</div>
                        <div class="stat-label"><i class="fas fa-user-graduate me-1"></i> Enrolled Students</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item-box">
                        <div class="stat-number">185+</div>
                        <div class="stat-label"><i class="fas fa-chalkboard-teacher me-1"></i> Qualified Teachers</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item-box">
                        <div class="stat-number">99.4%</div>
                        <div class="stat-label"><i class="fas fa-trophy me-1"></i> Board Exam Pass Rate</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item-box">
                        <div class="stat-number">100%</div>
                        <div class="stat-label"><i class="fas fa-leaf me-1"></i> Paperless Operations</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Community & Testimonials Section -->
    <section class="testimonials-section" id="testimonials">
        <div class="container">
            <div class="section-header">
                <div class="section-subtitle">
                    <i class="fas fa-heart"></i> Voices of Excellence
                </div>
                <h2 class="section-title">Trusted by Educators & Parents</h2>
                <p class="section-desc">Here is how EduSuite has modernized daily operations and transparent communication across our school community.</p>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <div>
                            <div class="testimonial-stars">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <p class="testimonial-quote">"EduSuite transformed our school administration. Result calculation and fee generation that used to take days now happen in seconds with complete accuracy."</p>
                        </div>
                        <div class="testimonial-author">
                            <div class="author-avatar">PA</div>
                            <div class="author-info">
                                <h6>Principal Anwar</h6>
                                <span>Head of Institution</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="testimonial-card">
                        <div>
                            <div class="testimonial-stars">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <p class="testimonial-quote">"As a teacher, marking attendance and updating exam marks directly from my phone saves so much classroom time. The timetable slot manager is flawless."</p>
                        </div>
                        <div class="testimonial-author">
                            <div class="author-avatar" style="background: #ecfdf5; color: #059669;">FK</div>
                            <div class="author-info">
                                <h6>Fatima Khan</h6>
                                <span>Senior Science Faculty</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="testimonial-card">
                        <div>
                            <div class="testimonial-stars">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <p class="testimonial-quote">"Checking my son's attendance record and downloading his exam date sheet and fee slips from home gives me complete peace of mind."</p>
                        </div>
                        <div class="testimonial-author">
                            <div class="author-avatar" style="background: #eff6ff; color: #2563eb;">MR</div>
                            <div class="author-info">
                                <h6>Muhammad Rashid</h6>
                                <span>Parent & Guardian</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="front-footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="brand-logo-wrap footer-brand">
                        <div class="brand-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div>
                            <div class="brand-title">EduSuite</div>
                            <div class="brand-tag">School Management System</div>
                        </div>
                    </div>
                    <p class="footer-desc">
                        A modern enterprise educational platform providing intelligent tools for academics, finance, student lifecycles, and institutional administration.
                    </p>
                    <div class="system-status-badge">
                        <span class="system-status-dot"></span>
                        <span>All Systems Operational • Session 2026-27</span>
                    </div>
                </div>

                <div class="col-6 col-lg-2 offset-lg-1">
                    <h5 class="footer-heading">Quick Portals</h5>
                    <ul class="footer-links-list">
                        <li><a href="{{ route('student.login') }}">Student Portal</a></li>
                        <li><a href="{{ route('employee.login') }}">Faculty Portal</a></li>
                        <li><a href="javascript:void(0)" onclick="quickSelectRole('admin'); document.getElementById('authSection').scrollIntoView({behavior: 'smooth'});">Admin Sign In</a></li>
                        <li><a href="#features">Academics & ERP</a></li>
                        <li><a href="#stats">Campus Overview</a></li>
                    </ul>
                </div>

                <div class="col-6 col-lg-2">
                    <h5 class="footer-heading">ERP Modules</h5>
                    <ul class="footer-links-list">
                        <li><a href="#features">Student Admissions</a></li>
                        <li><a href="#features">Smart Attendance</a></li>
                        <li><a href="#features">Exam & Datesheets</a></li>
                        <li><a href="#features">Fee Vouchers</a></li>
                        <li><a href="#features">Academic Timetable</a></li>
                    </ul>
                </div>

                <div class="col-lg-3">
                    <h5 class="footer-heading">Institutional Support</h5>
                    <p style="font-size: 13px; color: #94a3b8; margin-bottom: 12px;">
                        <i class="fas fa-location-dot text-primary me-2"></i> EduSuite Academic Campus, Main Education Boulevard
                    </p>
                    <p style="font-size: 13px; color: #94a3b8; margin-bottom: 12px;">
                        <i class="fas fa-envelope text-primary me-2"></i> support@edusuite.edu.pk
                    </p>
                    <p style="font-size: 13px; color: #94a3b8; margin-bottom: 12px;">
                        <i class="fas fa-phone text-primary me-2"></i> +92 (042) 111-EDU-ERP
                    </p>
                </div>
            </div>

            <div class="footer-bottom">
                <div>&copy; {{ date('Y') }} EduSuite School ERP. All Rights Reserved.</div>
                <div>Designed with <i class="fas fa-heart text-danger"></i> for Academic Excellence</div>
            </div>
        </div>
    </footer>

    <!-- =========================================================================
         FORGOT PASSWORD OTP WIZARD MODAL (Multi-Step In-Place Recovery)
         ========================================================================= -->
    <div class="otp-wizard-modal" id="otpWizardModal">
        <div class="otp-wizard-box">
            <button type="button" class="otp-close-btn" onclick="closeOtpWizardModal()" title="Close">
                <i class="fas fa-xmark"></i>
            </button>

            <!-- Wizard Step Dots -->
            <div class="otp-step-indicator">
                <div class="otp-step-dot active" id="dotStep1">1</div>
                <div class="otp-step-line" id="lineStep1"></div>
                <div class="otp-step-dot" id="dotStep2">2</div>
                <div class="otp-step-line" id="lineStep2"></div>
                <div class="otp-step-dot" id="dotStep3">3</div>
            </div>

            <!-- ================= STEP 1: REQUEST OTP ================= -->
            <div id="otpStep1Container">
                <div class="text-center mb-3">
                    <div style="width: 50px; height: 50px; border-radius: 50%; background: #eef2ff; color: #4f46e5; display: inline-flex; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 12px;">
                        <i class="fas fa-envelope-open-text"></i>
                    </div>
                    <h4 style="font-weight: 800; color: #0f172a; margin-bottom: 6px;">Reset Password</h4>
                    <p style="font-size: 13px; color: #64748b; margin: 0;">Enter your registered email address to receive a secure 6-digit OTP code.</p>
                </div>

                <form onsubmit="handleSendOtp(event)">
                    <div class="form-floating-custom">
                        <label for="otpEmailInput">Registered Email</label>
                        <div class="input-icon-wrap">
                            <input type="email" class="form-control-custom" id="otpEmailInput" placeholder="name@school.com" required value="admin@admin.com">
                            <i class="fas fa-envelope field-icon"></i>
                        </div>
                    </div>

                    <button type="submit" class="btn-auth-submit mt-3" id="sendOtpBtn">
                        <span class="btn-text"><i class="fas fa-paper-plane me-1"></i> Send 6-Digit OTP</span>
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    </button>
                </form>
            </div>

            <!-- ================= STEP 2: VERIFY 6-DIGIT OTP ================= -->
            <div id="otpStep2Container" style="display: none;">
                <div class="text-center mb-2">
                    <div style="width: 50px; height: 50px; border-radius: 50%; background: #ecfdf5; color: #059669; display: inline-flex; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 12px;">
                        <i class="fas fa-shield-halved"></i>
                    </div>
                    <h4 style="font-weight: 800; color: #0f172a; margin-bottom: 4px;">Enter Verification OTP</h4>
                    <p style="font-size: 12.5px; color: #64748b; margin: 0;">We have sent a 6-digit verification code to <b id="otpSentEmailDisplay" class="text-primary">user@example.com</b></p>
                </div>

                <!-- 6-Digit Pin Input Boxes -->
                <div class="otp-digit-inputs">
                    <input type="text" maxlength="1" class="otp-digit-box" id="otp1" oninput="handleOtpInput(this, 'otp2')" onkeydown="handleOtpBackspace(event, this, null)" autofocus>
                    <input type="text" maxlength="1" class="otp-digit-box" id="otp2" oninput="handleOtpInput(this, 'otp3')" onkeydown="handleOtpBackspace(event, this, 'otp1')">
                    <input type="text" maxlength="1" class="otp-digit-box" id="otp3" oninput="handleOtpInput(this, 'otp4')" onkeydown="handleOtpBackspace(event, this, 'otp2')">
                    <input type="text" maxlength="1" class="otp-digit-box" id="otp4" oninput="handleOtpInput(this, 'otp5')" onkeydown="handleOtpBackspace(event, this, 'otp3')">
                    <input type="text" maxlength="1" class="otp-digit-box" id="otp5" oninput="handleOtpInput(this, 'otp6')" onkeydown="handleOtpBackspace(event, this, 'otp4')">
                    <input type="text" maxlength="1" class="otp-digit-box" id="otp6" oninput="handleOtpInput(this, null)" onkeydown="handleOtpBackspace(event, this, 'otp5')">
                </div>

                <div class="d-flex align-items-center justify-content-between mb-3" style="font-size: 12.5px;">
                    <span class="text-muted">Code expires in: <strong id="otpTimerText" class="text-danger">05:00</strong></span>
                    <a href="javascript:void(0)" class="forgot-link" id="resendOtpBtn" onclick="resendOtpCode()" style="pointer-events: none; opacity: 0.5;">
                        <i class="fas fa-rotate-right me-1"></i> Resend OTP
                    </a>
                </div>

                <button type="button" class="btn-auth-submit" id="verifyOtpBtn" onclick="handleVerifyOtp()">
                    <span class="btn-text"><i class="fas fa-check-double me-1"></i> Verify OTP Code</span>
                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                </button>

                <div class="text-center mt-3">
                    <a href="javascript:void(0)" onclick="goToOtpStep(1)" style="font-size: 12.5px; color: #64748b; text-decoration: none;">
                        <i class="fas fa-arrow-left me-1"></i> Change email address
                    </a>
                </div>
            </div>

            <!-- ================= STEP 3: SET NEW PASSWORD ================= -->
            <div id="otpStep3Container" style="display: none;">
                <div class="text-center mb-3">
                    <div style="width: 50px; height: 50px; border-radius: 50%; background: #eff6ff; color: #2563eb; display: inline-flex; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 12px;">
                        <i class="fas fa-key"></i>
                    </div>
                    <h4 style="font-weight: 800; color: #0f172a; margin-bottom: 4px;">Set New Password</h4>
                    <p style="font-size: 12.5px; color: #64748b; margin: 0;">Create a strong new password for your account.</p>
                </div>

                <form onsubmit="handleResetPasswordSubmit(event)">
                    <!-- New Password -->
                    <div class="form-floating-custom">
                        <label for="newPasswordInput">New Password</label>
                        <div class="input-icon-wrap">
                            <input type="password" class="form-control-custom" id="newPasswordInput" placeholder="Min. 8 characters" required oninput="checkPasswordStrength(this.value)">
                            <i class="fas fa-lock field-icon"></i>
                            <button type="button" class="toggle-password" onclick="togglePasswordVisibility('newPasswordInput', this)">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <!-- Strength bar -->
                        <div class="pw-strength-bar">
                            <div class="pw-strength-fill" id="pwStrengthFill"></div>
                        </div>
                    </div>

                    <!-- Confirm New Password -->
                    <div class="form-floating-custom">
                        <label for="newPasswordConfirmInput">Confirm New Password</label>
                        <div class="input-icon-wrap">
                            <input type="password" class="form-control-custom" id="newPasswordConfirmInput" placeholder="Repeat new password" required>
                            <i class="fas fa-shield-check field-icon"></i>
                        </div>
                    </div>

                    <button type="submit" class="btn-auth-submit mt-3" id="savePasswordBtn">
                        <span class="btn-text"><i class="fas fa-floppy-disk me-1"></i> Update & Log In</span>
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Interactive Landing & Auth Scripts -->
    <script>
        // Navbar Scroll Effect
        window.addEventListener('scroll', function () {
            const nav = document.getElementById('mainNavbar');
            if (window.scrollY > 40) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        });

        // Tab Switcher (Login <-> Register)
        function switchAuthTab(tab) {
            const loginBtn = document.getElementById('tabLoginBtn');
            const regBtn = document.getElementById('tabRegisterBtn');
            const loginContainer = document.getElementById('loginFormContainer');
            const regContainer = document.getElementById('registerFormContainer');

            if (tab === 'login') {
                loginBtn.classList.add('active');
                regBtn.classList.remove('active');
                loginContainer.style.display = 'block';
                regContainer.style.display = 'none';
            } else {
                regBtn.classList.add('active');
                loginBtn.classList.remove('active');
                regContainer.style.display = 'block';
                loginContainer.style.display = 'none';
            }
        }

        // Quick Role Pill Auto-Fill
        function quickSelectRole(role) {
            document.querySelectorAll('.role-pill-btn').forEach(btn => btn.classList.remove('active'));
            const emailInput = document.getElementById('loginEmail');
            const passwordInput = document.getElementById('loginPassword');
            const loginForm = document.getElementById('loginForm');
            const handleLabel = document.getElementById('loginHandleLabel');
            const handleIcon = document.getElementById('loginHandleIcon');

            if (role === 'admin') {
                document.getElementById('roleBtnAdmin').classList.add('active');
                loginForm.action = '{{ route("login") }}';
                emailInput.name = 'email';
                emailInput.type = 'email';
                emailInput.placeholder = 'admin@admin.com';
                emailInput.value = 'admin@admin.com';
                passwordInput.value = 'password';
                if(handleLabel) handleLabel.innerText = 'Admin Email Address';
                if(handleIcon) handleIcon.className = 'fas fa-envelope field-icon';
            } else if (role === 'teacher') {
                document.getElementById('roleBtnTeacher').classList.add('active');
                loginForm.action = '{{ route("employee.login") }}';
                emailInput.name = 'email';
                emailInput.type = 'text';
                emailInput.placeholder = 'teacher@school.com or Phone';
                emailInput.value = 'teacher@school.com';
                passwordInput.value = 'password';
                if(handleLabel) handleLabel.innerText = 'Teacher Email or Phone';
                if(handleIcon) handleIcon.className = 'fas fa-chalkboard-user field-icon';
            } else if (role === 'student') {
                document.getElementById('roleBtnStudent').classList.add('active');
                loginForm.action = '{{ route("student.login") }}';
                emailInput.name = 'username';
                emailInput.type = 'text';
                emailInput.placeholder = 'std_username or Reg. No';
                emailInput.value = 'student';
                passwordInput.value = 'password';
                if(handleLabel) handleLabel.innerText = 'Student Username / Reg. No';
                if(handleIcon) handleIcon.className = 'fas fa-user-graduate field-icon';
            }
        }

        // Show/Hide Password Toggle
        function togglePasswordVisibility(fieldId, btn) {
            const input = document.getElementById(fieldId);
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Handle Login Submit Animation
        function handleLoginSubmit(event) {
            const btn = document.getElementById('loginSubmitBtn');
            btn.querySelector('.btn-text').classList.add('d-none');
            btn.querySelector('.spinner-border').classList.remove('d-none');
            btn.disabled = true;
        }

        // Handle Register Submit Animation
        function handleRegisterSubmit(event) {
            const btn = document.getElementById('regSubmitBtn');
            btn.querySelector('.btn-text').classList.add('d-none');
            btn.querySelector('.spinner-border').classList.remove('d-none');
            btn.disabled = true;
        }

        // =========================================================================
        // OTP WIZARD CONTROLLER & STATE
        // =========================================================================
        let currentOtpEmail = '';
        let currentResetToken = '';
        let otpCountdownInterval = null;
        let otpSecondsRemaining = 300;

        function openOtpWizardModal() {
            const modal = document.getElementById('otpWizardModal');
            const loginEmail = document.getElementById('loginEmail').value.trim();
            if (loginEmail) {
                document.getElementById('otpEmailInput').value = loginEmail;
            }
            goToOtpStep(1);
            modal.classList.add('active');
        }

        function closeOtpWizardModal() {
            document.getElementById('otpWizardModal').classList.remove('active');
            if (otpCountdownInterval) {
                clearInterval(otpCountdownInterval);
            }
        }

        function goToOtpStep(step) {
            document.getElementById('otpStep1Container').style.display = step === 1 ? 'block' : 'none';
            document.getElementById('otpStep2Container').style.display = step === 2 ? 'block' : 'none';
            document.getElementById('otpStep3Container').style.display = step === 3 ? 'block' : 'none';

            // Step dots
            const dot1 = document.getElementById('dotStep1');
            const dot2 = document.getElementById('dotStep2');
            const dot3 = document.getElementById('dotStep3');
            const line1 = document.getElementById('lineStep1');
            const line2 = document.getElementById('lineStep2');

            dot1.className = 'otp-step-dot' + (step >= 1 ? (step > 1 ? ' completed' : ' active') : '');
            line1.className = 'otp-step-line' + (step >= 2 ? ' active' : '');
            dot2.className = 'otp-step-dot' + (step >= 2 ? (step > 2 ? ' completed' : ' active') : '');
            line2.className = 'otp-step-line' + (step >= 3 ? ' active' : '');
            dot3.className = 'otp-step-dot' + (step === 3 ? ' active' : '');
        }

        // Step 1: Send OTP
        async function handleSendOtp(event) {
            event.preventDefault();
            const email = document.getElementById('otpEmailInput').value.trim();
            if (!email) return;

            const btn = document.getElementById('sendOtpBtn');
            btn.querySelector('.btn-text').classList.add('d-none');
            btn.querySelector('.spinner-border').classList.remove('d-none');
            btn.disabled = true;

            try {
                const response = await fetch('{{ route("password.otp.send") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ email: email })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    currentOtpEmail = email;
                    document.getElementById('otpSentEmailDisplay').innerText = email;

                    // If demo OTP is returned in local/debug mode, show a friendly helper notification
                    if (data.demo_otp) {
                        Swal.fire({
                            icon: 'info',
                            title: 'OTP Code Generated',
                            html: `<p>A 6-digit OTP code has been dispatched:</p><h2 style="letter-spacing: 4px; color: #4f46e5; font-weight: 800;">${data.demo_otp}</h2><p class="text-muted" style="font-size:12px;">(Simulated for instant testing)</p>`,
                            confirmButtonColor: '#4f46e5',
                            confirmButtonText: 'Auto-fill OTP'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                fillOtpDigits(data.demo_otp);
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'OTP Dispatched!',
                            text: data.message,
                            timer: 3000,
                            showConfirmButton: false
                        });
                    }

                    goToOtpStep(2);
                    startOtpCountdown();
                    setTimeout(() => document.getElementById('otp1').focus(), 200);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Verification Failed',
                        text: data.message || 'Unable to send OTP. Please check your email.',
                        confirmButtonColor: '#ef4444'
                    });
                }
            } catch (err) {
                Swal.fire({
                    icon: 'error',
                    title: 'Network Error',
                    text: 'Unable to connect to server. Please try again.',
                    confirmButtonColor: '#ef4444'
                });
            } finally {
                btn.querySelector('.btn-text').classList.remove('d-none');
                btn.querySelector('.spinner-border').classList.add('d-none');
                btn.disabled = false;
            }
        }

        // Auto-fill OTP Helper
        function fillOtpDigits(code) {
            const digits = code.toString().split('');
            for (let i = 0; i < 6; i++) {
                const input = document.getElementById(`otp${i+1}`);
                if (input && digits[i]) {
                    input.value = digits[i];
                }
            }
        }

        // 6-Digit Auto-Focus Logic
        function handleOtpInput(current, nextId) {
            current.value = current.value.replace(/[^0-9]/g, '');
            if (current.value.length === 1 && nextId) {
                document.getElementById(nextId).focus();
            }
        }

        function handleOtpBackspace(event, current, prevId) {
            if (event.key === 'Backspace' && !current.value && prevId) {
                document.getElementById(prevId).focus();
            }
        }

        // Countdown Timer
        function startOtpCountdown() {
            if (otpCountdownInterval) clearInterval(otpCountdownInterval);
            otpSecondsRemaining = 300; // 5 minutes
            const timerText = document.getElementById('otpTimerText');
            const resendBtn = document.getElementById('resendOtpBtn');
            resendBtn.style.pointerEvents = 'none';
            resendBtn.style.opacity = '0.5';

            otpCountdownInterval = setInterval(() => {
                otpSecondsRemaining--;
                const mins = Math.floor(otpSecondsRemaining / 60);
                const secs = otpSecondsRemaining % 60;
                timerText.innerText = `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;

                if (otpSecondsRemaining <= 0) {
                    clearInterval(otpCountdownInterval);
                    timerText.innerText = 'Expired';
                    resendBtn.style.pointerEvents = 'auto';
                    resendBtn.style.opacity = '1';
                }
            }, 1000);
        }

        function resendOtpCode() {
            handleSendOtp(new Event('submit'));
        }

        // Step 2: Verify OTP
        async function handleVerifyOtp() {
            let otp = '';
            for (let i = 1; i <= 6; i++) {
                otp += document.getElementById(`otp${i}`).value.trim();
            }

            if (otp.length !== 6) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Incomplete OTP',
                    text: 'Please enter the complete 6-digit verification code.',
                    confirmButtonColor: '#4f46e5'
                });
                return;
            }

            const btn = document.getElementById('verifyOtpBtn');
            btn.querySelector('.btn-text').classList.add('d-none');
            btn.querySelector('.spinner-border').classList.remove('d-none');
            btn.disabled = true;

            try {
                const response = await fetch('{{ route("password.otp.verify") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ email: currentOtpEmail, otp: otp })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    currentResetToken = data.reset_token;
                    if (otpCountdownInterval) clearInterval(otpCountdownInterval);

                    Swal.fire({
                        icon: 'success',
                        title: 'OTP Verified!',
                        text: 'Identity confirmed. Please create your new password.',
                        timer: 2000,
                        showConfirmButton: false
                    });

                    goToOtpStep(3);
                    setTimeout(() => document.getElementById('newPasswordInput').focus(), 200);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Verification Failed',
                        text: data.message || 'Invalid or expired OTP code.',
                        confirmButtonColor: '#ef4444'
                    });
                }
            } catch (err) {
                Swal.fire({
                    icon: 'error',
                    title: 'Network Error',
                    text: 'Unable to verify OTP. Please try again.',
                    confirmButtonColor: '#ef4444'
                });
            } finally {
                btn.querySelector('.btn-text').classList.remove('d-none');
                btn.querySelector('.spinner-border').classList.add('d-none');
                btn.disabled = false;
            }
        }

        // Password Strength Meter
        function checkPasswordStrength(password) {
            const bar = document.getElementById('pwStrengthFill');
            let strength = 0;
            if (password.length >= 6) strength += 25;
            if (password.length >= 8) strength += 25;
            if (/[A-Z]/.test(password)) strength += 25;
            if (/[0-9!@#$%^&*]/.test(password)) strength += 25;

            bar.style.width = strength + '%';
            if (strength <= 25) {
                bar.style.backgroundColor = '#ef4444';
            } else if (strength <= 50) {
                bar.style.backgroundColor = '#f59e0b';
            } else if (strength <= 75) {
                bar.style.backgroundColor = '#06b6d4';
            } else {
                bar.style.backgroundColor = '#10b981';
            }
        }

        // Step 3: Save New Password & Return to Login
        async function handleResetPasswordSubmit(event) {
            event.preventDefault();
            const password = document.getElementById('newPasswordInput').value;
            const passwordConfirmation = document.getElementById('newPasswordConfirmInput').value;

            if (password.length < 6) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Short Password',
                    text: 'Password must be at least 6 characters in length.',
                    confirmButtonColor: '#4f46e5'
                });
                return;
            }

            if (password !== passwordConfirmation) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Password Mismatch',
                    text: 'Passwords do not match. Please ensure both fields are identical.',
                    confirmButtonColor: '#4f46e5'
                });
                return;
            }

            const btn = document.getElementById('savePasswordBtn');
            btn.querySelector('.btn-text').classList.add('d-none');
            btn.querySelector('.spinner-border').classList.remove('d-none');
            btn.disabled = true;

            try {
                const response = await fetch('{{ route("password.otp.reset") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        email: currentOtpEmail,
                        reset_token: currentResetToken,
                        password: password,
                        password_confirmation: passwordConfirmation
                    })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    closeOtpWizardModal();

                    Swal.fire({
                        icon: 'success',
                        title: 'Password Reset Successfully!',
                        text: 'Your password has been updated. You can now log in with your new credentials.',
                        confirmButtonColor: '#4f46e5',
                        confirmButtonText: 'Proceed to Sign In'
                    }).then(() => {
                        switchAuthTab('login');
                        document.getElementById('loginEmail').value = currentOtpEmail;
                        document.getElementById('loginPassword').value = password;
                        document.getElementById('authSection').scrollIntoView({ behavior: 'smooth' });
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Reset Failed',
                        text: data.message || 'Unable to update password. Please try again.',
                        confirmButtonColor: '#ef4444'
                    });
                }
            } catch (err) {
                Swal.fire({
                    icon: 'error',
                    title: 'Network Error',
                    text: 'Failed to update password. Please check your connection.',
                    confirmButtonColor: '#ef4444'
                });
            } finally {
                btn.querySelector('.btn-text').classList.remove('d-none');
                btn.querySelector('.spinner-border').classList.add('d-none');
                btn.disabled = false;
            }
        }
    </script>
</body>
</html>
