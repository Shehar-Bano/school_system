<!DOCTYPE html>
<html lang="en">

@include('view-file/head')
<body>
  <div class="container-scroller">
    @include('view-file/nav')
    <div class="container-fluid page-body-wrapper">
      @include('view-file.side-bar')
<!--inner part-->
<div class="main-panel">
    <div class="content-wrapper">
      <div class="container">
        <!-- Add New Employee Form -->
        <div class="card">
          <div class="card-body">
            <div class="header">
                <h4><i class="fas fa-briefcase"></i> Designation</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                       
                        <li class="breadcrumb-item active" aria-current="page" style="color: rgb(180, 176, 176)">Designation</li>
                    </ol>
                </nav>
            </div>
            <h4 class="card-title mt-5">Add New Designation</h4>
            <div class="form-container">
               
              <form action="{{ route('designations_store') }}" method="POST" enctype="multipart/form-data">
                @csrf
            
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name" name="name" value="{{ old('name') }}">
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            
             <button type="submit" class="btn btn-primary">Save</button>
            </form>
          </div>
        </div>
      </div>
    </div>

  {{-- show --}}
  
    <div class="content-wrapper">
      <div class="container">
        <!-- Add New Employee Button -->
        
      <!-- Filter Inputs -->
<!-- Filter Inputs -->
<div class="my-5 row">
    <div class="col-md-4">
      <input type="text" id="filterName" class="form-control btn btn-light btn-outline-primary" placeholder="Filter by Name">
      <!-- Hidden Suggestion List -->
      <ul id="nameSuggestionList" class="list-group" style="display:none; position:absolute; z-index:1000;">
        <!-- Suggestions will be populated here dynamically -->
      </ul>
    </div>
  </div>
  
        <!-- Employees Table -->
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Designation List</h4>
            <div class="table-responsive">
              <table class="table table-striped table-bordered text-center" id="examsTable">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Designation</th>           
                  <th><i class="fa fa-ellipsis-h"></i></th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Example Row, you can dynamically generate rows using Blade templates -->
                  @php
                      $count=0;
                  @endphp
                  @foreach ($designations as $designation)
                  <tr>
                    <td>{{ ++$count }}</td>
                    <td>{{$designation->name  }}</td>
               <td>
                      <!-- Delete Button -->
                      <form id="delete-form-{{ $designation->id }}" action="{{ route('designation_delete', ['id' => $designation->id]) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger btn-sm" title="Delete" onclick="confirmDelete({{ $designation->id }})">
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
<!--inner part-->

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


    @if(session('message'))
      swal("Success!", "{{ session('message') }}", "success");
    @endif
  </script>
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
        const name = row.querySelector('td:nth-child(2)').textContent.toLowerCase(); // assuming name is in 2nd column
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
  </script>
</body>

</html>


