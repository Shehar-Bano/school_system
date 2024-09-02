<!DOCTYPE html>
<html lang="en">
@include('view-file/head')
<head>
    <!-- Include SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    .form-container {
        background-color: white;
        padding: 20px;
        border-radius: 8px;
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
</head>
<body>
    <div class="container-scroller">
      @include('view-file/nav')
      <div class="container-fluid page-body-wrapper">
        @include('view-file.side-bar')
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="container mt-5">
              <div class="form-container">
                  <div class="header">
                      <h4><i class="fas fa-pencil-alt"></i>Update Student</h4>
                      <nav aria-label="breadcrumb">
                          <ol class="breadcrumb mb-0">
                              <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                              <li class="breadcrumb-item">Academic</li>
                              <li class="breadcrumb-item"><a href="{{route('student-list')}}">Students</a></li>
                              <li class="breadcrumb-item active" aria-current="page" style="color: rgb(180, 176, 176)">Update Student</li>
                          </ol>
                      </nav>
                  </div>

                  <form id="studentForm" class="mt-4" action="{{route('student-update',['id'=>$student->id])}}" method="POST" enctype="multipart/form-data">
                      @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Student Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" value="{{$student->name}}"  placeholder="Enter student name" required>
                    </div>

                    <div class="mb-3">
                        <label for="gurdian" class="form-label">Guardian <span class="text-danger">*</span></label>
                        <select class="form-control" id="gurdian" name="gurdian" required>
                            <option value="" disabled selected>Select Guardian</option>
                            <option value="father"{{$student->gurdian == 'father' ? 'selected' : ''}}>Father</option>
                            <option value="mother" {{$student->gurdian == 'mother' ? 'selected' : ''}}>Mother</option>
                            <option value="otherFamilyMember" {{$student->gurdian == 'otherFamilyMember' ? 'selected' : ''}}>Other Family Member</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="admissiondate" class="form-label">Admission Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="admissiondate" value={{$student->admissiondate}} name="admissiondate" required>
                    </div>

                    <div class="mb-3">
                        <label for="dob" class="form-label">Date of Birth <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="dob" value={{$student->dob}} name="dob" required>
                    </div>

                    <div class="mb-3">
                        <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                        <select class="form-control" id="gender" name="gender" required>
                            <option value="" disabled selected>Select Gender</option>
                            <option value="male" {{$student->gender == 'male' ? 'selected' : ''}}>Male</option>
                            <option value="female" {{$student->gender == 'female' ? 'selected' : ''}}>Female</option>
                            <option value="other" {{$student->gender == 'other' ? 'selected' : ''}}>Other</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="religion" class="form-label">Religion</label>
                        <input type="text" class="form-control" id="religion" value="{{$student->religion}}" name="religion" placeholder="Enter religion">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" value="{{$student->email}}" name="email" placeholder="Enter email">
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" value="{{$student->phone}}" name="phone" placeholder="Enter phone number">
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" value="{{$student->address}}" name="address" placeholder="Enter address">
                    </div>

                    <div class="mb-3">
                        <label for="class" class="form-label">Class <span class="text-danger">*</span></label>
                        <select class="form-control" id="class" name="class" required>
                            <option value="" disabled selected>Select Class</option>
                            @foreach ($classes as $class)
                                <option  value="{{ $class->id }}" {{$student->class_id == $class->id ? 'selected' : ''}} index="{{$class->id}}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                   
                    <div class="mb-3">
                        <label for="tution_fee" class="form-label">Tution Fee </label>
                        <input type="number" class="form-control" id="tution_fee" name="tution_fee"  value={{ $student->tution_fee }} placeholder="Enter fee concession">
                    </div>
                    <div class="mb-3">
                        <label for="section" class="form-label">Section <span class="text-danger">*</span></label>
                        <select class="form-control" id="section" name="section" required>
                            <option value="" disabled selected>Select Section</option>
                            @foreach ($sections as $section)
                                <option  value="{{ $section->id }}"{{$student->section_id == $section->id ? 'selected' : ''}} class="ab ab{{$section->classe_id}}">{{ $section->name }}, {{$section->classe->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="group" class="form-label">Group <span class="text-danger">*</span></label>
                        <select class="form-control" id="group" name="group" required>
                            <option value="" disabled selected>Select Group</option>
                            <option value="arts" {{$student->group == 'art' ? 'selected' : ''}}>Arts</option>
                            <option value="science" {{$student->group == 'science' ? 'selected' : ''}}>Science</option>
                            <option value="commerce" {{$student->group == 'commerce' ? 'selected' : ''}}>Commerce</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="registration" class="form-label">Registration Number</label>
                        <input type="text" class="form-control" id="registration" value="{{$student->registration}}" name="registration" placeholder="Enter registration number">
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Upload Image</label>
                        <input type="file" class="form-control"  id="image" name="image">


                    </div>
                    <input type="submit" id="submitBtn" class="btn btn-primary" value="Update Student">
                  </form>
            </div>
          </div>
        </div>
      </div>
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

   <script>
    $(document).ready(function(){
        $('#class').on('change',function(){
      $('.ab').hide()
      $('.ab'+ $(this).children('option:selected').attr('index')).css('display', 'block')
      })
    })
    </script>
</body>
</html>
