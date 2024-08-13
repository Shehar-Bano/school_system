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
                <button class="btn btn-light btn-outline-primary">Copy</button>
                <button class="btn btn-light btn-outline-primary">Excel</button>
                <button class="btn btn-light btn-outline-primary">CSV</button>
                <button class="btn btn-light btn-outline-primary">PDF</button>
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
  
</body>

</html>
