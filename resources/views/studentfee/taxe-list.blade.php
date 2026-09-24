<!DOCTYPE html>
<html lang="en">
@php
    use Carbon\Carbon;
    use App\Models\StudentFee;
    use App\Models\TaxeFee;
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
                  <h4 class="erp-table-title"><i class="fas fa-file-invoice text-primary me-2"></i>Student Auxiliary Fee Breakdown</h4>
                  <p class="erp-table-subtitle">Bus, admission, canteen, activity, and library tax collections</p>
                </div>
                <div class="d-flex gap-2">
                  <a href="{{ route('taxe.index') }}" class="btn btn-light btn-sm font-weight-bold" style="border: 1px solid var(--erp-border, #e2e8f0); color: #475569;">
                    <i class="fas fa-arrow-left me-1"></i> Section Slabs
                  </a>
                  <a href="{{ route('student_fees') }}" class="btn btn-light btn-sm font-weight-bold" style="border: 1px solid var(--erp-border, #e2e8f0); color: #475569;">
                    <i class="fas fa-coins me-1"></i> General Fees
                  </a>
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
                    <input type="text" id="taxStudentSearch" class="form-control erp-filter-input" placeholder="Search student name..." style="width: 220px;">
                  </div>
                  <button type="button" id="resetFilterBtn" class="erp-btn-filter-action erp-btn-filter-reset" title="Reset Filters">
                    <i class="fas fa-rotate-left"></i><span>Reset</span>
                  </button>
                </div>
              </div>

              <!-- Table -->
              <div class="table-responsive">
                <table class="table erp-table" id="studentTaxFeeTable">
                  <thead>
                    <tr>
                      <th style="width: 100px;">Date</th>
                      <th>Student</th>
                      <th class="text-right">Bus Tax</th>
                      <th class="text-right">Adm Fee</th>
                      <th class="text-right">Activity</th>
                      <th class="text-right">Canteen</th>
                      <th class="text-right">Library</th>
                      <th class="text-right">Total Fee</th>
                      <th style="width: 120px;" class="text-center">Status</th>
                      <th style="width: 100px;" class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php $count = 0; @endphp
                    @forelse ($studentData as $data)
                      @php
                        $count++;
                        $isPaid = TaxeFee::where('student_id', $data['student_id'])->exists();
                      @endphp
                      <tr class="student-fee-row" data-name="{{ strtolower($data['student']->name ?? '') }}">
                        <td>
                          <span class="erp-code-pill" style="color: #475569; background: #f8fafc; border-color: #e2e8f0; font-size: 11px;">
                            {{ Carbon::parse($data['date'])->format('d M, Y') }}
                          </span>
                        </td>
                        <td>
                          <div class="font-weight-600 text-dark">{{ $data['student']->name ?? 'N/A' }}</div>
                          <span class="text-muted" style="font-size: 11px;">ID: #{{ $data['student_id'] }}</span>
                        </td>
                        <td class="text-right font-weight-500 text-dark">{{ number_format($data['bus_taxes']) }} Rs</td>
                        <td class="text-right font-weight-500 text-dark">{{ number_format($data['admission_tax']) }} Rs</td>
                        <td class="text-right font-weight-500 text-dark">{{ number_format($data['other_activity_tax']) }} Rs</td>
                        <td class="text-right font-weight-500 text-dark">{{ number_format($data['lunch']) }} Rs</td>
                        <td class="text-right font-weight-500 text-dark">{{ number_format($data['library_tax']) }} Rs</td>
                        <td class="text-right">
                          <span class="font-weight-bold text-primary" style="font-size: 13px;">
                            {{ number_format($data['totalFee']) }} Rs/-
                          </span>
                        </td>
                        <td class="text-center">
                          @if (!$isPaid)
                            <span class="badge" style="background-color: #fef2f2; color: #dc2626; border: 1px solid #fecaca; font-weight: 600; font-size: 11px; padding: 4px 8px; border-radius: 6px;">
                              <i class="fas fa-circle-exclamation me-1"></i>Pending
                            </span>
                          @else
                            <span class="badge" style="background-color: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; font-weight: 600; font-size: 11px; padding: 4px 8px; border-radius: 6px;">
                              <i class="fas fa-circle-check me-1"></i>Received
                            </span>
                          @endif
                        </td>
                        <td class="text-center">
                          @if (!$isPaid)
                            <a href="{{ route('taxe.receive', ['id' => $data['student_id'], 'total' => $data['totalFee']]) }}" title="Confirm Payment Receipt" class="btn btn-sm btn-primary py-1 px-2 font-weight-bold shadow-xs" style="font-size: 11px; border-radius: 6px;">
                              <i class="fas fa-hand-holding-dollar me-1"></i> Receive
                            </a>
                          @else
                            <button class="btn btn-sm btn-light py-1 px-2 text-muted" disabled style="font-size: 11px; border-radius: 6px; border: 1px solid #e2e8f0;">
                              <i class="fas fa-check me-1"></i> Paid
                            </button>
                          @endif
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="10" class="text-center py-4 text-muted">
                          <i class="fas fa-receipt fa-2x mb-2 d-block text-muted opacity-50"></i>
                          No auxiliary fee records found.
                        </td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>

              <!-- Footer -->
              <div class="erp-table-footer">
                <div class="erp-footer-count">
                  Showing <span id="filteredCount">{{ $count }}</span> of <span>{{ $count }}</span> student tax entries
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
      const searchInput = document.getElementById('taxStudentSearch');
      const resetBtn = document.getElementById('resetFilterBtn');
      const rows = document.querySelectorAll('.student-fee-row');
      const filteredCount = document.getElementById('filteredCount');

      function filterRows() {
        const query = (searchInput.value || '').toLowerCase().trim();
        let visible = 0;

        rows.forEach(row => {
          const name = row.getAttribute('data-name') || '';
          if (name.includes(query)) {
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
            let table = document.getElementById('studentTaxFeeTable');
            return table.innerText;
          }
        }).on('success', function() {
          Swal.fire({ icon: 'success', title: 'Copied!', timer: 1500, showConfirmButton: false });
        });
      }

      if (csvBtn) {
        csvBtn.addEventListener('click', function() {
          let csv = [];
          let rows = document.querySelectorAll('#studentTaxFeeTable tr');
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
          link.download = 'student_auxiliary_fees.csv';
          link.click();
        });
      }

      if (excelBtn) {
        excelBtn.addEventListener('click', function() {
          let table = document.getElementById('studentTaxFeeTable');
          let wb = XLSX.utils.table_to_book(table, { sheet: 'AuxiliaryFees' });
          XLSX.writeFile(wb, 'student_auxiliary_fees.xlsx');
        });
      }

      if (pdfBtn) {
        pdfBtn.addEventListener('click', function() {
          const { jsPDF } = window.jspdf;
          let doc = new jsPDF('landscape');
          doc.text('Student Auxiliary Fee List', 14, 15);
          doc.autoTable({
            html: '#studentTaxFeeTable',
            startY: 20,
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
          });
          doc.save('student_auxiliary_fees.pdf');
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
