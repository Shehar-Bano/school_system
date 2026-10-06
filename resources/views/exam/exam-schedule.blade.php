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
                      <i class="fas fa-calendar-check text-primary"></i>
                      Create Exam Schedule
                    </h3>
                    <p class="erp-form-subtitle">Schedule exam session for class, section and date range window</p>
                  </div>

                  <!-- Back to List Button -->
                  <div>
                    <a href="{{ route('exam-schedule-list') }}" class="erp-btn-back">
                      <i class="fas fa-arrow-left"></i> Back to Schedules
                    </a>
                  </div>
                </div>

                <form action="{{ route('exam_schedule_store') }}" method="POST" id="addScheduleForm">
                  @csrf
                  
                  <div class="erp-form-body">
                    <div class="row">
                      <!-- Exam Selection -->
                      <div class="col-md-6">
                        <div class="erp-form-group">
                          <label for="exam_id" class="erp-form-label">Exam Term <span class="required">*</span></label>
                          <select class="form-control" id="exam_id" name="exam_id" required>
                            <option value="" disabled selected>-- Select Exam Term --</option>
                            @foreach($exams as $exam)
                              <option value="{{ $exam->id }}" {{ old('exam_id') == $exam->id ? 'selected' : '' }}>
                                {{ $exam->name }}
                              </option>
                            @endforeach
                          </select>
                          @error('exam_id')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <!-- Class Selection -->
                      <div class="col-md-6">
                        <div class="erp-form-group">
                          <label for="class_id" class="erp-form-label">Target Class <span class="required">*</span></label>
                          <select class="form-control" id="class_id" name="class_id" required>
                            <option value="" disabled selected>-- Select Class --</option>
                            @foreach($classes as $class)
                              <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->name }}
                              </option>
                            @endforeach
                          </select>
                          @error('class_id')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <!-- Section Selection -->
                      <div class="col-md-4">
                        <div class="erp-form-group">
                          <label for="section_id" class="erp-form-label">Section <span class="required">*</span></label>
                          <select class="form-control" id="section_id" name="section_id" required>
                            <option value="" disabled selected>-- Select Section --</option>
                            @foreach($sections as $section)
                              <option value="{{ $section->id }}" {{ old('section_id') == $section->id ? 'selected' : '' }}>
                                {{ $section->name }} ({{ $section->classe->name ?? '' }})
                              </option>
                            @endforeach
                          </select>
                          @error('section_id')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <!-- Start Date -->
                      <div class="col-md-4">
                        <div class="erp-form-group">
                          <label for="start_date" class="erp-form-label">Start Date <span class="required">*</span></label>
                          <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                          @error('start_date')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <!-- End Date -->
                      <div class="col-md-4">
                        <div class="erp-form-group">
                          <label for="end_date" class="erp-form-label">End Date <span class="required">*</span></label>
                          <input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                          @error('end_date')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
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
                      <i class="fas fa-check"></i> Save Exam Schedule
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
