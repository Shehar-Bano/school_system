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
              <a href="{{ route('student') }}" class="btn btn-primary">Add New Student</a>
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
                  <!-- Hidden Suggestion List for Name -->
                  <ul id="nameSuggestionList" class="list-group" style="display:none; position:absolute; z-index:1000;">
                    <!-- Suggestions will be populated here dynamically -->
                  </ul>
                </div>
                <div class="col-md-2">
                  <input type="text" id="filterClass" class="form-control" placeholder="Filter by Class">
                  <!-- Hidden Suggestion List for Class -->
                  <ul id="classSuggestionList" class="list-group" style="display:none; position:absolute; z-index:1000;">
                    <!-- Suggestions will be populated here dynamically -->
                  </ul>
                </div>
                <div class="col-md-2">
                  <input type="text" id="filterSection" class="form-control" placeholder="Filter by Section">
                  <!-- Hidden Suggestion List for Section -->
                  <ul id="sectionSuggestionList" class="list-group" style="display:none; position:absolute; z-index:1000;">
                    <!-- Suggestions will be populated here dynamically -->
                  </ul>
                </div>
              </div>
            </div>

            <!-- Student Table -->
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Student List</h4>
                <div class="table-responsive">
                  <table class="table table-striped table-bordered " id="examsTable">
                    <thead>
                      <tr>
                        <th>Sr.no</th>
                        <th>Name</th>
                        <th>Class</th>
                        <th>Registration No</th>
                        <th>Section</th>
                        <th>Status</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        @php
                            $count=0;
                        @endphp
                        @foreach ($students as $student)
                        <tr>
                            <td>{{ ++$count }}</td>
                            <td><img src="{{asset('storage/'. $student->image)}}" style="width: 25px;height:25px">{{ $student->name }}</td>
                            <td> {{$student->class->name}}
                           </td>
                            <td>{{$student->registration}}</td>
                            <td> {{$student->section->name}}</td>
                            <td>{{ $student->status }}</td>
                            <td>
                                <!-- Edit Button -->
                                <a href="{{ route('student-edit', ['id' => $student->id]) }}" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('section_delete', ['id' => $student->id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
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
    // Filter by Class with Suggestions
    const filterClassInput = document.getElementById('filterClass');
    const classSuggestionList = document.getElementById('classSuggestionList');

    filterClassInput.addEventListener('keyup', function() {
      const filter = this.value.toLowerCase();
      const rows = document.querySelectorAll('#examsTable tbody tr');
      classSuggestionList.innerHTML = ''; // Clear previous suggestions
      let hasSuggestions = false;

      rows.forEach(row => {
        const className = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
        if (className.includes(filter)) {
          row.style.display = '';
          // Add suggestion to the list
          const suggestionItem = document.createElement('li');
          suggestionItem.className = 'list-group-item list-group-item-action';
          suggestionItem.textContent = className;
          suggestionItem.addEventListener('click', function() {
            filterClassInput.value = className;
            classSuggestionList.style.display = 'none';
            // Hide non-matching rows
            rows.forEach(r => {
              const cn = r.querySelector('td:nth-child(3)').textContent.toLowerCase();
              r.style.display = cn === className ? '' : 'none';
            });
          });
          classSuggestionList.appendChild(suggestionItem);
          hasSuggestions = true;
        } else {
          row.style.display = 'none';
        }
      });

      classSuggestionList.style.display = hasSuggestions ? 'block' : 'none';
    });

    // Filter by Section with Suggestions
    const filterSectionInput = document.getElementById('filterSection');
    const sectionSuggestionList = document.getElementById('sectionSuggestionList');

    filterSectionInput.addEventListener('keyup', function() {
      const filter = this.value.toLowerCase();
      const rows = document.querySelectorAll('#examsTable tbody tr');
      sectionSuggestionList.innerHTML = ''; // Clear previous suggestions
      let hasSuggestions = false;

      rows.forEach(row => {
        const sectionName = row.querySelector('td:nth-child(5)').textContent.toLowerCase();
        if (sectionName.includes(filter)) {
          row.style.display = '';
          // Add suggestion to the list
          const suggestionItem = document.createElement('li');
          suggestionItem.className = 'list-group-item list-group-item-action';
          suggestionItem.textContent = sectionName;
          suggestionItem.addEventListener('click', function() {
            filterSectionInput.value = sectionName;
            sectionSuggestionList.style.display = 'none';
            // Hide non-matching rows
            rows.forEach(r => {
              const sn = r.querySelector('td:nth-child(5)').textContent.toLowerCase();
              r.style.display = sn === sectionName ? '' : 'none';
            });
          });
          sectionSuggestionList.appendChild(suggestionItem);
          hasSuggestions = true;
        } else {
          row.style.display = 'none';
        }
      });

      sectionSuggestionList.style.display = hasSuggestions ? 'block' : 'none';
    });

    // Filter by Name with Suggestions
    const filterNameInput = document.getElementById('filterName');
    const nameSuggestionList = document.getElementById('nameSuggestionList');

    filterNameInput.addEventListener('keyup', function() {
      const filter = this.value.toLowerCase();
      const rows = document.querySelectorAll('#examsTable tbody tr');
      nameSuggestionList.innerHTML = ''; // Clear previous suggestions
      let hasSuggestions = false;

      rows.forEach(row => {
        const name = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
        if (name.includes(filter)) {
          row.style.display = '';
          // Add suggestion to the list
          const suggestionItem = document.createElement('li');
          suggestionItem.className = 'list-group-item list-group-item-action';
          suggestionItem.textContent = name;
          suggestionItem.addEventListener('click', function() {
            filterNameInput.value = name;
            nameSuggestionList.style.display = 'none';
            // Hide non-matching rows
            rows.forEach(r => {
              const n = r.querySelector('td:nth-child(2)').textContent.toLowerCase();
              r.style.display = n === name ? '' : 'none';
            });
          });
          nameSuggestionList.appendChild(suggestionItem);
          hasSuggestions = true;
        } else {
          row.style.display = 'none';
        }
      });

      nameSuggestionList.style.display = hasSuggestions ? 'block' : 'none';
    });

    // Hide suggestion lists when clicking outside
    document.addEventListener('click', function(event) {
      if (!filterNameInput.contains(event.target)) {
        nameSuggestionList.style.display = 'none';
      }
      if (!filterClassInput.contains(event.target)) {
        classSuggestionList.style.display = 'none';
      }
      if (!filterSectionInput.contains(event.target)) {
        sectionSuggestionList.style.display = 'none';
      }
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
</body>

</html>
