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

          <!-- Page Header Block -->
          <div class="erp-card-form mb-4">
            <div class="erp-form-header-block">
              <div class="d-flex align-items-center gap-3">
                <div class="erp-header-icon-badge" style="background: #eef2ff; color: #4f46e5;">
                  <i class="fas fa-clipboard-list"></i>
                </div>
                <div class="erp-form-title-area">
                  <h3 class="erp-form-title">
                    My Class Assignments & Homework
                  </h3>
                  <p class="erp-form-subtitle">Track homework assigned to {{ $student->class->name ?? 'your class' }} - {{ $student->section->name ?? 'section' }}, submit tasks, and view grades</p>
                </div>
              </div>
            </div>

            <!-- Student Assignment Metrics -->
            <div class="p-4 bg-white">
              <div class="row g-3">
                <!-- Total Assigned -->
                <div class="col-sm-6 col-lg-3">
                  <div class="p-3 rounded border" style="background: #f8fafc; border-left: 4px solid #6366f1 !important;">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                      <span class="text-muted small font-weight-bold text-uppercase">Total Assigned</span>
                      <i class="fas fa-tasks text-primary"></i>
                    </div>
                    <div class="h3 font-weight-bold text-dark mb-0">{{ $totalAssigned }}</div>
                    <small class="text-muted">Curriculum assignments</small>
                  </div>
                </div>

                <!-- Submitted -->
                <div class="col-sm-6 col-lg-3">
                  <div class="p-3 rounded border" style="background: #f0fdf4; border-left: 4px solid #22c55e !important;">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                      <span class="text-success small font-weight-bold text-uppercase">Submitted</span>
                      <i class="fas fa-circle-check text-success"></i>
                    </div>
                    <div class="h3 font-weight-bold text-success mb-0">{{ $submittedCount }}</div>
                    <small class="text-muted">Completed by you</small>
                  </div>
                </div>

                <!-- Pending -->
                <div class="col-sm-6 col-lg-3">
                  <div class="p-3 rounded border" style="background: #fffbeb; border-left: 4px solid #f59e0b !important;">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                      <span class="text-warning small font-weight-bold text-uppercase">Pending</span>
                      <i class="fas fa-clock text-warning"></i>
                    </div>
                    <div class="h3 font-weight-bold text-warning mb-0">{{ $pendingCount }}</div>
                    <small class="text-muted">Need your submission</small>
                  </div>
                </div>

                <!-- Graded -->
                <div class="col-sm-6 col-lg-3">
                  <div class="p-3 rounded border" style="background: #faf5ff; border-left: 4px solid #a855f7 !important;">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                      <span class="text-purple small font-weight-bold text-uppercase" style="color: #9333ea;">Graded</span>
                      <i class="fas fa-award" style="color: #9333ea;"></i>
                    </div>
                    <div class="h3 font-weight-bold text-dark mb-0">{{ $gradedCount }}</div>
                    <small class="text-muted">Marks & feedback available</small>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Assignments Table -->
          <div class="erp-card-table">
            <div class="erp-table-header-block">
              <div class="erp-table-title-area">
                <h3 class="erp-table-title">
                  <i class="fas fa-book-open-reader text-primary"></i>
                  Assignment Task Roster
                </h3>
                <p class="erp-table-subtitle">View details, download worksheets, and submit your homework before the deadline</p>
              </div>
            </div>

            <div class="table-responsive">
              <table class="erp-table">
                <thead>
                  <tr>
                    <th style="width: 45px;" class="text-center">#</th>
                    <th style="width: 25%;">Assignment Title</th>
                    <th style="width: 16%;">Subject & Teacher</th>
                    <th style="width: 15%;" class="text-center">Due Deadline</th>
                    <th style="width: 15%;" class="text-center">Your Status</th>
                    <th style="width: 12%;" class="text-center">Marks</th>
                    <th style="width: 120px;" class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @php $cnt = 0; @endphp
                  @forelse($assignments as $item)
                    @php
                      $sub = $item->user_submission;
                    @endphp
                    <tr>
                      <td class="text-center font-weight-medium text-muted">{{ ++$cnt }}</td>
                      <td>
                        <div class="font-weight-semibold text-dark">{{ $item->title }}</div>
                        <div class="text-muted text-xs">{{ \Illuminate\Support\Str::limit($item->description, 70) }}</div>
                      </td>
                      <td>
                        <div class="font-weight-medium text-dark">
                          <i class="fas fa-book text-primary mr-1 text-xs"></i> {{ $item->subject->subject_name ?? 'Subject' }}
                        </div>
                        <div class="text-muted text-xs">
                          <i class="fas fa-chalkboard-user mr-1"></i> {{ $item->teacher->name ?? $item->uploader ?? 'Teacher' }}
                        </div>
                      </td>
                      <td class="text-center">
                        @if($item->is_deadline_passed)
                          <span class="badge badge-soft-danger font-weight-semibold" title="Deadline has passed">
                            <i class="fas fa-circle-xmark mr-1 text-xs"></i> {{ $item->deadline }}
                          </span>
                        @else
                          <span class="badge badge-soft-warning font-weight-semibold" title="Deadline Active">
                            <i class="fas fa-clock mr-1 text-xs"></i> Due: {{ $item->deadline }}
                          </span>
                        @endif
                      </td>
                      <td class="text-center">
                        @if($sub)
                          @if($sub->marks !== null)
                            <span class="badge badge-soft-success font-weight-semibold">
                              <i class="fas fa-check-double mr-1 text-xs"></i> Graded
                            </span>
                          @elseif($sub->status == 'late')
                            <span class="badge badge-soft-info font-weight-semibold">
                              <i class="fas fa-check mr-1 text-xs"></i> Submitted (Late)
                            </span>
                          @else
                            <span class="badge badge-soft-primary font-weight-semibold">
                              <i class="fas fa-check mr-1 text-xs"></i> Submitted
                            </span>
                          @endif
                        @else
                          @if($item->is_deadline_passed)
                            <span class="badge badge-soft-danger font-weight-semibold">
                              <i class="fas fa-triangle-exclamation mr-1 text-xs"></i> Overdue / Missed
                            </span>
                          @else
                            <span class="badge badge-soft-warning font-weight-semibold">
                              <i class="fas fa-hourglass-half mr-1 text-xs"></i> Pending
                            </span>
                          @endif
                        @endif
                      </td>
                      <td class="text-center">
                        @if($sub && $sub->marks !== null)
                          <span class="badge badge-soft-success font-weight-bold" style="font-size: 12px;">
                            {{ $sub->marks }} / {{ $item->total_marks ?? 100 }}
                          </span>
                        @elseif($sub)
                          <span class="badge badge-soft-secondary text-xs">Pending Grade</span>
                        @else
                          <span class="text-muted text-xs">—</span>
                        @endif
                      </td>
                      <td class="text-center">
                        <a href="{{ route('student.assignment.detail', ['id' => $item->id]) }}" class="btn btn-xs {{ $sub ? 'btn-outline-primary' : 'btn-primary' }} font-weight-semibold" style="font-size: 11px; padding: 4px 10px;">
                          @if($sub)
                            <i class="fas fa-eye mr-1"></i> View
                          @else
                            <i class="fas fa-upload mr-1"></i> Submit
                          @endif
                        </a>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="7" class="text-center py-4 text-muted">
                        <i class="fas fa-clipboard-check mb-2 text-xl d-block" style="font-size: 26px; color: #cbd5e1;"></i>
                        No assignments available for your class and section at this time.
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  @include('StudentDashboard.ViewFile.script')
</body>
</html>
