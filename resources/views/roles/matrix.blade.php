<!DOCTYPE html>
<html lang="en">

@include('view-file/head')

<style>
  /* Custom Permissions Matrix Styling */
  .erp-matrix-container {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
    overflow: hidden;
  }
  .matrix-scroll-wrapper {
    position: relative;
    max-height: calc(100vh - 270px);
    min-height: 480px;
    overflow-y: auto;
    overflow-x: auto;
  }
  .matrix-table {
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
    margin-bottom: 0;
  }
  .matrix-table thead th {
    position: sticky;
    top: 0;
    background: #f8fafc;
    z-index: 25;
    border-top: none;
    border-bottom: 2px solid #cbd5e1 !important;
    padding: 12px 16px;
    font-size: 13px;
    font-weight: 700;
    color: #1e293b;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.03);
    white-space: nowrap;
  }
  .matrix-table td {
    padding: 11px 16px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
    background-color: #ffffff;
    font-size: 13px;
  }
  .matrix-table tbody tr:hover td {
    background-color: #f8fafc;
  }
  .matrix-guard-header td {
    background: #e2e8f0 !important;
    color: #334155;
    font-weight: 800;
    font-size: 12px;
    letter-spacing: 0.6px;
    text-transform: uppercase;
    padding: 8px 16px;
    border-top: 1px solid #cbd5e1;
    border-bottom: 1px solid #cbd5e1;
  }
  .matrix-group-header td {
    background: #f1f5f9 !important;
    color: #1e293b;
    font-weight: 700;
    font-size: 13.5px;
    padding: 10px 16px;
    border-top: 1px solid #e2e8f0;
    border-bottom: 1px solid #e2e8f0;
  }
  .matrix-status-allowed {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: #ecfdf5;
    color: #10b981;
    font-size: 14px;
  }
  .matrix-status-denied {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: #f8fafc;
    color: #cbd5e1;
    font-size: 13px;
  }
  .matrix-tab-btn {
    border: 1px solid #e2e8f0;
    background: #ffffff;
    color: #64748b;
    font-size: 13px;
    font-weight: 600;
    padding: 6px 14px;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.15s ease;
  }
  .matrix-tab-btn:hover {
    background: #f8fafc;
    color: #334155;
  }
  .matrix-tab-btn.active {
    background: #4f46e5;
    color: #ffffff;
    border-color: #4f46e5;
    box-shadow: 0 2px 6px rgba(79, 70, 229, 0.25);
  }
  .matrix-perm-code {
    font-family: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
    font-size: 11.5px;
    background: #f1f5f9;
    color: #475569;
    padding: 2px 6px;
    border-radius: 4px;
  }
</style>

