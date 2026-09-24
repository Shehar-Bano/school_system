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
                  <i class="fas fa-receipt text-primary"></i>
                  Student Fee Transactions
                </h3>
                <p class="erp-table-subtitle">Manage student fee invoices, waivers, special charges, and payment records</p>
              </div>

              <!-- Top Action: Add New Transaction Button -->
              <div>
                <a href="{{ route('transaction.addView') }}" class="btn btn-sm btn-primary">
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
              <form action="{{ route('transaction.view') }}" method="GET" class="m-0">
                <div class="erp-filter-group">
                  <input type="date" id="start_date" name="start_date" class="form-control" style="height: 34px; width: 125px; font-size: 11px;" value="{{ request('start_date') }}" title="Start Date">
                  <input type="date" id="end_date" name="end_date" class="form-control" style="height: 34px; width: 125px; font-size: 11px;" value="{{ request('end_date') }}" title="End Date">
                  
                  <select class="erp-filter-select" id="category_id" name="category_id" style="min-width: 140px;">
                    <option value="">All Categories</option>
                    @foreach ($transactionCategories as $category)
                      <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                      </option>
                    @endforeach
                  </select>

                  <button type="submit" class="erp-btn-filter-action erp-btn-filter-primary">
                    <i class="fas fa-filter"></i> Filter
                  </button>

                  <a href="{{ route('transaction.view') }}" class="erp-btn-filter-action erp-btn-filter-reset text-decoration-none">
                    <i class="fas fa-rotate-left"></i> Reset
                  </a>
                </div>
              </form>
            </div>

            <!-- Table Responsive Container -->
            <div class="table-responsive">
              <table class="erp-table" id="transactionsTable">
                <thead>
                  <tr>
                    <th style="width: 50px;" class="text-center">#</th>
                    <th style="width: 12%;" class="text-center">Date</th>
                    <th style="width: 20%;">Student Profile</th>
                    <th style="width: 14%;">Type</th>
                    <th style="width: 18%;">Category</th>
                    <th style="width: 14%;" class="text-center">Amount</th>
                    <th style="width: 12%;" class="text-center">Due Month</th>
                    <th style="width: 14%;">Issued By</th>
                    <th style="width: 90px;" class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                    $count = 0;
                  @endphp
                  @forelse ($transactions as $recode)
                    @if ($recode->status != 'deleted')
                    <tr>
                      <td class="text-center font-weight-medium text-muted">{{ ++$count }}</td>
                      <td class="text-center text-xs text-muted">
                        {{ $recode->transaction_date }}
                      </td>
                      <td>
                        <div class="d-flex align-items-center gap-2">
                          <div class="erp-user-avatar" style="width: 26px; height: 26px; font-size: 10px;">
                            {{ strtoupper(substr($recode->student->name ?? 'ST', 0, 2)) }}
                          </div>
                          <span class="font-weight-semibold text-dark">{{ $recode->student->name ?? 'Student' }}</span>
                        </div>
                      </td>
                      <td>
                        <span class="badge badge-soft-primary">
                          {{ $recode->transaction_type }}
                        </span>
                      </td>
                      <td class="font-weight-medium text-dark">
                        {{ $recode->transaction->name ?? 'Fee' }}
                      </td>
                      <td class="text-center font-weight-bold text-dark">
                        Rs. {{ number_format($recode->amount) }}
                      </td>
                      <td class="text-center text-xs font-weight-medium text-secondary">
                        {{ Carbon::parse($recode->due_date)->format('M, Y') }}
                      </td>
                      <td class="text-xs text-muted">
                        <i class="fas fa-user-shield mr-1"></i> {{ $recode->issueBy->name ?? 'Admin' }}
                      </td>
                      <td class="text-center">
                        <div class="erp-action-btn-group">
                          <!-- Edit Button -->
                          <a href="{{ route('transaction.edit', ['id' => $recode->id]) }}" class="erp-action-btn edit" title="Edit Transaction">
                            <i class="fas fa-pen-to-square"></i>
                          </a>

                          <!-- Delete Button -->
                          <a href="{{ route('transaction.delete', ['id' => $recode->id]) }}" class="erp-action-btn delete" title="Delete Transaction" onclick="confirmDelete(event, '{{ route('transaction.delete', ['id' => $recode->id]) }}')">
                            <i class="fas fa-trash-can"></i>
                          </a>
                        </div>
                      </td>
                    </tr>
                    @endif
                  @empty
                  <tr>
                    <td colspan="9" class="text-center py-4 text-muted">
                      <i class="fas fa-receipt mb-2 text-xl d-block" style="font-size: 24px; color: #cbd5e1;"></i>
                      No student transaction records found. Click <strong>"Add New Transaction"</strong> to post billing.
                    </td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            <!-- Table Footer with Records Count and Pagination -->
            <div class="erp-table-footer">
              <div class="erp-table-info">
                Showing 1 to {{ count($transactions) }} of {{ count($transactions) }} records
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
        title: 'Delete Student Transaction?',
        text: "This action will remove this billing record from student accounts.",
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
            return document.getElementById('transactionsTable').innerText;
          }
        }).on('success', function () {
          Swal.fire({
            toast: true, position: 'top-end', icon: 'success',
            title: 'Transactions copied', showConfirmButton: false, timer: 2000
          });
        });
      }

      if (csvBtn) {
        csvBtn.addEventListener('click', function () {
          let csv = [];
          let rows = document.querySelectorAll('#transactionsTable tr');
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
          link.download = 'student_transactions.csv';
          link.click();
        });
      }

      if (excelBtn && window.XLSX) {
        excelBtn.addEventListener('click', function () {
          let table = document.getElementById('transactionsTable');
          let wb = XLSX.utils.table_to_book(table, { sheet: 'Transactions' });
          XLSX.writeFile(wb, 'student_transactions.xlsx');
        });
      }

      if (pdfBtn && window.jspdf) {
        pdfBtn.addEventListener('click', function () {
          const { jsPDF } = window.jspdf;
          let doc = new jsPDF('l', 'pt', 'a4');
          doc.text("School ERP - Student Fee Transactions", 40, 30);
          if (doc.autoTable) {
            doc.autoTable({
              html: '#transactionsTable',
              startY: 45,
              columns: [0, 1, 2, 3, 4, 5, 6, 7],
              theme: 'striped',
              headStyles: { fillColor: [79, 70, 229] }
            });
            doc.save('student_transactions.pdf');
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
