<!DOCTYPE html>
<html lang="en">

@include('view-file/head')

<body>
  <div class="container-scroller">
    @include('view-file/nav')

    <div class="container-fluid page-body-wrapper">
      @include('view-file/side-bar')

      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row justify-content-center">
            <div class="col-md-8">

              <!-- Notification Card -->
              <div class="card shadow-sm mt-5">
                <div class="card-header bg-primary text-white">
                  <h4 class="mb-0">Send Notification</h4>
                </div>

                <div class="card-body">
                  <!-- Notification Form -->
                  <form action="{{ route('admin.sendNotification') }}" method="POST">
                    @csrf

                    <!-- Title Field -->
                    <div class="form-group">
                      <label for="title">Title</label>
                      <input type="text" name="title" class="form-control" placeholder="Enter notification title" required>
                    </div>

                    <!-- Message Field -->
                    <div class="form-group">
                      <label for="message">Message</label>
                      <textarea name="message" class="form-control" rows="5" placeholder="Enter your message" required></textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center">
                      <button type="submit" class="btn btn-primary btn-lg mt-3">Send Notification</button>
                    </div>
                  </form>
                </div>
              </div>
              <!-- End of Notification Card -->

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @include('view-file/script')

  <style>
    /* Style to make the form look more appealing */
    .card {
      border-radius: 15px;
      border: 0;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .card-header {
      border-top-left-radius: 15px;
      border-top-right-radius: 15px;
    }

    .form-control {
      padding: 10px;
      font-size: 1rem;
      border-radius: 8px;
    }

    .btn-primary {
      padding: 10px 30px;
      font-size: 1.2rem;
    }
  </style>

</body>

</html>
