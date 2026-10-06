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
                      <i class="fas fa-file-circle-plus text-primary"></i>
                      Add New Syllabus
                    </h3>
                    <p class="erp-form-subtitle">Upload class curriculum outline, course topics, study guide, and reference document</p>
                  </div>

                  <!-- Back to List Button -->
                  <div>
                    <a href="{{ route('syllabus_show') }}" class="erp-btn-back">
                      <i class="fas fa-arrow-left"></i> Back to Syllabus
                    </a>
                  </div>
                </div>

                <form action="{{ route('syllabus_store') }}" method="POST" enctype="multipart/form-data" id="addSyllabusForm">
                  @csrf
                  
                  <div class="erp-form-body">
                    <div class="row">
                      <!-- Title -->
                      <div class="col-md-7">
                        <div class="erp-form-group">
                          <label for="title" class="erp-form-label">Syllabus Title <span class="required">*</span></label>
                          <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" placeholder="e.g. Grade 10 Mathematics Term 1 Syllabus" required autofocus>
                          @error('title')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <!-- Class Selection -->
                      <div class="col-md-5">
                        <div class="erp-form-group">
                          <label for="class_id" class="erp-form-label">Target Class <span class="required">*</span></label>
                          <select class="form-control" id="class_id" name="class_id" required>
                            <option value="" disabled selected>-- Select Class --</option>
                            @foreach ($classes as $class)
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

                      <!-- Description -->
                      <div class="col-md-12">
                        <div class="erp-form-group">
                          <label for="description" class="erp-form-label">Description & Learning Outcomes <span class="required">*</span></label>
                          <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter key syllabus topics, grading weights, and learning objectives..." required>{{ old('description') }}</textarea>
                          @error('description')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <!-- Attachment File -->
                      <div class="col-md-12">
                        <div class="erp-form-group mb-0">
                          <label for="file" class="erp-form-label">Document Attachment (PDF / DOC / DOCX) <span class="required">*</span></label>
                          <input type="file" class="form-control" id="file" name="file" required>
                          <small class="form-text text-muted">Upload a complete syllabus outline document (Max 10MB)</small>
                          @error('file')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Form Action Footer -->
                  <div class="erp-form-footer">
                    <a href="{{ route('syllabus_show') }}" class="btn btn-sm btn-outline-secondary">
                      Cancel
                    </a>
                    <button type="submit" class="erp-btn-submit">
                      <i class="fas fa-check"></i> Save Syllabus
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
