<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f5f6fa;
            margin-top: 20px;
            font-family: Arial, sans-serif;
        }

        .table-container {
            padding: 20px;
            margin-top: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .table-container h3 {
            color: #4c42bc;
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .student-info h4, .student-info h5 {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .table-bordered thead th {
            background-color: #4c42bc;
            color: #ffffff;
            padding: 10px;
        }

        .table-bordered td {
            padding: 15px;
            vertical-align: middle;
        }

        .result-summary {
            text-align: right;
        }

        .result-summary p {
            font-size: 18px;
            font-weight: bold;
        }

        .result-summary .total-due {
            color: #dc3545;
        }

        .bg-light {
            background-color: #f0f0f0 !important;
        }

        .btn-primary {
            background-color: #4c42bc;
            border-color: #4c42bc;
            padding: 10px 20px;
        }

        .table-container table {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    @include('StudentDashboard.ViewFile.head')
    <div class="container-scroller">
        @include('StudentDashboard.ViewFile.nav')
        <div class="container-fluid page-body-wrapper">
            @include('StudentDashboard.ViewFile.sidebar')

            <div class="container">
                <div class="table-container">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <td colspan="2">
                                    <h3>Science Academy Girls High School Bhera</h3>
                                    <div class="student-info">
                                        <h4>Student Name: {{ $user->name }}</h4>
                                        <h5>Class: {{ $user->class->name }} ({{ $user->section->name }})</h5>
                                        <h5>Roll No: {{ $user->registration }}</h5>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <th>Description</th>
                                <th>Amount (Rs/-)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalAmount = 0;
                            @endphp

                            @foreach ($studentFees as $fee)
                                <tr>
                                    <td>{{ $fee['fee_type'] }}</td>
                                    <td class="text-center">{{ number_format($fee['amount']) }}</td>
                                </tr>
                                @php
                                    $totalAmount += $fee['amount'];
                                @endphp
                            @endforeach
                        </tbody>

                        <tfoot>
                            <tr class="bg-light">
                                <td colspan="2" class="text-right">
                                    <div class="result-summary mt-3">
                                        <p><strong>Total Amount:</strong> {{ number_format($totalAmount) }} Rs/-</p>
                                        @if ($scholarship != 0)
                                            <p><strong>Fund Amount:</strong> {{ number_format($scholarship) }} Rs/-</p>
                                        @endif
                                        <p class="total-due"><strong>Total Due:</strong> {{ number_format($totalDue) }} Rs/-</p>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>

                    {{-- Optional: Add button if needed --}}
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
