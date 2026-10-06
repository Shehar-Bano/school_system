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
                      <i class="fas fa-clipboard-question text-primary"></i>
                      Assignment Details
                    </h3>
                    <p class="erp-form-subtitle">View homework instructions, assigned class/section, and submission deadline</p>
                  </div>

                  <!-- Header Action Buttons -->
                  <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('assignment_tracking', ['id' => $assignment->id]) }}" class="btn btn-sm btn-primary">
                      <i class="fas fa-chart-line mr-1"></i> Track Submissions
                    </a>
                    <a href="{{ route('assignment_show') }}" class="erp-btn-back">
                      <i class="fas fa-arrow-left"></i> Back to Assignments
                    </a>
                  </div>
                </div>

                <!-- Live Submission Tracking Progress Widget -->
                @if(isset($trackingStats))
                <div class="p-3 bg-light border-bottom">
                  <div class="row align-items-center">
                    <div class="col-md-8">
                      <div class="d-flex align-items-center gap-3">
                        <div>
                          <span class="text-xs text-muted font-weight-bold text-uppercase d-block">Submission Progress</span>
                          <span class="font-weight-bold text-dark">
                            {{ $trackingStats['submitted_count'] }} of {{ $trackingStats['total_students'] }} Students Submitted ({{ $trackingStats['percentage'] }}%)
                          </span>
                        </div>
                        <div class="progress flex-grow-1" style="height: 6px; max-width: 200px;">
                          <div class="progress-bar {{ $trackingStats['percentage'] == 100 ? 'bg-success' : 'bg-primary' }}" role="progressbar" style="width: {{ $trackingStats['percentage'] }}%"></div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4 text-md-right mt-2 mt-md-0">
                      <a href="{{ route('assignment_tracking', ['id' => $assignment->id]) }}" class="btn btn-xs btn-outline-primary font-weight-semibold">
                        View Detailed Student Roster <i class="fas fa-arrow-right ml-1"></i>
                      </a>
                    </div>
                  </div>
                </div>
                @endif

                <div class="erp-form-body">
                  <div class="row g-4">
                    <div class="col-md-6">
                      <div class="mb-4">
                        <label class="text-xs font-weight-bold text-muted text-uppercase mb-1 d-block">Assignment Title</label>
                        <div class="font-weight-semibold text-dark fs-5">{{ $assignment->title }}</div>
                      </div>

                      <div class="mb-4">
                        <label class="text-xs font-weight-bold text-muted text-uppercase mb-1 d-block">Target Class & Section</label>
                        <div class="font-weight-medium text-dark">
                          <span class="badge badge-soft-primary mr-1">{{ $assignment->class->name ?? 'N/A' }}</span>
                          <span class="badge badge-soft-info">{{ $assignment->section->name ?? 'N/A' }}</span>
                        </div>
                      </div>

                      <div class="mb-4">
                        <label class="text-xs font-weight-bold text-muted text-uppercase mb-1 d-block">Subject</label>
                        <div class="font-weight-medium text-dark">
                          <i class="fas fa-book text-primary mr-1"></i> {{ $assignment->subject->subject_name ?? 'N/A' }}
                        </div>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="mb-4">
                        <label class="text-xs font-weight-bold text-muted text-uppercase mb-1 d-block">Submission Deadline</label>
                        <div class="font-weight-semibold {{ isset($trackingStats) && $trackingStats['is_deadline_passed'] ? 'text-danger' : 'text-primary' }}">
                          <i class="fas fa-clock mr-1"></i> {{ $assignment->deadline }}
                          @if(isset($trackingStats) && $trackingStats['is_deadline_passed'])
                            <span class="badge badge-soft-danger ml-1">Deadline Passed</span>
                          @else
                            <span class="badge badge-soft-success ml-1">Active</span>
                          @endif
                        </div>
                      </div>

                      <div class="mb-4">
                        <label class="text-xs font-weight-bold text-muted text-uppercase mb-1 d-block">Uploaded By / Teacher</label>
                        <div class="font-weight-medium text-dark">
                          <i class="fas fa-user-tie text-primary mr-1"></i> {{ $assignment->teacher->name ?? $assignment->uploader ?? 'Staff' }}
                        </div>
                      </div>

                      <div class="mb-4">
                        <label class="text-xs font-weight-bold text-muted text-uppercase mb-1 d-block">Worksheet / Attached File</label>
                        @if($assignment->assignment)
                          <div class="p-3 bg-light border rounded d-inline-block">
                            <a href="{{ asset('storage/' . $assignment->assignment) }}" target="_blank" class="btn btn-sm btn-primary">
                              <i class="fas fa-download mr-1"></i> Download Worksheet
                            </a>
                          </div>
                        @else
                          <p class="text-muted">No attachment file.</p>
                        @endif
                      </div>
                    </div>

                    <div class="col-12">
                      <hr class="my-2">
                      <label class="text-xs font-weight-bold text-muted text-uppercase mb-2 d-block">Instructions & Task Details</label>
                      <div class="p-3 bg-light rounded text-secondary" style="white-space: pre-wrap; line-height: 1.6;">
                        {{ $assignment->description }}
                      </div>
                    </div>
                  </div>
                </div>

                <div class="erp-form-footer">
                  <a href="{{ route('assignment_show') }}" class="erp-btn-back">
                    <i class="fas fa-arrow-left"></i> Back to Assignments
                  </a>
                  <a href="{{ route('assignment_tracking', ['id' => $assignment->id]) }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-chart-line mr-1"></i> Track Submissions
                  </a>
                  @if(auth()->check() && (auth()->user()->hasRole('superadmin') || auth()->user()->can('academic.assignment.edit')))
                  <a href="{{ route('edit_assinment', ['id' => $assignment->id]) }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-edit mr-1"></i> Edit Assignment
                  </a>
                  @endif
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
