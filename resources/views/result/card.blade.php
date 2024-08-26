<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Result</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }
        .report-card {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        .report-header {
            text-align: center;
            margin-bottom: 20px;
            position: relative;
        }
        .report-header h1 {
            font-size: 36px;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        .report-header img {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 100px;
        }
        .report-header p {
            margin: 0;
            font-size: 14px;
            color: #666;
        }
        .student-info {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .student-info img {
            border-radius: 50%;
            width: 120px;
            height: 120px;
            object-fit: cover;
            margin-right: 20px;
        }
        .student-details {
            font-size: 16px;
        }
        .student-details p {
            margin: 0;
            line-height: 1.6;
        }
        .student-details strong {
            color: #333;
        }
        .result-table {
            width: 100%;
            margin-top: 20px;
        }
        .result-table thead {
            background-color: #333;
            color: #fff;
        }
        .result-table th, .result-table td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }
        .result-summary {
            text-align: center;
            margin-top: 20px;
            font-weight: bold;
            font-size: 16px;
            padding: 15px;
            background-color: #f1f1f1;
            border-radius: 10px;
        }
        .footer-section {
            margin-top: 30px;
            text-align: center;
        }
        .footer-section p {
            margin: 0;
            font-size: 14px;
            color: #666;
        }
        .footer-section .signature {
            margin-top: 30px;
            display: flex;
            justify-content: space-around;
        }
        .footer-section .signature div {
            text-align: center;
        }
        .footer-section .signature div p {
            margin-top: 50px;
            border-top: 1px solid #333;
            width: 200px;
            margin-left: auto;
            margin-right: auto;
            padding-top: 10px;
            font-size: 14px;
        }
    </style>
    @include('view-file/head')
</head>
<body>
    <div class="container-scroller">
        @include('view-file/nav')
        <div class="container-fluid page-body-wrapper">
          @include('view-file.side-bar')
          <div class="main-panel">
            <div class="content-wrapper">
              <div class="container">
                <div class="report-card" id="examsTable">
                    <!-- Header -->
                    <div class="report-header">
                        <h1>RESULT CARD</h1>
                        <h4>Science Acadmey High School Bhera</h4>
                        {{-- <img src="{{ asset('path/to/your/logo.png') }}" alt="School Logo"> --}}
                        <p>The following is a summary of learning progress during this time period.</p>
                    </div>

                    <!-- Student Info -->
                    <div class="student-info">
                        <a class="navbar-brand brand-logo-mini" href="index.html"><img src="{{asset('assesst/images/logo-mini.svg')}}" alt="logo"/></a>
                        <div class="student-details">
                            <p><strong>Full Name:</strong> {{ $student->name }}</p>
                            <p><strong>Class:</strong> {{ $student->class->name }}</p>
                            <p><strong>Section:</strong> {{ $student->section->name }}</p>
                            <p><strong>Exam:</strong> {{ $exam->name }}</p>

                        </div>
                    </div>

                    <!-- Result Table -->
                    
                    <table class="table result-table" id="examsTable">
                        <thead>
                            <tr>
                                <th>Subject</th>
                                <th>Score</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalmarks = 0;
                                $obt = 0;
                                $avg = 0;
                            @endphp
                            @foreach ($results as $result)
                            <tr>
                                <td>{{ $result->subject->subject_name }}</td>
                                <td>{{ $result->obt_marks }}</td>
                                <td>{{ ($result->total) }}</td> <!-- Converts numbers to words -->
                            </tr>
                            @php
                                $totalmarks += $result->total;
                                $obt += $result->obt_marks;
                            @endphp
                            @endforeach
                            @php
                                $avg = $obt / $totalmarks * 100;
                            @endphp
                        </tbody>
                    </table>

                    <!-- Result Summary -->
                    <p class="result-summary">Total Marks: {{ $totalmarks }} | Total Obtained Marks: {{ $obt }} | Average Marks (%): {{ number_format($avg, 2) }}</p>

                    <!-- Footer Section -->
                    <div class="footer-section">
                        <div class="signature">
                            <div>
                                <p>Homeroom Teacher</p>
                            </div>
                            <div>
                                <p>Head of Campus</p>
                            </div>
                            <div>
                                <p>Student Guardian</p>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
              {{-- <button id="pdfButton" class="btn btn-light btn-outline-warning">PDF</button> --}}
            </div>
          </div>
        </div>
    </div>
    @include('view-file.script')
</body>
</html>
<script>
     document.addEventListener('DOMContentLoaded', function() {

      // Export to PDF
      if (pdfButton) {
        pdfButton.addEventListener('click', function() {
          const { jsPDF } = window.jspdf;
          let doc = new jsPDF();
          let table = document.getElementById('examsTable');
          doc.autoTable({ html: table });
          doc.save('exams.pdf');
        });
      }
    });
</script>
