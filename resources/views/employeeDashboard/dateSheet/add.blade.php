@extends('employeeDashboard.employeeView.masterpage')
@section('content')

    <!-- Include SweetAlert CDN -->
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
</head>
<body>
 
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="container mt-5">
            <div class="form-container">
                <div class="header">
                    <h4><i class="fas fa-pencil-alt"></i> Add Exam Schedule</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{route('employee.dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{route('employee.exam.schedules')}}">Exam Schedule</a></li>
                            <li class="breadcrumb-item active" aria-current="page" style="color: rgb(180, 176, 176)">Add Exam Subject</li>
                        </ol>
                    </nav>
                </div>
            <div class="row mt-4" >
            <div class="col-md-3 px-5">
                <label for="date" class="form-label">Subject <span class="text-danger">*</span></label>
            </div>
            <div class="col-md-3 mb-3">
                <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
            </div>
            <div class="col-md-3 mb-3">
                <label for="start_time" class="form-label">Start Time <span class="text-danger">*</span></label>
            </div>
            <div class="col-md-3 mb-3">
                <label for="end_time" class="form-label">End Time <span class="text-danger">*</span></label>
            </div>

              </div>
             <form class="mt-1" action="{{route('employee.exam.date-sheet.store', ['id' => $exam->id]) }}" method="POST">
    @csrf
    @foreach($subjects as $subject)
    <div class="row">
        <div class="col-md-3 px-5">
            <label class="form-control" for="subject">{{ $subject->subject_name }}</label>
            <input type="hidden" class="form-control" name="subjects[{{ $loop->index }}][subject_id]" value="{{ $subject->id }}" required>
        </div>

        <!-- Date Selection -->
        <div class="col-md-3 mb-3">
            <input type="date" class="form-control" name="subjects[{{ $loop->index }}][date]" required>
        </div>

        <!-- Start Time -->
        <div class="col-md-3 mb-3">
            <input type="time" class="form-control" name="subjects[{{ $loop->index }}][start_time]" required>
        </div>

        <!-- End Time -->
        <div class="col-md-3 mb-3">
            <input type="time" class="form-control" name="subjects[{{ $loop->index }}][end_time]" required>
        </div>
    </div>
    @endforeach
    <div class="text-center">
        <button type="submit" class="btn btn-primary">Add Exam Schedule</button>
    </div>

</form>


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