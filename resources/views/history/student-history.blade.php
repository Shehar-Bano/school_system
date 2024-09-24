<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* Global font size reduction */
        body {
            font-size: 14px;
        }

        /* Custom styles for card headers */
        .card-header {
            padding: 1rem 1.5rem;
            font-size: 1.25rem;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        /* kiya chaiya */
        /* dekh rha kis tra ka hy code rangbranga ye kia hy mjy isy live run kr ky rdekhao konsy step hoty  */

        /* Table font size reduction */
        .table th, .table td {
            font-size: 0.9rem;
            padding: 0.75rem;
        }

        /* Button styling */
        .toggle-btn {
            background: none;
            border: none;
            color: white;
            font-size: 1.2rem;
        }

        /* Styling for the toggle icons */
        .toggle-btn i {
            transition: transform 0.2s ease;
        }

        /* Rotate the chevron when expanded */
        .collapse.show .toggle-btn i {
            transform: rotate(180deg);
        }
    </style>
</head>

@include('view-file/head')

<body>
    <div class="container-scroller">
        @include('view-file/nav')
        <div class="container-fluid page-body-wrapper">
            @include('view-file.side-bar')

            <div class="container mt-4">
                <h1 class="mb-4 text-center">Student History - <span class="text-primary">{{ $student->name }}</span></h1>

                <!-- Attendance History -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-info text-white">
                        Attendance History
                        <button class="toggle-btn" type="button" data-bs-toggle="collapse" data-bs-target="#attendanceHistory" aria-expanded="true" aria-controls="attendanceHistory">
                            <i class="bi bi-chevron-down"></i>
                        </button>
                    </div>
                    <div id="attendanceHistory" class="collapse show">
                        <div class="card-body">
                            <table class="table table-bordered table-hover table-striped">
                                <thead class="table">
                                    <tr>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($attendance as $att)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($att->date)->format('d-m-Y') }}</td>
                                        <td>{{ ucfirst($att->status) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Grades History -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-success text-white">
                        Grades History
                        <button class="toggle-btn" type="button" data-bs-toggle="collapse" data-bs-target="#gradesHistory" aria-expanded="false" aria-controls="gradesHistory">
                            <i class="bi bi-chevron-down"></i>
                        </button>
                    </div>
                    <div id="gradesHistory" class="collapse">
                        <div class="card-body">
                            <table class="table table-bordered table-hover table-striped">
                                <thead class="table">
                                    <tr>
                                        <th>Exam</th>
                                        <th>Subject</th>
                                        <th>Grade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($grades as $grade)
                                    <tr>
                                        <td>{{ $grade->exam->name }}</td>
                                        <td>{{ $grade->subject->subject_name }}</td>
                                        <td>{{ $grade->grade }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Payments History -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-warning text-white">
                        Payments History
                        <button class="toggle-btn" type="button" data-bs-toggle="collapse" data-bs-target="#paymentsHistory" aria-expanded="false" aria-controls="paymentsHistory">
                            <i class="bi bi-chevron-down"></i>
                        </button>
                    </div>
                    <div id="paymentsHistory" class="collapse">
                        <div class="card-body">
                            <table class="table table-bordered table-hover table-striped">
                                <thead class="table">
                                    <tr>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($payments as $payment)
                                    @if ($payment->student_id)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($payment->date)->format('d-m-Y') }}</td>
                                        <td>{{ number_format($payment->total, 2) }} USD</td>
                                        <td><span class="badge bg-success text-white">Paid</span></td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('view-file/script')
</body>

</html>
