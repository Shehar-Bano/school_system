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
          <div class="container">
            <!-- Add New Employee Button -->
            <div class="mb-4">
              <a href="{{ route('inventory.expences.create') }}" class="btn btn-primary">Add Expence</a>
            </div>
          <!-- Filter Inputs -->
<div class="mb-3 row">
  <div class="col-12 mt-5">
    <form action="{{ route('inventory.expences') }}" method="get">
      <div class="mb-3 row">
        <div class="col-md-3">
          <label for="start_date" class="form-label">Start Date</label>
          <input type="date" id="start_date" name="start_date" class="form-control" value="{{ request('start_date') }}">
        </div>
        <div class="col-md-3">
          <label for="end_date" class="form-label">End Date</label>
          <input type="date" id="end_date" name="end_date" class="form-control" value="{{ request('end_date') }}">
        </div>
        <div class="col-md-3">
          <label for="category_id" class="form-label">Category</label>
          <select class="form-control" id="category_id" name="category_id">
            <option value="">Select Category</option>
            @foreach ($categories as $category)
              <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3">
          <label for="sub_category_id" class="form-label">Sub-Category</label>
          <select class="form-control" id="sub_category_id" name="sub_category_id">
            <option value="">Select Sub-Category</option>
            @foreach ($sub_categories as $subCategory)
              <option value="{{ $subCategory->id }}" {{ request('sub_category_id') == $subCategory->id ? 'selected' : '' }}>
                {{ $subCategory->name }}
              </option>
            @endforeach
          </select>
        </div>

      </div>
      <button type="submit" class="btn btn-primary">Filter</button>
    </form>
  </div>

</div>
            <!-- Employees Table -->
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Expences List</h4>
                <div class="table-responsive">
                  <table class="table table-striped table-bordered text-center table-sm" id="examsTable">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Category</th>
                        <th>Sub  Category</th>
                        <th>Amount</th>
                        <th>Description</th>

                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php
                          $count = 0;
                          $totalExpence = 0;
                      @endphp
                      @foreach ($expences as $recode)
                          <tr>
                              <td>{{ ++$count }}</td>
                              <td>{{ $recode->date}}</td>
                              <td>{{ $recode->category->name }}</td>
                              <td>{{$recode->sub_category->name}}</td>
                              <td>{{ number_format($recode->amount) }} Rs/-</td>
                              <td>{{$recode->description}}</td>
                              <td>
                                <a class="btn btn-warning btn-sm" href="{{ route('inventory.expences.edit', ['id' => $recode->id]) }}" title="Edit"><i class="fas fa-edit"></i> </a>
                                <a class="btn btn-danger btn-sm" href="{{ route('inventory.expences.delete', ['id' => $recode->id]) }}" title="Delete" onclick="confirmDelete(event, '{{ route('inventory.expences.delete', ['id' => $recode->id]) }}')">
                                  <i class="fas fa-trash"></i>  </a>
                          </td>
                          </tr>
                          @php
                              $totalExpence += $recode->amount;
                          @endphp
                      @endforeach
                  </tbody>
                  <tfoot>
                    <tr>

                      <td colspan="6"><strong>Total Expenses</strong></td>
                      <td ><strong>{{ $totalExpence }} Rs/-</strong></td>

                    </tr>
                  </tfoot>

                  </table>
                  <div class="d-flex justify-content-center mt-4">
                    {{ $expences->links('pagination::simple-bootstrap-4') }}
                </div>
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
  <script>
    function confirmDelete(event, url) {
    event.preventDefault(); // Prevent the default action of the link

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url; // Redirect to the URL if confirmed
        }
    });
}

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
