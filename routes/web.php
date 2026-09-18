<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/intro')->name('home');

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

Route::middleware('auth')->group(function () {
    // Applicant Job Feed
    Route::get('/applicant/jobs', [JobController::class, 'index'])->name('jobs.index');
    Route::get('/applicant/jobs/{jobListing}', [JobController::class, 'show'])->name('jobs.show');
    Route::post('/applicant/jobs/{jobListing}/apply', [JobController::class, 'apply'])->name('jobs.apply');
    Route::get('/applicant/applications', [JobController::class, 'myApplications'])->name('applications.mine');

    // Backend Dashboard for Admin & Perusahaan
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/admin/jobs/create', [DashboardController::class, 'createJob'])->name('jobs.create');
    Route::post('/admin/jobs', [DashboardController::class, 'storeJob'])->name('jobs.store');
    Route::patch('/admin/jobs/{jobListing}/close', [DashboardController::class, 'closeJob'])->name('jobs.close');
});
