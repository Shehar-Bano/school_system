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

        .student-info h4,
        .student-info h5 {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .table-responsive {
            max-width: 100%; /* Ensures the table doesn't overflow */
            overflow-x: auto; /* Adds horizontal scroll */
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
            margin-top: 20px;
        }

        .result-summary p {
            font-size: 18px;
            font-weight: bold;
        }

        .result-summary .total-due {
            color: #dc3545;
        }

        .btn-primary {
            background-color: #4c42bc;
            border-color: #4c42bc;
            padding: 10px 20px;
        }

        @media (max-width: 508px) {
            .table-container {
                padding: 10px;
            }
            .table-container h3 {
                font-size: 1.5rem;
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

            <div class="container">
                <div class="table-container m-5">
                    <div class="table-responsive ">
                        <table class="table table-bordered table-hover ">
                            <thead>
                                <tr>
                                    <td colspan="3">
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
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalAmount = 0;
                                @endphp

@if ($fee &&  $taxefee)
@foreach ($taxes as $tax)
<tr>
    <td>Bus Tax</td>
    <td class="text-center">{{ number_format($tax->bus_taxes) }}</td>
    <td>Paid</td>
</tr>
<tr>
    <td>Admission Fee</td>
    <td class="text-center">{{ number_format($tax->admission_fee) }}</td>
    <td>Paid</td>
</tr>
<tr>
    <td>Canteen Tax</td>
    <td class="text-center">{{ number_format($tax->lunch) }}</td>
    <td>Paid</td>
</tr>
<tr>
    <td>Library Tax</td>
    <td class="text-center">{{ number_format($tax->library_tax) }}</td>
    <td>Paid</td>
</tr>
<tr>
    <td>Other Activities</td>
    <td class="text-center">{{ number_format($tax->other_activity) }}</td>
    <td>Paid</td>
</tr>
<tr>
    <td>Other Fee</td>
    <td class="text-center">{{ number_format($fee->total) }}   </td>
    <td>Paid</td>
</tr>
@endforeach
@elseif ($fee)
@foreach ($taxes as $tax)
<tr>
    <td>Bus Tax</td>
    <td class="text-center">{{ number_format($tax->bus_taxes) }}</td>
    <td>Un-Paid</td>
</tr>
<tr>
    <td>Admission Fee</td>
    <td class="text-center">{{ number_format($tax->admission_fee) }}</td>
    <td>Un-Paid</td>
</tr>
<tr>
    <td>Canteen Tax</td>
    <td class="text-center">{{ number_format($tax->lunch) }}</td>
    <td>Un-Paid</td>
</tr>
<tr>
    <td>Library Tax</td>
    <td class="text-center">{{ number_format($tax->library_tax) }}</td>
    <td>Un-Paid</td>
</tr>
<tr>
    <td>Other Activities</td>
    <td class="text-center">{{ number_format($tax->other_activity) }}</td>
    <td>Un-Paid</td>
</tr>
<tr>
    <td>Other Fee</td>
    <td class="text-center">{{ number_format($fee->total) }}   </td>
    <td>Paid</td>
</tr>
@endforeach
@elseif ($taxefee)
@foreach ($taxes as $tax)
<tr>
    <td>Bus Tax</td>
    <td class="text-center">{{ number_format($tax->bus_taxes) }}</td>
    <td>Paid</td>
</tr>
<tr>
    <td>Admission Fee</td>
    <td class="text-center">{{ number_format($tax->admission_fee) }}</td>
    <td>Paid</td>
</tr>
<tr>
    <td>Canteen Tax</td>
    <td class="text-center">{{ number_format($tax->lunch) }}</td>
    <td>Paid</td>
</tr>
<tr>
    <td>Library Tax</td>
    <td class="text-center">{{ number_format($tax->library_tax) }}</td>
    <td>Paid</td>
</tr>
<tr>
    <td>Other Activities</td>
    <td class="text-center">{{ number_format($tax->other_activity) }}</td>
    <td>Paid</td>
</tr>
<tr>
    <td>Other Fee</td>
    <td class="text-center">{{ number_format($fee->total) }}   </td>
    <td>Un-Paid</td>
</tr>
@endforeach

                        @elseif (!$fee && !$taxefee)



                                @foreach ($taxes as $tax)
                                    <tr>
                                        <td>Bus Tax</td>
                                        <td class="text-center">{{ number_format($tax->bus_taxes) }}</td>
                                        <td>Un-Paid</td>
                                    </tr>
                                    <tr>
                                        <td>Admission Fee</td>
                                        <td class="text-center">{{ number_format($tax->admission_fee) }}</td>
                                        <td>Un-Paid</td>
                                    </tr>
                                    <tr>
                                        <td>Canteen Tax</td>
                                        <td class="text-center">{{ number_format($tax->lunch) }}</td>
                                        <td>Un-Paid</td>
                                    </tr>
                                    <tr>
                                        <td>Library Tax</td>
                                        <td class="text-center">{{ number_format($tax->library_tax) }}</td>
                                        <td>Un-Paid</td>
                                    </tr>
                                    <tr>
                                        <td>Other Activities</td>
                                        <td class="text-center">{{ number_format($tax->other_activity) }}</td>
                                        <td>Un-Paid</td>
                                    </tr>
                                    <tr>
                                        <td>Tuition Fee</td>
                                        <td class="text-center">{{ number_format($class->tution_fee) }}</td>
                                        <td>un-Paid</td>
                                    </tr>
                                    <tr>
                                        <td>Exam Fee</td>
                                        <td class="text-center">{{ number_format($exam->exam->exam_fee) }}</td>
                                        <td>un-Paid</td>
                                    </tr>


                                    @php
                                        $totalAmount += $tax->bus_taxes + $tax->admission_fee + $tax->lunch + $tax->library_tax + $tax->other_activity + $user->tution_fee + $exam->exam->exam_fee;
                                    @endphp
                                    @endforeach
                            </tbody>
                            @endif
                        </table>
                    </div>

                    <!-- Total Amount Display -->
                    <div class="result-summary">
                        <p>Total Amount Due: <span class="total-due">{{ number_format($totalAmount) }} Rs/-</span></p>
                    </div>
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
