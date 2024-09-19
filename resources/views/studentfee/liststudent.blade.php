<!DOCTYPE html>
<html lang="en">
  @php
  use Carbon\Carbon;
  use App\Models\StudentFee; // Add this line to import the model
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
        {{-- <div class="col-md-3">
          <label for="employee_id" class="form-label">Name</label>
          <select class="form-control {{ $errors->has('employee_id') ? 'is-invalid' : '' }}" id="employee_id" name="employee_id">
            <option value="">Select Employee</option>
            @foreach ($employees as $employee)
              <option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>
                {{ $employee->name }}
              </option>
            @endforeach
          </select>
        </div> --}}
        
      </div>
      <button type="submit" class="btn btn-primary">Filter</button>
    </form>
  </div>
  
</div>
<div class="card">
    <div class="card-body">
      <h4 class="card-title">Student Fee List</h4>
      <div class="table-responsive">
        <table class="table table-striped table-bordered text-center table-sm" id="studentFeeTable">
          <thead>
            <tr>
              <th>#</th>
              <th>Date</th>
              <th>Name</th>
              <th>Tuition Fee</th>
              <th>Fund</th>
              <th>Fine</th>
              <th>Exam Fee</th>
              <th>Total Fee</th>
              <th>Payment Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @php
                $count = 0;
                $totalFee=0;
            @endphp
          @foreach ($studentData as $data)
          <tr>
              <td>{{ ++$count }}</td>
              <td>{{ \Carbon\Carbon::parse($data['date'])->format('j, M Y') }}</td> <!-- Date -->
              <td>{{ $data['student']->name }}</td> <!-- Student's Name -->
              <td>{{ number_format($data['tuitionFee']) }} Rs/-</td> <!-- Tuition Fee -->
              <td>{{ number_format($data['totalFund']) }} Rs/-</td> <!-- Fund (non-fine transactions) -->
              <td>{{ number_format($data['totalFine']) }} Rs/-</td> <!-- Fine -->
              <td>{{ number_format($data['examFee']) }} Rs/-</td> <!-- Exam Fee -->
          
              <!-- Total Fee (Tuition + Fund + Fine + Exam) -->
              @php
                  $totalFee = $data['tuitionFee'] + $data['totalFine'] + $data['examFee'] - $data['totalFund'];
              @endphp
              <td>{{ number_format($totalFee) }} Rs/-</td> <!-- Total Fee -->
          
              <!-- Payment Status -->
              @if (!StudentFee::where('student_id', $data['student_id'])->exists())
                  <td><span class="badge badge-danger">Pending</span></td>
              @else
                  <td><span class="badge badge-success">Received</span></td>
              @endif
          
              <!-- Actions -->
              <td>
                  @if (!StudentFee::where('student_id', $data['student_id'])->exists())
                      <a href="{{ route('fee.receive', ['id' => $data['student_id'], 'total' => $totalFee]) }}" title='Confirm Receive' class="btn btn-sm btn-info">
                          <i class="fas fa-money-bill-1"></i>
                      </a>
                  @else
                      <button class="btn btn-sm btn-secondary" disabled title="Fee Already Paid">
                          <i class="fas fa-money-bill-1"></i>
                      </button>
                  @endif
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
