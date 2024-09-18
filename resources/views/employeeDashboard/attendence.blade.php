@extends('employeeDashboard.employeeView.masterpage')
@section('content')

      <div class="container-fluid">
        
        <!--  Row -->
        <div class="row mt-5">
          <div class="col-md-4 mt-4 text-center">
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
          <div class="col-md-8 p-5">
            <h5 class="mx-5">Attendance Summary:</h5>

            <canvas id="myChart" class="w-75 h-auto mx-5"></canvas>

          </div>

          <!-- Month and Year Filter Form -->
          <div class="col-md-12 mt-5">
            <h5 class="card-title" style="font-size: 16px; margin-bottom: 10px;">
              Attendance for {{ $months[$selectedMonth] }} {{ $selectedYear }}
            </h5>
            <form method="GET" action="{{ route('attendance.employee', $employee->id) }}" class="mb-3">
              <div class="row">
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

            <!-- Attendance Table -->
            <table class="table table-bordered table-sm" style="font-size: 12px; border-collapse: collapse;">
              <thead>
                <tr>
                  <th style="width: 15px; font-size: 12px; background-color: #f7f7f7;" class="text-center">Date</th>
                  @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $dayOfWeek)
                    <th style="width: 15px; font-size: 12px; background-color: #f7f7f7;" class="text-center">{{ $dayOfWeek }}</th>
                  @endforeach
                </tr>
              </thead>
              <tbody>
                @for ($day = 1; $day <= cal_days_in_month(CAL_GREGORIAN, $selectedMonth, $selectedYear); $day++)
                  <?php $date = $selectedYear . '-' . $selectedMonth . '-' . str_pad($day, 2, '0', STR_PAD_LEFT); ?>
                  <tr>
                    <td style="width: 15px; font-size: 12px; background-color: #f7f7f7;" class="text-center">{{ date('d/m/Y', strtotime($date)) }}</td>
                    @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $dayOfWeek)
                      @php
                        $status = isset($attendanceData[$dayOfWeek][$day]) ? $attendanceData[$dayOfWeek][$day] : '';
                      @endphp
                      <td class="text-center status-cell" style="width: 15px; font-size: 10px;">
                        {{ $status }}
                      </td>
                    @endforeach
                  </tr>
                @endfor
              </tbody>
            </table>

          </div>
        </div>

      </div>
    </div>

    @include('view-file/script')
  
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const statusCells = document.querySelectorAll('.status-cell');
      statusCells.forEach(cell => {
        const status = cell.textContent.trim();
        switch(status) {
          case 'P':
            cell.style.backgroundColor = '#2a9d13'; // Color for Present
            break;
          case 'A':
            cell.style.backgroundColor = '#dd0e0e'; // Color for Absent
            break;
          case 'L':
            cell.style.backgroundColor = 'orange'; // Color for Late
            break;
          case 'LV':
            cell.style.backgroundColor = 'yellow'; // Color for Leave
            break;
          case 'EL':
            cell.style.backgroundColor = 'coral'; // Color for Excused Late
            break;
          default:
            cell.style.backgroundColor = ''; 
        }
      });
    });

    //////////////////////CHART
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ['Present', 'Absent', 'Leave', 'Late', 'Excused Late'],
        datasets: [{
          label: '# of Votes',
          data: [{{ $totalPresent }}, {{ $totalAbsent }}, {{ $totalLeave }}, {{ $totalLate }}, {{ $totalLateExcuse }}],
          backgroundColor: [
            '#2a9d13',
            '#dd0e0e',
            'yellow',
            'orange',
            'coral'
          ],
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        animation: {
          animateScale: true,
          animateRotate: true
        }
      }
    });
  </script>

@endsection
