<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            margin-top: 20px;
        }
        .bg-light-gray {
            background-color: #f7f7f7;
        }
        .table-bordered thead td, .table-bordered thead th {
            border-bottom-width: 2px;
        }
        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }
        .table-bordered td, .table-bordered th {
            border: 1px solid #dee2e6;
        }
        .bg-yellow.box-shadow {
            box-shadow: 0px 5px 0px 0px #dcbf02;
        }
        .padding-15px-lr {
            padding-left: 15px;
            padding-right: 15px;
        }
        .padding-5px-tb {
            padding-top: 5px;
            padding-bottom: 5px;
        }
        .margin-10px-bottom {
            margin-bottom: 10px;
        }
        .border-radius-5 {
            border-radius: 5px;
        }
        .margin-10px-top {
            margin-top: 10px;
        }
        .font-size14 {
            font-size: 14px;
        }
        .text-light-gray {
            color: #d6d5d5;
        }
        .font-size13 {
            font-size: 13px;
        }
        .table-bordered td, .table-bordered th {
            border: 1px solid #dee2e6;
        }
        .table td, .table th {
            padding: .75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }
    </style>
</head>
<body>
    @include('StudentDashboard.ViewFile.head')
    <div class="container-scroller">
        @include('StudentDashboard.ViewFile.nav')
        <div class="container-fluid page-body-wrapper">
            @include('StudentDashboard.ViewFile.sidebar')
            <div class="container mt-4">
                <h1 class="mb-4">Your Notifications</h1>
            
                @if($notifications->isEmpty())
                    <div class="alert alert-info" role="alert">
                        No notifications available.
                    </div>
                @else
                    <div class="list-group">
                        @foreach($notifications as $notification)
                            <div class="list-group-item d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">{{ $notification->data['title'] }}</h6>
                                    <p class="mb-1">{{ $notification->data['message'] }}</p>
                                    <small class="text-muted">Received: {{ $notification->created_at->diffForHumans() }}</small>
                                </div>
                                <div>
                                    @if($notification->read_at)
                                        <span class="badge badge-success">Viewed</span>
                                    @else
                                        <a href="{{ route('student.notifications.read', $notification->id) }}" class="btn btn-sm btn-outline-primary">Mark as Read</a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
    @include('StudentDashboard.ViewFile.script')
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
