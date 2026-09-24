<!DOCTYPE html>
<html lang="en">
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
                  <h4 class="erp-table-title"><i class="fas fa-clock-rotate-left text-primary me-2"></i>Student History Directory</h4>
                  <p class="erp-table-subtitle">View lifetime academic records, attendance archives, and performance history</p>
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
                <form id="searchForm" method="GET" action="" class="m-0">
                  <div class="erp-filter-group">
                    <select name="class" id="class" class="form-control erp-filter-select" style="width: 140px;">
                      <option value="">All Classes</option>
                      @foreach ($classes as $class)
                        <option value="{{ $class->id }}" {{ $class->id == request()->query('class') ? 'selected' : '' }}>
                          {{ $class->name }}
                        </option>
                      @endforeach
                    </select>

                    <select name="section" id="section" class="form-control erp-filter-select" style="width: 150px;">
                      <option value="">All Sections</option>
                      @foreach ($sections as $section)
                        <option value="{{ $section->id }}" {{ $section->id == request()->query('section') ? 'selected' : '' }}>
                          {{ $section->name }}, {{ $section->classe->name }}
                        </option>
                      @endforeach
                    </select>

                    <button type="submit" class="erp-btn-filter-action erp-btn-filter-search" title="Filter Students">
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
                <table class="table erp-table" id="studentHistoryTable">
                  <thead>
                    <tr>
                      <th style="width: 50px;">#</th>
                      <th>Student</th>
                      <th>Class</th>
                      <th>Section</th>
                      <th style="width: 110px;" class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php $count = 0; @endphp
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
                        <td class="text-center">
                          <div class="erp-action-btn-group justify-content-center">
                            <a href="{{ route('admin.student.history', ['student_id' => $student->id]) }}" class="erp-action-btn erp-btn-view" title="View Full Academic History">
                              <i class="fas fa-eye"></i>
                            </a>
                          </div>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                          <i class="fas fa-users-slash fa-2x mb-2 d-block text-muted opacity-50"></i>
                          No students found matching the selected filters.
                        </td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>

              <!-- Footer -->
              <div class="erp-table-footer">
                <div class="erp-footer-count">
                  Showing <span>{{ $count }}</span> student history records
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
            let table = document.getElementById('studentHistoryTable');
            return table.innerText;
          }
        }).on('success', function() {
          Swal.fire({ icon: 'success', title: 'Copied!', timer: 1500, showConfirmButton: false });
        });
      }

      if (csvBtn) {
        csvBtn.addEventListener('click', function() {
          let csv = [];
          let rows = document.querySelectorAll('#studentHistoryTable tr');
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
          link.download = 'student_history_directory.csv';
          link.click();
        });
      }

      if (excelBtn) {
        excelBtn.addEventListener('click', function() {
          let table = document.getElementById('studentHistoryTable');
          let wb = XLSX.utils.table_to_book(table, { sheet: 'Students' });
          XLSX.writeFile(wb, 'student_history_directory.xlsx');
        });
      }

      if (pdfBtn) {
        pdfBtn.addEventListener('click', function() {
          const { jsPDF } = window.jspdf;
          let doc = new jsPDF();
          doc.text('Student History Directory', 14, 15);
          doc.autoTable({
            html: '#studentHistoryTable',
            startY: 20,
            columns: [0, 1, 2, 3]
          });
          doc.save('student_history_directory.pdf');
        });
      }
    });
  </script>

</body>
</html>
