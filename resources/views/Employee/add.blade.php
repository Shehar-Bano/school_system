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
                    <h4><i class="fas fa-user"></i> Employee</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{route('employee_view')}}">Employee</a></li>
                            <li class="breadcrumb-item active" aria-current="page" style="color: rgb(180, 176, 176)">Add Exam</li>
                        </ol>
                    </nav>
                </div>
                <h4 class="card-title mt-5">Add New Employee</h4>
                <div class="form-container">
                   
                  <form action="{{ route('employees_store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name" name="name" value="{{ old('name') }}">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="form-group">
                        <label for="designation">Designation</label>
                        <select class="form-control {{ $errors->has('designation') ? 'is-invalid' : '' }}" id="designation" name="designation">
                          <option value="" disabled selected></option> 
                          @foreach ($designations as $designation )
                          <option value="{{ $designation->id }}" {{ old('designation') == $designation->name ? 'selected' : '' }}>{{ $designation->name }}</option>
                          
                          @endforeach
                            </select>
                        @error('designation')
                        <div class="invalid-feedback ">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="form-group">
                        <label for="dob">Date of Birth</label>
                        <input type="date" class="form-control {{ $errors->has('date_of_birth') ? 'is-invalid' : '' }}" id="dob" name="date_of_birth" value="{{ old('date_of_birth') }}">
                        @error('date_of_birth')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="form-group">
                        <label>Gender</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" id="genderMale" value="Male" {{ old('gender') == 'Male' ? 'checked' : '' }}>
                            <label class="form-check-label" for="genderMale">Male</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" id="genderFemale" value="Female" {{ old('gender') == 'Female' ? 'checked' : '' }}>
                            <label class="form-check-label" for="genderFemale">Female</label>
                        </div>
                        @error('gender')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="form-group">
                        <label for="religion">Religion</label>
                        <select class="form-control {{ $errors->has('religion') ? 'is-invalid' : '' }}" id="religion" name="religion">
                          <option value="" disabled selected></option>
                            <option value="Christianity" {{ old('religion') == 'Christianity' ? 'selected' : '' }}>Christianity</option>
                            <option value="Islam" {{ old('religion') == 'Islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Hinduism" {{ old('religion') == 'Hinduism' ? 'selected' : '' }}>Hinduism</option>
                            <option value="Buddhism" {{ old('religion') == 'Buddhism' ? 'selected' : '' }}>Buddhism</option>
                            <option value="Other" {{ old('religion') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('religion')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email" name="email" value="{{ old('email') }}">
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                  <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" class="form-control  {{ $errors->has('phone') ? 'is-invalid' : '' }}" id="phone" name="phone"  value="{{ old('phone') }}">
                    @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="address">Address</label>
                    <textarea class="form-control  {{ $errors->has('address') ? 'is-invalid' : '' }}" id="address" name="address" rows="3"  >{{ old('address') }}</textarea>
                    @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="joining_date">Joining Date</label>
                    <input type="date" class="form-control  {{ $errors->has('joining_date') ? 'is-invalid' : '' }}" id="joining_date" name="joining_date" value="{{ old('joining_date') }}">
                    @error('joining_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" class="form-control  {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image" name="image" accept="image/*" value="{{ old('image') }}" >
                    @error('image')
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
