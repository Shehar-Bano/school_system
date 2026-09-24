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
                  <i class="fas fa-file-pen text-primary"></i>
                  Examinations
                </h3>
                <p class="erp-table-subtitle">Manage examination terms, evaluation sessions, and examination fee schedules</p>
              </div>

              <!-- Top Action: Add New Exam Button -->
              <div>
                <a href="{{ route('exam') }}" class="btn btn-sm btn-primary">
                  <i class="fas fa-plus mr-1"></i> Add New Exam
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
              <div class="erp-filter-group">
                <div class="erp-input-icon-wrapper">
                  <i class="fas fa-search"></i>
                  <input type="text" id="filterExamName" placeholder="Search exam..." autocomplete="off">
                </div>

                <button type="button" id="btnFilterSearch" class="erp-btn-filter-action erp-btn-filter-primary">
                  <i class="fas fa-filter"></i> Search
                </button>

                <button type="button" id="btnFilterReset" class="erp-btn-filter-action erp-btn-filter-reset">
                  <i class="fas fa-rotate-left"></i> Reset
                </button>
              </div>
            </div>

            <!-- Table Responsive Container -->
            <div class="table-responsive">
              <table class="erp-table" id="examsTable">
                <thead>
                  <tr>
                    <th style="width: 50px;" class="text-center">#</th>
                    <th style="width: 30%;">Exam Name</th>
                    <th style="width: 20%;" class="text-center">Exam Fee</th>
                    <th style="width: 35%;">Description / Note</th>
                    <th style="width: 100px;" class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody id="examsTableBody">
                  @php
                    $count = 0;
                  @endphp
                  @forelse ($exams as $exam)
                  <tr data-name="{{ strtolower($exam->name) }}">
                    <td class="text-center font-weight-medium text-muted">{{ ++$count }}</td>
                    <td class="font-weight-semibold text-dark">
                      <span class="badge badge-soft-primary mr-1" style="font-size: 11px;">
                        <i class="fas fa-award text-xs mr-1"></i> {{ $exam->name }}
                      </span>
                    </td>
                    <td class="text-center font-weight-semibold text-dark">
                      @if($exam->exam_fee == 0)
                        <span class="badge badge-soft-success">Free</span>
                      @else
                        Rs. {{ number_format($exam->exam_fee) }}
                      @endif
                    </td>
                    <td class="text-muted text-xs">
                      {{ $exam->note ?? '—' }}
                    </td>
                    <td class="text-center">
                      <div class="erp-action-btn-group">
                        <!-- Edit Button -->
                        <a href="{{ route('exam-edit', ['id' => $exam->id]) }}" class="erp-action-btn edit" title="Edit Exam">
                          <i class="fas fa-pen-to-square"></i>
                        </a>

                        <!-- Delete Button -->
                        <form id="delete-exam-{{ $exam->id }}" action="{{ route('exam_delete', ['id' => $exam->id]) }}" method="POST" style="display:inline;">
                          @csrf
                          @method('DELETE')
                          <button type="button" class="erp-action-btn delete" title="Delete Exam" onclick="confirmDelete({{ $exam->id }})">
                            <i class="fas fa-trash-can"></i>
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                  @empty
                  <tr id="emptyRow">
                    <td colspan="5" class="text-center py-4 text-muted">
                      <i class="fas fa-file-pen mb-2 text-xl d-block" style="font-size: 24px; color: #cbd5e1;"></i>
                      No exams configured yet. Click <strong>"Add New Exam"</strong> to schedule one.
                    </td>
                  </tr>
                  @endforelse
                  <tr id="noResultsRow" style="display: none;">
                    <td colspan="5" class="text-center py-4 text-muted">
                      <i class="fas fa-magnifying-glass mb-2 text-xl d-block" style="font-size: 22px; color: #cbd5e1;"></i>
                      No matching exams found.
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Table Footer with Records Count and Pagination -->
            <div class="erp-table-footer">
              <div class="erp-table-info" id="tableRecordInfo">
                Showing 1 to {{ count($exams) }} of {{ count($exams) }} exams
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
    function confirmDelete(examId) {
      Swal.fire({
        title: 'Delete Exam?',
        text: "This action will permanently delete this examination record.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Yes, delete it',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById('delete-exam-' + examId).submit();
        }
      });
    }
  </script>

  <!-- Filter & Export Script -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const nameInput = document.getElementById('filterExamName');
      const searchBtn = document.getElementById('btnFilterSearch');
      const resetBtn = document.getElementById('btnFilterReset');
      const tableRows = document.querySelectorAll('#examsTableBody tr[data-name]');
      const noResultsRow = document.getElementById('noResultsRow');
      const infoText = document.getElementById('tableRecordInfo');
      const totalCount = tableRows.length;

      function filterTable() {
        const query = nameInput.value.trim().toLowerCase();
        let visibleCount = 0;

        tableRows.forEach(row => {
          const rowName = row.getAttribute('data-name') || '';
          if (!query || rowName.includes(query)) {
            row.style.display = '';
            visibleCount++;
          } else {
            row.style.display = 'none';
          }
        });

        if (noResultsRow) {
          noResultsRow.style.display = (visibleCount === 0 && totalCount > 0) ? '' : 'none';
        }

        if (infoText) {
          infoText.innerText = (visibleCount === totalCount)
            ? `Showing 1 to ${totalCount} of ${totalCount} exams`
            : `Showing ${visibleCount} of ${totalCount} filtered exams`;
        }
      }

      nameInput.addEventListener('input', filterTable);
      searchBtn.addEventListener('click', filterTable);

      resetBtn.addEventListener('click', function () {
        nameInput.value = '';
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
            return document.getElementById('examsTable').innerText;
          }
        }).on('success', function () {
          Swal.fire({
            toast: true, position: 'top-end', icon: 'success',
            title: 'Exams table copied', showConfirmButton: false, timer: 2000
          });
        });
      }

      if (csvBtn) {
        csvBtn.addEventListener('click', function () {
          let csv = [];
          let rows = document.querySelectorAll('#examsTable tr:not(#noResultsRow)');
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
          link.download = 'exams_list.csv';
          link.click();
        });
      }

      if (excelBtn && window.XLSX) {
        excelBtn.addEventListener('click', function () {
          let table = document.getElementById('examsTable');
          let wb = XLSX.utils.table_to_book(table, { sheet: 'Exams' });
          XLSX.writeFile(wb, 'exams_list.xlsx');
        });
      }

      if (pdfBtn && window.jspdf) {
        pdfBtn.addEventListener('click', function () {
          const { jsPDF } = window.jspdf;
          let doc = new jsPDF('p', 'pt', 'a4');
          doc.text("School ERP - Exams List", 40, 30);
          if (doc.autoTable) {
            doc.autoTable({
              html: '#examsTable',
              startY: 45,
              columns: [0, 1, 2, 3],
              theme: 'striped',
              headStyles: { fillColor: [79, 70, 229] }
            });
            doc.save('exams_list.pdf');
          }
        });
      }
    });
  </script>
</body>
</html>
