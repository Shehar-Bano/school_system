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
                    <input type="text" class="form-control" id="name" name="name" required>
                  </div>

                  <div class="form-group">
                    <label for="designation">Designation</label>
                    <select class="form-control" id="designation" name="designation" required>
                      <option value="Teacher">Teacher</option>
                      <option value="Librarian">Librarian</option>
                      <option value="Moderator">Moderator</option>
                      <option value="Receptionist">Receptionist</option>
                      <option value="Accountant">Accountant</option>
                      <option value="Other">Other</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="dob">Date of Birth</label>
                    <input type="date" class="form-control" id="dob" name="dob" required>
                  </div>

                  <div class="form-group">
                    <label>Gender</label>
                    <div class="form-check ml-5">
                      <input class="form-check-input" type="radio" name="gender" id="genderMale" value="Male" required>
                      <label class="form-check-label" for="genderMale">Male</label>
                    </div>
                    <div class="form-check ml-5">
                      <input class="form-check-input" type="radio" name="gender" id="genderFemale" value="Female">
                      <label class="form-check-label" for="genderFemale">Female</label>
                    </div>
                  </div>

                  <div class="form-group ">
                    <label for="religion">Religion</label>
                    <select class="form-control" id="religion" name="religion" required>
                      <option value="Christianity">Christianity</option>
                      <option value="Islam">Islam</option>
                      <option value="Hinduism">Hinduism</option>
                      <option value="Buddhism">Buddhism</option>
                      <option value="Other">Other</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                  </div>

                  <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" class="form-control" id="phone" name="phone" required>
                  </div>

                  <div class="form-group">
                    <label for="address">Address</label>
                    <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                  </div>

                  <div class="form-group">
                    <label for="joining_date">Joining Date</label>
                    <input type="date" class="form-control" id="joining_date" name="joining_date" required>
                  </div>

                  <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
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
</body>
</html>
