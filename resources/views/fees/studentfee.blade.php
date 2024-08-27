<!DOCTYPE html>
<html lang="en">
@include('view-file/head')
<head>
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
  <div class="container-scroller">
    @include('view-file/nav')
    <div class="container-fluid page-body-wrapper">
      @include('view-file/side-bar')
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="container mt-5">
            <div class="form-container">
                <div class="header">
                    <h4><i class="fas fa-pencil-alt"></i> Add Fees</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('fee') }}">Student Fees</a></li>
                            <li class="breadcrumb-item active" aria-current="page" style="color: rgb(180, 176, 176)">Add Marks</li>
                        </ol>
                    </nav>
                </div>
                <form class="mt-1" action="{{ route('student-fee-store') }}" method="POST">
                    @csrf


                    @if($students->isNotEmpty())
                    <div class="container-fluid bg-light mt-4 p-3" style="border-radius: 15px">
                        <div class="row">
                            <div class="col-md-4 px-5">
                                <label for="student">Student</label>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="obt_marks">Tution Fees</label>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="obt_marks">Exam Fees</label>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="obt_marks">Other Activity Fees</label>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="obt_marks">Due Date</label>
                            </div>
                        </div>

                        @foreach ($students as $student)
                        <div class="row">
                            <div class="col-md-4 px-5">
                                <input type="hidden" name="students[{{ $loop->index }}][student_id]" value="{{ $student->id }}">
                                <input type="text" class="form-control" value="{{ $student->name }}" disabled>
                            </div>
                            <div class="col-md-2 mb-3">
                                <input type="number" class="form-control" name="students[{{ $loop->index }}][fee]" required>
                            </div>
                            <div class="col-md-2 mb-3">
                                <input type="number" class="form-control" name="students[{{ $loop->index }}][exam_fee]]" required>
                            </div>
                            <div class="col-md-2 mb-3">
                                <input type="number" class="form-control" name="students[{{ $loop->index }}][other_activity_fee]]" required>
                            </div>
                            <div class="col-md-2 mb-3">
                                <input type="date" class="form-control" name="students[{{ $loop->index }}][due_date]]" required>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary mt-3">Add fees</button>
                    </div>
                </form>

            </div>





          </div>

        </div>
      </div>
    </div>

  </div>

  @include('view-file/script')

  @if (session('alert'))
  <script>
      Swal.fire({
          icon: 'warning',
          title: 'Warning',
          text: '{{ session('alert') }}',
      });
  </script>
@endif

@if (session('message'))
  <script>
      Swal.fire({
          icon: 'success',
          title: 'Success',
          text: '{{ session('message') }}',
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
</body>
</html>

