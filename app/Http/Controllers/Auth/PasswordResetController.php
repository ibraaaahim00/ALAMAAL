<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\PasswordResetOtp;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class PasswordResetController extends Controller
{
    public function showForgot(): View
    {
        return view('auth.forgot-password');
    }

    public function sendOtp(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.required' => 'حقل البريد الإلكتروني مطلوب.',
            'email.exists' => 'البريد الإلكتروني المدخل غير مسجل لدينا.',
        ]);

        $email = strtolower(trim($request->email));

        // Generate 4-digit numeric OTP code
        $otp = (string) random_int(1000, 9999);

        // Save OTP
        PasswordResetOtp::where('email', $email)->delete();
        PasswordResetOtp::create([
            'email' => $email,
            'otp_code' => Hash::make($otp),
            'expires_at' => now()->addMinutes(15),
        ]);

        // For local development & demo convenience, also save plain OTP in session to allow easy testing if mail is simulated
        session([
            'reset_email' => $email,
            'demo_otp' => $otp,
        ]);

        return redirect()->route('password.otp')->with('success', "تم إرسال رمز التحقق إلى بريدك الإلكتروني. (كود التجربة: {$otp})");
    }

    public function showVerifyOtp(): View
    {
        $email = session('reset_email');
        if (!$email) {
            return view('auth.forgot-password');
        }

        return view('auth.verify-otp', compact('email'));
    }

    public function verifyOtp(Request $request): RedirectResponse
    {
        $email = session('reset_email') ?? $request->input('email');

        // Combined 4 inputs if sent as array, or single string
        $otpCode = $request->input('otp');
        if (is_array($otpCode)) {
            $otpCode = implode('', $otpCode);
        }

        $record = PasswordResetOtp::where('email', $email)->latest()->first();

        if (!$record || $record->isExpired()) {
            return back()->withErrors(['otp' => 'انتهت صلاحية رمز التحقق، يرجى طلب رمز جديد.']);
        }

        if (!Hash::check($otpCode, $record->otp_code)) {
            return back()->withErrors(['otp' => 'رمز التحقق غير صحيح.']);
        }

        session(['otp_verified' => true, 'verified_email' => $email]);

        return redirect()->route('password.reset.form');
    }

    public function resendOtp(Request $request): RedirectResponse
    {
        $email = session('reset_email');
        if (!$email) {
            return redirect()->route('password.request');
        }

        $otp = (string) random_int(1000, 9999);

        PasswordResetOtp::where('email', $email)->delete();
        PasswordResetOtp::create([
            'email' => $email,
            'otp_code' => Hash::make($otp),
            'expires_at' => now()->addMinutes(15),
        ]);

        session(['demo_otp' => $otp]);

        return back()->with('success', "تمت إعادة إرسال رمز التحقق بنجاح. (كود التجربة: {$otp})");
    }

    public function showResetPassword(): View
    {
        $email = session('verified_email') ?? session('reset_email');

        return view('auth.reset-password', compact('email'));
    }

    public function resetPassword(ResetPasswordRequest $request): RedirectResponse
    {
        $user = User::where('email', $request->email)->firstOrFail();
        $user->password = Hash::make($request->password);
        $user->save();

        PasswordResetOtp::where('email', $request->email)->delete();
        session()->forget(['reset_email', 'verified_email', 'otp_verified', 'demo_otp']);

        return redirect()->route('login')->with('success', 'تم إعادة تعيين كلمة المرور بنجاح! يمكنك الآن تسجيل الدخول.');
    }
}
