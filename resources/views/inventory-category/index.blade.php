<!DOCTYPE html>
<html lang="en">
@php
    use Carbon\Carbon;
@endphp

@include('view-file/head')

<body>
  <div class="container-scroller">
    @include('view-file/nav')
    <div class="container-fluid page-body-wrapper">
      @include('view-file.side-bar')
      
      <!-- Inner-page -->
      <div class="main-panel">
        <div class="content-wrapper">
          
<div class="mb-3 row">
  <div class="col-12 my-3 ">
    <div class="card">
        <div class="card-body">
        
          <h4 class="card-title mt-5">Add Categories</h4>
          <div class="form-container">
            <form action="{{ route('inventory.category.store') }}" method="POST">
              @csrf
  
                   
              <div class="form-group">
                <label for="description">Caregory</label>
                <input type="text" name="name" id="name" class="form-control  {{ $errors->has('name') ? 'is-invalid' : '' }} ">
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
  
</div>
            <!-- Employees Table -->
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Categories List</h4>
                <div class="table-responsive">
                  <table class="table table-striped table-bordered text-center" id="examsTable">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Actions</th>
                       
                      </tr>
                    </thead>
                    <tbody>
                       @php
                      
                          $count=0;
                      @endphp
                      @foreach ($categories as $recode)
                     @if($recode->status != 'deleted')
                       
                        <td>{{ ++$count }}</td>
                        <td>{{ $recode->name }}</td>
                        <td>
                        @if ($recode->status == 'active')
                        <span class="btn btn-sm btn-success">{{ $recode->status }}</span>
                        @elseif ($recode->status == 'inactive')
                        <span class="btn btn-sm btn-danger">{{ $recode->status }}</span>

                       @endif
                        <td>
                              @if ($recode->status== 'active')
                              <a class="btn btn-warning btn-sm" href="{{ route('inventory.catagory.changeStatus', ['id' => $recode->id]) }}" title="set to inactive"> <i class="fa-solid fa-times"></i> </a>
                              @else
                              <a class="btn btn-info btn-sm" href="{{ route('inventory.catagory.changeStatus', ['id' => $recode->id]) }}" title="set to active"> <i class="fa-solid fa-check"></i> </a>
                              @endif
                              <a class="btn btn-danger btn-sm" href="{{ route('inventory.catagory.delete', ['id' => $recode->id]) }}" title="Delete" onclick="confirmDelete(event, '{{ route('inventory.catagory.delete', ['id' => $recode->id]) }}')">
                                <i class="fas fa-trash"></i>  </a>
                            
                          
                        </td>
                        
                      </tr>
                
                      @endif
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
  <script>function confirmDelete(event, url) {
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

</script>
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
@if(session('success'))
<script>
  Swal.fire({
    title: 'Success!',
    text: "{{ session('success') }}",
    icon: 'success',
    confirmButtonText: 'OK'
  });
</script>
@endif

</body>

</html>
