@extends('employeeDashboard.employeeView.masterpage') 
@section('content')

<div class="container-fluid">
  <!--  Row -->
  <div class="row mt-2">
    
    <div class="col-md-8 p-5">
      <h3 class="mx-5">Your Attendance:</h3>
      <div class="calendar mx-5">
        <!-- Month and Year Filter Form -->
        <form method="GET" action="{{ route('attendance.employee', $employee->id) }}" class="mb-3">
          <div class="row mb-4">
            <div class="col-md-4">
              <select name="month" class="form-control">
                @foreach($months as $key => $month)
                  <option value="{{ $key }}" {{ $key == $selectedMonth ? 'selected' : '' }}>
                    {{ $month }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="col-md-4">
              <select name="year" class="form-control">
                @for ($year = now()->year; $year >= 2000; $year--)
                  <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>
                    {{ $year }}
                  </option>
                @endfor
              </select>
            </div>
            <div class="col-md-4">
              <button type="submit" class="btn btn-primary">Filter</button>
            </div>
          </div>
        </form>

        <!-- Calendar Grid -->
        <div class="calendar-grid">
          @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $dayOfWeek)
            <div class="calendar-cell day-name">{{ $dayOfWeek }}</div>
          @endforeach
          @for ($day = 1; $day <= cal_days_in_month(CAL_GREGORIAN, $selectedMonth, $selectedYear); $day++)
            <?php $date = $selectedYear . '-' . $selectedMonth . '-' . str_pad($day, 2, '0', STR_PAD_LEFT); ?>
            <div class="calendar-cell">
              <div class="date">{{ $day }}</div>
              @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $dayOfWeek)
                @php
                  $status = isset($attendanceData[$dayOfWeek][$day]) ? $attendanceData[$dayOfWeek][$day] : '';
                @endphp
                <div class="status" data-status="{{ $status }}">
                  {{ $status }}
                </div>
              @endforeach
            </div>
          @endfor
        </div>
      </div>
    </div>
  </div>
</div>

@include('view-file/script')

<script>
  // Function to return color based on status
  function getStatusColor(status) {
    switch(status) {
      case 'P': return '#2a9d13'; // Present
      case 'A': return '#dd0e0e'; // Absent
      case 'L': return 'orange'; // Late
      case 'LV': return 'yellow'; // Leave
      case 'EL': return 'coral'; // Excused Late
      default: return ''; 
    }
  }

  // Call this function to colorize the calendar status
  document.addEventListener('DOMContentLoaded', function() {
    const statusElements = document.querySelectorAll('.status');
    statusElements.forEach(element => {
      const status = element.dataset.status.trim();
      element.style.backgroundColor = getStatusColor(status);
    });
  });
</script>
<style>
  .calendar {
    display: flex;
    flex-direction: column;
  }
  .calendar-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 1px;
  }
  .calendar-cell {
    padding: 15px; /* Increase padding to make the box larger */
    text-align: center;
    border: 1px solid #ddd;
    box-sizing: border-box;
    font-size: 14px; /* Adjust font size if needed */
    height: 80px; /* Set a fixed height for the boxes */
  }
  .day-name {
    font-weight: bold;
    background-color: #f7f7f7;
  }
  .status {
    height: 30px; /* Increase height of the status circle */
    width: 30px; /* Increase width of the status circle */
    border-radius: 50%;
    display: inline-block;
  }
</style>


@endsection
