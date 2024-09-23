
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
          <div class="container mt-5">

            <!-- Search Form -->
            <form id="searchForm" method="GET" action="{{ route('students_attendence') }}" class="mb-4">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="class">Class</label>
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
                 <div class="col-md-3">
                  <div class="form-group">
                    <label for="section">Section</label>
                    <select name="section" id="section" class="form-control">
                      <option value="">Select Section</option>
                      @foreach ($sections as $section)
                        <option value="{{ $section->id }}" {{ $section->id == request()->query('section') ? 'selected' : '' }}>
                          {{ $section->name }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-3 mt-4">
                  <button type="submit" class="btn btn-primary">Search</button>
                </div>
              </div>
            </form>

            <!-- Time Table -->
            <!-- Table for Class, Section, and Students -->
<div class="card mt-4">
  <div class="card-body">
    <h4 class="card-title">View Fee Details of Class</h4>
    <div class="table-responsive">
      <table class="table table-bordered text-center">
        <thead>
          <tr>
            <th>#</th>
            <th>Class</th>
            <th>Section</th>

            <th>Taxe's</th>

          </tr>
        </thead>
        <tbody>
          @php
            $serialNumber = 1;
          @endphp
          @foreach ($sections as $section)
          <tr>
            <td>{{ $serialNumber++ }}</td>
            <td>{{ $section->classe->name }}</td> <!-- Assuming there is a relation to Class model -->
            <td>{{ $section->name }}</td> <!-- Assuming there is a relation to Section model -->

            <td>
              <a href="{{ route('taxe.show.student',['id'=>$section->id]) }}" title="Mange Fee">
                <i class="fas fa-money-bill-wave"></i>

              </a>
            </td>
          </tr>

          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>


          </div>
        </div>
      </div>
      <!-- End Inner-page -->
    </div>
  </div>

  @include('view-file.script')

  @if(session('message'))
    <script>
      Swal.fire({
        title: 'Success!',
        text: "{{ session('message') }}",
        icon: 'success',
        confirmButtonText: 'OK'
      });
    </script>
  @endif

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
</body>
</html>
