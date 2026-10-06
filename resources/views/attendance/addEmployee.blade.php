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
                      <i class="fas fa-user-check text-primary"></i>
                      Mark Staff Attendance
                    </h3>
                    <p class="erp-form-subtitle">Record daily employee and teacher attendance status</p>
                  </div>

                  <!-- Back Button -->
                  <div>
                    <a href="{{ route('employee_attendence') }}" class="erp-btn-back">
                      <i class="fas fa-arrow-left"></i> Back to Attendance
                    </a>
                  </div>
                </div>

                <form action="{{ route('attendance_store') }}" method="POST" id="employeeAttendanceForm">
                  @csrf
                  
                  <div class="erp-form-body">
                    <!-- Date Selector Banner -->
                    <div class="p-3 bg-light rounded border mb-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
                      <div class="d-flex align-items-center gap-2">
                        <label for="date" class="small font-weight-bold text-muted mb-0">Attendance Date:</label>
                        <input type="date" name="date" id="date" class="form-control form-control-sm" style="width: 170px;" value="{{ date('Y-m-d') }}" required>
                      </div>

                      <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-xs btn-outline-success" onclick="markAll('present')">
                          <i class="fas fa-check-double mr-1"></i> Mark All Present
                        </button>
                        <button type="button" class="btn btn-xs btn-outline-danger" onclick="markAll('absent')">
                          <i class="fas fa-times mr-1"></i> Mark All Absent
                        </button>
                      </div>
                    </div>

                    <!-- Attendance Table -->
                    <div class="table-responsive">
                      <table class="table table-bordered align-middle">
                        <thead class="bg-light">
                          <tr>
                            <th style="width: 50px;" class="text-center">#</th>
                            <th style="width: 35%;">Employee Name</th>
                            <th style="width: 20%;">Designation</th>
                            <th style="width: 40%;" class="text-center">Attendance Status</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php $count = 0; @endphp
                          @forelse($employees as $employee)
                          <tr>
                            <td class="text-center font-weight-medium text-muted">{{ ++$count }}</td>
                            <td>
                              <span class="font-weight-semibold text-dark">{{ $employee->name }}</span>
                              <small class="d-block text-muted">{{ $employee->email }}</small>
                            </td>
                            <td>
                              <span class="badge badge-soft-primary">
                                {{ $employee->designation->name ?? 'Staff' }}
                              </span>
                            </td>
                            <td class="text-center">
                              <div class="d-flex align-items-center justify-content-center gap-3">
                                <label class="radio-inline mb-0 cursor-pointer text-success font-weight-semibold">
                                  <input type="radio" name="attendance[{{ $employee->id }}]" value="present" checked> Present
                                </label>
                                <label class="radio-inline mb-0 cursor-pointer text-danger font-weight-semibold">
                                  <input type="radio" name="attendance[{{ $employee->id }}]" value="absent"> Absent
                                </label>
                                <label class="radio-inline mb-0 cursor-pointer text-warning font-weight-semibold">
                                  <input type="radio" name="attendance[{{ $employee->id }}]" value="leave"> Leave
                                </label>
                                <label class="radio-inline mb-0 cursor-pointer text-info font-weight-semibold">
                                  <input type="radio" name="attendance[{{ $employee->id }}]" value="late"> Late
                                </label>
                              </div>
                            </td>
                          </tr>
                          @empty
                          <tr>
                            <td colspan="4" class="text-center py-4 text-muted">
                              No employees found.
                            </td>
                          </tr>
                          @endforelse
                        </tbody>
                      </table>
                    </div>
                  </div>

                  <!-- Form Action Footer -->
                  <div class="erp-form-footer">
                    <a href="{{ route('employee_attendence') }}" class="btn btn-sm btn-outline-secondary">
                      Cancel
                    </a>
                    @if($employees->isNotEmpty())
                    <button type="submit" class="erp-btn-submit">
                      <i class="fas fa-check"></i> Submit Staff Attendance
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
  
  <script>
    function markAll(status) {
      document.querySelectorAll(`input[type="radio"][value="${status}"]`).forEach(radio => {
        radio.checked = true;
      });
    }
  </script>
</body>
</html>
