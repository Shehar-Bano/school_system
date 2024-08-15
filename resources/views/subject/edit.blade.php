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
                    <h4><i class="fas fa-book"></i> Subject</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{route('subject_show')}}">Acadamic</a></li>
                            <li class="breadcrumb-item"><a href="{{route('subject_show')}}">Subject</a></li>
                            <li class="breadcrumb-item active" aria-current="page" style="color: rgb(180, 176, 176)">Update Subject</li>
                        </ol>
                    </nav>
                </div>
                <h4 class="card-title mt-5">UpdatevSubject</h4>
                <div class="form-container">
                   
                  <form action="{{ route('subject_update',['id'=>$subject->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                
                    <div class="form-group">
                        <label for="teacher_id">Add Teacher</label>
                        <select class="form-control {{ $errors->has('teacher_id') ? 'is-invalid' : '' }}" id="teacher_id" name="teacher_id">
                            <option value="" disabled selected></option>
                            @foreach ($employees as $employee)
                                @if($employee->designation->name == "Teacher")
                                    <option value="{{ $employee->id }}" {{$subject->teacher->name  == $employee->name? 'selected' : '' }}>
                                        {{ $employee->name }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        @error('teacher_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="form-group">
                        <label for="class_id">Add Class</label>
                        <select class="form-control {{ $errors->has('class_id') ? 'is-invalid' : '' }}" id="class_id" name="class_id">
                            <option value="" disabled selected></option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}" {{ $subject->class->id == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('class_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="form-group">
                        <label for="subject_name">Subject Name</label>
                        <input type="text" class="form-control {{ $errors->has('subject_name') ? 'is-invalid' : '' }}" id="subject_name" name="subject_name" value={{ $subject->subject_name }}>
                        @error('subject_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="form-group">
                        <label for="type">Subject Type</label>
                        <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" id="type" name="type">
                            <option value="" disabled selected></option>
                            <option value="Mandatory" {{ $subject->type == 'Mandatory' ? 'selected' : '' }}>Mandatory</option>
                            <option value="Optional" {{ $subject->type  == 'Optional' ? 'selected' : '' }}>Optional</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="form-group">
                        <label for="pass_marks">Pass Marks</label>
                        <input type="text" class="form-control {{ $errors->has('pass_marks') ? 'is-invalid' : '' }}" id="pass_marks" name="pass_marks" value="{{  $subject->pass_marks }}">
                        @error('pass_marks')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="form-group">
                        <label for="final_marks">Final Marks</label>
                        <input type="text" class="form-control {{ $errors->has('final_marks') ? 'is-invalid' : '' }}" id="final_marks" name="final_marks" value="{{  $subject->final_marks }}">
                        @error('final_marks')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="form-group">
                        <label for="sub_code">Subject Code</label>
                        <input type="text" class="form-control {{ $errors->has('sub_code') ? 'is-invalid' : '' }}" id="sub_code" name="sub_code" value="{{  $subject->sub_code}}">
                        @error('sub_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
                
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
    // Filter by Name with Suggestions
    const filterNameInput = document.getElementById('filterName');
    const nameSuggestionList = document.getElementById('nameSuggestionList');
  
    filterNameInput.addEventListener('keyup', function() {
      const filter = this.value.toLowerCase();
      const rows = document.querySelectorAll('#examsTable tbody tr');
      nameSuggestionList.innerHTML = ''; // Clear previous suggestions
      let hasSuggestions = false;
  
      rows.forEach(row => {
        const name = row.querySelector('td:nth-child(4)').textContent.toLowerCase(); // assuming name is in 4th column
        if (name.includes(filter)) {
          row.style.display = '';
          // Add suggestion to the list
          const suggestionItem = document.createElement('li');
          suggestionItem.className = 'list-group-item list-group-item-action';
          suggestionItem.textContent = name;
          suggestionItem.addEventListener('click', function() {
            filterNameInput.value = name;
            nameSuggestionList.style.display = 'none';
            // Hide non-matching rows
            rows.forEach(r => {
              const n = r.querySelector('td:nth-child(4)').textContent.toLowerCase();
              r.style.display = n === name ? '' : 'none';
            });
          });
          nameSuggestionList.appendChild(suggestionItem);
          hasSuggestions = true;
        } else {
          row.style.display = 'none';
        }
      });
  
      nameSuggestionList.style.display = hasSuggestions ? 'block' : 'none';
    });
  
    // Hide suggestion list when clicking outside
    document.addEventListener('click', function(event) {
      if (!filterNameInput.contains(event.target)) {
        nameSuggestionList.style.display = 'none';
      }
    });
  
    // Filter by Designation with Suggestions
    const filterDesignationInput = document.getElementById('filterDesignation');
    const designationSuggestionList = document.getElementById('designationSuggestionList');
  
    filterDesignationInput.addEventListener('keyup', function() {
      const filter = this.value.toLowerCase();
      const rows = document.querySelectorAll('#examsTable tbody tr');
      designationSuggestionList.innerHTML = ''; // Clear previous suggestions
      let hasSuggestions = false;
  
      rows.forEach(row => {
        const designation = row.querySelector('td:nth-child(6)').textContent.toLowerCase(); // assuming designation is in 6th column
        if (designation.includes(filter)) {
          row.style.display = '';
          // Add suggestion to the list
          const suggestionItem = document.createElement('li');
          suggestionItem.className = 'list-group-item list-group-item-action';
          suggestionItem.textContent = designation;
          suggestionItem.addEventListener('click', function() {
            filterDesignationInput.value = designation;
            designationSuggestionList.style.display = 'none';
            // Hide non-matching rows
            rows.forEach(r => {
              const d = r.querySelector('td:nth-child(6)').textContent.toLowerCase();
              r.style.display = d === designation ? '' : 'none';
            });
          });
          designationSuggestionList.appendChild(suggestionItem);
          hasSuggestions = true;
        } else {
          row.style.display = 'none';
        }
      });
  
      designationSuggestionList.style.display = hasSuggestions ? 'block' : 'none';
    });
  
    // Hide suggestion list when clicking outside
    document.addEventListener('click', function(event) {
      if (!filterDesignationInput.contains(event.target)) {
        designationSuggestionList.style.display = 'none';
      }
    });
  </script>
</body>
</html>
