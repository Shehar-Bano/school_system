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
        
          <h4 class="card-title mt-5">Add Transaction</h4>
          <div class="form-container">
            <form action="{{ route('transaction,type.store') }}" method="POST">
              @csrf
             
{{--           
                  <option value="Library Fine" {{ old('transaction_type') == 'Library Fine' ? 'selected' : '' }}>Library Fine</option>
                  <option value="Late Payment Fine" {{ old('transaction_type') == 'Late Payment Fine' ? 'selected' : '' }}>Late Payment Fine</option>
                  <option value="Disciplinary Fines" {{ old('transaction_type') == 'Disciplinary Fines' ? 'selected' : '' }}>Disciplinary Fines</option>
                  <option value="late submission of assignments" {{ old('transaction_type') == 'late submission of assignments' ? 'selected' : '' }}>late submission of assignments</option>
                  <option value="Transport Fine" {{ old('transaction_type') == 'Transport Fine' ? 'selected' : '' }}>Transport Fine</option>
                  <option value="Uniform Fine" {{ old('transaction_type') == 'Uniform Fine' ? 'selected' : '' }}>Uniform Fine</option>
                  <option value="Scholarship" {{ old('transaction_type') == 'Scholarship' ? 'selected' : '' }}>Scholarship</option>
                  <option value="Grant" {{ old('transaction_type') == 'Grant' ? 'selected' : '' }}>Grant</option>
                  <option value="Academic achievement awards" {{ old('transaction_type') == 'Academic achievement awards' ? 'selected' : '' }}>Academic achievement awards</option>
                  <option value="Awards for extracurricular achievements" {{ old('transaction_type') == 'Awards for extracurricular achievements' ? 'selected' : '' }}>Awards for extracurricular achievements</option>
                  <option value="Emergency Fund" {{ old('transaction_type') == 'Emergency Fund' ? 'selected' : '' }}>Emergency Fund</option>
                   --}}
                
                   
              <div class="form-group">
                <label for="description">Type</label>
                <input type="text" name="name" id="name" class="form-control  {{ $errors->has('name') ? 'is-invalid' : '' }} ">
                @error('name')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>


              <div class="form-group">
                <label for="description">Description</label>
                <input type="text" name="description" id="description" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}">
                @error('description')
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
                <h4 class="card-title">Transaction List</h4>
                <div class="table-responsive">
                  <table class="table table-striped table-bordered text-center" id="examsTable">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                       
                      </tr>
                    </thead>
                    <tbody>
                       @php
                      
                          $count=0;
                      @endphp
                      @foreach ($transactions as $recode)
                     
                       
                        <td>{{ ++$count }}</td>
                        <td>{{ $recode->name }}</td>
                        <td>{{ $recode->descrtiption }} </td>                      

                        <td>

                              <a class="btn btn-warning btn-sm" href="{{ route('transaction.edit', ['id' => $recode->id]) }}" title="Edit"><i class="fas fa-edit"></i> </a>
                              <a class="btn btn-danger btn-sm" href="{{ route('transaction.type.delete', ['id' => $recode->id]) }}" title="Delete" onclick="confirmDelete(event, '{{ route('transaction.type.delete', ['id' => $recode->id]) }}')">
                                <i class="fas fa-trash"></i>  </a>
                            
                          
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
