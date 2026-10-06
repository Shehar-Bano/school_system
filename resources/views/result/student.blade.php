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
            <div class="col-lg-11 col-xl-10">
              
              <!-- Modern ERP Form Card -->
              <div class="erp-card-form">
                <div class="erp-form-header-block">
                  <div class="erp-form-title-area">
                    <h3 class="erp-form-title">
                      <i class="fas fa-file-pen text-primary"></i>
                      Enter Exam Marks
                    </h3>
                    <p class="erp-form-subtitle">Record individual student exam marks for {{ $subject->subject_name }} ({{ $class->name }} - {{ $section->name }})</p>
                  </div>

                  <!-- Back to List Button -->
                  <div>
                    <a href="{{ route('result') }}" class="erp-btn-back">
                      <i class="fas fa-arrow-left"></i> Back to Results
                    </a>
                  </div>
                </div>

                <form action="{{ route('result-store') }}" method="POST" id="storeMarksForm">
                  @csrf
                  
                  <!-- Hidden Session Parameters -->
                  <input type="hidden" name="exam" value="{{ $exam->id }}">
                  <input type="hidden" name="class" value="{{ $class->id }}">
                  <input type="hidden" name="section" value="{{ $section->id }}">
                  <input type="hidden" name="subject" value="{{ $subject->id }}">

                  <div class="erp-form-body">
                    <!-- Session Context Badges -->
                    <div class="p-3 bg-light rounded border mb-4 d-flex flex-wrap align-items-center gap-3 justify-content-between">
                      <div>
                        <span class="text-muted small d-block">Exam Term:</span>
                        <strong class="text-dark">{{ $exam->name }}</strong>
                      </div>
                      <div>
                        <span class="text-muted small d-block">Class & Section:</span>
                        <span class="badge badge-soft-primary">{{ $class->name }}</span>
                        <span class="badge badge-soft-purple">{{ $section->name }}</span>
                      </div>
                      <div>
                        <span class="text-muted small d-block">Subject:</span>
                        <span class="badge badge-soft-info"><i class="fas fa-book mr-1"></i> {{ $subject->subject_name }}</span>
                      </div>
                      <div>
                        <span class="text-muted small d-block">Max / Total Marks:</span>
                        <strong class="text-dark">{{ $subject->final_marks ?? 100 }}</strong>
                      </div>
                    </div>

                    @if($students->isNotEmpty())
                    <div class="table-responsive">
                      <table class="table table-bordered align-middle">
                        <thead class="bg-light">
                          <tr>
                            <th style="width: 50px;" class="text-center">#</th>
                            <th style="width: 40%;">Student Name</th>
                            <th style="width: 30%;">Obtained Marks <span class="text-danger">*</span></th>
                            <th style="width: 30%;">Total Marks <span class="text-danger">*</span></th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($students as $student)
                          <tr>
                            <td class="text-center text-muted font-weight-medium">{{ $loop->iteration }}</td>
                            <td>
                              <input type="hidden" name="students[{{ $loop->index }}][student_id]" value="{{ $student->id }}">
                              <span class="font-weight-semibold text-dark">{{ $student->name }}</span>
                              <small class="d-block text-muted">Reg: {{ $student->registration ?? 'N/A' }}</small>
                            </td>
                            <td>
                              <input type="number" class="form-control" name="students[{{ $loop->index }}][obt_marks]" placeholder="e.g. 75" min="0" max="{{ $subject->final_marks ?? 100 }}" required>
                            </td>
                            <td>
                              <input type="number" class="form-control" name="students[{{ $loop->index }}][total]" value="{{ $subject->final_marks ?? 100 }}" required>
                            </td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                    @else
                      <div class="text-center py-4 text-muted">
                        <i class="fas fa-users-slash fa-2x mb-2 d-block text-muted"></i>
                        No students enrolled in this class and section.
                      </div>
                    @endif
                  </div>

                  <!-- Form Action Footer -->
                  <div class="erp-form-footer">
                    <a href="{{ route('result') }}" class="btn btn-sm btn-outline-secondary">
                      Cancel
                    </a>
                    @if($students->isNotEmpty())
                    <button type="submit" class="erp-btn-submit">
                      <i class="fas fa-check"></i> Save & Publish Marks
                    </button>
                    @endif
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
