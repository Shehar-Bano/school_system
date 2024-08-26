<!DOCTYPE html>
<html lang="en">
  <?php use Carbon\Carbon; ?>
@include('view-file/head')
<style>
  .dropdown-toggle::after{
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
              <a href="{{ route('timeTable_create') }}" class="btn btn-primary">Add New TimeTable</a>
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
            <form id="searchForm" method="GET" action="{{ route('timeTable') }}" class="mb-4">
              <div class="row">
                  <div class="col-md-3">
                      <div class="form-group">
                          <label for="class">Class</label>
                          <select name="class" id="class" class="form-control">
                              <option value="">Select Class</option>
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
                              <option value="">Select Teacher</option>
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
                      <button type="submit" class="btn btn-primary">Search</button>
                  </div>
              </div>
          </form>
          
            <!-- Time Table -->
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">TimeTable</h4>
                <div class="table-responsive">
                  <table class="table table-striped table-bordered text-center">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Class</th>
                        <th>Section</th>
                        <th>Subject</th>
                        <th>Teacher</th>
                        <th>Time</th>
                        <th>Slot Status</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    
                    <tbody>
                        @php
                            $count = 0;
                        @endphp
                        @foreach ($timetables as $timetable)
                        <tr>
                          <td>{{ ++$count }}</td>
                          <td>{{ $timetable->class->name }}</td>
                          <td>{{ $timetable->section->name }}</td>
                          <td>{{ $timetable->subject->subject_name }}</td>
                          <td>{{ $timetable->teacher->name }}</td>
                          <td>{{ Carbon::parse($timetable->start_time)->format('g:i A')}} - {{ Carbon::parse($timetable->end_time)->format('g:i A')}}</td>
                          <td class="mt-3">
                            @if($timetable->slot_status == 'allocated')
                                <span class="btn btn-success btn-xs">{{$timetable->slot_status}}</span>
                            @elseif ($timetable->slot_status == 'available')
                                <span class="btn btn-info btn-xs">{{$timetable->slot_status}}</span>
                            @else
                                <span class="btn btn-warning btn-xs">{{$timetable->slot_status}}</span>
                            @endif
                        </td>
                        
                          <td>
                            <!-- Bootstrap Dropdown -->
                            <div class="dropdown">
                              <button class="btn  dropdown-toggle" type="button" id="dropdownMenuButton{{ $timetable->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-ellipsis-v"></i>
                              </button>
                              <div class="dropdown-menu " aria-labelledby="dropdownMenuButton{{ $timetable->id }}">
                                <a class="dropdown-item text-warning" href="{{ route('timetable_edit', ['id' => $timetable->id]) }}" title="Edit"><i class="fas fa-edit"></i> Edit</a>
                                <a class="dropdown-item text-danger" href="{{ route('timetable_delete', ['id' => $timetable->id]) }}" title="Delete" onclick="confirmDelete(event, '{{ route('timetable_delete', ['id' => $timetable->id]) }}')">
                                  <i class="fas fa-trash"></i> Delete
                              </a>
                                @if($timetable->slot_status == 'allocated')
                                  <a class="dropdown-item text-info" href="{{ route('timetable_freeSlot', ['id' => $timetable->id]) }}" title="Free this time slot"><i class="fas fa-circle-notch"></i> Free Slot</a>
                                @else
                                  <a class="dropdown-item text-info" href="{{ route('timetable_occupySlot', ['id' => $timetable->id]) }}" title="Allocate this time slot"><i class="fas fa-unlock"></i> Allocate</a>
                                @endif
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
