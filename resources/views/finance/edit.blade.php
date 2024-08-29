<!DOCTYPE html>
<html lang="en">

@include('view-file/head')

<body>
  <div class="container-scroller">
    @include('view-file/nav')
    <div class="container-fluid page-body-wrapper">
      @include('view-file.side-bar')

      <!-- Inner page -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="container">
            <!-- Add New Employee Form -->
            <div class="card">
              <div class="card-body">
                <div class="header">
                  <h4><i class="fas fa-clock"></i> Transactions</h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                      <li class="breadcrumb-item"><a href="{{ route('finance') }}">Finance</a></li>
                      <li class="breadcrumb-item"><a href="{{ route('finance') }}">Finance Recode</a></li>
                      <li class="breadcrumb-item active" aria-current="page" style="color: rgb(180, 176, 176)">Update Transaction</li>
                    </ol>
                  </nav>
                </div>
                <h4 class="card-title mt-5">Update Transaction</h4>
                <div class="form-container">
                  <form action="{{ route('finance.update',['id'=>$recode->id]) }}" method="POST">
                    @csrf
               
                   
                    <div class="form-group">
                        <label for="employee_id">Employee</label>
                        <select class="form-control {{ $errors->has('employee_id') ? 'is-invalid' : '' }}" id="employee_id" name="employee_id">
                          <option value="" disabled selected></option>
                          @foreach ($employees as $employee)
                          
                            <option value="{{ $employee->id }}"  {{$recode->employee_id == $employee->id ? 'selected' : '' }}>
                              {{ $employee->name }}-{{ $employee->designation->name }}
                            </option>
                            
                          @endforeach
                        </select>
                        @error('employee_id')
                          <div class="invalid-feedback">{{ "Employee name is required. " }}</div>
                        @enderror
                      </div>
                      <div class="form-group">
                        <label for="transaction_type">Transaction Type</label>
                        <select class="form-control {{ $errors->has('transaction_type') ? 'is-invalid' : '' }}" id="transaction_type" name="transaction_type">
                          <option value="" disabled selected></option>
                          <option value="Late Penalty" {{$recode->transaction_type == 'Late Penalty' ? 'selected' : '' }}>Late Penalty</option>
                          <option value="Absentance Penalty" {{ $recode->transaction_type == 'Absentance Penalty' ? 'selected' : '' }}>Absentance Penalty</option>
                          <option value="Loan Repayment" {{ $recode->transaction_type == 'Loan Repayment' ? 'selected' : '' }}>Loan Repayment</option>
                          <option value="Performance Bonus" {{ $recode->transaction_type == 'Performance Bonus' ? 'selected' : '' }}>Performance Bonus</option>
                          <option value="Festival Bonus" {{ $recode->transaction_type == 'Festival Bonus' ? 'selected' : '' }}>Festival Bonus</option>
                          <option value="Duty Reward" {{ $recode->transaction_type == 'Duty Reward' ? 'selected' : '' }}>Exam Duty Reward</option>
                          <option value="Paper Checking Reward" {{ $recode->transaction_type == 'Paper Checking Reward' ? 'selected' : '' }}>Paper Checking Reward</option>
                        </select>
                        @error('transaction_type')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group">
                        <label for="amount">Amount</label>
                       <input type="number" name="amount" id="amount" class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" value="{{ $recode->amount }}">
                        @error('amount')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group">
                        <label for="description">Description</label>
                       <input type="text" name="description" id="description" class="form-control  {{ $errors->has('description') ? 'is-invalid' : '' }} " value="{{ $recode->description }}">
                        @error('description')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
 
                    <!-- Start Time -->
                    <div class="form-group">
                      <label for="date">Transaction Date</label>
                      <input type="date" class="form-control {{ $errors->has('transaction_date') ? 'is-invalid' : '' }}" id="date" name="transaction_date" value="{{ $recode->transaction_date }}">

                      @error('transaction_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="date">
                            Due Date</label>
                        <input type="date" class="form-control {{ $errors->has('due_date') ? 'is-invalid' : '' }}" id="date" name="due_date" value="{{ $recode->due_date }}">
  
                        @error('due_date')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                   
                    <button type="submit" class="btn btn-primary">Update</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- End Inner page -->
    </div>
  </div>

  @include('view-file.script')

  <script>
      document.addEventListener('DOMContentLoaded', function() {
        var dateInput = document.getElementById('date');
        var today = new Date().toISOString().split('T')[0];
        dateInput.value = today;
    });
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
