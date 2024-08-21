<!DOCTYPE html>
<html lang="en">
   
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
            <div class="mb-4">
              <a href="{{ route('exam-schedule') }}" class="btn btn-primary">Add New Schedule</a>


            </div>

            <!-- Filter Inputs -->
            <div class="mb-4">
              <div class="row">
                <div class="col-md-6">
                  <button id="copyButton" class="btn btn-light btn-outline-primary">Copy</button>
                  <button id="csvButton" class="btn btn-light btn-outline-primary">CSV</button>
                  <button id="excelButton" class="btn btn-light btn-outline-primary">Excel</button>
                  <button id="pdfButton" class="btn btn-light btn-outline-primary">PDF</button>
                </div>
                <div class="col-md-2">
                  <input type="text" id="filterName" class="form-control" placeholder="Filter by Name">
                  <!-- Hidden Suggestion List -->
                  <ul id="suggestionList" class="list-group" style="display:none; position:absolute; z-index:1000;">
                    <!-- Suggestions will be populated here dynamically -->
                  </ul>
                </div>

                <div class="col-md-2">
                  <input type="text" id="filterClass" class="form-control" placeholder="Filter by Class">
                </div>
                <div class="col-md-2">
                  <input type="text" id="filterSection" class="form-control" placeholder="Filter by Section">
                </div>
              </div>
            </div>

            <!-- Exams Table -->
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Exams List</h4>
                <div class="table-responsive" style=" overflow-x: visible; position: relative;">
                  <table class="table table-striped table-bordered text-center" id="examsTable">
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
                      @foreach ($exams as $exam)
                      <tr>
                        <td>{{ ++$count }}</td>
                        <td>{{ $exam->exam->name }}</td>
                        <td>{{$exam->class->name}}</td>
                        <td>{{$exam->section->name}}</td>
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
  @include('view-file.script')

  <!-- Filter and Suggestion Script -->
  <script>
    // Function to filter table rows
    function filterTable() {
      const filterName = document.getElementById('filterName').value.toLowerCase();
      const filterClass = document.getElementById('filterClass').value.toLowerCase();
      const filterSection = document.getElementById('filterSection').value.toLowerCase();

      const rows = document.querySelectorAll('#examsTable tbody tr');

      rows.forEach(row => {
        const name = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
        const className = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
        const sectionName = row.querySelector('td:nth-child(4)').textContent.toLowerCase();

        const nameMatch = name.includes(filterName);
        const classMatch = className.includes(filterClass);
        const sectionMatch = sectionName.includes(filterSection);

        // Debugging output to check if filters are working
        console.log({ name, className, sectionName, nameMatch, classMatch, sectionMatch });

        if (nameMatch && classMatch && sectionMatch) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });
    }

    // Attach event listeners to filter inputs
    document.getElementById('filterName').addEventListener('keyup', filterTable);
    document.getElementById('filterClass').addEventListener('keyup', filterTable);
    document.getElementById('filterSection').addEventListener('keyup', filterTable);

    // Hide suggestion list when clicking outside
    document.addEventListener('click', function(event) {
      const filterNameInput = document.getElementById('filterName');
      const suggestionList = document.getElementById('suggestionList');
      if (!filterNameInput.contains(event.target)) {
        suggestionList.style.display = 'none';
      }
    });

    // Export functionalities
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
