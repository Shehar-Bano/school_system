<!DOCTYPE html>
<html lang="en">

@include('view-file/head')
<body>
  <div class="container-scroller">
    @include('view-file/nav')
    <div class="container-fluid page-body-wrapper">
      @include('view-file.side-bar')

      <!-- Inner-page -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="container">
            <!-- Add New Exam Button -->


            <!-- Filter Inputs -->
            <div class="mb-4">
              <div class="row">
                <div class="col-md-6">
                  <button id="copyButton" class="btn btn-light btn-outline-primary">Copy</button>
                  <button id="csvButton" class="btn btn-light btn-outline-primary">CSV</button>
                  <button id="excelButton" class="btn btn-light btn-outline-primary">Excel</button>
                  <button id="pdfButton" class="btn btn-light btn-outline-primary">PDF</button>
                </div>

              </div>
            </div>

            <!-- Exams Table -->
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Date Sheet</h4>
                <div class="table-responsive">
                  <table class="table table-striped table-bordered" id="examsTable">
                    <thead>
                      <tr>
                        <th>Sr.no</th>
                        <th>Subject</th>
                        <th>Time</th>
                        <th>Date</th>
                        <th>Actions</th>
                      </tr>
                    </thead>

                    <tbody>
                        @php
                            $count = 0;
                        @endphp
                      @foreach ($datesheets as $exam)
                      @if($exams->id == $exam->exam_schedule_id )
                      <tr>
                        <td>{{ ++$count }}</td>

                        <td>{{$exam->subject->subject_name}}</td>
                        <td>{{ $exam->start_time }} to {{$exam->end_time}}</td>
                        <td>{{ $exam->date }}</td>
                        <td>
                           <!-- Edit Button -->
                           <a href="{{ route('exam-schedule-date-edit', ['id' => $exam->id ]) }}" class="btn btn-warning btn-sm" title="Edit">
                            <i class="fas fa-edit"></i>
                          </a>
                          <form action="{{ route('exam-schedule-date_delete', ['id' => $exam->id]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                              <i class="fas fa-trash"></i>
                            </button>
                          </form>
                        </td>
                      </tr>
                      @endif
                      @endforeach
                    </tbody>


                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- End Inner-page -->

    </div>
  </div>
  @include('view-file.script')

  <!-- Filter and Suggestion Script -->
  <script>

    // Export functionalities
    document.addEventListener('DOMContentLoaded', function() {
      const copyButton = document.getElementById('copyButton');
      const csvButton = document.getElementById('csvButton');
      const excelButton = document.getElementById('excelButton');
      const pdfButton = document.getElementById('pdfButton');

      // Copy to Clipboard
      if (copyButton) {
    new ClipboardJS(copyButton, {
        text: function() {
            let table = document.getElementById('examsTable');
            return table.innerText; // Copy table content
        }
    });
}

      // Export to CSV
      if (csvButton) {
    csvButton.addEventListener('click', function() {
        let csv = [];
        let rows = document.querySelectorAll('#examsTable tr');
        for (let i = 0; i < rows.length; i++) {
            let row = [];
            let cols = rows[i].querySelectorAll('td, th');
            for (let j = 0; j < cols.length; j++) {
                row.push('"' + cols[j].innerText.replace(/"/g, '""') + '"');
            }
            csv.push(row.join(','));
        }
        let csvFile = new Blob([csv.join('\n')], { type: 'text/csv' });
        let downloadLink = document.createElement('a');
        downloadLink.download = 'exams.csv';
        downloadLink.href = window.URL.createObjectURL(csvFile);
        downloadLink.click();
    });
}


      // Export to Excel
      if (excelButton) {
    excelButton.addEventListener('click', function() {
        let table = document.getElementById('examsTable');
        let wb = XLSX.utils.table_to_book(table, { sheet: 'Sheet1' });
        XLSX.writeFile(wb, 'exams.xlsx');
    });
}


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

</body>

</html>
