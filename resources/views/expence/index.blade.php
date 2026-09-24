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
                  <i class="fas fa-boxes-stacked text-primary"></i>
                  School Expenses & Logistics
                </h3>
                <p class="erp-table-subtitle">Track operational expenditures, utilities, stationery purchases, and inventory outflows</p>
              </div>

              <!-- Top Action: Add Expense Button -->
              <div>
                <a href="{{ route('inventory.expences.create') }}" class="btn btn-sm btn-primary">
                  <i class="fas fa-plus mr-1"></i> Add Expense
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
              <form action="{{ route('inventory.expences') }}" method="GET" class="m-0">
                <div class="erp-filter-group">
                  <input type="date" id="start_date" name="start_date" class="form-control" style="height: 34px; width: 125px; font-size: 11px;" value="{{ request('start_date') }}" title="Start Date">
                  <input type="date" id="end_date" name="end_date" class="form-control" style="height: 34px; width: 125px; font-size: 11px;" value="{{ request('end_date') }}" title="End Date">
                  
                  <select class="erp-filter-select" id="category_id" name="category_id" style="min-width: 130px;">
                    <option value="">All Categories</option>
                    @foreach ($categories as $category)
                      <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                      </option>
                    @endforeach
                  </select>

                  <select class="erp-filter-select" id="sub_category_id" name="sub_category_id" style="min-width: 130px;">
                    <option value="">All Sub-Categories</option>
                    @foreach ($sub_categories as $subCategory)
                      <option value="{{ $subCategory->id }}" {{ request('sub_category_id') == $subCategory->id ? 'selected' : '' }}>
                        {{ $subCategory->name }}
                      </option>
                    @endforeach
                  </select>

                  <button type="submit" class="erp-btn-filter-action erp-btn-filter-primary">
                    <i class="fas fa-filter"></i> Filter
                  </button>

                  <a href="{{ route('inventory.expences') }}" class="erp-btn-filter-action erp-btn-filter-reset text-decoration-none">
                    <i class="fas fa-rotate-left"></i> Reset
                  </a>
                </div>
              </form>
            </div>

            <!-- Table Responsive Container -->
            <div class="table-responsive">
              <table class="erp-table" id="expensesTable">
                <thead>
                  <tr>
                    <th style="width: 50px;" class="text-center">#</th>
                    <th style="width: 14%;" class="text-center">Date</th>
                    <th style="width: 18%;">Category</th>
                    <th style="width: 18%;">Sub-Category</th>
                    <th style="width: 16%;" class="text-center">Amount</th>
                    <th style="width: 25%;">Description</th>
                    <th style="width: 90px;" class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                    $count = 0;
                    $totalExpence = 0;
                  @endphp
                  @forelse ($expences as $recode)
                  @php
                    $totalExpence += $recode->amount;
                  @endphp
                  <tr>
                    <td class="text-center font-weight-medium text-muted">{{ ++$count }}</td>
                    <td class="text-center text-xs text-muted">
                      {{ $recode->date }}
                    </td>
                    <td>
                      <span class="badge badge-soft-primary font-weight-medium">
                        {{ $recode->category->name ?? 'Category' }}
                      </span>
                    </td>
                    <td>
                      <span class="badge badge-soft-purple font-weight-medium">
                        {{ $recode->sub_category->name ?? 'Sub' }}
                      </span>
                    </td>
                    <td class="text-center font-weight-bold text-danger">
                      Rs. {{ number_format($recode->amount) }}
                    </td>
                    <td class="text-muted text-xs">
                      {{ $recode->description ?? '—' }}
                    </td>
                    <td class="text-center">
                      <div class="erp-action-btn-group">
                        <!-- Edit Button -->
                        <a href="{{ route('inventory.expences.edit', ['id' => $recode->id]) }}" class="erp-action-btn edit" title="Edit Expense">
                          <i class="fas fa-pen-to-square"></i>
                        </a>

                        <!-- Delete Button -->
                        <a href="{{ route('inventory.expences.delete', ['id' => $recode->id]) }}" class="erp-action-btn delete" title="Delete Expense" onclick="confirmDelete(event, '{{ route('inventory.expences.delete', ['id' => $recode->id]) }}')">
                          <i class="fas fa-trash-can"></i>
                        </a>
                      </div>
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="7" class="text-center py-4 text-muted">
                      <i class="fas fa-boxes-stacked mb-2 text-xl d-block" style="font-size: 24px; color: #cbd5e1;"></i>
                      No expense records found. Click <strong>"Add Expense"</strong> to log an outflow.
                    </td>
                  </tr>
                  @endforelse
                </tbody>
                @if(count($expences) > 0)
                <tfoot>
                  <tr style="background-color: #f8fafc; border-top: 2px solid var(--erp-border);">
                    <td colspan="4" class="text-right font-weight-bold text-dark py-2 px-3">Total Page Expenses:</td>
                    <td class="text-center font-weight-bold text-danger py-2">Rs. {{ number_format($totalExpence) }}</td>
                    <td colspan="2"></td>
                  </tr>
                </tfoot>
                @endif
              </table>
            </div>

            <!-- Table Footer with Records Count and Pagination -->
            <div class="erp-table-footer">
              <div class="erp-table-info">
                Showing {{ count($expences) }} records
              </div>
              <div>
                {{ $expences->links('pagination::simple-bootstrap-4') }}
              </div>
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
        title: 'Delete Expense?',
        text: "This action will permanently delete this expense voucher.",
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
            return document.getElementById('expensesTable').innerText;
          }
        }).on('success', function () {
          Swal.fire({
            toast: true, position: 'top-end', icon: 'success',
            title: 'Expenses copied', showConfirmButton: false, timer: 2000
          });
        });
      }

      if (csvBtn) {
        csvBtn.addEventListener('click', function () {
          let csv = [];
          let rows = document.querySelectorAll('#expensesTable tr');
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
          link.download = 'expenses_list.csv';
          link.click();
        });
      }

      if (excelBtn && window.XLSX) {
        excelBtn.addEventListener('click', function () {
          let table = document.getElementById('expensesTable');
          let wb = XLSX.utils.table_to_book(table, { sheet: 'Expenses' });
          XLSX.writeFile(wb, 'expenses_list.xlsx');
        });
      }

      if (pdfBtn && window.jspdf) {
        pdfBtn.addEventListener('click', function () {
          const { jsPDF } = window.jspdf;
          let doc = new jsPDF('p', 'pt', 'a4');
          doc.text("School ERP - School Expenses List", 40, 30);
          if (doc.autoTable) {
            doc.autoTable({
              html: '#expensesTable',
              startY: 45,
              columns: [0, 1, 2, 3, 4, 5],
              theme: 'striped',
              headStyles: { fillColor: [79, 70, 229] }
            });
            doc.save('expenses_list.pdf');
          }
        });
      }
    });
  </script>

  @if(session('error'))
  <script>
    Swal.fire({
      title: 'Error!', text: "{{ session('error') }}", icon: 'error', confirmButtonText: 'OK'
    });
  </script>
  @endif

  @if(session('success'))
  <script>
    Swal.fire({
      title: 'Success!', text: "{{ session('success') }}", icon: 'success', confirmButtonText: 'OK'
    });
  </script>
  @endif
</body>
</html>
