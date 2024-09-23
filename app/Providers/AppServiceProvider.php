<?php
namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
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
    }
}
