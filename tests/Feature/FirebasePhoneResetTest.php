<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\JobListing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class JobListingAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_job_for_company(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $companyUser = User::factory()->create(['role' => 'company']);
        $company = Company::create([
            'user_id' => $companyUser->id,
            'name' => 'PT Demo Digital',
            'description' => 'Description',
        ]);

        $this->actingAs($admin)
            ->post('/admin/jobs', [
                'company_id' => $company->id,
                'title' => 'Backend Developer',
                'description' => 'Build and support internal APIs.',
                'requirements' => 'PHP and Laravel experience.',
                'location' => 'Jakarta',
                'salary' => 'Rp 12.000.000',
                'status' => 'open',
            ])
            ->assertRedirect('/admin/dashboard');

        $this->assertDatabaseHas('job_listings', [
            'company_id' => $company->id,
            'title' => 'Backend Developer',
        ]);
    }

    public function test_company_cannot_close_another_company_job(): void
    {
        $ownerUser = User::factory()->create(['role' => 'company']);
        $ownerCompany = Company::create([
            'user_id' => $ownerUser->id,
            'name' => 'Owner Company',
            'description' => 'Owner company description',
        ]);

        $otherUser = User::factory()->create(['role' => 'company']);
        $otherCompany = Company::create([
            'user_id' => $otherUser->id,
            'name' => 'Other Company',
            'description' => 'Other company description',
        ]);

        $job = JobListing::create([
            'company_id' => $ownerCompany->id,
            'title' => 'Frontend Developer',
            'description' => 'We need a frontend developer.',
            'requirements' => 'Vue experience.',
            'location' => 'Bandung',
            'salary' => 'Rp 9.000.000',
            'status' => 'open',
        ]);

        $this->actingAs($otherUser)
            ->patch('/admin/jobs/'.$job->id.'/close')
            ->assertForbidden();
    }

    public function test_applicant_can_register_and_apply_for_job(): void
    {
        $companyUser = User::factory()->create(['role' => 'company']);
        $company = Company::create([
            'user_id' => $companyUser->id,
            'name' => 'PT Karya Baru',
            'description' => 'Description',
        ]);

        $job = JobListing::create([
            'company_id' => $company->id,
            'title' => 'QA Engineer',
            'description' => 'Manual and automated QA testing.',
            'requirements' => 'Testing mindset and QA understanding.',
            'location' => 'Remote',
            'salary' => 'Rp 8.000.000',
            'status' => 'open',
        ]);

        $this->post('/register', [
            'name' => 'Pelamar Baru',
            'email' => 'pelamarbaru@example.com',
            'phone_number' => '081234567890',
            'role' => 'applicant',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])->assertRedirect('/applicant/dashboard');

        $applicant = User::where('email', 'pelamarbaru@example.com')->firstOrFail();

        $this->actingAs($applicant)
            ->post('/applicant/jobs/'.$job->id.'/apply', [
                'resume' => 'https://example.com/cv.pdf',
                'cover_letter' => 'Saya tertarik dengan posisi ini.',
            ])
            ->assertRedirect('/applicant/applications');

        $this->assertDatabaseHas('applicants', [
            'user_id' => $applicant->id,
            'job_listing_id' => $job->id,
            'status' => 'pending',
        ]);
    }
}
