<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Calendar Styling */
        .table-bordered th {
            background-color: #4536a0;
            color: white;
        }

        .table-bordered td {
            height: 60px;
            vertical-align: middle;
            font-weight: bold;
            cursor: pointer;
        }

        /* Status Colors */
        .status-cell.present {
            background-color: #4CAF50; /* Green for present */
            color: white;
        }

        .status-cell.absent {
            background-color: #F44336; /* Red for absent */
            color: white;
        }

        .status-cell.leave {
            background-color: #FFEB3B; /* Yellow for leave */
            color: black;
        }

        .status-cell.excused-late {
            background-color: #FF9800; /* Orange for excused late */
            color: white;
        }
    </style>

</head>
<body>
    @include('StudentDashboard.ViewFile.head')
    <div class="container-scroller">
        @include('StudentDashboard.ViewFile.nav')
        <div class="container-fluid page-body-wrapper">
            @include('StudentDashboard.ViewFile.sidebar')

            <!-- Attendance Table -->
            <div>
                <h5 class="card-title m-4" style="font-size: 16px; margin-bottom: 10px;">
                    Attendance for {{ $months[$selectedMonth] }} {{ $selectedYear }}
                </h5>

                <!-- Month and Year Filter Form -->
                <form method="GET" action="{{ route('attendence.student', $user->id) }}" class="mb-3">
                    <div class="row m-3">
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
                <div class="table-responsive">
                    <table class="table table-bordered table-striped text-center">
                        <thead>
                            <tr>
                                <th colspan="7">{{ $months[$selectedMonth] }} {{ $selectedYear }}</th>
                            </tr>
                            <tr>
                                @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $dayOfWeek)
                                    <th>{{ $dayOfWeek }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $firstDayOfMonth = date('w', strtotime("$selectedYear-$selectedMonth-01"));
                                $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $selectedMonth, $selectedYear);
                                $currentDay = 1;
                            @endphp

                            <!-- Generate Calendar Rows -->
                            @for ($week = 0; $week < 6; $week++)
                            <tr>
                                @for ($day = 0; $day < 7; $day++)
                                    @if ($week === 0 && $day < $firstDayOfMonth || $currentDay > $daysInMonth)
                                        <td></td> <!-- Empty cell -->
                                    @else
                                        <?php
                                            $status = isset($attendanceData[$currentDay]) ? $attendanceData[$currentDay] : '';
                                            $statusClass = strtolower(str_replace(' ', '-', $status)); // Convert status to class
                                        ?>
                                        <td class="status-cell {{ $statusClass }}">
                                            {{ $currentDay }}
                                        </td>
                                        @php $currentDay++; @endphp
                                    @endif
                                @endfor
                            </tr>
                            @if ($currentDay > $daysInMonth)
                                @break
                            @endif
                        @endfor

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('StudentDashboard.ViewFile.script')
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
