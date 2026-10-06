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
                      <i class="fas fa-user-pen text-primary"></i>
                      Update Staff / Employee Profile
                    </h3>
                    <p class="erp-form-subtitle">Modify employee position, personal details, contact information and portal role</p>
                  </div>

                  <!-- Back to List Button -->
                  <div>
                    <a href="{{ route('employee_view') }}" class="erp-btn-back">
                      <i class="fas fa-arrow-left"></i> Back to Employees
                    </a>
                  </div>
                </div>

                <form action="{{ route('employees_update', ['id' => $employee->id]) }}" method="POST" enctype="multipart/form-data" id="editEmployeeForm">
                  @csrf
                  
                  <div class="erp-form-body">
                    
                    <!-- 1. Position & Employment Info -->
                    <div class="form-section-title mb-3">
                      <h5 class="text-primary font-weight-bold" style="font-size: 14px; border-bottom: 2px solid #e2e8f0; padding-bottom: 6px;">
                        <i class="fas fa-briefcase mr-1"></i> Employment & Position Details
                      </h5>
                    </div>

                    <div class="row mb-3">
                      <!-- Designation -->
                      <div class="col-md-6">
                        <div class="erp-form-group">
                          <label for="designation" class="erp-form-label">Designation / Role <span class="required">*</span></label>
                          <select class="form-control" id="designation" name="designation" required>
                            <option value="" disabled>-- Select Designation --</option> 
                            @foreach ($designations as $designation)
                              <option value="{{ $designation->id }}" {{ ($employee->designation_id == $designation->id || ($employee->designation && $employee->designation->id == $designation->id)) ? 'selected' : '' }}>
                                {{ $designation->name }}
                              </option>
                            @endforeach
                          </select>
                          @error('designation')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <!-- Joining Date -->
                      <div class="col-md-6">
                        <div class="erp-form-group">
                          <label for="joining_date" class="erp-form-label">Date of Joining</label>
                          <input type="date" class="form-control" id="joining_date" name="joining_date" value="{{ old('joining_date', $employee->joining_date) }}">
                          @error('joining_date')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                    </div>

                    <!-- 2. Personal & Contact Info -->
                    <div class="form-section-title mb-3">
                      <h5 class="text-primary font-weight-bold" style="font-size: 14px; border-bottom: 2px solid #e2e8f0; padding-bottom: 6px;">
                        <i class="fas fa-user-tie mr-1"></i> Personal & Contact Information
                      </h5>
                    </div>

                    <div class="row mb-3">
                      <!-- Full Name -->
                      <div class="col-md-6">
                        <div class="erp-form-group">
                          <label for="name" class="erp-form-label">Full Name <span class="required">*</span></label>
                          <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $employee->name) }}" placeholder="e.g. John Doe" required autofocus>
                          @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <!-- Email -->
                      <div class="col-md-6">
                        <div class="erp-form-group">
                          <label for="email" class="erp-form-label">Email Address <span class="required">*</span></label>
                          <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $employee->email) }}" placeholder="staff@school.edu" required>
                          @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <!-- Phone -->
                      <div class="col-md-4">
                        <div class="erp-form-group">
                          <label for="phone" class="erp-form-label">Phone Number <span class="required">*</span></label>
                          <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $employee->phone) }}" placeholder="+92 300 1234567" required>
                          @error('phone')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <!-- Date of Birth -->
                      <div class="col-md-4">
                        <div class="erp-form-group">
                          <label for="dob" class="erp-form-label">Date of Birth <span class="required">*</span></label>
                          <input type="date" class="form-control" id="dob" name="date_of_birth" value="{{ old('date_of_birth', $employee->date_of_birth) }}" required>
                          @error('date_of_birth')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <!-- Gender -->
                      <div class="col-md-4">
                        <div class="erp-form-group">
                          <label class="erp-form-label">Gender <span class="required">*</span></label>
                          <div class="d-flex align-items-center gap-4 mt-2">
                            <div class="form-check mr-3">
                              <input class="form-check-input" type="radio" name="gender" id="genderMale" value="Male" {{ old('gender', $employee->gender) == 'Male' ? 'checked' : '' }}>
                              <label class="form-check-label font-weight-medium" for="genderMale">Male</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="gender" id="genderFemale" value="Female" {{ old('gender', $employee->gender) == 'Female' ? 'checked' : '' }}>
                              <label class="form-check-label font-weight-medium" for="genderFemale">Female</label>
                            </div>
                          </div>
                          @error('gender')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <!-- Religion -->
                      <div class="col-md-4">
                        <div class="erp-form-group">
                          <label for="religion" class="erp-form-label">Religion</label>
                          <select class="form-control" id="religion" name="religion">
                            <option value="Islam" {{ old('religion', $employee->religion) == 'Islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Christianity" {{ old('religion', $employee->religion) == 'Christianity' ? 'selected' : '' }}>Christianity</option>
                            <option value="Hinduism" {{ old('religion', $employee->religion) == 'Hinduism' ? 'selected' : '' }}>Hinduism</option>
                            <option value="Other" {{ old('religion', $employee->religion) == 'Other' ? 'selected' : '' }}>Other</option>
                          </select>
                        </div>
                      </div>

                      <!-- Address -->
                      <div class="col-md-8">
                        <div class="erp-form-group">
                          <label for="address" class="erp-form-label">Residential Address <span class="required">*</span></label>
                          <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $employee->address) }}" placeholder="House #, Street, City" required>
                          @error('address')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                    </div>

                    <!-- 3. Portal Security & Role -->
                    <div class="form-section-title mb-3">
                      <h5 class="text-primary font-weight-bold" style="font-size: 14px; border-bottom: 2px solid #e2e8f0; padding-bottom: 6px;">
                        <i class="fas fa-shield-halved mr-1"></i> Security & Permissions
                      </h5>
                    </div>

                    <div class="row mb-3">
                      <!-- Assign Security Role -->
                      <div class="col-md-6">
                        <div class="erp-form-group">
                          <label for="role" class="erp-form-label">Portal Security Role</label>
                          <select class="form-control" id="role" name="role">
                            <option value="" disabled>-- Select Role --</option>
                            @php
                              $currentRole = $employee->roles->first() ? $employee->roles->first()->name : 'employee';
                            @endphp
                            @if(isset($roles))
                              @foreach ($roles as $role)
                                <option value="{{ $role->name }}" {{ old('role', $currentRole) == $role->name ? 'selected' : '' }}>
                                  {{ ucfirst($role->name) }} ({{ $role->permissions->count() }} permissions)
                                </option>
                              @endforeach
                            @endif
                          </select>
                          <small class="text-muted">The assigned role grants module access privileges to this employee.</small>
                        </div>
                      </div>

                      <!-- Photo Upload -->
                      <div class="col-md-6">
                        <div class="erp-form-group mb-0">
                          <label for="image" class="erp-form-label">Change Photo</label>
                          <input type="file" class="form-control" id="image" name="image" accept="image/*">
                          @if($employee->image && $employee->image !== 'default.png')
                            <div class="mt-2 d-flex align-items-center gap-2">
                              <img src="{{ asset('storage/' . $employee->image) }}" class="rounded-circle border" style="width: 32px; height: 32px; object-fit: cover;" alt="current">
                              <span class="text-xs text-muted">Current photo</span>
                            </div>
                          @endif
                          @error('image')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                    </div>

                    <!-- Password Security Row -->
                    <div class="row">
                      <!-- New Password -->
                      <div class="col-md-6">
                        <div class="erp-form-group">
                          <label for="password" class="erp-form-label">
                            New Password <span class="text-muted font-weight-normal" style="font-size: 11.5px;">(Leave blank to keep unchanged)</span>
                          </label>
                          <div class="input-group">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Enter new password (min. 6 chars)" autocomplete="new-password">
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
                            Confirm New Password
                          </label>
                          <div class="input-group">
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" placeholder="Repeat new password" autocomplete="new-password">
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
                    <a href="{{ route('employee_view') }}" class="btn btn-sm btn-outline-secondary">
                      Cancel
                    </a>
                    <button type="submit" class="erp-btn-submit">
                      <i class="fas fa-save"></i> Update Employee
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
  </script>
</body>
</html>
