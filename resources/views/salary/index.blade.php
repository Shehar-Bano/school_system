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
              <a href="{{ route('salary.store') }}" class="btn btn-primary">Add New Salary</a>
            </div>
          <!-- Filter Inputs -->
<div class="mb-3 row">
  <div class="col-12 mt-5">
    <form action="{{ route('finance.salary') }}" method="get">
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
        
      </div>
      <button type="submit" class="btn btn-primary">Filter</button>
    </form>
  </div>
  
</div>
            <!-- Employees Table -->
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Employee Salary List</h4>
                <div class="table-responsive">
                  <table class="table table-striped table-bordered text-center table-sm" id="examsTable">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Month</th>
                        <th>Name</th>
                        <th>Base Salary</th>
                        <th>Bonus</th> 
                        <th>Deduction</th>                       
                        <th>Gross Salary</th>
                        <th>Net Salary</th>                                          
                        <th>status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php
                          $count = 0;
                      @endphp
                      @foreach ($calculatedSalaries as $salary)
                          <tr>
                              <td>{{ ++$count }}</td>
                              <td>{{ $salary['date'] }}</td>
                              <td>{{ $salary['employee_name'] }}</td>
                              <td>{{ number_format($salary['base_salary']) }} Rs/-</td>
                              <td>{{ number_format($salary['bonus']) }} {{ $salary['bonus'] ? 'Rs/-' : '' }}</td>
                              <td>{{ number_format($salary['deduction']) }} {{ $salary['deduction'] ? 'Rs/-' : '' }}</td>
                              <td>{{ number_format($salary['gross_salary']) }} Rs/-</td>
                              <td>{{ number_format($salary['net_salary']) }} Rs/-</td>
                              
                              @if ($salary['status'] == 'unpaid')
                                  <td><a class="btn btn-info btn-sm text-sm">{{ $salary['status'] }}</a></td>
                              @else
                                  <td><a class="btn btn-success btn-sm text-sm">{{ $salary['status'] }}</a></td>
                              @endif
                  
                              <td>
                                  @if ($salary['status'] == 'unpaid')
                                      <a href="{{ route('salary.pay', ['id' => $salary['id']]) }}" title='Pay Salary' class="btn btn-sm btn-info">
                                          <i class="fas fa-coins"></i>
                                      </a>
                                  @else
                                      <button class="btn btn-sm btn-secondary" disabled title="Salary Already Paid">
                                          <i class="fas fa-coins"></i>
                                      </button>
                                  @endif
                                  <a href="{{ route('salary.pdf', ['id' => $salary['employee_id']]) }}" class="btn btn-sm btn-warning" title='Print Receipt'>
                                      <i class="fas fa-print"></i>
                                  </a>
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
