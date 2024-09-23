@extends('employeeDashboard.employeeView.masterpage')

@section('content')
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
                            <a href="{{ route('notifications.read', $notification->id) }}" class="btn btn-sm btn-outline-primary">Mark as Read</a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
