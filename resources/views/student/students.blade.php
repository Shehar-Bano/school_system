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
          <div class="row justify-content-center">
            <div class="col-lg-11 col-xl-10">
              
              <!-- Modern ERP Form Card -->
              <div class="erp-card-form">
                <div class="erp-form-header-block">
                  <div class="erp-form-title-area">
                    <h3 class="erp-form-title">
                      <i class="fas fa-user-plus text-primary"></i>
                      Register New Student
                    </h3>
                    <p class="erp-form-subtitle">Enroll student, assign class section, tuition fee, guardian details and portal credentials</p>
                  </div>

                  <!-- Back to List Button -->
                  <div>
                    <a href="{{ route('student-list') }}" class="erp-btn-back">
                      <i class="fas fa-arrow-left"></i> Back to Students
                    </a>
                  </div>
                </div>

                <form id="studentForm" action="{{ url('/student') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  
                  <div class="erp-form-body">
                    
                    <!-- 1. Academic & Enrollment Details -->
                    <div class="form-section-title mb-3">
                      <h5 class="text-primary font-weight-bold" style="font-size: 14px; border-bottom: 2px solid #e2e8f0; padding-bottom: 6px;">
                        <i class="fas fa-graduation-cap mr-1"></i> Academic & Enrollment Information
                      </h5>
                    </div>

                    <div class="row mb-3">
                      <!-- Class -->
                      <div class="col-md-4">
                        <div class="erp-form-group">
                          <label for="class" class="erp-form-label">Class <span class="required">*</span></label>
                          <select class="form-control" id="class" name="class" required>
                            <option value="" disabled selected>-- Select Class --</option>
                            @foreach ($classes as $class)
                              <option value="{{ $class->id }}" index="{{ $class->id }}" data-custom="{{ $class->tution_fee }}" {{ old('class') == $class->id ? 'selected' : '' }}>
                                {{ $class->name }}
                              </option>
                            @endforeach
                          </select>
                          @error('class')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <!-- Section -->
                      <div class="col-md-4">
                        <div class="erp-form-group">
                          <label for="section" class="erp-form-label">Section <span class="required">*</span></label>
                          <select class="form-control" id="section" name="section" required>
                            <option value="" disabled selected>-- Select Section --</option>
                            @if($sections)
                              @foreach ($sections as $section)
                                <option value="{{ $section->id }}" class="ab ab{{ $section->classe_id }}" {{ old('section') == $section->id ? 'selected' : '' }}>
                                  {{ $section->name }} ({{ $section->classe->name ?? '' }})
                                </option>
                              @endforeach
                            @endif
                          </select>
                          @error('section')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <!-- Academic Group -->
                      <div class="col-md-4">
                        <div class="erp-form-group">
                          <label for="group" class="erp-form-label">Group / Stream <span class="required">*</span></label>
                          <select class="form-control" id="group" name="group" required>
                            <option value="science" {{ old('group') == 'science' ? 'selected' : '' }}>Science</option>
                            <option value="arts" {{ old('group') == 'arts' ? 'selected' : '' }}>Arts / Humanities</option>
                            <option value="commerce" {{ old('group') == 'commerce' ? 'selected' : '' }}>Commerce</option>
                          </select>
                          @error('group')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <!-- Admission Date -->
                      <div class="col-md-4">
                        <div class="erp-form-group">
                          <label for="admissiondate" class="erp-form-label">Admission Date <span class="required">*</span></label>
                          <input type="date" class="form-control" id="admissiondate" name="admissiondate" value="{{ old('admissiondate', date('Y-m-d')) }}" required>
                          @error('admissiondate')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <!-- Registration Number -->
                      <div class="col-md-4">
                        <div class="erp-form-group">
                          <label for="registration" class="erp-form-label">Registration / Roll No</label>
                          <input type="text" class="form-control" id="registration" name="registration" value="{{ old('registration') }}" placeholder="e.g. REG-2026-001">
                          @error('registration')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <!-- Monthly Tuition Fee -->
                      <div class="col-md-4">
                        <div class="erp-form-group">
                          <label for="tution_fee" class="erp-form-label">Monthly Tuition Fee (Rs.)</label>
                          <input type="number" class="form-control" id="tution_fee" name="tution_fee" value="{{ old('tution_fee') }}" placeholder="e.g. 3500">
                          @error('tution_fee')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                    </div>

                    <!-- 2. Personal & Contact Details -->
                    <div class="form-section-title mb-3">
                      <h5 class="text-primary font-weight-bold" style="font-size: 14px; border-bottom: 2px solid #e2e8f0; padding-bottom: 6px;">
                        <i class="fas fa-user mr-1"></i> Personal & Contact Information
                      </h5>
                    </div>

                    <div class="row mb-3">
                      <!-- Student Full Name -->
                      <div class="col-md-6">
                        <div class="erp-form-group">
                          <label for="name" class="erp-form-label">Student Full Name <span class="required">*</span></label>
                          <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Enter student full name" required>
                          @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <!-- Guardian -->
                      <div class="col-md-6">
                        <div class="erp-form-group">
                          <label for="gurdian" class="erp-form-label">Guardian Relationship <span class="required">*</span></label>
                          <select class="form-control" id="gurdian" name="gurdian" required>
                            <option value="father" {{ old('gurdian') == 'father' ? 'selected' : '' }}>Father</option>
                            <option value="mother" {{ old('gurdian') == 'mother' ? 'selected' : '' }}>Mother</option>
                            <option value="otherFamilyMember" {{ old('gurdian') == 'otherFamilyMember' ? 'selected' : '' }}>Other Relative / Guardian</option>
                          </select>
                          @error('gurdian')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <!-- Date of Birth -->
                      <div class="col-md-4">
                        <div class="erp-form-group">
                          <label for="dob" class="erp-form-label">Date of Birth <span class="required">*</span></label>
                          <input type="date" class="form-control" id="dob" name="dob" value="{{ old('dob') }}" required>
                          @error('dob')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <!-- Gender -->
                      <div class="col-md-4">
                        <div class="erp-form-group">
                          <label for="gender" class="erp-form-label">Gender <span class="required">*</span></label>
                          <select class="form-control" id="gender" name="gender" required>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                          </select>
                          @error('gender')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <!-- Religion -->
                      <div class="col-md-4">
                        <div class="erp-form-group">
                          <label for="religion" class="erp-form-label">Religion</label>
                          <input type="text" class="form-control" id="religion" name="religion" value="{{ old('religion', 'Islam') }}" placeholder="e.g. Islam">
                          @error('religion')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <!-- Email -->
                      <div class="col-md-6">
                        <div class="erp-form-group">
                          <label for="email" class="erp-form-label">Email Address</label>
                          <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="student@school.edu">
                          @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <!-- Phone -->
                      <div class="col-md-6">
                        <div class="erp-form-group">
                          <label for="phone" class="erp-form-label">Contact / Guardian Phone</label>
                          <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" placeholder="e.g. +92 300 1234567">
                          @error('phone')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <!-- Address -->
                      <div class="col-md-12">
                        <div class="erp-form-group">
                          <label for="address" class="erp-form-label">Residential Address</label>
                          <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" placeholder="House #, Street, City">
                          @error('address')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                    </div>

                    <!-- 3. Portal Account & Security -->
                    <div class="form-section-title mb-3">
                      <h5 class="text-primary font-weight-bold" style="font-size: 14px; border-bottom: 2px solid #e2e8f0; padding-bottom: 6px;">
                        <i class="fas fa-shield-halved mr-1"></i> Portal Access & Security
                      </h5>
                    </div>

                    <div class="row mb-3">
                      <!-- Username -->
                      <div class="col-md-4">
                        <div class="erp-form-group">
                          <label for="username" class="erp-form-label">Portal Username <span class="required">*</span></label>
                          <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" placeholder="e.g. std_john" required>
                          @error('username')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <!-- Role -->
                      <div class="col-md-4">
                        <div class="erp-form-group">
                          <label for="role" class="erp-form-label">Portal Security Role</label>
                          <select class="form-control" id="role" name="role">
                            @if(isset($roles))
                              @foreach ($roles as $role)
                                <option value="{{ $role->name }}" {{ old('role', 'student') == $role->name ? 'selected' : '' }}>
                                  {{ ucfirst($role->name) }} ({{ $role->permissions->count() }} permissions)
                                </option>
                              @endforeach
                            @endif
                          </select>
                        </div>
                      </div>

                      <!-- Student Photo -->
                      <div class="col-md-4">
                        <div class="erp-form-group">
                          <label for="image" class="erp-form-label">Profile Photo</label>
                          <input type="file" class="form-control" id="image" name="image" accept="image/*">
                          @error('image')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                    </div>

                    <!-- Password Security Row -->
                    <div class="row">
                      <!-- Password -->
                      <div class="col-md-6">
                        <div class="erp-form-group">
                          <label for="password" class="erp-form-label">
                            Portal Password <span class="text-muted font-weight-normal" style="font-size: 11.5px;">(Optional, defaults to Reg. No or '123456')</span>
                          </label>
                          <div class="input-group">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Create login password" autocomplete="new-password">
                            <div class="input-group-append">
                              <button class="btn btn-outline-secondary" type="button" onclick="toggleInputPassword('password', this)" style="border: 1px solid #ced4da; border-left: none;">
                                <i class="fas fa-eye"></i>
                              </button>
                            </div>
                          </div>
                          @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <!-- Confirm Password -->
                      <div class="col-md-6">
                        <div class="erp-form-group">
                          <label for="password_confirmation" class="erp-form-label">
                            Confirm Portal Password
                          </label>
                          <div class="input-group">
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" placeholder="Repeat portal password" autocomplete="new-password">
                            <div class="input-group-append">
                              <button class="btn btn-outline-secondary" type="button" onclick="toggleInputPassword('password_confirmation', this)" style="border: 1px solid #ced4da; border-left: none;">
                                <i class="fas fa-eye"></i>
                              </button>
                            </div>
                          </div>
                          @error('password_confirmation')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                    </div>

                  </div>

                  <!-- Form Action Footer -->
                  <div class="erp-form-footer">
                    <a href="{{ route('student-list') }}" class="btn btn-sm btn-outline-secondary">
                      Cancel
                    </a>
                    <button type="submit" class="erp-btn-submit">
                      <i class="fas fa-check"></i> Register Student
                    </button>
                  </div>
                </form>

              </div>
              <!-- End ERP Card Form -->

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @include('view-file/script')
  
  <script>
    function toggleInputPassword(inputId, btn) {
      const input = document.getElementById(inputId);
      const icon = btn.querySelector('i');
      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    }

    $(document).ready(function(){
      $('#class').on('change', function() {
        var selectedOption = $(this).find('option:selected');
        var tutionFee = selectedOption.data('custom');
        if (tutionFee) {
          $('#tution_fee').val(tutionFee);
        }
        var classIndex = selectedOption.attr('index');
        $('#section option').each(function(){
          if($(this).val() === '') return;
          if($(this).hasClass('ab' + classIndex)) {
            $(this).show();
          } else {
            $(this).hide();
          }
        });
      });
    });
  </script>
</body>
</html>
