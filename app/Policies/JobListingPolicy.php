<?php

namespace App\Policies;

use App\Models\JobListing;
use App\Models\User;

class JobListingPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, JobListing $jobListing): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'company'], true);
    }

    public function update(User $user, JobListing $jobListing): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        if ($user->role !== 'company') {
            return false;
        }

        return $user->company?->id === $jobListing->company_id;
    }

    public function delete(User $user, JobListing $jobListing): bool
    {
        return $this->update($user, $jobListing);
    }

    public function close(User $user, JobListing $jobListing): bool
    {
        return $this->update($user, $jobListing);
    }

    public function apply(User $user, JobListing $jobListing): bool
    {
        if ($user->role !== 'applicant') {
            return false;
        }

        return $jobListing->status === 'open';
    }
}
