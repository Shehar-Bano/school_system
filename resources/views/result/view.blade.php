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
                      <i class="fas fa-file-waveform text-primary"></i>
                      Student Academic Transcript
                    </h3>
                    <p class="erp-form-subtitle">Comprehensive examination results and subject breakdown for {{ $student->name }}</p>
                  </div>

                  <!-- Back to List Button -->
                  <div>
                    <a href="{{ route('result') }}" class="erp-btn-back">
                      <i class="fas fa-arrow-left"></i> Back to Results
                    </a>
                  </div>
                </div>

                <div class="erp-form-body">
                  
                  <!-- Top Filter & Action Bar -->
                  <div class="p-3 bg-light rounded border mb-4">
                    <form id="searchForm" method="GET" action="" class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                      <div class="d-flex align-items-center gap-2">
                        <label for="exam" class="small font-weight-bold text-muted mb-0">Select Term:</label>
                        <select name="exam" id="exam" class="form-control form-control-sm" style="width: 220px;" onchange="this.form.submit()">
                          <option value="" disabled selected>-- Select Exam Term --</option>
                          @foreach ($exams as $exam)
                            <option value="{{ $exam->id }}" {{ $exam->id == request()->query('exam') ? 'selected' : '' }}>
                              {{ $exam->name }}
                            </option>
                          @endforeach
                        </select>
                        <input type="hidden" name="student_id" value="{{ $student->id }}">
                      </div>

                      <div class="d-flex align-items-center gap-2">
                        <a class="btn btn-sm btn-primary" href="{{ route('result.card', ['student_id' => $student->id, 'exam' => request()->query('exam')]) }}" target="_blank">
                          <i class="fas fa-print mr-1"></i> Print Result Card
                        </a>
                      </div>
                    </form>
                  </div>

                  <div class="row g-4">
                    <!-- Student Summary Card -->
                    <div class="col-md-4">
                      <div class="p-4 bg-white border rounded text-center shadow-xs">
                        @if($student->image && $student->image !== 'default.png')
                          <img src="{{ asset('storage/' . $student->image) }}" class="rounded-circle border mb-3" style="width: 80px; height: 80px; object-fit: cover;" alt="avatar">
                        @else
                          <div class="erp-user-avatar mx-auto mb-3" style="width: 80px; height: 80px; font-size: 26px;">
                            {{ strtoupper(substr($student->name, 0, 2)) }}
                          </div>
                        @endif
                        <h4 class="font-weight-bold text-dark mb-1">{{ $student->name }}</h4>
                        <div class="badge badge-soft-primary mb-3">Reg: {{ $student->registration ?? 'N/A' }}</div>
                        
                        <div class="text-left border-top pt-3">
                          <div class="d-flex justify-content-between py-1 border-bottom">
                            <span class="text-muted small">Class</span>
                            <span class="font-weight-semibold text-dark">{{ $student->class->name ?? 'N/A' }}</span>
                          </div>
                          <div class="d-flex justify-content-between py-1 border-bottom">
                            <span class="text-muted small">Section</span>
                            <span class="font-weight-semibold text-dark">{{ $student->section->name ?? 'N/A' }}</span>
                          </div>
                          <div class="d-flex justify-content-between py-1">
                            <span class="text-muted small">Guardian</span>
                            <span class="font-weight-semibold text-dark">{{ ucfirst($student->gurdian ?? 'N/A') }}</span>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Subject Marks Table -->
                    <div class="col-md-8">
                      <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                          <thead class="bg-light">
                            <tr>
                              <th>Subject</th>
                              <th class="text-center">Obtained Marks</th>
                              <th class="text-center">Total Marks</th>
                              <th class="text-center">Grade</th>
                            </tr>
                          </thead>
                          <tbody>
                            @php
                              $totalmarks = 0;
                              $obt = 0;
                              $avg = 0;
                            @endphp
                            @forelse ($results as $result)
                            <tr>
                              <td class="font-weight-semibold text-dark">
                                <i class="fas fa-book text-primary mr-1"></i> {{ $result->subject->subject_name }}
                              </td>
                              <td class="text-center font-weight-bold text-dark">{{ $result->obt_marks }}</td>
                              <td class="text-center">{{ $result->total }}</td>
                              <td class="text-center">
                                <span class="badge @if($result->grade == 'A') badge-soft-success @elseif($result->grade == 'B') badge-soft-primary @elseif($result->grade == 'C') badge-soft-warning @else badge-soft-danger @endif">
                                  {{ $result->grade }}
                                </span>
                              </td>
                            </tr>
                            @php
                              $totalmarks += $result->total;
                              $obt += $result->obt_marks;
                            @endphp
                            @empty
                            <tr>
                              <td colspan="4" class="text-center py-4 text-muted">
                                No subject marks recorded for this student in the selected term.
                              </td>
                            </tr>
                            @endforelse
                            @php
                              $avg = $totalmarks > 0 ? ($obt / $totalmarks) * 100 : 0;
                            @endphp
                          </tbody>
                        </table>
                      </div>

                      <!-- Summary Banner -->
                      @if($totalmarks > 0)
                      <div class="p-3 bg-light rounded border mt-3 d-flex justify-content-around text-center">
                        <div>
                          <small class="text-muted text-uppercase d-block font-weight-bold">Total Marks</small>
                          <span class="fs-5 font-weight-bold text-dark">{{ $totalmarks }}</span>
                        </div>
                        <div class="border-left pl-3">
                          <small class="text-muted text-uppercase d-block font-weight-bold">Obtained</small>
                          <span class="fs-5 font-weight-bold text-primary">{{ $obt }}</span>
                        </div>
                        <div class="border-left pl-3">
                          <small class="text-muted text-uppercase d-block font-weight-bold">Percentage</small>
                          <span class="fs-5 font-weight-bold @if($avg >= 50) text-success @else text-danger @endif">{{ number_format($avg, 2) }}%</span>
                        </div>
                      </div>
                      @endif
                    </div>
                  </div>

                </div>

                <!-- Footer Action -->
                <div class="erp-form-footer">
                  <a href="{{ route('result') }}" class="erp-btn-back">
                    <i class="fas fa-arrow-left"></i> Back to Results
                  </a>
                </div>

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
