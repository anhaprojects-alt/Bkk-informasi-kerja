<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\JobListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function dashboard()
    {
        $userId = Auth::id();
        $totalApplied = Applicant::where('user_id', $userId)->count();
        $acceptedCount = Applicant::where('user_id', $userId)->where('status', 'accepted')->count();
        $rejectedCount = Applicant::where('user_id', $userId)->where('status', 'rejected')->count();
        $pendingCount = Applicant::where('user_id', $userId)->where('status', 'pending')->count();
        $recommendations = JobListing::with('company')->where('status', 'open')->latest()->take(3)->get();
        $compatibilityScore = $totalApplied > 0 ? min(70 + ($acceptedCount * 10) + ($totalApplied * 2), 98) : 65;
        $marketStats = [
            'totalActiveJobs' => JobListing::where('status', 'open')->count(),
            'averageSalaryInsight' => 'Rp 6.8M - 12.5M',
            'topHiringLocation' => JobListing::select('location')->where('status', 'open')->groupBy('location')->orderByRaw('COUNT(*) DESC')->first()?->location ?? 'Jakarta / Remote',
        ];
        return view('applicant.dashboard', compact('totalApplied', 'acceptedCount', 'rejectedCount', 'pendingCount', 'recommendations', 'compatibilityScore', 'marketStats'));
    }

    public function index(Request $request)
    {
        $search = trim((string) $request->query('q', ''));
        $location = trim((string) $request->query('l', ''));
        $remoteOnly = $request->boolean('remote');
        $query = JobListing::with('company')->where('status', 'open');
        if ($search !== '') {
            $query->where(fn ($q) => $q->where('title', 'like', "%{$search}%")->orWhereHas('company', fn ($c) => $c->where('name', 'like', "%{$search}%")));
        }
        if ($location !== '') {
            $query->where('location', 'like', "%{$location}%");
        }
        if ($remoteOnly) {
            $query->where('location', 'like', '%Remote%');
        }
        $jobs = $query->latest()->paginate(15)->withQueryString();
        $appliedJobIds = Auth::check() ? Applicant::where('user_id', Auth::id())->pluck('job_listing_id')->all() : [];
        return view('jobs.explore', compact('jobs', 'search', 'location', 'remoteOnly', 'appliedJobIds'));
    }

    public function show(JobListing $jobListing)
    {
        $jobListing->load('company');
        $hasApplied = Auth::check() && Applicant::where('user_id', Auth::id())->where('job_listing_id', $jobListing->id)->exists();
        return view('applicant.show', compact('jobListing', 'hasApplied'));
    }

    public function apply(Request $request, JobListing $jobListing)
    {
        $this->authorize('apply', $jobListing);
        $data = $request->validate([
            'resume' => ['required', 'url:http,https', 'max:2048'],
            'cover_letter' => ['nullable', 'string', 'max:5000'],
        ], [
            'resume.required' => 'Link CV/resume wajib diisi.',
            'resume.url' => 'Link CV/resume harus berupa tautan yang valid dan diawali http:// atau https://.',
            'resume.max' => 'Link CV/resume terlalu panjang (maksimal 2048 karakter).',
            'cover_letter.max' => 'Surat lamaran terlalu panjang (maksimal 5000 karakter).',
        ]);
        if (Applicant::where('user_id', Auth::id())->where('job_listing_id', $jobListing->id)->exists()) {
            return redirect()->route('jobs.show', $jobListing)->with('status', 'Anda sudah melamar pada lowongan ini.');
        }
        Applicant::create([
            'user_id' => Auth::id(),
            'job_listing_id' => $jobListing->id,
            'resume' => $data['resume'],
            'cover_letter' => $data['cover_letter'] ?? null,
            'status' => 'pending',
        ]);
        return redirect()->route('applications.mine')->with('status', 'Lamaran Anda berhasil dikirim.');
    }

    public function myApplications()
    {
        $applications = Applicant::where('user_id', Auth::id())->with('jobListing.company')->latest()->get();
        return view('applicant.applications', compact('applications'));
    }
}
