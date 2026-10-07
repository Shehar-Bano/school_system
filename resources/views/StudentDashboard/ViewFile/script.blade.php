<!-- Core Vendor Bundle -->
<script src="{{ asset('assesst/vendors/js/vendor.bundle.base.js') }}"></script>

<!-- Vendor Plugins -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

<!-- Template Scripts -->
<script src="{{ asset('assesst/js/off-canvas.js') }}"></script>
<script src="{{ asset('assesst/js/hoverable-collapse.js') }}"></script>
<script src="{{ asset('assesst/js/template.js') }}"></script>

<!-- Optional Export Libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.10/clipboard.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>

<!-- Student Dashboard Charts Initialization -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Academic & Attendance Activity Bar Chart
    const academicCanvas = document.getElementById('student-academic-chart');
    if (academicCanvas) {
        const ctxAcad = academicCanvas.getContext('2d');
        const presentCount = {{ (int)($totalPresent ?? 0) }};
        const absentCount = {{ (int)($totalAbsent ?? 0) }};
        const leaveCount = {{ (int)($totalLeave ?? 0) }};
        const submittedAssign = {{ (int)($submittedAssignmentsCount ?? 0) }};
        const pendingAssign = {{ (int)($pendingAssignmentsCount ?? 0) }};

        new Chart(ctxAcad, {
            type: 'bar',
            data: {
                labels: ['Present Days', 'Submitted Tasks', 'Pending Tasks', 'Leaves', 'Absent Days'],
                datasets: [{
                    label: 'Count',
                    data: [presentCount, submittedAssign, pendingAssign, leaveCount, absentCount],
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.85)', // Emerald
                        'rgba(79, 70, 229, 0.85)',  // Indigo
                        'rgba(245, 158, 11, 0.85)',  // Amber
                        'rgba(139, 92, 246, 0.85)',  // Purple
                        'rgba(239, 68, 68, 0.85)'    // Rose
                    ],
                    borderColor: [
                        '#10b981',
                        '#4f46e5',
                        '#f59e0b',
                        '#8b5cf6',
                        '#ef4444'
                    ],
                    borderWidth: 1,
                    borderRadius: 6,
                    barThickness: 28
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleFont: { size: 12, weight: '600', family: 'Plus Jakarta Sans' },
                        bodyFont: { size: 11, family: 'Plus Jakarta Sans' },
                        padding: 8,
                        cornerRadius: 6
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: {
                            color: '#64748b',
                            font: { size: 11, family: 'Plus Jakarta Sans', weight: '500' }
                        }
                    },
                    y: {
                        grid: { color: '#f1f5f9' },
                        ticks: {
                            stepSize: 1,
                            color: '#64748b',
                            font: { size: 10.5, family: 'Plus Jakarta Sans' }
                        }
                    }
                }
            }
        });
    }

    // 2. Attendance Doughnut Chart
    const attCanvas = document.getElementById('student-attendance-chart');
    if (attCanvas) {
        const ctxAtt = attCanvas.getContext('2d');
        const presentCount = {{ (int)($totalPresent ?? 0) }};
        const absentCount = {{ (int)($totalAbsent ?? 0) }};
        const leaveCount = {{ (int)($totalLeave ?? 0) }};

        new Chart(ctxAtt, {
            type: 'doughnut',
            data: {
                labels: ['Present', 'Absent', 'Leave'],
                datasets: [{
                    data: [
                        presentCount || (absentCount + leaveCount == 0 ? 1 : 0),
                        absentCount,
                        leaveCount
                    ],
                    backgroundColor: [
                        '#10b981', // Emerald
                        '#ef4444', // Rose
                        '#f59e0b'  // Amber
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff',
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '72%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleFont: { size: 11, weight: '600' },
                        bodyFont: { size: 11 },
                        padding: 8,
                        cornerRadius: 6
                    }
                }
            }
        });
    }

    // Global Search shortcut (Ctrl+K or Cmd+K)
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            const searchInput = document.getElementById('global-erp-search');
            if (searchInput) {
                searchInput.focus();
            }
        }
    });
});
</script>

<!-- Global ERP SweetAlert2 Notifications & Confirmations -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    @if(session('message') || session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Action Successful',
            text: "{{ session('message') ?? session('success') }}",
            confirmButtonColor: '#4f46e5',
            timer: 3500,
            timerProgressBar: true
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error Occurred',
            text: "{{ session('error') }}",
            confirmButtonColor: '#ef4444'
        });
    @endif

    @if(session('warning'))
        Swal.fire({
            icon: 'warning',
            title: 'Notice',
            text: "{{ session('warning') }}",
            confirmButtonColor: '#f59e0b'
        });
    @endif

    @if(session('status'))
        Swal.fire({
            icon: 'info',
            title: 'Status Update',
            text: "{{ session('status') }}",
            confirmButtonColor: '#4f46e5'
        });
    @endif

    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            html: '<ul style="text-align: left; font-size: 13px;">@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>',
            confirmButtonColor: '#ef4444'
        });
    @endif
});
</script>
