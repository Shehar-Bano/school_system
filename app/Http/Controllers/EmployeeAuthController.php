<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.employee-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $loginHandle = trim($credentials['email']);
        $rawPassword = $credentials['password'];

        // Find employee by email or phone
        $employee = Employee::where('email', $loginHandle)
            ->orWhere('phone', $loginHandle)
            ->first();

        if ($employee) {
            $isPasswordValid = false;

            // 1. Check hashed password
            if (!empty($employee->password) && Hash::check($rawPassword, $employee->password)) {
                $isPasswordValid = true;
            }
            // 2. Legacy plaintext password fallback
            elseif ($employee->password === $rawPassword) {
                $isPasswordValid = true;
                $employee->password = Hash::make($rawPassword);
                $employee->save();
            }
            // 3. Fallback: if employee password was empty or default 'password'
            elseif ((empty($employee->password) || $employee->password === 'password') && ($rawPassword === 'password' || $rawPassword === $employee->phone)) {
                $isPasswordValid = true;
                $employee->password = Hash::make($rawPassword);
                $employee->save();
            }

            if ($isPasswordValid) {
                Auth::guard('employee')->login($employee, $request->boolean('remember'));
                $request->session()->regenerate();

                return redirect()->intended('/employee/dashboard');
            }
        }

        return redirect()->back()->withInput($request->only('email'))->withErrors([
            'email' => 'The provided credentials do not match our employee records.',
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
