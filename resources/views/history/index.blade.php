<!DOCTYPE html>
<html lang="en">

@include('view-file/head')

<body>
  <div class="container-scroller">
    @include('view-file/nav')
    <div class="container-fluid page-body-wrapper">
      @include('view-file.side-bar')

      <div class="main-panel">
        <div class="content-wrapper">
          <div class="container">
            <!-- Add New Exam Button -->

            <!-- Filter Inputs -->
            <div class="mb-4">
              <div class="row">
                <div class="col-md-6">
                  <button id="copyButton" class="btn btn-light btn-outline-primary">Copy</button>
                  <button id="csvButton" class="btn btn-light btn-outline-primary">CSV</button>
                  <button id="excelButton" class="btn btn-light btn-outline-primary">Excel</button>
                  <button id="pdfButton" class="btn btn-light btn-outline-primary">PDF</button>
                </div>
                <div class="col-md-6">
                    <form id="searchForm" method="GET" action="" class="mb-4">
                        <div class="row">
                          <div class="col-md-4">
                            <div class="form-group">

                              <select name="class" id="class" class="form-control">
                                <option value="">Select Section</option>

                                <!-- Populate classes dynamically -->
                                @foreach ($classes as $class)
                                  <option value="{{ $class->id }}"
                                      {{ $class->id == request()->query('class') ? 'selected' : '' }}>
                                      {{ $class->name }}
                                  </option>
                                @endforeach
                              </select>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">

                              <select name="section" id="section" class="form-control">
                                <option value="">Select Section</option>
                                <!-- Populate sections dynamically -->
                                @foreach ($sections as $section)
                                  <option value="{{ $section->id }}"
                                      {{ $section->id == request()->query('section') ? 'selected' : '' }}>
                                      {{ $section->name }}, {{$section->classe->name}}
                                  </option>
                                @endforeach
                              </select>
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="mt-1"></span>
                            <button type="submit" class="btn btn-primary">Search</button>
                          </div>
                        </div>
                      </form>
                </div>
              </div>
            </div>

            <!-- Exams Table -->
            <div class="card mt-5">
              <div class="card-body">
                <h4 class="card-title">Result</h4>
                <div class="table-responsive">
                  <table class="table table-striped table-bordered text-center">
                    <thead>
                      <tr>
                        <th>Sr.no</th>
                        <th>Student Name</th>
                        <th>Class</th>
                        <th>Section</th>
                        <th>View</th>
                      </tr>
                    </thead>
                    <tbody>
                        @php
                            $count = 0;
                        @endphp
                        @foreach ($students as $student)
                            <tr>
                                <td>{{ ++$count }}</td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->class->name }}</td>
                                <td>{{ $student->section->name }} , {{$student->section->classe->name}}</td>
                                <td><a href="{{ route('admin.student.history', ['student_id' => $student->id]) }}" class="dropdown-item text-info" title="View">
                                    <i class="fas fa-eye"></i>
                                     </a>

                                </td>
                            </tr>

                        @endforeach
                    </tbody>
                  </table>


                <!-- Add a class to hide the table by default -->



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


</body>

</html>
