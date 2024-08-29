  <!DOCTYPE html>
<html lang="en">
<?php use Carbon\Carbon; ?>
@include('view-file/head')
<style>
  .dropdown-toggle::after {
    display: none;
  }
</style>
<body>
  <div class="container-scroller">
    @include('view-file/nav')
    <div class="container-fluid page-body-wrapper">
      @include('view-file.side-bar')

      <!-- Inner-page -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="container">
            <!-- Add New TimeTable Button -->
         
         
            <!-- Search Form -->
            <div class="card mb-5 w-100">
                <div class="card-body">
                  <div class="header">
                    <h4><i class="fas fa-clock"></i>Student Attendance</h4>
                    <nav aria-label="breadcrumb">
                      <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('students_attendence') }}">Attendance</a></li>
                        <li class="breadcrumb-item active" aria-current="page" style="color: rgb(180, 176, 176)">Select Class</li>
                      </ol>
                    </nav>
                  </div>
                    <div class="mb-4 card-body text-white border bg-primary">
                        <h2>Select Class And Its Section For Attendance</h2>
                       </div>
                </div>
            <form id="searchForm" method="GET" action="{{ route('add_student_attendance') }}" class="mb-4 mx-3">
              <div class="row">
                <div class="col-md-5">
                  <div class="form-group">
                    <label for="designation">Class</label>
                    <select name="class" id="class" class="form-control">
                      <option value="">Select Class</option>
                      @foreach ($classes as $class)
                        <option value="{{ $class->id }}" {{ $class->id == request()->query('class') ? 'selected' : '' }}>
                          {{ $class->name }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <label for="designation">Section</label>
                    <select name="section" id="section" class="form-control">
                      <!-- Options will be dynamically populated -->
                    </select>
                  </div>
                </div>
                 
                <div class="col-md-3 mt-4">
                  <button type="submit" class="btn btn-primary">Add Attendance</button>
                </div>
              </div>
            </form>
        </div>
    </div>

    {{-- ////////////////////////////////////////////////////////////////// --}}
   
  </div>

  @include('view-file.script')

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const classSelect = document.getElementById('class');
      const sectionSelect = document.getElementById('section');
      
      // Data for sections, ideally this should be from your backend
      const sectionsData = @json($classes->mapWithKeys(function ($class) {
        return [$class->id => $class->section->pluck('name', 'id')];
      }));

      classSelect.addEventListener('change', function() {
        const selectedClass = classSelect.value;
        const sections = sectionsData[selectedClass] || {};
        
        // Clear existing options
        sectionSelect.innerHTML = '<option value="">Select Section</option>';
        
        // Populate new options
        for (const [id, name] of Object.entries(sections)) {
          const option = document.createElement('option');
          option.value = id;
          option.textContent = name;
          sectionSelect.appendChild(option);
        }
      });
      
      // Trigger change event to populate sections on page load if a class is selected
      classSelect.dispatchEvent(new Event('change'));
    });

    @if(session('error'))
    Swal.fire({
      title: 'Error!',
      text: "{{ session('error') }}",
      icon: 'error',
      confirmButtonText: 'OK'
    });
    @endif
  </script>
  
</body>
</html>
