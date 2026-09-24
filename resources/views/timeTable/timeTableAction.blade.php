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
                  <h4 class="erp-table-title"><i class="fas fa-calendar-days text-primary me-2"></i>TimeTable Schedules</h4>
                  <p class="erp-table-subtitle">Manage class schedules, period timings, teacher allocations, and slot statuses</p>
                </div>
                <div class="d-flex gap-2">
                  <a href="{{ route('timeTable_show') }}" class="btn btn-light btn-sm font-weight-bold" style="border: 1px solid var(--erp-border, #e2e8f0); color: #475569;">
                    <i class="fas fa-table-cells me-1"></i> Class Matrix
                  </a>
                  <a href="{{ route('teacher_timeTable_show') }}" class="btn btn-light btn-sm font-weight-bold" style="border: 1px solid var(--erp-border, #e2e8f0); color: #475569;">
                    <i class="fas fa-user-clock me-1"></i> Teacher Matrix
                  </a>
                  <a href="{{ route('timeTable_create') }}" class="btn btn-primary btn-sm font-weight-bold shadow-sm">
                    <i class="fas fa-plus me-1"></i> Add Schedule
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

                <!-- Right: Server/Client Filters -->
                <form id="searchForm" method="GET" action="{{ route('timeTable') }}" class="m-0">
                  <div class="erp-filter-group">
                    <select name="class" id="class" class="form-control erp-filter-select" style="width: 140px;">
                      <option value="">All Classes</option>
                      @foreach ($classes as $class)
                        <option value="{{ $class->id }}" {{ $class->id == request()->query('class') ? 'selected' : '' }}>
                          {{ $class->name }}
                        </option>
                      @endforeach
                    </select>

                    <select name="section" id="section" class="form-control erp-filter-select" style="width: 140px;">
                      <option value="">All Sections</option>
                      @foreach ($sections as $section)
                        <option value="{{ $section->id }}" {{ $section->id == request()->query('section') ? 'selected' : '' }}>
                          {{ $section->name }}
                        </option>
                      @endforeach
                    </select>

                    <select name="teacher" id="teacher" class="form-control erp-filter-select" style="width: 160px;">
                      <option value="">All Teachers</option>
                      @foreach ($employees as $employee)
                        @if($employee->designation->name == "Teacher")
                          <option value="{{ $employee->id }}" {{ $employee->id == request()->query('teacher') ? 'selected' : '' }}>
                            {{ $employee->name }}
                          </option>
                        @endif
                      @endforeach
                    </select>

                    <button type="submit" class="erp-btn-filter-action erp-btn-filter-search" title="Apply Filter">
                      <i class="fas fa-filter"></i><span>Filter</span>
                    </button>
                    <a href="{{ route('timeTable') }}" class="erp-btn-filter-action erp-btn-filter-reset" title="Reset Filters">
                      <i class="fas fa-rotate-left"></i><span>Reset</span>
                    </a>
                  </div>
                </form>
              </div>

              <!-- Table -->
              <div class="table-responsive">
                <table class="table erp-table" id="timetablesTable">
                  <thead>
                    <tr>
                      <th style="width: 50px;">#</th>
                      <th>Class</th>
                      <th>Section</th>
                      <th>Subject</th>
                      <th>Teacher</th>
                      <th>Time Slot</th>
                      <th style="width: 120px;" class="text-center">Slot Status</th>
                      <th style="width: 130px;" class="text-center">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php $count = 0; @endphp
                    @forelse ($timetables as $timetable)
                      <tr>
                        <td class="font-weight-bold text-muted">{{ ++$count }}</td>
                        <td>
                          <span class="badge" style="background-color: #f1f5f9; color: #334155; border: 1px solid #cbd5e1; font-weight: 600; font-size: 11px; padding: 4px 8px; border-radius: 6px;">
                            {{ $timetable->class->name }}
                          </span>
                        </td>
                        <td>
                          <span class="font-weight-500 text-dark">{{ $timetable->section->name }}</span>
                        </td>
                        <td>
                          <div class="font-weight-600 text-dark">{{ $timetable->subject->subject_name }}</div>
                        </td>
                        <td>
                          <div class="d-flex align-items-center">
                            <div class="me-2" style="width: 26px; height: 26px; border-radius: 50%; background: #e0e7ff; color: #4338ca; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700;">
                              {{ strtoupper(substr($timetable->teacher->name ?? 'T', 0, 1)) }}
                            </div>
                            <span class="font-weight-500 text-dark">{{ $timetable->teacher->name }}</span>
                          </div>
                        </td>
                        <td>
                          <span class="erp-code-pill" style="color: #0f766e; background: #ccfbf1; border-color: #99f6e4;">
                            <i class="fas fa-clock me-1 text-muted"></i>
                            {{ Carbon::parse($timetable->start_time)->format('g:i A') }} - {{ Carbon::parse($timetable->end_time)->format('g:i A') }}
                          </span>
                        </td>
                        <td class="text-center">
                          @if($timetable->slot_status == 'allocated')
                            <span class="badge" style="background-color: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; font-weight: 600; font-size: 11px; padding: 4px 8px; border-radius: 6px;">
                              <i class="fas fa-lock me-1"></i>Allocated
                            </span>
                          @elseif ($timetable->slot_status == 'available')
                            <span class="badge" style="background-color: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; font-weight: 600; font-size: 11px; padding: 4px 8px; border-radius: 6px;">
                              <i class="fas fa-unlock me-1"></i>Available
                            </span>
                          @else
                            <span class="badge" style="background-color: #fffbeb; color: #d97706; border: 1px solid #fde68a; font-weight: 600; font-size: 11px; padding: 4px 8px; border-radius: 6px;">
                              {{ ucfirst($timetable->slot_status) }}
                            </span>
                          @endif
                        </td>
                        <td class="text-center">
                          <div class="erp-action-btn-group justify-content-center">
                            @if($timetable->slot_status == 'allocated')
                              <a class="erp-action-btn" style="color: #0284c7; background: #e0f2fe;" href="{{ route('timetable_freeSlot', ['id' => $timetable->id]) }}" title="Free this slot">
                                <i class="fas fa-circle-notch"></i>
                              </a>
                            @else
                              <a class="erp-action-btn" style="color: #059669; background: #d1fae5;" href="{{ route('timetable_occupySlot', ['id' => $timetable->id]) }}" title="Allocate this slot">
                                <i class="fas fa-lock"></i>
                              </a>
                            @endif
                            <a class="erp-action-btn erp-btn-edit" href="{{ route('timetable_edit', ['id' => $timetable->id]) }}" title="Edit Schedule">
                              <i class="fas fa-pen"></i>
                            </a>
                            <button type="button" class="erp-action-btn erp-btn-delete" title="Delete Schedule" onclick="confirmDelete(event, '{{ route('timetable_delete', ['id' => $timetable->id]) }}')">
                              <i class="fas fa-trash-can"></i>
                            </button>
                          </div>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="8" class="text-center py-4 text-muted">
                          <i class="fas fa-calendar-xmark fa-2x mb-2 d-block text-muted opacity-50"></i>
                          No timetable schedules found for the selected criteria.
                        </td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>

              <!-- Footer -->
              <div class="erp-table-footer">
                <div class="erp-footer-count">
                  Showing <span>{{ $count }}</span> schedule entries
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
    function confirmDelete(event, url) {
      event.preventDefault();
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#4f46e5',
        cancelButtonColor: '#ef4444',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = url;
        }
      });
    }

    document.addEventListener('DOMContentLoaded', function() {
      // Exports
      const copyBtn = document.getElementById('copyButton');
      const csvBtn = document.getElementById('csvButton');
      const excelBtn = document.getElementById('excelButton');
      const pdfBtn = document.getElementById('pdfButton');

      if (copyBtn) {
        new ClipboardJS(copyBtn, {
          text: function() {
            let table = document.getElementById('timetablesTable');
            return table.innerText;
          }
        }).on('success', function() {
          Swal.fire({ icon: 'success', title: 'Copied!', timer: 1500, showConfirmButton: false });
        });
      }

      if (csvBtn) {
        csvBtn.addEventListener('click', function() {
          let csv = [];
          let rows = document.querySelectorAll('#timetablesTable tr');
          rows.forEach(row => {
            let cols = row.querySelectorAll('th, td');
            let rowData = [];
            for (let i = 0; i < cols.length - 1; i++) {
              rowData.push('"' + cols[i].innerText.replace(/"/g, '""').trim() + '"');
            }
            csv.push(rowData.join(','));
          });
          let blob = new Blob([csv.join('\n')], { type: 'text/csv;charset=utf-8;' });
          let link = document.createElement('a');
          link.href = URL.createObjectURL(blob);
          link.download = 'timetables.csv';
          link.click();
        });
      }

      if (excelBtn) {
        excelBtn.addEventListener('click', function() {
          let table = document.getElementById('timetablesTable');
          let wb = XLSX.utils.table_to_book(table, { sheet: 'TimeTable' });
          XLSX.writeFile(wb, 'timetables.xlsx');
        });
      }

      if (pdfBtn) {
        pdfBtn.addEventListener('click', function() {
          const { jsPDF } = window.jspdf;
          let doc = new jsPDF('landscape');
          doc.text('TimeTable Schedules', 14, 15);
          doc.autoTable({
            html: '#timetablesTable',
            startY: 20,
            columns: [0, 1, 2, 3, 4, 5, 6]
          });
          doc.save('timetables.pdf');
        });
      }
    });
  </script>

  @if(session('message'))
  <script>
    Swal.fire({
      title: 'Success!',
      text: "{{ session('message') }}",
      icon: 'success',
      confirmButtonText: 'OK'
    });
  </script>
  @endif

  @if(session('error'))
  <script>
    Swal.fire({
      title: 'Error!',
      text: "{{ session('error') }}",
      icon: 'error',
      confirmButtonText: 'OK'
    });
  </script>
  @endif
</body>
</html>
