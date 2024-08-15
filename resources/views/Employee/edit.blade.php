<!DOCTYPE html>
<html lang="en">

@include('view-file/head')
<style>
    .form-container {
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        border: 1px rgb(56, 56, 56);
        box-shadow: 0 2px 10px rgba(114, 114, 114, 0.1);
    }
    .header {
        background-color: #4B49AC;
        color: white;
        padding: 10px;
        border-radius: 8px 8px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .header h4 {
        margin: 0;
        display: flex;
        align-items: center;
    }
    .header h4 i {
        margin-right: 10px;
    }
    .header a {
        color: whitesmoke;
        text-decoration: none;
    }
</style>
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
                             <li class="breadcrumb-item active" aria-current="page" style="color: rgb(180, 176, 176)">Update Employee</li>
                        </ol>
                    </nav>
                </div>
                <h4 class="card-title mt-5">Update Employee</h4>
                <div class="form-container">
                   
                <form action="{{ route('employees_update',['id'=>$employee->id]) }}" method="POST" enctype="multipart/form-data">
                  @csrf

                  <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name" name="name" value={{ $employee->name }} required>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="designation">Designation</label>
                    <select class="form-control {{ $errors->has('designation') ? 'is-invalid' : '' }}" id="designation" name="designation" >
                      @foreach ($designations as $designation )
                      <option value="{{ $designation->id }}" {{ $employee->designation->name == $designation->name ? 'selected' : '' }}>{{ $designation->name }}</option>
                      
                      @endforeach </select>
                    @error('designation')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                  <div class="form-group">
                    <label for="dob">Date of Birth</label>
                    <input type="date" class="form-control {{ $errors->has('date_of_birth') ? 'is-invalid' : '' }}" id="dob" name="date_of_birth"  value={{ $employee->date_of_birth }} required>
                    @error('date_of_birth')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label>Gender</label>
                    <div class="form-check ml-5">
                        <input class="form-check-input" type="radio" name="gender" id="genderMale" value="Male" {{ $employee->gender == "Male" ? 'checked' : '' }} required>
                        <label class="form-check-label" for="genderMale">Male</label>
                    </div>
                    <div class="form-check ml-5">
                        <input class="form-check-input" type="radio" name="gender" id="genderFemale" value="Female" {{ $employee->gender == "Female" ? 'checked' : '' }}>
                        <label class="form-check-label" for="genderFemale">Female</label>
                    </div>

                    @error('gender')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                </div>

                <div class="form-group">
                    <label for="religion">Religion</label>
                    <select class="form-control {{ $errors->has('date_of_birth') ? 'is-invalid' : '' }}" id="religion" name="religion" >
                        <option value="Christianity" {{ $employee->religion == "Christianity" ? 'selected' : '' }}>Christianity</option>
                        <option value="Islam" {{ $employee->religion == "Islam" ? 'selected' : '' }}>Islam</option>
                        <option value="Hinduism" {{ $employee->religion == "Hinduism" ? 'selected' : '' }}>Hinduism</option>
                        <option value="Buddhism" {{ $employee->religion == "Buddhism" ? 'selected' : '' }}>Buddhism</option>
                        <option value="Other" {{ $employee->religion == "Other" ? 'selected' : '' }}>Other</option>
                    </select>
                    
                    @error('religion')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                </div>

                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control  {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email" value={{ $employee->email }}  name="email">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                  </div>

                  <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" class="form-control  {{ $errors->has('phone') ? 'is-invalid' : '' }}" id="phone" name="phone" value={{ $employee->phone }}>
                    @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="address">Address</label>
                    <textarea class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" id="address" name="address" rows="2" required>{{$employee->address }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                  </div>

                  <div class="form-group">
                    <label for="joining_date">Joining Date</label>
                    <input type="date" class="form-control {{ $errors->has('date_of_birth') ? 'is-invalid' : '' }}" id="joining_date" value={{ $employee->joining_date }} name="joining_date" >
                    @error('joining_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                  </div>

                  <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" class="form-control mb-2 {{ $errors->has('image') ? 'is-invalid' : '' }}"  id="image" name="image" accept="image/*">
                    <img src="{{ asset('storage/' . $employee->image) }}" alt="Employee Image" style="width: 100px; height: 100px;">
                    @error('image')
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
</body>
</html>
