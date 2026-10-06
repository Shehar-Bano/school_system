<!DOCTYPE html>
<html lang="en">
@include('view-file/head')

<body>
  <div class="container-scroller">
    @include('view-file/nav')
    <div class="container-fluid page-body-wrapper">
      @include('view-file.side-bar')

      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
              
              <!-- Modern ERP Detail Card -->
              <div class="erp-card-form">
                <div class="erp-form-header-block">
                  <div class="erp-form-title-area">
                    <h3 class="erp-form-title">
                      <i class="fas fa-id-card text-primary"></i>
                      Staff Profile & Details
                    </h3>
                    <p class="erp-form-subtitle">Comprehensive employee employment summary and contact record</p>
                  </div>

                  <!-- Back Button -->
                  <div>
                    <a href="{{ route('employee_view') }}" class="erp-btn-back">
                      <i class="fas fa-arrow-left"></i> Back to Employees
                    </a>
                  </div>
                </div>

                <div class="erp-form-body">
                  <!-- Header Profile Highlight -->
                  <div class="d-flex align-items-center gap-3 p-3 bg-light rounded mb-4">
                    @if($employee->image && $employee->image !== 'default.png')
                      <img src="{{ asset('storage/' . $employee->image) }}" alt="{{ $employee->name }}" class="rounded-circle border" style="width: 70px; height: 70px; object-fit: cover;">
                    @else
                      <div class="erp-user-avatar" style="width: 70px; height: 70px; font-size: 24px;">
                        {{ strtoupper(substr($employee->name, 0, 2)) }}
                      </div>
                    @endif
                    <div>
                      <h4 class="font-weight-bold text-dark mb-1">{{ $employee->name }}</h4>
                      <div class="d-flex align-items-center gap-2">
                        <span class="badge badge-soft-primary">
                          <i class="fas fa-briefcase mr-1"></i> {{ $employee->designation->name ?? 'Staff' }}
                        </span>
                        @if($employee->roles && $employee->roles->count() > 0)
                          <span class="badge badge-soft-info">
                            <i class="fas fa-shield mr-1"></i> {{ ucfirst($employee->roles->first()->name) }}
                          </span>
                        @endif
                      </div>
                    </div>
                  </div>

                  <!-- Details Grid -->
                  <div class="row g-3">
                    <div class="col-md-6">
                      <div class="p-3 border rounded mb-3">
                        <small class="text-muted text-uppercase font-weight-bold d-block mb-1">Email Address</small>
                        <div class="font-weight-semibold text-dark">{{ $employee->email ?? 'N/A' }}</div>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="p-3 border rounded mb-3">
                        <small class="text-muted text-uppercase font-weight-bold d-block mb-1">Contact Phone</small>
                        <div class="font-weight-semibold text-dark">{{ $employee->phone ?? 'N/A' }}</div>
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="p-3 border rounded mb-3">
                        <small class="text-muted text-uppercase font-weight-bold d-block mb-1">Date of Birth</small>
                        <div class="font-weight-semibold text-dark">{{ $employee->date_of_birth ?? 'N/A' }}</div>
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="p-3 border rounded mb-3">
                        <small class="text-muted text-uppercase font-weight-bold d-block mb-1">Gender</small>
                        <div class="font-weight-semibold text-dark">{{ $employee->gender ?? 'N/A' }}</div>
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="p-3 border rounded mb-3">
                        <small class="text-muted text-uppercase font-weight-bold d-block mb-1">Religion</small>
                        <div class="font-weight-semibold text-dark">{{ $employee->religion ?? 'N/A' }}</div>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="p-3 border rounded mb-3">
                        <small class="text-muted text-uppercase font-weight-bold d-block mb-1">Joining Date</small>
                        <div class="font-weight-semibold text-dark">{{ $employee->joining_date ?? 'N/A' }}</div>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="p-3 border rounded mb-3">
                        <small class="text-muted text-uppercase font-weight-bold d-block mb-1">Residential Address</small>
                        <div class="font-weight-semibold text-dark">{{ $employee->address ?? 'N/A' }}</div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Footer Actions -->
                <div class="erp-form-footer">
                  <a href="{{ route('employee_view') }}" class="erp-btn-back">
                    <i class="fas fa-arrow-left"></i> Back to Employees
                  </a>
                  <a href="{{ route('employees_edit', ['id' => $employee->id]) }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-edit mr-1"></i> Edit Profile
                  </a>
                </div>

              </div>
              <!-- End ERP Detail Card -->

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @include('view-file/script')
</body>
</html>
