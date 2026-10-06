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
            <div class="col-lg-10 col-xl-9">
              
              <!-- Modern ERP Form Card -->
              <div class="erp-card-form">
                <div class="erp-form-header-block">
                  <div class="erp-form-title-area">
                    <h3 class="erp-form-title">
                      <i class="fas fa-calendar-pen text-primary"></i>
                      Update Subject Exam Timing
                    </h3>
                    <p class="erp-form-subtitle">Modify date, start time, and finish time for {{ $exam->subject->subject_name ?? 'this subject' }}</p>
                  </div>

                  <!-- Back to List Button -->
                  <div>
                    <a href="{{ route('exam-schedule-list') }}" class="erp-btn-back">
                      <i class="fas fa-arrow-left"></i> Back to Schedules
                    </a>
                  </div>
                </div>

                <form action="{{ route('exam.schedule.datesheet.update', ['id' => $exam->id]) }}" method="POST" id="editDateSheetForm">
                  @csrf
                  
                  <div class="erp-form-body">
                    <div class="row">
                      <!-- Subject Display -->
                      <div class="col-md-12 mb-3">
                        <div class="p-3 bg-light rounded border d-flex align-items-center">
                          <i class="fas fa-book text-primary fa-lg mr-2"></i>
                          <div>
                            <small class="text-muted d-block">Subject</small>
                            <span class="font-weight-bold text-dark fs-6">{{ $exam->subject->subject_name ?? 'Subject' }}</span>
                          </div>
                        </div>
                      </div>

                      <!-- Date -->
                      <div class="col-md-4">
                        <div class="erp-form-group">
                          <label for="date" class="erp-form-label">Exam Date <span class="required">*</span></label>
                          <input type="date" class="form-control" id="date" name="date" value="{{ $exam->date ?? '' }}" required>
                        </div>
                      </div>

                      <!-- Start Time -->
                      <div class="col-md-4">
                        <div class="erp-form-group">
                          <label for="start_time" class="erp-form-label">Start Time <span class="required">*</span></label>
                          <input type="time" class="form-control" id="start_time" name="start_time" value="{{ $exam->start_time ?? '' }}" required>
                        </div>
                      </div>

                      <!-- End Time -->
                      <div class="col-md-4">
                        <div class="erp-form-group">
                          <label for="end_time" class="erp-form-label">End Time <span class="required">*</span></label>
                          <input type="time" class="form-control" id="end_time" name="end_time" value="{{ $exam->end_time ?? '' }}" required>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Form Action Footer -->
                  <div class="erp-form-footer">
                    <a href="{{ route('exam-schedule-list') }}" class="btn btn-sm btn-outline-secondary">
                      Cancel
                    </a>
                    <button type="submit" class="erp-btn-submit">
                      <i class="fas fa-save"></i> Update Exam Timing
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
