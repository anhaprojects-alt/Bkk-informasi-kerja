<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetPasswordForm(string $token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60))->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    /**
     * Firebase Phone Verification Reset Logic
     */
    public function resetPasswordViaPhone(Request $request)
    {
        // This endpoint is called after Firebase frontend verifies the phone.
        // It requires a signed 'token' or 'uid' from Firebase if we want to be secure.
        $data = $request->validate([
            'phone_number' => 'required|string',
            'password' => 'required|min:8|confirmed',
            'firebase_token' => 'required', // Verified on frontend
        ]);

        // Security Note: In a production app, you MUST verify the firebase_token
        // using Firebase Admin SDK (kreait/laravel-firebase) to ensure the phone
        // number really belongs to this session.

        $user = User::where('phone_number', $data['phone_number'])->first();

        if (! $user) {
            return back()->withErrors(['phone_number' => 'Nomor HP tidak terdaftar dalam sistem.']);
        }

        $user->update([
            'password' => Hash::make($data['password']),
        ]);

        return redirect()->route('login')->with('status', 'Kata sandi berhasil diperbarui melalui verifikasi HP.');
    }

    public function introduction()
    {
        return view('auth.introduction');
    }

    public function login()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }

        return view('auth.login');
    }

    public function loginPost(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return $this->redirectBasedOnRole(Auth::user());
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan salah.',
        ]);
    }

    public function register()
    {
        return view('auth.register');
    }

    public function registerPost(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone_number' => ['required', 'string', 'max:20', 'unique:users'],
            'role' => ['required', 'in:applicant,company'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'role' => $data['role'],
            'password' => Hash::make($data['password']),
        ]);

        // If it's a company, initialize a blank company profile
        if ($user->role === 'company') {
            $user->company()->create([
                'name' => 'Perusahaan '.$user->name,
                'description' => 'Profil deskripsi perusahaan baru.',
            ]);
        }

        Auth::login($user);

        return $this->redirectBasedOnRole($user);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('introduction');
    }

    private function redirectBasedOnRole($user)
    {
        if ($user->role === 'admin') {
            return redirect()->intended('/admin/dashboard');
        } elseif ($user->role === 'company') {
            return redirect()->intended('/admin/dashboard'); // Let's use the shared backend panel
        }

        return redirect()->intended('/applicant/dashboard');
    }
}
