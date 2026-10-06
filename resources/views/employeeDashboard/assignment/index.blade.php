@extends('employeeDashboard.employeeView.masterpage')

@section('content')
<div class="main-panel">
  <div class="content-wrapper">

    <!-- ERP Card Table Container -->
    <div class="erp-card-table">
      
      <!-- Table Header Block -->
      <div class="erp-table-header-block">
        <div class="erp-table-title-area">
          <h3 class="erp-table-title">
            <i class="fas fa-clipboard-list text-primary"></i>
            My Assigned Homework & Tasks
          </h3>
          <p class="erp-table-subtitle">Manage class assignments, track student submission progress, and evaluate homework</p>
        </div>

        <div>
          <a href="{{ route('employee.assignment.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus mr-1"></i> Add New Assignment
          </a>
        </div>
      </div>

      <!-- Table Responsive -->
      <div class="table-responsive">
        <table class="erp-table">
          <thead>
            <tr>
              <th style="width: 45px;" class="text-center">#</th>
              <th style="width: 15%;" class="text-center">Deadline</th>
              <th style="width: 24%;">Assignment Title</th>
              <th style="width: 18%;">Class & Subject</th>
              <th style="width: 20%;" class="text-center">Submission Tracking</th>
              <th style="width: 130px;" class="text-center">Actions</th>
            </tr>
          </thead>
          <tbody>
            @php $count = 0; @endphp
            @forelse($assignments as $assignment)
              @php
                $stats = $assignment->getTrackingStats();
              @endphp
              <tr>
                <td class="text-center font-weight-medium text-muted">{{ ++$count }}</td>
                <td class="text-center">
                  @if($stats['is_deadline_passed'])
                    <span class="badge badge-soft-danger font-weight-medium">
                      <i class="fas fa-circle-xmark mr-1 text-xs"></i> {{ $assignment->deadline }}
                    </span>
                  @else
                    <span class="badge badge-soft-warning font-weight-medium">
                      <i class="fas fa-clock mr-1 text-xs"></i> {{ $assignment->deadline }}
                    </span>
                  @endif
                </td>
                <td>
                  <div class="font-weight-semibold text-dark">{{ $assignment->title }}</div>
                  <div class="text-muted text-xs">{{ \Illuminate\Support\Str::limit($assignment->description, 60) }}</div>
                </td>
                <td>
                  <div>
                    <span class="badge badge-soft-primary mr-1">{{ $assignment->class->name ?? 'Class' }}</span>
                    <span class="badge badge-soft-info">{{ $assignment->section->name ?? 'Section' }}</span>
                  </div>
                  <div class="text-muted small mt-1">
                    <i class="fas fa-book text-primary mr-1 text-xs"></i> {{ $assignment->subject->subject_name ?? 'Subject' }}
                  </div>
                </td>
                <td class="text-center">
                  <a href="{{ route('employee.assignment.track', ['id' => $assignment->id]) }}" class="text-decoration-none" title="Click to view student submission roster">
                    <div class="d-flex align-items-center justify-content-center gap-1 mb-1">
                      <span class="badge badge-soft-{{ $stats['percentage'] == 100 ? 'success' : ($stats['percentage'] > 0 ? 'primary' : 'secondary') }} font-weight-bold" style="font-size: 11px;">
                        {{ $stats['submitted_count'] }} / {{ $stats['total_students'] }} Submitted ({{ $stats['percentage'] }}%)
                      </span>
                    </div>
                    <div class="progress mx-auto" style="height: 4px; width: 110px;">
                      <div class="progress-bar {{ $stats['percentage'] == 100 ? 'bg-success' : 'bg-primary' }}" role="progressbar" style="width: {{ $stats['percentage'] }}%"></div>
                    </div>
                  </a>
                </td>
                <td class="text-center">
                  <a href="{{ route('employee.assignment.track', ['id' => $assignment->id]) }}" class="btn btn-xs btn-primary font-weight-semibold" style="font-size: 11px; padding: 4px 10px;">
                    <i class="fas fa-chart-line mr-1"></i> Track & Grade
                  </a>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="text-center py-4 text-muted">
                  <i class="fas fa-clipboard-list fa-2x mb-2 d-block text-muted opacity-50"></i>
                  No assignments created yet. Click <strong>"Add New Assignment"</strong> to assign homework to your students.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

    </div>

  </div>
</div>
@endsection
