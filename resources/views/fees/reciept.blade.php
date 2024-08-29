<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fee Receipt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .receipt {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
        }
        .receipt-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .receipt-table th, .receipt-table td {
            padding: 10px;
            text-align: left;
        }
        .total-row {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="receipt-header">
            <h2>Fee Receipt</h2>
            <p>Date: {{ \Carbon\Carbon::now()->format('d-m-Y') }}</p>
        </div>

        <p><strong>Student Name:</strong> {{ $fee->student->name }}</p>
        <p><strong>Student Registration No:</strong> {{ $fee->student->registration }}</p>
        <p><strong>Class:</strong> {{ $fee->student->class->name }}</p>

        <table class="table receipt-table">
            <thead>
                <tr>
                    <th>Fee Type</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Tuition Fee</td>
                    <td>{{ number_format($fee->fee, 2) }}</td>
                </tr>
                <tr>
                    <td>Exam Fee</td>
                    <td>{{ number_format($fee->exam_fee, 2) }}</td>
                </tr>
                <tr>
                    <td>Other Activity Fee</td>
                    <td>{{ number_format($fee->other_activity_fee, 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td>Total</td>
                    <td>{{ number_format($fee->totalfee, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <p><strong>Due Date:</strong> {{ \Carbon\Carbon::parse($fee->due_date)->format('d-m-Y') }}</p>
        <p><strong>Status:</strong> {{ ucfirst($fee->status) }}</p>

        <div class="text-center mt-4">
            <p>Thank you for your payment!</p>
        </div>


    </div>
    <div class="text-center mt-4 ">
        <a href="{{ route('receipt.download', $fee->student->id) }}" class="btn btn-primary">Download Receipt</a>
    </div>
</body>
</html>
