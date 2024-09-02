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
          <div class="container">
            <!-- Add New Employee Button -->
            <div class="mb-4">
              <a href="{{ route('transaction.addView') }}" class="btn btn-primary">Add New Transaction</a>
            </div>
          <!-- Filter Inputs -->
<!-- Filter Inputs -->
<div class="mb-3 row">
  <div class="col-12 mt-5">
    <form action="{{ route('transaction.view') }}" method="get">
      <div class="mb-3 row">
        <div class="col-md-3">
          <label for="start_date" class="form-label">Start Date</label>
          <input type="date" id="start_date" name="start_date" class="form-control" value="{{ request('start_date') }}">
        </div>
        <div class="col-md-3">
          <label for="end_date" class="form-label">End Date</label>
          <input type="date" id="end_date" name="end_date" class="form-control" value="{{ request('end_date') }}">
        </div>
        <div class="col-md-3">
          <label for="category_id" class="form-label">Transaction Category</label>
          <select class="form-control {{ $errors->has('category_id') ? 'is-invalid' : '' }}" id="category_id" name="category_id">
            <option value="">Select category</option>
            @foreach ($transactionCategories as $category)
              <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
              </option>
            @endforeach
          </select>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Filter</button>
    </form>
  </div>
</div>
            <!-- Employees Table -->
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Transaction List</h4>
                <div class="table-responsive">
                  <table class="table table-striped table-bordered text-center table-sm" id="examsTable">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th> Student</th>                       
                        <th>Type</th>
                        <th>Transaction</th>                       
                        <th>Amount</th>
                        <th>Due Month</th>
                        <th>issued By</th>
                       
                        <th><i class="fa fa-ellipsis-h"></i></th>
                      </tr>
                    </thead>
                    <tbody>
                       @php
                      
                          $count=0;
                      @endphp
                      @foreach ($transactions as $recode)
                      @if ($recode->status !='deleted')
                      <tr>
                       
                        <td>{{ ++$count }}</td>
                        <td>{{ $recode->transaction_date }}</td>
                       <td>{{ $recode->student->name }}</td>
                       <td>{{ $recode->transaction_type }}</td>
                       <td>{{ $recode->transaction->name }}</td>
                       <td>{{ number_format($recode->amount) }} Rs/-</td>                      
                       <td>{{ Carbon::parse($recode->due_date)->format('M, Y') }}</td>
                       <td>{{ $recode->issueBy->name }}</td>
                        <td>

                              <a class="btn btn-warning btn-sm" href="{{ route('transaction.edit', ['id' => $recode->id]) }}" title="Edit"><i class="fas fa-edit"></i> </a>
                              <a class="btn btn-danger btn-sm" href="{{ route('transaction.delete', ['id' => $recode->id]) }}" title="Delete" onclick="confirmDelete(event, '{{ route('transaction.delete', ['id' => $recode->id]) }}')">
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
  <script>
    function confirmDelete(event, url) {
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
