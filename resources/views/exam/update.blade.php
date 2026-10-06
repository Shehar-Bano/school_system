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
                      <i class="fas fa-file-pen text-primary"></i>
                      Update Examination Term
                    </h3>
                    <p class="erp-form-subtitle">Modify examination title, fee requirements, and notes</p>
                  </div>

                  <!-- Back to List Button -->
                  <div>
                    <a href="{{ route('exam-list') }}" class="erp-btn-back">
                      <i class="fas fa-arrow-left"></i> Back to Exams
                    </a>
                  </div>
                </div>

                <form action="{{ url('/exam/update', ['id' => $exams->id]) }}" method="POST" id="editExamForm">
                  @csrf
                  
                  <div class="erp-form-body">
                    <div class="row">
                      <!-- Exam Name -->
                      <div class="col-md-7">
                        <div class="erp-form-group">
                          <label for="examName" class="erp-form-label">Exam Term Name <span class="required">*</span></label>
                          <input type="text" class="form-control" id="examName" name="name" value="{{ old('name', $exams->name) }}" placeholder="e.g. Mid-Term Examination 2026" required autofocus>
                          @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <!-- Exam Fee -->
                      <div class="col-md-5">
                        <div class="erp-form-group">
                          <label for="exam_fee" class="erp-form-label">Exam Fee (Rs.)</label>
                          <input type="number" class="form-control" id="exam_fee" name="exam_fee" value="{{ old('exam_fee', $exams->exam_fee) }}" placeholder="e.g. 1000">
                          @error('exam_fee')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <!-- Note -->
                      <div class="col-md-12">
                        <div class="erp-form-group mb-0">
                          <label for="examNote" class="erp-form-label">Examination Note & Guidelines</label>
                          <textarea class="form-control" id="examNote" name="note" rows="3" placeholder="Enter special guidelines, rules or remarks...">{{ old('note', $exams->note) }}</textarea>
                          @error('note')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Form Action Footer -->
                  <div class="erp-form-footer">
                    <a href="{{ route('exam-list') }}" class="btn btn-sm btn-outline-secondary">
                      Cancel
                    </a>
                    <button type="submit" class="erp-btn-submit">
                      <i class="fas fa-save"></i> Update Exam
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
