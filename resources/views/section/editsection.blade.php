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
            <div class="col-lg-10 col-xl-9">
              
              <!-- Modern ERP Form Card -->
              <div class="erp-card-form">
                <div class="erp-form-header-block">
                  <div class="d-flex align-items-center gap-3">
                    <div class="erp-header-icon-badge">
                      <i class="fas fa-pen-to-square"></i>
                    </div>
                    <div class="erp-form-title-area">
                      <h3 class="erp-form-title">
                        Update Section Details
                      </h3>
                      <p class="erp-form-subtitle">Modify section name, capacity, assigned class, and class teacher</p>
                    </div>
                  </div>

                  <!-- Back to List Button -->
                  <div>
                    <a href="{{ route('section-list') }}" class="erp-btn-back">
                      <i class="fas fa-arrow-left"></i> Back to Sections
                    </a>
                  </div>
                </div>

                <form action="{{ route('section-update', ['id' => $section->id]) }}" method="POST" id="editSectionForm">
                  @csrf
                  
                  <div class="erp-form-body">
                    <div class="row g-3">
                      <!-- Section Name -->
                      <div class="col-md-6">
                        <div class="erp-form-group">
                          <label for="sectionName" class="erp-form-label">
                            Section Name / Identifier <span class="required">*</span>
                          </label>
                          <div class="erp-input-wrapper">
                            <i class="fas fa-tag input-icon-prefix"></i>
                            <input type="text" class="form-control has-prefix-icon" id="sectionName" name="name" value="{{ old('name', $section->name) }}" placeholder="Enter section name" required autofocus>
                          </div>
                          @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <!-- Student Capacity -->
                      <div class="col-md-6">
                        <div class="erp-form-group">
                          <label for="capacity" class="erp-form-label">
                            Student Capacity Limit <span class="required">*</span>
                          </label>
                          <div class="erp-input-wrapper">
                            <i class="fas fa-users input-icon-prefix"></i>
                            <input type="number" class="form-control has-prefix-icon" id="capacity" name="capacity" value="{{ old('capacity', $section->capacity) }}" placeholder="e.g. 40" min="1" required>
                          </div>
                          @error('capacity')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <!-- Target Class -->
                      <div class="col-md-6">
                        <div class="erp-form-group">
                          <label for="classeSelect" class="erp-form-label">
                            Target Academic Class <span class="required">*</span>
                          </label>
                          <div class="erp-input-wrapper">
                            <i class="fas fa-chalkboard-user input-icon-prefix"></i>
                            <select class="form-control has-prefix-icon" name="class" id="classeSelect" required>
                              <option value="" disabled>-- Select a Class --</option>
                              @foreach ($class as $clas)
                                <option value="{{ $clas->id }}" {{ old('class', $section->classe_id) == $clas->id ? 'selected' : '' }}>
                                  {{ $clas->name }}
                                </option>
                              @endforeach
                            </select>
                          </div>
                          @error('class')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <!-- Assigned Class Teacher / Incharge -->
                      <div class="col-md-6">
                        <div class="erp-form-group">
                          <label for="teacherSelect" class="erp-form-label">
                            Section Incharge / Class Teacher <span class="required">*</span>
                          </label>
                          <div class="erp-input-wrapper">
                            <i class="fas fa-user-tie input-icon-prefix"></i>
                            <select class="form-control has-prefix-icon" name="employ" id="teacherSelect" required>
                              <option value="" disabled>-- Select Assigned Professor / Teacher --</option>
                              @foreach ($teacher as $tec)
                                @php
                                  $isAssigned = isset($assignedTeachers[$tec->id]);
                                  $assignedSectionInfo = $isAssigned ? (($assignedTeachers[$tec->id]->classe->name ?? 'Class') . ' - ' . $assignedTeachers[$tec->id]->name) : '';
                                  $isCurrentTeacher = ($section->employee_id == $tec->id);
                                @endphp
                                <option value="{{ $tec->id }}" 
                                        data-assigned="{{ $isAssigned ? 'true' : 'false' }}"
                                        data-assigned-info="{{ $assignedSectionInfo }}"
                                        data-teacher-name="{{ $tec->name }}"
                                        {{ old('employ', $section->employee_id) == $tec->id ? 'selected' : '' }}
                                        @if($isAssigned) style="color: #b91c1c; font-weight: 600; background-color: #fef2f2;" @endif>
                                  {{ $tec->name }} ({{ $tec->designation->name ?? 'Staff' }}) 
                                  @if($isCurrentTeacher)
                                    [Current Incharge]
                                  @elseif($isAssigned)
                                    [⚠️ Already Incharge: {{ $assignedSectionInfo }}]
                                  @else
                                    [✓ Available]
                                  @endif
                                </option>
                              @endforeach
                            </select>
                          </div>
                          <div id="teacherConflictHint" class="small mt-1 text-danger fw-semibold" style="display: none;"></div>
                          @error('employ')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <!-- Note / Remarks -->
                      <div class="col-12">
                        <div class="erp-form-group mb-0">
                          <label for="sectionNote" class="erp-form-label">Note / Room & Campus Remarks</label>
                          <textarea class="form-control" id="sectionNote" rows="3" name="note" placeholder="Enter optional notes, room location, or remarks...">{{ old('note', $section->note) }}</textarea>
                          @error('note')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Form Action Footer -->
                  <div class="erp-form-footer">
                    <a href="{{ route('section-list') }}" class="btn btn-sm btn-outline-secondary">
                      Cancel
                    </a>
                    <button type="submit" class="erp-btn-submit">
                      <i class="fas fa-floppy-disk"></i> Update Section
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

  <!-- Teacher Incharge Conflict Check Script -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const teacherSelect = document.getElementById('teacherSelect');
      const conflictHint = document.getElementById('teacherConflictHint');
      const editSectionForm = document.getElementById('editSectionForm');
      const currentTeacherId = "{{ $section->employee_id }}";

      function validateTeacherSelection(showModal = true) {
        if (!teacherSelect || !teacherSelect.value) {
          if (conflictHint) conflictHint.style.display = 'none';
          return true;
        }

        const selectedOption = teacherSelect.options[teacherSelect.selectedIndex];
        const isAssigned = selectedOption.getAttribute('data-assigned') === 'true';
        const assignedInfo = selectedOption.getAttribute('data-assigned-info') || 'another section';
        const teacherName = selectedOption.getAttribute('data-teacher-name') || 'This professor';

        // If the teacher is assigned to another section
        if (isAssigned) {
          if (conflictHint) {
            conflictHint.innerHTML = `<i class="fas fa-triangle-exclamation mr-1"></i> <strong>${teacherName}</strong> is already Incharge of <strong>${assignedInfo}</strong>. Please select another professor.`;
            conflictHint.style.display = 'block';
          }

          if (showModal) {
            Swal.fire({
              icon: 'warning',
              title: 'Professor Already Assigned!',
              html: `
                <div style="text-align: left; font-size: 13.5px; line-height: 1.6; color: #334155;">
                  <p class="mb-2"><strong>${teacherName}</strong> is already assigned as Incharge for:</p>
                  <div class="p-2.5 rounded mb-3" style="background: #fffbeb; border: 1px solid #fde68a; color: #92400e; font-weight: 600; padding: 10px;">
                    <i class="fas fa-exclamation-triangle mr-1 text-warning"></i> ${assignedInfo}
                  </div>
                  <p class="mb-0 text-danger fw-semibold">
                    <i class="fas fa-circle-xmark mr-1"></i> A professor can only be Incharge of one section at a time. Please select another professor.
                  </p>
                </div>
              `,
              confirmButtonColor: '#4f46e5',
              confirmButtonText: '<i class="fas fa-user-plus mr-1"></i> Choose Another Professor'
            }).then(() => {
              teacherSelect.value = currentTeacherId;
              if (conflictHint) conflictHint.style.display = 'none';
            });
          }
          return false;
        } else {
          if (conflictHint) conflictHint.style.display = 'none';
          return true;
        }
      }

      if (teacherSelect) {
        teacherSelect.addEventListener('change', function () {
          validateTeacherSelection(true);
        });
      }

      if (editSectionForm) {
        editSectionForm.addEventListener('submit', function (e) {
          if (!validateTeacherSelection(true)) {
            e.preventDefault();
          }
        });
      }
    });
  </script>
</body>
</html>
