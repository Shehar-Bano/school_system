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
              <a href="{{ route('finance.create') }}" class="btn btn-primary">Add New Transaction</a>
            </div>
          <!-- Filter Inputs -->
<div class="mb-3 row">
  <div class="col-12 mt-5">
    <form action="{{ route('finance') }}" method="get">
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
          <label for="employee_id" class="form-label">Name</label>
          <select class="form-control {{ $errors->has('employee_id') ? 'is-invalid' : '' }}" id="employee_id" name="employee_id">
            <option value="">Select Employee</option>
            @foreach ($employees as $employee)
              <option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>
                {{ $employee->name }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3">
          <label for="transaction_type" class="form-label">Transaction Type</label>
          <select id="transaction_type" name="transaction_type" class="form-control">
            <option value="">Select Transaction Type</option>
            <option value="late_Penalty" {{ request('transaction_type') == 'late_Penalty' ? 'selected' : '' }}>Late Penalty</option>
            <option value="absentance_Penalty" {{ request('transaction_type') == 'absentance_Penalty' ? 'selected' : '' }}>Attendance Penalty</option>
            <option value="loan_Repayment" {{ request('transaction_type') == 'loan_Repayment' ? 'selected' : '' }}>Loan Repayment</option>
            <option value="performance_Bonus" {{ request('transaction_type') == 'performance_Bonus' ? 'selected' : '' }}>Performance Bonus</option>
            <option value="festival_Bonus" {{ request('transaction_type') == 'festival_Bonus' ? 'selected' : '' }}>Festival Bonus</option>
            <option value="duty_Reward" {{ request('transaction_type') == 'duty_Reward' ? 'selected' : '' }}>Exam Duty Reward</option>
            <option value="paperChinging_reward" {{ request('transaction_type') == 'paperChinging_reward' ? 'selected' : '' }}>Paper Checking Reward</option>
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
                  <table class="table table-striped table-bordered text-center" id="examsTable">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Transaction Type</th>
                        <th>Amount</th>
                        <th>Due_Month</th>
                       
                        <th><i class="fa fa-ellipsis-h"></i></th>
                      </tr>
                    </thead>
                    <tbody>
                       @php
                      
                          $count=0;
                      @endphp
                      @foreach ($recodes as $recode)
                      @if ($recode->status !='deleted')
                      <tr>
                       
                        <td>{{ ++$count }}</td>
                        <td>{{ $recode->transaction_date }}</td>
                       <td>{{ $recode->employee->name }}</td>
                       <td>{{ $recode->transaction_type }}</td>
                       <td>{{ $recode->amount }}</td>
                       <td>{{ Carbon::parse($recode->due_date)->format('M, Y') }}</td>
                        <td>

                              <a class="btn btn-warning btn-sm" href="{{ route('finance.edit', ['id' => $recode->id]) }}" title="Edit"><i class="fas fa-edit"></i> </a>
                              <a class="btn btn-danger btn-sm" href="{{ route('finance.delete', ['id' => $recode->id]) }}" title="Delete" onclick="confirmDelete(event, '{{ route('finance.delete', ['id' => $recode->id]) }}')">
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
  
</body>

</html>
