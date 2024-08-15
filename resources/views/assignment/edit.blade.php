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
                    <h4><i class="fas fa-file-alt"></i> Assignment</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{route('subject_show')}}">Acadamic</a></li>
                            <li class="breadcrumb-item"><a href="{{route('assignment_show')}}">Assignment</a></li>
                            <li class="breadcrumb-item active" aria-current="page" style="color: rgb(180, 176, 176)">Update Assignment</li>
                        </ol>
                    </nav>
                </div>
                <h4 class="card-title mt-5">Update Assignment</h4>
                <div class="form-container">
                   
                  <form action="{{ route('assignments_update',['id'=>$assignment->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" id="title" name="title" value="{{ $assignment->title }}">
                     
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" id="description" name="description" value="{{ $assignment->description }}">
                     
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="deadline">DeadLine</label>
                        <input type="date" class="form-control {{ $errors->has('deadline') ? 'is-invalid' : '' }}" id="deadline" name="deadline" value="{{ $assignment->deadline}}">
                     
                        @error('deadline')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="class_id">Add Class</label>
                        <select class="form-control {{ $errors->has('class_id') ? 'is-invalid' : '' }}" id="class_id" name="class_id">
                            <option value="" disabled selected></option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}" {{ $assignment->class_id == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('class_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="class_id">Add Section</label>
                        <select class="form-control {{ $errors->has('section_id') ? 'is-invalid' : '' }}" id="section_id" name="section_id">
                            <option value="" disabled selected></option>
                            @foreach ($sections as $section)
                                <option value="{{ $section->id }}" {{ $assignment->section_id == $section->id ? 'selected' : '' }}>
                                    {{ $section->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('section_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="subject_id">Add Subject</label>
                        <select class="form-control {{ $errors->has('subject_id') ? 'is-invalid' : '' }}" id="subject_id" name="subject_id">
                            <option value="" disabled selected></option>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ $assignment->subject_id == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->subject_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('subject_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                
                    <div class="form-group">
                        <label for="assignment">File</label>
                        <input type="file" class="form-control  {{ $errors->has('assignment') ? 'is-invalid' : '' }}" id="assignment" name="assignment"  value="{{ old('assignment') }}" >
                        @error('assignment')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                              <!-- Link to view or download the current PDF file -->
                          
                              <div class="mt-3">
                                  <a href="{{ asset('storage/' . $assignment->assignment) }}" target="_blank" class="btn btn-secondary">
                                      View Current Assignment
                                  </a>
                              </div>
                         
                      </div>
                    <button type="submit" class="btn btn-primary">Save</button>
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
