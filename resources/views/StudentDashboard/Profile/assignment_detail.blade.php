<!DOCTYPE html>
<html lang="en">
@include('StudentDashboard.ViewFile.head')

<style>
  /* Custom LMS Assignment Detail Styles */
  .lms-hero-banner {
    background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4338ca 100%);
    border-radius: 16px;
    padding: 28px 32px;
    color: #ffffff;
    box-shadow: 0 10px 25px -5px rgba(67, 56, 202, 0.25);
    margin-bottom: 24px;
    position: relative;
    overflow: hidden;
  }

  .lms-hero-banner::after {
    content: '';
    position: absolute;
    top: -50px;
    right: -50px;
    width: 220px;
    height: 220px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0) 70%);
    pointer-events: none;
  }

  .lms-badge-subject {
    background: rgba(255, 255, 255, 0.18);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.25);
    color: #ffffff;
    font-size: 12px;
    font-weight: 700;
    padding: 5px 12px;
    border-radius: 9999px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }

  .lms-detail-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
    margin-bottom: 24px;
    overflow: hidden;
    transition: box-shadow 0.2s ease;
  }

  .lms-detail-card:hover {
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
  }

  .lms-card-header {
    padding: 18px 24px;
    background: #ffffff;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
  }

  .lms-card-header-title {
    font-size: 16px;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .lms-card-body {
    padding: 24px;
  }

  /* File Dropzone Style */
  .lms-dropzone {
    border: 2px dashed #cbd5e1;
    border-radius: 12px;
    padding: 24px 16px;
    text-align: center;
    background: #f8fafc;
    cursor: pointer;
    transition: all 0.2s ease;
    position: relative;
  }

  .lms-dropzone:hover, .lms-dropzone.dragover {
    border-color: #4f46e5;
    background: #eef2ff;
  }

  .lms-dropzone input[type="file"] {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
  }

  /* Selected File Preview Box */
  .lms-file-preview {
    display: none;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 10px;
    padding: 12px 16px;
    margin-top: 12px;
  }

  /* Deadline Pill Countdown */
  .lms-deadline-widget {
    background: #f8fafc;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    padding: 16px;
    margin-bottom: 18px;
  }

  /* Teacher Remarks Bubble */
  .lms-feedback-bubble {
    background: #f8fafc;
    border-left: 4px solid #4f46e5;
    border-radius: 0 12px 12px 0;
    padding: 16px 20px;
    position: relative;
  }

  /* Score Highlight Badge */
  .lms-score-badge {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: #ffffff;
    border-radius: 12px;
    padding: 14px 20px;
    text-align: center;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);
  }

  .lms-btn-submit-solution {
    background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
    color: #ffffff;
    border: none;
    border-radius: 10px;
    padding: 12px 24px;
    font-weight: 700;
    font-size: 14px;
    box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35);
    transition: all 0.2s ease;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
  }

  .lms-btn-submit-solution:hover {
    background: linear-gradient(135deg, #4338ca 0%, #4f46e5 100%);
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(79, 70, 229, 0.45);
    color: #ffffff;
  }
</style>

<body>
  <div class="container-scroller">
    @include('StudentDashboard.ViewFile.nav')
    <div class="container-fluid page-body-wrapper">
      @include('StudentDashboard.ViewFile.sidebar')

      <div class="main-panel">
        <div class="content-wrapper">

          <!-- Top Navigation Breadcrumb Bar -->
          <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb mb-0 p-0" style="background: transparent; font-size: 13px;">
                <li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}" class="text-primary font-weight-semibold"><i class="fas fa-home me-1"></i> Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('student.assignments') }}" class="text-primary font-weight-semibold">Assignments</a></li>
                <li class="breadcrumb-item active text-muted" aria-current="page">{{ Str::limit($assignment->title, 35) }}</li>
              </ol>
            </nav>

            <a href="{{ route('student.assignments') }}" class="erp-btn-back">
              <i class="fas fa-arrow-left me-1"></i> Back to All Assignments
            </a>
          </div>

          <!-- Hero Banner -->
          <div class="lms-hero-banner">
            <div class="row align-items-center gy-3">
              <div class="col-lg-8">
                <div class="d-flex align-items-center gap-2 mb-2">
                  <span class="lms-badge-subject">
                    <i class="fas fa-book-bookmark"></i>
                    {{ $assignment->subject->subject_name ?? 'Academic Subject' }}
                  </span>
                  
                  @if($submission)
                    @if($submission->marks !== null)
                      <span class="badge bg-success text-white px-3 py-1" style="border-radius: 9999px; font-size: 11.5px;">
                        <i class="fas fa-award me-1"></i> Graded ({{ $submission->marks }}/{{ $assignment->total_marks ?? 100 }})
                      </span>
                    @else
                      <span class="badge bg-info text-white px-3 py-1" style="border-radius: 9999px; font-size: 11.5px;">
                        <i class="fas fa-check-circle me-1"></i> Submitted ({{ $submission->status == 'late' ? 'Late' : 'On-Time' }})
                      </span>
                    @endif
                  @else
                    @if($isDeadlinePassed)
                      <span class="badge bg-danger text-white px-3 py-1" style="border-radius: 9999px; font-size: 11.5px;">
                        <i class="fas fa-triangle-exclamation me-1"></i> Past Deadline
                      </span>
                    @else
                      <span class="badge bg-warning text-dark px-3 py-1 font-weight-bold" style="border-radius: 9999px; font-size: 11.5px;">
                        <i class="fas fa-hourglass-start me-1"></i> Pending Submission
                      </span>
                    @endif
                  @endif
                </div>

                <h2 class="font-weight-bold text-white mb-2" style="font-size: 24px; letter-spacing: -0.3px;">
                  {{ $assignment->title }}
                </h2>

                <div class="d-flex align-items-center flex-wrap gap-3 text-white-50" style="font-size: 13px;">
                  <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center bg-white text-primary" style="width: 24px; height: 24px; font-size: 11px;">
                      <i class="fas fa-chalkboard-user"></i>
                    </div>
                    <span>Assigned by: <strong class="text-white">{{ $assignment->teacher->name ?? $assignment->uploader ?? 'Class Instructor' }}</strong></span>
                  </div>

                  <span>•</span>

                  <div>
                    <i class="fas fa-users-rectangle me-1"></i>
                    <span>Class: <strong class="text-white">{{ $assignment->class->name ?? '' }} ({{ $assignment->section->name ?? '' }})</strong></span>
                  </div>

                  <span>•</span>

                  <div>
                    <i class="fas fa-calendar-check me-1"></i>
                    <span>Assigned: <strong class="text-white">{{ $assignment->created_at ? $assignment->created_at->format('M d, Y') : 'Session 2026' }}</strong></span>
                  </div>
                </div>
              </div>

              <!-- Hero Right Column Metric -->
              <div class="col-lg-4 text-lg-end">
                <div class="d-inline-flex flex-column align-items-lg-end">
                  <div class="text-white-50 text-xs text-uppercase font-weight-bold mb-1">Maximum Score</div>
                  <div class="h2 font-weight-bolder text-white mb-0">
                    <i class="fas fa-star text-warning me-1"></i> {{ $assignment->total_marks ?? 100 }} <span class="fs-6 font-weight-normal text-white-50">Pts</span>
                  </div>
                  <div class="text-white-50 text-xs mt-1">
                    Due: {{ \Carbon\Carbon::parse($assignment->deadline)->format('D, M d, Y') }}
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Main Content Grid -->
          <div class="row g-4">
            
            <!-- LEFT COLUMN: Instructions, Attachments & Submission Records -->
            <div class="col-lg-8">
              
              <!-- 1. Assignment Task Description & Instructions -->
              <div class="lms-detail-card">
                <div class="lms-card-header">
                  <h4 class="lms-card-header-title">
                    <i class="fas fa-file-lines text-primary"></i>
                    Assignment Brief & Guidelines
                  </h4>
                  <span class="badge badge-soft-primary font-weight-semibold">Instructions</span>
                </div>

                <div class="lms-card-body">
                  <div class="p-3 rounded border mb-4" style="background: #fafafa; border-color: #e2e8f0 !important;">
                    <div style="font-size: 14px; line-height: 1.7; color: #334155; white-space: pre-wrap;">{{ $assignment->description ?: 'Please refer to the attached assignment worksheet and complete all questions accordingly. Ensure neat presentation and submit before the deadline.' }}</div>
                  </div>

                  <!-- Teacher Attached Worksheet / Download Box -->
                  @if($assignment->assignment)
                    @php
                      $extension = strtolower(pathinfo($assignment->assignment, PATHINFO_EXTENSION));
                      $fileIcon = 'fa-file-pdf text-danger';
                      if(in_array($extension, ['doc', 'docx'])) $fileIcon = 'fa-file-word text-primary';
                      elseif(in_array($extension, ['xls', 'xlsx'])) $fileIcon = 'fa-file-excel text-success';
                      elseif(in_array($extension, ['zip', 'rar'])) $fileIcon = 'fa-file-zipper text-warning';
                      elseif(in_array($extension, ['jpg', 'png', 'jpeg'])) $fileIcon = 'fa-file-image text-info';
                    @endphp

                    <div class="p-3 rounded border d-flex align-items-center justify-content-between flex-wrap gap-3" style="background: #f0fdf4; border-color: #bbf7d0 !important;">
                      <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center bg-white shadow-sm" style="width: 44px; height: 44px;">
                          <i class="fas {{ $fileIcon }} fa-xl"></i>
                        </div>
                        <div>
                          <div class="font-weight-bold text-dark" style="font-size: 14px;">Instructor's Attached Material / Worksheet</div>
                          <div class="text-muted text-xs">Official question paper & reference worksheet</div>
                        </div>
                      </div>

                      <a href="{{ asset('storage/' . $assignment->assignment) }}" target="_blank" download class="btn btn-sm btn-success font-weight-bold px-3 py-2 shadow-sm d-inline-flex align-items-center gap-2">
                        <i class="fas fa-cloud-arrow-down"></i>
                        <span>Download Worksheet</span>
                      </a>
                    </div>
                  @endif
                </div>
              </div>

              <!-- 2. Teacher Feedback & Grade Evaluation (If Graded) -->
              @if($submission && $submission->marks !== null)
                <div class="lms-detail-card" style="border-left: 4px solid #10b981 !important;">
                  <div class="lms-card-header">
                    <h4 class="lms-card-header-title text-success">
                      <i class="fas fa-medal text-success"></i>
                      Teacher Evaluation & Grading Report
                    </h4>
                    <span class="badge bg-success text-white">Graded</span>
                  </div>

                  <div class="lms-card-body">
                    <div class="row align-items-center g-3 mb-4">
                      <!-- Score Visual -->
                      <div class="col-md-5">
                        <div class="lms-score-badge">
                          <div class="text-uppercase text-xs font-weight-bold text-white-50">Score Obtained</div>
                          <div class="h1 font-weight-bolder text-white mb-0">{{ $submission->marks }} <span class="fs-5 font-weight-normal">/ {{ $assignment->total_marks ?? 100 }}</span></div>
                          <div class="small text-white-50 mt-1 font-weight-semibold">
                            Percentage: {{ round(($submission->marks / ($assignment->total_marks ?? 100)) * 100, 1) }}%
                          </div>
                        </div>
                      </div>

                      <!-- Evaluator Info -->
                      <div class="col-md-7">
                        <div class="p-3 bg-light rounded border">
                          <div class="text-xs text-muted text-uppercase font-weight-bold mb-1">Evaluated By</div>
                          <div class="font-weight-bold text-dark d-flex align-items-center gap-2">
                            <i class="fas fa-chalkboard-user text-primary"></i>
                            {{ $submission->graded_by ?? ($assignment->teacher->name ?? 'Instructor') }}
                          </div>
                          <div class="text-muted text-xs mt-1">
                            Graded on {{ $submission->graded_at ? \Carbon\Carbon::parse($submission->graded_at)->format('M d, Y') : ($submission->updated_at ? $submission->updated_at->format('M d, Y') : 'Recent') }}
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Teacher Comments Bubble -->
                    <div class="mb-2">
                      <label class="text-xs font-weight-bold text-muted text-uppercase mb-2 d-block">Instructor's Feedback & Remarks</label>
                      <div class="lms-feedback-bubble">
                        <div class="d-flex align-items-start gap-2">
                          <i class="fas fa-quote-left text-muted me-2" style="font-size: 16px;"></i>
                          <div class="text-dark font-weight-medium" style="font-size: 13.5px; line-height: 1.6;">
                            {{ $submission->feedback ?: 'Excellent work and comprehensive solutions submitted on time. Keep up the consistent effort!' }}
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              @endif

              <!-- 3. Current Submission Record (If already submitted) -->
              @if($submission)
                <div class="lms-detail-card">
                  <div class="lms-card-header">
                    <h4 class="lms-card-header-title">
                      <i class="fas fa-box-archive text-primary"></i>
                      Your Submitted Work Record
                    </h4>
                    <span class="badge badge-soft-{{ $submission->status == 'late' ? 'warning' : 'success' }} font-weight-bold">
                      <i class="fas {{ $submission->status == 'late' ? 'fa-clock' : 'fa-circle-check' }} me-1"></i>
                      {{ $submission->status == 'late' ? 'Submitted Late' : 'Submitted On-Time' }}
                    </span>
                  </div>

                  <div class="lms-card-body">
                    <div class="d-flex align-items-center gap-2 text-muted text-xs mb-3">
                      <i class="fas fa-calendar-check text-success"></i>
                      <span>Submission Date: <strong class="text-dark">{{ $submission->submitted_at ? $submission->submitted_at->format('M d, Y \a\t h:i A') : $submission->updated_at->format('M d, Y \a\t h:i A') }}</strong></span>
                    </div>

                    @if($submission->submission_file)
                      @php
                        $subExtension = strtolower(pathinfo($submission->submission_file, PATHINFO_EXTENSION));
                        $subIcon = 'fa-file-pdf text-danger';
                        if(in_array($subExtension, ['doc', 'docx'])) $subIcon = 'fa-file-word text-primary';
                        elseif(in_array($subExtension, ['zip', 'rar'])) $subIcon = 'fa-file-zipper text-warning';
                        elseif(in_array($subExtension, ['jpg', 'png', 'jpeg'])) $subIcon = 'fa-file-image text-info';
                      @endphp

                      <div class="p-3 bg-light rounded border mb-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-3">
                          <i class="fas {{ $subIcon }} fa-2x"></i>
                          <div>
                            <div class="font-weight-bold text-dark text-xs">Attached Solution Document</div>
                            <small class="text-muted">{{ basename($submission->submission_file) }}</small>
                          </div>
                        </div>

                        <a href="{{ asset('storage/' . $submission->submission_file) }}" target="_blank" class="btn btn-sm btn-outline-primary font-weight-bold d-inline-flex align-items-center gap-2">
                          <i class="fas fa-arrow-up-right-from-square"></i>
                          <span>View / Download</span>
                        </a>
                      </div>
                    @endif

                    @if($submission->submission_text)
                      <div class="mt-3">
                        <label class="text-xs font-weight-bold text-muted text-uppercase mb-1 d-block">Submitted Solution Notes</label>
                        <div class="p-3 rounded border bg-light text-secondary" style="font-size: 13px; line-height: 1.6; white-space: pre-wrap;">{{ $submission->submission_text }}</div>
                      </div>
                    @endif
                  </div>
                </div>
              @endif

            </div>

            <!-- RIGHT COLUMN: Action Box, Deadline Tracker & Academic Guidelines -->
            <div class="col-lg-4">

              <!-- 1. Deadline Tracker Widget -->
              <div class="lms-detail-card">
                <div class="lms-card-header">
                  <h4 class="lms-card-header-title">
                    <i class="fas fa-stopwatch text-primary"></i>
                    Deadline Tracker
                  </h4>
                </div>

                <div class="lms-card-body">
                  <div class="lms-deadline-widget {{ $isDeadlinePassed ? 'border-danger bg-danger-subtle' : '' }}">
                    <div class="d-flex align-items-center gap-3">
                      <div class="rounded-circle d-flex align-items-center justify-content-center {{ $isDeadlinePassed ? 'bg-danger text-white' : 'bg-primary text-white' }}" style="width: 42px; height: 42px; font-size: 18px;">
                        <i class="fas {{ $isDeadlinePassed ? 'fa-calendar-xmark' : 'fa-calendar-day' }}"></i>
                      </div>
                      <div>
                        <div class="text-xs text-muted text-uppercase font-weight-bold">Due Date</div>
                        <div class="font-weight-bolder text-dark" style="font-size: 14.5px;">
                          {{ \Carbon\Carbon::parse($assignment->deadline)->format('M d, Y') }}
                        </div>
                        <small class="{{ $isDeadlinePassed ? 'text-danger font-weight-bold' : 'text-primary font-weight-semibold' }}">
                          {{ $isDeadlinePassed ? 'Deadline Passed' : 'Active for submission' }}
                        </small>
                      </div>
                    </div>
                  </div>

                  <!-- Quick Stats Grid -->
                  <div class="row g-2 text-center">
                    <div class="col-6">
                      <div class="p-2 rounded border bg-light">
                        <div class="text-xs text-muted">Status</div>
                        <div class="font-weight-bold {{ $submission ? 'text-success' : ($isDeadlinePassed ? 'text-danger' : 'text-warning') }} text-xs mt-1">
                          {{ $submission ? 'Completed' : ($isDeadlinePassed ? 'Overdue' : 'Pending') }}
                        </div>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="p-2 rounded border bg-light">
                        <div class="text-xs text-muted">Total Marks</div>
                        <div class="font-weight-bold text-dark text-xs mt-1">
                          {{ $assignment->total_marks ?? 100 }} Pts
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- 2. Interactive Submission Box -->
              <div class="lms-detail-card">
                <div class="lms-card-header">
                  <h4 class="lms-card-header-title">
                    <i class="fas fa-cloud-arrow-up text-primary"></i>
                    {{ $submission ? 'Update Submission' : 'Submit Assignment' }}
                  </h4>
                </div>

                <div class="lms-card-body">
                  @if($isDeadlinePassed)
                    <div class="alert alert-warning py-2 px-3 mb-3 d-flex align-items-center gap-2" style="font-size: 12px; border-radius: 8px;">
                      <i class="fas fa-triangle-exclamation text-warning"></i>
                      <div><strong>Notice:</strong> Deadline has passed. Submitting now will mark your submission as <strong>Late</strong>.</div>
                    </div>
                  @endif

                  <form action="{{ route('student.assignment.submit', ['id' => $assignment->id]) }}" method="POST" enctype="multipart/form-data" id="studentAssignmentSubmitForm" onsubmit="handleAssignmentSubmit(event)">
                    @csrf

                    <!-- Drag & Drop Dropzone File Input -->
                    <div class="mb-3">
                      <label class="form-label text-xs font-weight-bold text-uppercase text-muted mb-2">
                        Attachment Solution File
                      </label>
                      <div class="lms-dropzone" id="dropzoneArea" onclick="document.getElementById('fileInputEl').click()">
                        <input type="file" id="fileInputEl" name="submission_file" accept=".pdf,.doc,.docx,.png,.jpg,.jpeg,.zip,.ppt,.pptx" onchange="handleFileSelected(this)">
                        <i class="fas fa-cloud-arrow-up fa-2x text-primary mb-2"></i>
                        <div class="font-weight-bold text-dark text-xs mb-1">Click to browse or drop file here</div>
                        <div class="text-muted" style="font-size: 11px;">PDF, Word, Images, Zip (Max 20MB)</div>
                      </div>

                      <!-- Selected File Info -->
                      <div class="lms-file-preview" id="filePreviewBox">
                        <div class="d-flex align-items-center justify-content-between">
                          <div class="d-flex align-items-center gap-2 text-truncate">
                            <i class="fas fa-file-check text-success"></i>
                            <span class="font-weight-semibold text-xs text-dark text-truncate" id="selectedFileName">filename.pdf</span>
                            <span class="text-muted text-xs" id="selectedFileSize">(0 KB)</span>
                          </div>
                          <button type="button" class="btn btn-xs text-danger" onclick="clearSelectedFile(event)" title="Remove file">
                            <i class="fas fa-xmark"></i>
                          </button>
                        </div>
                      </div>

                      @error('submission_file')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                      @enderror
                    </div>

                    <!-- Solution Notes / Explanation Textarea -->
                    <div class="mb-3">
                      <label for="submissionText" class="form-label text-xs font-weight-bold text-uppercase text-muted mb-2">
                        Solution Notes & Answers <span class="text-muted font-weight-normal">(Optional)</span>
                      </label>
                      <textarea class="form-control" id="submissionText" name="submission_text" rows="4" placeholder="Type your answers, notes, equations, or submission comments here..." style="font-size: 13px; border-radius: 10px;">{{ old('submission_text', $submission->submission_text ?? '') }}</textarea>
                      @error('submission_text')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                      @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="lms-btn-submit-solution" id="submitBtn">
                      <span class="btn-text">
                        <i class="fas fa-paper-plane me-1"></i>
                        {{ $submission ? 'Update & Resubmit Task' : 'Submit Assignment' }}
                      </span>
                      <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    </button>
                  </form>
                </div>
              </div>

              <!-- 3. Submission Guidelines -->
              <div class="lms-detail-card">
                <div class="lms-card-header">
                  <h4 class="lms-card-header-title text-muted" style="font-size: 14px;">
                    <i class="fas fa-circle-info text-primary"></i>
                    Student Guidelines
                  </h4>
                </div>
                <div class="lms-card-body p-3">
                  <ul class="list-unstyled mb-0" style="font-size: 12.5px; color: #64748b; line-height: 1.8;">
                    <li class="d-flex align-items-start gap-2 mb-2">
                      <i class="fas fa-check text-success mt-1"></i>
                      <span>Ensure handwriting/scans are clear and legible before uploading.</span>
                    </li>
                    <li class="d-flex align-items-start gap-2 mb-2">
                      <i class="fas fa-check text-success mt-1"></i>
                      <span>Multiple resubmissions are allowed until grading is finalized.</span>
                    </li>
                    <li class="d-flex align-items-start gap-2">
                      <i class="fas fa-check text-success mt-1"></i>
                      <span>Check back after deadline for teacher grades and performance feedback.</span>
                    </li>
                  </ul>
                </div>
              </div>

            </div>

          </div>

        </div>
      </div>
    </div>
  </div>

  @include('StudentDashboard.ViewFile.script')

  <script>
    // File Selection Preview Handler
    function handleFileSelected(input) {
      if (input.files && input.files[0]) {
        const file = input.files[0];
        const previewBox = document.getElementById('filePreviewBox');
        const fileNameEl = document.getElementById('selectedFileName');
        const fileSizeEl = document.getElementById('selectedFileSize');

        fileNameEl.innerText = file.name;
        const sizeInKB = (file.size / 1024).toFixed(1);
        fileSizeEl.innerText = sizeInKB > 1024 ? `(${(sizeInKB / 1024).toFixed(2)} MB)` : `(${sizeInKB} KB)`;
        
        previewBox.style.display = 'block';
      }
    }

    function clearSelectedFile(event) {
      event.stopPropagation();
      const input = document.getElementById('fileInputEl');
      input.value = '';
      document.getElementById('filePreviewBox').style.display = 'none';
    }

    // Drag & Drop visual feedback
    const dropzone = document.getElementById('dropzoneArea');
    ['dragenter', 'dragover'].forEach(eventName => {
      dropzone.addEventListener(eventName, (e) => {
        e.preventDefault();
        dropzone.classList.add('dragover');
      }, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
      dropzone.addEventListener(eventName, (e) => {
        e.preventDefault();
        dropzone.classList.remove('dragover');
      }, false);
    });

    // Handle Assignment Submit Animation
    function handleAssignmentSubmit(event) {
      const btn = document.getElementById('submitBtn');
      btn.querySelector('.btn-text').classList.add('d-none');
      btn.querySelector('.spinner-border').classList.remove('d-none');
      btn.disabled = true;
    }

    // Flash Message Notification
    @if(session('message'))
      Swal.fire({
        icon: 'success',
        title: 'Submission Successful!',
        text: "{{ session('message') }}",
        confirmButtonColor: '#4f46e5'
      });
    @endif
  </script>
</body>
</html>
