@extends('employeeDashboard.employeeView.masterpage')
@section('content')
<div class="container">

    @section('content')
    <div class="container mt-3">
        <h2>Your Incentives</h2>
    
    
     
        <table class="table">
            <thead>
                <tr>
                 
                    <th>Date</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Due Date</th>
                   
                </tr>
            </thead>
            <tbody>
                @foreach($recodes as $record)
                    <tr>
                        <td>{{ $record->transaction_date->format('d M Y') }}</td>
                        <td>{{ $record->transaction_type }}</td>
                        <td>{{ number_format($record->amount) }} Rs/-</td>
                        <td>{{ $record->due_date ? \Carbon\Carbon::parse($record->due_date)->format('d M Y') : 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endsection
</div>
@endsection