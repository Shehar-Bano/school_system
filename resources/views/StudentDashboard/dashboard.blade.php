<!DOCTYPE html>
<html>
    @include('StudentDashboard.ViewFile.head')
<body>
  <div class="container-scroller">
    @include('StudentDashboard.ViewFile.nav')
    <div class="container-fluid page-body-wrapper">
      @include('StudentDashboard.ViewFile.sidebar')
      @include('StudentDashboard.ViewFile.main')
    </div>
  </div>
  @include('StudentDashboard.ViewFile.script')
</body>
</html>
