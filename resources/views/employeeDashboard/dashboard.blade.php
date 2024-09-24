@extends('employeeDashboard.employeeView.masterpage')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Welcome {{ Auth::guard('employee')->user()->name }}!</h3>
                        <h6 class="font-weight-normal mb-0">To your Teacher Portal</h6>
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
        
        <!-- Notification Section -->
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card tale-bg">
                    <div class="card-people mt-auto">
                        <img src="{{ asset('assesst/images/dashboard/8202589.jpg') }}" alt="people">
                       
                    </div>
                </div>
            </div>

            <!-- Attendance Section -->
            <div class="col-md-6 grid-margin transparent mt-3">
                <div class="row">
                    <div class="col-md-6 mb-4 stretch-card transparent">
                        <div class="card card-tale">
                            <div class="card-body">
                                <p class="mb-4">Current Month Attendance</p>
                                <p class="fs-30 mb-2">Present: {{ $totalPresent }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4 stretch-card transparent">
                        <div class="card card-dark-blue">
                            <div class="card-body">
                                <p class="mb-4">Current Month Attendance</p>
                                <p class="fs-30 mb-2">Absent: {{ $totalAbsent }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                        <div class="card card-light-blue">
                            <div class="card-body">
                                <p class="mb-4">Current Month Attendance</p>
                                <p class="fs-30 mb-2">Leaves: {{ $totalLeave }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 stretch-card transparent">
                        <div class="card card-light-danger">
                            <div class="card-body">
                                <p class="mb-4">Current Year Attendance</p>
                                <p class="h5">Overall Attendance:</p>
                                <p class="fs-30 mb-2"> {{ number_format($attendancePercentage, 2) }}%</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
            <div class="container ">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card shadow-lg">
                            <div class="card-header bg-primary text-white">
                                <h4 class="mb-0">Class Assigned</h4>
                            </div>
                            <div class="card-body">
                                @if($assignedClass)
                                    <div class="row align-items-center">
                                        <div class="col-md-3 text-center">
                                            <i class="mdi mdi-school mdi-48px text-primary"></i>
                                        </div>
                                        <div class="col-md-9">
                                            <h5 class="font-weight-bold">Assigned Class: {{ $assignedClass->classe->name }} ({{ $assignedClass->name }})
                                            </h5>
                                            <p class="text-muted mb-0">You are the class teacher for this class.</p>
                                        </div>
                                    </div>
                                @else
                                    <div class="alert alert-warning text-center" role="alert">
                                        <i class="mdi mdi-alert-circle-outline"></i> You are not assigned to any class yet.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
    

  </div>

@endsection
