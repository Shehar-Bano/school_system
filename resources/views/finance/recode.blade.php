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
      
      <!-- Main Panel -->
      <div class="main-panel">
        <div class="content-wrapper">
          
          <!-- ERP Card Table Container -->
          <div class="erp-card-table">
            
            <!-- Table Header Block -->
            <div class="erp-table-header-block">
              <div class="erp-table-title-area">
                <h3 class="erp-table-title">
                  <i class="fas fa-money-bill-transfer text-primary"></i>
                  Finance & Bonus/Deduction Records
                </h3>
                <p class="erp-table-subtitle">Manage employee penalties, performance rewards, loan adjustments, and financial transactions</p>
              </div>

              <!-- Top Action: Add New Transaction Button -->
              <div>
                <a href="{{ route('finance.create') }}" class="btn btn-sm btn-primary">
                  <i class="fas fa-plus mr-1"></i> Add New Transaction
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
              <form action="{{ route('finance') }}" method="GET" class="m-0">
                <div class="erp-filter-group">
                  <input type="date" id="start_date" name="start_date" class="form-control" style="height: 34px; width: 125px; font-size: 11px;" value="{{ request('start_date') }}" title="Start Date">
                  <input type="date" id="end_date" name="end_date" class="form-control" style="height: 34px; width: 125px; font-size: 11px;" value="{{ request('end_date') }}" title="End Date">
                  
                  <select class="erp-filter-select" id="employee_id" name="employee_id" style="min-width: 120px;">
                    <option value="">All Staff</option>
                    @foreach ($employees as $employee)
                      <option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>
                        {{ $employee->name }}
                      </option>
                    @endforeach
                  </select>

                  <select id="transaction_type" name="transaction_type" class="erp-filter-select" style="min-width: 130px;">
                    <option value="">All Types</option>
                    <option value="late_Penalty" {{ request('transaction_type') == 'late_Penalty' ? 'selected' : '' }}>Late Penalty</option>
                    <option value="absentance_Penalty" {{ request('transaction_type') == 'absentance_Penalty' ? 'selected' : '' }}>Attendance Penalty</option>
                    <option value="loan_Repayment" {{ request('transaction_type') == 'loan_Repayment' ? 'selected' : '' }}>Loan Repayment</option>
                    <option value="performance_Bonus" {{ request('transaction_type') == 'performance_Bonus' ? 'selected' : '' }}>Performance Bonus</option>
                    <option value="festival_Bonus" {{ request('transaction_type') == 'festival_Bonus' ? 'selected' : '' }}>Festival Bonus</option>
                    <option value="duty_Reward" {{ request('transaction_type') == 'duty_Reward' ? 'selected' : '' }}>Exam Duty Reward</option>
                    <option value="paperChinging_reward" {{ request('transaction_type') == 'paperChinging_reward' ? 'selected' : '' }}>Paper Checking Reward</option>
                  </select>

                  <button type="submit" class="erp-btn-filter-action erp-btn-filter-primary">
                    <i class="fas fa-filter"></i> Filter
                  </button>

                  <a href="{{ route('finance') }}" class="erp-btn-filter-action erp-btn-filter-reset text-decoration-none">
                    <i class="fas fa-rotate-left"></i> Reset
                  </a>
                </div>
              </form>
            </div>

            <!-- Table Responsive Container -->
            <div class="table-responsive">
              <table class="erp-table" id="financeTable">
                <thead>
                  <tr>
                    <th style="width: 50px;" class="text-center">#</th>
                    <th style="width: 14%;" class="text-center">Date</th>
                    <th style="width: 22%;">Employee</th>
                    <th style="width: 22%;">Transaction Type</th>
                    <th style="width: 16%;" class="text-center">Amount</th>
                    <th style="width: 14%;" class="text-center">Due Month</th>
                    <th style="width: 90px;" class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                    $count = 0;
                  @endphp
                  @forelse ($recodes as $recode)
                    @if ($recode->status != 'deleted')
                    <tr>
                      <td class="text-center font-weight-medium text-muted">{{ ++$count }}</td>
                      <td class="text-center text-xs text-muted">
                        {{ $recode->transaction_date }}
                      </td>
                      <td class="font-weight-semibold text-dark">
                        {{ $recode->employee->name ?? 'Staff' }}
                      </td>
                      <td>
                        @if(stripos($recode->transaction_type, 'Bonus') !== false || stripos($recode->transaction_type, 'Reward') !== false)
                          <span class="badge badge-soft-success">
                            <i class="fas fa-arrow-up mr-1 text-xs"></i> {{ str_replace('_', ' ', ucfirst($recode->transaction_type)) }}
                          </span>
                        @else
                          <span class="badge badge-soft-danger">
                            <i class="fas fa-arrow-down mr-1 text-xs"></i> {{ str_replace('_', ' ', ucfirst($recode->transaction_type)) }}
                          </span>
                        @endif
                      </td>
                      <td class="text-center font-weight-bold text-dark">
                        Rs. {{ number_format($recode->amount) }}
                      </td>
                      <td class="text-center text-xs font-weight-medium text-secondary">
                        {{ Carbon::parse($recode->due_date)->format('M, Y') }}
                      </td>
                      <td class="text-center">
                        <div class="erp-action-btn-group">
                          <!-- Edit Button -->
                          <a href="{{ route('finance.edit', ['id' => $recode->id]) }}" class="erp-action-btn edit" title="Edit Record">
                            <i class="fas fa-pen-to-square"></i>
                          </a>

                          <!-- Delete Button -->
                          <a href="{{ route('finance.delete', ['id' => $recode->id]) }}" class="erp-action-btn delete" title="Delete Record" onclick="confirmDelete(event, '{{ route('finance.delete', ['id' => $recode->id]) }}')">
                            <i class="fas fa-trash-can"></i>
                          </a>
                        </div>
                      </td>
                    </tr>
                    @endif
                  @empty
                  <tr>
                    <td colspan="7" class="text-center py-4 text-muted">
                      <i class="fas fa-money-bill-transfer mb-2 text-xl d-block" style="font-size: 24px; color: #cbd5e1;"></i>
                      No finance transaction records found. Click <strong>"Add New Transaction"</strong> to log entries.
                    </td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            <!-- Table Footer with Records Count and Pagination -->
            <div class="erp-table-footer">
              <div class="erp-table-info">
                Showing 1 to {{ count($recodes) }} of {{ count($recodes) }} records
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
    function confirmDelete(event, url) {
      event.preventDefault();
      Swal.fire({
        title: 'Delete Finance Record?',
        text: "This action will remove this transaction record from payroll adjustments.",
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
  </script>

  <!-- Export Functionality -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const copyBtn = document.getElementById('copyButton');
      const csvBtn = document.getElementById('csvButton');
      const excelBtn = document.getElementById('excelButton');
      const pdfBtn = document.getElementById('pdfButton');

      if (copyBtn && window.ClipboardJS) {
        new ClipboardJS(copyBtn, {
          text: function () {
            return document.getElementById('financeTable').innerText;
          }
        }).on('success', function () {
          Swal.fire({
            toast: true, position: 'top-end', icon: 'success',
            title: 'Finance records copied', showConfirmButton: false, timer: 2000
          });
        });
      }

      if (csvBtn) {
        csvBtn.addEventListener('click', function () {
          let csv = [];
          let rows = document.querySelectorAll('#financeTable tr');
          rows.forEach(row => {
            let cols = row.querySelectorAll('th, td');
            let rowData = [];
            for (let i = 0; i < cols.length - 1; i++) {
              rowData.push('"' + cols[i].innerText.replace(/"/g, '""').trim() + '"');
            }
            csv.push(rowData.join(','));
          });
          let blob = new Blob([csv.join('\n')], { type: 'text/csv;charset=utf-8;' });
          let link = document.createElement('a');
          link.href = URL.createObjectURL(blob);
          link.download = 'finance_records.csv';
          link.click();
        });
      }

      if (excelBtn && window.XLSX) {
        excelBtn.addEventListener('click', function () {
          let table = document.getElementById('financeTable');
          let wb = XLSX.utils.table_to_book(table, { sheet: 'Finance' });
          XLSX.writeFile(wb, 'finance_records.xlsx');
        });
      }

      if (pdfBtn && window.jspdf) {
        pdfBtn.addEventListener('click', function () {
          const { jsPDF } = window.jspdf;
          let doc = new jsPDF('p', 'pt', 'a4');
          doc.text("School ERP - Finance & Transaction Records", 40, 30);
          if (doc.autoTable) {
            doc.autoTable({
              html: '#financeTable',
              startY: 45,
              columns: [0, 1, 2, 3, 4, 5],
              theme: 'striped',
              headStyles: { fillColor: [79, 70, 229] }
            });
            doc.save('finance_records.pdf');
          }
        });
      }
    });
  </script>
</body>
</html>
