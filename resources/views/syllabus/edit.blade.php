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
                      Update Syllabus
                    </h3>
                    <p class="erp-form-subtitle">Modify syllabus curriculum outline, course topics, and attached document</p>
                  </div>

                  <!-- Back to List Button -->
                  <div>
                    <a href="{{ route('syllabus_show') }}" class="erp-btn-back">
                      <i class="fas fa-arrow-left"></i> Back to Syllabus
                    </a>
                  </div>
                </div>

                <form action="{{ route('syllabus_update', ['id' => $syllabus->id]) }}" method="POST" enctype="multipart/form-data" id="editSyllabusForm">
                  @csrf
                  
                  <div class="erp-form-body">
                    <div class="row">
                      <!-- Title -->
                      <div class="col-md-7">
                        <div class="erp-form-group">
                          <label for="title" class="erp-form-label">Syllabus Title <span class="required">*</span></label>
                          <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $syllabus->title) }}" placeholder="e.g. Grade 10 Mathematics Term 1 Syllabus" required autofocus>
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
                              <option value="{{ $class->id }}" {{ old('class_id', $syllabus->class_id) == $class->id ? 'selected' : '' }}>
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
                          <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter key syllabus topics, grading weights, and learning objectives..." required>{{ old('description', $syllabus->description) }}</textarea>
                          @error('description')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <!-- Attachment File -->
                      <div class="col-md-12">
                        <div class="erp-form-group mb-0">
                          <label for="file" class="erp-form-label">Replace Document Attachment (Optional)</label>
                          <input type="file" class="form-control" id="file" name="file">
                          @if($syllabus->file)
                            <div class="mt-2 p-2 rounded bg-light border d-inline-flex align-items-center">
                              <i class="fas fa-file-pdf text-danger mr-2"></i>
                              <span class="small mr-3">Current File: {{ basename($syllabus->file) }}</span>
                              <a href="{{ asset('storage/' . $syllabus->file) }}" target="_blank" class="btn btn-xs btn-outline-primary">
                                <i class="fas fa-external-link-alt"></i> View File
                              </a>
                            </div>
                          @endif
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
                      <i class="fas fa-save"></i> Update Syllabus
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
