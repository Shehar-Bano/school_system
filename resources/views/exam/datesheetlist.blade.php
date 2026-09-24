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
                  <i class="fas fa-calendar-days text-primary"></i>
                  Examination Date Sheet
                </h3>
                <p class="erp-table-subtitle">Subject-wise schedule, paper timings, and examination dates</p>
              </div>

              <!-- Top Action: Add New Date Button -->
              <div>
                <a href="{{ route('date-sheet', ['id' => $exams->id ?? 0]) }}" class="btn btn-sm btn-primary">
                  <i class="fas fa-plus mr-1"></i> Add Date Sheet Entry
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

              <!-- Right: Search Controls -->
              <div class="erp-filter-group">
                <div class="erp-input-icon-wrapper">
                  <i class="fas fa-search"></i>
                  <input type="text" id="filterSubject" placeholder="Search subject..." autocomplete="off">
                </div>

                <button type="button" id="btnFilterReset" class="erp-btn-filter-action erp-btn-filter-reset">
                  <i class="fas fa-rotate-left"></i> Reset
                </button>
              </div>
            </div>

            <!-- Table Responsive Container -->
            <div class="table-responsive">
              <table class="erp-table" id="datesheetTable">
                <thead>
                  <tr>
                    <th style="width: 50px;" class="text-center">#</th>
                    <th style="width: 35%;">Subject</th>
                    <th style="width: 25%;" class="text-center">Exam Date</th>
                    <th style="width: 25%;" class="text-center">Time Slot</th>
                    <th style="width: 100px;" class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody id="datesheetTableBody">
                  @php
                    $count = 0;
                  @endphp
                  @forelse ($datesheets as $sheet)
                    @if(isset($exams) && $exams->id == $sheet->exam_schedule_id)
                    <tr data-subject="{{ strtolower($sheet->subject->subject_name ?? '') }}">
                      <td class="text-center font-weight-medium text-muted">{{ ++$count }}</td>
                      <td class="font-weight-semibold text-dark">
                        <span class="badge badge-soft-primary font-weight-medium mr-1">
                          <i class="fas fa-book-bookmark text-xs mr-1"></i> {{ $sheet->subject->subject_name ?? 'Subject' }}
                        </span>
                      </td>
                      <td class="text-center">
                        <span class="badge badge-soft-warning font-weight-medium">
                          <i class="fas fa-calendar-day mr-1 text-xs"></i> {{ $sheet->date }}
                        </span>
                      </td>
                      <td class="text-center text-xs font-weight-medium text-dark">
                        <i class="fas fa-clock text-muted mr-1"></i> {{ $sheet->start_time }} to {{ $sheet->end_time }}
                      </td>
                      <td class="text-center">
                        <div class="erp-action-btn-group">
                          <!-- Edit Button -->
                          <a href="{{ route('exam-schedule-date-edit', ['id' => $sheet->id]) }}" class="erp-action-btn edit" title="Edit Date Entry">
                            <i class="fas fa-pen-to-square"></i>
                          </a>

                          <!-- Delete Button -->
                          <form id="delete-datesheet-{{ $sheet->id }}" action="{{ route('exam-schedule-date_delete', ['id' => $sheet->id]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="erp-action-btn delete" title="Delete Entry" onclick="confirmDelete({{ $sheet->id }})">
                              <i class="fas fa-trash-can"></i>
                            </button>
                          </form>
                        </div>
                      </td>
                    </tr>
                    @endif
                  @empty
                  <tr id="emptyRow">
                    <td colspan="5" class="text-center py-4 text-muted">
                      <i class="fas fa-calendar-days mb-2 text-xl d-block" style="font-size: 24px; color: #cbd5e1;"></i>
                      No date sheet entries added yet.
                    </td>
                  </tr>
                  @endforelse
                  <tr id="noResultsRow" style="display: none;">
                    <td colspan="5" class="text-center py-4 text-muted">
                      <i class="fas fa-magnifying-glass mb-2 text-xl d-block" style="font-size: 22px; color: #cbd5e1;"></i>
                      No matching date sheet entries found.
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Table Footer with Records Count and Pagination -->
            <div class="erp-table-footer">
              <div class="erp-table-info" id="tableRecordInfo">
                Showing entries for this examination schedule
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
    function confirmDelete(sheetId) {
      Swal.fire({
        title: 'Delete Date Sheet Entry?',
        text: "This action will remove this subject date from the examination schedule.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Yes, delete it',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById('delete-datesheet-' + sheetId).submit();
        }
      });
    }
  </script>

  <!-- Filter & Export Script -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const subjectInput = document.getElementById('filterSubject');
      const resetBtn = document.getElementById('btnFilterReset');
      const tableRows = document.querySelectorAll('#datesheetTableBody tr[data-subject]');
      const noResultsRow = document.getElementById('noResultsRow');

      function filterTable() {
        const query = subjectInput.value.trim().toLowerCase();
        let visibleCount = 0;

        tableRows.forEach(row => {
          const rowSubject = row.getAttribute('data-subject') || '';
          if (!query || rowSubject.includes(query)) {
            row.style.display = '';
            visibleCount++;
          } else {
            row.style.display = 'none';
          }
        });

        if (noResultsRow) {
          noResultsRow.style.display = (visibleCount === 0 && tableRows.length > 0) ? '' : 'none';
        }
      }

      subjectInput.addEventListener('input', filterTable);
      resetBtn.addEventListener('click', function () {
        subjectInput.value = '';
        filterTable();
      });

      // Export functionality
      const copyBtn = document.getElementById('copyButton');
      const csvBtn = document.getElementById('csvButton');
      const excelBtn = document.getElementById('excelButton');
      const pdfBtn = document.getElementById('pdfButton');

      if (copyBtn && window.ClipboardJS) {
        new ClipboardJS(copyBtn, {
          text: function () {
            return document.getElementById('datesheetTable').innerText;
          }
        }).on('success', function () {
          Swal.fire({
            toast: true, position: 'top-end', icon: 'success',
            title: 'Date sheet copied', showConfirmButton: false, timer: 2000
          });
        });
      }

      if (csvBtn) {
        csvBtn.addEventListener('click', function () {
          let csv = [];
          let rows = document.querySelectorAll('#datesheetTable tr:not(#noResultsRow)');
          rows.forEach(row => {
            if (row.style.display !== 'none') {
              let cols = row.querySelectorAll('th, td');
              let rowData = [];
              for (let i = 0; i < cols.length - 1; i++) {
                rowData.push('"' + cols[i].innerText.replace(/"/g, '""').trim() + '"');
              }
              csv.push(rowData.join(','));
            }
          });
          let blob = new Blob([csv.join('\n')], { type: 'text/csv;charset=utf-8;' });
          let link = document.createElement('a');
          link.href = URL.createObjectURL(blob);
          link.download = 'datesheet.csv';
          link.click();
        });
      }

      if (excelBtn && window.XLSX) {
        excelBtn.addEventListener('click', function () {
          let table = document.getElementById('datesheetTable');
          let wb = XLSX.utils.table_to_book(table, { sheet: 'DateSheet' });
          XLSX.writeFile(wb, 'datesheet.xlsx');
        });
      }

      if (pdfBtn && window.jspdf) {
        pdfBtn.addEventListener('click', function () {
          const { jsPDF } = window.jspdf;
          let doc = new jsPDF('p', 'pt', 'a4');
          doc.text("School ERP - Examination Date Sheet", 40, 30);
          if (doc.autoTable) {
            doc.autoTable({
              html: '#datesheetTable',
              startY: 45,
              columns: [0, 1, 2, 3],
              theme: 'striped',
              headStyles: { fillColor: [79, 70, 229] }
            });
            doc.save('datesheet.pdf');
          }
        });
      }
    });
  </script>
</body>
</html>
