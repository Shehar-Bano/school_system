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

      <!-- Inner-page -->
      <div class="main-panel">
        <div class="content-wrapper">

<div class="mb-3 row">
  <div class="col-12 my-3 ">
    <div class="card">
        <div class="card-body">
            <div class="header">
                <h4><i class="fas fa-wallet"></i> Expence</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('inventory.expences')}}">Inventory</a></li>
                        <li class="breadcrumb-item"><a href="{{route('inventory.expences')}}">Expences</a></li>
                        <li class="breadcrumb-item active" aria-current="page" style="color: rgb(180, 176, 176)">Add Expence</li>
                    </ol>
                </nav>
            </div>
          <h4 class="card-title mt-5">Add Expense</h4>
          <div class="form-container">
            <form action="{{ route('inventory.expences.store') }}" method="POST">
              @csrf
  
              <div class="form-group">
                <label for="category_id">Category</label>
                <select name="category_id" id="category_id" class="form-control {{ $errors->has('category_id') ? 'is-invalid' : '' }}">
                  <option value="">Select a Category</option>
                  @foreach ($categories as $category)
                  @if ($category->status=='active')
                  <option value="{{ $category->id }}">{{ $category->name }}</option>
                  @endif
                  @endforeach
                </select>
                @error('category_id')
                  <div class="invalid-feedback">{{ 'Category is required' }}</div>
                @enderror
              </div>

              <div class="form-group">
                <label for="sub_category_id"> Subcategory</label>
                <select name="sub_category_id" id="sub_category_id" class="form-control {{ $errors->has('sub_category_id') ? 'is-invalid' : '' }}">
                  <option value="">Select a Subcategory</option>
                </select>
                @error('sub_category_id')
                  <div class="invalid-feedback">{{ 'Subcategory is required' }}</div>
                @enderror
              </div>

              <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" name="amount" id="amount" class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}">
                @error('amount')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group">
                <label for="description">Description</label>
                <input type="text" name="description" id="description" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}">
                @error('description')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group">
                <label for="date">Date</label>
                <input type="date" class="form-control {{ $errors->has('date') ? 'is-invalid' : '' }}" id="date" name="date" value="{{ old('date',Carbon::now()->format('Y-m-d')) }}">
                @error('date')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <button type="submit" class="btn btn-primary">Save</button>
            </form>
          </div>
        </div>
      </div>
  </div>
</div>

    </div>
  </div>

  @include('view-file/script')

<!-- jQuery Script for Category/Subcategory -->
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
      $('#sub_category_id').append('<option value="">Select a Subcategory</option>');
      filteredSubCategories.forEach(function(subCategory) {
        $('#sub_category_id').append('<option value="' + subCategory.id + '">' + subCategory.name + '</option>');
      });
    });
  });
</script>

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

@if(session('success'))
<script>
  Swal.fire({
    title: 'Success!',
    text: "{{ session('success') }}",
    icon: 'success',
    confirmButtonText: 'OK'
  });
</script>
@endif

</body>
</html>
