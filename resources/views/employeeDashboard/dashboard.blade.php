@extends('employeeDashboard.employeeView.masterpage')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-md-12 grid-margin">
          <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
              <h3 class="font-weight-bold">Welcome {{ Auth::guard('employee')->user()->name }}!</h3>
              <h6 class="font-weight-normal mb-0"> To you'r Teacher Portal </h6>
            </div>
            <div class="col-12 col-xl-4">
             <div class="justify-content-end d-flex">
              <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                 <i class="mdi mdi-calendar"></i> Today ({{ date('l, F j, Y') }})
                </button>
              </div>
             </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
          <div class="card tale-bg">
            <div class="card-people mt-auto">
              <img src="{{asset('assesst/images/dashboard/8202589.jpg')}}" alt="people">
              <div class="weather-info">
                <div class="d-flex">
                  {{-- <div>
                    <h2 class="mb-0 font-weight-normal"><i class="icon-sun mr-2"></i>31<sup>C</sup></h2>
                  </div> --}}
                  <div class="ml-2 mt-2">
                    <h4 class="location font-weight-normal">It's School Time</h4>
                    <h6 class="font-weight-normal">Let's go</h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 grid-margin transparent mt-3">
          <div class="row">
            <div class="col-md-6 mb-4 stretch-card transparent">
              <div class="card card-tale">
                <div class="card-body">
                  <p class="mb-4">Current Month Attendence</p>
                  <p class="fs-30 mb-2">Presence:  {{ $totalPresent }}</p>
                
                </div>
              </div>
            </div>
            <div class="col-md-6 mb-4 stretch-card transparent">
              <div class="card card-dark-blue">
                <div class="card-body">
                  <p class="mb-4">Current Month Attendence</p>
                  <p class="fs-30 mb-2">Absence: {{ $totalAbsent }}</p>
                 
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
              <div class="card card-light-blue">
                <div class="card-body">
                  <p class="mb-4">Current Month Attendence</p>
                  <p class="fs-30 mb-2">Leave's : {{ $totalLeave }}</p>
                </div>
              </div>
            </div>
            <div class="col-md-6 stretch-card transparent">
              <div class="card card-light-danger">
                <div class="card-body">
                  <p class="mb-4">Current Year Attendence</p>
                  <p style="font-size: 22px" class=" mb-2">Overall attendance: {{ number_format($attendancePercentage, 2) }}%</p>
                
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>



  
@endsection