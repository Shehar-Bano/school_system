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
            <!-- Add New Employee Button -->
            <div class="mb-4">
              <a href="{{ route('add_syllabus') }}" class="btn btn-primary">Add New Assignment</a>
            </div>
          <!-- Filter Inputs -->
<div class="mb-3 row">
  <div class="col-6">
    <button id="copyButton" class="btn btn-light btn-outline-primary">Copy</button>
    <button id="csvButton" class="btn btn-light btn-outline-primary">CSV</button>
    <button id="excelButton" class="btn btn-light btn-outline-primary">Excel</button>
    <button id="pdfButton" class="btn btn-light btn-outline-primary">PDF</button>
  </div>
  <div class="col-1 text-primary mt-2">
    Filter By:
  </div>
  <div class="col-md-2">
    
    <input type="text" id="filterName" class="form-control btn btn-light btn-outline-primary " placeholder=" Subject Name">
    <!-- Hidden Suggestion List -->
    <ul id="nameSuggestionList" class="list-group" style="display:none; position:absolute; z-index:1000;">
      <!-- Suggestions will be populated here dynamically -->
    </ul>
  </div>
  <div class="col-md-2">
    <input type="date" id="filterDate" class="form-control btn btn-light btn-outline-primary" placeholder="Filter Date">
  </div>
  </div>
 
</div>
            <!-- Employees Table -->
            <div class="card ">
              <div class="card-body">
                <h4 class="card-title">Assignment List</h4>
                <div class="table-responsive">
                  <table class="table table-striped table-bordered text-center table-sm" id="examsTable">
                    <thead >
                      <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Title</th>
                        <th>Description</th>
                         <th>Uploader</th>
                        <th>File</th>
                      
                            <th><i class="fa fa-ellipsis-h"></i></th>
                      </tr>
                    </thead>
                    <tbody>
                      <!-- Example Row, you can dynamically generate rows using Blade templates -->
                      @php
                          $count=0;
                      @endphp
                      @foreach ($assignments as $assignment)
                      <tr>
                        <td>{{ ++$count }}</td>
                        <td>{{$assignment->deadline }}</td>
                        <td>{{ $syllabus->title}}</td>
                        <td>{{$syllabus->description  }}</td>                      
                        <td>{{$syllabus->uploader }}</td>
                        <td>{{$syllabus->assignment }}</td>
                        
                        <td>
                          {{-- <button onclick="downloadFile('{{ $syllabus->file }}')" class="btn btn-info btn-sm" >  <i class="fas fa-download"></i></button>
                       --}}
                          <!-- Edit Button -->
                          <a href="{{ route('edit_syllabus',  ['id' => $assignment->id]) }}" class="btn btn-warning btn-sm" title="Edit">
                            <i class="fas fa-edit"></i>
                          </a>

                          <!-- Delete Button -->
                          <form id="delete-form-{{ $assignment->id }}" action="{{ route('syllabus_delete', ['id' => $assignment->id]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm" title="Delete" onclick="confirmDelete({{ $assignment->id }})">
                              <i class="fas fa-trash"></i>
                            </button>
                          </form>
                          
                        </td>
                      </tr>
                      @endforeach
                      
                      <!-- Add more rows here -->
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
  function downloadFile(file) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', `/download_file/${file}`, true);
    xhr.responseType = 'blob';
    xhr.onload = function() {
      if (xhr.status === 200) {
        const blob = xhr.response;
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = file;
        a.click();
      }
    };
    xhr.send();
  }
</script>
  <script>
    function confirmDelete(employeeId) {
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
          document.getElementById('delete-form-' + employeeId).submit();
        }
      })
    }

 
</script>
<script>
  // Filter by Date
  const filterDateInput = document.getElementById('filterDate');

  filterDateInput.addEventListener('change', function() {
    const filterDate = this.value;
    const rows = document.querySelectorAll('#examsTable tbody tr');

    if (filterDate) {
      rows.forEach(row => {
        const date = row.querySelector('td:nth-child(2)').textContent; // assuming date is in 2nd column
        const filterDateObj = new Date(filterDate);
        const dateObj = new Date(date);

        if (dateObj.toDateString() === filterDateObj.toDateString()) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });
    } else {
      // If filter date is cleared, show all rows
      rows.forEach(row => {
        row.style.display = '';
      });
    }
  });
</script>
 <!-- Filter and Suggestion Script -->
<script>
  // Filter by Name with Suggestions
  const filterNameInput = document.getElementById('filterName');
  const nameSuggestionList = document.getElementById('nameSuggestionList');

  filterNameInput.addEventListener('keyup', function() {
    const filter = this.value.toLowerCase();
    const rows = document.querySelectorAll('#examsTable tbody tr');
    nameSuggestionList.innerHTML = ''; // Clear previous suggestions
    let hasSuggestions = false;

    rows.forEach(row => {
      const name = row.querySelector('td:nth-child(2)').textContent.toLowerCase(); // assuming name is in 4th column
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

  // Hide suggestion list when clicking outside
  document.addEventListener('click', function(event) {
    if (!filterNameInput.contains(event.target)) {
      nameSuggestionList.style.display = 'none';
    }
  });

  // Filter by Designation with Suggestions
  const filterDesignationInput = document.getElementById('filterDesignation');
  const designationSuggestionList = document.getElementById('designationSuggestionList');

  filterDesignationInput.addEventListener('keyup', function() {
    const filter = this.value.toLowerCase();
    const rows = document.querySelectorAll('#examsTable tbody tr');
    designationSuggestionList.innerHTML = ''; // Clear previous suggestions
    let hasSuggestions = false;

    rows.forEach(row => {
      const designation = row.querySelector('td:nth-child(6)').textContent.toLowerCase(); // assuming designation is in 6th column
      if (designation.includes(filter)) {
        row.style.display = '';
        // Add suggestion to the list
        const suggestionItem = document.createElement('li');
        suggestionItem.className = 'list-group-item list-group-item-action';
        suggestionItem.textContent = designation;
        suggestionItem.addEventListener('click', function() {
          filterDesignationInput.value = designation;
          designationSuggestionList.style.display = 'none';
          // Hide non-matching rows
          rows.forEach(r => {
            const d = r.querySelector('td:nth-child(6)').textContent.toLowerCase();
            r.style.display = d === designation ? '' : 'none';
          });
        });
        designationSuggestionList.appendChild(suggestionItem);
        hasSuggestions = true;
      } else {
        row.style.display = 'none';
      }
    });

    designationSuggestionList.style.display = hasSuggestions ? 'block' : 'none';
  });

  // Hide suggestion list when clicking outside
  document.addEventListener('click', function(event) {
    if (!filterDesignationInput.contains(event.target)) {
      designationSuggestionList.style.display = 'none';
    }
  });
</script>
    <script>
      // Filter by ID
   
  
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
