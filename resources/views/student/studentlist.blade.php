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
                  <i class="fas fa-user-graduate text-primary"></i>
                  Student Directory
                </h3>
                <p class="erp-table-subtitle">Manage active student admissions, registration numbers, classroom sections, and tuition fees</p>
              </div>

              <!-- Top Action: Add New Student Button -->
              <div>
                <a href="{{ route('student') }}" class="btn btn-sm btn-primary">
                  <i class="fas fa-user-plus mr-1"></i> Add New Student
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
              <div class="erp-filter-group">
                <div class="erp-input-icon-wrapper">
                  <i class="fas fa-search"></i>
                  <input type="text" id="filterStudentName" placeholder="Search student name..." autocomplete="off">
                </div>

                <div class="erp-input-icon-wrapper" style="width: 130px;">
                  <i class="fas fa-school"></i>
                  <input type="text" id="filterClass" placeholder="Filter class..." autocomplete="off">
                </div>

                <div class="erp-input-icon-wrapper" style="width: 130px;">
                  <i class="fas fa-layer-group"></i>
                  <input type="text" id="filterSection" placeholder="Filter section..." autocomplete="off">
                </div>

                <button type="button" id="btnFilterSearch" class="erp-btn-filter-action erp-btn-filter-primary">
                  <i class="fas fa-filter"></i> Search
                </button>

                <button type="button" id="btnFilterReset" class="erp-btn-filter-action erp-btn-filter-reset">
                  <i class="fas fa-rotate-left"></i> Reset
                </button>
              </div>
            </div>

            <!-- Table Responsive Container -->
            <div class="table-responsive">
              <table class="erp-table" id="studentsTable">
                <thead>
                  <tr>
                    <th style="width: 50px;" class="text-center">#</th>
                    <th style="width: 25%;">Student Profile</th>
                    <th style="width: 14%;" class="text-center">Registration No</th>
                    <th style="width: 14%;">Class</th>
                    <th style="width: 14%;">Section</th>
                    <th style="width: 14%;" class="text-center">Tuition Fee</th>
                    <th style="width: 10%;" class="text-center">Status</th>
                    <th style="width: 100px;" class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody id="studentsTableBody">
                  @php
                    $count = 0;
                  @endphp
                  @forelse ($students as $student)
                  <tr data-name="{{ strtolower($student->name) }}" data-class="{{ strtolower($student->class->name ?? '') }}" data-section="{{ strtolower($student->section->name ?? '') }}">
                    <td class="text-center font-weight-medium text-muted">{{ ++$count }}</td>
                    <td>
                      <div class="d-flex align-items-center gap-2">
                        @if($student->image && $student->image !== 'default.png')
                          <img src="{{ asset('storage/'. $student->image) }}" class="rounded-circle" style="width: 28px; height: 28px; object-fit: cover;" alt="avatar">
                        @else
                          <div class="erp-user-avatar" style="width: 28px; height: 28px; font-size: 10.5px;">
                            {{ strtoupper(substr($student->name, 0, 2)) }}
                          </div>
                        @endif
                        <div>
                          <span class="font-weight-semibold text-dark">{{ $student->name }}</span>
                          <small class="d-block text-muted" style="font-size: 10.5px;">{{ $student->email }}</small>
                        </div>
                      </div>
                    </td>
                    <td class="text-center">
                      <span class="erp-code-pill">{{ $student->registration ?? 'N/A' }}</span>
                    </td>
                    <td>
                      <span class="badge badge-soft-primary">
                        <i class="fas fa-school text-xs mr-1"></i> {{ $student->class->name ?? 'Unassigned' }}
                      </span>
                    </td>
                    <td>
                      <span class="badge badge-soft-purple">
                        <i class="fas fa-layer-group text-xs mr-1"></i> {{ $student->section->name ?? 'Section' }}
                      </span>
                    </td>
                    <td class="text-center font-weight-semibold text-dark">
                      Rs. {{ number_format($student->tution_fee ?? 0) }}
                    </td>
                    <td class="text-center">
                      <span class="badge badge-soft-success">
                        <span class="dot" style="width: 5px; height: 5px; border-radius: 50%; background-color: #10b981; display: inline-block;"></span>
                        {{ ucfirst($student->status ?? 'Active') }}
                      </span>
                    </td>
                    <td class="text-center">
                      <div class="erp-action-btn-group">
                        <!-- Edit Button -->
                        <a href="{{ route('student-edit', ['id' => $student->id]) }}" class="erp-action-btn edit" title="Edit Student">
                          <i class="fas fa-pen-to-square"></i>
                        </a>

                        <!-- Delete Button -->
                        <form id="delete-student-{{ $student->id }}" action="{{ route('student_delete', ['id' => $student->id]) }}" method="POST" style="display:inline;">
                          @csrf
                          @method('DELETE')
                          <button type="button" class="erp-action-btn delete" title="Delete Student" onclick="confirmDelete({{ $student->id }})">
                            <i class="fas fa-trash-can"></i>
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                  @empty
                  <tr id="emptyRow">
                    <td colspan="8" class="text-center py-4 text-muted">
                      <i class="fas fa-user-graduate mb-2 text-xl d-block" style="font-size: 24px; color: #cbd5e1;"></i>
                      No student records found. Click <strong>"Add New Student"</strong> to register admissions.
                    </td>
                  </tr>
                  @endforelse
                  <tr id="noResultsRow" style="display: none;">
                    <td colspan="8" class="text-center py-4 text-muted">
                      <i class="fas fa-magnifying-glass mb-2 text-xl d-block" style="font-size: 22px; color: #cbd5e1;"></i>
                      No matching students found.
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Table Footer with Records Count and Pagination -->
            <div class="erp-table-footer">
              <div class="erp-table-info" id="tableRecordInfo">
                Showing 1 to {{ count($students) }} of {{ count($students) }} students
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
    function confirmDelete(studentId) {
      Swal.fire({
        title: 'Delete Student?',
        text: "This action will permanently delete the student profile and academic record.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Yes, delete it',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById('delete-student-' + studentId).submit();
        }
      });
    }
  </script>

  <!-- Filter & Export Script -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const nameInput = document.getElementById('filterStudentName');
      const classInput = document.getElementById('filterClass');
      const sectionInput = document.getElementById('filterSection');
      const searchBtn = document.getElementById('btnFilterSearch');
      const resetBtn = document.getElementById('btnFilterReset');
      const tableRows = document.querySelectorAll('#studentsTableBody tr[data-name]');
      const noResultsRow = document.getElementById('noResultsRow');
      const infoText = document.getElementById('tableRecordInfo');
      const totalCount = tableRows.length;

      function filterTable() {
        const queryName = nameInput.value.trim().toLowerCase();
        const queryClass = classInput.value.trim().toLowerCase();
        const querySection = sectionInput.value.trim().toLowerCase();
        let visibleCount = 0;

        tableRows.forEach(row => {
          const rowName = row.getAttribute('data-name') || '';
          const rowClass = row.getAttribute('data-class') || '';
          const rowSection = row.getAttribute('data-section') || '';

          const matchName = !queryName || rowName.includes(queryName);
          const matchClass = !queryClass || rowClass.includes(queryClass);
          const matchSection = !querySection || rowSection.includes(querySection);

          if (matchName && matchClass && matchSection) {
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
      classInput.addEventListener('input', filterTable);
      sectionInput.addEventListener('input', filterTable);
      searchBtn.addEventListener('click', filterTable);

      resetBtn.addEventListener('click', function () {
        nameInput.value = '';
        classInput.value = '';
        sectionInput.value = '';
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
            return document.getElementById('studentsTable').innerText;
          }
        }).on('success', function () {
          Swal.fire({
            toast: true, position: 'top-end', icon: 'success',
            title: 'Students table copied', showConfirmButton: false, timer: 2000
          });
        });
      }

      if (csvBtn) {
        csvBtn.addEventListener('click', function () {
          let csv = [];
          let rows = document.querySelectorAll('#studentsTable tr:not(#noResultsRow)');
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
          link.download = 'students_list.csv';
          link.click();
        });
      }

      if (excelBtn && window.XLSX) {
        excelBtn.addEventListener('click', function () {
          let table = document.getElementById('studentsTable');
          let wb = XLSX.utils.table_to_book(table, { sheet: 'Students' });
          XLSX.writeFile(wb, 'students_list.xlsx');
        });
      }

      if (pdfBtn && window.jspdf) {
        pdfBtn.addEventListener('click', function () {
          const { jsPDF } = window.jspdf;
          let doc = new jsPDF('p', 'pt', 'a4');
          doc.text("School ERP - Student Directory", 40, 30);
          if (doc.autoTable) {
            doc.autoTable({
              html: '#studentsTable',
              startY: 45,
              columns: [0, 1, 2, 3, 4, 5, 6],
              theme: 'striped',
              headStyles: { fillColor: [79, 70, 229] }
            });
            doc.save('students_list.pdf');
          }
        });
      }
    });
  </script>
</body>
</html>
