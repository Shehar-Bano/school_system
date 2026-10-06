<!DOCTYPE html>
<html lang="en">
@include('view-file/head')

<body>
  <div class="container-scroller">
    @include('view-file/nav')
    <div class="container-fluid page-body-wrapper">
      @include('view-file.side-bar')
      
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row justify-content-center">
            <div class="col-lg-11 col-xl-10">
              
              <!-- Modern ERP Form Card -->
              <div class="erp-card-form">
                <div class="erp-form-header-block">
                  <div class="erp-form-title-area">
                    <h3 class="erp-form-title">
                      <i class="fas fa-calendar-days text-primary"></i>
                      Configure Exam Date Sheet
                    </h3>
                    <p class="erp-form-subtitle">Assign examination dates, start times and ending times for every subject</p>
                  </div>

                  <!-- Back to List Button -->
                  <div>
                    <a href="{{ route('exam-schedule-list') }}" class="erp-btn-back">
                      <i class="fas fa-arrow-left"></i> Back to Schedules
                    </a>
                  </div>
                </div>

                <form action="{{ url('/exam/schedule/datesheet/store', ['id' => $exam->id]) }}" method="POST" id="dateSheetForm">
                  @csrf
                  
                  <div class="erp-form-body">
                    <div class="table-responsive">
                      <table class="table table-bordered align-middle">
                        <thead class="bg-light">
                          <tr>
                            <th style="width: 30%;">Subject</th>
                            <th style="width: 25%;">Exam Date <span class="text-danger">*</span></th>
                            <th style="width: 22%;">Start Time <span class="text-danger">*</span></th>
                            <th style="width: 23%;">End Time <span class="text-danger">*</span></th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($subjects as $subject)
                          <tr>
                            <td>
                              <span class="font-weight-semibold text-dark">
                                <i class="fas fa-book text-primary mr-1"></i> {{ $subject->subject_name }}
                              </span>
                              <input type="hidden" name="subjects[{{ $loop->index }}][subject_id]" value="{{ $subject->id }}">
                            </td>
                            <td>
                              <input type="date" class="form-control" name="subjects[{{ $loop->index }}][date]" required>
                            </td>
                            <td>
                              <input type="time" class="form-control" name="subjects[{{ $loop->index }}][start_time]" required>
                            </td>
                            <td>
                              <input type="time" class="form-control" name="subjects[{{ $loop->index }}][end_time]" required>
                            </td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>

                  <!-- Form Action Footer -->
                  <div class="erp-form-footer">
                    <a href="{{ route('exam-schedule-list') }}" class="btn btn-sm btn-outline-secondary">
                      Cancel
                    </a>
                    <button type="submit" class="erp-btn-submit">
                      <i class="fas fa-check"></i> Save Date Sheet
                    </button>
                  </div>
                </form>

              </div>
              <!-- End ERP Card Form -->

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @include('view-file/script')
</body>
</html>
