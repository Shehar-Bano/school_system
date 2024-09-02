<!DOCTYPE html>
<html lang="en">
@php
use Carbon\Carbon;
@endphp
<head>
    <meta charset="UTF-8">
    <title>Salary Slip</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 10px;
        }
        .pdfDiv {
            width: 40vh;
            height: 60vh;
            padding: 10px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
            font-size: 0.7em;
        }
        .table th, .table td {
            border: 1px solid #000;
            padding: 2px;
            text-align: left;
        }
        .table-borderless th, .table-borderless td {
            border: none;
            padding: 2px;
            text-align: left;
        }
        h1 {
            margin-top: 5px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 1em;
        }
        h3 {
            margin-bottom: 8px;
            font-size: 0.9em;
        }
        .text-center {
            text-align: center;
        }
        .nodata {
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="pdfDiv">
        <!-- Employee Details Section -->
        <h1>Payment Receipt</h1>
        <table class="table table-borderless">
            <tr>
                <td><strong>Name:</strong></td>
                <td>{{ $employee->employee->name }}</td>
            </tr>
            <tr>
                <td><strong>Designation:</strong></td>
                <td>{{ $employee->employee->designation->name }}</td>
            </tr>
            <tr>
                <td><strong>Gender:</strong></td>
                <td>{{ $employee->employee->gender }}</td>
            </tr>
            <tr>
                <td><strong>Date of Birth:</strong></td>
                <td>{{ Carbon::parse($employee->employee->date_of_birth)->format('d M, Y') }}</td>
            </tr>
            <tr>
                <td><strong>Phone:</strong></td>
                <td>{{ $employee->employee->phone }}</td>
            </tr>
        </table>

        <!-- Salary Information Section -->
        <h3>Salary Details</h3>
        <table class="table">
            <tr>
                <td><strong>Salary Month</strong></td>
                <td>{{ Carbon::parse($employee->date)->format('M, Y') }}</td>
            </tr>
            <tr>
                <td><strong>Base Salary</strong></td>
                <td>{{ number_format($employee->employee->salary) }} Rs/-</td>
            </tr>
            <tr>
                <td><strong>Salary Status</strong></td>
                <td>{{ $employee->status }}</td>
            </tr>
        </table>

        <!-- Bonus Information Section -->
        <h3>Bonuses</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Bonus</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $hasBonus = false;
                @endphp
                @foreach ($transactions as $transction)
                    @if (in_array($transction->transaction_type, ['Performance Bonus', 'Festival Bonus', 'Duty Reward', 'Paper Checking Reward']) && $transction->employee_id == $employee->employee->id)
                        @php
                            $hasBonus = true;
                        @endphp
                        <tr>
                            <td>{{ $transction->transaction_type }}</td>
                            <td>{{ number_format($transction->amount) }} Rs/-</td>
                        </tr>
                    @endif
                @endforeach
                @if (!$hasBonus)
                    <tr class="text-center">
                        <td colspan="2" class="nodata">There is no bonus for {{ Carbon::parse($employee->date)->format('M, Y') }}</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <!-- Deduction Information Section -->
        <h3>Deductions</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Deduction</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $hasDeduction = false;
                @endphp
                @foreach ($transactions as $transction)
                    @if (in_array($transction->transaction_type, ['Late Penalty', 'Absence Penalty', 'Loan Repayment']) && $transction->employee_id == $employee->employee->id)
                        @php
                            $hasDeduction = true;
                        @endphp
                        <tr>
                            <td>{{ $transction->transaction_type }}</td>
                            <td>{{ number_format($transction->amount) }} Rs/-</td>
                        </tr>
                    @endif
                @endforeach
                @if (!$hasDeduction)
                    <tr class="text-center">
                        <td colspan="2" class="nodata">There is no Deduction for {{ Carbon::parse($employee->date)->format('M, Y') }}</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <!-- Total Salary Information Section -->
        <h3>Total Salary Details</h3>
        <table class="table">
            <tr>
                <td>Gross Salary</td>
                <td>{{ number_format($gross_salary) }} Rs/-</td>
            </tr>
            <tr>
                <td>Total Deduction</td>
                @if($deduction === 0)
                <td>0.00</td>
                @else
                <td>{{ number_format($deduction) }} Rs/-</td>
                @endif
            </tr>
            <tr>
                <td>Net Salary</td>
                <td>{{ number_format($net_salary) }} Rs/-</td>
            </tr>
        </table>
    </div>
</body>
</html>
