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
          
          <div class="row">
            <!-- Left: Add Category Form -->
            <div class="col-lg-4 mb-4">
              <div class="card shadow-xs border-0" style="border: 1px solid var(--erp-border); border-radius: var(--erp-radius-xl); overflow: hidden;">
                <div class="card-header bg-white py-3 px-4" style="border-bottom: 1px solid var(--erp-border);">
                  <h3 class="erp-table-title" style="font-size: 14.5px !important;">
                    <i class="fas fa-money-check-dollar text-primary mr-1"></i>
                    Add Fee Category
                  </h3>
                  <p class="erp-table-subtitle">Create new student billing & fee transaction head</p>
                </div>
                <div class="card-body p-4">
                  <form action="{{ route('transaction,type.store') }}" method="POST">
                    @csrf
                    
                    <div class="form-group mb-3">
                      <label for="name" class="font-weight-semibold text-xs text-secondary mb-1">Category / Head Name <span class="text-danger">*</span></label>
                      <input type="text" name="name" id="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" placeholder="e.g. Admission Fee, Lab Charges..." required autocomplete="off">
                      @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>

                    <div class="form-group mb-3">
                      <label for="description" class="font-weight-semibold text-xs text-secondary mb-1">Description</label>
                      <textarea name="description" id="description" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" rows="3" placeholder="Optional details..."></textarea>
                      @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>

                    <button type="submit" class="btn btn-sm btn-primary w-100 font-weight-semibold">
                      <i class="fas fa-save mr-1"></i> Save Fee Category
                    </button>
                  </form>
                </div>
              </div>
            </div>

            <!-- Right: Categories List Table -->
            <div class="col-lg-8">
              <div class="erp-card-table">
                
                <!-- Table Header Block -->
                <div class="erp-table-header-block">
                  <div class="erp-table-title-area">
                    <h3 class="erp-table-title">
                      <i class="fas fa-hand-holding-dollar text-primary"></i>
                      Fee Categories
                    </h3>
                    <p class="erp-table-subtitle">Active student fee billing types and transaction heads</p>
                  </div>
                </div>

                <!-- Single-Line Compact Toolbar -->
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

                  <!-- Right: Search Controls -->
                  <div class="erp-filter-group">
                    <div class="erp-input-icon-wrapper">
                      <i class="fas fa-search"></i>
                      <input type="text" id="filterCategoryName" placeholder="Search category..." autocomplete="off">
                    </div>

                    <button type="button" id="btnFilterReset" class="erp-btn-filter-action erp-btn-filter-reset">
                      <i class="fas fa-rotate-left"></i> Reset
                    </button>
                  </div>
                </div>

                <!-- Table Responsive Container -->
                <div class="table-responsive">
                  <table class="erp-table" id="categoriesTable">
                    <thead>
                      <tr>
                        <th style="width: 50px;" class="text-center">#</th>
                        <th style="width: 35%;">Category Name</th>
                        <th style="width: 45%;">Description</th>
                        <th style="width: 80px;" class="text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody id="categoriesTableBody">
                      @php
                        $count = 0;
                      @endphp
                      @forelse ($transactions as $recode)
                      <tr data-name="{{ strtolower($recode->name) }}">
                        <td class="text-center font-weight-medium text-muted">{{ ++$count }}</td>
                        <td class="font-weight-semibold text-dark">
                          <span class="badge badge-soft-primary mr-1" style="font-size: 11px;">
                            <i class="fas fa-receipt text-xs mr-1"></i> {{ $recode->name }}
                          </span>
                        </td>
                        <td class="text-muted text-xs">
                          {{ $recode->descrtiption ?? $recode->description ?? '—' }}
                        </td>
                        <td class="text-center">
                          <div class="erp-action-btn-group">
                            <a class="erp-action-btn delete" href="{{ route('transaction.type.delete', ['id' => $recode->id]) }}" title="Delete Category" onclick="confirmDelete(event, '{{ route('transaction.type.delete', ['id' => $recode->id]) }}')">
                              <i class="fas fa-trash-can"></i>
                            </a>
                          </div>
                        </td>
                      </tr>
                      @empty
                      <tr id="emptyRow">
                        <td colspan="4" class="text-center py-4 text-muted">
                          <i class="fas fa-receipt mb-2 text-xl d-block" style="font-size: 24px; color: #cbd5e1;"></i>
                          No fee categories created yet.
                        </td>
                      </tr>
                      @endforelse
                      <tr id="noResultsRow" style="display: none;">
                        <td colspan="4" class="text-center py-4 text-muted">
                          <i class="fas fa-magnifying-glass mb-2 text-xl d-block" style="font-size: 22px; color: #cbd5e1;"></i>
                          No matching fee categories found.
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>

                <!-- Table Footer with Records Count and Pagination -->
                <div class="erp-table-footer">
                  <div class="erp-table-info" id="tableRecordInfo">
                    Showing 1 to {{ count($transactions) }} of {{ count($transactions) }} categories
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

        </div>
      </div>
      <!-- End Main Panel -->

    </div>
  </div>

  @include('view-file.script')

  <!-- SweetAlert2 Delete Confirmation -->
  <script>
    function confirmDelete(event, url) {
      event.preventDefault();
      Swal.fire({
        title: 'Delete Fee Category?',
        text: "This action will permanently delete this transaction type.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Yes, delete it',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = url;
        }
      });
    }

    @if(session('success'))
      Swal.fire({
        toast: true, position: 'top-end', icon: 'success',
        title: "{{ session('success') }}", showConfirmButton: false, timer: 2500
      });
    @endif

    @if(session('error'))
      Swal.fire({
        title: 'Error', text: "{{ session('error') }}", icon: 'error', confirmButtonText: 'OK'
      });
    @endif
  </script>

  <!-- Filter & Export Script -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const nameInput = document.getElementById('filterCategoryName');
      const resetBtn = document.getElementById('btnFilterReset');
      const tableRows = document.querySelectorAll('#categoriesTableBody tr[data-name]');
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
            ? `Showing 1 to ${totalCount} of ${totalCount} categories`
            : `Showing ${visibleCount} of ${totalCount} filtered categories`;
        }
      }

      nameInput.addEventListener('input', filterTable);

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
            return document.getElementById('categoriesTable').innerText;
          }
        }).on('success', function () {
          Swal.fire({
            toast: true, position: 'top-end', icon: 'success',
            title: 'Categories copied', showConfirmButton: false, timer: 2000
          });
        });
      }

      if (csvBtn) {
        csvBtn.addEventListener('click', function () {
          let csv = [];
          let rows = document.querySelectorAll('#categoriesTable tr:not(#noResultsRow)');
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
          link.download = 'fee_categories.csv';
          link.click();
        });
      }

      if (excelBtn && window.XLSX) {
        excelBtn.addEventListener('click', function () {
          let table = document.getElementById('categoriesTable');
          let wb = XLSX.utils.table_to_book(table, { sheet: 'Categories' });
          XLSX.writeFile(wb, 'fee_categories.xlsx');
        });
      }

      if (pdfBtn && window.jspdf) {
        pdfBtn.addEventListener('click', function () {
          const { jsPDF } = window.jspdf;
          let doc = new jsPDF('p', 'pt', 'a4');
          doc.text("School ERP - Fee Categories", 40, 30);
          if (doc.autoTable) {
            doc.autoTable({
              html: '#categoriesTable',
              startY: 45,
              columns: [0, 1, 2],
              theme: 'striped',
              headStyles: { fillColor: [79, 70, 229] }
            });
            doc.save('fee_categories.pdf');
          }
        });
      }
    });
  </script>
</body>
</html>
