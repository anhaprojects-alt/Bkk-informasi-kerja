<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
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

    public function resetPasswordViaPhone(Request $request)
    {
        $data = $request->validate([
            'phone_number' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'firebase_token' => ['required', 'string'],
        ]);

        $firebaseApiKey = config('services.firebase.api_key');

        if (blank($firebaseApiKey)) {
            return back()->withErrors(['firebase_token' => 'Verifikasi nomor HP belum dikonfigurasi di server.']);
        }

        $lookupResponse = Http::acceptJson()->post(
            'https://identitytoolkit.googleapis.com/v1/accounts:lookup?key='.$firebaseApiKey,
            ['idToken' => $data['firebase_token']]
        );

        if ($lookupResponse->failed()) {
            return back()->withErrors(['firebase_token' => 'Token Firebase tidak valid atau masa berlakunya sudah habis.']);
        }

        $firebasePhone = $lookupResponse->json('users.0.phoneNumber');

        if (! is_string($firebasePhone) || blank($firebasePhone)) {
            return back()->withErrors(['firebase_token' => 'Nomor HP pada token Firebase tidak ditemukan.']);
        }

        $normalizedFirebasePhone = $this->normalizePhoneNumber($firebasePhone);
        $normalizedRequestPhone = $this->normalizePhoneNumber($data['phone_number']);

        if ($normalizedFirebasePhone !== $normalizedRequestPhone) {
            return back()->withErrors(['phone_number' => 'Nomor HP tidak cocok dengan token verifikasi Firebase.']);
        }

        $user = User::query()
            ->whereNotNull('phone_number')
            ->get()
            ->first(fn (User $candidate) => $this->normalizePhoneNumber($candidate->phone_number) === $normalizedRequestPhone);

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

    public function login(Request $request)
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }

        if ($request->has('intended')) {
            session(['url.intended' => $request->query('intended')]);
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

    public function register(Request $request)
    {
        if ($request->has('intended')) {
            session(['url.intended' => $request->query('intended')]);
        }

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

    private function normalizePhoneNumber(string $phone): string
    {
        $digits = preg_replace('/\D+/', '', $phone) ?? '';

        if ($digits === '') {
            return '';
        }

        if (str_starts_with($digits, '62')) {
            $digits = '0'.substr($digits, 2);
        }

        return $digits;
    }

    private function redirectBasedOnRole($user)
    {
        if ($user->role === 'admin') {
            return redirect()->intended('/admin/dashboard');
        }

        if ($user->role === 'company') {
            return redirect()->intended('/admin/dashboard');
        }

        return redirect()->intended('/applicant/dashboard');
    }
}
