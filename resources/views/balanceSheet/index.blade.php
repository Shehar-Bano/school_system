<!DOCTYPE html>
<html lang="en">
@php
    use Carbon\Carbon;
@endphp
@include('view-file/head')

<style>
@media print {
  .erp-toolbar, .erp-table-header-block .btn, .navbar, .sidebar {
    display: none !important;
  }
  .main-panel {
    width: 100% !important;
    margin: 0 !important;
    padding: 0 !important;
  }
}
</style>

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
                  <h4 class="erp-table-title"><i class="fas fa-scale-balanced text-primary me-2"></i>School Balance Sheet</h4>
                  <p class="erp-table-subtitle">General ledger accounting statement, debit/credit entries, and cumulative net balance</p>
                </div>
                <div class="d-flex gap-2">
                  <button type="button" class="btn btn-primary btn-sm font-weight-bold shadow-sm" onclick="window.print()">
                    <i class="fas fa-print me-1"></i> Print Statement
                  </button>
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
                    <input type="text" id="balanceSearchInput" class="form-control erp-filter-input" placeholder="Search transactions..." style="width: 220px;">
                  </div>
                  <button type="button" id="resetFilterBtn" class="erp-btn-filter-action erp-btn-filter-reset" title="Reset Filters">
                    <i class="fas fa-rotate-left"></i><span>Reset</span>
                  </button>
                </div>
              </div>

              <!-- Table -->
              <div class="table-responsive">
                <table class="table erp-table" id="balanceSheetTable">
                  <thead>
                    <tr>
                      <th style="width: 50px;">#</th>
                      <th style="width: 120px;">Date</th>
                      <th>Description</th>
                      <th class="text-right" style="width: 140px;">Debit (Out)</th>
                      <th class="text-right" style="width: 140px;">Credit (In)</th>
                      <th class="text-right" style="width: 150px;">Running Balance</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php 
                      $currentBalance = 0; 
                      $count = 0;
                    @endphp
                    @forelse ($entries as $entry)
                      @php
                        $count++;
                        if ($entry['type'] == 'debit') {
                          $currentBalance -= $entry['amount'];
                        } elseif ($entry['type'] == 'credit') {
                          $currentBalance += $entry['amount'];
                        }
                      @endphp
                      <tr class="balance-row" data-desc="{{ strtolower($entry['description'] ?? '') }}">
                        <td class="font-weight-bold text-muted">{{ $loop->iteration }}</td>
                        <td>
                          <span class="erp-code-pill" style="color: #475569; background: #f8fafc; border-color: #e2e8f0;">
                            <i class="fas fa-calendar-day me-1 text-muted"></i>
                            {{ Carbon::parse($entry['date'])->format('Y-m-d') }}
                          </span>
                        </td>
                        <td>
                          <div class="font-weight-600 text-dark">{{ $entry['description'] }}</div>
                        </td>
                        <td class="text-right">
                          @if($entry['type'] == 'debit')
                            <span class="badge" style="background-color: #fef2f2; color: #dc2626; border: 1px solid #fecaca; font-weight: 700; font-size: 12px; padding: 4px 8px; border-radius: 6px;">
                              - {{ number_format($entry['amount']) }} Rs
                            </span>
                          @else
                            <span class="text-muted opacity-50">—</span>
                          @endif
                        </td>
                        <td class="text-right">
                          @if($entry['type'] == 'credit')
                            <span class="badge" style="background-color: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; font-weight: 700; font-size: 12px; padding: 4px 8px; border-radius: 6px;">
                              + {{ number_format($entry['amount']) }} Rs
                            </span>
                          @else
                            <span class="text-muted opacity-50">—</span>
                          @endif
                        </td>
                        <td class="text-right">
                          <span class="font-weight-bold {{ $currentBalance >= 0 ? 'text-success' : 'text-danger' }}" style="font-size: 13px;">
                            {{ number_format($currentBalance) }} Rs/-
                          </span>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                          <i class="fas fa-receipt fa-2x mb-2 d-block text-muted opacity-50"></i>
                          No financial entries recorded yet.
                        </td>
                      </tr>
                    @endforelse
                  </tbody>
                  @if($count > 0)
                    <tfoot>
                      <tr style="background: #f8fafc; font-weight: 700; font-size: 13px;">
                        <td colspan="3" class="text-right py-3" style="color: #334155;">Grand Totals:</td>
                        <td class="text-right py-3 text-danger">
                          {{ number_format($totalDebit) }} Rs/-
                        </td>
                        <td class="text-right py-3 text-success">
                          {{ number_format($totalCredit) }} Rs/-
                        </td>
                        <td class="text-right py-3 text-primary">
                          {{ number_format($currentBalance) }} Rs/-
                        </td>
                      </tr>
                    </tfoot>
                  @endif
                </table>
              </div>

              <!-- Footer -->
              <div class="erp-table-footer">
                <div class="erp-footer-count">
                  Showing <span id="filteredCount">{{ $count }}</span> of <span>{{ $count }}</span> ledger entries
                </div>
              </div>

            </div>

          </div>
        </div>
      </div>
      <!-- End Inner-page -->

    </div>
  </div>

  @include('view-file/script')

  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.11/clipboard.min.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const searchInput = document.getElementById('balanceSearchInput');
      const resetBtn = document.getElementById('resetFilterBtn');
      const rows = document.querySelectorAll('.balance-row');
      const filteredCount = document.getElementById('filteredCount');

      function filterRows() {
        const query = (searchInput.value || '').toLowerCase().trim();
        let visible = 0;

        rows.forEach(row => {
          const desc = row.getAttribute('data-desc') || '';
          if (desc.includes(query)) {
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
            let table = document.getElementById('balanceSheetTable');
            return table.innerText;
          }
        }).on('success', function() {
          Swal.fire({ icon: 'success', title: 'Copied!', timer: 1500, showConfirmButton: false });
        });
      }

      if (csvBtn) {
        csvBtn.addEventListener('click', function() {
          let csv = [];
          let rows = document.querySelectorAll('#balanceSheetTable tr');
          rows.forEach(row => {
            if (row.style.display !== 'none') {
              let cols = row.querySelectorAll('th, td');
              let rowData = [];
              for (let i = 0; i < cols.length; i++) {
                rowData.push('"' + cols[i].innerText.replace(/"/g, '""').trim() + '"');
              }
              csv.push(rowData.join(','));
            }
          });
          let blob = new Blob([csv.join('\n')], { type: 'text/csv;charset=utf-8;' });
          let link = document.createElement('a');
          link.href = URL.createObjectURL(blob);
          link.download = 'balance_sheet.csv';
          link.click();
        });
      }

      if (excelBtn) {
        excelBtn.addEventListener('click', function() {
          let table = document.getElementById('balanceSheetTable');
          let wb = XLSX.utils.table_to_book(table, { sheet: 'BalanceSheet' });
          XLSX.writeFile(wb, 'balance_sheet.xlsx');
        });
      }

      if (pdfBtn) {
        pdfBtn.addEventListener('click', function() {
          const { jsPDF } = window.jspdf;
          let doc = new jsPDF();
          doc.text('School Balance Sheet', 14, 15);
          doc.autoTable({
            html: '#balanceSheetTable',
            startY: 20
          });
          doc.save('balance_sheet.pdf');
        });
      }
    });
  </script>
</body>
</html>
