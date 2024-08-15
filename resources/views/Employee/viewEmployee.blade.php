<!DOCTYPE html>
<html lang="en">

@include('view-file/head')
<style>
    .form-container {
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        border: 1px solid rgb(56, 56, 56);
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
    .employee-image {
        display: block;
        margin: 0 auto 20px;
    }
    .employee-name {
        text-align: center;
        margin-bottom: 20px;
        font-weight: bold;
    }
</style>

<body>
  <div class="container-scroller">
    @include('view-file/nav')
    <div class="container-fluid page-body-wrapper">
      @include('view-file/side-bar')

      <!-- Inner Section -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="container">
            <!-- Employee Details Card -->
            <div class="card mt-2">
                <div class="header">
                    <h4><i class="fas fa-user"></i> Employee Detail</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{route('employee_view')}}">Employee</a></li>
                             <li class="breadcrumb-item active" aria-current="page" style="color: rgb(180, 176, 176)">Employee Detail</li>
                        </ol>
                    </nav>
                </div>
                <img src="{{ asset('storage/' . $employee->image) }}" alt="Employee Image" class="img-fluid employee-image mt-5 " style="max-width: 150px;">
                <div class="employee-name">{{ $employee->name }}</div>
                
              <div class="card-body">
              <table class="table table-bordered">
                  <tr>
                    <th>Designation</th>
                    <td>{{ $employee->designation->name }}</td>
                  </tr>
                  <tr>
                    <th>Date of Birth</th>
                    <td>{{ $employee->date_of_birth }}</td>
                  </tr>
                  <tr>
                    <th>Gender</th>
                    <td>{{ $employee->gender }}</td>
                  </tr>
                  <tr>
                    <th>Religion</th>
                    <td>{{ $employee->religion }}</td>
                  </tr>
                  <tr>
                    <th>Email</th>
                    <td>{{ $employee->email }}</td>
                  </tr>
                  <tr>
                    <th>Phone</th>
                    <td>{{ $employee->phone }}</td>
                  </tr>
                  <tr>
                    <th>Address</th>
                    <td>{{ $employee->address }}</td>
                  </tr>
                  <tr>
                    <th>Joining Date</th>
                    <td>{{ $employee->joining_date }}</td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- End Inner Section -->
    </div>
  </div>

  @include('view-file/script')
</body>

</html>
