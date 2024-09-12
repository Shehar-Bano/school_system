<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentAuthController extends Controller
{
    public function showLoginForm() {
        return view('auth.student-login');
    }

    public function login(Request $request)
{
    $credentials = $request->validate([
        'username' => ['required'],
        'registration' => ['required'],
    ]);
    $student = Student::where('username', $credentials['username'])
                ->where('registration', $credentials['registration'])
                ->first();

    if ($student) {
        Auth::guard('student')->login($student);
        return redirect()->intended('/student/dashboard');
    }
    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ]);
}
public function logout(Request $request)
    {
        Auth::guard('student')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('student.login')->with('success', 'You have been logged out.');
    }


}
