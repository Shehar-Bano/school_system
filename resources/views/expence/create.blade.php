<!DOCTYPE html>
<html lang="en">
@php
  use Carbon\Carbon;
@endphp
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
                  <div class="erp-form-title-area">
                    <h3 class="erp-form-title">
                      <i class="fas fa-wallet text-primary"></i>
                      Record School Expense
                    </h3>
                    <p class="erp-form-subtitle">Add inventory purchases, operational costs, utilities or maintenance expenses</p>
                  </div>

                  <!-- Back to List Button -->
                  <div>
                    <a href="{{ route('inventory.expences') }}" class="erp-btn-back">
                      <i class="fas fa-arrow-left"></i> Back to Expenses
                    </a>
                  </div>
                </div>

                <form action="{{ route('inventory.expences.store') }}" method="POST" id="addExpenseForm">
                  @csrf
                  
                  <div class="erp-form-body">
                    <div class="row">
                      <!-- Category -->
                      <div class="col-md-6">
                        <div class="erp-form-group">
                          <label for="category_id" class="erp-form-label">Expense Category <span class="required">*</span></label>
                          <select name="category_id" id="category_id" class="form-control" required>
                            <option value="" disabled selected>-- Select Category --</option>
                            @foreach ($categories as $category)
                              @if ($category->status == 'active')
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                              @endif
                            @endforeach
                          </select>
                          @error('category_id')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <!-- Subcategory -->
                      <div class="col-md-6">
                        <div class="erp-form-group">
                          <label for="sub_category_id" class="erp-form-label">Subcategory <span class="required">*</span></label>
                          <select name="sub_category_id" id="sub_category_id" class="form-control" required>
                            <option value="" disabled selected>-- Select Subcategory --</option>
                          </select>
                          @error('sub_category_id')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <!-- Amount -->
                      <div class="col-md-6">
                        <div class="erp-form-group">
                          <label for="amount" class="erp-form-label">Expense Amount (Rs.) <span class="required">*</span></label>
                          <input type="number" name="amount" id="amount" class="form-control" placeholder="e.g. 5000" min="1" step="0.01" required>
                          @error('amount')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <!-- Date -->
                      <div class="col-md-6">
                        <div class="erp-form-group">
                          <label for="date" class="erp-form-label">Expense Date <span class="required">*</span></label>
                          <input type="date" class="form-control" id="date" name="date" value="{{ old('date', Carbon::now()->format('Y-m-d')) }}" required>
                          @error('date')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <!-- Description -->
                      <div class="col-md-12">
                        <div class="erp-form-group mb-0">
                          <label for="description" class="erp-form-label">Expense Description & Details <span class="required">*</span></label>
                          <textarea name="description" id="description" class="form-control" rows="3" placeholder="Enter vendor name, invoice reference, or item breakdown..." required>{{ old('description') }}</textarea>
                          @error('description')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Form Action Footer -->
                  <div class="erp-form-footer">
                    <a href="{{ route('inventory.expences') }}" class="btn btn-sm btn-outline-secondary">
                      Cancel
                    </a>
                    <button type="submit" class="erp-btn-submit">
                      <i class="fas fa-check"></i> Save Expense
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
  
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      var subCategories = @json($sub_categories);

      $('#category_id').on('change', function() {
        var categoryId = $(this).val();
        var filteredSubCategories = subCategories.filter(function(subCategory) {
          return subCategory.category_id == categoryId;
        });

        $('#sub_category_id').empty();
        $('#sub_category_id').append('<option value="" disabled selected>-- Select Subcategory --</option>');
        filteredSubCategories.forEach(function(subCategory) {
          $('#sub_category_id').append('<option value="' + subCategory.id + '">' + subCategory.name + '</option>');
        });
      });
    });
  </script>
</body>
</html>
