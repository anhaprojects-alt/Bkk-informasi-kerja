<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Company;
use App\Models\JobListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Ensure only admin/company accounts reach the backend panel.
     */
    private function ensureStaff(): void
    {
        abort_unless(in_array(Auth::user()->role, ['admin', 'company'], true), 403);
    }

    /**
     * Base query scoped to what the current user is allowed to manage.
     */
    private function scopedJobs()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return JobListing::query();
        }

        return JobListing::where('company_id', optional($user->company)->id);
    }

    public function index()
    {
        $this->ensureStaff();

        $user = Auth::user();
        $jobIds = (clone $this->scopedJobs())->pluck('id');

        $stats = [
            'companies' => $user->role === 'admin' ? Company::count() : ($user->company ? 1 : 0),
            'openJobs' => (clone $this->scopedJobs())->where('status', 'open')->count(),
            'applicants' => Applicant::whereIn('job_listing_id', $jobIds)->count(),
        ];

        $jobs = (clone $this->scopedJobs())
            ->with('company')
            ->withCount('applicants')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'jobs'));
    }

    public function createJob()
    {
        $this->ensureStaff();

        $companies = Auth::user()->role === 'admin'
            ? Company::orderBy('name')->get()
            : collect();

        return view('admin.jobs.create', compact('companies'));
    }

    public function storeJob(Request $request)
    {
        $this->ensureStaff();

        $user = Auth::user();

        $rules = [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'requirements' => ['required', 'string'],
            'location' => ['required', 'string', 'max:255'],
            'salary' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:open,closed,pending'],
        ];

        if ($user->role === 'admin') {
            $rules['company_id'] = ['required', 'exists:companies,id'];
        }

        $data = $request->validate($rules);

        if ($user->role === 'admin') {
            $companyId = $data['company_id'];
        } else {
            abort_unless($user->company, 403, 'Akun perusahaan Anda belum memiliki profil.');
            $companyId = $user->company->id;
        }

        JobListing::create([
            'company_id' => $companyId,
            'title' => $data['title'],
            'description' => $data['description'],
            'requirements' => $data['requirements'],
            'location' => $data['location'],
            'salary' => $data['salary'] ?? null,
            'status' => $data['status'],
        ]);

        return redirect()
            ->route('dashboard')
            ->with('status', 'Lowongan kerja berhasil ditambahkan.');
    }

    public function closeJob(JobListing $jobListing)
    {
        $this->ensureStaff();

        $user = Auth::user();
        if ($user->role !== 'admin') {
            abort_unless(optional($user->company)->id === $jobListing->company_id, 403);
        }

        $jobListing->update(['status' => 'closed']);

        return redirect()
            ->route('dashboard')
            ->with('status', 'Lowongan kerja telah ditutup.');
    }
}
