<!DOCTYPE html>
<html lang="en">
@include('StudentDashboard.ViewFile.head')

<body>
  <div class="container-scroller">
    @include('StudentDashboard.ViewFile.nav')
    <div class="container-fluid page-body-wrapper">
      @include('StudentDashboard.ViewFile.sidebar')

      <div class="main-panel">
        <div class="content-wrapper">

          <div class="row justify-content-center">
            <div class="col-lg-11 col-xl-10">

              <!-- Assignment Details Card -->
              <div class="erp-card-form mb-4">
                <div class="erp-form-header-block">
                  <div class="d-flex align-items-center gap-3">
                    <div class="erp-header-icon-badge" style="background: #eef2ff; color: #4f46e5;">
                      <i class="fas fa-clipboard-question"></i>
                    </div>
                    <div class="erp-form-title-area">
                      <h3 class="erp-form-title">
                        {{ $assignment->title }}
                      </h3>
                      <p class="erp-form-subtitle">{{ $assignment->subject->subject_name ?? 'Subject' }} | Assigned by {{ $assignment->teacher->name ?? $assignment->uploader ?? 'Class Teacher' }}</p>
                    </div>
                  </div>

                  <div>
                    <a href="{{ route('student.assignments') }}" class="erp-btn-back">
                      <i class="fas fa-arrow-left"></i> Back to Assignments
                    </a>
                  </div>
                </div>

                <div class="erp-form-body">
                  <div class="row g-4 mb-3">
                    <div class="col-md-4">
                      <label class="text-xs font-weight-bold text-muted text-uppercase mb-1 d-block">Subject</label>
                      <div class="font-weight-semibold text-dark">
                        <i class="fas fa-book text-primary mr-1"></i> {{ $assignment->subject->subject_name ?? 'N/A' }}
                      </div>
                    </div>

                    <div class="col-md-4">
                      <label class="text-xs font-weight-bold text-muted text-uppercase mb-1 d-block">Submission Deadline</label>
                      <div class="font-weight-semibold {{ $isDeadlinePassed ? 'text-danger' : 'text-primary' }}">
                        <i class="fas fa-clock mr-1"></i> {{ $assignment->deadline }}
                        @if($isDeadlinePassed)
                          <span class="badge badge-soft-danger ml-1">Deadline Passed</span>
                        @else
                          <span class="badge badge-soft-success ml-1">Active</span>
                        @endif
                      </div>
                    </div>

                    <div class="col-md-4">
                      <label class="text-xs font-weight-bold text-muted text-uppercase mb-1 d-block">Total Marks</label>
                      <div class="font-weight-bold text-success fs-6">
                        <i class="fas fa-star mr-1"></i> {{ $assignment->total_marks ?? 100 }} Marks
                      </div>
                    </div>
                  </div>

                  <!-- Assignment Task Instructions -->
                  <div class="mb-4">
                    <label class="text-xs font-weight-bold text-muted text-uppercase mb-2 d-block">Task Instructions & Description</label>
                    <div class="p-3 bg-light rounded text-secondary" style="white-space: pre-wrap; line-height: 1.6; font-size: 13px;">
                      {{ $assignment->description }}
                    </div>
                  </div>

                  <!-- Attachment / Worksheet Download -->
                  @if($assignment->assignment)
                    <div class="p-3 border rounded mb-4" style="background: #f0fdf4; border-color: #bbf7d0 !important;">
                      <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-2">
                          <i class="fas fa-file-arrow-down fa-2x text-success"></i>
                          <div>
                            <div class="font-weight-semibold text-dark">Teacher's Attached Worksheet / Material</div>
                            <small class="text-muted">Download assignment questions or supporting materials</small>
                          </div>
                        </div>
                        <a href="{{ asset('storage/' . $assignment->assignment) }}" target="_blank" class="btn btn-sm btn-success font-weight-semibold">
                          <i class="fas fa-download mr-1"></i> Download Worksheet
                        </a>
                      </div>
                    </div>
                  @endif
                </div>
              </div>

              <!-- Student Submission Status & Upload Box -->
              <div class="erp-card-form">
                <div class="erp-form-header-block">
                  <div class="d-flex align-items-center gap-3">
                    <div class="erp-header-icon-badge" style="background: {{ $submission ? '#f0fdf4' : '#fffbeb' }}; color: {{ $submission ? '#16a34a' : '#d97706' }};">
                      <i class="fas {{ $submission ? 'fa-circle-check' : 'fa-upload' }}"></i>
                    </div>
                    <div class="erp-form-title-area">
                      <h3 class="erp-form-title">
                        Your Submission Response
                      </h3>
                      <p class="erp-form-subtitle">
                        @if($submission)
                          Your response was submitted on {{ $submission->submitted_at ? $submission->submitted_at->format('M d, Y \a\t h:i A') : 'N/A' }}
                        @else
                          Upload your solution document or write your notes below
                        @endif
                      </p>
                    </div>
                  </div>

                  @if($submission)
                    <div>
                      <span class="badge badge-soft-{{ $submission->marks !== null ? 'success' : 'primary' }} font-weight-bold" style="font-size: 13px; padding: 6px 12px;">
                        @if($submission->marks !== null)
                          <i class="fas fa-award mr-1"></i> Graded: {{ $submission->marks }} / {{ $assignment->total_marks ?? 100 }}
                        @else
                          <i class="fas fa-check mr-1"></i> Submitted ({{ $submission->status == 'late' ? 'Late' : 'On-Time' }})
                        @endif
                      </span>
                    </div>
                  @endif
                </div>

                <div class="erp-form-body">
                  @if($submission)
                    <!-- Submitted Details Display -->
                    <div class="row g-3 mb-4">
                      <!-- Submission File -->
                      @if($submission->submission_file)
                        <div class="col-md-6">
                          <label class="text-xs font-weight-bold text-muted text-uppercase mb-1 d-block">Your Submitted File</label>
                          <div class="p-3 bg-light rounded border d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                              <i class="fas fa-file-pdf text-danger fa-2x"></i>
                              <div>
                                <div class="font-weight-semibold text-dark text-xs">Submitted Solution Document</div>
                                <small class="text-muted">Uploaded on {{ $submission->submitted_at ? $submission->submitted_at->format('M d, Y') : '' }}</small>
                              </div>
                            </div>
                            <a href="{{ asset('storage/' . $submission->submission_file) }}" target="_blank" class="btn btn-xs btn-primary font-weight-semibold">
                              <i class="fas fa-download mr-1"></i> View / Download
                            </a>
                          </div>
                        </div>
                      @endif

                      <!-- Grade & Feedback -->
                      <div class="col-md-6">
                        <label class="text-xs font-weight-bold text-muted text-uppercase mb-1 d-block">Marks & Feedback</label>
                        <div class="p-3 bg-light rounded border">
                          @if($submission->marks !== null)
                            <div class="d-flex align-items-center justify-content-between mb-2">
                              <span class="font-weight-bold text-success fs-5">{{ $submission->marks }} / {{ $assignment->total_marks ?? 100 }}</span>
                              <span class="badge badge-soft-success">Graded by {{ $submission->graded_by ?? 'Teacher' }}</span>
                            </div>
                            <p class="text-muted small mb-0"><strong>Teacher Remarks:</strong> {{ $submission->feedback ?? 'Well done!' }}</p>
                          @else
                            <div class="text-muted small">
                              <i class="fas fa-hourglass-half mr-1 text-warning"></i> Your submission is pending teacher evaluation. Marks will appear here once graded.
                            </div>
                          @endif
                        </div>
                      </div>

                      <!-- Submitted Text Notes -->
                      @if($submission->submission_text)
                        <div class="col-12">
                          <label class="text-xs font-weight-bold text-muted text-uppercase mb-1 d-block">Your Solution Notes</label>
                          <div class="p-3 bg-light rounded border text-secondary" style="white-space: pre-wrap; font-size: 13px;">
                            {{ $submission->submission_text }}
                          </div>
                        </div>
                      @endif
                    </div>
                  @endif

                  <!-- Submission Form (if not submitted or if updating) -->
                  <div class="border rounded p-4" style="background: #fafafa;">
                    <h5 class="font-weight-bold text-dark mb-3">
                      <i class="fas fa-file-arrow-up text-primary mr-1"></i>
                      {{ $submission ? 'Resubmit / Update Assignment Solution' : 'Submit Assignment Solution' }}
                    </h5>

                    @if($isDeadlinePassed)
                      <div class="alert alert-warning small mb-3">
                        <i class="fas fa-triangle-exclamation mr-1"></i>
                        <strong>Notice:</strong> The deadline for this assignment was <strong>{{ $assignment->deadline }}</strong>. Your submission will be flagged as <strong>Late</strong>.
                      </div>
                    @endif

                    <form action="{{ route('student.assignment.submit', ['id' => $assignment->id]) }}" method="POST" enctype="multipart/form-data" id="studentSubmitForm">
                      @csrf

                      <!-- File Upload -->
                      <div class="erp-form-group mb-3">
                        <label for="submissionFile" class="erp-form-label">
                          Upload Assignment File / Document (PDF, Word, Images, Zip - Max 20MB)
                        </label>
                        <input type="file" class="form-control" id="submissionFile" name="submission_file" accept=".pdf,.doc,.docx,.png,.jpg,.jpeg,.zip,.ppt,.pptx">
                        @error('submission_file')
                          <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                      </div>

                      <!-- Solution Notes -->
                      <div class="erp-form-group mb-3">
                        <label for="submissionText" class="erp-form-label">
                          Solution Notes / Explanations / Answers (Optional if file attached)
                        </label>
                        <textarea class="form-control" id="submissionText" name="submission_text" rows="4" placeholder="Write your answers, references, or solution text here...">{{ old('submission_text', $submission->submission_text ?? '') }}</textarea>
                        @error('submission_text')
                          <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                      </div>

                      <div class="d-flex justify-content-end">
                        <button type="submit" class="erp-btn-submit">
                          <i class="fas fa-paper-plane mr-1"></i> {{ $submission ? 'Update Submission' : 'Submit Assignment' }}
                        </button>
                      </div>
                    </form>
                  </div>

                </div>
              </div>

            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  @include('StudentDashboard.ViewFile.script')
</body>
</html>
