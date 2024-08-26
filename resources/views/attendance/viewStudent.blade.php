<!DOCTYPE html>
<html lang="en">
<?php use Carbon\Carbon; ?>
@include('view-file/head')
<style>
  .dropdown-toggle::after {
    display: none;
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
          <div class="container">
            <!-- Add New TimeTable Button -->
            <div class="mb-4">
              <a href="{{ route('students_class') }}" class="btn btn-primary">Add new attendance</a>
            </div>
            <!-- Buttons for Exporting and Copying -->
            <div class="mb-3 row">
              <div class="col-6">
                <button id="copyButton" class="btn btn-light btn-outline-primary">Copy</button>
                <button id="csvButton" class="btn btn-light btn-outline-primary">CSV</button>
                <button id="excelButton" class="btn btn-light btn-outline-primary">Excel</button>
                <button id="pdfButton" class="btn btn-light btn-outline-primary">PDF</button>
              </div>
            </div>

            <!-- Search Form -->
            <form id="searchForm" method="GET" action="{{ route('students_attendence') }}" class="mb-4">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="class">Class</label>
                    <select name="class" id="class" class="form-control">
                      <option value="">Select Class</option>
                      @foreach ($classes as $class)
                        <option value="{{ $class->id }}" {{ $class->id == request()->query('class') ? 'selected' : '' }}>
                          {{ $class->name }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                </div>
                 <div class="col-md-3">
                  <div class="form-group">
                    <label for="section">Section</label>
                    <select name="section" id="section" class="form-control">
                      <option value="">Select Section</option>
                      @foreach ($sections as $section)
                        <option value="{{ $section->id }}" {{ $section->id == request()->query('section') ? 'selected' : '' }}>
                          {{ $section->name }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-3 mt-4">
                  <button type="submit" class="btn btn-primary">Search</button>
                </div>
              </div>
            </form>

            <!-- Time Table -->
            <!-- Table for Class, Section, and Students -->
<div class="card mt-4">
  <div class="card-body">
    <h4 class="card-title">Class and Student Information</h4>
    <div class="table-responsive">
      <table class="table table-bordered text-center">
        <thead>
          <tr>
            <th>#</th>
            <th>Class</th>
            <th>Section</th>
            <th>Teacher</th>
            <th>Students</th>
          </tr>
        </thead>
        <tbody>
          @php
            $serialNumber = 1;
          @endphp
          @foreach ($sections as $section)
          <tr>
            <td>{{ $serialNumber++ }}</td>
            <td>{{ $section->classe->name }}</td> <!-- Assuming there is a relation to Class model -->
            <td>{{ $section->name }}</td> <!-- Assuming there is a relation to Section model -->
            <td>{{ $section->employee->name }}</td>
            <td>
              <a href="javascript:void(0);" class="toggle-details" data-target="#details-{{ $section->classe->id }}">
                <i class="fas fa-chevron-down"></i>
              </a>
            </td>
          </tr>
          <tr id="details-{{ $section->classe->id }}" class="details-row" style="display: none;">
            <td colspan="5">
              <div class="details-content">
                @php
                  $count=0;
                @endphp
               
               
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Student Attendance</h4>
                    <div class="table-responsive">
                      <div id="attendanceTable" class="mt-4">
                        <table class="table table-bordered text-center">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Student</th>
                              <th>Roll_No</th>
                              <th>Email</th>
                              <th>Attendance</th>
                            </tr>
                          </thead>
                          <tbody>
                     
                            @foreach ($students as $student)
                @if ($section->classe->id == $student->class_id && $section->id == $student->section_id)
                              <tr>
                                <td>{{ ++$count }}</td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->registration }}</td>
                                <td>{{ $student->email }}</td>
                                <td>
                                  <a href="{{ route('show_student_attendace', ['id' => $student->id]) }}" class="btn btn-info btn-sm" title="View">
                                    <i class="fas fa-eye"></i>
                                  </a>
                                </td>
                              </tr>
                              
                              @endif
                  
                              @endforeach
                              @if($section->classe->id != $student->class_id || $section->id != $student->section_id)
                              <tr>
                                <td colspan="5">
                                There Is No Student For Class {{$section->classe->name  }} and Section {{ $section->name }}
                              </td>
                              </tr>
                              @endif
                          </tbody>
                        </table>
                      </div>
                      <!-- Pagination -->
                      <div class="mt-3">
                        {{ $students->links('pagination::bootstrap-5') }}
                      </div>
                    </div>
                  </div>
                </div>
            
              
              </div>
            </td>
          </tr>
          
          @endforeach
        </tbody>
      </table>
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

  <script>
    function confirmDelete(event, url) {
      event.preventDefault(); // Prevent the default action of the link

      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = url; // Redirect to the URL if confirmed
        }
      });
    }

    // Export and Copy Functionality
    document.addEventListener('DOMContentLoaded', function() {
      const copyButton = document.getElementById('copyButton');
      const csvButton = document.getElementById('csvButton');
      const excelButton = document.getElementById('excelButton');
      const pdfButton = document.getElementById('pdfButton');

      // Copy to Clipboard
      if (copyButton) {
        new ClipboardJS(copyButton, {
          text: function() {
            let table = document.getElementById('attendanceTable');
            return table.innerText; // Copy table content
          }
        });
      }

      // Export to CSV
      if (csvButton) {
        csvButton.addEventListener('click', function() {
          let csv = [];
          let rows = document.querySelectorAll('#attendanceTable tr');
          for (let i = 0; i < rows.length; i++) {
            let row = [];
            let cols = rows[i].querySelectorAll('td, th');
            for (let j = 0; j < cols.length; j++) {
              row.push(cols[j].innerText);
            }
            csv.push(row.join(','));
          }
          let csvFile = new Blob([csv.join('\n')], { type: 'text/csv' });
          let downloadLink = document.createElement('a');
          downloadLink.download = 'attendance.csv';
          downloadLink.href = window.URL.createObjectURL(csvFile);
          downloadLink.click();
        });
      }

      // Export to Excel
      if (excelButton) {
        excelButton.addEventListener('click', function() {
          let table = document.getElementById('attendanceTable');
          let wb = XLSX.utils.table_to_book(table, { sheet: 'Sheet1' });
          XLSX.writeFile(wb, 'attendance.xlsx');
        });
      }

      // Export to PDF
      if (pdfButton) {
        pdfButton.addEventListener('click', function() {
          const { jsPDF } = window.jspdf;
          let doc = new jsPDF();
          let table = document.getElementById('attendanceTable');
          doc.autoTable({ html: table });
          doc.save('attendance.pdf');
        });
      }
    });
  </script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const toggleLinks = document.querySelectorAll('.toggle-details');

    toggleLinks.forEach(link => {
      link.addEventListener('click', function () {
        const target = document.querySelector(this.dataset.target);
        if (target.style.display === "none") {
          target.style.display = "table-row";
        } else {
          target.style.display = "none";
        }
      });
    });
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
