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
              <a href="{{ route('employees_create') }}" class="btn btn-primary">Add New Employee</a>
            </div>
              <div class="mb-3">
                <button id="copyButton" class="btn btn-light btn-outline-primary">Copy</button>
                <button id="csvButton" class="btn btn-light btn-outline-primary">CSV</button>
                <button id="excelButton" class="btn btn-light btn-outline-primary">Excel</button>
                <button id="pdfButton" class="btn btn-light btn-outline-primary">PDF</button>
               </div>
            <!-- Employees Table -->
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Employees List</h4>
                <div class="table-responsive">
                  <table class="table table-striped table-bordered text-center">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                       
                                    <th><i class="fa fa-ellipsis-h"></i></th>
                      </tr>
                    </thead>
                    <tbody>
                      <!-- Example Row, you can dynamically generate rows using Blade templates -->
                      @php
                          $count=0;
                      @endphp
                      @foreach ($employees as $employee)
                      <tr>
                        <td>{{ ++$count }}</td>
                        <td>  <img src="{{ asset('storage/' . $employee->image) }}" alt="Employee Image" style="width: 100px; height: 100px;">
                        </td>
                        <td>{{$employee->name  }}</td>
                        <td>{{$employee->email }}</td>
                        <td>{{$employee->designation  }}</td>
                        <td><a class='btn btn-sm btn-success '>{{ $employee->status }}</a></td>
                      
                        <td>
                          <!-- View Button -->
                          <a href="{{ route('employees_show',['id' => $employee->id] ) }}" class="btn btn-info btn-sm" title="View">
                            <i class="fas fa-eye"></i>
                          </a>

                          <!-- Edit Button -->
                          <a href="{{ route('employees_edit',  ['id' => $employee->id]) }}" class="btn btn-warning btn-sm" title="Edit">
                            <i class="fas fa-edit"></i>
                          </a>

                          <!-- Delete Button -->
                          <form id="delete-form-{{ $employee->id }}" action="{{ route('employees_delete', ['id' => $employee->id]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm" title="Delete" onclick="confirmDelete({{ $employee->id }})">
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
      // Filter by ID
      document.getElementById('filterId').addEventListener('keyup', function() {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('#examsTable tbody tr');
        rows.forEach(row => {
          const id = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
          if (id.includes(filter)) {
            row.style.display = '';
          } else {
            row.style.display = 'none';
          }
        });
      });
  
      // Filter by Name with Suggestions
      const filterNameInput = document.getElementById('filterName');
      const suggestionList = document.getElementById('suggestionList');
  
      filterNameInput.addEventListener('keyup', function() {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('#examsTable tbody tr');
        suggestionList.innerHTML = ''; // Clear previous suggestions
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
              suggestionList.style.display = 'none';
              // Hide non-matching rows
              rows.forEach(r => {
                const n = r.querySelector('td:nth-child(2)').textContent.toLowerCase();
                r.style.display = n === name ? '' : 'none';
              });
            });
            suggestionList.appendChild(suggestionItem);
            hasSuggestions = true;
          } else {
            row.style.display = 'none';
          }
        });
  
        suggestionList.style.display = hasSuggestions ? 'block' : 'none';
      });
  
      // Hide suggestion list when clicking outside
      document.addEventListener('click', function(event) {
        if (!filterNameInput.contains(event.target)) {
          suggestionList.style.display = 'none';
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
