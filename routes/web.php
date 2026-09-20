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

// Public Job Exploration (LinkedIn Style)
Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{jobListing}', [JobController::class, 'show'])->name('jobs.show');

Route::middleware('auth')->group(function () {
    // Applicant Smart Dashboard
    Route::get('/applicant/dashboard', [JobController::class, 'dashboard'])->name('applicant.dashboard');
    Route::post('/applicant/jobs/{jobListing}/apply', [JobController::class, 'apply'])->name('jobs.apply');
    Route::get('/applicant/applications', [JobController::class, 'myApplications'])->name('applications.mine');

    // Backend Dashboard for Admin & Perusahaan
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // User Management (Admin Only)
    Route::get('/admin/users', [DashboardController::class, 'usersIndex'])->name('admin.users.index');
    Route::get('/admin/users/{user}/edit', [DashboardController::class, 'userEdit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [DashboardController::class, 'userUpdate'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [DashboardController::class, 'userDestroy'])->name('admin.users.destroy');

    Route::get('/admin/jobs/create', [DashboardController::class, 'createJob'])->name('jobs.create');
    Route::post('/admin/jobs', [DashboardController::class, 'storeJob'])->name('jobs.store');
    Route::get('/admin/jobs/{jobListing}/edit', [DashboardController::class, 'editJob'])->name('jobs.edit');
    Route::put('/admin/jobs/{jobListing}', [DashboardController::class, 'updateJob'])->name('jobs.update');
    Route::delete('/admin/jobs/{jobListing}', [DashboardController::class, 'destroyJob'])->name('jobs.destroy');
    Route::patch('/admin/jobs/{jobListing}/close', [DashboardController::class, 'closeJob'])->name('jobs.close');

    // Applicant Management (Company/Admin)
    Route::get('/admin/jobs/{jobListing}/applicants', [DashboardController::class, 'jobApplicants'])->name('jobs.applicants');
    Route::patch('/admin/applicants/{applicant}/status', [DashboardController::class, 'updateApplicantStatus'])->name('applicants.status.update');

    // Profile Settings (Universal)
    Route::get('/settings/profile', [DashboardController::class, 'profile'])->name('settings.profile');
    Route::put('/settings/profile', [DashboardController::class, 'profileUpdate'])->name('settings.profile.update');

    Route::get('/help-center', [DashboardController::class, 'helpCenter'])->name('help.center');
    Route::get('/messages', [DashboardController::class, 'messagesIndex'])->name('messages.index');
    Route::get('/messages/{user}', [DashboardController::class, 'messagesIndex'])->name('messages.show');
    Route::post('/messages/{user}', [DashboardController::class, 'messagesStore'])->name('messages.store');
});
