<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.student-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $loginHandle = trim($credentials['username']);
        $rawPassword = $credentials['password'];

        // Find student by username, registration no, or email
        $student = Student::where('username', $loginHandle)
            ->orWhere('registration', $loginHandle)
            ->orWhere('email', $loginHandle)
            ->first();

        if ($student) {
            $isPasswordValid = false;

            // 1. Check if hashed password matches
            if (!empty($student->password) && Hash::check($rawPassword, $student->password)) {
                $isPasswordValid = true;
            }
            // 2. Legacy plaintext password fallback
            elseif ($student->password === $rawPassword) {
                $isPasswordValid = true;
                $student->password = Hash::make($rawPassword);
                $student->save();
            }
            // 3. Fallback: if student password was empty or registration no was used as default password
            elseif ((empty($student->password) || $student->password === '123456') && ($rawPassword === $student->registration || $rawPassword === '123456')) {
                $isPasswordValid = true;
                $student->password = Hash::make($rawPassword);
                $student->save();
            }

            if ($isPasswordValid) {
                Auth::guard('student')->login($student, $request->boolean('remember'));
                $request->session()->regenerate();

                return redirect()->intended('/student/dashboard');
            }
        }

        return back()->withInput($request->only('username'))->withErrors([
            'username' => 'Invalid student login credentials. Please check your username and password.',
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
