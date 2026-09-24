<!DOCTYPE html>
<html lang="en">
@include('view-file/head')

<style>
@media print {
  .erp-toolbar, .erp-table-header-block .btn, .navbar, .sidebar {
    display: none !important;
  }
  .main-panel {
    width: 100% !important;
    margin: 0 !important;
    padding: 0 !important;
  }
}
</style>

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
                  <h4 class="erp-table-title"><i class="fas fa-clipboard-user text-primary me-2"></i>Attendance & Result Report</h4>
                  <p class="erp-table-subtitle">Comprehensive attendance tracking, status metrics, and student logs</p>
                </div>
                <button type="button" class="btn btn-primary btn-sm font-weight-bold shadow-sm" onclick="window.print()">
                  <i class="fas fa-print me-1"></i> Print Report
                </button>
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
                <form id="searchForm" method="GET" action="" class="m-0">
                  <div class="erp-filter-group">
                    <select name="class" id="class" class="form-control erp-filter-select" style="width: 150px;">
                      <option value="">Select Class</option>
                      @foreach ($classes as $class)
                        <option value="{{ $class->id }}" index="{{ $class->id }}" {{ $class->id == request()->query('class') ? 'selected' : '' }}>
                          {{ $class->name }}
                        </option>
                      @endforeach
                    </select>

                    <select name="section" id="section" class="form-control erp-filter-select" style="width: 160px;">
                      <option value="">Select Section</option>
                      @foreach ($sections as $section)
                        <option value="{{ $section->id }}" class="ab ab{{ $section->classe_id }}" {{ $section->id == request()->query('section') ? 'selected' : '' }}>
                          {{ $section->name }}, {{ $section->classe->name }}
                        </option>
                      @endforeach
                    </select>

                    <button type="submit" class="erp-btn-filter-action erp-btn-filter-search" title="Search Records">
                      <i class="fas fa-filter"></i><span>Search</span>
                    </button>
                    <a href="{{ url()->current() }}" class="erp-btn-filter-action erp-btn-filter-reset" title="Reset Filters">
                      <i class="fas fa-rotate-left"></i><span>Reset</span>
                    </a>
                  </div>
                </form>
              </div>

              <!-- Table -->
              <div class="table-responsive">
                <table id="attendanceReportTable" class="table erp-table">
                  <thead>
                    <tr>
                      <th style="width: 50px;">#</th>
                      <th>Student Name</th>
                      <th>Date</th>
                      <th style="width: 120px;" class="text-center">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                      $count = 0;
                      $totalStudent = 0;
                      $present = 0;
                      $absent = 0;
                      $leaves = 0;
                      $uniqueStudents = [];
                    @endphp

                    @forelse ($attendences as $attend)
                      @php
                        if (!in_array($attend->student->id ?? 0, $uniqueStudents)) {
                          $uniqueStudents[] = $attend->student->id ?? 0;
                          $totalStudent++;
                        }

                        $status = strtolower($attend->status ?? '');
                        if ($status == 'present') {
                          $present++;
                        } elseif ($status == 'absent') {
                          $absent++;
                        } elseif ($status == 'leave') {
                          $leaves++;
                        }
                      @endphp
                      <tr>
                        <td class="font-weight-bold text-muted">{{ ++$count }}</td>
                        <td>
                          <div class="d-flex align-items-center">
                            <div class="me-2" style="width: 28px; height: 28px; border-radius: 50%; background: #e0e7ff; color: #4338ca; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700;">
                              {{ strtoupper(substr($attend->student->name ?? 'S', 0, 1)) }}
                            </div>
                            <div>
                              <div class="font-weight-600 text-dark">{{ $attend->student->name ?? 'N/A' }}</div>
                              <span class="text-muted" style="font-size: 11px;">Roll: #{{ $attend->student->id ?? '' }}</span>
                            </div>
                          </div>
                        </td>
                        <td>
                          <span class="erp-code-pill" style="color: #475569; background: #f8fafc; border-color: #e2e8f0;">
                            <i class="fas fa-calendar-day me-1 text-muted"></i>
                            {{ $attend->date }}
                          </span>
                        </td>
                        <td class="text-center">
                          @if ($status == 'present')
                            <span class="badge" style="background-color: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; font-weight: 600; font-size: 11px; padding: 4px 8px; border-radius: 6px;">
                              <i class="fas fa-check-circle me-1"></i>Present
                            </span>
                          @elseif ($status == 'absent')
                            <span class="badge" style="background-color: #fef2f2; color: #dc2626; border: 1px solid #fecaca; font-weight: 600; font-size: 11px; padding: 4px 8px; border-radius: 6px;">
                              <i class="fas fa-times-circle me-1"></i>Absent
                            </span>
                          @elseif ($status == 'leave')
                            <span class="badge" style="background-color: #fffbeb; color: #d97706; border: 1px solid #fde68a; font-weight: 600; font-size: 11px; padding: 4px 8px; border-radius: 6px;">
                              <i class="fas fa-clock-rotate-left me-1"></i>Leave
                            </span>
                          @else
                            <span class="badge" style="background-color: #f1f5f9; color: #64748b; border: 1px solid #cbd5e1; font-weight: 600; font-size: 11px; padding: 4px 8px; border-radius: 6px;">
                              {{ ucfirst($attend->status ?? 'N/A') }}
                            </span>
                          @endif
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="4" class="text-center py-4 text-muted">
                          <i class="fas fa-clipboard-question fa-2x mb-2 d-block text-muted opacity-50"></i>
                          No attendance records found for the selected criteria.
                        </td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>

              <!-- Metric Cards Summary Block -->
              <div class="p-3" style="background: #fafafa; border-top: 1px solid var(--erp-border, #e2e8f0);">
                <h6 class="font-weight-bold text-dark mb-3" style="font-size: 13px;">
                  <i class="fas fa-chart-pie text-primary me-2"></i>Attendance Summary
                </h6>
                <div class="row g-2">
                  <div class="col-md-3 col-6 mb-2">
                    <div class="p-3 rounded bg-white shadow-xs" style="border: 1px solid #e2e8f0;">
                      <div class="text-muted" style="font-size: 11px; font-weight: 600; text-transform: uppercase;">Unique Students</div>
                      <div class="font-weight-bold text-dark mt-1" style="font-size: 18px;">
                        <i class="fas fa-users text-primary me-1"></i> {{ $totalStudent }}
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3 col-6 mb-2">
                    <div class="p-3 rounded bg-white shadow-xs" style="border: 1px solid #e2e8f0;">
                      <div class="text-muted" style="font-size: 11px; font-weight: 600; text-transform: uppercase;">Total Presents</div>
                      <div class="font-weight-bold text-success mt-1" style="font-size: 18px;">
                        <i class="fas fa-circle-check me-1"></i> {{ $present }}
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3 col-6 mb-2">
                    <div class="p-3 rounded bg-white shadow-xs" style="border: 1px solid #e2e8f0;">
                      <div class="text-muted" style="font-size: 11px; font-weight: 600; text-transform: uppercase;">Total Absents</div>
                      <div class="font-weight-bold text-danger mt-1" style="font-size: 18px;">
                        <i class="fas fa-circle-xmark me-1"></i> {{ $absent }}
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3 col-6 mb-2">
                    <div class="p-3 rounded bg-white shadow-xs" style="border: 1px solid #e2e8f0;">
                      <div class="text-muted" style="font-size: 11px; font-weight: 600; text-transform: uppercase;">Total Leaves</div>
                      <div class="font-weight-bold text-warning mt-1" style="font-size: 18px;">
                        <i class="fas fa-clock-rotate-left me-1"></i> {{ $leaves }}
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Footer -->
              <div class="erp-table-footer">
                <div class="erp-footer-count">
                  Showing <span>{{ $count }}</span> attendance entries
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
            let table = document.getElementById('attendanceReportTable');
            return table.innerText;
          }
        }).on('success', function() {
          Swal.fire({ icon: 'success', title: 'Copied!', timer: 1500, showConfirmButton: false });
        });
      }

      if (csvBtn) {
        csvBtn.addEventListener('click', function() {
          let csv = [];
          let rows = document.querySelectorAll('#attendanceReportTable tr');
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
          link.download = 'attendance_report.csv';
          link.click();
        });
      }

      if (excelBtn) {
        excelBtn.addEventListener('click', function() {
          let table = document.getElementById('attendanceReportTable');
          let wb = XLSX.utils.table_to_book(table, { sheet: 'Attendance' });
          XLSX.writeFile(wb, 'attendance_report.xlsx');
        });
      }

      if (pdfBtn) {
        pdfBtn.addEventListener('click', function() {
          const { jsPDF } = window.jspdf;
          let doc = new jsPDF();
          doc.text('Attendance & Result Report', 14, 15);
          doc.autoTable({
            html: '#attendanceReportTable',
            startY: 20
          });
          doc.save('attendance_report.pdf');
        });
      }
    });

    $(document).ready(function(){
      $('#class').on('change', function() {
        var selectedOption = $(this).find('option:selected');
        var classId = selectedOption.attr('index');
        if (classId) {
          $('.ab').hide();
          $('.ab' + classId).css('display', 'block');
        } else {
          $('.ab').show();
        }
      });
    });
  </script>

</body>
</html>
