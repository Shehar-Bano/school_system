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
                  <i class="fas fa-book-bookmark text-primary"></i>
                  Subjects
                </h3>
                <p class="erp-table-subtitle">Manage curriculum, subject codes, passing criteria and grading weights</p>
              </div>

              <!-- Top Action: Add New Subject Button -->
              <div>
                <a href="{{ route('add_subject') }}" class="btn btn-sm btn-primary">
                  <i class="fas fa-plus mr-1"></i> Add New Subject
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
                  <input type="text" id="filterSubjectName" placeholder="Search subject..." autocomplete="off">
                </div>

                <select id="filterSubjectType" class="erp-filter-select">
                  <option value="">All Types</option>
                  <option value="Theory">Theory</option>
                  <option value="Practical">Practical</option>
                  <option value="Theory & Practical">Theory & Practical</option>
                </select>

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
              <table class="erp-table" id="subjectsTable">
                <thead>
                  <tr>
                    <th style="width: 50px;" class="text-center">#</th>
                    <th style="width: 26%;">Subject Name</th>
                    <th style="width: 15%;" class="text-center">Subject Code</th>
                    <th style="width: 14%;" class="text-center">Passing Marks</th>
                    <th style="width: 14%;" class="text-center">Final Marks</th>
                    <th style="width: 16%;" class="text-center">Type</th>
                    <th style="width: 100px;" class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody id="subjectsTableBody">
                  @php
                      $count = 0;
                  @endphp
                  @forelse ($subjects as $subject)
                  <tr data-name="{{ strtolower($subject->subject_name) }}" data-type="{{ strtolower($subject->type) }}">
                    <td class="text-center font-weight-medium text-muted">{{ ++$count }}</td>
                    <td class="font-weight-semibold text-dark">
                      {{ $subject->subject_name }}
                    </td>
                    <td class="text-center">
                      <span class="erp-code-pill">{{ $subject->sub_code }}</span>
                    </td>
                    <td class="text-center">
                      <span class="font-weight-semibold text-dark">{{ $subject->pass_marks }}</span>
                    </td>
                    <td class="text-center">
                      <span class="font-weight-semibold text-dark">{{ $subject->final_marks }}</span>
                    </td>
                    <td class="text-center">
                      @if(stripos($subject->type, 'Practical') !== false && stripos($subject->type, 'Theory') !== false)
                        <span class="badge badge-soft-warning">
                          <i class="fas fa-layer-group mr-1" style="font-size: 10px;"></i> {{ $subject->type }}
                        </span>
                      @elseif(stripos($subject->type, 'Practical') !== false)
                        <span class="badge badge-soft-purple">
                          <i class="fas fa-flask mr-1" style="font-size: 10px;"></i> {{ $subject->type }}
                        </span>
                      @else
                        <span class="badge badge-soft-primary">
                          <i class="fas fa-book-open mr-1" style="font-size: 10px;"></i> {{ $subject->type }}
                        </span>
                      @endif
                    </td>
                    <td class="text-center">
                      <div class="erp-action-btn-group">
                        <!-- Edit Button -->
                        <a href="{{ route('edit_subject', ['id' => $subject->id]) }}" class="erp-action-btn edit" title="Edit Subject">
                          <i class="fas fa-pen-to-square"></i>
                        </a>

                        <!-- Delete Button -->
                        <form id="delete-form-{{ $subject->id }}" action="{{ route('subject_delete', ['id' => $subject->id]) }}" method="POST" style="display:inline;">
                          @csrf
                          @method('DELETE')
                          <button type="button" class="erp-action-btn delete" title="Delete Subject" onclick="confirmDelete({{ $subject->id }})">
                            <i class="fas fa-trash-can"></i>
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                  @empty
                  <tr id="emptyRow">
                    <td colspan="7" class="text-center py-4 text-muted">
                      <i class="fas fa-folder-open mb-2 text-xl d-block" style="font-size: 24px; color: #cbd5e1;"></i>
                      No subjects found. Click <strong>"Add New Subject"</strong> to create one.
                    </td>
                  </tr>
                  @endforelse
                  <tr id="noResultsRow" style="display: none;">
                    <td colspan="7" class="text-center py-4 text-muted">
                      <i class="fas fa-magnifying-glass mb-2 text-xl d-block" style="font-size: 22px; color: #cbd5e1;"></i>
                      No matching subjects found. Try adjusting your search or filters.
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Table Footer with Records Count and Compact Pagination -->
            <div class="erp-table-footer">
              <div class="erp-table-info" id="tableRecordInfo">
                Showing 1 to {{ count($subjects) }} of {{ count($subjects) }} subjects
              </div>
              <ul class="erp-pagination">
                <li class="page-item disabled">
                  <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                    <i class="fas fa-chevron-left" style="font-size: 10px;"></i>
                  </a>
                </li>
                <li class="page-item active">
                  <a class="page-link" href="#">1</a>
                </li>
                <li class="page-item disabled">
                  <a class="page-link" href="#">
                    <i class="fas fa-chevron-right" style="font-size: 10px;"></i>
                  </a>
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
    function confirmDelete(subjectId) {
      Swal.fire({
        title: 'Delete Subject?',
        text: "This action cannot be undone and will remove the subject.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Yes, delete it',
        cancelButtonText: 'Cancel',
        customClass: {
          popup: 'rounded-xl shadow-lg border'
        }
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById('delete-form-' + subjectId).submit();
        }
      });
    }
  </script>

  <!-- Filter & Search Script -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const nameInput = document.getElementById('filterSubjectName');
      const typeSelect = document.getElementById('filterSubjectType');
      const searchBtn = document.getElementById('btnFilterSearch');
      const resetBtn = document.getElementById('btnFilterReset');
      const tableRows = document.querySelectorAll('#subjectsTableBody tr[data-name]');
      const noResultsRow = document.getElementById('noResultsRow');
      const infoText = document.getElementById('tableRecordInfo');
      const totalCount = tableRows.length;

      function filterTable() {
        const queryName = nameInput.value.trim().toLowerCase();
        const queryType = typeSelect.value.trim().toLowerCase();
        let visibleCount = 0;

        tableRows.forEach(row => {
          const rowName = row.getAttribute('data-name') || '';
          const rowType = row.getAttribute('data-type') || '';

          const matchName = !queryName || rowName.includes(queryName);
          const matchType = !queryType || rowType.includes(queryType);

          if (matchName && matchType) {
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
          if (visibleCount === totalCount) {
            infoText.innerText = `Showing 1 to ${totalCount} of ${totalCount} subjects`;
          } else {
            infoText.innerText = `Showing ${visibleCount} of ${totalCount} filtered subjects`;
          }
        }
      }

      // Instant live filtering on typing / selection
      nameInput.addEventListener('input', filterTable);
      typeSelect.addEventListener('change', filterTable);
      searchBtn.addEventListener('click', filterTable);

      // Reset filters
      resetBtn.addEventListener('click', function () {
        nameInput.value = '';
        typeSelect.value = '';
        filterTable();
      });

      // Export Functionality
      const copyBtn = document.getElementById('copyButton');
      const csvBtn = document.getElementById('csvButton');
      const excelBtn = document.getElementById('excelButton');
      const pdfBtn = document.getElementById('pdfButton');

      // 1. Copy to Clipboard
      if (copyBtn && window.ClipboardJS) {
        new ClipboardJS(copyBtn, {
          text: function () {
            let table = document.getElementById('subjectsTable');
            return table.innerText;
          }
        }).on('success', function (e) {
          Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'Table copied to clipboard',
            showConfirmButton: false,
            timer: 2000
          });
        });
      }

      // 2. Export to CSV
      if (csvBtn) {
        csvBtn.addEventListener('click', function () {
          let csv = [];
          let rows = document.querySelectorAll('#subjectsTable tr:not(#noResultsRow)');
          rows.forEach(row => {
            if (row.style.display !== 'none') {
              let cols = row.querySelectorAll('th, td');
              let rowData = [];
              // Ignore action column (last column)
              for (let i = 0; i < cols.length - 1; i++) {
                let cleanText = cols[i].innerText.replace(/"/g, '""').trim();
                rowData.push('"' + cleanText + '"');
              }
              csv.push(rowData.join(','));
            }
          });

          let blob = new Blob([csv.join('\n')], { type: 'text/csv;charset=utf-8;' });
          let link = document.createElement('a');
          link.href = URL.createObjectURL(blob);
          link.download = 'subjects_list.csv';
          link.click();
        });
      }

      // 3. Export to Excel (XLSX)
      if (excelBtn && window.XLSX) {
        excelBtn.addEventListener('click', function () {
          let table = document.getElementById('subjectsTable');
          let wb = XLSX.utils.table_to_book(table, { sheet: 'Subjects' });
          XLSX.writeFile(wb, 'subjects_list.xlsx');
        });
      }

      // 4. Export to PDF (jsPDF + autoTable)
      if (pdfBtn && window.jspdf) {
        pdfBtn.addEventListener('click', function () {
          const { jsPDF } = window.jspdf;
          let doc = new jsPDF('p', 'pt', 'a4');
          doc.text("School ERP - Subjects List", 40, 30);
          if (doc.autoTable) {
            doc.autoTable({
              html: '#subjectsTable',
              startY: 45,
              columns: [0, 1, 2, 3, 4, 5], // Exclude actions
              theme: 'striped',
              headStyles: { fillColor: [79, 70, 229] }
            });
            doc.save('subjects_list.pdf');
          }
        });
      }
    });
  </script>
</body>
</html>
