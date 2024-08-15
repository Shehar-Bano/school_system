<!DOCTYPE html>
<html lang="en">

@include('view-file/head')
<body>
  <div class="container-scroller">
    @include('view-file/nav')
    <div class="container-fluid page-body-wrapper">
      @include('view-file.side-bar')
      {{-- inner_page --}}
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                    <div class="header">
                        <h4><i class="fas fa-file-alt"></i> Assignment</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{route('subject_show')}}">Acadamic</a></li>
                                <li class="breadcrumb-item"><a href="{{route('assignment_show')}}">Assignment</a></li>
                                <li class="breadcrumb-item active" aria-current="page" style="color: rgb(180, 176, 176)">Assignment Details</li>
                            </ol>
                        </nav>
                    </div>
                
                  <div class="row mt-5">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="assignmentTitle" class="font-weight-bold">Title:</label>
                        <p id="assignmentTitle">{{ $assignment->title }}</p>
                      </div>
                      <div class="form-group">
                        <label for="assignmentDescription" class="font-weight-bold">Description:</label>
                        <p id="assignmentDescription">{{ $assignment->description }}</p>
                      </div>
                      <div class="form-group">
                        <label for="assignmentUploader" class="font-weight-bold">Uploaded By:</label>
                        <p id="assignmentUploader">{{ $assignment->uploader }}</p>
                      </div>
                      <div class="form-group">
                        <label for="assignmentDeadline" class="font-weight-bold">Deadline:</label>
                        <p id="assignmentDeadline">{{ $assignment->deadline }}</p>
                      </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="assignmentDeadline" class="font-weight-bold">class:</label>
                            <p id="assignmentDeadline">{{ $assignment->class->name }}</p>
                          </div>
                      <div class="form-group">
                        <label for="assignmentDeadline" class="font-weight-bold">Section:</label>
                        <p id="assignmentDeadline">{{ $assignment->section->name }}</p>
                      </div>
                      <div class="form-group">
                        <label for="assignmentDeadline" class="font-weight-bold">Subject:</label>
                        <p id="assignmentDeadline">{{ $assignment->subject->subject_name }}</p>
                      </div>
                     

                      <div class="form-group">
                        <label for="assignmentFile" class="font-weight-bold">Uploaded File:</label>
                        <img src="{{ asset('storage/' . $assignment->assignment) }}" alt="Uploaded File" class="img-thumbnail">
                      </div>
                      
                    </div>
                  </div>
                 
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      {{-- End inner_page --}}
    </div>
  </div>
  @include('view-file/script')

</body>

</html>
