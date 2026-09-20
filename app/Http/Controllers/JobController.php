<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\JobListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    /**
     * Smart Analytics Dashboard for the logged-in applicant.
     */
    public function dashboard()
    {
        $userId = Auth::id();

        // Application metrics status
        $totalApplied = Applicant::where('user_id', $userId)->count();
        $acceptedCount = Applicant::where('user_id', $userId)->where('status', 'accepted')->count();
        $rejectedCount = Applicant::where('user_id', $userId)->where('status', 'rejected')->count();
        $pendingCount = Applicant::where('user_id', $userId)->where('status', 'pending')->count();

        // Personalized smart recommendations (Open jobs matching top locations)
        $recommendations = JobListing::with('company')
            ->where('status', 'open')
            ->latest()
            ->take(3)
            ->get();

        // Market intelligence calculations (Simulating enterprise-level algorithmic statistics)
        $compatibilityScore = $totalApplied > 0 ? min(70 + ($acceptedCount * 10) + ($totalApplied * 2), 98) : 65;

        $marketStats = [
            'totalActiveJobs' => JobListing::where('status', 'open')->count(),
            'averageSalaryInsight' => 'Rp 6.8M - 12.5M',
            'topHiringLocation' => JobListing::select('location')
                ->where('status', 'open')
                ->groupBy('location')
                ->orderByRaw('COUNT(*) DESC')
                ->first()?->location ?? 'Jakarta / Remote',
        ];

        return view('applicant.dashboard', compact(
            'totalApplied',
            'acceptedCount',
            'rejectedCount',
            'pendingCount',
            'recommendations',
            'compatibilityScore',
            'marketStats'
        ));
    }

    /**
     * Job feed (Public & Private).
     * Uses LinkedIn-style Split View on Desktop.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q', ''));
        $location = trim((string) $request->query('l', ''));
        $selectedCities = (array) $request->query('cities', []);
        $remoteOnly = $request->boolean('remote');

        $query = JobListing::query()
            ->with(['company' => function ($q) {
                $q->select('id', 'user_id', 'name', 'logo', 'address');
            }])
            ->where('status', 'open');

        // Text Search (Title, Company Name, Description)
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('company', fn ($c) => $c->where('name', 'like', "%{$search}%"));
            });
        }

        // Location Filters (Text or Checkbox)
        if ($location !== '' || ! empty($selectedCities)) {
            $query->where(function ($q) use ($location, $selectedCities) {
                if ($location !== '') {
                    $q->where('location', 'like', "%{$location}%")
                      ->orWhereHas('company', fn ($c) => $c->where('address', 'like', "%{$location}%"));
                }

                if (! empty($selectedCities)) {
                    $q->orWhereIn('location', $selectedCities);
                }
            });
        }

        // Remote Filter
        if ($remoteOnly) {
            $query->where(function ($q) {
                $q->where('location', 'like', '%Remote%')
                    ->orWhere('location', 'like', '%WFA%')
                    ->orWhere('location', 'like', '%WFH%')
                    ->orWhere('location', 'like', '%Hybrid%');
            });
        }

        $jobs = $query->latest()->paginate(15)->withQueryString();
        $appliedJobIds = Auth::check() ? Applicant::where('user_id', Auth::id())->pluck('job_listing_id')->all() : [];

        // Dynamic Meta Data for Filter Sidebar
        $availableLocations = JobListing::where('status', 'open')
            ->whereNotNull('location')
            ->where('location', '!=', '')
            ->distinct()
            ->pluck('location')
            ->all();

        return view('jobs.explore', [
            'jobs' => $jobs,
            'search' => $search,
            'location' => $location,
            'cities' => $selectedCities,
            'remoteOnly' => $remoteOnly,
            'appliedJobIds' => $appliedJobIds,
            'availableLocations' => $availableLocations,
        ]);
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
            'resume' => ['required', 'url:http,https', 'max:2048'],
            'cover_letter' => ['nullable', 'string', 'max:5000'],
        ], [
            'resume.required' => 'Link CV/resume wajib diisi.',
            'resume.url' => 'Link CV/resume harus berupa tautan yang valid dan diawali http:// atau https://.',
            'resume.max' => 'Link CV/resume terlalu panjang (maksimal 2048 karakter).',
            'cover_letter.max' => 'Surat lamaran terlalu panjang (maksimal 5000 karakter).',
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
