<?php

namespace App\Providers;

use App\Repositories\EmployeeAttendanceRepository;
use App\Repositories\EmployeeAttendanceRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(){
        $this->app->bind(EmployeeAttendanceRepositoryInterface::class,EmployeeAttendanceRepository::class);
    }
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Define a view composer for employee's masterpage
        View::composer('employeeDashboard.employeeView.masterpage', function ($view) {
            $employee = Auth::guard('employee')->user();

            if ($employee) {
                $unreadNotifications = $employee->unreadNotifications;

                // Pass unread notifications data to the view
                $view->with('unreadNotifications', $unreadNotifications);
            }
        });
        // Define a view composer for student's masterpage
        View::composer('StudentDashboard.ViewFile.nav', function ($view) {
            $student = Auth::guard('student')->user();
            $unreadNotifications = collect(); // Initialize an empty collection

            // If a student is authenticated, get their unread notifications
            if ($student) {
                $unreadNotifications = $student->unreadNotifications;
                $view->with('unreadNotifications', $unreadNotifications);
            }
        });
    }
}
