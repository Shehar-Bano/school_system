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
                      <i class="fas fa-book text-primary"></i>
                      Add New Subject
                    </h3>
                    <p class="erp-form-subtitle">Create a curriculum course, specify subject code, passing marks, and subject classification</p>
                  </div>

                  <!-- Back to List Button -->
                  <div>
                    <a href="{{ route('subject_show') }}" class="erp-btn-back">
                      <i class="fas fa-arrow-left"></i> Back to Subjects
                    </a>
                  </div>
                </div>

                <form action="{{ route('subject_store') }}" method="POST" id="addSubjectForm">
                  @csrf
                  
                  <div class="erp-form-body">
                    <div class="row">
                      <!-- Subject Name -->
                      <div class="col-md-6">
                        <div class="erp-form-group">
                          <label for="subject_name" class="erp-form-label">Subject Name <span class="required">*</span></label>
                          <input type="text" class="form-control" id="subject_name" name="subject_name" value="{{ old('subject_name') }}" placeholder="e.g. Mathematics / Physics" required autofocus>
                        </div>
                      </div>

                      <!-- Subject Code -->
                      <div class="col-md-6">
                        <div class="erp-form-group">
                          <label for="sub_code" class="erp-form-label">Subject Code <span class="required">*</span></label>
                          <input type="text" class="form-control" id="sub_code" name="sub_code" value="{{ old('sub_code') }}" placeholder="e.g. MATH-101" required>
                        </div>
                      </div>

                      <!-- Subject Type -->
                      <div class="col-md-4">
                        <div class="erp-form-group">
                          <label for="type" class="erp-form-label">Subject Type <span class="required">*</span></label>
                          <select class="form-control" id="type" name="type" required>
                            <option value="Mandatory" {{ old('type') == 'Mandatory' ? 'selected' : '' }}>Mandatory / Core</option>
                            <option value="Optional" {{ old('type') == 'Optional' ? 'selected' : '' }}>Optional / Elective</option>
                            <option value="Practical" {{ old('type') == 'Practical' ? 'selected' : '' }}>Practical / Lab</option>
                          </select>
                        </div>
                      </div>

                      <!-- Pass Marks -->
                      <div class="col-md-4">
                        <div class="erp-form-group">
                          <label for="pass_marks" class="erp-form-label">Pass Marks <span class="required">*</span></label>
                          <input type="number" class="form-control" id="pass_marks" name="pass_marks" value="{{ old('pass_marks', 33) }}" placeholder="e.g. 33" min="0" required>
                        </div>
                      </div>

                      <!-- Final / Total Marks -->
                      <div class="col-md-4">
                        <div class="erp-form-group">
                          <label for="final_marks" class="erp-form-label">Total / Final Marks <span class="required">*</span></label>
                          <input type="number" class="form-control" id="final_marks" name="final_marks" value="{{ old('final_marks', 100) }}" placeholder="e.g. 100" min="1" required>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Form Action Footer -->
                  <div class="erp-form-footer">
                    <a href="{{ route('subject_show') }}" class="btn btn-sm btn-outline-secondary">
                      Cancel
                    </a>
                    <button type="submit" class="erp-btn-submit">
                      <i class="fas fa-check"></i> Save Subject
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
