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
                  <i class="fas fa-tasks text-primary"></i>
                  Student Assignments
                </h3>
                <p class="erp-table-subtitle">Manage class homework, project submissions, assignment guidelines, and due dates</p>
              </div>

              <!-- Top Action: Add New Assignment Button -->
              <div>
                @if(auth()->check() && (auth()->user()->hasRole('superadmin') || auth()->user()->can('academic.assignment.create')))
                <a href="{{ route('add_assignment') }}" class="btn btn-sm btn-primary">
                  <i class="fas fa-plus mr-1"></i> Add New Assignment
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
                  <input type="text" id="filterAssignmentTitle" placeholder="Search assignment..." autocomplete="off">
                </div>

                <input type="date" id="filterDeadline" class="form-control" style="height: 34px; width: 140px; font-size: 12px;">

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
              <table class="erp-table" id="assignmentsTable">
                <thead>
                  <tr>
                    <th style="width: 45px;" class="text-center">#</th>
                    <th style="width: 14%;" class="text-center">Due Deadline</th>
                    <th style="width: 22%;">Assignment Title</th>
                    <th style="width: 18%;">Class & Subject</th>
                    <th style="width: 18%;" class="text-center">Submission Tracking</th>
                    <th style="width: 140px;" class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody id="assignmentsTableBody">
                  @php
                    $count = 0;
                  @endphp
                  @forelse ($assignments as $assignment)
                  @php
                    $stats = $assignment->getTrackingStats();
                  @endphp
                  <tr data-title="{{ strtolower($assignment->title) }}" data-deadline="{{ $assignment->deadline }}">
                    <td class="text-center font-weight-medium text-muted">{{ ++$count }}</td>
                    <td class="text-center">
                      @if($stats['is_deadline_passed'])
                        <span class="badge badge-soft-danger font-weight-medium" title="Deadline has passed">
                          <i class="fas fa-circle-xmark mr-1 text-xs"></i> {{ $assignment->deadline }}
                        </span>
                      @else
                        <span class="badge badge-soft-warning font-weight-medium" title="Deadline Active">
                          <i class="fas fa-clock mr-1 text-xs"></i> {{ $assignment->deadline }}
                        </span>
                      @endif
                    </td>
                    <td>
                      <div class="font-weight-semibold text-dark">{{ $assignment->title }}</div>
                      <div class="text-muted text-xs">{{ \Illuminate\Support\Str::limit($assignment->description, 60) }}</div>
                    </td>
                    <td>
                      <div>
                        <span class="badge badge-soft-primary mr-1">{{ $assignment->class->name ?? 'Class' }}</span>
                        <span class="badge badge-soft-info">{{ $assignment->section->name ?? 'Section' }}</span>
                      </div>
                      <div class="text-muted small mt-1">
                        <i class="fas fa-book mr-1 text-xs text-primary"></i> {{ $assignment->subject->subject_name ?? 'Subject' }}
                      </div>
                    </td>
                    <td class="text-center">
                      <a href="{{ route('assignment_tracking', ['id' => $assignment->id]) }}" class="text-decoration-none" title="Click to view full submission tracking">
                        <div class="d-flex align-items-center justify-content-center gap-1 mb-1">
                          <span class="badge badge-soft-{{ $stats['percentage'] == 100 ? 'success' : ($stats['percentage'] > 0 ? 'primary' : 'secondary') }} font-weight-bold" style="font-size: 11px;">
                            {{ $stats['submitted_count'] }} / {{ $stats['total_students'] }} Submitted ({{ $stats['percentage'] }}%)
                          </span>
                        </div>
                        <div class="progress mx-auto" style="height: 4px; width: 110px;">
                          <div class="progress-bar {{ $stats['percentage'] == 100 ? 'bg-success' : 'bg-primary' }}" role="progressbar" style="width: {{ $stats['percentage'] }}%"></div>
                        </div>
                      </a>
                    </td>
                    <td class="text-center">
                      <div class="erp-action-btn-group">
                        <!-- Tracking Dashboard Button -->
                        <a href="{{ route('assignment_tracking', ['id' => $assignment->id]) }}" class="erp-action-btn view" style="background: #eef2ff; color: #4f46e5;" title="Assignment Tracking Dashboard">
                          <i class="fas fa-chart-line"></i>
                        </a>

                        @if(auth()->check() && (auth()->user()->hasRole('superadmin') || auth()->user()->can('academic.assignment.detail') || auth()->user()->can('academic.assignment.view')))
                        <!-- View Detail Button -->
                        <a href="{{ route('assignmet_detail', ['id' => $assignment->id]) }}" class="erp-action-btn view" title="View Assignment Details">
                          <i class="fas fa-eye"></i>
                        </a>
                        @endif

                        @if(auth()->check() && (auth()->user()->hasRole('superadmin') || auth()->user()->can('academic.assignment.edit')))
                        <!-- Edit Button -->
                        <a href="{{ route('edit_assinment', ['id' => $assignment->id]) }}" class="erp-action-btn edit" title="Edit Assignment">
                          <i class="fas fa-pen-to-square"></i>
                        </a>
                        @endif

                        @if(auth()->check() && (auth()->user()->hasRole('superadmin') || auth()->user()->can('academic.assignment.delete')))
                        <!-- Delete Button -->
                        <form id="delete-assignment-{{ $assignment->id }}" action="{{ route('assignment_delete', ['id' => $assignment->id]) }}" method="POST" style="display:inline;">
                          @csrf
                          @method('DELETE')
                          <button type="button" class="erp-action-btn delete" title="Delete Assignment" onclick="confirmDelete({{ $assignment->id }})">
                            <i class="fas fa-trash-can"></i>
                          </button>
                        </form>
                        @endif
                      </div>
                    </td>
                  </tr>
                  @empty
                  <tr id="emptyRow">
                    <td colspan="6" class="text-center py-4 text-muted">
                      <i class="fas fa-tasks mb-2 text-xl d-block" style="font-size: 24px; color: #cbd5e1;"></i>
                      No assignments assigned yet. Click <strong>"Add New Assignment"</strong> to create homework.
                    </td>
                  </tr>
                  @endforelse
                  <tr id="noResultsRow" style="display: none;">
                    <td colspan="6" class="text-center py-4 text-muted">
                      <i class="fas fa-magnifying-glass mb-2 text-xl d-block" style="font-size: 22px; color: #cbd5e1;"></i>
                      No matching assignment records found.
                    </td>
                  </tr>
                      No matching assignment records found.
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Table Footer with Records Count and Pagination -->
            <div class="erp-table-footer">
              <div class="erp-table-info" id="tableRecordInfo">
                Showing 1 to {{ count($assignments) }} of {{ count($assignments) }} assignments
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
    function confirmDelete(assignmentId) {
      Swal.fire({
        title: 'Delete Assignment?',
        text: "This action will permanently delete this student assignment.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Yes, delete it',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById('delete-assignment-' + assignmentId).submit();
        }
      });
    }
  </script>

  <!-- Filter & Export Script -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const titleInput = document.getElementById('filterAssignmentTitle');
      const deadlineInput = document.getElementById('filterDeadline');
      const searchBtn = document.getElementById('btnFilterSearch');
      const resetBtn = document.getElementById('btnFilterReset');
      const tableRows = document.querySelectorAll('#assignmentsTableBody tr[data-title]');
      const noResultsRow = document.getElementById('noResultsRow');
      const infoText = document.getElementById('tableRecordInfo');
      const totalCount = tableRows.length;

      function filterTable() {
        const queryTitle = titleInput.value.trim().toLowerCase();
        const queryDeadline = deadlineInput.value;
        let visibleCount = 0;

        tableRows.forEach(row => {
          const rowTitle = row.getAttribute('data-title') || '';
          const rowDeadline = row.getAttribute('data-deadline') || '';

          const matchTitle = !queryTitle || rowTitle.includes(queryTitle);
          const matchDeadline = !queryDeadline || rowDeadline === queryDeadline;

          if (matchTitle && matchDeadline) {
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
            ? `Showing 1 to ${totalCount} of ${totalCount} assignments`
            : `Showing ${visibleCount} of ${totalCount} filtered assignments`;
        }
      }

      titleInput.addEventListener('input', filterTable);
      deadlineInput.addEventListener('change', filterTable);
      searchBtn.addEventListener('click', filterTable);

      resetBtn.addEventListener('click', function () {
        titleInput.value = '';
        deadlineInput.value = '';
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
            return document.getElementById('assignmentsTable').innerText;
          }
        }).on('success', function () {
          Swal.fire({
            toast: true, position: 'top-end', icon: 'success',
            title: 'Assignments table copied', showConfirmButton: false, timer: 2000
          });
        });
      }

      if (csvBtn) {
        csvBtn.addEventListener('click', function () {
          let csv = [];
          let rows = document.querySelectorAll('#assignmentsTable tr:not(#noResultsRow)');
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
          link.download = 'assignments_list.csv';
          link.click();
        });
      }

      if (excelBtn && window.XLSX) {
        excelBtn.addEventListener('click', function () {
          let table = document.getElementById('assignmentsTable');
          let wb = XLSX.utils.table_to_book(table, { sheet: 'Assignments' });
          XLSX.writeFile(wb, 'assignments_list.xlsx');
        });
      }

      if (pdfBtn && window.jspdf) {
        pdfBtn.addEventListener('click', function () {
          const { jsPDF } = window.jspdf;
          let doc = new jsPDF('p', 'pt', 'a4');
          doc.text("School ERP - Assignments List", 40, 30);
          if (doc.autoTable) {
            doc.autoTable({
              html: '#assignmentsTable',
              startY: 45,
              columns: [0, 1, 2, 3],
              theme: 'striped',
              headStyles: { fillColor: [79, 70, 229] }
            });
            doc.save('assignments_list.pdf');
          }
        });
      }
    });
  </script>
</body>
</html>
