@extends('employeeDashboard.employeeView.masterpage')

@section('content')
<div class="main-panel">
  <div class="content-wrapper">

    <!-- Tracking Overview Header Card -->
    <div class="erp-card-form mb-4">
      <div class="erp-form-header-block">
        <div class="d-flex align-items-center gap-3">
          <div class="erp-header-icon-badge" style="background: #eef2ff; color: #4f46e5;">
            <i class="fas fa-chart-line"></i>
          </div>
          <div class="erp-form-title-area">
            <h3 class="erp-form-title">
              Assignment Submission Tracking
            </h3>
            <p class="erp-form-subtitle">Track student submissions, download student homework, and assign marks & feedback</p>
          </div>
        </div>

        <div>
          <a href="{{ route('employee.assignments') }}" class="erp-btn-back">
            <i class="fas fa-arrow-left"></i> Back to Assignments
          </a>
        </div>
      </div>

      <!-- Quick Context Ribbon -->
      <div class="p-3 bg-light border-bottom">
        <div class="row align-items-center g-3">
          <div class="col-md-4">
            <span class="text-muted small text-uppercase font-weight-bold d-block">Assignment Title</span>
            <span class="font-weight-bold text-dark fs-6">{{ $assignment->title }}</span>
          </div>
          <div class="col-md-3">
            <span class="text-muted small text-uppercase font-weight-bold d-block">Class & Section</span>
            <span class="badge badge-soft-primary mr-1">{{ $assignment->class->name ?? 'Class' }}</span>
            <span class="badge badge-soft-info">{{ $assignment->section->name ?? 'Section' }}</span>
            <span class="text-muted small ml-1">({{ $assignment->subject->subject_name ?? 'Subject' }})</span>
          </div>
          <div class="col-md-3">
            <span class="text-muted small text-uppercase font-weight-bold d-block">Submission Deadline</span>
            @if($isDeadlinePassed)
              <span class="badge badge-soft-danger font-weight-semibold">
                <i class="fas fa-circle-xmark mr-1"></i> {{ $assignment->deadline }} (Deadline Passed)
              </span>
            @else
              <span class="badge badge-soft-warning font-weight-semibold">
                <i class="fas fa-clock mr-1"></i> Due: {{ $assignment->deadline }} (Active)
              </span>
            @endif
          </div>
          <div class="col-md-2 text-md-right">
            <span class="text-muted small text-uppercase font-weight-bold d-block">Total Marks</span>
            <span class="badge badge-soft-success font-weight-bold" style="font-size: 13px;">
              {{ $assignment->total_marks ?? 100 }} Marks
            </span>
          </div>
        </div>
      </div>

      <!-- 4 Metric KPI Cards -->
      <div class="p-4 bg-white">
        <div class="row g-3">
          <!-- KPI 1: Total Students -->
          <div class="col-sm-6 col-lg-3">
            <div class="p-3 rounded border" style="background: #f8fafc; border-left: 4px solid #6366f1 !important;">
              <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-muted small font-weight-bold text-uppercase">Total Students</span>
                <i class="fas fa-users text-primary"></i>
              </div>
              <div class="h3 font-weight-bold text-dark mb-0">{{ $totalStudents }}</div>
              <small class="text-muted">Enrolled in section</small>
            </div>
          </div>

          <!-- KPI 2: Submitted -->
          <div class="col-sm-6 col-lg-3">
            <div class="p-3 rounded border" style="background: #f0fdf4; border-left: 4px solid #22c55e !important;">
              <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-success small font-weight-bold text-uppercase">Submitted</span>
                <i class="fas fa-circle-check text-success"></i>
              </div>
              <div class="h3 font-weight-bold text-success mb-0">
                {{ $submittedCount }} <span class="text-xs text-muted font-weight-normal">({{ $submissionRate }}%)</span>
              </div>
              <div class="progress mt-2" style="height: 5px;">
                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $submissionRate }}%"></div>
              </div>
            </div>
          </div>

          <!-- KPI 3: Pending -->
          <div class="col-sm-6 col-lg-3">
            <div class="p-3 rounded border" style="background: #fffbeb; border-left: 4px solid #f59e0b !important;">
              <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-warning small font-weight-bold text-uppercase">Pending / Missing</span>
                <i class="fas fa-hourglass-half text-warning"></i>
              </div>
              <div class="h3 font-weight-bold text-warning mb-0">{{ $pendingCount }}</div>
              <small class="text-muted">{{ $isDeadlinePassed ? 'Overdue submissions' : 'Awaiting submission' }}</small>
            </div>
          </div>

          <!-- KPI 4: Graded Rate -->
          <div class="col-sm-6 col-lg-3">
            <div class="p-3 rounded border" style="background: #faf5ff; border-left: 4px solid #a855f7 !important;">
              <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-purple small font-weight-bold text-uppercase" style="color: #9333ea;">Graded Rate</span>
                <i class="fas fa-award" style="color: #9333ea;"></i>
              </div>
              <div class="h3 font-weight-bold text-dark mb-0">{{ $gradedCount }} / {{ $submittedCount }}</div>
              <small class="text-muted">Avg: {{ $averageMarks }} / {{ $assignment->total_marks ?? 100 }}</small>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Student Submission Roster Table -->
    <div class="erp-card-table">
      <div class="erp-table-header-block">
        <div class="erp-table-title-area">
          <h3 class="erp-table-title">
            <i class="fas fa-list-check text-primary"></i>
            Student Submission & Evaluation Roster
          </h3>
          <p class="erp-table-subtitle">Review student solutions, view timestamps, and grade submissions</p>
        </div>

        <!-- Filter Controls -->
        <div class="erp-filter-group">
          <div class="erp-input-icon-wrapper">
            <i class="fas fa-search"></i>
            <input type="text" id="filterStudentInput" placeholder="Filter student name or roll #..." autocomplete="off">
          </div>
          <select id="filterStatusSelect" class="form-control" style="height: 34px; width: 150px; font-size: 12px;">
            <option value="all">All Statuses</option>
            <option value="submitted">Submitted</option>
            <option value="pending">Pending</option>
            <option value="graded">Graded</option>
            <option value="overdue">Overdue</option>
          </select>
        </div>
      </div>

      <div class="table-responsive">
        <table class="erp-table" id="trackingTable">
          <thead>
            <tr>
              <th style="width: 50px;" class="text-center">#</th>
              <th style="width: 22%;">Student Name & Roll #</th>
              <th style="width: 15%;" class="text-center">Submission Status</th>
              <th style="width: 15%;" class="text-center">Submitted At</th>
              <th style="width: 16%;" class="text-center">Student Solution</th>
              <th style="width: 14%;" class="text-center">Marks</th>
              <th style="width: 110px;" class="text-center">Action</th>
            </tr>
          </thead>
          <tbody id="trackingTableBody">
            @php $idx = 0; @endphp
            @forelse ($roster as $item)
              <tr data-student-name="{{ strtolower($item->student->name) }}" data-reg="{{ strtolower($item->student->registration ?? '') }}" data-status="{{ $item->status }}">
                <td class="text-center font-weight-medium text-muted">{{ ++$idx }}</td>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <div class="erp-avatar" style="width: 32px; height: 32px; border-radius: 50%; background: #e0e7ff; color: #4338ca; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 12px;">
                      {{ strtoupper(substr($item->student->name, 0, 1)) }}
                    </div>
                    <div>
                      <div class="font-weight-semibold text-dark">{{ $item->student->name }}</div>
                      <div class="text-muted text-xs">Roll #: {{ $item->student->registration ?? 'N/A' }}</div>
                    </div>
                  </div>
                </td>

                <!-- Status Badge -->
                <td class="text-center">
                  <span class="badge badge-soft-{{ $item->status_badge }} font-weight-semibold">
                    @if($item->status == 'graded')
                      <i class="fas fa-check-double mr-1 text-xs"></i>
                    @elseif($item->status == 'submitted' || $item->status == 'late')
                      <i class="fas fa-check mr-1 text-xs"></i>
                    @elseif($item->status == 'overdue')
                      <i class="fas fa-triangle-exclamation mr-1 text-xs"></i>
                    @else
                      <i class="fas fa-clock mr-1 text-xs"></i>
                    @endif
                    {{ $item->status_text }}
                  </span>
                </td>

                <!-- Submitted At -->
                <td class="text-center text-xs">
                  @if($item->submission && $item->submission->submitted_at)
                    <div class="font-weight-medium text-dark">{{ $item->submission->submitted_at->format('M d, Y') }}</div>
                    <div class="text-muted">{{ $item->submission->submitted_at->format('h:i A') }}</div>
                  @else
                    <span class="text-muted">—</span>
                  @endif
                </td>

                <!-- Solution Attachment / Note -->
                <td class="text-center">
                  @if($item->submission)
                    <div class="d-flex flex-column align-items-center gap-1">
                      @if($item->submission->submission_file)
                        <a href="{{ asset('storage/' . $item->submission->submission_file) }}" target="_blank" class="btn btn-xs btn-outline-primary" style="font-size: 11px; padding: 3px 8px;">
                          <i class="fas fa-download mr-1"></i> View File
                        </a>
                      @endif
                      @if($item->submission->submission_text)
                        <button type="button" class="btn btn-xs btn-outline-secondary" style="font-size: 10px; padding: 2px 6px;" onclick="viewStudentNote('{{ addslashes($item->student->name) }}', '{{ addslashes($item->submission->submission_text) }}')">
                          <i class="fas fa-comment-dots mr-1"></i> Notes
                        </button>
                      @endif
                    </div>
                  @else
                    <span class="text-muted text-xs">No submission</span>
                  @endif
                </td>

                <!-- Marks -->
                <td class="text-center">
                  @if($item->submission && $item->submission->marks !== null)
                    <span class="badge badge-soft-success font-weight-bold" style="font-size: 12px;">
                      {{ $item->submission->marks }} / {{ $assignment->total_marks ?? 100 }}
                    </span>
                  @elseif($item->submission)
                    <span class="badge badge-soft-secondary text-xs">Ungraded</span>
                  @else
                    <span class="text-muted text-xs">—</span>
                  @endif
                </td>

                <!-- Action Button -->
                <td class="text-center">
                  @if($item->submission)
                    <button type="button" class="btn btn-xs btn-primary font-weight-medium" style="font-size: 11px; padding: 4px 9px;" onclick="openGradeModal({{ $item->submission->id }}, '{{ addslashes($item->student->name) }}', '{{ $item->submission->marks ?? '' }}', '{{ addslashes($item->submission->feedback ?? '') }}', {{ $assignment->total_marks ?? 100 }})">
                      <i class="fas fa-pen mr-1"></i> Grade
                    </button>
                  @else
                    <span class="text-muted text-xs">—</span>
                  @endif
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="text-center py-4 text-muted">
                  No students enrolled in {{ $assignment->class->name ?? 'Class' }} - {{ $assignment->section->name ?? 'Section' }}.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>

