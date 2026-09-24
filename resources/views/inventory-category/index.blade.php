<!DOCTYPE html>
<html lang="en">
@php
    use Carbon\Carbon;
@endphp

@include('view-file/head')

<body>
  <div class="container-scroller">
    @include('view-file/nav')
    <div class="container-fluid page-body-wrapper">
      @include('view-file.side-bar')
      
      <!-- Inner-page -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="container-fluid px-3 py-2">
            
            <div class="row g-3">
              <!-- Left Column: Add Category Form -->
              <div class="col-lg-4 mb-3">
                <div class="erp-card-table h-100">
                  <div class="erp-table-header-block">
                    <div>
                      <h4 class="erp-table-title"><i class="fas fa-plus-circle text-primary me-2"></i>Add Category</h4>
                      <p class="erp-table-subtitle">Create a new inventory category</p>
                    </div>
                  </div>
                  
                  <div class="p-3">
                    <form action="{{ route('inventory.category.store') }}" method="POST">
                      @csrf
                      
                      <div class="form-group mb-3">
                        <label for="name" class="form-label font-weight-bold" style="font-size: 12px; color: var(--erp-text-secondary, #64748b);">Category Name <span class="text-danger">*</span></label>
                        <div class="erp-input-icon-wrapper">
                          <i class="fas fa-boxes-stacked erp-input-icon"></i>
                          <input type="text" name="name" id="name" class="form-control erp-filter-input {{ $errors->has('name') ? 'is-invalid' : '' }}" placeholder="e.g. Stationery, IT Equipment" value="{{ old('name') }}" required>
                        </div>
                        @error('name')
                          <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                      </div>

                      <button type="submit" class="btn btn-primary btn-sm w-100 py-2 font-weight-bold shadow-sm">
                        <i class="fas fa-save me-1"></i> Save Category
                      </button>
                    </form>
                  </div>
                </div>
              </div>

              <!-- Right Column: Categories List -->
              <div class="col-lg-8 mb-3">
                <div class="erp-card-table">
                  <div class="erp-table-header-block">
                    <div>
                      <h4 class="erp-table-title"><i class="fas fa-tags text-primary me-2"></i>Inventory Categories</h4>
                      <p class="erp-table-subtitle">Manage and organize store item categories</p>
                    </div>
                  </div>

                  <!-- Toolbar -->
                  <div class="erp-toolbar">
                    <!-- Left: Export Buttons -->
                    <div class="erp-export-group">
                      <button id="copyButton" class="erp-btn-export" title="Copy to Clipboard">
                        <i class="fas fa-copy"></i><span>Copy</span>
                      </button>
                      <button id="csvButton" class="erp-btn-export" title="Export to CSV">
                        <i class="fas fa-file-csv"></i><span>CSV</span>
                      </button>
                      <button id="excelButton" class="erp-btn-export" title="Export to Excel">
                        <i class="fas fa-file-excel"></i><span>Excel</span>
                      </button>
                      <button id="pdfButton" class="erp-btn-export" title="Export to PDF">
                        <i class="fas fa-file-pdf"></i><span>PDF</span>
                      </button>
                    </div>

                    <!-- Right: Search Controls -->
                    <div class="erp-filter-group">
                      <div class="erp-input-icon-wrapper">
                        <i class="fas fa-search erp-input-icon"></i>
                        <input type="text" id="categorySearchInput" class="form-control erp-filter-input" placeholder="Search category..." style="width: 220px;">
                      </div>
                      <button type="button" id="resetFilterBtn" class="erp-btn-filter-action erp-btn-filter-reset" title="Reset Filters">
                        <i class="fas fa-rotate-left"></i><span>Reset</span>
                      </button>
                    </div>
                  </div>

                  <!-- Table -->
                  <div class="table-responsive">
                    <table class="table erp-table" id="categoriesTable">
                      <thead>
                        <tr>
                          <th style="width: 60px;">#</th>
                          <th>Category Name</th>
                          <th style="width: 120px;" class="text-center">Status</th>
                          <th style="width: 110px;" class="text-center">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php $count = 0; @endphp
                        @forelse ($categories as $recode)
                          @if($recode->status != 'deleted')
                            <tr class="category-row" data-name="{{ strtolower($recode->name) }}">
                              <td class="font-weight-bold text-muted">{{ ++$count }}</td>
                              <td>
                                <div class="font-weight-600 text-dark">{{ $recode->name }}</div>
                              </td>
                              <td class="text-center">
                                @if ($recode->status == 'active')
                                  <span class="badge" style="background-color: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; font-weight: 600; font-size: 11px; padding: 4px 8px; border-radius: 6px;">
                                    <i class="fas fa-circle-check me-1"></i>Active
                                  </span>
                                @else
                                  <span class="badge" style="background-color: #fef2f2; color: #dc2626; border: 1px solid #fecaca; font-weight: 600; font-size: 11px; padding: 4px 8px; border-radius: 6px;">
                                    <i class="fas fa-circle-xmark me-1"></i>Inactive
                                  </span>
                                @endif
                              </td>
                              <td class="text-center">
                                <div class="erp-action-btn-group justify-content-center">
                                  @if ($recode->status == 'active')
                                    <a class="erp-action-btn" style="color: #d97706; background: #fef3c7;" href="{{ route('inventory.catagory.changeStatus', ['id' => $recode->id]) }}" title="Set Inactive">
                                      <i class="fas fa-ban"></i>
                                    </a>
                                  @else
                                    <a class="erp-action-btn" style="color: #059669; background: #d1fae5;" href="{{ route('inventory.catagory.changeStatus', ['id' => $recode->id]) }}" title="Set Active">
                                      <i class="fas fa-check"></i>
                                    </a>
                                  @endif
                                  <button type="button" class="erp-action-btn erp-btn-delete" title="Delete Category" onclick="confirmDelete(event, '{{ route('inventory.catagory.delete', ['id' => $recode->id]) }}')">
                                    <i class="fas fa-trash-can"></i>
                                  </button>
                                </div>
                              </td>
                            </tr>
                          @endif
                        @empty
                          <tr>
                            <td colspan="4" class="text-center py-4 text-muted">
                              <i class="fas fa-boxes-stacked fa-2x mb-2 d-block text-muted opacity-50"></i>
                              No categories found.
                            </td>
                          </tr>
                        @endforelse
                      </tbody>
                    </table>
                  </div>

                  <!-- Footer -->
                  <div class="erp-table-footer">
                    <div class="erp-footer-count">
                      Showing <span id="filteredCount">{{ $count }}</span> of <span>{{ $count }}</span> entries
                    </div>
                  </div>

                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
      <!-- End Inner-page -->

    </div>
  </div>

  @include('view-file.script')
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.11/clipboard.min.js"></script>

  <script>
    function confirmDelete(event, url) {
      event.preventDefault();
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#4f46e5',
        cancelButtonColor: '#ef4444',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = url;
        }
      });
    }

    document.addEventListener('DOMContentLoaded', function() {
      // Live Filter functionality
      const searchInput = document.getElementById('categorySearchInput');
      const resetBtn = document.getElementById('resetFilterBtn');
      const rows = document.querySelectorAll('.category-row');
      const filteredCount = document.getElementById('filteredCount');

      function filterRows() {
        const query = (searchInput.value || '').toLowerCase().trim();
        let visible = 0;

        rows.forEach(row => {
          const name = row.getAttribute('data-name') || '';
          const matches = name.includes(query);
          if (matches) {
            row.style.display = '';
            visible++;
          } else {
            row.style.display = 'none';
          }
        });

        if (filteredCount) filteredCount.textContent = visible;
      }

      if (searchInput) searchInput.addEventListener('input', filterRows);
      if (resetBtn) {
        resetBtn.addEventListener('click', function() {
          if (searchInput) searchInput.value = '';
          filterRows();
        });
      }

      // Exports
      const copyBtn = document.getElementById('copyButton');
      const csvBtn = document.getElementById('csvButton');
      const excelBtn = document.getElementById('excelButton');
      const pdfBtn = document.getElementById('pdfButton');

      if (copyBtn) {
        new ClipboardJS(copyBtn, {
          text: function() {
            let table = document.getElementById('categoriesTable');
            return table.innerText;
          }
        }).on('success', function() {
          Swal.fire({ icon: 'success', title: 'Copied!', timer: 1500, showConfirmButton: false });
        });
      }

      if (csvBtn) {
        csvBtn.addEventListener('click', function() {
          let csv = [];
          let rows = document.querySelectorAll('#categoriesTable tr');
          rows.forEach(row => {
            if (row.style.display !== 'none') {
              let cols = row.querySelectorAll('th, td');
              let rowData = [];
              for (let i = 0; i < cols.length - 1; i++) { // exclude action col
                rowData.push('"' + cols[i].innerText.replace(/"/g, '""').trim() + '"');
              }
              csv.push(rowData.join(','));
            }
          });
          let blob = new Blob([csv.join('\n')], { type: 'text/csv;charset=utf-8;' });
          let link = document.createElement('a');
          link.href = URL.createObjectURL(blob);
          link.download = 'inventory_categories.csv';
          link.click();
        });
      }

      if (excelBtn) {
        excelBtn.addEventListener('click', function() {
          let table = document.getElementById('categoriesTable');
          let wb = XLSX.utils.table_to_book(table, { sheet: 'Categories' });
          XLSX.writeFile(wb, 'inventory_categories.xlsx');
        });
      }

      if (pdfBtn) {
        pdfBtn.addEventListener('click', function() {
          const { jsPDF } = window.jspdf;
          let doc = new jsPDF();
          doc.text('Inventory Categories List', 14, 15);
          doc.autoTable({
            html: '#categoriesTable',
            startY: 20,
            columns: [0, 1, 2] // Exclude actions
          });
          doc.save('inventory_categories.pdf');
        });
      }
    });
  </script>

  @if(session('error'))
  <script>
    Swal.fire({
      title: 'Error!',
      text: "{{ session('error') }}",
      icon: 'error',
      confirmButtonText: 'OK'
    });
  </script>
  @endif

  @if(session('success'))
  <script>
    Swal.fire({
      title: 'Success!',
      text: "{{ session('success') }}",
      icon: 'success',
      confirmButtonText: 'OK'
    });
  </script>
  @endif

</body>
</html>
