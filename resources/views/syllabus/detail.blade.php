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
                        <h4><i class="fas fa-file-alt"></i> Syllabus</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{route('subject_show')}}">Acadamic</a></li>
                                <li class="breadcrumb-item"><a href="{{route('syllabus_show')}}">Syllabus</a></li>
                                <li class="breadcrumb-item active" aria-current="page" style="color: rgb(180, 176, 176)">Syllabus Details</li>
                            </ol>
                        </nav>
                    </div>
                
                  <div class="row mt-5">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="assignmentTitle" class="font-weight-bold">Title:</label>
                        <p id="assignmentTitle">{{ $syllabus->title }}</p>
                      </div>
                      <div class="form-group">
                        <label for="assignmentDescription" class="font-weight-bold">Description:</label>
                        <p id="assignmentDescription">{{ $syllabus->description }}</p>
                      </div>
                      <div class="form-group">
                        <label for="assignmentUploader" class="font-weight-bold">Uploaded By:</label>
                        <p id="assignmentUploader">{{ $syllabus->uploader }}</p>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="assignmentDeadline" class="font-weight-bold">Date:</label>
                        <p id="assignmentDeadline">{{ $syllabus->date }}</p>
                      </div>
                      <div class="form-group">
                        <label for="assignmentFile" class="font-weight-bold">Uploaded Syllabus:</label>
                        <img src="{{ asset('storage/' . $syllabus->file) }}" alt="Uploaded Syllabus" class="img-thumbnail">
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
