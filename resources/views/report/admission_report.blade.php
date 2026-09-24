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
                  <h4 class="erp-table-title"><i class="fas fa-user-graduate text-primary me-2"></i>Admission Report</h4>
                  <p class="erp-table-subtitle">Student enrollment records, class assignments, and admission statistics</p>
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
                    <select name="class" id="class" class="form-control erp-filter-select" style="width: 130px;">
                      <option value="">All Classes</option>
                      @foreach ($classes as $class)
                        <option value="{{ $class->id }}" index="{{ $class->id }}" {{ $class->id == request()->query('class') ? 'selected' : '' }}>
                          {{ $class->name }}
                        </option>
                      @endforeach
                    </select>

                    <select name="section" id="section" class="form-control erp-filter-select" style="width: 140px;">
                      <option value="">All Sections</option>
                      @foreach ($sections as $section)
                        <option value="{{ $section->id }}" class="ab ab{{ $section->classe_id }}" {{ $section->id == request()->query('section') ? 'selected' : '' }}>
                          {{ $section->name }}, {{ $section->classe->name }}
                        </option>
                      @endforeach
                    </select>

                    <input type="date" name="start_date" class="form-control erp-filter-input" value="{{ request()->query('start_date') }}" title="Start Date" style="width: 130px;">
                    <input type="date" name="end_date" class="form-control erp-filter-input" value="{{ request()->query('end_date') }}" title="End Date" style="width: 130px;">

                    <button type="submit" class="erp-btn-filter-action erp-btn-filter-search" title="Search Records">
                      <i class="fas fa-filter"></i><span>Filter</span>
                    </button>
                    <a href="{{ url()->current() }}" class="erp-btn-filter-action erp-btn-filter-reset" title="Reset Filters">
                      <i class="fas fa-rotate-left"></i><span>Reset</span>
                    </a>
                  </div>
                </form>
              </div>

              <!-- Table -->
              <div class="table-responsive">
                <table id="admissionsTable" class="table erp-table">
                  <thead>
                    <tr>
                      <th style="width: 50px;">#</th>
                      <th>Student Name</th>
                      <th>Class</th>
                      <th>Section</th>
                      <th>Admission Date</th>
                      <th style="width: 110px;" class="text-center">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                      $count = 0;
                      $totalStudent = 0;
                    @endphp
                    @forelse ($students as $student)
                      <tr>
                        <td class="font-weight-bold text-muted">{{ ++$count }}</td>
                        <td>
                          <div class="d-flex align-items-center">
                            <div class="me-2" style="width: 28px; height: 28px; border-radius: 50%; background: #e0e7ff; color: #4338ca; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700;">
                              {{ strtoupper(substr($student->name ?? 'S', 0, 1)) }}
                            </div>
                            <div>
                              <div class="font-weight-600 text-dark">{{ $student->name }}</div>
                              <span class="text-muted" style="font-size: 11px;">Roll: #{{ $student->id }}</span>
                            </div>
                          </div>
                        </td>
                        <td>
                          <span class="badge" style="background-color: #f1f5f9; color: #334155; border: 1px solid #cbd5e1; font-weight: 600; font-size: 11px; padding: 4px 8px; border-radius: 6px;">
                            {{ $student->class->name ?? 'N/A' }}
                          </span>
                        </td>
                        <td>
                          <span class="font-weight-500 text-dark">{{ $student->section->name ?? 'N/A' }}</span>
                        </td>
                        <td>
                          <span class="erp-code-pill" style="color: #475569; background: #f8fafc; border-color: #e2e8f0;">
                            <i class="fas fa-calendar-check me-1 text-muted"></i>
                            {{ optional($student->created_at)->format('d M, Y') ?? 'N/A' }}
                          </span>
                        </td>
                        <td class="text-center">
                          @if(strtolower($student->status ?? '') == 'active')
                            <span class="badge" style="background-color: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; font-weight: 600; font-size: 11px; padding: 4px 8px; border-radius: 6px;">
                              <i class="fas fa-circle-check me-1"></i>Active
                            </span>
                          @else
                            <span class="badge" style="background-color: #f1f5f9; color: #64748b; border: 1px solid #cbd5e1; font-weight: 600; font-size: 11px; padding: 4px 8px; border-radius: 6px;">
                              {{ ucfirst($student->status ?? 'Registered') }}
                            </span>
                          @endif
                        </td>
                      </tr>
                      @php $totalStudent++; @endphp
                    @empty
                      <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                          <i class="fas fa-user-xmark fa-2x mb-2 d-block text-muted opacity-50"></i>
                          No student admission records found for the selected date range.
                        </td>
                      </tr>
                    @endforelse
                  </tbody>
                  @if($totalStudent > 0)
                    <tfoot>
                      <tr style="background: #f8fafc; font-weight: 600;">
                        <td colspan="4" class="text-right py-3" style="color: #475569; font-size: 13px;">
                          <strong>Total Admissions Recorded:</strong>
                        </td>
                        <td colspan="2" class="py-3">
                          <span class="badge" style="background-color: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; font-size: 13px; font-weight: 700; padding: 6px 12px; border-radius: 8px;">
                            <i class="fas fa-users me-1"></i> {{ $totalStudent }} Students
                          </span>
                        </td>
                      </tr>
                    </tfoot>
                  @endif
                </table>
              </div>

              <!-- Footer -->
              <div class="erp-table-footer">
                <div class="erp-footer-count">
                  Showing <span>{{ $totalStudent }}</span> total students
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
            let table = document.getElementById('admissionsTable');
            return table.innerText;
          }
        }).on('success', function() {
          Swal.fire({ icon: 'success', title: 'Copied!', timer: 1500, showConfirmButton: false });
        });
      }

      if (csvBtn) {
        csvBtn.addEventListener('click', function() {
          let csv = [];
          let rows = document.querySelectorAll('#admissionsTable tr');
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
          link.download = 'admission_report.csv';
          link.click();
        });
      }

      if (excelBtn) {
        excelBtn.addEventListener('click', function() {
          let table = document.getElementById('admissionsTable');
          let wb = XLSX.utils.table_to_book(table, { sheet: 'Admissions' });
          XLSX.writeFile(wb, 'admission_report.xlsx');
        });
      }

      if (pdfBtn) {
        pdfBtn.addEventListener('click', function() {
          const { jsPDF } = window.jspdf;
          let doc = new jsPDF();
          doc.text('Admission Report', 14, 15);
          doc.autoTable({
            html: '#admissionsTable',
            startY: 20
          });
          doc.save('admission_report.pdf');
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
