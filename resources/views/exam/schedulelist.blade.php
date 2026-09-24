<!DOCTYPE html>
<html lang="en">

@include('view-file/head')

<body>
  <div class="container-scroller">
    @include('view-file/nav')
    <div class="container-fluid page-body-wrapper">
      @include('view-file.side-bar')

      <!-- Main Panel -->
      <div class="main-panel">
        <div class="content-wrapper">
          
          <!-- ERP Card Table Container -->
          <div class="erp-card-table">
            
            <!-- Table Header Block -->
            <div class="erp-table-header-block">
              <div class="erp-table-title-area">
                <h3 class="erp-table-title">
                  <i class="fas fa-calendar-check text-primary"></i>
                  Exam Schedules
                </h3>
                <p class="erp-table-subtitle">Manage examination timetables, classroom date sheets, and result printing</p>
              </div>

              <!-- Top Action: Add New Schedule Button -->
              <div>
                <a href="{{ route('exam-schedule') }}" class="btn btn-sm btn-primary">
                  <i class="fas fa-plus mr-1"></i> Add New Schedule
                </a>
              </div>
            </div>

            <!-- Single-Line Compact Toolbar (Exports & Filters) -->
            <div class="erp-toolbar">
              <!-- Left: Grouped Export Buttons -->
              <div class="erp-export-group">
                <button type="button" id="excelButton" class="erp-export-btn" title="Export to Excel">
                  <i class="fas fa-file-excel"></i> Excel
                </button>
                <button type="button" id="pdfButton" class="erp-export-btn" title="Export to PDF">
                  <i class="fas fa-file-pdf"></i> PDF
                </button>
              </div>

              <!-- Right: Search & Filter Controls -->
              <form id="searchForm" method="GET" action="" class="m-0">
                <div class="erp-filter-group">
                  <select name="class" id="class" class="erp-filter-select">
                    <option value="">All Classes</option>
                    @foreach ($classes as $class)
                      <option value="{{ $class->id }}" {{ $class->id == request()->query('class') ? 'selected' : '' }}>
                        {{ $class->name }}
                      </option>
                    @endforeach
                  </select>

                  <select name="section" id="section" class="erp-filter-select">
                    <option value="">All Sections</option>
                    @foreach ($sections as $section)
                      <option value="{{ $section->id }}" {{ $section->id == request()->query('section') ? 'selected' : '' }}>
                        {{ $section->name }} ({{ $section->classe->name ?? '' }})
                      </option>
                    @endforeach
                  </select>

                  <select name="exam" id="exam" class="erp-filter-select">
                    <option value="">All Exams</option>
                    @foreach ($exams as $exam)
                      <option value="{{ $exam->id }}" {{ $exam->id == request()->query('exam') ? 'selected' : '' }}>
                        {{ $exam->name }}
                      </option>
                    @endforeach
                  </select>

                  <button type="submit" class="erp-btn-filter-action erp-btn-filter-primary">
                    <i class="fas fa-filter"></i> Search
                  </button>

                  <a href="{{ url()->current() }}" class="erp-btn-filter-action erp-btn-filter-reset text-decoration-none">
                    <i class="fas fa-rotate-left"></i> Reset
                  </a>
                </div>
              </form>
            </div>

            <!-- Table Responsive Container -->
            <div class="table-responsive">
              <table class="erp-table" id="examsTable">
                <thead>
                  <tr>
                    <th style="width: 50px;" class="text-center">#</th>
                    <th style="width: 24%;">Exam Name</th>
                    <th style="width: 16%;">Class</th>
                    <th style="width: 16%;">Section</th>
                    <th style="width: 24%;" class="text-center">Schedule Duration</th>
                    <th style="width: 140px;" class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                    $count = 0;
                  @endphp
                  @forelse ($examschedules as $schedule)
                  <tr>
                    <td class="text-center font-weight-medium text-muted">{{ ++$count }}</td>
                    <td class="font-weight-semibold text-dark">
                      <span class="badge badge-soft-primary mr-1" style="font-size: 11px;">
                        <i class="fas fa-file-pen text-xs mr-1"></i> {{ $schedule->exam->name ?? 'Exam' }}
                      </span>
                    </td>
                    <td>
                      <span class="badge badge-soft-primary">
                        {{ $schedule->class->name ?? 'Class' }}
                      </span>
                    </td>
                    <td>
                      <span class="badge badge-soft-purple">
                        {{ $schedule->section->name ?? 'Section' }}
                      </span>
                    </td>
                    <td class="text-center text-xs">
                      <span class="badge badge-soft-warning font-weight-medium">
                        <i class="fas fa-calendar-day mr-1 text-xs"></i> {{ $schedule->start_date }} → {{ $schedule->end_date }}
                      </span>
                    </td>
                    <td class="text-center">
                      <div class="erp-action-btn-group">
                        <!-- Print Result Button -->
                        <a href="{{ route('exam-result', ['id' => $schedule->id]) }}" class="erp-action-btn view" title="Print Result">
                          <i class="fas fa-print"></i>
                        </a>

                        <!-- Add Date Sheet Button -->
                        <a href="{{ route('date-sheet', ['id' => $schedule->id]) }}" class="erp-action-btn" style="background-color: #ecfdf5; color: #047857;" title="Add Date Sheet">
                          <i class="fas fa-plus"></i>
                        </a>

                        <!-- View Date Sheet Button -->
                        <a href="{{ route('date-sheet-list', ['id' => $schedule->id]) }}" class="erp-action-btn view" title="View Date Sheet">
                          <i class="fas fa-eye"></i>
                        </a>

                        <!-- Edit Button -->
                        <a href="{{ route('exam-schedule-edit', ['id' => $schedule->id]) }}" class="erp-action-btn edit" title="Edit Schedule">
                          <i class="fas fa-pen-to-square"></i>
                        </a>

                        <!-- Delete Button -->
                        <form id="delete-schedule-{{ $schedule->id }}" action="{{ route('exam-schedule_delete', ['id' => $schedule->id]) }}" method="POST" style="display:inline;">
                          @csrf
                          @method('DELETE')
                          <button type="button" class="erp-action-btn delete" title="Delete Schedule" onclick="confirmDelete({{ $schedule->id }})">
                            <i class="fas fa-trash-can"></i>
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="6" class="text-center py-4 text-muted">
                      <i class="fas fa-calendar-xmark mb-2 text-xl d-block" style="font-size: 24px; color: #cbd5e1;"></i>
                      No exam schedules created yet. Click <strong>"Add New Schedule"</strong> to configure exam dates.
                    </td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            <!-- Table Footer with Records Count and Pagination -->
            <div class="erp-table-footer">
              <div class="erp-table-info">
                Showing 1 to {{ count($examschedules) }} of {{ count($examschedules) }} schedules
              </div>
              <ul class="erp-pagination">
                <li class="page-item disabled">
                  <a class="page-link" href="#"><i class="fas fa-chevron-left" style="font-size: 10px;"></i></a>
                </li>
                <li class="page-item active">
                  <a class="page-link" href="#">1</a>
                </li>
                <li class="page-item disabled">
                  <a class="page-link" href="#"><i class="fas fa-chevron-right" style="font-size: 10px;"></i></a>
                </li>
              </ul>
            </div>

          </div>
          <!-- End ERP Card Table -->

        </div>
      </div>
      <!-- End Main Panel -->

    </div>
  </div>

  @include('view-file.script')

  <!-- SweetAlert2 Delete Confirmation -->
  <script>
    function confirmDelete(scheduleId) {
      Swal.fire({
        title: 'Delete Exam Schedule?',
        text: "This action will permanently delete this schedule and associated dates.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Yes, delete it',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById('delete-schedule-' + scheduleId).submit();
        }
      });
    }
  </script>

  <!-- Export Script -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const excelBtn = document.getElementById('excelButton');
      const pdfBtn = document.getElementById('pdfButton');

      if (excelBtn && window.XLSX) {
        excelBtn.addEventListener('click', function() {
          let table = document.getElementById('examsTable');
          let wb = XLSX.utils.table_to_book(table, { sheet: 'Schedules' });
          XLSX.writeFile(wb, 'exam_schedules.xlsx');
        });
      }

      if (pdfBtn && window.jspdf) {
        pdfBtn.addEventListener('click', function() {
          const { jsPDF } = window.jspdf;
          let doc = new jsPDF('p', 'pt', 'a4');
          doc.text("School ERP - Exam Schedules", 40, 30);
          if (doc.autoTable) {
            doc.autoTable({
              html: '#examsTable',
              startY: 45,
              columns: [0, 1, 2, 3, 4],
              theme: 'striped',
              headStyles: { fillColor: [79, 70, 229] }
            });
            doc.save('exam_schedules.pdf');
          }
        });
      }
    });
  </script>
</body>
</html>
