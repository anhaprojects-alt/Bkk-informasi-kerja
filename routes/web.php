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

// Password Reset Routes (Standard Laravel Logic)
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Firebase Phone Reset Endpoint
Route::post('/phone-reset-password', [AuthController::class, 'resetPasswordViaPhone'])->name('password.phone.reset');

Route::middleware('auth')->group(function () {
    // Applicant Smart Dashboard & Job Feed
    Route::get('/applicant/dashboard', [JobController::class, 'dashboard'])->name('applicant.dashboard');
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
