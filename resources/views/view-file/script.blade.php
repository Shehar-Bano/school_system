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

<!-- Modern ERP Dashboard Charts Initialization -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Financial Performance Bar / Line Chart
    const revenueCanvas = document.getElementById('revenue-chart');
    if (revenueCanvas) {
        const ctxRev = revenueCanvas.getContext('2d');
        const income = {{ isset($income) ? (int)$income : 0 }};
        const expenses = {{ isset($expence) ? (int)$expence : 0 }};
        const salaries = {{ isset($totalSalary) ? (int)$totalSalary : 0 }};
        const netSurplus = Math.max(0, income - (expenses + salaries));

        new Chart(ctxRev, {
            type: 'bar',
            data: {
                labels: ['Fee Inflow', 'Staff Salaries', 'Operating Expenses', 'Net Balance'],
                datasets: [{
                    label: 'Amount (PKR)',
                    data: [income, salaries, expenses, netSurplus],
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.85)', // Emerald
                        'rgba(79, 70, 229, 0.85)',  // Indigo
                        'rgba(239, 68, 68, 0.85)',   // Rose
                        'rgba(245, 158, 11, 0.85)'   // Amber
                    ],
                    borderColor: [
                        '#10b981',
                        '#4f46e5',
                        '#ef4444',
                        '#f59e0b'
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
                        cornerRadius: 6,
                        callbacks: {
                            label: function(context) {
                                return ' Rs. ' + Number(context.raw).toLocaleString();
                            }
                        }
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
                            color: '#64748b',
                            font: { size: 10.5, family: 'Plus Jakarta Sans' },
                            callback: function(val) {
                                return val >= 1000 ? (val / 1000) + 'k' : val;
                            }
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
        const presentCount = {{ (isset($studentAttendance) && is_iterable($studentAttendance)) ? $studentAttendance->sum('present') : 0 }};
        const absentCount = {{ (isset($studentAttendance) && is_iterable($studentAttendance)) ? $studentAttendance->sum('absent') : 0 }};
        const leaveCount = {{ (isset($studentAttendance) && is_iterable($studentAttendance)) ? $studentAttendance->sum('leave') : 0 }};
        const lateCount = {{ (isset($studentAttendance) && is_iterable($studentAttendance)) ? $studentAttendance->sum('late') : 0 }};

        new Chart(ctxAtt, {
            type: 'doughnut',
            data: {
                labels: ['Present', 'Absent', 'Leave', 'Late'],
                datasets: [{
                    data: [
                        presentCount || 1,
                        absentCount || 0,
                        leaveCount || 0,
                        lateCount || 0
                    ],
                    backgroundColor: [
                        '#10b981', // Emerald
                        '#ef4444', // Rose
                        '#f59e0b', // Amber
                        '#8b5cf6'  // Purple
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

// Universal Delete Confirmation Helper
function confirmGlobalDelete(formId, itemName = 'Record') {
    Swal.fire({
        title: `Delete ${itemName}?`,
        text: `Are you sure you want to delete this ${itemName.toLowerCase()}? This action cannot be undone.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Yes, Delete',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById(formId);
            if (form) {
                form.submit();
            }
        }
    });
}
</script>
