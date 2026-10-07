<!DOCTYPE html>
<html lang="en">

@include('StudentDashboard.ViewFile.head')

<body>
  <div class="container-scroller">
    @include('StudentDashboard.ViewFile.nav')
    <div class="container-fluid page-body-wrapper">
      @include('StudentDashboard.ViewFile.sidebar')

      <div class="main-panel">
        <div class="content-wrapper">

          <!-- Page Header & Action Bar -->
          <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-3 gap-2">
            <div>
              <div class="d-flex align-items-center gap-2 mb-1">
                <a href="{{ route('student.dashboard') }}" class="text-muted text-xs hover-text-primary">
                  <i class="fas fa-arrow-left me-1"></i> Dashboard
                </a>
                <span class="text-muted text-xs">/</span>
                <span class="text-xs font-weight-semibold text-primary">Student Profile</span>
              </div>
              <h2 class="h3 font-bold mb-0 d-flex align-items-center gap-2">
                Student Profile & Identity
                <span class="badge badge-soft-success" style="font-size: 11px;">
                  <i class="fas fa-circle-check me-1"></i> Enrolled
                </span>
              </h2>
            </div>

            <!-- Quick Action Buttons -->
            <div class="d-flex align-items-center gap-2 flex-wrap">
              <a href="{{ route('student.dashboard') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-home me-1"></i> Dashboard
              </a>
              <button onclick="window.print()" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-print me-1"></i> Print Profile
              </button>
              <a href="{{ route('student.assignments') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-tasks me-1"></i> My Coursework
              </a>
            </div>
          </div>

          <div class="row g-3">

            <!-- LEFT COLUMN: Student Card & Quick Overview -->
            <div class="col-12 col-xl-4 mb-3">
              
              <!-- 1. Identity Badge Card -->
              <div class="card mb-3">
                <div class="card-body text-center p-4">
                  
                  <!-- Student Avatar -->
                  <div class="position-relative d-inline-block mb-3">
                    @if($student->image && $student->image !== 'default.png')
                      <img src="{{ asset('storage/' . $student->image) }}" alt="{{ $student->name }}" 
                           class="rounded-circle shadow-sm border border-2 border-primary" 
                           style="width: 110px; height: 110px; object-fit: cover;">
                    @else
                      <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary-subtle text-primary border border-2 border-primary mx-auto shadow-sm" 
                           style="width: 110px; height: 110px; font-size: 42px;">
                        <i class="fas fa-user-graduate"></i>
                      </div>
                    @endif
                    <span class="position-absolute bottom-0 end-0 bg-success border border-white rounded-circle p-2" 
                          style="width: 18px; height: 18px;" title="Account Active"></span>
                  </div>

                  <h4 class="font-weight-bold text-dark mb-1">{{ $student->name }}</h4>
                  <div class="text-muted text-xs mb-2">
                    <span>Roll / Reg No: </span>
                    <strong class="text-primary font-monospace">{{ $student->registration ?? $student->username }}</strong>
                  </div>

                  <div class="d-flex justify-content-center gap-2 mb-3 flex-wrap">
                    <span class="badge badge-soft-primary">
                      <i class="fas fa-school me-1"></i> {{ $student->class->name ?? 'Class' }}
                    </span>
                    <span class="badge badge-soft-info">
                      <i class="fas fa-layer-group me-1"></i> {{ $student->section->name ?? 'Section' }}
                    </span>
                    <span class="badge badge-soft-warning">
                      <i class="fas fa-atom me-1"></i> {{ ucfirst($student->group ?? 'General') }}
                    </span>
                  </div>

                  <hr class="my-3">

                  <!-- Quick Key-Value Attributes -->
                  <div class="text-start">
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                      <span class="text-muted text-xs"><i class="fas fa-id-card text-muted me-2"></i> Username</span>
                      <span class="font-weight-semibold text-xs text-dark">{{ $student->username }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                      <span class="text-muted text-xs"><i class="fas fa-calendar-alt text-muted me-2"></i> Admission Date</span>
                      <span class="font-weight-semibold text-xs text-dark">{{ $student->admissiondate ? \Carbon\Carbon::parse($student->admissiondate)->format('M d, Y') : 'N/A' }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                      <span class="text-muted text-xs"><i class="fas fa-wallet text-muted me-2"></i> Tuition Fee</span>
                      <span class="font-weight-bold text-xs text-success">Rs. {{ number_format($student->tution_fee ?? 0) }} /mo</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center py-2">
                      <span class="text-muted text-xs"><i class="fas fa-shield-halved text-muted me-2"></i> Account Status</span>
                      <span class="badge badge-soft-success">Active</span>
                    </div>
                  </div>

                </div>
              </div>

              <!-- 2. Portal Shortcuts Card -->
              <div class="card mb-0">
                <div class="card-header py-2">
                  <h4 class="card-title text-xs font-weight-bold text-uppercase text-muted">
                    <i class="fas fa-bolt text-warning me-1"></i> Quick Navigation
                  </h4>
                </div>
                <div class="card-body p-2">
                  <div class="list-group list-group-flush">
                    <a href="{{ route('timetable.student') }}" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between p-2 rounded mb-1 border-0 hover-bg-light">
                      <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-calendar-alt text-primary" style="width: 20px;"></i>
                        <span class="text-xs font-weight-medium text-dark">Weekly Timetable</span>
                      </div>
                      <i class="fas fa-chevron-right text-muted text-xs"></i>
                    </a>
                    <a href="{{ route('student.assignments') }}" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between p-2 rounded mb-1 border-0 hover-bg-light">
                      <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-clipboard-list text-success" style="width: 20px;"></i>
                        <span class="text-xs font-weight-medium text-dark">Assignments & Homework</span>
                      </div>
                      <i class="fas fa-chevron-right text-muted text-xs"></i>
                    </a>
                    <a href="{{ route('attendence.student') }}" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between p-2 rounded mb-1 border-0 hover-bg-light">
                      <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-user-check text-info" style="width: 20px;"></i>
                        <span class="text-xs font-weight-medium text-dark">Attendance Record</span>
                      </div>
                      <i class="fas fa-chevron-right text-muted text-xs"></i>
                    </a>
                    <a href="{{ route('result.student') }}" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between p-2 rounded mb-1 border-0 hover-bg-light">
                      <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-award text-warning" style="width: 20px;"></i>
                        <span class="text-xs font-weight-medium text-dark">Examination Grades</span>
                      </div>
                      <i class="fas fa-chevron-right text-muted text-xs"></i>
                    </a>
                    <a href="{{ route('fee.student') }}" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between p-2 rounded border-0 hover-bg-light">
                      <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-receipt text-danger" style="width: 20px;"></i>
                        <span class="text-xs font-weight-medium text-dark">Fee Vouchers</span>
                      </div>
                      <i class="fas fa-chevron-right text-muted text-xs"></i>
                    </a>
                  </div>
                </div>
              </div>

            </div>

            <!-- RIGHT COLUMN: Detailed Academic & Personal Records -->
            <div class="col-12 col-xl-8 mb-3">

              <!-- Section 1: Academic & Enrollment Information -->
              <div class="card mb-3">
                <div class="card-header py-2 d-flex align-items-center justify-content-between">
                  <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-graduation-cap text-primary"></i>
                    <h4 class="card-title">Academic & Enrollment Profile</h4>
                  </div>
                  <span class="badge badge-soft-primary">Session 2026-27</span>
                </div>
                <div class="card-body">
                  <div class="row g-3">
                    <div class="col-sm-6 col-md-4">
                      <div class="p-3 rounded border bg-light">
                        <span class="text-muted text-xs d-block mb-1">Class / Grade</span>
                        <div class="font-weight-bold text-dark fs-6">{{ $student->class->name ?? 'Not Assigned' }}</div>
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                      <div class="p-3 rounded border bg-light">
                        <span class="text-muted text-xs d-block mb-1">Section</span>
                        <div class="font-weight-bold text-dark fs-6">{{ $student->section->name ?? 'Not Assigned' }}</div>
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                      <div class="p-3 rounded border bg-light">
                        <span class="text-muted text-xs d-block mb-1">Stream / Group</span>
                        <div class="font-weight-bold text-dark fs-6">{{ ucfirst($student->group ?? 'Science') }}</div>
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                      <div class="p-3 rounded border bg-light">
                        <span class="text-muted text-xs d-block mb-1">Registration Number</span>
                        <div class="font-weight-bold text-primary fs-6">{{ $student->registration ?? $student->username }}</div>
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                      <div class="p-3 rounded border bg-light">
                        <span class="text-muted text-xs d-block mb-1">Admission Date</span>
                        <div class="font-weight-bold text-dark fs-6">
                          {{ $student->admissiondate ? \Carbon\Carbon::parse($student->admissiondate)->format('d M, Y') : 'N/A' }}
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                      <div class="p-3 rounded border bg-light">
                        <span class="text-muted text-xs d-block mb-1">Monthly Tuition Fee</span>
                        <div class="font-weight-bold text-success fs-6">
                          Rs. {{ number_format($student->tution_fee ?? 0) }}
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Section 2: Personal & Bio Data -->
              <div class="card mb-3">
                <div class="card-header py-2 d-flex align-items-center gap-2">
                  <i class="fas fa-user text-info"></i>
                  <h4 class="card-title">Personal & Biographical Information</h4>
                </div>
                <div class="card-body">
                  <div class="row g-3">
                    <div class="col-sm-6 col-md-4">
                      <div class="p-3 rounded border bg-light">
                        <span class="text-muted text-xs d-block mb-1">Full Legal Name</span>
                        <div class="font-weight-semibold text-dark">{{ $student->name }}</div>
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                      <div class="p-3 rounded border bg-light">
                        <span class="text-muted text-xs d-block mb-1">Gender</span>
                        <div class="font-weight-semibold text-dark">{{ ucfirst($student->gender ?? 'N/A') }}</div>
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                      <div class="p-3 rounded border bg-light">
                        <span class="text-muted text-xs d-block mb-1">Date of Birth</span>
                        <div class="font-weight-semibold text-dark">
                          {{ $student->dob ? \Carbon\Carbon::parse($student->dob)->format('d M, Y') : 'N/A' }}
                          @if($student->dob)
                            <small class="text-muted">({{ \Carbon\Carbon::parse($student->dob)->age }} yrs)</small>
                          @endif
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                      <div class="p-3 rounded border bg-light">
                        <span class="text-muted text-xs d-block mb-1">Religion</span>
                        <div class="font-weight-semibold text-dark">{{ ucfirst($student->religion ?? 'Islam') }}</div>
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                      <div class="p-3 rounded border bg-light">
                        <span class="text-muted text-xs d-block mb-1">Portal Username</span>
                        <div class="font-weight-semibold text-dark">{{ $student->username }}</div>
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                      <div class="p-3 rounded border bg-light">
                        <span class="text-muted text-xs d-block mb-1">Student Status</span>
                        <div><span class="badge badge-soft-success">Active / Enrolled</span></div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="p-3 rounded border bg-light">
                        <span class="text-muted text-xs d-block mb-1">Residential Address</span>
                        <div class="font-weight-semibold text-dark">
                          <i class="fas fa-map-pin text-danger me-1"></i>
                          {{ $student->address ? $student->address : 'Address record not updated.' }}
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Section 3: Guardian & Contact Details -->
              <div class="card mb-0">
                <div class="card-header py-2 d-flex align-items-center gap-2">
                  <i class="fas fa-users text-purple"></i>
                  <h4 class="card-title">Parent & Contact Information</h4>
                </div>
                <div class="card-body">
                  <div class="row g-3">
                    <div class="col-sm-6">
                      <div class="p-3 rounded border bg-light">
                        <span class="text-muted text-xs d-block mb-1">Father / Guardian Name</span>
                        <div class="font-weight-semibold text-dark fs-6">
                          <i class="fas fa-user-tie text-secondary me-1"></i>
                          {{ $student->gurdian ?? 'N/A' }}
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="p-3 rounded border bg-light">
                        <span class="text-muted text-xs d-block mb-1">Emergency Phone Number</span>
                        <div class="font-weight-semibold text-dark fs-6">
                          <i class="fas fa-phone text-success me-1"></i>
                          {{ $student->phone ?? 'N/A' }}
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="p-3 rounded border bg-light">
                        <span class="text-muted text-xs d-block mb-1">Registered Email Address</span>
                        <div class="font-weight-semibold text-dark">
                          <i class="fas fa-envelope text-primary me-1"></i>
                          {{ $student->email ?? 'N/A' }}
                        </div>
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
            <span class="text-muted">Student Portal v2.5</span>
          </div>
        </footer>
      </div>

    </div>
  </div>

  @include('StudentDashboard.ViewFile.script')
</body>
</html>
