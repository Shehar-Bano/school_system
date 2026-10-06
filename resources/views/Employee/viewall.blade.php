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
                  <i class="fas fa-users text-primary"></i>
                  Employees & Staff Directory
                </h3>
                <p class="erp-table-subtitle">Manage faculty profiles, employee designations, contact details, and employment statuses</p>
              </div>

              <!-- Top Action: Add New Employee Button -->
              <div>
                <a href="{{ route('employees_create') }}" class="btn btn-sm btn-primary">
                  <i class="fas fa-user-plus mr-1"></i> Add New Employee
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
                  <input type="text" id="filterEmployeeName" placeholder="Search employee..." autocomplete="off">
                </div>

                <div class="erp-input-icon-wrapper" style="width: 150px;">
                  <i class="fas fa-id-badge"></i>
                  <input type="text" id="filterDesignation" placeholder="Filter role/title..." autocomplete="off">
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
              <table class="erp-table" id="employeesTable">
                <thead>
                  <tr>
                    <th style="width: 50px;" class="text-center">#</th>
                    <th style="width: 25%;">Employee Profile</th>
                    <th style="width: 20%;">Email Address</th>
                    <th style="width: 16%;">Designation / Role</th>
                    <th style="width: 13%;" class="text-center">Joining Date</th>
                    <th style="width: 12%;" class="text-center">Status</th>
                    <th style="width: 110px;" class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody id="employeesTableBody">
                  @php
                    $count = 0;
                  @endphp
                  @forelse ($employees as $employee)
                  <tr data-name="{{ strtolower($employee->name) }}" data-role="{{ strtolower($employee->designation->name ?? '') }}">
                    <td class="text-center font-weight-medium text-muted">{{ ++$count }}</td>
                    <td>
                      <div class="d-flex align-items-center gap-2">
                        @if($employee->image && $employee->image !== 'default.png')
                          <img src="{{ asset('storage/' . $employee->image) }}" class="rounded-circle" style="width: 28px; height: 28px; object-fit: cover;" alt="{{ $employee->name }}">
                        @else
                          <div class="erp-user-avatar" style="width: 28px; height: 28px; font-size: 11px;">
                            {{ strtoupper(substr($employee->name, 0, 2)) }}
                          </div>
                        @endif
                        <span class="font-weight-semibold text-dark">{{ $employee->name }}</span>
                      </div>
                    </td>
                    <td class="text-secondary text-xs">
                      {{ $employee->email }}
                    </td>
                    <td>
                      <span class="badge badge-soft-primary font-weight-medium">
                        {{ $employee->designation->name ?? 'Staff' }}
                      </span>
                      @if($employee->roles && $employee->roles->count() > 0)
                        <span class="badge badge-soft-purple font-weight-medium ml-1" style="font-size: 10px;" title="Assigned Security Role">
                          <i class="fas fa-shield mr-1"></i> {{ ucfirst($employee->roles->first()->name) }}
                        </span>
                      @endif
                    </td>
                    <td class="text-center text-xs text-muted">
                      {{ $employee->joining_date ?? '—' }}
                    </td>
                    <td class="text-center">
                      <span class="badge badge-soft-success">
                        <span class="dot" style="width: 5px; height: 5px; border-radius: 50%; background-color: #10b981; display: inline-block;"></span>
                        {{ ucfirst($employee->status ?? 'Active') }}
                      </span>
                    </td>
                    <td class="text-center">
                      <div class="erp-action-btn-group">
                        <!-- View Profile Button -->
                        <a href="{{ route('employees_show', ['id' => $employee->id]) }}" class="erp-action-btn view" title="View Profile">
                          <i class="fas fa-eye"></i>
                        </a>

                        <!-- Edit Button -->
                        <a href="{{ route('employees_edit', ['id' => $employee->id]) }}" class="erp-action-btn edit" title="Edit Employee">
                          <i class="fas fa-pen-to-square"></i>
                        </a>

                        <!-- Delete Button -->
                        <form id="delete-employee-{{ $employee->id }}" action="{{ route('employees_delete', ['id' => $employee->id]) }}" method="POST" style="display:inline;">
                          @csrf
                          @method('DELETE')
                          <button type="button" class="erp-action-btn delete" title="Delete Employee" onclick="confirmDelete({{ $employee->id }})">
                            <i class="fas fa-trash-can"></i>
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                  @empty
                  <tr id="emptyRow">
                    <td colspan="7" class="text-center py-4 text-muted">
                      <i class="fas fa-users mb-2 text-xl d-block" style="font-size: 24px; color: #cbd5e1;"></i>
                      No employees added yet. Click <strong>"Add New Employee"</strong> to register staff.
                    </td>
                  </tr>
                  @endforelse
                  <tr id="noResultsRow" style="display: none;">
                    <td colspan="7" class="text-center py-4 text-muted">
                      <i class="fas fa-magnifying-glass mb-2 text-xl d-block" style="font-size: 22px; color: #cbd5e1;"></i>
                      No matching employee records found.
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Table Footer with Records Count and Pagination -->
            <div class="erp-table-footer">
              <div class="erp-table-info" id="tableRecordInfo">
                Showing 1 to {{ count($employees) }} of {{ count($employees) }} employees
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
    function confirmDelete(employeeId) {
      Swal.fire({
        title: 'Delete Employee?',
        text: "This action will permanently delete the employee profile.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Yes, delete it',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById('delete-employee-' + employeeId).submit();
        }
      });
    }
  </script>

  <!-- Filter & Export Script -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const nameInput = document.getElementById('filterEmployeeName');
      const roleInput = document.getElementById('filterDesignation');
      const searchBtn = document.getElementById('btnFilterSearch');
      const resetBtn = document.getElementById('btnFilterReset');
      const tableRows = document.querySelectorAll('#employeesTableBody tr[data-name]');
      const noResultsRow = document.getElementById('noResultsRow');
      const infoText = document.getElementById('tableRecordInfo');
      const totalCount = tableRows.length;

      function filterTable() {
        const queryName = nameInput.value.trim().toLowerCase();
        const queryRole = roleInput.value.trim().toLowerCase();
        let visibleCount = 0;

        tableRows.forEach(row => {
          const rowName = row.getAttribute('data-name') || '';
          const rowRole = row.getAttribute('data-role') || '';

          const matchName = !queryName || rowName.includes(queryName);
          const matchRole = !queryRole || rowRole.includes(queryRole);

          if (matchName && matchRole) {
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
            ? `Showing 1 to ${totalCount} of ${totalCount} employees`
            : `Showing ${visibleCount} of ${totalCount} filtered employees`;
        }
      }

      nameInput.addEventListener('input', filterTable);
      roleInput.addEventListener('input', filterTable);
      searchBtn.addEventListener('click', filterTable);

      resetBtn.addEventListener('click', function () {
        nameInput.value = '';
        roleInput.value = '';
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
            return document.getElementById('employeesTable').innerText;
          }
        }).on('success', function () {
          Swal.fire({
            toast: true, position: 'top-end', icon: 'success',
            title: 'Employees table copied', showConfirmButton: false, timer: 2000
          });
        });
      }

      if (csvBtn) {
        csvBtn.addEventListener('click', function () {
          let csv = [];
          let rows = document.querySelectorAll('#employeesTable tr:not(#noResultsRow)');
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
          link.download = 'employees_list.csv';
          link.click();
        });
      }

      if (excelBtn && window.XLSX) {
        excelBtn.addEventListener('click', function () {
          let table = document.getElementById('employeesTable');
          let wb = XLSX.utils.table_to_book(table, { sheet: 'Employees' });
          XLSX.writeFile(wb, 'employees_list.xlsx');
        });
      }

      if (pdfBtn && window.jspdf) {
        pdfBtn.addEventListener('click', function () {
          const { jsPDF } = window.jspdf;
          let doc = new jsPDF('p', 'pt', 'a4');
          doc.text("School ERP - Employees Directory", 40, 30);
          if (doc.autoTable) {
            doc.autoTable({
              html: '#employeesTable',
              startY: 45,
              columns: [0, 1, 2, 3, 4, 5],
              theme: 'striped',
              headStyles: { fillColor: [79, 70, 229] }
            });
            doc.save('employees_list.pdf');
          }
        });
      }
    });
  </script>
</body>
</html>
