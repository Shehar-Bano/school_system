@extends('employeeDashboard.employeeView.masterpage') 

@section('content')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            border: 1px rgb(56, 56, 56);
            box-shadow: 0 2px 10px rgba(114, 114, 114, 0.1);
        }
        .header {
            background-color: #4B49AC;
            color: white;
            padding: 10px;
            border-radius: 8px 8px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h4 {
            margin: 0;
            display: flex;
            align-items: center;
        }
        .header h4 i {
            margin-right: 10px;
        }
        .header a {
            color: whitesmoke;
            text-decoration: none;
        }
    </style>
<
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="container mt-5">
            <div class="form-container">
                <div class="header">
                    <h4><i class="fas fa-pencil-alt"></i> Add Marks</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('employee.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('employee.exam.result') }}">Result</a></li>
                            <li class="breadcrumb-item active" aria-current="page" style="color: rgb(180, 176, 176)">Add Marks</li>
                        </ol>
                    </nav>
                </div>
             <form class="mt-1" action="{{ route('employee.exam.result.addstudent') }}" method="GET">
    @csrf

    <div class="row mt-3">
        <!-- Exam Name -->
        <div class="col-md-3 px-5">
            <label for="exam">Exam Name</label>
            <select class="form-control" name="exam" required>
                <option value="" disabled selected>Select Exam</option>
                @foreach ($exams as $exam)
                <option value="{{ $exam->id }}">{{ $exam->name }}</option>

                @endforeach
            </select>
        </div>

        <!-- Class Name -->
        <div class="col-md-3 mb-3">
            <label  for="class">Class Name</label>
            <select class="form-control" name="class" required>
                <option value="" disabled selected>Select Class</option>
                @foreach ($classe as $class)
                <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach

            </select>
        </div>

        <!-- Section Name -->
        <div class="col-md-3 mb-3">
            <label  for="section">Section Name</label>
            <select class="form-control" name="section" required>
                <option value="" disabled selected>Select Section</option>
                @foreach ($sections as $section)
                <option value="{{ $section->id }}">{{ $section->name }}, {{$section->classe->name}}</option>
                @endforeach

            </select>
        </div>
        <!-- Subject -->
        <div class="col-md-3 mb-3">
            <label  for="subject">Subject</label>
            <select class="form-control" name="subject" required>
                <option value="" disabled selected>Select Subject</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
                    @endforeach
            </select>
        </div>
    </div>
<div class="text-center">
    <button type="submit" class="btn btn-primary mt-3"> Add Marks </button>
</div>


</form>


            </div>
          </div>
        </div>
      </div>
    </div>

  </div>


  @if(session('message'))
  <script>
      Swal.fire({
          title: 'Success!',
          text: "{{ session('message') }}",
          icon: 'success',
          confirmButtonText: 'OK'
      });
  </script>
  @endif

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

  <script>
      document.querySelector('form').addEventListener('submit', function(event) {
          event.preventDefault(); // Prevent the form from submitting

          Swal.fire({
              title: 'Are you sure?',
              text: "Do you want to submit the exam schedule?",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, submit it!'
          }).then((result) => {
              if (result.isConfirmed) {
                  this.submit(); // Submit the form
              }
          });
      });
  </script>

@endsection