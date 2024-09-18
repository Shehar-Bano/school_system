<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom Table Styling */
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th, td {
            padding: 8px;
            text-align: center;
            font-size: 14px;
        }

        th {
            background-color: #4536a0;
            color: #fff;
            font-weight: 600;
        }

        
        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            th, td {
                font-size: 12px;
            }
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
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                @foreach(['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $dayOfWeek)
                                    <th>{{ $dayOfWeek }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @for ($day = 1; $day <= cal_days_in_month(CAL_GREGORIAN, $selectedMonth, $selectedYear); $day++)
                                <?php $date = $selectedYear . '-' . $selectedMonth . '-' . str_pad($day, 2, '0', STR_PAD_LEFT); ?>
                                <tr>
                                    <td>{{ date('d/m/Y', strtotime($date)) }}</td>
                                    @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $dayOfWeek)
                                        @php
                                            $status = isset($attendanceData[$dayOfWeek][$day]) ? $attendanceData[$dayOfWeek][$day] : '';
                                            $statusClass = strtolower(str_replace(' ', '-', $status)); // Class for color coding
                                        @endphp
                                        <td class="status-cell {{ $statusClass }}">
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
    @include('StudentDashboard.ViewFile.script')
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
