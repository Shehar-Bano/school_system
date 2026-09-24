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
                  <i class="fas fa-square-poll-vertical text-primary"></i>
                  Student Examination Results
                </h3>
                <p class="erp-table-subtitle">View and print student academic transcripts, grades, and mark sheets</p>
              </div>

              <!-- Top Action: Enter Marks Button -->
              <div>
                <a href="{{ route('result') }}" class="btn btn-sm btn-primary">
                  <i class="fas fa-plus mr-1"></i> Enter New Results
                </a>
              </div>
            </div>

            <!-- Single-Line Compact Toolbar (Exports & Filters) -->
            <div class="erp-toolbar">
              <!-- Left: Grouped Export Buttons -->
              <div class="erp-export-group">
                <button type="button" id="copyButton" class="erp-export-btn" title="Copy to clipboard">
                  <i class="fas fa-copy"></i> Copy
                </button>
                <button type="button" id="csvButton" class="erp-export-btn" title="Export to CSV">
                  <i class="fas fa-file-csv"></i> CSV
                </button>
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
              <table class="erp-table" id="resultsTable">
                <thead>
                  <tr>
                    <th style="width: 50px;" class="text-center">#</th>
                    <th style="width: 30%;">Student Profile</th>
                    <th style="width: 22%;">Class</th>
                    <th style="width: 22%;">Section</th>
                    <th style="width: 110px;" class="text-center">Mark Sheet</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                    $count = 0;
                  @endphp
                  @forelse ($students as $student)
                  <tr>
                    <td class="text-center font-weight-medium text-muted">{{ ++$count }}</td>
                    <td>
                      <div class="d-flex align-items-center gap-2">
                        <div class="erp-user-avatar" style="width: 28px; height: 28px; font-size: 11px;">
                          {{ strtoupper(substr($student->name, 0, 2)) }}
                        </div>
                        <div>
                          <span class="font-weight-semibold text-dark">{{ $student->name }}</span>
                          <small class="d-block text-muted" style="font-size: 10.5px;">Reg: {{ $student->registration ?? 'N/A' }}</small>
                        </div>
                      </div>
                    </td>
                    <td>
                      <span class="badge badge-soft-primary">
                        {{ $student->class->name ?? 'Class' }}
                      </span>
                    </td>
                    <td>
                      <span class="badge badge-soft-purple">
                        {{ $student->section->name ?? 'Section' }}
                      </span>
                    </td>
                    <td class="text-center">
                      @php
                        $examFound = false;
                      @endphp
                      @foreach ($exams as $exam)
                        @if($exam->class_id == $student->class_id && $exam->section_id == $student->section_id)
                          <a href="{{ route('result-view', ['id' => $student->id]) }}" class="btn btn-xs btn-outline-primary font-weight-semibold" title="View Result Sheet">
                            <i class="fas fa-file-lines mr-1"></i> View Result
                          </a>
                          @php
                            $examFound = true;
                            break;
                          @endphp
                        @endif
                      @endforeach

                      @if (!$examFound)
                        <a href="{{ route('not_Found') }}" class="btn btn-xs btn-outline-secondary font-weight-medium" title="No Results Entered">
                          <i class="fas fa-circle-question mr-1"></i> Not Available
                        </a>
                      @endif
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="5" class="text-center py-4 text-muted">
                      <i class="fas fa-square-poll-vertical mb-2 text-xl d-block" style="font-size: 24px; color: #cbd5e1;"></i>
                      No student results found for this class and section.
                    </td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            <!-- Table Footer with Records Count and Pagination -->
            <div class="erp-table-footer">
              <div class="erp-table-info">
                Showing 1 to {{ count($students) }} of {{ count($students) }} students
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

  <!-- Export Functionality -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const copyBtn = document.getElementById('copyButton');
      const csvBtn = document.getElementById('csvButton');
      const excelBtn = document.getElementById('excelButton');
      const pdfBtn = document.getElementById('pdfButton');

      if (copyBtn && window.ClipboardJS) {
        new ClipboardJS(copyBtn, {
          text: function () {
            return document.getElementById('resultsTable').innerText;
          }
        }).on('success', function () {
          Swal.fire({
            toast: true, position: 'top-end', icon: 'success',
            title: 'Results table copied', showConfirmButton: false, timer: 2000
          });
        });
      }

      if (csvBtn) {
        csvBtn.addEventListener('click', function () {
          let csv = [];
          let rows = document.querySelectorAll('#resultsTable tr');
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
          link.download = 'results_sheet.csv';
          link.click();
        });
      }

      if (excelBtn && window.XLSX) {
        excelBtn.addEventListener('click', function () {
          let table = document.getElementById('resultsTable');
          let wb = XLSX.utils.table_to_book(table, { sheet: 'Results' });
          XLSX.writeFile(wb, 'results_sheet.xlsx');
        });
      }

      if (pdfBtn && window.jspdf) {
        pdfBtn.addEventListener('click', function () {
          const { jsPDF } = window.jspdf;
          let doc = new jsPDF('p', 'pt', 'a4');
          doc.text("School ERP - Student Examination Results", 40, 30);
          if (doc.autoTable) {
            doc.autoTable({
              html: '#resultsTable',
              startY: 45,
              columns: [0, 1, 2, 3],
              theme: 'striped',
              headStyles: { fillColor: [79, 70, 229] }
            });
            doc.save('results_sheet.pdf');
          }
        });
      }
    });
  </script>

  @if(session('message'))
  <script>
    Swal.fire({
      title: 'Notice',
      text: "{{ session('message') }}",
      icon: 'info',
      confirmButtonText: 'OK'
    });
  </script>
  @endif
</body>
</html>
