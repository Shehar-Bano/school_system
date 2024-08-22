<!DOCTYPE html>
<html lang="en">

@include('view-file/head')

<body>
  <div class="container-scroller">
    @include('view-file/nav')
    <div class="container-fluid page-body-wrapper">
      @include('view-file/side-bar')
<div class="container-fluid">
      <div class="header my-5 ">
        <h4><i class="fas fa-clock"></i>Employee Attendance</h4>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('subject_show') }}">Attendence</a></li>
            <li class="breadcrumb-item"><a href="{{ route('employee_attendence') }}">Employees Attendace</a></li>
            <li class="breadcrumb-item active" aria-current="page" style="color: rgb(180, 176, 176)">Attendance</li>
          </ol>
        </nav>
      </div>
 
<!--  Row -->
<div class="row mt-5">

    
    <div class="col-md-3 mt-4 text-center">
        <div class="card border-0 shadow">
          <div class="card-body">
            <img src="{{ $employee->image_url }}" class="card-img-top rounded-circle mx-auto mt-4" alt="Employee Image" style="width: 150px; border: 5px solid #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
            <h5 class="card-title text-uppercase" style="font-size: 15px; font-weight: bold; margin-top: 10px;">{{ $employee->name }}</h5>
            <p class="text-muted" style="font-size: 12px; margin-bottom: 20px;">{{ $employee->designation->name }}</p>
            <ul class="list-group text-left">
              <li class="list-group-item py-2 border-bottom" style="font-size: 12px;">Gender: {{ $employee->gender }}</li>
              <li class="list-group-item py-2 border-bottom" style="font-size: 12px;">Date of Birth: {{ \Carbon\Carbon::parse($employee->dob)->format('d M Y') }}</li>
              <li class="list-group-item py-2" style="font-size: 12px;">Phone: {{ $employee->phone }}</li>
            </ul>
          </div>
        </div>
      </div>
      
    
      <div class="col-md-8  ">
        <h5 class="card-title" style="font-size: 16px; margin-bottom: 10px;">Attendance</h5>
        <table class="table table-bordered table-sm  " style="font-size: 12px; border-collapse: collapse;background-color:#9594d8;">
          <thead>
            <tr>
              <th style="width: 20px; font-size: 12px; background-color: #f7f7f7;">#</th>
              @for ($day = 1; $day <= 31; $day++)
                <th style="width: 20px; font-size: 12px; background-color: #f7f7f7;">{{ $day }}</th>
              @endfor
            </tr>
          </thead>
          <tbody>
            @foreach(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $month)
              <tr>
                <td style="width: 20px; font-size: 12px; background-color: #f7f7f7;">{{ $month }}</td>
                @for ($day = 1; $day <= 31; $day++)
                  @php
                    $status = isset($attendanceData[$month][$day]) ? $attendanceData[$month][$day] : 'N/A';
                  @endphp
                  <td class="text-center {{ strtolower($status) }}" style="width: 20px; font-size: 10px;">
                   
                    {{ $status }}
                  </td>
                @endfor
              </tr>
            @endforeach
          </tbody>
        </table>
        <div class="mt-2" style="font-size: 12px;">
          <p><strong>Total Present:</strong> {{ $totalPresent }},<strong>Total Late With Excuse: </strong>{{ $totalLateExcuse }}, <strong>Total Late: </strong>{{ $totalLate }},<strong> Total Absent: </strong>{{ $totalAbsent }},<strong> Total Leave: </strong>{{ $totalLeave }}</p>
        </div>
      </div>
   
    </div> 

    </div>
  
      
    </div>
</div>

  @include('view-file/script')
</body>

</html>