<!-- Teacher Grading Modal -->
<div class="modal fade" id="gradeModal" tabindex="-1" role="dialog" aria-labelledby="gradeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="gradeModalLabel">
          <i class="fas fa-award mr-1"></i> Grade Student Submission
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="gradeForm" method="POST" action="">
        @csrf
        <div class="modal-body p-4">
          <div class="mb-3">
            <label class="text-xs text-muted font-weight-bold text-uppercase d-block">Student Name</label>
            <div id="modalStudentName" class="font-weight-bold text-dark fs-6"></div>
          </div>

          <div class="erp-form-group mb-3">
            <label for="inputMarks" class="erp-form-label">
              Marks Obtained (Max: <span id="modalMaxMarks">100</span>) <span class="required">*</span>
            </label>
            <div class="erp-input-wrapper">
              <i class="fas fa-star input-icon-prefix"></i>
              <input type="number" step="0.5" min="0" class="form-control has-prefix-icon" id="inputMarks" name="marks" required placeholder="Enter marks obtained">
            </div>
          </div>

          <div class="erp-form-group mb-0">
            <label for="inputFeedback" class="erp-form-label">Feedback / Teacher Remarks</label>
            <textarea class="form-control" id="inputFeedback" name="feedback" rows="3" placeholder="Enter optional comments or guidance for the student..."></textarea>
          </div>
        </div>

        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="erp-btn-submit">
            <i class="fas fa-check mr-1"></i> Save Grade
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  function openGradeModal(submissionId, studentName, marks, feedback, maxMarks) {
    const form = document.getElementById('gradeForm');
    form.action = "{{ url('/employeeDashboard/assignments/grade') }}/" + submissionId;
    document.getElementById('modalStudentName').innerText = studentName;
    document.getElementById('modalMaxMarks').innerText = maxMarks;
    document.getElementById('inputMarks').value = marks;
    document.getElementById('inputMarks').max = maxMarks;
    document.getElementById('inputFeedback').value = feedback;
    $('#gradeModal').modal('show');
  }

  function viewStudentNote(studentName, notes) {
    Swal.fire({
      title: studentName + ' - Solution Notes',
      text: notes,
      icon: 'info',
      confirmButtonColor: '#4f46e5'
    });
  }

  document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('filterStudentInput');
    const statusSelect = document.getElementById('filterStatusSelect');
    const rows = document.querySelectorAll('#trackingTableBody tr[data-student-name]');

    function filterRoster() {
      const query = searchInput ? searchInput.value.trim().toLowerCase() : '';
      const selectedStatus = statusSelect ? statusSelect.value : 'all';

      rows.forEach(row => {
        const name = row.getAttribute('data-student-name') || '';
        const reg = row.getAttribute('data-reg') || '';
        const status = row.getAttribute('data-status') || '';

        const matchesQuery = !query || name.includes(query) || reg.includes(query);
        const matchesStatus = (selectedStatus === 'all') || (status === selectedStatus);

        if (matchesQuery && matchesStatus) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });
    }

    if (searchInput) searchInput.addEventListener('input', filterRoster);
    if (statusSelect) statusSelect.addEventListener('change', filterRoster);
  });
</script>
@endsection
