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
            <!-- Add New Exam Button -->

            <!-- Filter Inputs -->
            <div class="mb-4">
                <div class="row">
                  <div class="col-md-4">
                    <button id="excelButton" class="btn btn-light btn-outline-primary">Excel</button>
                    <button id="pdfButton" class="btn btn-light btn-outline-primary">PDF</button>
                  </div>
                </div>
                <div class="row">
                      <form id="searchForm" method="GET" action="" class="mb-4">
                          <div class="row mt-3 ml-2">
                            <div class="col-md-2">
                              <div class="form-group">

                                <select name="class" id="class" class="form-control">
                                  <option value="">class</option>

                                  <!-- Populate classes dynamically -->
                                  @foreach ($classes as $class)
                                    <option value="{{ $class->id }}"
                                        index="{{$class->id}}"
                                        {{ $class->id == request()->query('class') ? 'selected' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                  @endforeach
                                </select>
                              </div>
                            </div>
                            <div class="col-md-2">
                              <div class="form-group">

                                <select name="section" id="section" class="form-control">
                                  <option value="">Section</option>
                                  <!-- Populate sections dynamically -->
                                  @foreach ($sections as $section)
                                    <option value="{{ $section->id }}"
                                        class="ab ab{{$section->classe_id}}"
                                        {{ $section->id == request()->query('section') ? 'selected' : '' }}>
                                        {{ $section->name }}, {{$section->classe->name}}
                                    </option>
                                  @endforeach
                                </select>
                              </div>
                            </div>
                            <div class="col-md-3">
                                <input type="date" name="start_date" class="form-control" value="{{ request()->query('start_date') }}">
                            </div>
                            <div class="col-md-3">
                                <input type="date" name="end_date" class="form-control" value="{{ request()->query('end_date') }}">
                            </div>

                            <div class="col-md-2">
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
                <h4 class="card-title">Admission Report</h4>
                <div class="table-responsive" style=" overflow-x: visible; position: relative;">
                    <table id="admissionsTable" class="table table-striped table-bordered text-center">
                      <thead>
                      <tr>
                        <th>Sr.no</th>
                        <th>Student Name</th>
                        <th>Class</th>
                        <th>Section</th>
                        <th>Admission Date</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                        @php
                          $count = 0;
                          $totalStudent = 0;
                        @endphp
                        @foreach ($students as $student)
                        <tr>
                          <td>{{ ++$count }}</td>
                          <td>{{ $student->name }}</td>
                          <td>{{ $student->class->name }}</td>
                          <td>{{ $student->section->name }}, {{ $student->section->classe->name }}</td>
                          <td>{{ $student->created_at->format('Y-m-d') }}</td>
                          <td>{{ $student->status }}</td>
                        </tr>
                        @php
                          $totalStudent++;
                        @endphp
                        @endforeach
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="5"><strong>Total Students</strong></td>
                          <td><strong>{{ $totalStudent }}</strong></td>
                        </tr>
                      </tfoot>

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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>

  <!-- Filter and Suggestion Script -->
  <script>
  document.addEventListener('DOMContentLoaded', function() {
    const excelButton = document.getElementById('excelButton');
    const pdfButton = document.getElementById('pdfButton');

    // Export to Excel
    if (excelButton) {
        excelButton.addEventListener('click', function() {
            let table = document.getElementById('admissionsTable'); // Correct ID
            let wb = XLSX.utils.table_to_book(table, { sheet: 'Sheet1' });
            XLSX.writeFile(wb, 'admission_report.xlsx');
        });
    }

    // Export to PDF
    if (pdfButton) {
        pdfButton.addEventListener('click', function() {
            const { jsPDF } = window.jspdf;
            let doc = new jsPDF();
            let table = document.getElementById('admissionsTable'); // Correct ID
            doc.autoTable({ html: table });
            doc.save('admission_report.pdf');
        });
    }

});

 </script>
  <script>
    $(document).ready(function(){
        $('#class').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            var tutionFee = selectedOption.data('custom');
            $('#tution_fee').val(tutionFee);
            $('.ab').hide();
            $('.ab' + selectedOption.attr('index')).css('display', 'block');
        });
    });
</script>

</body>

</html>
