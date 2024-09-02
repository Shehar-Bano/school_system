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
                      <li class="breadcrumb-item"><a href="{{ route('transaction.view') }}">Student Payments</a></li>
                      <li class="breadcrumb-item"><a href="{{ route('transaction.view') }}">Transactions</a></li>
                      <li class="breadcrumb-item active" aria-current="page" style="color: rgb(180, 176, 176)">Add Transaction</li>
                    </ol>
                  </nav>
                </div>
                <h4 class="card-title mt-5">Add Transaction</h4>
                <div class="form-container">
                  <form action="{{ route('transaction.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                      <label for="class">Class</label>
                      <select class="form-control {{ $errors->has('class') ? 'is-invalid' : '' }}" id="class" name="class">
                        <option value="" disabled selected></option>
                        @foreach ($classes as $class)
                          <option value="{{ $class->id }}" {{ old('class') == $class->id ? 'selected' : '' }}>
                            {{ $class->name }}
                          </option>
                        @endforeach
                      </select>
                      @error('class')
                        <div class="invalid-feedback">{{ "Class is required." }}</div>
                      @enderror
                    </div>

                    <div class="form-group">
                      <label for="section">Section</label>
                      <select class="form-control {{ $errors->has('section') ? 'is-invalid' : '' }}" id="section" name="section">
                        <option value="" disabled selected></option>
                        @foreach ($sections as $section)
                          <option value="{{ $section->id }}" data-custom="{{ $section->classe_id }}" {{ old('section') == $section->id ? 'selected' : '' }}>
                            {{ $section->name }}
                          </option>
                        @endforeach
                      </select>
                      @error('section')
                        <div class="invalid-feedback">{{ "Section is required." }}</div>
                      @enderror
                    </div>

                    <div class="form-group">
                      <label for="student_id">Student</label>
                      <select class="form-control {{ $errors->has('student_id') ? 'is-invalid' : '' }}" id="employee_id" name="student_id">
                        <option value="" disabled selected></option>
                        @foreach ($students as $student)
                          <option value="{{ $student->id }}" data-class-id="{{ $student->class_id }}" data-section-id="{{ $student->section_id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                            {{ $student->name }}
                          </option>
                        @endforeach
                      </select>
                      @error('student_id')
                        <div class="invalid-feedback">{{ "Student is required." }}</div>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label for="transaction_id">Transaction</label>
                      <select class="form-control {{ $errors->has('student_id') ? 'is-invalid' : '' }}" id="transaction_id" name="transaction_id">
                        <option value="" disabled selected></option>
                        @foreach ($types as $type)
                          <option value="{{ $type->id }}"  {{ old('transaction_id') == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                          </option>
                        @endforeach
                      </select>
                      @error('transaction_id')
                        <div class="invalid-feedback">{{ "Student is required." }}</div>
                      @enderror
                    </div>


                    <div class="form-group">
                      <label for="transaction_type"> Type</label>
                      <select class="form-control {{ $errors->has('transaction_type') ? 'is-invalid' : '' }}" id="transaction_type" name="transaction_type">
                        <option value="" disabled selected></option>
                       <option value="fine" {{ old('transaction_type') == 'fine' ? 'selected' : '' }}>Fine</option>
                        <option value="scholarship" {{ old('transaction_type') == 'scholarship' ? 'selected' : '' }}>Scholarship</option>
                        <option value="grant" {{ old('transaction_type') == 'grant' ? 'selected' : '' }}>Grant</option>
                        <option value="fund" {{ old('transaction_type') == 'fund' ? 'selected' : '' }}>Fund</option>
                       </select>
                      @error('transaction_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>

                    <div class="form-group">
                      <label for="amount">Amount</label>
                      <input type="number" name="amount" id="amount" class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}">
                      @error('amount')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>

                    <div class="form-group">
                      <label for="description">Description</label>
                      <input type="text" name="description" id="description" class="form-control  {{ $errors->has('description') ? 'is-invalid' : '' }} ">
                      @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>

                    <!-- Transaction Date -->
                    <div class="form-group">
                      <label for="date">Transaction Date</label>
                      <input type="date" class="form-control {{ $errors->has('transaction_date') ? 'is-invalid' : '' }}" id="date" name="transaction_date" value="{{ old('transaction_date') }}">
                      @error('transaction_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>

                    <!-- Due Date -->
                    <div class="form-group">
                      <label for="due_date">Due Date</label>
                      <input type="date" class="form-control {{ $errors->has('due_date') ? 'is-invalid' : '' }}" id="due_date" name="due_date" value="{{ old('due_date') }}">
                      @error('due_date')
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
      </div>
      <!-- End Inner page -->
    </div>
  </div>

  @include('view-file.script')

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
 $(document).ready(function () {
  // Handle class change
  $('#class').on('change', function () {
    var selectedClassId = $(this).val();

    // Filter sections based on selected class
    $('#section option').hide();
    $('#section option[data-custom="' + selectedClassId + '"]').show();

    // Select the first visible section option
    $('#section').val($('#section option:visible:first').val());

    // Filter students based on selected class
    $('#employee_id option').hide();
    $('#employee_id option[data-class-id="' + selectedClassId + '"]').show();

    // Select the first visible student option
    $('#employee_id').val($('#employee_id option:visible:first').val());
  });

  // Handle section change
  $('#section').on('change', function () {
    var selectedClassId = $('#class').val();
    var selectedSectionId = $(this).val();

    // Filter students based on selected class and section
    $('#employee_id option').hide();
    $('#employee_id option[data-class-id="' + selectedClassId + '"][data-section-id="' + selectedSectionId + '"]').show();

    // Select the first visible student option
    $('#employee_id').val($('#employee_id option:visible:first').val());
  });

  // Initialize the selections
  $('#class').change();
});
   </script>

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
