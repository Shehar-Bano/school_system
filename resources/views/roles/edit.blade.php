<!DOCTYPE html>
<html lang="en">

@include('view-file/head')

<style>
  .erp-perm-group-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    margin-bottom: 20px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    transition: all 0.2s ease;
    overflow: hidden;
  }
  .erp-perm-group-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    border-color: #cbd5e1;
  }
  .erp-perm-group-header {
    background: #f8fafc;
    padding: 12px 18px;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  .erp-perm-group-title {
    font-size: 14.5px;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .erp-perm-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 12px;
    padding: 16px;
  }
  .erp-perm-item {
    background: #fdfdfd;
    border: 1px solid #edf2f7;
    border-radius: 8px;
    padding: 10px 14px;
    display: flex;
    align-items: flex-start;
    gap: 10px;
    cursor: pointer;
    transition: all 0.15s ease;
  }
  .erp-perm-item:hover {
    background: #f1f5f9;
    border-color: #cbd5e1;
  }
  .erp-perm-item input[type="checkbox"] {
    margin-top: 3px;
    width: 17px;
    height: 17px;
    cursor: pointer;
    accent-color: #4f46e5;
  }
  .erp-perm-label {
    cursor: pointer;
    user-select: none;
    margin: 0;
    flex-grow: 1;
  }
  .erp-perm-name {
    font-size: 13px;
    font-weight: 600;
    color: #334155;
    display: block;
    line-height: 1.3;
  }
  .erp-perm-code {
    font-size: 11px;
    color: #64748b;
    font-family: monospace;
    display: block;
    margin-top: 2px;
  }
  .erp-perm-item.checked {
    background: #eef2ff;
    border-color: #a5b4fc;
  }
  .erp-perm-item.checked .erp-perm-name {
    color: #3730a3;
  }
  .erp-sticky-topbar {
    position: sticky;
    top: 70px;
    z-index: 99;
    background: white;
    padding: 14px 20px;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    margin-bottom: 24px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
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

          <!-- Page Header -->
          <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1 p-0 bg-transparent">
                  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-primary">Dashboard</a></li>
                  <li class="breadcrumb-item"><a href="{{ route('roles.index') }}" class="text-primary">Roles & Permissions</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Edit Role: {{ ucfirst($role->name) }}</li>
                </ol>
              </nav>
              <h3 class="font-weight-bold text-dark mb-0">
                <i class="fas fa-pen-to-square text-primary mr-2"></i> Edit Role & Action Permissions
              </h3>
              <p class="text-muted text-xs mb-0 mt-1">Configure action permissions and access rights for role <strong>{{ ucfirst($role->name) }}</strong></p>
            </div>
            <div>
              <a href="{{ route('roles.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius: 8px;">
                <i class="fas fa-arrow-left mr-1"></i> Back to Roles
              </a>
            </div>
          </div>

          <form action="{{ route('roles.update', ['role' => $role->id]) }}" method="POST" id="roleEditForm">
            @csrf
            @method('PUT')

            <!-- Role Basic Information Card -->
            <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
              <div class="card-body p-4">
                <h5 class="font-weight-bold text-dark mb-3">
                  <i class="fas fa-id-card-clip text-primary mr-1"></i> Role Details
                </h5>
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="name" class="font-weight-semibold text-dark">Role Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name" name="name" value="{{ old('name', $role->name) }}" required style="border-radius: 8px; height: 44px;" {{ $role->name === 'superadmin' ? 'readonly' : '' }}>
                    @if($role->name === 'superadmin')
                    <small class="text-warning"><i class="fas fa-lock mr-1"></i> The superadmin role name is protected and cannot be modified.</small>
                    @endif
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="col-md-6 mb-3">
                    <label class="font-weight-semibold text-dark">Assigned Portal (Guard)</label>
                    <div>
                      @if($role->guard_name === 'web')
                        <span class="badge badge-soft-primary" style="font-size: 14px; padding: 10px 16px; border-radius: 8px; display: inline-block;">
                          <i class="fas fa-desktop mr-1"></i> Web Guard (Admin & Staff Panel)
                        </span>
                      @elseif($role->guard_name === 'employee')
                        <span class="badge badge-soft-purple" style="font-size: 14px; padding: 10px 16px; border-radius: 8px; display: inline-block;">
                          <i class="fas fa-briefcase mr-1"></i> Employee Guard (Staff & Teacher Portal)
                        </span>
                      @elseif($role->guard_name === 'student')
                        <span class="badge badge-soft-success" style="font-size: 14px; padding: 10px 16px; border-radius: 8px; display: inline-block;">
                          <i class="fas fa-graduation-cap mr-1"></i> Student Guard (Student Portal)
                        </span>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Permissions Sticky Toolbar -->
            <div class="erp-sticky-topbar">
              <div class="d-flex align-items-center gap-2">
                <h5 class="mb-0 font-weight-bold text-dark">
                  <i class="fas fa-list-check text-primary mr-1"></i> Granular Action Permissions
                </h5>
                <span class="badge badge-soft-primary ml-2" id="selectedCountBadge">0 Actions Selected</span>
              </div>

              <div class="d-flex align-items-center gap-2 flex-wrap">
                <!-- Live Search Filter -->
                <div class="input-group" style="width: 250px;">
                  <div class="input-group-prepend">
                    <span class="input-group-text bg-white border-right-0" style="border-radius: 8px 0 0 8px;"><i class="fas fa-search text-muted"></i></span>
                  </div>
                  <input type="text" id="permSearchInput" class="form-control border-left-0" placeholder="Search permissions..." style="border-radius: 0 8px 8px 0; height: 36px; font-size: 13px;">
                </div>

                <button type="button" class="btn btn-sm btn-outline-primary" id="btnSelectAll" style="border-radius: 8px; font-weight: 500;">
                  <i class="fas fa-check-double mr-1"></i> Select All
                </button>

                <button type="button" class="btn btn-sm btn-outline-secondary" id="btnDeselectAll" style="border-radius: 8px; font-weight: 500;">
                  <i class="fas fa-times mr-1"></i> Deselect All
                </button>
              </div>
            </div>

            <!-- Permission Groups Container (Section-wise) -->
            <div id="permissionsContainer">
              @foreach($permissions as $groupName => $groupPermissions)
              @php
                $allInGroupChecked = $groupPermissions->every(fn($p) => in_array($p->name, $rolePermissions));
              @endphp
              <div class="erp-perm-group-card" data-group="{{ strtolower($groupName) }}">
                <div class="erp-perm-group-header">
                  <h6 class="erp-perm-group-title">
                    @if(str_contains($groupName, 'Academic'))
                      <i class="fas fa-graduation-cap text-primary"></i>
                    @elseif(str_contains($groupName, 'User'))
                      <i class="fas fa-users-gear text-info"></i>
                    @elseif(str_contains($groupName, 'TimeTable'))
                      <i class="fas fa-calendar-days text-warning"></i>
                    @elseif(str_contains($groupName, 'Attendance'))
                      <i class="fas fa-user-check text-success"></i>
                    @elseif(str_contains($groupName, 'Exam'))
                      <i class="fas fa-file-pen text-danger"></i>
                    @elseif(str_contains($groupName, 'Payment') || str_contains($groupName, 'Finance'))
                      <i class="fas fa-sack-dollar text-success"></i>
                    @elseif(str_contains($groupName, 'Inventory'))
                      <i class="fas fa-boxes-stacked text-secondary"></i>
                    @elseif(str_contains($groupName, 'Report'))
                      <i class="fas fa-chart-pie text-purple" style="color: #8b5cf6;"></i>
                    @elseif(str_contains($groupName, 'Role'))
                      <i class="fas fa-shield-halved text-primary"></i>
                    @else
                      <i class="fas fa-layer-group text-primary"></i>
                    @endif
                    {{ $groupName }}
                    <span class="badge badge-soft-secondary text-xs" style="font-size: 11px;">{{ count($groupPermissions) }} actions</span>
                  </h6>

                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input group-select-all" id="group_{{ Str::slug($groupName) }}" {{ $allInGroupChecked ? 'checked' : '' }}>
                    <label class="custom-control-label text-xs font-weight-semibold" for="group_{{ Str::slug($groupName) }}" style="cursor: pointer;">
                      Select All in Group
                    </label>
                  </div>
                </div>

                <div class="erp-perm-grid">
                  @foreach($groupPermissions as $permission)
                  @php
                    $cleanName = ucwords(str_replace(['.', '_', '-'], ' ', $permission->name));
                    $isChecked = in_array($permission->name, $rolePermissions);
                  @endphp
                  <label class="erp-perm-item {{ $isChecked ? 'checked' : '' }}" for="perm_{{ $permission->id }}" data-search="{{ strtolower($cleanName . ' ' . $permission->name) }}">
                    <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="perm_{{ $permission->id }}" class="perm-checkbox" {{ $isChecked ? 'checked' : '' }}>
                    <div class="erp-perm-label">
                      <span class="erp-perm-name">{{ $cleanName }}</span>
                      <span class="erp-perm-code">{{ $permission->name }}</span>
                    </div>
                  </label>
                  @endforeach
                </div>
              </div>
              @endforeach
            </div>

            <!-- Form Submit Actions Card -->
            <div class="card shadow-sm border-0 mt-4" style="border-radius: 12px;">
              <div class="card-body p-4 d-flex align-items-center justify-content-between">
                <a href="{{ route('roles.index') }}" class="btn btn-secondary" style="border-radius: 8px; font-weight: 500;">
                  Cancel
                </a>

                <button type="submit" class="btn btn-primary px-4" style="border-radius: 8px; font-weight: 600; font-size: 15px;">
                  <i class="fas fa-floppy-disk mr-1"></i> Update Role Permissions
                </button>
              </div>
            </div>

          </form>

        </div>
      </div>
    </div>
  </div>

  @include('view-file/script')

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const selectedCountBadge = document.getElementById('selectedCountBadge');
      const searchInput = document.getElementById('permSearchInput');
      const container = document.getElementById('permissionsContainer');

      // Update selected count and visually style checked items
      function updateSelectionCount() {
        if (!container) return;

        const checkboxes = container.querySelectorAll('.perm-checkbox');
        let selectedCount = 0;

        checkboxes.forEach(cb => {
          const item = cb.closest('.erp-perm-item');
          if (cb.checked) {
            selectedCount++;
            if (item) item.classList.add('checked');
          } else {
            if (item) item.classList.remove('checked');
          }
        });

        if (selectedCountBadge) {
          selectedCountBadge.textContent = `${selectedCount} Actions Selected`;
        }

        // Update group select all checkboxes state
        document.querySelectorAll('.erp-perm-group-card').forEach(groupCard => {
          const groupCheckboxes = groupCard.querySelectorAll('.perm-checkbox');
          const groupSelectAll = groupCard.querySelector('.group-select-all');
          if (groupSelectAll && groupCheckboxes.length > 0) {
            const allChecked = Array.from(groupCheckboxes).every(cb => cb.checked);
            groupSelectAll.checked = allChecked;
          }
        });
      }

      // Individual checkbox click
      document.addEventListener('change', function(e) {
        if (e.target.classList.contains('perm-checkbox')) {
          updateSelectionCount();
        }
      });

      // Group Select All
      document.querySelectorAll('.group-select-all').forEach(groupCheckbox => {
        groupCheckbox.addEventListener('change', function() {
          const groupCard = this.closest('.erp-perm-group-card');
          if (groupCard) {
            const checkboxes = groupCard.querySelectorAll('.perm-checkbox');
            checkboxes.forEach(cb => {
              cb.checked = this.checked;
            });
            updateSelectionCount();
          }
        });
      });

      // Global Select All Button
      const btnSelectAll = document.getElementById('btnSelectAll');
      if (btnSelectAll) {
        btnSelectAll.addEventListener('click', function() {
          if (container) {
            container.querySelectorAll('.perm-checkbox').forEach(cb => cb.checked = true);
            container.querySelectorAll('.group-select-all').forEach(cb => cb.checked = true);
            updateSelectionCount();
          }
        });
      }

      // Global Deselect All Button
      const btnDeselectAll = document.getElementById('btnDeselectAll');
      if (btnDeselectAll) {
        btnDeselectAll.addEventListener('click', function() {
          if (container) {
            container.querySelectorAll('.perm-checkbox').forEach(cb => cb.checked = false);
            container.querySelectorAll('.group-select-all').forEach(cb => cb.checked = false);
            updateSelectionCount();
          }
        });
      }

      // Live Permission Search Filter
      if (searchInput) {
        searchInput.addEventListener('input', function() {
          const query = this.value.toLowerCase().trim();
          if (!container) return;

          container.querySelectorAll('.erp-perm-group-card').forEach(groupCard => {
            let visibleInGroup = 0;
            groupCard.querySelectorAll('.erp-perm-item').forEach(item => {
              const text = item.getAttribute('data-search') || '';
              if (!query || text.includes(query)) {
                item.style.display = '';
                visibleInGroup++;
              } else {
                item.style.display = 'none';
              }
            });

            groupCard.style.display = visibleInGroup > 0 ? '' : 'none';
          });
        });
      }

      // Initialize counts on load
      updateSelectionCount();
    });
  </script>
</body>
</html>
