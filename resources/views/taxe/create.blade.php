<!DOCTYPE html>
<html lang="en">

@include('view-file/head')

<body>
  <div class="container-scroller">
    @include('view-file/nav')
    <div class="container-fluid page-body-wrapper">
      @include('view-file.side-bar')

      <div class="container mt-5">
        <div class="row justify-content-center">
          <div class="col-md-8">
            <div class="card">
              <div class="card-header">
                <h4>Add Tax Information</h4>
              </div>
              <div class="card-body">

                @if(session('success'))
                  <div class="alert alert-success">
                      {{ session('success') }}
                  </div>
                @endif

                <form action="{{ route('taxes.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="bus_taxes">Bus Taxes:</label>
                        <input type="text" class="form-control" id="bus_taxes" name="bus_taxes" required>
                    </div>
                    <div class="form-group">
                        <label for="admission_fee">Admission Fee:</label>
                        <input type="text" class="form-control" id="admission_fee" name="admission_fee" required>
                    </div>
                    <div class="form-group">
                        <label for="other_activity">Other Activity:</label>
                        <input type="text" class="form-control" id="other_activity" name="other_activity" required>
                    </div>
                    <div class="form-group">
                        <label for="lunch">Lunch:</label>
                        <input type="text" class="form-control" id="lunch" name="lunch" required>
                    </div>
                    <div class="form-group">
                        <label for="library_tax">Library Tax:</label>
                        <input type="text" class="form-control" id="library_tax" name="library_tax" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
  @include('view-file.script')
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
