<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Student Fees</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet"> <!-- Assuming you use Bootstrap -->
    <style>
        /* Hide elements by default */
        .d-none {
            display: none !important;
        }

        /* Show the div only during printing */
        @media print {
            .d-none {
                display: block !important;
                
            }

            .d-print-block {
                display: block !important;
            }

            /* Optional: Adjust styles for printing */
            .result-card {
    width: 60%; 
   
    /* margin: 20px; Added margin to separate cards */
    display: block; 
    text-align: center;/* Changed from inline-block to block */
    vertical-align: top;
    position: relative;
    z-index: 2; /* Ensure content is above the watermark */
    
}


/* Add a page break after each card */
.result-card {
    page-break-after: always;
}
            h3, h4, h5, h6 {
                text-align: center;
                margin: 0;
                padding: 5px;
                
            }

            .result-summary {
                text-align: left;
            }

            .page-break {
                page-break-after: always;
                clear: both;
            }

            .table-container {
                width: 100%;
                margin-top: 5px;
                /* margin-right: 20px; */
                
            }

            table {
                border: 2px solid black;
                border-collapse: collapse;
                width: 100%;
            }

            th, td {
                border: 1px solid black;
                padding: 5px;
            }

            .thead-dark th {
                background-color: #343a40 !important;
                color: white !important;
            }

            .result-summary {
                margin-top: 10px;
                text-align: right;
            }

            .footer-section {
                margin-top: 20px;
                text-align: center;
            }

            .footer-section p {
                margin: 0;
                font-size: 12px;
                color: #666;
            }

            .footer-section .signature {
                margin-top: 20px;
                display: flex;
                justify-content: space-around;
            }

            .footer-section .signature div {
                text-align: center;
            }

            .footer-section .signature div p {
                margin-top: 30px;
                border-top: 1px solid #333;
                width: 90px;
                margin-left: auto;
                margin-right: auto;
                padding-top: 5px;
                font-size: 12px;
            }
            #printArea{
                height: 90vh;
            }
        }
    </style>
</head>
<body>

    <div id="printArea" class="d-none d-print-block main">
        @foreach($students as $student)
        @if(isset($fees[$student['id']]))
            <div class="result-card">
               
    
                <div class="table-container">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <td colspan="2">
                                <h3>Science Academy Girls High School Bhera</h3>
               
                                <div class="student-info">
                                    <h4>Student Name: {{ $student['name'] }}</h4>
                                    <h5>Class: {{ $student['class']->name }} ({{ $student['section']->name }})</h5>
                                    <h5>Roll No: {{ $student['roll_no'] }}</h5>
                                </div>
                            </td>
                        </tr>
                      
                            <tr>
                                <th>Description</th>
                                <th>Amount</th>
                            </tr>
                        
                        <tbody>
                            @php
                                $totalAmount = 0;
                                $scholarship=0;
                                $totalDue = 0;
                            @endphp
    
                            @foreach ($fees[$student['id']] as $fee)
                                <tr>
                                    <td class="align-middle">{{ $fee['fee_type'] }}</td>
                                    <td class="align-middle text-center">{{ number_format($fee['amount']) }}</td>
                                </tr>
                                @php
                                    $totalAmount += $fee['amount'];
                                @endphp
                            @endforeach
                            @php
                            $scholarship = $student['funds']->sum('amount');
                            $totalDue =$totalAmount-$scholarship;
                            @endphp
                        </tbody>
                        <tfoot>
                            <tr class="bg-light">
                                <td colspan="4" class="text-end">
                                    <div class="result-summary mt-3">
                                        <p class="mb-1"><strong>Total Amount:</strong> {{ number_format($totalAmount) }} Rs/-</p>
                                        @if ($scholarship != 0)
                                        <p class="mb-1"><strong>Fund Amount:</strong> {{ number_format($scholarship) }} Rs/-</p>
                                        @endif
                                        <p><strong>Total Due:</strong> {{ number_format($totalDue)}} Rs/-</p>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
    
                <div class="footer-section">
                    <div class="signature">
                        <div>
                            <p>Fee Clerk</p>
                        </div>
                        <div>
                            <p>Accounts Manager</p>
                        </div>
                        <div>
                            <p>Parent/Guardian</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
    </div>
    
    <script>
      window.onload = function() {
    // Hide all elements except the printArea
    const printArea = document.getElementById('printArea');
    const bodyContent = document.body.innerHTML;
    const printContent = printArea.innerHTML;

    // Set the body content to only the printArea content
    document.body.innerHTML = printContent;

    // Print the content
    window.print();

    // Restore the original body content after printing
    document.body.innerHTML = bodyContent;

    // After printing, redirect to the section list page
    window.onafterprint = function() {
        setTimeout(function() {
            window.location.href = "{{ route('section-list') }}";
        }, 1000); // Adjust the delay as needed
    };
};

    </script>

</body>
</html>
