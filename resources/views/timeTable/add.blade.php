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
                      <i class="fas fa-calendar-plus text-primary"></i>
                      Add Class Timetable Slot
                    </h3>
                    <p class="erp-form-subtitle">Assign weekly lecture slot, classroom section, assigned teacher, and period timing</p>
                  </div>

                  <!-- Back to List Button -->
                  <div>
                    <a href="{{ route('timeTable') }}" class="erp-btn-back">
                      <i class="fas fa-arrow-left"></i> Back to Timetable
                    </a>
                  </div>
                </div>

                <form action="{{ route('timeTable_store') }}" method="POST" id="addTimetableForm">
                  @csrf
                  
                  <div class="erp-form-body">
                    <div class="row">
                      <!-- Class -->
                      <div class="col-md-4">
                        <div class="erp-form-group">
                          <label for="class_id" class="erp-form-label">Class <span class="required">*</span></label>
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

                      <!-- Section -->
                      <div class="col-md-4">
                        <div class="erp-form-group">
                          <label for="section_id" class="erp-form-label">Section <span class="required">*</span></label>
                          <select class="form-control" id="section_id" name="section_id" required>
                            <option value="" disabled selected>-- Select Section --</option>
                            @foreach ($sections as $section)
                              <option value="{{ $section->id }}" data-class-id="{{ $section->class_id }}" {{ old('section_id') == $section->id ? 'selected' : '' }}>
                                {{ $section->name }} ({{ $section->classe->name ?? '' }})
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
                          <label for="subject_id" class="erp-form-label">Subject <span class="required">*</span></label>
                          <select class="form-control" id="subject_id" name="subject_id" required>
                            <option value="" disabled selected>-- Select Subject --</option>
                            @foreach ($subjects as $subject)
                              @if($subject->subject)
                                <option value="{{ $subject->subject_id }}" data-class-id="{{ $subject->class_id }}" {{ old('subject_id') == $subject->subject_id ? 'selected' : '' }}>
                                  {{ $subject->subject->subject_name }}
                                </option>
                              @endif
                            @endforeach
                          </select>
                          @error('subject_id')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <!-- Teacher -->
                      <div class="col-md-6">
                        <div class="erp-form-group">
                          <label for="teacher_id" class="erp-form-label">Assigned Teacher <span class="required">*</span></label>
                          <select class="form-control" id="teacher_id" name="teacher_id" required>
                            <option value="" disabled selected>-- Select Teacher --</option>
                            @foreach ($employees as $employee)
                              @if($employee->designation && $employee->designation->name == "Teacher")
                                <option value="{{ $employee->id }}" {{ old('teacher_id') == $employee->id ? 'selected' : '' }}>
                                  {{ $employee->name }}
                                </option>
                              @endif
                            @endforeach
                          </select>
                          @error('teacher_id')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <!-- Day of Week -->
                      <div class="col-md-6">
                        <div class="erp-form-group">
                          <label for="day" class="erp-form-label">Day of Week <span class="required">*</span></label>
                          <select class="form-control" id="day" name="day" required>
                            <option value="Monday" {{ old('day') == 'Monday' ? 'selected' : '' }}>Monday</option>
                            <option value="Tuesday" {{ old('day') == 'Tuesday' ? 'selected' : '' }}>Tuesday</option>
                            <option value="Wednesday" {{ old('day') == 'Wednesday' ? 'selected' : '' }}>Wednesday</option>
                            <option value="Thursday" {{ old('day') == 'Thursday' ? 'selected' : '' }}>Thursday</option>
                            <option value="Friday" {{ old('day') == 'Friday' ? 'selected' : '' }}>Friday</option>
                            <option value="Saturday" {{ old('day') == 'Saturday' ? 'selected' : '' }}>Saturday</option>
                            <option value="Sunday" {{ old('day') == 'Sunday' ? 'selected' : '' }}>Sunday</option>
                          </select>
                          @error('day')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <!-- Start Time -->
                      <div class="col-md-6">
                        <div class="erp-form-group">
                          <label for="start_time" class="erp-form-label">Period Start Time <span class="required">*</span></label>
                          <input type="time" class="form-control" id="start_time" name="start_time" value="{{ old('start_time', '08:00') }}" required>
                          @error('start_time')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <!-- End Time -->
                      <div class="col-md-6">
                        <div class="erp-form-group">
                          <label for="end_time" class="erp-form-label">Period End Time <span class="required">*</span></label>
                          <input type="time" class="form-control" id="end_time" name="end_time" value="{{ old('end_time', '08:45') }}" required>
                          @error('end_time')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Form Action Footer -->
                  <div class="erp-form-footer">
                    <a href="{{ route('timeTable') }}" class="btn btn-sm btn-outline-secondary">
                      Cancel
                    </a>
                    <button type="submit" class="erp-btn-submit">
                      <i class="fas fa-check"></i> Save Timetable Slot
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
  
  <script>
    document.getElementById('class_id').addEventListener('change', function() {
      var selectedClassId = this.value;
      var subjectSelect = document.getElementById('subject_id');
      var options = subjectSelect.querySelectorAll('option');

      options.forEach(function(option) {
        if (option.getAttribute('data-class-id') == selectedClassId || option.value == '') {
          option.style.display = '';
        } else {
          option.style.display = 'none';
        }
      });
      subjectSelect.value = '';
    });
  </script>
</body>
</html>
