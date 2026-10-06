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

          @if(session('message'))
          <div class="alert alert-success alert-dismissible fade show erp-alert" role="alert" style="border-left: 4px solid #10b981; background: #ecfdf5; color: #065f46; border-radius: 8px; margin-bottom: 20px;">
            <i class="fas fa-circle-check mr-2"></i> {{ session('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: #065f46;">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          @endif

          @if(session('error'))
          <div class="alert alert-danger alert-dismissible fade show erp-alert" role="alert" style="border-left: 4px solid #ef4444; background: #fef2f2; color: #991b1b; border-radius: 8px; margin-bottom: 20px;">
            <i class="fas fa-circle-exclamation mr-2"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: #991b1b;">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          @endif

          <!-- Stats Overview Row -->
          <div class="row mb-4">
            <div class="col-md-3 mb-3 mb-md-0">
              <div class="card shadow-sm border-0" style="border-radius: 12px; background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%); color: white;">
                <div class="card-body p-3 d-flex align-items-center justify-content-between">
                  <div>
                    <span class="text-xs text-uppercase font-weight-bold" style="opacity: 0.85; letter-spacing: 0.5px;">Total Roles</span>
                    <h3 class="mb-0 font-weight-bold mt-1">{{ $roles->count() }}</h3>
                  </div>
                  <div style="background: rgba(255,255,255,0.2); width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                    <i class="fas fa-shield-halved"></i>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-3 mb-3 mb-md-0">
              <div class="card shadow-sm border-0" style="border-radius: 12px; background: linear-gradient(135deg, #0ea5e9 0%, #0369a1 100%); color: white;">
                <div class="card-body p-3 d-flex align-items-center justify-content-between">
                  <div>
                    <span class="text-xs text-uppercase font-weight-bold" style="opacity: 0.85; letter-spacing: 0.5px;">Admin / Web Actions</span>
                    <h3 class="mb-0 font-weight-bold mt-1">{{ $webPermissionsCount }}</h3>
                  </div>
                  <div style="background: rgba(255,255,255,0.2); width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                    <i class="fas fa-user-gear"></i>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-3 mb-3 mb-md-0">
              <div class="card shadow-sm border-0" style="border-radius: 12px; background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%); color: white;">
                <div class="card-body p-3 d-flex align-items-center justify-content-between">
                  <div>
                    <span class="text-xs text-uppercase font-weight-bold" style="opacity: 0.85; letter-spacing: 0.5px;">Employee Actions</span>
                    <h3 class="mb-0 font-weight-bold mt-1">{{ $employeePermissionsCount }}</h3>
                  </div>
                  <div style="background: rgba(255,255,255,0.2); width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                    <i class="fas fa-chalkboard-user"></i>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-3">
              <div class="card shadow-sm border-0" style="border-radius: 12px; background: linear-gradient(135deg, #10b981 0%, #047857 100%); color: white;">
                <div class="card-body p-3 d-flex align-items-center justify-content-between">
                  <div>
                    <span class="text-xs text-uppercase font-weight-bold" style="opacity: 0.85; letter-spacing: 0.5px;">Student Actions</span>
                    <h3 class="mb-0 font-weight-bold mt-1">{{ $studentPermissionsCount }}</h3>
                  </div>
                  <div style="background: rgba(255,255,255,0.2); width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                    <i class="fas fa-user-graduate"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <!-- ERP Card Table Container -->
          <div class="erp-card-table">
            
            <!-- Table Header Block -->
            <div class="erp-table-header-block">
              <div class="erp-table-title-area">
                <h3 class="erp-table-title">
                  <i class="fas fa-user-shield text-primary"></i>
                  Roles & Permissions Management
                </h3>
                <p class="erp-table-subtitle">Configure granular access control, section-wise permissions, and assign security roles to administrators, staff, and students</p>
              </div>

              <!-- Top Actions: Add Role & Matrix View -->
              <div class="d-flex gap-2">
                <a href="{{ route('permissions.index') }}" class="btn btn-sm btn-outline-secondary mr-2" style="border-radius: 8px; font-weight: 500;">
                  <i class="fas fa-table-cells mr-1"></i> Permissions Matrix
                </a>
                @if(auth()->check() && (auth()->user()->hasRole('superadmin') || auth()->user()->can('roles.create')))
                <a href="{{ route('roles.create') }}" class="btn btn-sm btn-primary" style="border-radius: 8px; font-weight: 500;">
                  <i class="fas fa-plus mr-1"></i> Create New Role
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
                  <input type="text" id="filterRoleName" placeholder="Search role name..." autocomplete="off">
                </div>

                <select id="filterGuardType" class="erp-filter-select">
                  <option value="">All Portals (Guards)</option>
                  <option value="web">Web (Admin)</option>
                  <option value="employee">Employee</option>
                  <option value="student">Student</option>
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
              <table class="erp-table" id="rolesTable">
                <thead>
                  <tr>
                    <th style="width: 50px;" class="text-center">#</th>
                    <th style="width: 22%;">Role Name</th>
                    <th style="width: 14%;" class="text-center">Target Portal (Guard)</th>
                    <th style="width: 26%;">Permissions Assigned</th>
                    <th style="width: 14%;" class="text-center">Assigned Users</th>
                    <th style="width: 100px;" class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody id="rolesTableBody">
                  @php
                    $count = 0;
                  @endphp
                  @forelse ($roles as $role)
                  <tr data-name="{{ strtolower($role->name) }}" data-guard="{{ strtolower($role->guard_name) }}">
                    <td class="text-center font-weight-medium text-muted">{{ ++$count }}</td>
                    <td>
                      <div class="d-flex align-items-center">
                        <div class="avatar-icon mr-2" style="width: 34px; height: 34px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 600; 
                          @if($role->name === 'superadmin') background: #fef3c7; color: #b45309; 
                          @elseif($role->guard_name === 'employee') background: #ede9fe; color: #6d28d9; 
                          @elseif($role->guard_name === 'student') background: #d1fae5; color: #047857; 
                          @else background: #e0e7ff; color: #4338ca; @endif">
                          @if($role->name === 'superadmin')
                            <i class="fas fa-crown"></i>
                          @elseif($role->guard_name === 'employee')
                            <i class="fas fa-chalkboard-user"></i>
                          @elseif($role->guard_name === 'student')
                            <i class="fas fa-user-graduate"></i>
                          @else
                            <i class="fas fa-shield"></i>
                          @endif
                        </div>
                        <div>
                          <span class="font-weight-bold text-dark" style="font-size: 14px;">{{ ucfirst($role->name) }}</span>
                          @if($role->name === 'superadmin')
                            <span class="badge badge-warning ml-1" style="font-size: 10px; padding: 2px 6px;">System Master</span>
                          @endif
                        </div>
                      </div>
                    </td>
                    <td class="text-center">
                      @if($role->guard_name === 'web')
                        <span class="badge badge-soft-primary" style="font-weight: 600; padding: 4px 10px; border-radius: 6px;">
                          <i class="fas fa-desktop mr-1"></i> Web (Admin)
                        </span>
                      @elseif($role->guard_name === 'employee')
                        <span class="badge badge-soft-purple" style="font-weight: 600; padding: 4px 10px; border-radius: 6px;">
                          <i class="fas fa-briefcase mr-1"></i> Employee
                        </span>
                      @elseif($role->guard_name === 'student')
                        <span class="badge badge-soft-success" style="font-weight: 600; padding: 4px 10px; border-radius: 6px;">
                          <i class="fas fa-graduation-cap mr-1"></i> Student
                        </span>
                      @else
                        <span class="badge badge-secondary">{{ $role->guard_name }}</span>
                      @endif
                    </td>
                    <td>
                      @if($role->name === 'superadmin')
                        <span class="badge badge-soft-success" style="font-size: 11px;">
                          <i class="fas fa-infinity mr-1"></i> Full Access (All {{ $totalPermissions }} Actions)
                        </span>
                      @else
                        @php
                          $permCount = $role->permissions->count();
                        @endphp
                        @if($permCount > 0)
                          <div class="d-flex align-items-center gap-1 flex-wrap">
                            <span class="badge badge-soft-primary" style="font-weight: 600; font-size: 11px;">
                              <i class="fas fa-key mr-1"></i> {{ $permCount }} Actions Allowed
                            </span>
                            @foreach($role->permissions->take(3) as $perm)
                              <span class="badge badge-light border text-muted" style="font-size: 10px;">{{ $perm->name }}</span>
                            @endforeach
                            @if($permCount > 3)
                              <span class="text-muted text-xs" style="font-size: 11px;">+{{ $permCount - 3 }} more</span>
                            @endif
                          </div>
                        @else
                          <span class="text-muted text-xs"><i class="fas fa-lock mr-1"></i> No permissions assigned</span>
                        @endif
                      @endif
                    </td>
                    <td class="text-center">
                      <span class="badge badge-soft-info font-weight-bold" style="font-size: 12px; padding: 4px 10px;">
                        <i class="fas fa-users mr-1"></i> {{ $role->assigned_count }}
                      </span>
                    </td>
                    <td class="text-center">
                      <div class="erp-action-btn-group">
                        @if(auth()->check() && (auth()->user()->hasRole('superadmin') || auth()->user()->can('roles.edit')))
                        <!-- Edit Role & Permissions Button -->
                        <a href="{{ route('roles.edit', ['role' => $role->id]) }}" class="erp-action-btn edit" title="Edit Role & Permissions">
                          <i class="fas fa-pen-to-square"></i>
                        </a>
                        @endif

                        @if($role->name !== 'superadmin' && auth()->check() && (auth()->user()->hasRole('superadmin') || auth()->user()->can('roles.delete')))
                        <!-- Delete Role Button -->
                        <form id="delete-role-{{ $role->id }}" action="{{ route('roles.destroy', ['role' => $role->id]) }}" method="POST" style="display:inline;">
                          @csrf
                          @method('DELETE')
                          <button type="button" class="erp-action-btn delete" title="Delete Role" onclick="confirmDeleteRole({{ $role->id }}, '{{ ucfirst($role->name) }}')">
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
                      <i class="fas fa-user-shield mb-2 text-xl d-block" style="font-size: 24px; color: #cbd5e1;"></i>
                      No roles configured yet. Click <strong>"Create New Role"</strong> to add one.
                    </td>
                  </tr>
                  @endforelse
                  <tr id="noResultsRow" style="display: none;">
                    <td colspan="6" class="text-center py-4 text-muted">
                      <i class="fas fa-magnifying-glass mb-2 text-xl d-block" style="font-size: 22px; color: #cbd5e1;"></i>
                      No matching roles found.
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Table Footer -->
            <div class="erp-table-footer">
              <div class="erp-pagination-info" id="tableRecordCount">
                Showing {{ $roles->count() }} configured security roles
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

  @include('view-file/script')

  <script>
    // Delete Confirmation with SweetAlert2
    function confirmDeleteRole(id, roleName) {
      Swal.fire({
        title: 'Delete Role?',
        text: "Are you sure you want to delete role '" + roleName + "'? Users assigned to this role may lose access permissions.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, delete role',
        cancelButtonText: 'Cancel',
        reverseButtons: true,
        customClass: {
          popup: 'erp-swal-popup',
          confirmButton: 'erp-swal-confirm',
          cancelButton: 'erp-swal-cancel'
        }
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById('delete-role-' + id).submit();
        }
      });
    }

    // Live Search & Filter Logic
    document.addEventListener('DOMContentLoaded', function() {
      const searchInput = document.getElementById('filterRoleName');
      const guardSelect = document.getElementById('filterGuardType');
      const btnSearch = document.getElementById('btnFilterSearch');
      const btnReset = document.getElementById('btnFilterReset');
      const tableRows = document.querySelectorAll('#rolesTableBody tr:not(#emptyRow):not(#noResultsRow)');
      const noResultsRow = document.getElementById('noResultsRow');
      const recordCount = document.getElementById('tableRecordCount');

      function filterTable() {
        const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const selectedGuard = guardSelect ? guardSelect.value.toLowerCase() : '';
        let visibleCount = 0;

        tableRows.forEach(row => {
          const roleName = row.getAttribute('data-name') || '';
          const guard = row.getAttribute('data-guard') || '';

          const matchesSearch = !searchTerm || roleName.includes(searchTerm);
          const matchesGuard = !selectedGuard || guard === selectedGuard;

          if (matchesSearch && matchesGuard) {
            row.style.display = '';
            visibleCount++;
          } else {
            row.style.display = 'none';
          }
        });

        if (noResultsRow) {
          noResultsRow.style.display = (visibleCount === 0 && tableRows.length > 0) ? '' : 'none';
        }

        if (recordCount) {
          recordCount.textContent = `Showing ${visibleCount} of ${tableRows.length} configured security roles`;
        }
      }

      if (searchInput) searchInput.addEventListener('input', filterTable);
      if (guardSelect) guardSelect.addEventListener('change', filterTable);
      if (btnSearch) btnSearch.addEventListener('click', filterTable);

      if (btnReset) {
        btnReset.addEventListener('click', function() {
          if (searchInput) searchInput.value = '';
          if (guardSelect) guardSelect.value = '';
          filterTable();
        });
      }

      // Export Buttons (CSV / Copy / Print)
      const copyBtn = document.getElementById('copyButton');
      const csvBtn = document.getElementById('csvButton');
      const excelBtn = document.getElementById('excelButton');
      const pdfBtn = document.getElementById('pdfButton');

      if (copyBtn) {
        copyBtn.addEventListener('click', function() {
          let text = '';
          tableRows.forEach(row => {
            if (row.style.display !== 'none') {
              text += Array.from(row.querySelectorAll('td')).map(td => td.innerText.trim().replace(/\n/g, ' ')).join('\t') + '\n';
            }
          });
          navigator.clipboard.writeText(text).then(() => {
            Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Copied table data to clipboard', showConfirmButton: false, timer: 2000 });
          });
        });
      }

      if (csvBtn || excelBtn) {
        const triggerExport = function() {
          let csv = [];
          const headers = ['#', 'Role Name', 'Portal (Guard)', 'Permissions', 'Assigned Users'];
          csv.push(headers.join(','));

          tableRows.forEach(row => {
            if (row.style.display !== 'none') {
              const cols = row.querySelectorAll('td');
              if (cols.length >= 5) {
                const rowData = [
                  `"${cols[0].innerText.trim()}"`,
                  `"${cols[1].innerText.trim().replace(/"/g, '""')}"`,
                  `"${cols[2].innerText.trim().replace(/"/g, '""')}"`,
                  `"${cols[3].innerText.trim().replace(/"/g, '""')}"`,
                  `"${cols[4].innerText.trim()}"`
                ];
                csv.push(rowData.join(','));
              }
            }
          });

          const blob = new Blob([csv.join('\n')], { type: 'text/csv;charset=utf-8;' });
          const url = URL.createObjectURL(blob);
          const link = document.createElement('a');
          link.setAttribute('href', url);
          link.setAttribute('download', 'roles_permissions_export.csv');
          document.body.appendChild(link);
          link.click();
          document.body.removeChild(link);
        };
        if (csvBtn) csvBtn.addEventListener('click', triggerExport);
        if (excelBtn) excelBtn.addEventListener('click', triggerExport);
      }

      if (pdfBtn) {
        pdfBtn.addEventListener('click', function() {
          window.print();
        });
      }
    });
  </script>
</body>
</html>
