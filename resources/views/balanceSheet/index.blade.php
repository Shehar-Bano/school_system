<!DOCTYPE html>
<html lang="en">

@include('view-file/head')
<body>
  <div class="container-scroller">
    @include('view-file/nav')
    <div class="container-fluid page-body-wrapper">
      @include('view-file.side-bar')

      <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="text-center">Balance Sheet</h1>
            {{-- <a href="{{ route('exportToExcel') }}" class="btn btn-success">Export to Excel</a> --}}
        </div>

        <!-- Balance Sheet Table -->
        <div class="table-responsive mt-4">
          <table class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>No.</th>
                <th>Date</th>
                <th>Description</th>
                <th>Debit</th>
                <th>Credit</th>
                <th>Balance</th>
              </tr>
            </thead>
            <tbody>
              @php $currentBalance = 0; @endphp
              @foreach ($entries as $entry)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ \Carbon\Carbon::parse($entry['date'])->format('Y-m-d') }}</td>
                <td>{{ $entry['description'] }}</td>
                <td>{{ $entry['type'] == 'debit' ? number_format($entry['amount']).' Rs/-': '-' }}</td>
                <td>{{ $entry['type'] == 'credit' ? number_format($entry['amount']).' Rs/-' : '-' }}</td>

                <!-- Calculate the balance based on debits and credits -->
                @php
            if ($entry['type'] == 'debit') {
                $currentBalance -= $entry['amount'];
            } elseif ($entry['type'] == 'credit') {
                $currentBalance += $entry['amount'];
            }
        @endphp
                <td>{{ number_format($currentBalance).' Rs/-' }}</td>
              </tr>
              @endforeach

              <!-- Total row -->
              <tr>
                <td colspan="3" class="text-end"><strong>Totals</strong></td>
                <td><strong>{{ number_format($totalDebit).' Rs/-' }}</strong></td>
                <td><strong>{{ number_format($totalCredit).' Rs/-' }}</strong></td>
                <td><strong>{{ number_format($currentBalance).' Rs/-' }}</strong></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>

  @include('view-file/script')
</body>

</html>
