<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.employee-login');
    }

    public function login(Request $request)
    {

        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);
        $teacher = Employee::where('email', $credentials['email'])->where('designation_id', '1')->first();
        if (! $teacher) {
            return redirect()->back()->withErrors(['error' => 'only Teacher can login']);
        }

        $employee = Employee::where('email', $credentials['email'])
            ->where('password', $credentials['password'])
            ->first();
        if ($employee) {
            Auth::guard('employee')->login($employee);

            return redirect()->intended('/employee/dashboard');
        }

        return redirect()->back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('employee')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('employee.login')->with('success', 'You have been logged out.');
    }
}
