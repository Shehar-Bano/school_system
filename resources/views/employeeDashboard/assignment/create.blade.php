@extends('employeeDashboard.employeeView.masterpage')

@section('content')
<div class="main-panel">
  <div class="content-wrapper">
    <div class="row justify-content-center">
      <div class="col-lg-11 col-xl-10">

        <!-- Modern ERP Form Card -->
        <div class="erp-card-form">
          <div class="erp-form-header-block">
            <div class="d-flex align-items-center gap-3">
              <div class="erp-header-icon-badge" style="background: #eef2ff; color: #4f46e5;">
                <i class="fas fa-plus"></i>
              </div>
              <div class="erp-form-title-area">
                <h3 class="erp-form-title">
                  Create Class Assignment
                </h3>
                <p class="erp-form-subtitle">Assign homework, project tasks, guidelines, and submission deadline for your students</p>
              </div>
            </div>

            <div>
              <a href="{{ route('employee.assignments') }}" class="erp-btn-back">
                <i class="fas fa-arrow-left"></i> Back to Assignments
              </a>
            </div>
          </div>

          <form action="{{ route('employee.assignment.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="erp-form-body">
              <div class="row g-3">
                <!-- Title -->
                <div class="col-md-8">
                  <div class="erp-form-group">
                    <label for="title" class="erp-form-label">Assignment Title <span class="required">*</span></label>
                    <div class="erp-input-wrapper">
                      <i class="fas fa-tag input-icon-prefix"></i>
                      <input type="text" class="form-control has-prefix-icon" id="title" name="title" value="{{ old('title') }}" placeholder="e.g. Chapter 4 Numerical Problems & Summary" required autofocus>
                    </div>
                    @error('title')
                      <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <!-- Total Marks -->
                <div class="col-md-4">
                  <div class="erp-form-group">
                    <label for="totalMarks" class="erp-form-label">Total Marks <span class="required">*</span></label>
                    <div class="erp-input-wrapper">
                      <i class="fas fa-star input-icon-prefix"></i>
                      <input type="number" class="form-control has-prefix-icon" id="totalMarks" name="total_marks" value="{{ old('total_marks', 100) }}" min="1" required>
                    </div>
                    @error('total_marks')
                      <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <!-- Target Class -->
                <div class="col-md-4">
                  <div class="erp-form-group">
                    <label for="class_id" class="erp-form-label">Target Class <span class="required">*</span></label>
                    <select class="form-control" name="class_id" id="class_id" required>
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

                <!-- Target Section -->
                <div class="col-md-4">
                  <div class="erp-form-group">
                    <label for="section_id" class="erp-form-label">Target Section <span class="required">*</span></label>
                    <select class="form-control" name="section_id" id="section_id" required>
                      <option value="" disabled selected>-- Select Section --</option>
                      @foreach ($sections as $section)
                        <option value="{{ $section->id }}" {{ old('section_id') == $section->id ? 'selected' : '' }}>
                          {{ $section->name }}
                        </option>
                      @endforeach
                    </select>
                    @error('section_id')
                      <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <!-- Subject -->
                <div class="col-md-4">
                  <div class="erp-form-group">
                    <label for="subject_id" class="erp-form-label">Curriculum Subject <span class="required">*</span></label>
                    <select class="form-control" name="subject_id" id="subject_id" required>
                      <option value="" disabled selected>-- Select Subject --</option>
                      @foreach ($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                          {{ $subject->subject_name }} ({{ $subject->sub_code ?? 'SUB' }})
                        </option>
                      @endforeach
                    </select>
                    @error('subject_id')
                      <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <!-- Deadline -->
                <div class="col-md-6">
                  <div class="erp-form-group">
                    <label for="deadline" class="erp-form-label">Submission Due Date / Deadline <span class="required">*</span></label>
                    <div class="erp-input-wrapper">
                      <i class="fas fa-calendar-day input-icon-prefix"></i>
                      <input type="date" class="form-control has-prefix-icon" id="deadline" name="deadline" value="{{ old('deadline') }}" required min="{{ date('Y-m-d') }}">
                    </div>
                    @error('deadline')
                      <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <!-- Worksheet Attachment -->
                <div class="col-md-6">
                  <div class="erp-form-group">
                    <label for="assignment" class="erp-form-label">Upload Worksheet / Task File <span class="required">*</span></label>
                    <input type="file" class="form-control" id="assignment" name="assignment" required accept=".pdf,.doc,.docx,.png,.jpg,.jpeg,.zip,.ppt,.pptx">
                    @error('assignment')
                      <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <!-- Description / Instructions -->
                <div class="col-12">
                  <div class="erp-form-group mb-0">
                    <label for="description" class="erp-form-label">Assignment Instructions & Guidelines <span class="required">*</span></label>
                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter detailed homework instructions, formatting guidelines, or questions for students..." required>{{ old('description') }}</textarea>
                    @error('description')
                      <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
              </div>
            </div>

            <!-- Footer Actions -->
            <div class="erp-form-footer">
              <a href="{{ route('employee.assignments') }}" class="btn btn-sm btn-outline-secondary">
                Cancel
              </a>
              <button type="submit" class="erp-btn-submit">
                <i class="fas fa-paper-plane mr-1"></i> Publish Assignment
              </button>
            </div>
          </form>

        </div>

      </div>
    </div>
  </div>
</div>
@endsection
