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

            <div class="erp-card-table">
              <!-- Header Block -->
              <div class="erp-table-header-block">
                <div>
                  <h4 class="erp-table-title"><i class="fas fa-file-invoice-dollar text-primary me-2"></i>Class-wise Fee Structure & Taxes</h4>
                  <p class="erp-table-subtitle">View and configure tuition fees, auxiliary charges, and tax slabs per section</p>
                </div>
                <a href="{{ route('student_fees') }}" class="btn btn-light btn-sm font-weight-bold" style="border: 1px solid var(--erp-border, #e2e8f0); color: #475569;">
                  <i class="fas fa-coins me-1"></i> Fee Collection
                </a>
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

                <!-- Right: Filters -->
                <div class="erp-filter-group">
                  <div class="erp-input-icon-wrapper">
                    <i class="fas fa-search erp-input-icon"></i>
                    <input type="text" id="sectionSearchInput" class="form-control erp-filter-input" placeholder="Search section/class..." style="width: 200px;">
                  </div>
                  <button type="button" id="resetFilterBtn" class="erp-btn-filter-action erp-btn-filter-reset" title="Reset Filters">
                    <i class="fas fa-rotate-left"></i><span>Reset</span>
                  </button>
                </div>
              </div>

              <!-- Table -->
              <div class="table-responsive">
                <table class="table erp-table" id="feeSectionsTable">
                  <thead>
                    <tr>
                      <th style="width: 60px;">#</th>
                      <th>Class</th>
                      <th>Section</th>
                      <th style="width: 140px;" class="text-center">Manage Taxes</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php $serialNumber = 1; @endphp
                    @forelse ($sections as $section)
                      <tr class="section-row" data-class="{{ strtolower(optional($section->classe)->name ?? '') }}" data-section="{{ strtolower($section->name ?? '') }}">
                        <td class="font-weight-bold text-muted">{{ $serialNumber++ }}</td>
                        <td>
                          <span class="badge" style="background-color: #f1f5f9; color: #334155; border: 1px solid #cbd5e1; font-weight: 600; font-size: 11px; padding: 4px 8px; border-radius: 6px;">
                            <i class="fas fa-graduation-cap me-1 text-muted"></i>{{ optional($section->classe)->name ?? 'N/A' }}
                          </span>
                        </td>
                        <td>
                          <div class="font-weight-600 text-dark">{{ $section->name }}</div>
                        </td>
                        <td class="text-center">
                          <a href="{{ route('taxe.show.student', ['id' => $section->id]) }}" class="btn btn-sm btn-primary py-1 px-2 font-weight-bold" style="font-size: 11px; border-radius: 6px;" title="Manage Section Taxes">
                            <i class="fas fa-receipt me-1"></i> Manage Taxes
                          </a>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="4" class="text-center py-4 text-muted">
                          <i class="fas fa-receipt fa-2x mb-2 d-block text-muted opacity-50"></i>
                          No class sections available.
                        </td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>

              <!-- Footer -->
              <div class="erp-table-footer">
                <div class="erp-footer-count">
                  Showing <span id="filteredCount">{{ count($sections) }}</span> of <span>{{ count($sections) }}</span> class sections
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
    document.addEventListener('DOMContentLoaded', function() {
      const searchInput = document.getElementById('sectionSearchInput');
      const resetBtn = document.getElementById('resetFilterBtn');
      const rows = document.querySelectorAll('.section-row');
      const filteredCount = document.getElementById('filteredCount');

      function filterRows() {
        const query = (searchInput.value || '').toLowerCase().trim();
        let visible = 0;

        rows.forEach(row => {
          const className = row.getAttribute('data-class') || '';
          const sectionName = row.getAttribute('data-section') || '';
          if (className.includes(query) || sectionName.includes(query)) {
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
            let table = document.getElementById('feeSectionsTable');
            return table.innerText;
          }
        }).on('success', function() {
          Swal.fire({ icon: 'success', title: 'Copied!', timer: 1500, showConfirmButton: false });
        });
      }

      if (csvBtn) {
        csvBtn.addEventListener('click', function() {
          let csv = [];
          let rows = document.querySelectorAll('#feeSectionsTable tr');
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
          link.download = 'fee_sections.csv';
          link.click();
        });
      }

      if (excelBtn) {
        excelBtn.addEventListener('click', function() {
          let table = document.getElementById('feeSectionsTable');
          let wb = XLSX.utils.table_to_book(table, { sheet: 'FeeSections' });
          XLSX.writeFile(wb, 'fee_sections.xlsx');
        });
      }

      if (pdfBtn) {
        pdfBtn.addEventListener('click', function() {
          const { jsPDF } = window.jspdf;
          let doc = new jsPDF();
          doc.text('Fee Sections Structure', 14, 15);
          doc.autoTable({
            html: '#feeSectionsTable',
            startY: 20,
            columns: [0, 1, 2]
          });
          doc.save('fee_sections.pdf');
        });
      }
    });
  </script>

  @if(session('message'))
    <script>
      Swal.fire({
        title: 'Success!',
        text: "{{ session('message') }}",
        icon: 'success',
        confirmButtonText: 'OK'
      });
    </script>
  @endif

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
</body>
</html>
