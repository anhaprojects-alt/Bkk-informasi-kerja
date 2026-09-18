<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\JobListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    /**
     * Public applicant job feed (mobile view).
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q', ''));

        $jobs = JobListing::query()
            ->with('company')
            ->where('status', 'open')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('location', 'like', "%{$search}%")
                        ->orWhereHas('company', fn ($c) => $c->where('name', 'like', "%{$search}%"));
                });
            })
            ->latest()
            ->get();

        $appliedJobIds = Applicant::where('user_id', Auth::id())->pluck('job_listing_id')->all();

        return view('applicant.jobs', compact('jobs', 'search', 'appliedJobIds'));
    }

    /**
     * Job detail page.
     */
    public function show(JobListing $jobListing)
    {
        $jobListing->load('company');

        $hasApplied = Applicant::where('user_id', Auth::id())
            ->where('job_listing_id', $jobListing->id)
            ->exists();

        return view('applicant.show', compact('jobListing', 'hasApplied'));
    }

    /**
     * Submit an application for a job.
     */
    public function apply(Request $request, JobListing $jobListing)
    {
        abort_if($jobListing->status !== 'open', 403, 'Lowongan ini sudah ditutup.');

        $data = $request->validate([
            'resume' => ['required', 'string', 'max:2048'],
            'cover_letter' => ['nullable', 'string', 'max:5000'],
        ]);

        $alreadyApplied = Applicant::where('user_id', Auth::id())
            ->where('job_listing_id', $jobListing->id)
            ->exists();

        if ($alreadyApplied) {
            return redirect()
                ->route('jobs.show', $jobListing)
                ->with('status', 'Anda sudah melamar pada lowongan ini.');
        }

        Applicant::create([
            'user_id' => Auth::id(),
            'job_listing_id' => $jobListing->id,
            'resume' => $data['resume'],
            'cover_letter' => $data['cover_letter'] ?? null,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('applications.mine')
            ->with('status', 'Lamaran Anda berhasil dikirim.');
    }

    /**
     * List the current applicant's applications.
     */
    public function myApplications()
    {
        $applications = Applicant::where('user_id', Auth::id())
            ->with('jobListing.company')
            ->latest()
            ->get();

        return view('applicant.applications', compact('applications'));
    }
}
