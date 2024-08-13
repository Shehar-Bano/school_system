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
                    <input type="text" class="form-control" id="name" name="name" value={{ $employee->name }} required>
                  </div>

                  <div class="form-group">
                    <label for="designation">Designation</label>
                    <select class="form-control" id="designation" name="designation" required>
                        <option value="Teacher" {{ $employee->designation == "Teacher" ? 'selected' : '' }}>Teacher</option>
                        <option value="Librarian" {{ $employee->designation == "Librarian" ? 'selected' : '' }}>Librarian</option>
                        <option value="Moderator" {{ $employee->designation == "Moderator" ? 'selected' : '' }}>Moderator</option>
                        <option value="Receptionist" {{ $employee->designation == "Receptionist" ? 'selected' : '' }}>Receptionist</option>
                        <option value="Accountant" {{ $employee->designation == "Accountant" ? 'selected' : '' }}>Accountant</option>
                        <option value="Other" {{ $employee->designation == "Other" ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                  <div class="form-group">
                    <label for="dob">Date of Birth</label>
                    <input type="date" class="form-control" id="dob" name="dob"  value={{ $employee->date_of_birth }} required>
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
                </div>

                <div class="form-group">
                    <label for="religion">Religion</label>
                    <select class="form-control" id="religion" name="religion" required>
                        <option value="Christianity" {{ $employee->religion == "Christianity" ? 'selected' : '' }}>Christianity</option>
                        <option value="Islam" {{ $employee->religion == "Islam" ? 'selected' : '' }}>Islam</option>
                        <option value="Hinduism" {{ $employee->religion == "Hinduism" ? 'selected' : '' }}>Hinduism</option>
                        <option value="Buddhism" {{ $employee->religion == "Buddhism" ? 'selected' : '' }}>Buddhism</option>
                        <option value="Other" {{ $employee->religion == "Other" ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" value={{ $employee->email }}  name="email" required>
                  </div>

                  <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" class="form-control" id="phone" name="phone" value={{ $employee->phone }} required>
                  </div>

                  <div class="form-group">
                    <label for="address">Address</label>
                    <textarea class="form-control" id="address" name="address" rows="3" required>{{$employee->address }}</textarea>
                  </div>

                  <div class="form-group">
                    <label for="joining_date">Joining Date</label>
                    <input type="date" class="form-control" id="joining_date" value={{ $employee->joining_date }} name="joining_date" required>
                  </div>

                  <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" class="form-control mb-2" id="image" name="image" accept="image/*">
                    <img src="{{ asset('storage/' . $employee->image) }}" alt="Employee Image" style="width: 100px; height: 100px;">
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