<body>
  <div class="container-scroller">
    @include('view-file/nav')
    <div class="container-fluid page-body-wrapper">
      @include('view-file.side-bar')
      
      <!-- Main Panel -->
      <div class="main-panel">
        <div class="content-wrapper">

          <!-- ERP Matrix Container -->
          <div class="erp-matrix-container">
            
            <!-- Table Header Block -->
            <div class="erp-table-header-block" style="padding: 18px 22px; border-bottom: 1px solid #e2e8f0;">
              <div class="erp-table-title-area">
                <h3 class="erp-table-title" style="margin-bottom: 4px;">
                  <i class="fas fa-table-cells text-primary mr-1"></i>
                  Security Permissions Matrix
                </h3>
                <p class="erp-table-subtitle" style="margin-bottom: 0;">Cross-role comparison matrix showing all granular permissions across system guards and modules</p>
              </div>

              <!-- Top Actions: Back to Roles List -->
              <div class="d-flex align-items-center gap-2">
                <a href="{{ route('roles.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius: 8px; font-weight: 500;">
                  <i class="fas fa-arrow-left mr-1"></i> Back to Roles List
                </a>
                @if(auth()->check() && (auth()->user()->hasRole('superadmin') || auth()->user()->can('roles.create')))
                <a href="{{ route('roles.create') }}" class="btn btn-sm btn-primary ml-2" style="border-radius: 8px; font-weight: 500;">
                  <i class="fas fa-plus mr-1"></i> Create Role
                </a>
                @endif
              </div>
            </div>

            <!-- Single-Line Compact Toolbar (Guard Tabs & Filters) -->
            <div class="erp-toolbar" style="padding: 12px 20px; background: #ffffff; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
              
              <!-- Left: Guard Selector Filter Tabs -->
              <div class="d-flex align-items-center gap-2 flex-wrap">
                <button type="button" class="matrix-tab-btn active" data-guard="all">
                  <i class="fas fa-layer-group mr-1"></i> All Portals
                </button>
                <button type="button" class="matrix-tab-btn" data-guard="web">
                  <i class="fas fa-desktop mr-1"></i> Web (Admin)
                </button>
                <button type="button" class="matrix-tab-btn" data-guard="employee">
                  <i class="fas fa-chalkboard-user mr-1"></i> Employee
                </button>
                <button type="button" class="matrix-tab-btn" data-guard="student">
                  <i class="fas fa-user-graduate mr-1"></i> Student
                </button>
              </div>

              <!-- Right: Search & Print Controls -->
              <div class="d-flex align-items-center gap-2">
                <div class="erp-input-icon-wrapper" style="position: relative; width: 260px;">
                  <i class="fas fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 13px;"></i>
                  <input type="text" id="matrixSearchInput" placeholder="Search action or code..." autocomplete="off" style="width: 100%; height: 36px; padding-left: 34px; padding-right: 12px; font-size: 13px; border: 1px solid #cbd5e1; border-radius: 8px;">
                </div>

                <button type="button" id="btnMatrixReset" class="btn btn-sm btn-outline-secondary" title="Reset Search" style="border-radius: 8px; height: 36px; padding: 0 12px;">
                  <i class="fas fa-rotate-left"></i>
                </button>

                <button type="button" onclick="window.print()" class="btn btn-sm btn-outline-secondary" title="Print Matrix" style="border-radius: 8px; height: 36px; padding: 0 12px;">
                  <i class="fas fa-print"></i>
                </button>
              </div>
            </div>

            <!-- Table Responsive Container with Fixed Header -->
            <div class="matrix-scroll-wrapper">
              <table class="matrix-table" id="matrixTable">
                <thead>
                  <tr>
                    <th style="min-width: 280px; width: 32%; text-align: left;">Action / Permission</th>
                    <th style="min-width: 200px; width: 22%; text-align: left;">Permission Code</th>
                    @foreach($roles as $role)
                    <th class="text-center role-column" data-guard="{{ $role->guard_name }}" style="min-width: 130px;">
                      <div class="d-flex flex-column align-items-center">
                        <span class="font-weight-bold text-dark" style="font-size: 13.5px;">{{ ucfirst($role->name) }}</span>
                        <span class="badge badge-soft-{{ $role->guard_name === 'web' ? 'primary' : ($role->guard_name === 'employee' ? 'purple' : 'success') }} mt-1" style="font-size: 10px; padding: 2px 7px;">
                          {{ $role->guard_name }}
                        </span>
                      </div>
                    </th>
                    @endforeach
                  </tr>
                </thead>
                <tbody id="matrixTableBody">
                  @foreach($permissionsByGroup as $guard => $groups)
                    <!-- Guard Header Row -->
                    <tr class="matrix-guard-header guard-section-{{ $guard }}" data-guard="{{ $guard }}">
                      <td colspan="{{ 2 + $roles->count() }}">
                        <i class="fas fa-shield mr-1"></i> {{ strtoupper($guard) }} GUARD PERMISSIONS
                      </td>
                    </tr>

                    @foreach($groups as $groupName => $permissions)
                      <!-- Group Header Row -->
                      <tr class="matrix-group-header guard-section-{{ $guard }}" data-guard="{{ $guard }}" data-group="{{ strtolower($groupName) }}">
                        <td colspan="{{ 2 + $roles->count() }}">
                          @if(str_contains($groupName, 'Academic'))
                            <i class="fas fa-graduation-cap text-primary mr-1"></i>
                          @elseif(str_contains($groupName, 'User'))
                            <i class="fas fa-users-gear text-info mr-1"></i>
                          @elseif(str_contains($groupName, 'TimeTable'))
                            <i class="fas fa-calendar-days text-warning mr-1"></i>
                          @elseif(str_contains($groupName, 'Attendance'))
                            <i class="fas fa-user-check text-success mr-1"></i>
                          @elseif(str_contains($groupName, 'Exam'))
                            <i class="fas fa-file-pen text-danger mr-1"></i>
                          @elseif(str_contains($groupName, 'Payment') || str_contains($groupName, 'Finance'))
                            <i class="fas fa-sack-dollar text-success mr-1"></i>
                          @elseif(str_contains($groupName, 'Inventory'))
                            <i class="fas fa-boxes-stacked text-secondary mr-1"></i>
                          @elseif(str_contains($groupName, 'Report'))
                            <i class="fas fa-chart-pie mr-1" style="color: #8b5cf6;"></i>
                          @elseif(str_contains($groupName, 'Role'))
                            <i class="fas fa-shield-halved text-primary mr-1"></i>
                          @else
                            <i class="fas fa-layer-group text-primary mr-1"></i>
                          @endif
                          {{ $groupName }}
                          <span class="badge badge-secondary ml-1" style="font-size: 10.5px; font-weight: 500;">{{ count($permissions) }} actions</span>
                        </td>
                      </tr>

                      @foreach($permissions as $permission)
                      @php
                        $cleanName = ucwords(str_replace(['.', '_', '-'], ' ', $permission->name));
                      @endphp
                      <tr class="matrix-data-row guard-section-{{ $guard }}" data-guard="{{ $guard }}" data-search="{{ strtolower($cleanName . ' ' . $permission->name . ' ' . $groupName) }}">
                        <td class="pl-4 font-weight-semibold text-dark">
                          {{ $cleanName }}
                        </td>
                        <td>
                          <span class="matrix-perm-code">{{ $permission->name }}</span>
                        </td>
                        @foreach($roles as $role)
                        <td class="text-center role-cell" data-guard="{{ $role->guard_name }}">
                          @if($role->guard_name === $permission->guard_name)
                            @if($role->name === 'superadmin' || $role->hasPermissionTo($permission->name, $permission->guard_name))
                              <span class="matrix-status-allowed" title="Allowed for {{ ucfirst($role->name) }}">
                                <i class="fas fa-check"></i>
                              </span>
                            @else
                              <span class="matrix-status-denied" title="Denied for {{ ucfirst($role->name) }}">
                                <i class="fas fa-times"></i>
                              </span>
                            @endif
                          @else
                            <span class="text-muted text-xs font-weight-light">—</span>
                          @endif
                        </td>
                        @endforeach
                      </tr>
                      @endforeach
                    @endforeach
                  @endforeach

                  <tr id="matrixNoResultsRow" style="display: none;">
                    <td colspan="{{ 2 + $roles->count() }}" class="text-center py-5 text-muted">
                      <i class="fas fa-magnifying-glass mb-2 text-xl d-block" style="font-size: 24px; color: #cbd5e1;"></i>
                      No matching actions found in the permissions matrix.
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Matrix Footer Note -->
            <div class="p-3 bg-light border-top d-flex align-items-center justify-content-between text-xs text-muted" style="font-size: 12px;">
              <div class="d-flex align-items-center gap-3">
                <span><i class="fas fa-circle-check text-success mr-1"></i> Allowed Action</span>
                <span><i class="fas fa-circle-xmark text-muted mr-1"></i> Denied Action</span>
                <span><span class="font-weight-bold">—</span> Inapplicable Guard</span>
              </div>
              <div id="matrixRecordCount">
                Showing {{ count($permissionsByGroup) }} guard categories
              </div>
            </div>

          </div>

        </div>
      </div>
    </div>
  </div>

  @include('view-file/script')

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const searchInput = document.getElementById('matrixSearchInput');
      const btnReset = document.getElementById('btnMatrixReset');
      const tabButtons = document.querySelectorAll('.matrix-tab-btn');
      const dataRows = document.querySelectorAll('.matrix-data-row');
      const groupRows = document.querySelectorAll('.matrix-group-header');
      const guardRows = document.querySelectorAll('.matrix-guard-header');
      const noResultsRow = document.getElementById('matrixNoResultsRow');
      let activeGuard = 'all';

      // Filter Matrix Rows by Guard Tab and Search Query
      function filterMatrix() {
        const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
        let totalVisibleDataRows = 0;

        // Track visibility of groups and guards
        const visibleGroups = new Set();
        const visibleGuards = new Set();

        dataRows.forEach(row => {
          const rowGuard = row.getAttribute('data-guard') || '';
          const searchText = row.getAttribute('data-search') || '';

          const matchesGuard = (activeGuard === 'all' || rowGuard === activeGuard);
          const matchesQuery = (!query || searchText.includes(query));

          if (matchesGuard && matchesQuery) {
            row.style.display = '';
            totalVisibleDataRows++;

            // Mark its parent group and guard as visible
            const parentGuard = row.getAttribute('data-guard');
            if (parentGuard) visibleGuards.add(parentGuard);
          } else {
            row.style.display = 'none';
          }
        });

        // Show/hide group headers based on whether any child row is visible
        groupRows.forEach(groupRow => {
          const groupGuard = groupRow.getAttribute('data-guard');
          const matchesGuard = (activeGuard === 'all' || groupGuard === activeGuard);

          if (!matchesGuard) {
            groupRow.style.display = 'none';
            return;
          }

          // Check if any following sibling data row in this group is visible
          let next = groupRow.nextElementSibling;
          let hasVisibleChild = false;
          while (next && next.classList.contains('matrix-data-row')) {
            if (next.style.display !== 'none') {
              hasVisibleChild = true;
              break;
            }
            next = next.nextElementSibling;
          }

          groupRow.style.display = hasVisibleChild ? '' : 'none';
        });

        // Show/hide guard headers
        guardRows.forEach(guardRow => {
          const guard = guardRow.getAttribute('data-guard');
          const isVisible = visibleGuards.has(guard);
          guardRow.style.display = (isVisible && (activeGuard === 'all' || guard === activeGuard)) ? '' : 'none';
        });

        // Show/hide no results row
        if (noResultsRow) {
          noResultsRow.style.display = totalVisibleDataRows === 0 ? '' : 'none';
        }

        // Update count indicator
        const recordCount = document.getElementById('matrixRecordCount');
        if (recordCount) {
          recordCount.textContent = `Showing ${totalVisibleDataRows} action permissions`;
        }
      }

      // Tab Button Click
      tabButtons.forEach(btn => {
        btn.addEventListener('click', function() {
          tabButtons.forEach(b => b.classList.remove('active'));
          this.classList.add('active');
          activeGuard = this.getAttribute('data-guard');
          filterMatrix();
        });
      });

      // Search Input
      if (searchInput) {
        searchInput.addEventListener('input', filterMatrix);
      }

      // Reset Button
      if (btnReset) {
        btnReset.addEventListener('click', function() {
          if (searchInput) searchInput.value = '';
          activeGuard = 'all';
          tabButtons.forEach(b => b.classList.remove('active'));
          if (tabButtons[0]) tabButtons[0].classList.add('active');
          filterMatrix();
        });
      }

      // Initialize
      filterMatrix();
    });
  </script>
</body>
</html>
