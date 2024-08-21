<!DOCTYPE html>
<html lang="en">
  <?php use Carbon\Carbon; ?>
@include('view-file/head')

<body>
  <div class="container-scroller">
    @include('view-file/nav')
    <div class="container-fluid page-body-wrapper">
      @include('view-file.side-bar')

      <!-- Inner-page -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="container">
            <div class="header mb-5">
              <h4><i class="fas fa-clock"></i> TimeTable</h4>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                  <li class="breadcrumb-item"><a href="{{ route('subject_show') }}">Academic</a></li>
                  <li class="breadcrumb-item"><a href="{{ route('timeTable') }}">TimeTable</a></li>
                  <li class="breadcrumb-item active" aria-current="page" style="color: rgb(180, 176, 176)">Teacher TimeTable</li>
                </ol>
              </nav>
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
            <form id="searchForm" method="GET" action="{{ route('teacher_timeTable_show') }}" class="mb-4">
              <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                      <label for="class">Class</label>
                      <select name="class" id="class" class="form-control">
                        <option value="">Select Section</option>
                        @foreach ($classes as $class)
                          <option value="{{ $class->id }}" 
                              {{ $class->id == request()->query('class') ? 'selected' : '' }}>
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
                      <!-- Populate sections dynamically -->
                      @foreach ($sections as $section)
                        <option value="{{ $section->id }}" 
                            {{ $section->id == request()->query('section') ? 'selected' : '' }}>
                            {{ $section->name }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="teacher">Teacher</label>
                    <select name="teacher" id="teacher" class="form-control">
                   
                      <!-- Populate teachers dynamically -->
                      @foreach ($employees as $employee)
                        @if($employee->designation->name == "Teacher")
                          <option value="{{ $employee->id }}" 
                              {{ $employee->id == request()->query('teacher') ? 'selected' : '' }}>
                              {{ $employee->name }}
                          </option>
                        @endif
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-3 mt-4">
                  <div class="mt-1"></span>
                  <button type="submit" class="btn btn-primary">Search</button>
                </div>
              </div>
            </form>

            
<!-- Time Table -->
<div class="card">
    <div class="card-body">
      <h4 class="card-title">Teacher Time Table</h4>
      <div class="table-responsive">
        <table class="table table-striped table-bordered text-center" id="examsTable">
          <thead>
            <tr>
              <th>Time</th>
              @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                <th>{{ $day }}</th>
              @endforeach
            </tr>
          </thead>
          
          <tbody>
            @php
  // Sort the timetables by start_time in ascending order
  $sortedTimetables = $timetables->sortBy('start_time');
@endphp
            @foreach($sortedTimetables as $timetable)
           
          
                <tr>
                    <td>{{ Carbon::parse($timetable->start_time)->format('g:i A')}} - {{ Carbon::parse($timetable->end_time)->format('g:i A')}}</td>
                  @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                    <td>
                      @php
                   $dayTimetables = $timetables->where('day', $day)
                                     ->where('start_time', $timetable->start_time)
                                     ->where('end_time', $timetable->end_time);
    
         @endphp
                      @if($dayTimetables->isNotEmpty())
                        @foreach ($dayTimetables as $timetable)
                          <div class="timetable-entry">
                            <p><strong>Teacher</strong>{{ $timetable->teacher->name}}</p>
                            <p><strong>class:</strong> {{ $timetable->class->name }}</p>
                            <p><strong>Section:</strong> {{ $timetable->section->name }}</p>
                            <p><strong>Subject:</strong> {{ $timetable->subject->subject_name }}</p>
                          </div> <br>
                        @endforeach
                      @else
                        <p>N/A</p>
                      @endif
                    </td>
                  @endforeach
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
        </div>
      </div>
      <!-- End Inner-page -->
    </div>
  </div>

  @include('view-file.script')

  <script>
    function confirmDelete(timetableId) {
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
          document.getElementById('delete-form-' + timetableId).submit();
        }
      })
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
            let table = document.getElementById('examsTable');
            return table.innerText; // Copy table content
          }
        });
      }

      // Export to CSV
      if (csvButton) {
        csvButton.addEventListener('click', function() {
          let csv = [];
          let rows = document.querySelectorAll('#examsTable tr');
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
          downloadLink.download = 'exams.csv';
          downloadLink.href = window.URL.createObjectURL(csvFile);
          downloadLink.click();
        });
      }

      // Export to Excel
      if (excelButton) {
        excelButton.addEventListener('click', function() {
          let table = document.getElementById('examsTable');
          let wb = XLSX.utils.table_to_book(table, { sheet: 'Sheet1' });
          XLSX.writeFile(wb, 'exams.xlsx');
        });
      }

      // Export to PDF
      if (pdfButton) {
        pdfButton.addEventListener('click', function() {
          const { jsPDF } = window.jspdf;
          let doc = new jsPDF();
          let table = document.getElementById('examsTable');
          doc.autoTable({ html: table });
          doc.save('exams.pdf');
        });
      }
    });
  </script>
</body>
</html>
