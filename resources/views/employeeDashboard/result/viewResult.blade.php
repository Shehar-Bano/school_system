@extends('employeeDashboard.employeeView.masterpage') 
@section('content')
    <title>Student Result</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .student-info {
            text-align: center;
            margin-bottom: 20px;
        }
        .student-info img {
            border-radius: 50%;
            width: 100px;
            height: 100px;
        }
        .student-info .details {
            margin-top: 10px;
        }
        .result-table th, .result-table td {
            text-align: center;
            vertical-align: middle;
        }

        .result-summary {
    background-color: #f8f9fa;
    padding: 10px;
    border-radius: 5px;
    text-align: center;
}

.card {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border: none;
}
    </style>

@include('view-file/head')

          <div class="main-panel">
            <div class="content-wrapper">
              <div class="container">
                <!-- Add New Exam Button -->
                <div class="mb-4">
                    <div class="row">
                        <div class="col-md-6">
                            <form id="searchForm" method="GET" action="" class="mb-4 w-100">
                                <div class="form-group">
                                    <select name="exam" id="exam" class="form-control w-50">
                                        <option value="" disabled selected>Select Section</option>
                                        @foreach ($exams as $exam)
                                        <option value="{{ $exam->id }}" {{ $exam->id == request()->query('exam') ? 'selected' : '' }}>
                                            {{ $exam->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="student_id" value="{{ $student->id }}"> <!-- Hidden Student ID -->
                                    <button type="submit" class="btn btn-light btn-outline-primary mt-3">Search</button>
                                    <a class="btn btn-light btn-outline-primary mt-3"
                                    href="{{ route('result.card', ['student_id' => $student->id, 'exam' => request()->query('exam')]) }}">
                                    Result Card
                                 </a></div>

                                </div>
                            </div>
                          

                    </div>
                </div>
      <!-- Filter Input -->
<div class="container ">
<div class="row">
        <!-- Student Info -->
        <div class="card mb-4">
            <div class="card-body text-center">
                <img src="{{ asset('storage/' . $student->image) }}" class="rounded-circle" alt="Student Image">
                <h4 class="mt-2">{{ $student->name }}</h4>
                <p>Registration No: {{ $student->registration }}</p>
                <p>Class: {{ $student->class->name }}</p>
                <p>Section: {{ $student->section->name }}</p>
            </div>
        </div>
        <!-- Result Table -->
        <!-- Result Table -->
<div class="card ml-5">

    <div class="card-body">
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>Subject</th>
                    <th>Obtained Marks</th>
                    <th>Total Marks</th>
                    <th>Grade</th>
                </tr>
            </thead>
            <tbody>
                    @php
                       $totalmarks = 0;
                       $obt = 0;
                       $avg = 0;
                    @endphp
                    @foreach ($results as $result )
                    <tr class="bg-white">
                        <td>{{$result->subject->subject_name}}</td>
                        <td>{{$result->obt_marks}}</td>
                        <td>{{$result->total}}</td>
                        <td>{{$result->grade}}</td>
                    </tr>
                    @php
                        $totalmarks+=$result->total;
                        $obt +=$result->obt_marks;
                    @endphp
                     @endforeach
                     @php
                         $avg = $obt/$totalmarks * 100
                     @endphp
                    <!-- Example end -->
                </tbody>
            </table>
            <div class="result-summary mt-4">
                <p>Total Marks: {{ $totalmarks }}</p>
                <p>Total Obtained Marks: {{ $obt }}</p>
                <p>Percentage: {{ number_format($avg, 2) }}%</p>
            </div>





        </div>

    </div>
</div>

</div>
</div>
</div>
</div>
<!-- End Inner-page -->
</div>
</div>

@endsection