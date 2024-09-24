@extends('employeeDashboard.employeeView.masterpage') 
@section('content')



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
      <!-- Inner-page -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="container">
            <!-- Add New Exam Button -->

            <!-- Filter Inputs -->
            <div class="mb-4">
              <div class="row">
                <div class="col-md-6">
                  <button id="copyButton" class="btn btn-light btn-outline-primary">Copy</button>
                  <button id="csvButton" class="btn btn-light btn-outline-primary">CSV</button>
                  <button id="excelButton" class="btn btn-light btn-outline-primary">Excel</button>
                  <button id="pdfButton" class="btn btn-light btn-outline-primary">PDF</button>
                </div>
                <div class="col-md-6">
                    <form id="searchForm" method="GET" action="" class="mb-4">
                        <div class="row">
                          <div class="col-md-4">
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
                          <div class="col-md-4">
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

                          <div class="col-md-4">
                            <div class="mt-1"></span>
                            <button type="submit" class="btn btn-primary">Search</button>
                          </div>
                        </div>
                      </form>
                </div>
              </div>
            </div>

            <!-- Exams Table -->
            <div class="card mt-5">
              <div class="card-body">
                <h4 class="card-title">Result</h4>
                <div class="table-responsive">
                  <table class="table table-striped table-bordered text-center">
                    <thead>
                      <tr>
                        <th>Sr.no</th>
                        <th>Student Name</th>
                        <th>Class</th>
                        <th>Section</th>
                        <th>View</th>
                      </tr>
                    </thead>
                    <tbody>
                        @php
                            $count = 0;
                        @endphp
                        @foreach ($students as $student)
                            <tr>
                                <td>{{ ++$count }}</td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->class->name }}</td>
                                <td>{{ $student->section->name }} , {{$student->section->classe->name}}</td>
                                <td>
                                    @php
                                        $examFound = false;
                                    @endphp
                                    @foreach ($exams as $exam)
                                        @if($exam->class_id == $student->class_id && $exam->section_id == $student->section_id)
                                            <a href="{{ route('employee.exam.result.viewResult', ['id' => $student->id]) }}" class="dropdown-item text-info" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @php
                                                $examFound = true;
                                                break; // Exit the loop once an exam is found
                                            @endphp
                                        @endif
                                    @endforeach

                                    @if (!$examFound)
                                    <a href="{{ route('not_Found') }}" class="dropdown-item text-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @endif
                                </td>
                            </tr>

                        @endforeach
                    </tbody>
                  </table>

                 
                <!-- Add a class to hide the table by default -->



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
    function filterTable(inputElement, columnIndex, suggestionListId) {
      const filter = inputElement.value.toLowerCase();
      const rows = document.querySelectorAll('#examsTable tbody tr');
      const suggestionList = document.getElementById(suggestionListId);
      suggestionList.innerHTML = '';
      let hasSuggestions = false;

      rows.forEach(row => {
        const cellText = row.querySelector(`td:nth-child(${columnIndex})`).textContent.toLowerCase();
        if (cellText.includes(filter)) {
          row.style.display = '';
          const suggestionItem = document.createElement('li');
          suggestionItem.className = 'list-group-item list-group-item-action';
          suggestionItem.textContent = cellText;
          suggestionItem.addEventListener('click', function() {
            inputElement.value = cellText;
            suggestionList.style.display = 'none';
            rows.forEach(r => {
              const name = r.querySelector(`td:nth-child(${columnIndex})`).textContent.toLowerCase();
              r.style.display = name === cellText ? '' : 'none';
            });
          });
          suggestionList.appendChild(suggestionItem);
          hasSuggestions = true;
        } else {
          row.style.display = 'none';
        }
      });

      suggestionList.style.display = hasSuggestions ? 'block' : 'none';
    }

    document.getElementById('filterClass').addEventListener('keyup', function() {
      filterTable(this, 3, 'classSuggestionList');
    });

    document.getElementById('filterSection').addEventListener('keyup', function() {
      filterTable(this, 4, 'sectionSuggestionList');
    });

    document.addEventListener('click', function(event) {
      ['filterClass', 'filterSection'].forEach(id => {
        const inputElement = document.getElementById(id);
        const suggestionList = document.getElementById(inputElement.nextElementSibling.id);
        if (!inputElement.contains(event.target)) {
          suggestionList.style.display = 'none';
        }
      });
    });

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
  {{-- ////////////////////////for print --}}
<script>
  document.getElementById('printResultBtn').addEventListener('click', function () {
  var printContents = document.getElementById('examsTable').outerHTML;
  var originalContents = document.body.innerHTML;
  document.body.innerHTML = printContents;
  window.print();
  document.body.innerHTML = originalContents;
});

</script>

  <!-- SweetAlert Error Message -->
  @if(session('message'))
  <script>
      Swal.fire({
          title: 'Error!',
          text: "{{ session('message') }}",
          icon: 'error',
          confirmButtonText: 'OK'
      });
  </script>
  @endif

    
@endsection