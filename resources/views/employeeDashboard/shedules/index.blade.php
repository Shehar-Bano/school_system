@extends('employeeDashboard.employeeView.masterpage') 
@section('content')
<!DOCTYPE html>
<html lang="en">
    <style>
        /* Add space between student results when printing */
        .d-none {
    display: none !important;
}

/* Show the table only during printing */
@media print {
    .d-none {
        display: block !important;
    }

    .d-print-block {
        display: block !important;
    }
}
      </style>

        <div class="content-wrapper">
          <div class="container">
            <!-- Add New Exam Button -->
            <div class="mb-4">
              <a href="{{ route('employee.exam.schedules.add') }}" class="btn btn-primary">Add New Schedule</a>


            </div>

            <!-- Filter Inputs -->
            <div class="mb-4">
                <div class="row">
                  <div class="col-md-4">
                    {{-- <button id="copyButton" class="btn btn-light btn-outline-primary">Copy</button>
                    <button id="csvButton" class="btn btn-light btn-outline-primary">CSV</button> --}}
                    <button id="excelButton" class="btn btn-light btn-outline-primary">Excel</button>
                    <button id="pdfButton" class="btn btn-light btn-outline-primary">PDF</button>
                  </div>
                  <div class="col-md-8">
                      <form id="searchForm" method="GET" action="" class="mb-4">
                          <div class="row">
                            <div class="col-md-3">
                              <div class="form-group">

                                <select name="class" id="class" class="form-control">
                                  <option value="">Select Section</option>

                                  <!-- Populate classes dynamically -->
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

                                <select name="section" id="section" class="form-control">
                                  <option value="">Select Section</option>
                                  <!-- Populate sections dynamically -->
                                  @foreach ($sections as $section)
                                    <option value="{{ $section->id }}"
                                        {{ $section->id == request()->query('section') ? 'selected' : '' }}>
                                        {{ $section->name }}, {{$section->classe->name}}
                                    </option>
                                  @endforeach
                                </select>
                              </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">

                                  <select name="exam" id="exam" class="form-control">
                                    <option value="">Select Section</option>
                                    <!-- Populate sections dynamically -->
                                    @foreach ($exams as $exam)
                                      <option value="{{ $exam->id }}"
                                          {{ $exam->id == request()->query('exam') ? 'selected' : '' }}>
                                          {{ $exam->name }}
                                      </option>
                                    @endforeach
                                  </select>
                                </div>
                              </div>

                            <div class="col-md-3">
                              <div class="mt-1"></span>
                              <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                          </div>
                        </form>
                  </div>
                </div>
              </div>

            <!-- Exams Table -->
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Exams List</h4>
                <div class="table-responsive" style=" overflow-x: visible; position: relative;">
                  <table class="table table-striped table-bordered text-center">
                    <thead>
                      <tr>
                        <th>Sr.no</th>
                        <th>Exam Name</th>
                        <th>Class</th>
                        <th>Section</th>
                        <th>Date</th>
                        <th>More</th>
                      </tr>
                    </thead>
                    <tbody>
                        @php
                            $count = 0;
                        @endphp
                      @foreach ($examschedules as $exam)
                      <tr>
                        <td>{{ ++$count }}</td>

                        <td>
                            {{ $exam->exam->name }}
                        </td>
                        <td>
                           {{$exam->class->name}}

                        </td>
                        <td>

                            {{$exam->section->name}}, {{$exam->section->classe->name}}

                        </td>
                        <td>{{ $exam->start_date }} to {{$exam->end_date}}</td>

                        <td>
                            <!-- Dropdown -->
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i> <!-- More options icon -->
                                    {{-- <span class="sr-only">Toggle Dropdown</span> --}}
                                </button>
                                <ul class="dropdown-menu" style=" inset: auto !important; right: 0 !important;top: 20px !important;">
                                    <!-- Add Button -->
                                    <li>

                                        <a class="dropdown-item text-primary" id="printResultBtn" title="Print" href="{{route('exam-result',['id'=>$exam->id])}}"> <i class="fas fa-print"></i> Print Result</a>


                                    </li>
                                    <li>
                                        <a href="{{ route('date-sheet',['id'=>$exam->id]) }}" class="dropdown-item text-primary" title="Add">
                                            <i class="fas fa-plus"></i> Add
                                        </a>
                                    </li>
                                    <!-- View Button -->
                                    <li>
                                        <a href="{{ route('date-sheet-list',['id' => $exam->id]) }}" class="dropdown-item text-info" title="View">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </li>
                                    <!-- Edit Button -->
                                    <li>
                                        <a href="{{ route('exam-schedule-edit', ['id' => $exam->id]) }}" class="dropdown-item text-warning" title="Edit">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    </li>
                                    <!-- Delete Button -->
                                    <li>
                                        <form action="{{ route('exam-schedule_delete', ['id' => $exam->id]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger" title="Delete">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </li>
                                </ul>
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
  
  <!-- Filter and Suggestion Script -->
  <script>
    // Function to filter table rows



    // Export functionalities
    document.addEventListener('DOMContentLoaded', function() {

      const excelButton = document.getElementById('excelButton');
      const pdfButton = document.getElementById('pdfButton');
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
  



@endsection