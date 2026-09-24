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
          
          <!-- ERP Card Table Container -->
          <div class="erp-card-table">
            
            <!-- Table Header Block -->
            <div class="erp-table-header-block">
              <div class="erp-table-title-area">
                <h3 class="erp-table-title">
                  <i class="fas fa-wallet text-primary"></i>
                  Faculty & Staff Payroll
                </h3>
                <p class="erp-table-subtitle">Manage employee monthly payroll, deductions, bonuses, pay slips, and disbursement records</p>
              </div>

              <!-- Top Action: Add New Salary Button -->
              <div>
                <a href="{{ route('salary.store') }}" class="btn btn-sm btn-primary">
                  <i class="fas fa-plus mr-1"></i> Add New Salary
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
              <form action="{{ route('finance.salary') }}" method="GET" class="m-0">
                <div class="erp-filter-group">
                  <input type="date" id="start_date" name="start_date" class="form-control" style="height: 34px; width: 130px; font-size: 11.5px;" value="{{ request('start_date') }}" title="Start Date">
                  <input type="date" id="end_date" name="end_date" class="form-control" style="height: 34px; width: 130px; font-size: 11.5px;" value="{{ request('end_date') }}" title="End Date">
                  
                  <select class="erp-filter-select" id="employee_id" name="employee_id">
                    <option value="">All Employees</option>
                    @foreach ($employees as $employee)
                      <option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>
                        {{ $employee->name }}
                      </option>
                    @endforeach
                  </select>

                  <button type="submit" class="erp-btn-filter-action erp-btn-filter-primary">
                    <i class="fas fa-filter"></i> Filter
                  </button>

                  <a href="{{ route('finance.salary') }}" class="erp-btn-filter-action erp-btn-filter-reset text-decoration-none">
                    <i class="fas fa-rotate-left"></i> Reset
                  </a>
                </div>
              </form>
            </div>

            <!-- Table Responsive Container -->
            <div class="table-responsive">
              <table class="erp-table" id="salariesTable">
                <thead>
                  <tr>
                    <th style="width: 50px;" class="text-center">#</th>
                    <th style="width: 12%;" class="text-center">Payroll Month</th>
                    <th style="width: 20%;">Employee Name</th>
                    <th style="width: 12%;" class="text-center">Base Salary</th>
                    <th style="width: 10%;" class="text-center">Bonus</th>
                    <th style="width: 10%;" class="text-center">Deduction</th>
                    <th style="width: 12%;" class="text-center">Gross Salary</th>
                    <th style="width: 12%;" class="text-center">Net Payable</th>
                    <th style="width: 10%;" class="text-center">Status</th>
                    <th style="width: 100px;" class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                    $count = 0;
                  @endphp
                  @forelse ($calculatedSalaries as $salary)
                  <tr>
                    <td class="text-center font-weight-medium text-muted">{{ ++$count }}</td>
                    <td class="text-center">
                      <span class="badge badge-soft-primary font-weight-medium" style="font-size: 11px;">
                        <i class="fas fa-calendar-day text-xs mr-1"></i> {{ $salary['date'] }}
                      </span>
                    </td>
                    <td class="font-weight-semibold text-dark">
                      {{ $salary['employee_name'] }}
                    </td>
                    <td class="text-center text-xs text-dark font-weight-medium">
                      Rs. {{ number_format($salary['base_salary']) }}
                    </td>
                    <td class="text-center text-xs text-success font-weight-medium">
                      {{ $salary['bonus'] ? '+ Rs. '. number_format($salary['bonus']) : '—' }}
                    </td>
                    <td class="text-center text-xs text-danger font-weight-medium">
                      {{ $salary['deduction'] ? '- Rs. '. number_format($salary['deduction']) : '—' }}
                    </td>
                    <td class="text-center text-xs text-secondary font-weight-medium">
                      Rs. {{ number_format($salary['gross_salary']) }}
                    </td>
                    <td class="text-center font-weight-bold text-dark">
                      Rs. {{ number_format($salary['net_salary']) }}
                    </td>
                    <td class="text-center">
                      @if ($salary['status'] == 'unpaid')
                        <span class="badge badge-soft-warning">
                          <span class="dot" style="width: 5px; height: 5px; border-radius: 50%; background-color: #f59e0b; display: inline-block;"></span>
                          Unpaid
                        </span>
                      @else
                        <span class="badge badge-soft-success">
                          <span class="dot" style="width: 5px; height: 5px; border-radius: 50%; background-color: #10b981; display: inline-block;"></span>
                          Paid
                        </span>
                      @endif
                    </td>
                    <td class="text-center">
                      <div class="erp-action-btn-group">
                        @if ($salary['status'] == 'unpaid')
                          <a href="{{ route('salary.pay', ['id' => $salary['id']]) }}" class="erp-action-btn" style="background-color: #ecfdf5; color: #047857;" title="Pay Salary">
                            <i class="fas fa-money-bill-wave"></i>
                          </a>
                        @else
                          <span class="erp-action-btn" style="background-color: #f1f5f9; color: #94a3b8; cursor: not-allowed;" title="Salary Already Paid">
                            <i class="fas fa-check"></i>
                          </span>
                        @endif

                        <!-- Print PDF Slip -->
                        <a href="{{ route('salary.pdf', ['id' => $salary['employee_id']]) }}" class="erp-action-btn view" title="Print Salary Slip">
                          <i class="fas fa-print"></i>
                        </a>
                      </div>
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="10" class="text-center py-4 text-muted">
                      <i class="fas fa-wallet mb-2 text-xl d-block" style="font-size: 24px; color: #cbd5e1;"></i>
                      No salary records found for the selected period.
                    </td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            <!-- Table Footer with Records Count and Pagination -->
            <div class="erp-table-footer">
              <div class="erp-table-info">
                Showing 1 to {{ count($calculatedSalaries) }} of {{ count($calculatedSalaries) }} payroll records
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

  <!-- Export functionality -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const copyBtn = document.getElementById('copyButton');
      const csvBtn = document.getElementById('csvButton');
      const excelBtn = document.getElementById('excelButton');
      const pdfBtn = document.getElementById('pdfButton');

      if (copyBtn && window.ClipboardJS) {
        new ClipboardJS(copyBtn, {
          text: function () {
            return document.getElementById('salariesTable').innerText;
          }
        }).on('success', function () {
          Swal.fire({
            toast: true, position: 'top-end', icon: 'success',
            title: 'Payroll table copied', showConfirmButton: false, timer: 2000
          });
        });
      }

      if (csvBtn) {
        csvBtn.addEventListener('click', function () {
          let csv = [];
          let rows = document.querySelectorAll('#salariesTable tr');
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
          link.download = 'salaries_payroll.csv';
          link.click();
        });
      }

      if (excelBtn && window.XLSX) {
        excelBtn.addEventListener('click', function () {
          let table = document.getElementById('salariesTable');
          let wb = XLSX.utils.table_to_book(table, { sheet: 'Payroll' });
          XLSX.writeFile(wb, 'salaries_payroll.xlsx');
        });
      }

      if (pdfBtn && window.jspdf) {
        pdfBtn.addEventListener('click', function () {
          const { jsPDF } = window.jspdf;
          let doc = new jsPDF('l', 'pt', 'a4');
          doc.text("School ERP - Faculty & Staff Payroll List", 40, 30);
          if (doc.autoTable) {
            doc.autoTable({
              html: '#salariesTable',
              startY: 45,
              columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
              theme: 'striped',
              headStyles: { fillColor: [79, 70, 229] }
            });
            doc.save('salaries_payroll.pdf');
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
