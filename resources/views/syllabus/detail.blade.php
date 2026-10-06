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
              
              <!-- Modern ERP Detail Card -->
              <div class="erp-card-form">
                <div class="erp-form-header-block">
                  <div class="erp-form-title-area">
                    <h3 class="erp-form-title">
                      <i class="fas fa-file-lines text-primary"></i>
                      Syllabus Details
                    </h3>
                    <p class="erp-form-subtitle">View detailed syllabus curriculum objectives and attachments</p>
                  </div>

                  <!-- Back Button -->
                  <div>
                    <a href="{{ route('syllabus_show') }}" class="erp-btn-back">
                      <i class="fas fa-arrow-left"></i> Back to Syllabus
                    </a>
                  </div>
                </div>

                <div class="erp-form-body">
                  <div class="row g-4">
                    <div class="col-md-6">
                      <div class="mb-4">
                        <label class="text-xs font-weight-bold text-muted text-uppercase mb-1 d-block">Syllabus Title</label>
                        <div class="font-weight-semibold text-dark fs-5">{{ $syllabus->title }}</div>
                      </div>

                      <div class="mb-4">
                        <label class="text-xs font-weight-bold text-muted text-uppercase mb-1 d-block">Uploaded By</label>
                        <div class="font-weight-medium text-dark">
                          <i class="fas fa-user-circle text-primary mr-1"></i> {{ $syllabus->uploader }}
                        </div>
                      </div>

                      <div class="mb-4">
                        <label class="text-xs font-weight-bold text-muted text-uppercase mb-1 d-block">Publication Date</label>
                        <div class="font-weight-medium text-dark">
                          <i class="fas fa-calendar-alt text-primary mr-1"></i> {{ $syllabus->date }}
                        </div>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="mb-4">
                        <label class="text-xs font-weight-bold text-muted text-uppercase mb-1 d-block">Document Attachment</label>
                        @if($syllabus->file)
                          <div class="p-3 bg-light border rounded">
                            <i class="fas fa-file-pdf text-danger fa-2x mb-2 d-block"></i>
                            <a href="{{ asset('storage/' . $syllabus->file) }}" target="_blank" class="btn btn-sm btn-primary">
                              <i class="fas fa-download mr-1"></i> View / Download Syllabus
                            </a>
                          </div>
                        @else
                          <p class="text-muted">No attachment file available.</p>
                        @endif
                      </div>
                    </div>

                    <div class="col-12">
                      <hr class="my-2">
                      <label class="text-xs font-weight-bold text-muted text-uppercase mb-2 d-block">Description & Syllabus Topics</label>
                      <div class="p-3 bg-light rounded text-secondary" style="white-space: pre-wrap; line-height: 1.6;">
                        {{ $syllabus->description }}
                      </div>
                    </div>
                  </div>
                </div>

                <div class="erp-form-footer">
                  <a href="{{ route('syllabus_show') }}" class="erp-btn-back">
                    <i class="fas fa-arrow-left"></i> Back to Syllabus
                  </a>
                  @if(auth()->check() && (auth()->user()->hasRole('superadmin') || auth()->user()->can('academic.syllabus.edit')))
                  <a href="{{ route('edit_syllabus', ['id' => $syllabus->id]) }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-edit mr-1"></i> Edit Syllabus
                  </a>
                  @endif
                </div>

              </div>
              <!-- End ERP Detail Card -->

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @include('view-file/script')
</body>
</html>
