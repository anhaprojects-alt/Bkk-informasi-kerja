<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Company;
use App\Models\JobListing;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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

            return view('admin.dashboard', [
                'stats' => $stats,
                'recentUsers' => $recentUsers,
                'recentJobs' => $recentJobs,
                'jobs' => collect(), // Empty collection for consistency
            ]);
        }

        // Company specific statistics
        $jobIds = $this->scopedJobs()->pluck('id');
        $stats = [
            'openJobs' => (clone $this->scopedJobs())->where('status', 'open')->count(),
            'totalApplications' => Applicant::whereIn('job_listing_id', $jobIds)->count(),
            'hiredCount' => Applicant::whereIn('job_listing_id', $jobIds)->where('status', 'accepted')->count(),
            'totalCompanies' => 1, // For the map widget text
        ];

        $jobs = $this->scopedJobs()
            ->withCount('applicants')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', [
            'stats' => $stats,
            'jobs' => $jobs,
            'company' => $user->company,
            'recentUsers' => collect(), // Empty collection for consistency
            'recentJobs' => collect(), // Empty collection for consistency
        ]);
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

    public function userEdit(User $user)
    {
        abort_unless(Auth::user()->role === 'admin', 403);

        return view('admin.users.edit', compact('user'));
    }

    public function userUpdate(Request $request, User $user)
    {
        abort_unless(Auth::user()->role === 'admin', 403);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'phone_number' => ['required', 'string', 'max:20', 'unique:users,phone_number,'.$user->id],
            'role' => ['required', 'in:admin,company,applicant'],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->phone_number = $data['phone_number'];
        $user->role = $data['role'];

        if ($request->filled('password')) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('status', 'Data pengguna berhasil diperbarui.');
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
        $user = Auth::user()->load('company');

        return view('settings.profile', compact('user'));
    }

    public function profileUpdate(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'phone_number' => ['required', 'string', 'max:20', 'unique:users,phone_number,'.$user->id],
            'headline' => ['nullable', 'string', 'max:120'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'location' => ['nullable', 'string', 'max:255'],
            'province' => ['nullable', 'string', 'max:100'],
            'city' => ['nullable', 'string', 'max:100'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'company_description' => ['nullable', 'string', 'max:5000'],
            'company_address' => ['nullable', 'string', 'max:500'],
            'company_website' => ['nullable', 'url:http,https', 'max:255'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:8192'],
            'banner' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:8192'],
        ];

        $messages = [
            'avatar.image' => 'Foto profil harus berupa file gambar yang valid.',
            'avatar.mimes' => 'Foto profil hanya boleh berformat JPG, JPEG, PNG, atau WEBP.',
            'avatar.max' => 'Foto profil maksimal berukuran 8 MB.',
            'banner.image' => 'Banner harus berupa file gambar yang valid.',
            'banner.mimes' => 'Banner hanya boleh berformat JPG, JPEG, PNG, atau WEBP.',
            'banner.max' => 'Banner maksimal berukuran 8 MB.',
        ];

        if ($user->role === 'applicant') {
            $rules['cv'] = ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'];
            $messages += [
                'cv.file' => 'CV harus berupa file yang valid.',
                'cv.mimes' => 'CV hanya boleh berformat PDF, DOC, atau DOCX.',
                'cv.max' => 'CV maksimal berukuran 5 MB.',
            ];
        }

        $data = $request->validate($rules, $messages);

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->phone_number = $data['phone_number'];
        $user->headline = $data['headline'] ?? null;
        $user->bio = $data['bio'] ?? null;
        $user->location = $data['location'] ?? null;
        $user->province = $data['province'] ?? null;
        $user->city = $data['city'] ?? null;

        if ($user->role === 'company') {
            $user->company()->updateOrCreate(
                [],
                [
                    'name' => $data['company_name'] ?? $user->name,
                    'description' => $data['company_description'] ?? null,
                    'address' => $data['company_address'] ?? null,
                    'website' => $data['company_website'] ?? null,
                ],
            );
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar_path && Storage::disk('public')->exists($user->avatar_path)) {
                Storage::disk('public')->delete($user->avatar_path);
            }

            $user->avatar_path = $request->file('avatar')->storePublicly('profiles/avatars', 'public');
        }

        if ($request->hasFile('banner')) {
            if ($user->banner_path && Storage::disk('public')->exists($user->banner_path)) {
                Storage::disk('public')->delete($user->banner_path);
            }

            $user->banner_path = $request->file('banner')->storePublicly('profiles/banners', 'public');
        }

        if ($user->role === 'applicant' && $request->hasFile('cv')) {
            if ($user->cv_path && Storage::disk('public')->exists($user->cv_path)) {
                Storage::disk('public')->delete($user->cv_path);
            }

            $user->cv_path = $request->file('cv')->store('profiles/cv', 'public');
            $user->cv_name = $request->file('cv')->getClientOriginalName();
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return redirect()->route('settings.profile')->with('status', 'Profil Anda berhasil diperbarui.');
    }

    public function helpCenter()
    {
        return view('help.center');
    }

    public function messagesIndex(?User $user = null)
    {
        $currentUser = Auth::user();

        // Get users who have exchanged messages with current user OR are potential contacts
        // For simplicity in this professional LinkedIn flow, we show active conversations first
        $recentParticipantsIds = Message::where('sender_id', $currentUser->id)
            ->orWhere('receiver_id', $currentUser->id)
            ->latest()
            ->pluck('sender_id', 'receiver_id')
            ->flatten()
            ->unique()
            ->filter(fn ($id) => $id != $currentUser->id);

        $participants = User::whereIn('id', $recentParticipantsIds)
            ->orWhere(function ($query) use ($currentUser) {
                // Applicants see Companies, Companies see Applicants/Admins
                if ($currentUser->role === 'applicant') {
                    $query->where('role', 'company');
                } else {
                    $query->where('role', '!=', 'company');
                }
            })
            ->where('id', '!=', $currentUser->id)
            ->orderBy('name')
            ->limit(20)
            ->get();

        $activeUser = $user ?? $participants->first();

        $messages = collect();

        if ($activeUser) {
            $messages = Message::where(function ($query) use ($activeUser) {
                $query->where('sender_id', Auth::id())
                    ->where('receiver_id', $activeUser->id);
            })->orWhere(function ($query) use ($activeUser) {
                $query->where('sender_id', $activeUser->id)
                    ->where('receiver_id', Auth::id());
            })->orderBy('created_at')->get();
        }

        return view('help.messages', compact('participants', 'activeUser', 'messages'));
    }

    public function messagesStore(Request $request, User $user)
    {
        $data = $request->validate([
            'body' => ['required', 'string', 'max:2000'],
        ]);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $user->id,
            'body' => trim($data['body']),
        ]);

        return redirect()->route('messages.show', $user)->with('status', 'Pesan berhasil dikirim.');
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

    public function editJob(JobListing $jobListing)
    {
        $this->ensureStaff();

        if (Auth::user()->role !== 'admin') {
            abort_unless(optional(Auth::user()->company)->id === $jobListing->company_id, 403);
        }

        $companies = Auth::user()->role === 'admin'
            ? Company::orderBy('name')->get()
            : collect();

        return view('admin.jobs.edit', compact('jobListing', 'companies'));
    }

    public function updateJob(Request $request, JobListing $jobListing)
    {
        $this->ensureStaff();

        if (Auth::user()->role !== 'admin') {
            abort_unless(optional(Auth::user()->company)->id === $jobListing->company_id, 403);
        }

        $rules = [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'requirements' => ['required', 'string'],
            'location' => ['required', 'string', 'max:255'],
            'salary' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:open,closed,pending'],
        ];

        if (Auth::user()->role === 'admin') {
            $rules['company_id'] = ['required', 'exists:companies,id'];
        }

        $data = $request->validate($rules);

        $updateData = [
            'title' => $data['title'],
            'description' => $data['description'],
            'requirements' => $data['requirements'],
            'location' => $data['location'],
            'salary' => $data['salary'] ?? null,
            'status' => $data['status'],
        ];

        if (Auth::user()->role === 'admin') {
            $updateData['company_id'] = $data['company_id'];
        }

        $jobListing->update($updateData);

        return redirect()
            ->route('dashboard')
            ->with('status', 'Lowongan kerja berhasil diperbarui.');
    }

    public function destroyJob(JobListing $jobListing)
    {
        $this->ensureStaff();

        if (Auth::user()->role !== 'admin') {
            abort_unless(optional(Auth::user()->company)->id === $jobListing->company_id, 403);
        }

        $jobListing->delete();

        return redirect()
            ->route('dashboard')
            ->with('status', 'Lowongan kerja berhasil dihapus.');
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

    public function jobApplicants(JobListing $jobListing)
    {
        $this->ensureStaff();

        if (Auth::user()->role !== 'admin') {
            abort_unless(optional(Auth::user()->company)->id === $jobListing->company_id, 403);
        }

        $applicants = Applicant::where('job_listing_id', $jobListing->id)
            ->with('user')
            ->latest()
            ->paginate(20);

        return view('admin.jobs.applicants', compact('jobListing', 'applicants'));
    }

    public function updateApplicantStatus(Request $request, Applicant $applicant)
    {
        $this->ensureStaff();

        if (Auth::user()->role !== 'admin') {
            abort_unless(optional(Auth::user()->company)->id === $applicant->jobListing->company_id, 403);
        }

        $data = $request->validate([
            'status' => ['required', 'in:pending,accepted,rejected'],
        ]);

        $applicant->update(['status' => $data['status']]);

        return back()->with('status', 'Status pelamar berhasil diperbarui.');
    }
}
