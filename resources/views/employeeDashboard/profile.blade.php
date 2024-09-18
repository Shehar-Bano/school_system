@extends('employeeDashboard.employeeView.masterpage')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            background-color: #f8f9fa;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .profile-image {
            text-align: center;
            margin-bottom: 20px;
        }

        .profile-image img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .profile-info {
            padding-left: 20px;
        }

        .profile-info h2 {
            font-size: 1.8em;
            color: #343a40;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .profile-info p {
            font-size: 1.2em;
            color: #495057;
            margin-bottom: 12px;
        }

        .profile-info p strong {
            color: #007bff;
        }
    </style>
</head>
<body>
   
            <div class="container mt-4">
                <div class="main-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-column align-items-center text-center">
                                        <div class="profile-image">
                                            <img src="{{ asset('storage/' . $employee->image) }}" alt="Profile Picture">
                                        </div>
                                        <div class="mt-3">
                                            <h4>{{ $employee->name }}</h4>
                                           
                                            <p class="text-muted font-size-sm">{{ $employee->address ? $employee->address : 'Address not available' }}</p>

                                        </div>
                                    </div>
                                    <hr class="my-4">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0">Joining Date</h6>
                                            <span class="text-secondary">{{ $employee->joining_date }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0">Email</h6>
                                            <span class="text-secondary">{{ $employee->email }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0">Phone</h6>
                                            <span class="text-secondary">{{ $employee->phone }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="d-flex align-items-center mb-3">Additional Information</h5>
                                   
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Salary</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" class="form-control" value="{{ number_format($employee->salary )}} Rs/-" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Religion</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" class="form-control" value="{{ $employee->religion }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Gender</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" class="form-control" value="{{ $employee->gender }}" readonly>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="d-flex align-items-center mb-3">Extra Additional Information</h5>
                                        
                                            <div class="row mb-3">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Date Of Birth</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    <input type="text" class="form-control" value="{{ $employee->date_of_birth }}" readonly>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Status</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    <span class="badge p-3 rounded-pill 
                                                    @switch($employee->status)
                                                        @case('active')
                                                            bg-success text-white
                                                            @break
                                                        @case('inactive')
                                                            bg-danger text-white
                                                            @break
                                                        
                                                            @break
                                                        @default
                                                            bg-secondary text-white
                                                    @endswitch">
                                                    {{ $employee->status }}
                                                </span>
                                                    </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

@endsection