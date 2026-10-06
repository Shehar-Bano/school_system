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
                      <i class="fas fa-file-signature text-primary"></i>
                      Select Examination For Marks Entry
                    </h3>
                    <p class="erp-form-subtitle">Choose exam session, class, section and subject to record student marks</p>
                  </div>

                  <!-- Back to List Button -->
                  <div>
                    <a href="{{ route('result') }}" class="erp-btn-back">
                      <i class="fas fa-arrow-left"></i> Back to Results
                    </a>
                  </div>
                </div>

                <form action="{{ route('result-add') }}" method="GET" id="selectResultForm">
                  <div class="erp-form-body">
                    <div class="row">
                      <!-- Exam Selection -->
                      <div class="col-md-6">
                        <div class="erp-form-group">
                          <label for="exam" class="erp-form-label">Examination Term <span class="required">*</span></label>
                          <select class="form-control" id="exam" name="exam" required>
                            <option value="" disabled selected>-- Select Exam Term --</option>
                            @foreach ($exams as $exam)
                              <option value="{{ $exam->id }}">{{ $exam->name }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>

                      <!-- Class Selection -->
                      <div class="col-md-6">
                        <div class="erp-form-group">
                          <label for="class" class="erp-form-label">Class <span class="required">*</span></label>
                          <select class="form-control" id="class" name="class" required>
                            <option value="" disabled selected>-- Select Class --</option>
                            @foreach ($classe as $class)
                              <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>

                      <!-- Section Selection -->
                      <div class="col-md-6">
                        <div class="erp-form-group">
                          <label for="section" class="erp-form-label">Section <span class="required">*</span></label>
                          <select class="form-control" id="section" name="section" required>
                            <option value="" disabled selected>-- Select Section --</option>
                            @foreach ($sections as $section)
                              <option value="{{ $section->id }}">{{ $section->name }} ({{ $section->classe->name ?? '' }})</option>
                            @endforeach
                          </select>
                        </div>
                      </div>

                      <!-- Subject Selection -->
                      <div class="col-md-6">
                        <div class="erp-form-group">
                          <label for="subject" class="erp-form-label">Subject <span class="required">*</span></label>
                          <select class="form-control" id="subject" name="subject" required>
                            <option value="" disabled selected>-- Select Subject --</option>
                            @foreach($subjects as $subject)
                              <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Form Action Footer -->
                  <div class="erp-form-footer">
                    <a href="{{ route('result') }}" class="btn btn-sm btn-outline-secondary">
                      Cancel
                    </a>
                    <button type="submit" class="erp-btn-submit">
                      <i class="fas fa-arrow-right"></i> Proceed to Marks Entry
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
