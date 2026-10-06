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
                  <i class="fas fa-layer-group text-primary"></i>
                  Class Sections
                </h3>
                <p class="erp-table-subtitle">Manage class sections, student seating capacity, class teachers, and fee receipts</p>
              </div>

              <!-- Top Action: Add New Section Button -->
              <div>
                @if(auth()->check() && (auth()->user()->hasRole('superadmin') || auth()->user()->can('academic.section.create')))
                <a href="{{ route('section') }}" class="btn btn-sm btn-primary">
                  <i class="fas fa-plus mr-1"></i> Add New Section
                </a>
                @endif
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
                  <input type="text" id="filterSectionName" placeholder="Search section..." autocomplete="off">
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
              <table class="erp-table" id="sectionsTable">
                <thead>
                  <tr>
                    <th style="width: 50px;" class="text-center">#</th>
                    <th style="width: 20%;">Section Name</th>
                    <th style="width: 14%;" class="text-center">Capacity</th>
                    <th style="width: 18%;">Class</th>
                    <th style="width: 20%;">Class Teacher</th>
                    <th style="width: 15%;">Note</th>
                    <th style="width: 120px;" class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody id="sectionsTableBody">
                  @php
                    $count = 0;
                  @endphp
                  @forelse ($sections as $section)
                  <tr data-name="{{ strtolower($section->name) }}" data-class="{{ strtolower($section->classe->name ?? '') }}">
                    <td class="text-center font-weight-medium text-muted">{{ ++$count }}</td>
                    <td class="font-weight-semibold text-dark">
                      {{ $section->name }}
                    </td>
                    <td class="text-center">
                      <span class="badge badge-soft-info" style="font-size: 11px;">
                        <i class="fas fa-users text-xs mr-1"></i> {{ $section->capacity }} Seats
                      </span>
                    </td>
                    <td>
                      <span class="badge badge-soft-primary">
                        {{ $section->classe ? $section->classe->name : 'Unassigned' }}
                      </span>
                    </td>
                    <td class="text-dark font-weight-medium">
                      @if($section->employee)
                        <i class="fas fa-chalkboard-user text-muted mr-1"></i> {{ $section->employee->name }}
                      @else
                        <span class="text-muted text-xs">No teacher assigned</span>
                      @endif
                    </td>
                    <td class="text-muted text-xs">
                      {{ $section->note ?? '—' }}
                    </td>
                    <td class="text-center">
                      <div class="erp-action-btn-group">
                        @if(auth()->check() && (auth()->user()->hasRole('superadmin') || auth()->user()->can('academic.section.fee')))
                        <!-- Fee Receipt Button -->
                        <a href="{{ route('section-fee', ['id' => $section->id]) }}" class="erp-action-btn view" title="Print Section Fee Slip">
                          <i class="fas fa-receipt"></i>
                        </a>
                        @endif

                        @if(auth()->check() && (auth()->user()->hasRole('superadmin') || auth()->user()->can('academic.section.edit')))
                        <!-- Edit Button -->
                        <a href="{{ route('section-edit', ['id' => $section->id]) }}" class="erp-action-btn edit" title="Edit Section">
                          <i class="fas fa-pen-to-square"></i>
                        </a>
                        @endif

                        @if(auth()->check() && (auth()->user()->hasRole('superadmin') || auth()->user()->can('academic.section.delete')))
                        <!-- Delete Button -->
                        <form id="delete-section-{{ $section->id }}" action="{{ route('section_delete', ['id' => $section->id]) }}" method="POST" style="display:inline;">
                          @csrf
                          @method('DELETE')
                          <button type="button" class="erp-action-btn delete" title="Delete Section" onclick="confirmDelete({{ $section->id }})">
                            <i class="fas fa-trash-can"></i>
                          </button>
                        </form>
                        @endif
                      </div>
                    </td>
                  </tr>
                  @empty
                  <tr id="emptyRow">
                    <td colspan="7" class="text-center py-4 text-muted">
                      <i class="fas fa-layer-group mb-2 text-xl d-block" style="font-size: 24px; color: #cbd5e1;"></i>
                      No sections found. Click <strong>"Add New Section"</strong> to add one.
                    </td>
                  </tr>
                  @endforelse
                  <tr id="noResultsRow" style="display: none;">
                    <td colspan="7" class="text-center py-4 text-muted">
                      <i class="fas fa-magnifying-glass mb-2 text-xl d-block" style="font-size: 22px; color: #cbd5e1;"></i>
                      No matching sections found.
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Table Footer with Records Count and Pagination -->
            <div class="erp-table-footer">
              <div class="erp-table-info" id="tableRecordInfo">
                Showing 1 to {{ count($sections) }} of {{ count($sections) }} sections
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
    function confirmDelete(sectionId) {
      Swal.fire({
        title: 'Delete Section?',
        text: "This action will permanently delete the section.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Yes, delete it',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById('delete-section-' + sectionId).submit();
        }
      });
    }
  </script>

  <!-- Filter & Export Script -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const nameInput = document.getElementById('filterSectionName');
      const searchBtn = document.getElementById('btnFilterSearch');
      const resetBtn = document.getElementById('btnFilterReset');
      const tableRows = document.querySelectorAll('#sectionsTableBody tr[data-name]');
      const noResultsRow = document.getElementById('noResultsRow');
      const infoText = document.getElementById('tableRecordInfo');
      const totalCount = tableRows.length;

      function filterTable() {
        const query = nameInput.value.trim().toLowerCase();
        let visibleCount = 0;

        tableRows.forEach(row => {
          const rowName = row.getAttribute('data-name') || '';
          const rowClass = row.getAttribute('data-class') || '';
          if (!query || rowName.includes(query) || rowClass.includes(query)) {
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
            ? `Showing 1 to ${totalCount} of ${totalCount} sections`
            : `Showing ${visibleCount} of ${totalCount} filtered sections`;
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
            return document.getElementById('sectionsTable').innerText;
          }
        }).on('success', function () {
          Swal.fire({
            toast: true, position: 'top-end', icon: 'success',
            title: 'Sections table copied', showConfirmButton: false, timer: 2000
          });
        });
      }

      if (csvBtn) {
        csvBtn.addEventListener('click', function () {
          let csv = [];
          let rows = document.querySelectorAll('#sectionsTable tr:not(#noResultsRow)');
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
          link.download = 'sections_list.csv';
          link.click();
        });
      }

      if (excelBtn && window.XLSX) {
        excelBtn.addEventListener('click', function () {
          let table = document.getElementById('sectionsTable');
          let wb = XLSX.utils.table_to_book(table, { sheet: 'Sections' });
          XLSX.writeFile(wb, 'sections_list.xlsx');
        });
      }

      if (pdfBtn && window.jspdf) {
        pdfBtn.addEventListener('click', function () {
          const { jsPDF } = window.jspdf;
          let doc = new jsPDF('p', 'pt', 'a4');
          doc.text("School ERP - Sections List", 40, 30);
          if (doc.autoTable) {
            doc.autoTable({
              html: '#sectionsTable',
              startY: 45,
              columns: [0, 1, 2, 3, 4, 5],
              theme: 'striped',
              headStyles: { fillColor: [79, 70, 229] }
            });
            doc.save('sections_list.pdf');
          }
        });
      }
    });
  </script>
</body>
</html>
