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
                  <h4><i class="fas fa-clock"></i>Student Attendance</h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                      <li class="breadcrumb-item"><a href="{{ route('students_attendence') }}">Attendance</a></li>
                      <li class="breadcrumb-item"><a href="{{ route('students_class') }}">Select Class</a></li>
                      <li class="breadcrumb-item active" aria-current="page" style="color: rgb(180, 176, 176)">Add Attendance</li>
                    </ol>
                  </nav>
                </div>
                <h4 class="card-title mt-5">Add New Attendance</h4>
                <div class="form-container ">
                  <div class="form-container">
                    <form action="{{ route('student_attendance_store') }}" method="POST">
                        @csrf
                        <div class="form-group ">
                            <label for="date">Date:</label>
                            <input type="date" name="date" id="date" class="form-control w-50" required>
                            <button type="button" id="toggleAttendance" class="btn btn-primary mt-3">Add Attendance</button>
                        
                        </div>
                        
                        <!-- Attendance Table -->
                        <div id="attendanceTable" class="mt-4" style="display: none;">
                            <table class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Student</th>
                                        <th>Roll_No</th>
                                        <th>Email</th>
                                        <th>Attendance</th>
                                     
                                    </tr>
                                </thead>
                                <tbody>
                                  @php
                                    $count=0;
                                  @endphp
                                    @foreach($students as $student)
                                    <tr>
                                        <td>{{ ++$count }}</td>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->registration }}</td>
                                        <td>{{ $student->email }}
                                          <input type="text" name="class" value={{ $student->class_id }} hidden>
                                          <input type="text" name="section" value={{ $student->section_id }} hidden></td>
                                        
                                            <input type="text" value={{ $student->section_id}} name="section" hidden>
                                        
                                        <td>
                                             <input type="radio" name="attendance[{{ $student->id }}]" value="present" > Present 
                                        
                                           <input type="radio" name="attendance[{{ $student->id }}]" value="absent">  Absent
                                       
                                            <input type="radio" name="attendance[{{ $student->id }}]" value="leave">  Leave
                                       
                                          <input type="radio" name="attendance[{{ $student->id }}]" value="late">   Late
                                       
                                           <input type="radio" name="attendance[{{ $student->id }}]" value="excused_late">  Excused Late
                                        </td>
                                        
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-success mt-3">Submit Attendance</button>
                        </div>
                    </form>
                  </div>                 
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
    document.getElementById('toggleAttendance').addEventListener('click', function() {
        var attendanceTable = document.getElementById('attendanceTable');
        if (attendanceTable.style.display === "none") {
            attendanceTable.style.display = "block";
        } else {
            attendanceTable.style.display = "none";
        }
    });
  </script>
  

  <script>
 

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
  @if(session('message'))
  <script>
      Swal.fire({
          title: 'Success!',
          text: "{{ session('sucsess') }}",
          icon: 'success',
          confirmButtonText: 'OK'
      });
  </script>
  @endif


</body>
</html>
