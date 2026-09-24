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
                  <i class="fas fa-file-lines text-primary"></i>
                  Academic Syllabus
                </h3>
                <p class="erp-table-subtitle">Manage class syllabus documents, course outlines, terms, and curriculum attachments</p>
              </div>

              <!-- Top Action: Add New Syllabus Button -->
              <div>
                <a href="{{ route('add_syllabus') }}" class="btn btn-sm btn-primary">
                  <i class="fas fa-plus mr-1"></i> Add New Syllabus
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
                  <input type="text" id="filterSyllabusTitle" placeholder="Search title..." autocomplete="off">
                </div>

                <input type="date" id="filterDate" class="form-control" style="height: 34px; width: 140px; font-size: 12px;">

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
              <table class="erp-table" id="syllabusTable">
                <thead>
                  <tr>
                    <th style="width: 50px;" class="text-center">#</th>
                    <th style="width: 15%;" class="text-center">Publish Date</th>
                    <th style="width: 25%;">Title / Topic</th>
                    <th style="width: 40%;">Description & Objectives</th>
                    <th style="width: 120px;" class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody id="syllabusTableBody">
                  @php
                    $count = 0;
                  @endphp
                  @forelse ($syllabuses as $syllabus)
                  <tr data-title="{{ strtolower($syllabus->title) }}" data-date="{{ $syllabus->date }}">
                    <td class="text-center font-weight-medium text-muted">{{ ++$count }}</td>
                    <td class="text-center">
                      <span class="badge badge-soft-primary font-weight-medium">
                        <i class="fas fa-calendar-day mr-1 text-xs"></i> {{ $syllabus->date }}
                      </span>
                    </td>
                    <td class="font-weight-semibold text-dark">
                      {{ $syllabus->title }}
                    </td>
                    <td class="text-secondary text-xs">
                      {{ \Illuminate\Support\Str::limit($syllabus->description, 100) }}
                    </td>
                    <td class="text-center">
                      <div class="erp-action-btn-group">
                        <!-- View Detail Button -->
                        <a href="{{ route('syllabus_detail', ['id' => $syllabus->id]) }}" class="erp-action-btn view" title="View Syllabus Details">
                          <i class="fas fa-eye"></i>
                        </a>

                        <!-- Edit Button -->
                        <a href="{{ route('edit_syllabus', ['id' => $syllabus->id]) }}" class="erp-action-btn edit" title="Edit Syllabus">
                          <i class="fas fa-pen-to-square"></i>
                        </a>

                        <!-- Delete Button -->
                        <form id="delete-syllabus-{{ $syllabus->id }}" action="{{ route('syllabus_delete', ['id' => $syllabus->id]) }}" method="POST" style="display:inline;">
                          @csrf
                          @method('DELETE')
                          <button type="button" class="erp-action-btn delete" title="Delete Syllabus" onclick="confirmDelete({{ $syllabus->id }})">
                            <i class="fas fa-trash-can"></i>
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                  @empty
                  <tr id="emptyRow">
                    <td colspan="5" class="text-center py-4 text-muted">
                      <i class="fas fa-file-lines mb-2 text-xl d-block" style="font-size: 24px; color: #cbd5e1;"></i>
                      No syllabus published yet. Click <strong>"Add New Syllabus"</strong> to upload course material.
                    </td>
                  </tr>
                  @endforelse
                  <tr id="noResultsRow" style="display: none;">
                    <td colspan="5" class="text-center py-4 text-muted">
                      <i class="fas fa-magnifying-glass mb-2 text-xl d-block" style="font-size: 22px; color: #cbd5e1;"></i>
                      No matching syllabus records found.
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Table Footer with Records Count and Pagination -->
            <div class="erp-table-footer">
              <div class="erp-table-info" id="tableRecordInfo">
                Showing 1 to {{ count($syllabuses) }} of {{ count($syllabuses) }} records
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
    function confirmDelete(syllabusId) {
      Swal.fire({
        title: 'Delete Syllabus?',
        text: "This action will permanently delete this syllabus outline.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Yes, delete it',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById('delete-syllabus-' + syllabusId).submit();
        }
      });
    }
  </script>

  <!-- Filter & Export Script -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const titleInput = document.getElementById('filterSyllabusTitle');
      const dateInput = document.getElementById('filterDate');
      const searchBtn = document.getElementById('btnFilterSearch');
      const resetBtn = document.getElementById('btnFilterReset');
      const tableRows = document.querySelectorAll('#syllabusTableBody tr[data-title]');
      const noResultsRow = document.getElementById('noResultsRow');
      const infoText = document.getElementById('tableRecordInfo');
      const totalCount = tableRows.length;

      function filterTable() {
        const queryTitle = titleInput.value.trim().toLowerCase();
        const queryDate = dateInput.value;
        let visibleCount = 0;

        tableRows.forEach(row => {
          const rowTitle = row.getAttribute('data-title') || '';
          const rowDate = row.getAttribute('data-date') || '';

          const matchTitle = !queryTitle || rowTitle.includes(queryTitle);
          const matchDate = !queryDate || rowDate === queryDate;

          if (matchTitle && matchDate) {
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
            ? `Showing 1 to ${totalCount} of ${totalCount} records`
            : `Showing ${visibleCount} of ${totalCount} filtered records`;
        }
      }

      titleInput.addEventListener('input', filterTable);
      dateInput.addEventListener('change', filterTable);
      searchBtn.addEventListener('click', filterTable);

      resetBtn.addEventListener('click', function () {
        titleInput.value = '';
        dateInput.value = '';
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
            return document.getElementById('syllabusTable').innerText;
          }
        }).on('success', function () {
          Swal.fire({
            toast: true, position: 'top-end', icon: 'success',
            title: 'Syllabus table copied', showConfirmButton: false, timer: 2000
          });
        });
      }

      if (csvBtn) {
        csvBtn.addEventListener('click', function () {
          let csv = [];
          let rows = document.querySelectorAll('#syllabusTable tr:not(#noResultsRow)');
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
          link.download = 'syllabus_list.csv';
          link.click();
        });
      }

      if (excelBtn && window.XLSX) {
        excelBtn.addEventListener('click', function () {
          let table = document.getElementById('syllabusTable');
          let wb = XLSX.utils.table_to_book(table, { sheet: 'Syllabus' });
          XLSX.writeFile(wb, 'syllabus_list.xlsx');
        });
      }

      if (pdfBtn && window.jspdf) {
        pdfBtn.addEventListener('click', function () {
          const { jsPDF } = window.jspdf;
          let doc = new jsPDF('p', 'pt', 'a4');
          doc.text("School ERP - Syllabus List", 40, 30);
          if (doc.autoTable) {
            doc.autoTable({
              html: '#syllabusTable',
              startY: 45,
              columns: [0, 1, 2, 3],
              theme: 'striped',
              headStyles: { fillColor: [79, 70, 229] }
            });
            doc.save('syllabus_list.pdf');
          }
        });
      }
    });
  </script>
</body>
</html>
