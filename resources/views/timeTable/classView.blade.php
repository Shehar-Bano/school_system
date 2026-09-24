<!DOCTYPE html>
<html lang="en">
@php
    use Carbon\Carbon;
@endphp
@include('view-file/head')

<body>
  <div class="container-scroller">
    @include('view-file/nav')
    <div class="container-fluid page-body-wrapper">
      @include('view-file.side-bar')

      <!-- Inner-page -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="container-fluid px-3 py-2">

            <div class="erp-card-table">
              <!-- Header Block -->
              <div class="erp-table-header-block">
                <div>
                  <h4 class="erp-table-title"><i class="fas fa-table-cells text-primary me-2"></i>Class TimeTable Matrix</h4>
                  <p class="erp-table-subtitle">Weekly schedule breakdown by subject and day</p>
                </div>
                <div class="d-flex gap-2">
                  <a href="{{ route('timeTable') }}" class="btn btn-light btn-sm font-weight-bold" style="border: 1px solid var(--erp-border, #e2e8f0); color: #475569;">
                    <i class="fas fa-arrow-left me-1"></i> All Schedules
                  </a>
                  <a href="{{ route('teacher_timeTable_show') }}" class="btn btn-light btn-sm font-weight-bold" style="border: 1px solid var(--erp-border, #e2e8f0); color: #475569;">
                    <i class="fas fa-user-clock me-1"></i> Teacher Matrix
                  </a>
                </div>
              </div>

              <!-- Toolbar -->
              <div class="erp-toolbar">
                <!-- Left: Export Buttons -->
                <div class="erp-export-group">
                  <button id="copyButton" class="erp-btn-export" title="Copy to Clipboard">
                    <i class="fas fa-copy"></i><span>Copy</span>
                  </button>
                  <button id="csvButton" class="erp-btn-export" title="Export to CSV">
                    <i class="fas fa-file-csv"></i><span>CSV</span>
                  </button>
                  <button id="excelButton" class="erp-btn-export" title="Export to Excel">
                    <i class="fas fa-file-excel"></i><span>Excel</span>
                  </button>
                  <button id="pdfButton" class="erp-btn-export" title="Export to PDF">
                    <i class="fas fa-file-pdf"></i><span>PDF</span>
                  </button>
                </div>

                <!-- Right: Filters -->
                <form id="searchForm" method="GET" action="{{ route('timeTable_show') }}" class="m-0">
                  <div class="erp-filter-group">
                    <select name="class" id="class" class="form-control erp-filter-select" style="width: 140px;">
                      <option value="">Select Class</option>
                      @foreach ($classes as $class)
                        <option value="{{ $class->id }}" {{ $class->id == request()->query('class') ? 'selected' : '' }}>
                          {{ $class->name }}
                        </option>
                      @endforeach
                    </select>

                    <select name="section" id="section" class="form-control erp-filter-select" style="width: 150px;">
                      <option value="">Select Section</option>
                      @foreach ($sections as $section)
                        <option value="{{ $section->id }}" {{ $section->id == request()->query('section') ? 'selected' : '' }}>
                          {{ $section->name }} - {{ $section->classe->name }}
                        </option>
                      @endforeach
                    </select>

                    <select name="teacher" id="teacher" class="form-control erp-filter-select" style="width: 160px;">
                      <option value="">Select Teacher</option>
                      @foreach ($employees as $employee)
                        @if($employee->designation->name == "Teacher")
                          <option value="{{ $employee->id }}" {{ $employee->id == request()->query('teacher') ? 'selected' : '' }}>
                            {{ $employee->name }}
                          </option>
                        @endif
                      @endforeach
                    </select>

                    <button type="submit" class="erp-btn-filter-action erp-btn-filter-search" title="Filter Schedule">
                      <i class="fas fa-filter"></i><span>Search</span>
                    </button>
                    <a href="{{ route('timeTable_show') }}" class="erp-btn-filter-action erp-btn-filter-reset" title="Reset Filters">
                      <i class="fas fa-rotate-left"></i><span>Reset</span>
                    </a>
                  </div>
                </form>
              </div>

              <!-- Table Matrix -->
              <div class="table-responsive">
                <table class="table erp-table" id="classTimetableMatrix" style="min-width: 900px;">
                  <thead>
                    <tr>
                      <th style="width: 180px;">Subject</th>
                      @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                        <th class="text-center" style="min-width: 140px;">{{ $day }}</th>
                      @endforeach
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($subjects as $subject)
                      <tr>
                        <td>
                          <div class="font-weight-600 text-dark">{{ $subject->subject_name }}</div>
                          <span class="badge badge-light text-muted" style="font-size: 10px;">ID: #{{ $subject->id }}</span>
                        </td>
                        @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                          <td class="text-center align-top p-2">
                            @php
                              $dayTimetables = $timetables->where('day', $day)->where('subject_id', $subject->id);
                            @endphp
                            @if($dayTimetables->isNotEmpty())
                              @foreach ($dayTimetables as $timetable)
                                <div class="p-2 mb-1 text-left rounded shadow-xs" style="background: #f8fafc; border: 1px solid #e2e8f0; font-size: 11px;">
                                  <div class="font-weight-bold text-primary mb-1">
                                    <i class="fas fa-clock me-1 text-muted"></i>
                                    {{ Carbon::parse($timetable->start_time)->format('g:i A') }} - {{ Carbon::parse($timetable->end_time)->format('g:i A') }}
                                  </div>
                                  <div class="text-secondary mb-1">
                                    <strong>Sec:</strong> {{ $timetable->section->name ?? 'N/A' }}
                                  </div>
                                  <div class="text-dark font-weight-500">
                                    <i class="fas fa-user-tie me-1 text-muted"></i>{{ $timetable->teacher->name ?? 'N/A' }}
                                  </div>
                                </div>
                              @endforeach
                            @else
                              <span class="text-muted opacity-50" style="font-size: 12px;">—</span>
                            @endif
                          </td>
                        @endforeach
                      </tr>
                    @empty
                      <tr>
                        <td colspan="8" class="text-center py-4 text-muted">
                          <i class="fas fa-calendar-xmark fa-2x mb-2 d-block text-muted opacity-50"></i>
                          No timetable slots found for the selected filter.
                        </td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>

              <!-- Footer -->
              <div class="erp-table-footer">
                <div class="erp-footer-count">
                  Weekly Class Schedule Matrix
                </div>
              </div>

            </div>

          </div>
        </div>
      </div>
      <!-- End Inner-page -->
    </div>
  </div>

  @include('view-file.script')

  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.11/clipboard.min.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const copyBtn = document.getElementById('copyButton');
      const csvBtn = document.getElementById('csvButton');
      const excelBtn = document.getElementById('excelButton');
      const pdfBtn = document.getElementById('pdfButton');

      if (copyBtn) {
        new ClipboardJS(copyBtn, {
          text: function() {
            let table = document.getElementById('classTimetableMatrix');
            return table.innerText;
          }
        }).on('success', function() {
          Swal.fire({ icon: 'success', title: 'Copied!', timer: 1500, showConfirmButton: false });
        });
      }

      if (csvBtn) {
        csvBtn.addEventListener('click', function() {
          let csv = [];
          let rows = document.querySelectorAll('#classTimetableMatrix tr');
          rows.forEach(row => {
            let cols = row.querySelectorAll('th, td');
            let rowData = [];
            for (let i = 0; i < cols.length; i++) {
              rowData.push('"' + cols[i].innerText.replace(/"/g, '""').trim() + '"');
            }
            csv.push(rowData.join(','));
          });
          let blob = new Blob([csv.join('\n')], { type: 'text/csv;charset=utf-8;' });
          let link = document.createElement('a');
          link.href = URL.createObjectURL(blob);
          link.download = 'class_timetable_matrix.csv';
          link.click();
        });
      }

      if (excelBtn) {
        excelBtn.addEventListener('click', function() {
          let table = document.getElementById('classTimetableMatrix');
          let wb = XLSX.utils.table_to_book(table, { sheet: 'ClassTimeTable' });
          XLSX.writeFile(wb, 'class_timetable_matrix.xlsx');
        });
      }

      if (pdfBtn) {
        pdfBtn.addEventListener('click', function() {
          const { jsPDF } = window.jspdf;
          let doc = new jsPDF('landscape');
          doc.text('Class TimeTable Matrix', 14, 15);
          doc.autoTable({
            html: '#classTimetableMatrix',
            startY: 20
          });
          doc.save('class_timetable_matrix.pdf');
        });
      }
    });
  </script>
</body>
</html>
