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
      @include('view-file.side-bar')
      <div class="main-panel">
        <div class="content-wrapper">
      <div class="container mt-5">
        <div class="form-container">
            <div class="header">
                <h4><i class="fas fa-pencil-alt"></i> Exam</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('exam-list')}}">Exam</a></li>
                        <li class="breadcrumb-item active" aria-current="page" style="color: rgb(180, 176, 176)">Add Exam</li>
                    </ol>
                </nav>
            </div>

            <form class="mt-4" action="{{url('/exam')}}" method="POST" >
                @csrf
                <div class="mb-3">
                    <label for="examName" class="form-label">Exam Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="examName" name="name" placeholder="Enter exam name" required>
                </div>
                <div class="mb-3">
                    <label for="examDate" class="form-label">Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="date" id="examDate" required>
                </div>
                <div class="mb-3">
                    <label for="examNote" class="form-label">Note</label>
                    <textarea class="form-control" id="examNote" rows="3" name="note" placeholder="Enter any notes"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Add Exam</button>
            </form>
        </div>
    </div>
        </div>
      </div>
    </div>
  </div>
  @include('view-file.script')
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
<script>
    document.querySelector('form').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting

        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to submit the exam?",
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

@endif


</body>

</html>


