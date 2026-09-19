<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Company;
use App\Models\JobListing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

        if ($user->role === 'admin') {
            // Global Admin Statistics
            $stats = [
                'totalUsers' => User::count(),
                'totalCompanies' => Company::count(),
                'totalJobs' => JobListing::count(),
                'totalApplicants' => Applicant::count(),
                'pendingJobs' => JobListing::where('status', 'pending')->count(),
            ];

            $recentUsers = User::latest()->take(5)->get();
            $recentJobs = JobListing::with('company')->latest()->take(5)->get();

            return view('admin.dashboard', compact('stats', 'recentUsers', 'recentJobs'));
        }

        // Company specific statistics
        $jobIds = $this->scopedJobs()->pluck('id');
        $stats = [
            'openJobs' => (clone $this->scopedJobs())->where('status', 'open')->count(),
            'totalApplications' => Applicant::whereIn('job_listing_id', $jobIds)->count(),
            'hiredCount' => Applicant::whereIn('job_listing_id', $jobIds)->where('status', 'accepted')->count(),
        ];

        $jobs = $this->scopedJobs()
            ->withCount('applicants')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'jobs'));
    }

    /**
     * User Management (Admin Only)
     */
    public function usersIndex()
    {
        abort_unless(Auth::user()->role === 'admin', 403);
        $users = User::withCount('applications')->latest()->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function userDestroy(User $user)
    {
        abort_unless(Auth::user()->role === 'admin', 403);
        abort_if($user->id === Auth::id(), 403, 'Anda tidak dapat menghapus akun Anda sendiri.');

        $user->delete();

        return back()->with('status', 'Pengguna berhasil dihapus dari sistem.');
    }

    /**
     * Profile Settings (Universal)
     */
    public function profile()
    {
        $user = Auth::user();

        return view('settings.profile', compact('user'));
    }

    public function profileUpdate(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'phone_number' => ['required', 'string', 'max:20', 'unique:users,phone_number,'.$user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->phone_number = $data['phone_number'];

        if ($request->filled('password')) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return back()->with('status', 'Profil Anda berhasil diperbarui.');
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
