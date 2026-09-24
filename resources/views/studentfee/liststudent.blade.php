<!DOCTYPE html>
<html lang="en">
@php
  use Carbon\Carbon;
  use App\Models\StudentFee;
@endphp

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
                  <i class="fas fa-hand-holding-dollar text-primary"></i>
                  Fee Collection & Dues Directory
                </h3>
                <p class="erp-table-subtitle">Collect student monthly tuition fees, exam fees, calculate fund adjustments and pending balances</p>
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

              <!-- Right: Search Controls -->
              <div class="erp-filter-group">
                <div class="erp-input-icon-wrapper">
                  <i class="fas fa-search"></i>
                  <input type="text" id="filterStudentFee" placeholder="Search student name..." autocomplete="off">
                </div>

                <button type="button" id="btnFilterReset" class="erp-btn-filter-action erp-btn-filter-reset">
                  <i class="fas fa-rotate-left"></i> Reset
                </button>
              </div>
            </div>

            <!-- Table Responsive Container -->
            <div class="table-responsive">
              <table class="erp-table" id="studentFeeTable">
                <thead>
                  <tr>
                    <th style="width: 50px;" class="text-center">#</th>
                    <th style="width: 12%;" class="text-center">Billing Date</th>
                    <th style="width: 20%;">Student Profile</th>
                    <th style="width: 11%;" class="text-center">Tuition</th>
                    <th style="width: 10%;" class="text-center">Waiver / Fund</th>
                    <th style="width: 10%;" class="text-center">Fine</th>
                    <th style="width: 10%;" class="text-center">Exam Fee</th>
                    <th style="width: 12%;" class="text-center">Total Payable</th>
                    <th style="width: 11%;" class="text-center">Status</th>
                    <th style="width: 80px;" class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody id="studentFeeTableBody">
                  @php
                    $count = 0;
                    $totalFee = 0;
                  @endphp
                  @forelse ($studentData as $data)
                  @php
                    $totalFee = $data['tuitionFee'] + $data['totalFine'] + $data['examFee'] - $data['totalFund'];
                    $isPaid = StudentFee::where('student_id', $data['student_id'])->exists();
                  @endphp
                  <tr data-name="{{ strtolower($data['student']->name ?? '') }}">
                    <td class="text-center font-weight-medium text-muted">{{ ++$count }}</td>
                    <td class="text-center text-xs text-muted">
                      {{ \Carbon\Carbon::parse($data['date'])->format('j M Y') }}
                    </td>
                    <td>
                      <div class="d-flex align-items-center gap-2">
                        <div class="erp-user-avatar" style="width: 26px; height: 26px; font-size: 10px;">
                          {{ strtoupper(substr($data['student']->name ?? 'ST', 0, 2)) }}
                        </div>
                        <span class="font-weight-semibold text-dark">{{ $data['student']->name ?? 'Student' }}</span>
                      </div>
                    </td>
                    <td class="text-center text-xs font-weight-medium text-dark">
                      Rs. {{ number_format($data['tuitionFee']) }}
                    </td>
                    <td class="text-center text-xs font-weight-medium text-success">
                      {{ $data['totalFund'] > 0 ? '- Rs. '. number_format($data['totalFund']) : '—' }}
                    </td>
                    <td class="text-center text-xs font-weight-medium text-danger">
                      {{ $data['totalFine'] > 0 ? '+ Rs. '. number_format($data['totalFine']) : '—' }}
                    </td>
                    <td class="text-center text-xs font-weight-medium text-secondary">
                      {{ $data['examFee'] > 0 ? 'Rs. '. number_format($data['examFee']) : '—' }}
                    </td>
                    <td class="text-center font-weight-bold text-dark">
                      Rs. {{ number_format(max(0, $totalFee)) }}
                    </td>
                    <td class="text-center">
                      @if (!$isPaid)
                        <span class="badge badge-soft-warning">
                          <span class="dot" style="width: 5px; height: 5px; border-radius: 50%; background-color: #f59e0b; display: inline-block;"></span>
                          Pending
                        </span>
                      @else
                        <span class="badge badge-soft-success">
                          <span class="dot" style="width: 5px; height: 5px; border-radius: 50%; background-color: #10b981; display: inline-block;"></span>
                          Received
                        </span>
                      @endif
                    </td>
                    <td class="text-center">
                      <div class="erp-action-btn-group">
                        @if (!$isPaid)
                          <a href="{{ route('fee.receive', ['id' => $data['student_id'], 'total' => $totalFee]) }}" class="erp-action-btn" style="background-color: #ecfdf5; color: #047857;" title="Receive Fee Payment">
                            <i class="fas fa-coins"></i>
                          </a>
                        @else
                          <span class="erp-action-btn" style="background-color: #f1f5f9; color: #94a3b8; cursor: not-allowed;" title="Fee Received">
                            <i class="fas fa-check"></i>
                          </span>
                        @endif
                      </div>
                    </td>
                  </tr>
                  @empty
                  <tr id="emptyRow">
                    <td colspan="10" class="text-center py-4 text-muted">
                      <i class="fas fa-hand-holding-dollar mb-2 text-xl d-block" style="font-size: 24px; color: #cbd5e1;"></i>
                      No student fee records pending collection.
                    </td>
                  </tr>
                  @endforelse
                  <tr id="noResultsRow" style="display: none;">
                    <td colspan="10" class="text-center py-4 text-muted">
                      <i class="fas fa-magnifying-glass mb-2 text-xl d-block" style="font-size: 22px; color: #cbd5e1;"></i>
                      No matching student fee records found.
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Table Footer with Records Count and Pagination -->
            <div class="erp-table-footer">
              <div class="erp-table-info" id="tableRecordInfo">
                Showing 1 to {{ count($studentData) }} of {{ count($studentData) }} students
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

  <!-- Filter & Export Script -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const nameInput = document.getElementById('filterStudentFee');
      const resetBtn = document.getElementById('btnFilterReset');
      const tableRows = document.querySelectorAll('#studentFeeTableBody tr[data-name]');
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
            ? `Showing 1 to ${totalCount} of ${totalCount} students`
            : `Showing ${visibleCount} of ${totalCount} filtered students`;
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
            return document.getElementById('studentFeeTable').innerText;
          }
        }).on('success', function () {
          Swal.fire({
            toast: true, position: 'top-end', icon: 'success',
            title: 'Fee list copied', showConfirmButton: false, timer: 2000
          });
        });
      }

      if (csvBtn) {
        csvBtn.addEventListener('click', function () {
          let csv = [];
          let rows = document.querySelectorAll('#studentFeeTable tr:not(#noResultsRow)');
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
          link.download = 'student_fee_collection.csv';
          link.click();
        });
      }

      if (excelBtn && window.XLSX) {
        excelBtn.addEventListener('click', function () {
          let table = document.getElementById('studentFeeTable');
          let wb = XLSX.utils.table_to_book(table, { sheet: 'FeeCollection' });
          XLSX.writeFile(wb, 'student_fee_collection.xlsx');
        });
      }

      if (pdfBtn && window.jspdf) {
        pdfBtn.addEventListener('click', function () {
          const { jsPDF } = window.jspdf;
          let doc = new jsPDF('l', 'pt', 'a4');
          doc.text("School ERP - Student Fee Collection", 40, 30);
          if (doc.autoTable) {
            doc.autoTable({
              html: '#studentFeeTable',
              startY: 45,
              columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
              theme: 'striped',
              headStyles: { fillColor: [79, 70, 229] }
            });
            doc.save('student_fee_collection.pdf');
          }
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
