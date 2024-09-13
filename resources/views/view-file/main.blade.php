<style>
  #student-attendance-chart {
  width: 80px;
  height: 80px;
}
</style>
<div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-md-12 grid-margin">
          <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
              <h3 class="font-weight-bold">Welcome {{ Auth::user()->name }}!</h3>
              <h6 class="font-weight-normal mb-0">All systems are running smoothly!  </h6>
            </div>
            <div class="col-12 col-xl-4">
             <div class="justify-content-end d-flex">
              <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                 <i class="mdi mdi-calendar"></i> Today ({{ date('l, F j, Y') }})
                </button>

              </div>
             </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
          <div class="card tale-bg">
            <div class="card-people mt-auto">
              <img src="{{asset('assesst/images/dashboard/people.svg')}}" alt="people">
              <div class="weather-info">
                <div class="d-flex">
                  {{-- <div>
                    <h2 class="mb-0 font-weight-normal"><i class="icon-sun mr-2"></i>31<sup>C</sup></h2>
                  </div> --}}
                  <div class="ml-2">
                    <h4 class="location font-weight-normal">It's School Time</h4>
                    <h6 class="font-weight-normal">Let's go</h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 grid-margin transparent">
          <div class="row">
            <div class="col-md-6 mb-4 stretch-card transparent">
              <div class="card card-tale">
                <div class="card-body">
                  <p class="mb-4">Students</p>
                  <p class="fs-30 mb-2">{{  $students}}</p>

                </div>
              </div>
            </div>
            <div class="col-md-6 mb-4 stretch-card transparent">
              <div class="card card-dark-blue">
                <div class="card-body">
                  <p class="mb-4">Employee</p>
                  <p class="fs-30 mb-2">{{ $employee }}</p>

                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
              <div class="card card-light-blue">
                <div class="card-body">
                  <p class="mb-4">Income</p>
                  <p class="fs-30 mb-2">{{ number_format($income ).' Rs/-'}}</p>

                </div>
              </div>
            </div>
            <div class="col-md-6 stretch-card transparent">
              <div class="card card-light-danger">
                <div class="card-body">
                  <p class="mb-4">Expence</p>
                  <p class="fs-30 mb-2">{{ number_format($expence+$totalSalary ).' Rs/-'}}</p>

                </div>

              </div>
            </div>
            <div class="col-md-6 mb-4 mt-4 mb-lg-0 stretch-card transparent">
              <div class="card card-tale">
                <div class="card-body">
                  <p class="mb-4">Revenue</p>
                  <p class="fs-30 mb-2">{{ number_format($income-($expence+$totalSalary) ).' Rs/-'}}</p>

                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
      <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <p class="card-title">Revenue Details</p>
              <p class="font-weight-500">total expences and income</p>
              <div class="d-flex flex-wrap mb-5">
                <div class="mr-5 mt-3">
                  <p class="text-muted">Expences</p>
                  <h3 class="text-primary fs-30 font-weight-medium">{{ number_format($expence ).' Rs/-'}}</h3>
                </div>
                <div class="mr-5 mt-3">
                  <p class="text-muted">Salary</p>
                  <h3 class="text-primary fs-30 font-weight-medium">{{ number_format($totalSalary ).' Rs/-'}}</h3>
                </div>
                <div class="mr-5 mt-3">
                  <p class="text-muted">Income</p>
                  <h3 class="text-primary fs-30 font-weight-medium">{{ number_format($income ).' Rs/-'}}</h3>
                </div>
                <div class="mr-5 mt-3">
                  <p class="text-muted">Revenue</p>
                  @php
                      $revenue = $income - ($expence + $totalSalary);
                      $percentage = ($income > 0) ? ($revenue / $income) * 100 : 0; // Avoid division by zero
                  @endphp
                  <h3 class="text-primary fs-30 font-weight-medium">
                      {{ number_format($revenue) . ' Rs/-' }}
                  </h3>
                  <p class="text-muted">
                      {{ number_format($percentage, 2) . '%' }} of total income
                  </p>
              </div>
              </div>
              <canvas id="revenue-chart" width="400" height="200"></canvas>

            </div>
          </div>
        </div>

    </div>
    <div class="row">
      <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <p class="card-title">Employee Attendace</p>

            </div>
            <p class="font-weight-500">Employees Attendace Recode</p>
            <div id="sales-legend" class="chartjs-legend mt-4 mb-2"></div>
            <canvas id="employee-attendance-chart" width="100" height="100"></canvas>
          </div>
          <div>

          </div>
        </div>
      </div>
      <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <p class="card-title">Student Attendace</p>

            </div>
            <p class="font-weight-500">Student Attendace Recode</p>
            <div id="sales-legend" class="chartjs-legend mt-4 mb-2"></div>
            <canvas id="student-attendance-chart" style="width: 80px; height: 80px;"></canvas>
          </div>
        </div>
      </div>
    </div>


    <!-- partial:partials/_footer.html -->
    <footer class="footer">
        <div class="d-sm-flex justify-content-center justify-content-sm-between">
          <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2021.  Premium <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap admin template</a> from BootstrapDash. All rights reserved.</span>
          <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="ti-heart text-danger ml-1"></i></span>
        </div>
        <div class="d-sm-flex justify-content-center justify-content-sm-between">
          <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Distributed by <a href="https://www.themewagon.com/" target="_blank">Themewagon</a></span>
        </div>
      </footer>
    <!-- partial -->
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('revenue-chart').getContext('2d');

    const income = {{ $income }};
    const expenses = {{ $expence }};
    const salaries = {{ $totalSalary }};

    const revenueChart = new Chart(ctx, {
      type: 'line',  // or 'line', 'pie', etc.
      data: {
        labels: ['Income', 'Expenses', 'Salaries'],
        datasets: [{
          label: 'Amount in Rs/-',
          data: [income, expenses, salaries],
          backgroundColor: [
            'rgba(75, 192, 192, 0.2)',  // Income color
            'rgba(255, 99, 132, 0.2)',  // Expenses color
            'rgba(54, 162, 235, 0.2)'   // Salaries color
          ],
          borderColor: [
            'rgba(75, 192, 192, 1)',  // Income color
            'rgba(255, 99, 132, 1)',  // Expenses color
            'rgba(54, 162, 235, 1)'   // Salaries color
          ],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  });


 // Employee Attendance Chart
var ctx = document.getElementById('student-attendance-chart').getContext('2d');
var chart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: ['Present', 'Absent', 'Leave', 'Late', 'Excused Late'],
    datasets: [{
      label: 'Student Attendance',
      data: [
        {{ $studentAttendance->sum('present') }},
        {{ $studentAttendance->sum('absent') }},
        {{ $studentAttendance->sum('leave') }},
        {{ $studentAttendance->sum('late') }},
        {{ $studentAttendance->sum('excused_late') }}
      ],
      backgroundColor: [
        'green',
        'red',
        'yellow',
        'orange',
        '#D9913E'
      ],
      borderColor: [
        'green',
        'red',
        'yellow',
        'orange',
        '#D9913E'
      ],
      borderWidth: 1
    }]
  },
  options: {
    title: {
      display: true,
      text: 'Employee Attendance'
    }
  }
});


var ctx = document.getElementById('employee-attendance-chart').getContext('2d');
var chart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: ['Present', 'Absent', 'Leave', 'Late', 'Excused Late'],
    datasets: [{
      label: 'Employee Attendance',
      data: [
        {{ $employeeAttendance->sum('present') }},
        {{ $employeeAttendance->sum('absent') }},
        {{ $employeeAttendance->sum('leave') }},
        {{ $employeeAttendance->sum('late') }},
        {{ $employeeAttendance->sum('excused_late') }}
      ],
      backgroundColor: [
        'green',
        'red',
        'yellow',
        'orange',
        '#D9913E'
      ],
      borderColor: [
        'green',
        'red',
        'yellow',
        'orange',
        '#D9913E'
      ],
      borderWidth: 1
    }]
  },
  options: {
    title: {
      display: true,
      text: 'Student Attendance'
    }
  }
});

</script>
