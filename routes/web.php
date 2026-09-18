<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('introduction');
});

Route::get('/intro', [AuthController::class, 'introduction'])->name('introduction');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginPost'])->name('login.post');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerPost'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Forgot Password routes placeholders
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

Route::post('/forgot-password', function () {
    return back()->with('status', 'Link reset password telah dikirim ke email Anda.');
})->name('password.email');

// Applicant Job Feed Placeholder
Route::get('/applicant/jobs', function () {
    return "Selamat datang di Halaman Cari Lowongan Kerja BKK (Tampilan Mobile Android)!";
})->middleware('auth');

// Backend Dashboard Admin & Perusahaan
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware('auth');

