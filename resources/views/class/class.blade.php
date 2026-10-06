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
                  <div class="d-flex align-items-center gap-3">
                    <div class="erp-header-icon-badge">
                      <i class="fas fa-chalkboard-user"></i>
                    </div>
                    <div class="erp-form-title-area">
                      <h3 class="erp-form-title">
                        Add New Class
                      </h3>
                      <p class="erp-form-subtitle">Create a class grade level, configure monthly tuition fee, and map curriculum subjects</p>
                    </div>
                  </div>

                  <!-- Back to List Button -->
                  <div>
                    <a href="{{ route('class-list') }}" class="erp-btn-back">
                      <i class="fas fa-arrow-left"></i> Back to Classes
                    </a>
                  </div>
                </div>

                <form action="{{ url('/class') }}" method="POST" id="addClassForm">
                  @csrf
                  
                  <div class="erp-form-body">
                    
                    <!-- Section 1: Basic Class Information -->
                    <div class="row g-3 mb-4">
                      <!-- Class Name -->
                      <div class="col-md-6">
                        <div class="erp-form-group mb-0">
                          <label for="className" class="erp-form-label">
                            Class Grade / Name <span class="required">*</span>
                          </label>
                          <div class="erp-input-wrapper">
                            <i class="fas fa-graduation-cap input-icon-prefix"></i>
                            <input type="text" class="form-control has-prefix-icon" id="className" name="name" value="{{ old('name') }}" placeholder="e.g. Class 10 / Matric Section A" required autofocus>
                          </div>
                          @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <!-- Tuition Fee -->
                      <div class="col-md-6">
                        <div class="erp-form-group mb-0">
                          <label for="tution_fee" class="erp-form-label">
                            Standard Monthly Tuition Fee <span class="required">*</span>
                          </label>
                          <div class="erp-input-wrapper">
                            <span class="input-currency-prefix">PKR</span>
                            <input type="number" class="form-control has-currency-prefix" id="tution_fee" name="tution_fee" value="{{ old('tution_fee') }}" placeholder="e.g. 4500" min="0" required>
                          </div>
                          @error('tution_fee')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                    </div>

                    <!-- Section 2: Interactive Curriculum Subjects Assignment -->
                    <div class="erp-form-group mb-4">
                      <div class="erp-picker-box">
                        <div class="erp-picker-header">
                          <h4 class="erp-picker-title">
                            <i class="fas fa-book-open text-primary"></i>
                            Assign Curriculum Subjects <span class="required">*</span>
                          </h4>

                          <div class="erp-picker-actions">
                            <!-- Live search mini input -->
                            <div class="erp-search-mini">
                              <i class="fas fa-search"></i>
                              <input type="text" id="subjectFilterInput" placeholder="Filter subjects..." autocomplete="off">
                            </div>

                            <!-- Action buttons -->
                            <button type="button" class="erp-btn-xs-action" id="btnSelectAllSubjects">
                              <i class="fas fa-check-double mr-1"></i> Select All
                            </button>
                            <button type="button" class="erp-btn-xs-action" id="btnClearAllSubjects">
                              <i class="fas fa-rotate-left mr-1"></i> Clear
                            </button>

                            <!-- Counter badge -->
                            <span id="subjectCountBadge" class="badge badge-soft-primary" style="font-size: 11px; padding: 5px 9px;">
                              0 Selected
                            </span>
                          </div>
                        </div>

                        <!-- Grid of Subject Selection Cards -->
                        <div class="erp-subject-grid" id="subjectCardsGrid">
                          @forelse ($subjects as $subject)
                            <label class="erp-subject-card" for="subject-{{ $subject->id }}" data-subject-name="{{ strtolower($subject->subject_name) }}" data-subject-code="{{ strtolower($subject->sub_code ?? '') }}">
                              <input type="checkbox" name="subject_id[]" value="{{ $subject->id }}" id="subject-{{ $subject->id }}" class="subject-checkbox" {{ (is_array(old('subject_id')) && in_array($subject->id, old('subject_id'))) ? 'checked' : '' }}>
                              
                              <div class="erp-subject-info">
                                <span class="erp-subject-name" title="{{ $subject->subject_name }}">
                                  {{ $subject->subject_name }}
                                </span>
                                <div class="erp-subject-meta">
                                  <span class="erp-subject-code">{{ $subject->sub_code ?? 'SUB' }}</span>
                                  @if($subject->type)
                                    <span class="text-muted" style="font-size: 10px;">• {{ $subject->type }}</span>
                                  @endif
                                </div>
                              </div>

                              <div class="erp-subject-check-icon">
                                <i class="fas fa-check"></i>
                              </div>
                            </label>
                          @empty
                            <div class="p-4 text-center text-muted col-12">
                              <i class="fas fa-book-open-reader fa-2x text-muted mb-2 d-block opacity-50"></i>
                              No curriculum subjects created yet. Please create subjects in Academics menu first.
                            </div>
                          @endforelse
                        </div>

                        <div id="noSubjectMatchMsg" class="text-center py-3 text-muted small" style="display: none;">
                          <i class="fas fa-magnifying-glass mr-1"></i> No matching subjects found.
                        </div>
                      </div>
                      @error('subject_id')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                      @enderror
                    </div>

                    <!-- Section 3: Class Description / Note -->
                    <div class="erp-form-group mb-0">
                      <label for="classNote" class="erp-form-label">Class Description / Note</label>
                      <textarea class="form-control" id="classNote" rows="3" name="note" placeholder="Enter optional notes, academic stream prerequisites, or room assignments...">{{ old('note') }}</textarea>
                      @error('note')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                      @enderror
                    </div>

                  </div>

                  <!-- Form Action Footer -->
                  <div class="erp-form-footer">
                    <a href="{{ route('class-list') }}" class="btn btn-sm btn-outline-secondary">
                      Cancel
                    </a>
                    <button type="submit" class="erp-btn-submit">
                      <i class="fas fa-check"></i> Save Class
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

  <!-- Interactive Subject Selection Script -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const cards = document.querySelectorAll('.erp-subject-card');
      const countBadge = document.getElementById('subjectCountBadge');
      const selectAllBtn = document.getElementById('btnSelectAllSubjects');
      const clearAllBtn = document.getElementById('btnClearAllSubjects');
      const searchInput = document.getElementById('subjectFilterInput');
      const noMatchMsg = document.getElementById('noSubjectMatchMsg');

      function updateCardState(card) {
        const checkbox = card.querySelector('input[type="checkbox"]');
        if (checkbox && checkbox.checked) {
          card.classList.add('is-selected');
        } else {
          card.classList.remove('is-selected');
        }
      }

      function updateCounter() {
        const checkedCount = document.querySelectorAll('.subject-checkbox:checked').length;
        const totalCount = cards.length;
        if (countBadge) {
          countBadge.innerText = `${checkedCount} of ${totalCount} Selected`;
          if (checkedCount > 0) {
            countBadge.className = 'badge badge-soft-primary';
          } else {
            countBadge.className = 'badge badge-soft-secondary';
          }
        }
      }

      // Initial state synchronization
      cards.forEach(card => {
        updateCardState(card);
        const checkbox = card.querySelector('input[type="checkbox"]');
        if (checkbox) {
          checkbox.addEventListener('change', function () {
            updateCardState(card);
            updateCounter();
          });
        }
      });
      updateCounter();

      // Select All Button
      if (selectAllBtn) {
        selectAllBtn.addEventListener('click', function () {
          cards.forEach(card => {
            if (card.style.display !== 'none') {
              const cb = card.querySelector('input[type="checkbox"]');
              if (cb) {
                cb.checked = true;
                updateCardState(card);
              }
            }
          });
          updateCounter();
        });
      }

      // Clear All Button
      if (clearAllBtn) {
        clearAllBtn.addEventListener('click', function () {
          cards.forEach(card => {
            const cb = card.querySelector('input[type="checkbox"]');
            if (cb) {
              cb.checked = false;
              updateCardState(card);
            }
          });
          updateCounter();
        });
      }

      // Live Filter Search
      if (searchInput) {
        searchInput.addEventListener('input', function () {
          const query = this.value.trim().toLowerCase();
          let visibleCount = 0;

          cards.forEach(card => {
            const name = card.getAttribute('data-subject-name') || '';
            const code = card.getAttribute('data-subject-code') || '';
            if (!query || name.includes(query) || code.includes(query)) {
              card.style.display = 'flex';
              visibleCount++;
            } else {
              card.style.display = 'none';
            }
          });

          if (noMatchMsg) {
            noMatchMsg.style.display = (visibleCount === 0 && cards.length > 0) ? 'block' : 'none';
          }
        });
      }
    });
  </script>
</body>
</html>
