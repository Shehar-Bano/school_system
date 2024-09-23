<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            margin-top: 20px;
        }

        .receipt-main {
            background: #ffffff;
            border: 2px solid #dedede;
            margin-top: 50px;
            padding: 40px 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            color: #dc3545;
        }

        .receipt-header {
            margin-bottom: 30px;
        }

        .receipt-header h3 {
            font-size: 28px;
            font-weight: bold;
            text-align: center;
        }

        .receipt-main thead th {
            background-color: #4c42bc;
            color: #fff;
            text-align: center;
            padding: 10px;
        }

        .receipt-main td {
            padding: 10px;
            text-align: center;
        }

        .receipt-main td h2 {
            font-size: 20px;
            font-weight: bold;
        }

        .total-row td {
            font-size: 18px;
            font-weight: bold;
        }

        .total-row .text-danger {
            color: #dc3545 !important;
        }

        .search-form {
            background-color: #ffffff;
            border: 2px solid #dedede;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 8px;
        }

        .search-form select {
            border: 2px solid #ced4da;
            border-radius: 4px;
        }

        .search-form .btn-primary {
            border-radius: 4px;
            padding: 8px 20px;
            font-size: 16px;
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
                <!-- Search Form -->
                <div class="search-form  mt-3">
                    <form id="searchForm" method="GET" action="">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="exam">Select Exam</label>
                                    <select name="exam" id="exam" class="form-control">
                                        <option value="">Select Exam</option>
                                        <!-- Populate sections dynamically -->
                                        @foreach ($exams as $exam)
                                        <option value="{{ $exam->id }}" {{ $exam->id == request()->query('exam') ? 'selected' : '' }}>
                                            {{ $exam->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary btn-block">Search</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Result Card -->
                <div class="receipt-main">
                    <div class="receipt-header">
                        <h3>Student Result Card</h3>
                    </div>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Subject</th>
                                <th>Obtained Marks</th>
                                <th>Total Marks</th>
                                <th>Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $totalMarks = 0;
                            @endphp

                            @foreach($result as $res)
                            <tr>
                                <td>{{ $res->subject->subject_name }}</td>
                                <td>{{ $res->obt_marks }}</td>
                                <td>{{ $res->total }}</td>
                                <td>{{ $res->grade }}</td>
                            </tr>

                            @php
                            $totalMarks += $res->obt_marks
                            @endphp
                            @endforeach

                            <tr class="total-row">
                                <td colspan="3" class="text-right"><strong>Total Marks:</strong></td>
                                <td class="text-danger"><strong>{{ $totalMarks }}</strong></td>
                            </tr>
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
