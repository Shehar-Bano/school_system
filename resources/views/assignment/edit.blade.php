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
                      Update Assignment
                    </h3>
                    <p class="erp-form-subtitle">Modify assignment task details, submission deadline, instructions and worksheet</p>
                  </div>

                  <!-- Back to List Button -->
                  <div>
                    <a href="{{ route('assignment_show') }}" class="erp-btn-back">
                      <i class="fas fa-arrow-left"></i> Back to Assignments
                    </a>
                  </div>
                </div>

                <form action="{{ route('assignments_update', ['id' => $assignment->id]) }}" method="POST" enctype="multipart/form-data" id="editAssignmentForm">
                  @csrf
                  
                  <div class="erp-form-body">
                    <div class="row">
                      <!-- Title -->
                      <div class="col-md-5">
                        <div class="erp-form-group">
                          <label for="title" class="erp-form-label">Assignment Title <span class="required">*</span></label>
                          <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $assignment->title) }}" placeholder="e.g. Chapter 4 Algebra Exercise Set" required autofocus>
                          @error('title')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <!-- Total Marks -->
                      <div class="col-md-3">
                        <div class="erp-form-group">
                          <label for="totalMarks" class="erp-form-label">Total Marks <span class="required">*</span></label>
                          <input type="number" class="form-control" id="totalMarks" name="total_marks" value="{{ old('total_marks', $assignment->total_marks ?? 100) }}" min="1" required>
                          @error('total_marks')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <!-- Deadline -->
                      <div class="col-md-4">
                        <div class="erp-form-group">
                          <label for="deadline" class="erp-form-label">Submission Deadline <span class="required">*</span></label>
                          <input type="date" class="form-control" id="deadline" name="deadline" value="{{ old('deadline', $assignment->deadline) }}" required>
                          @error('deadline')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <!-- Assigned Teacher -->
                      <div class="col-md-4">
                        <div class="erp-form-group">
                          <label for="teacher_id" class="erp-form-label">Assigned Teacher / Incharge</label>
                          <select class="form-control" id="teacher_id" name="teacher_id">
                            <option value="">-- Optional / Select Teacher --</option>
                            @foreach ($teachers as $teacher)
                              <option value="{{ $teacher->id }}" {{ old('teacher_id', $assignment->teacher_id) == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->name }} ({{ $teacher->designation->name ?? 'Staff' }})
                              </option>
                            @endforeach
                          </select>
                          @error('teacher_id')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <!-- Class Selection -->
                      <div class="col-md-4">
                        <div class="erp-form-group">
                          <label for="class_id" class="erp-form-label">Class <span class="required">*</span></label>
                          <select class="form-control" id="class_id" name="class_id" required>
                            <option value="" disabled selected>-- Select Class --</option>
                            @foreach ($classes as $class)
                              <option value="{{ $class->id }}" {{ old('class_id', $assignment->class_id) == $class->id ? 'selected' : '' }}>
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
                            @foreach ($sections as $section)
                              <option value="{{ $section->id }}" {{ old('section_id', $assignment->section_id) == $section->id ? 'selected' : '' }}>
                                {{ $section->name }}
                              </option>
                            @endforeach
                          </select>
                          @error('section_id')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <!-- Subject Selection -->
                      <div class="col-md-4">
                        <div class="erp-form-group">
                          <label for="subject_id" class="erp-form-label">Subject <span class="required">*</span></label>
                          <select class="form-control" id="subject_id" name="subject_id" required>
                            <option value="" disabled selected>-- Select Subject --</option>
                            @foreach ($subjects as $subject)
                              <option value="{{ $subject->id }}" {{ old('subject_id', $assignment->subject_id) == $subject->id ? 'selected' : '' }}>
                                {{ $subject->subject_name }}
                              </option>
                            @endforeach
                          </select>
                          @error('subject_id')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <!-- Description -->
                      <div class="col-md-12">
                        <div class="erp-form-group">
                          <label for="description" class="erp-form-label">Assignment Instructions & Guidelines <span class="required">*</span></label>
                          <textarea class="form-control" id="description" name="description" rows="4" placeholder="Explain the assignment problems, submission criteria, format required..." required>{{ old('description', $assignment->description) }}</textarea>
                          @error('description')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <!-- Attachment File -->
                      <div class="col-md-12">
                        <div class="erp-form-group mb-0">
                          <label for="assignment" class="erp-form-label">Replace Assignment File (Optional)</label>
                          <input type="file" class="form-control" id="assignment" name="assignment">
                          @if($assignment->assignment)
                            <div class="mt-2 p-2 rounded bg-light border d-inline-flex align-items-center">
                              <i class="fas fa-file text-primary mr-2"></i>
                              <span class="small mr-3">Current File: {{ basename($assignment->assignment) }}</span>
                              <a href="{{ asset('storage/' . $assignment->assignment) }}" target="_blank" class="btn btn-xs btn-outline-primary">
                                <i class="fas fa-external-link-alt"></i> View File
                              </a>
                            </div>
                          @endif
                          @error('assignment')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Form Action Footer -->
                  <div class="erp-form-footer">
                    <a href="{{ route('assignment_show') }}" class="btn btn-sm btn-outline-secondary">
                      Cancel
                    </a>
                    <button type="submit" class="erp-btn-submit">
                      <i class="fas fa-save"></i> Update Assignment
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
