<!DOCTYPE html>
<html lang="en">

@include('view-file/head')

<body>
  <div class="container-scroller">
    @include('view-file/nav')
    <div class="container-fluid page-body-wrapper">
      @include('view-file.side-bar')

      <!-- Inner page -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="container">
            <!-- Add New Employee Form -->
            <div class="card">
              <div class="card-body">
                <div class="header">
                  <h4><i class="fas fa-clock"></i> TimeTable</h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                      <li class="breadcrumb-item"><a href="{{ route('subject_show') }}">Academic</a></li>
                      <li class="breadcrumb-item"><a href="{{ route('timeTable') }}">TimeTable</a></li>
                      <li class="breadcrumb-item active" aria-current="page" style="color: rgb(180, 176, 176)">Add Time Table</li>
                    </ol>
                  </nav>
                </div>
                <h4 class="card-title mt-5">Add New Timetable</h4>
                <div class="form-container">
                  <form action="{{ route('timeTable_store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                      <label for="class_id">Add Class</label>
                      <select class="form-control {{ $errors->has('class_id') ? 'is-invalid' : '' }}" id="class_id" name="class_id">
                        <option value="" disabled selected></option>
                        @foreach ($classes as $class)
                          <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                            {{ $class->name }}
                          </option>
                        @endforeach
                      </select>
                      @error('class_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>

                    <div class="form-group">
                      <label for="subject_id">Add Subject</label>
                      <select class="form-control {{ $errors->has('subject_id') ? 'is-invalid' : '' }}" id="subject_id" name="subject_id">
                        <option value="" disabled selected></option>
                        @foreach ($subjects as $subject)
                          <option value="{{ $subject->subject_id }}" data-class-id="{{ $subject->class_id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                            {{ $subject->subject->subject_name }}
                          </option>
                        @endforeach
                      </select>
                      @error('subject_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>

                    <div class="form-group">
                      <label for="section_id">Add Section</label>
                      <select class="form-control {{ $errors->has('section_id') ? 'is-invalid' : '' }}" id="section_id" name="section_id">
                        <option value="" disabled selected></option>
                        @foreach ($sections as $section)
                          <option value="{{ $section->id }}" data-class-id="{{ $section->class_id }}" {{ old('section_id') == $section->id ? 'selected' : '' }}>
                            {{ $section->name }}-{{$section->classe->name}}
                          </option>
                        @endforeach
                      </select>
                      @error('section_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>

                    <div class="form-group">
                      <label for="day">Day</label>
                      <select class="form-control {{ $errors->has('day') ? 'is-invalid' : '' }}" id="day" name="day">
                        <option value="" disabled selected></option>
                        <option value="Sunday" {{ old('day') == 'Sunday' ? 'selected' : '' }}>Sunday</option>
                        <option value="Monday" {{ old('day') == 'Monday' ? 'selected' : '' }}>Monday</option>
                        <option value="Tuesday" {{ old('day') == 'Tuesday' ? 'selected' : '' }}>Tuesday</option>
                        <option value="Wednesday" {{ old('day') == 'Wednesday' ? 'selected' : '' }}>Wednesday</option>
                        <option value="Thursday" {{ old('day') == 'Thursday' ? 'selected' : '' }}>Thursday</option>
                        <option value="Friday" {{ old('day') == 'Friday' ? 'selected' : '' }}>Friday</option>
                        <option value="Saturday" {{ old('day') == 'Saturday' ? 'selected' : '' }}>Saturday</option>
                      </select>
                      @error('day')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                    <div class="form-group">
                        <label for="section_id">Teacher</label>
                        <select class="form-control {{ $errors->has('teacher_id') ? 'is-invalid' : '' }}" id="section_id" name="teacher_id">
                          <option value="" disabled selected></option>
                          @foreach ($employees as $employee)
                          @if($employee->designation->name=="Teacher")
                            <option value="{{ $employee->id }}" data-class-id="{{ $employee->class_id }}" {{ old('section_id') == $employee->id ? 'selected' : '' }}>
                              {{ $employee->name }}
                            </option>
                            @endif
                          @endforeach
                        </select>
                        @error('teacher_id')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>

                    <!-- Start Time -->
                    <div class="form-group">
                      <label for="start_time">Start Time</label>
                      <input type="time" class="form-control {{ $errors->has('start_time') ? 'is-invalid' : '' }}" id="start_time" name="start_time" value="{{ old('start_time') }}">
                      @error('start_time')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>

                    <!-- End Time -->
                    <div class="form-group">
                      <label for="end_time">End Time</label>
                      <input type="time" class="form-control {{ $errors->has('end_time') ? 'is-invalid' : '' }}" id="end_time" name="end_time" value="{{ old('end_time') }}">
                      @error('end_time')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Save</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- End Inner page -->
    </div>
  </div>

  @include('view-file.script')

  <script>
    @if(session('message'))
      swal("Success!", "{{ session('message') }}", "success");
    @endif
  </script>

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

      // Reset the subject selection
      subjectSelect.value = '';
    });


  </script>
  @if(session('error'))
  <script>
      Swal.fire({
          title: 'Error!',
          text: "{{ session('error') }}",
          icon: 'error',
          confirmButtonText: 'OK'
      });
  </script>
  @endif
  @if(session('success'))
  <script>
      Swal.fire({
          title: 'Success!',
          text: "{{ session('sucsess') }}",
          icon: 'success',
          confirmButtonText: 'OK'
      });
  </script>
  @endif


</body>
</html>
