<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class OtpPasswordResetController extends Controller
{
    /**
     * Send 6-digit OTP to user's registered email address.
     */
    public function sendOtp(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $email = strtolower(trim($request->email));

        // Locate account in User, Employee, or Student tables
        $user = User::where('email', $email)->first();
        $accountType = 'user';

        if (!$user) {
            $user = Employee::where('email', $email)->first();
            $accountType = 'employee';
        }

        if (!$user) {
            $user = Student::where('email', $email)->first();
            $accountType = 'student';
        }

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'No account found with this email address. Please check and try again.',
            ], 404);
        }

        // Generate a cryptographically secure 6-digit OTP
        $otp = sprintf('%06d', random_int(100000, 999999));
        $cacheKey = 'otp_reset_' . sha1($email);

        // Store OTP in cache for 10 minutes
        Cache::put($cacheKey, [
            'otp' => $otp,
            'email' => $email,
            'account_type' => $accountType,
            'user_id' => $user->id,
            'attempts' => 0,
            'created_at' => now(),
        ], now()->addMinutes(10));

        // Try to send email
        $mailSent = false;
        try {
            $appName = config('app.name', 'EduSuite School ERP');
            $subject = "Your Password Reset OTP - {$appName}";
            $messageBody = "Hello {$user->name},\n\n"
                . "Your 6-digit verification OTP for password reset is: {$otp}\n\n"
                . "This code is valid for 10 minutes. If you did not request a password reset, please ignore this email.\n\n"
                . "Regards,\n{$appName} Security Team";

            Mail::raw($messageBody, function ($message) use ($email, $subject) {
                $message->to($email)
                        ->subject($subject);
            });
            $mailSent = true;
        } catch (\Throwable $e) {
            Log::warning('OTP Email sending failed: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'A 6-digit OTP has been dispatched to ' . $email . '. Please check your inbox.',
            'mail_sent' => $mailSent,
            'expires_in' => 600, // 10 minutes in seconds
            'demo_otp' => config('app.debug', true) ? $otp : null, // Display in debug/local for convenience
        ]);
    }

    /**
     * Verify the 6-digit OTP entered by the user.
     */
    public function verifyOtp(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'otp' => ['required', 'string', 'size:6'],
        ]);

        $email = strtolower(trim($request->email));
        $cacheKey = 'otp_reset_' . sha1($email);
        $cachedData = Cache::get($cacheKey);

        if (!$cachedData) {
            return response()->json([
                'success' => false,
                'message' => 'The OTP code has expired or is invalid. Please request a new OTP.',
            ], 422);
        }

        // Check max attempts
        if (($cachedData['attempts'] ?? 0) >= 5) {
            Cache::forget($cacheKey);
            return response()->json([
                'success' => false,
                'message' => 'Too many failed verification attempts. Please request a new OTP.',
            ], 429);
        }

        if (trim($cachedData['otp']) !== trim($request->otp)) {
            $cachedData['attempts'] = ($cachedData['attempts'] ?? 0) + 1;
            Cache::put($cacheKey, $cachedData, now()->addMinutes(10));

            $remaining = 5 - $cachedData['attempts'];
            return response()->json([
                'success' => false,
                'message' => "Invalid OTP code entered. ({$remaining} attempts remaining)",
            ], 422);
        }

        // Generate temporary reset verification token valid for 15 minutes
        $resetToken = Str::random(60);
        $tokenKey = 'otp_verified_' . sha1($email);

        Cache::put($tokenKey, [
            'token' => $resetToken,
            'email' => $email,
            'account_type' => $cachedData['account_type'],
            'user_id' => $cachedData['user_id'],
        ], now()->addMinutes(15));

        // Remove OTP code so it cannot be reused
        Cache::forget($cacheKey);

        return response()->json([
            'success' => true,
            'message' => 'OTP verified successfully! Please set your new password.',
            'reset_token' => $resetToken,
        ]);
    }

    /**
     * Reset password using the verified reset token.
     */
    public function resetPassword(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'reset_token' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $email = strtolower(trim($request->email));
        $tokenKey = 'otp_verified_' . sha1($email);
        $verifiedData = Cache::get($tokenKey);

        if (!$verifiedData || $verifiedData['token'] !== $request->reset_token) {
            return response()->json([
                'success' => false,
                'message' => 'Your reset session has expired or is invalid. Please start over.',
            ], 422);
        }

        $accountType = $verifiedData['account_type'];
        $userId = $verifiedData['user_id'];
        $updated = false;

        if ($accountType === 'user') {
            $user = User::find($userId);
            if ($user) {
                $user->password = Hash::make($request->password);
                $user->setRememberToken(Str::random(60));
                $user->save();
                $updated = true;
            }
        } elseif ($accountType === 'employee') {
            $employee = Employee::find($userId);
            if ($employee) {
                $employee->password = Hash::make($request->password);
                $employee->save();
                $updated = true;
            }
        } elseif ($accountType === 'student') {
            $student = Student::find($userId);
            if ($student) {
                $student->password = Hash::make($request->password);
                $student->save();
                $updated = true;
            }
        }

        if (!$updated) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update account password. Please try again.',
            ], 500);
        }

        // Clean up reset token
        Cache::forget($tokenKey);

        return response()->json([
            'success' => true,
            'message' => 'Your password has been successfully reset! You can now log in with your new password.',
        ]);
    }
}
