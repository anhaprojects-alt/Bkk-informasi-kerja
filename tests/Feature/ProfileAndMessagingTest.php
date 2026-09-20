<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileAndMessagingTest extends TestCase
{
    use RefreshDatabase;

    public function test_applicant_can_update_advanced_profile_details(): void
    {
        $user = User::factory()->create([
            'role' => 'applicant',
            'phone_number' => '081234567890',
        ]);

        $this->actingAs($user)
            ->put('/settings/profile', [
                'name' => $user->name,
                'email' => $user->email,
                'phone_number' => '081234567891',
                'headline' => 'Senior Laravel Developer',
                'bio' => 'Saya adalah developer yang fokus pada Laravel dan integrasi API.',
                'province' => 'DKI Jakarta',
                'city' => 'Jakarta Selatan',
                'location' => 'Jakarta Selatan / Remote',
            ])
            ->assertRedirect('/settings/profile');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'headline' => 'Senior Laravel Developer',
            'province' => 'DKI Jakarta',
            'city' => 'Jakarta Selatan',
            'location' => 'Jakarta Selatan / Remote',
        ]);
    }

    public function test_applicant_can_access_help_center_and_send_message(): void
    {
        $applicant = User::factory()->create([
            'role' => 'applicant',
            'phone_number' => '081234567892',
        ]);

        $company = User::factory()->create([
            'role' => 'company',
            'name' => 'PT Mitra BKK',
            'phone_number' => '081234567893',
        ]);

        $this->actingAs($applicant)
            ->get('/help-center')
            ->assertOk();

        $this->actingAs($applicant)
            ->post('/messages/'.$company->id, [
                'body' => 'Halo, saya ingin bertanya terkait proses seleksi.',
            ])
            ->assertRedirect('/messages/'.$company->id);

        $this->assertDatabaseHas('messages', [
            'sender_id' => $applicant->id,
            'receiver_id' => $company->id,
            'body' => 'Halo, saya ingin bertanya terkait proses seleksi.',
        ]);
    }

    public function test_company_can_update_company_address_used_by_maps(): void
    {
        $companyUser = User::factory()->create([
            'role' => 'company',
            'phone_number' => '081234567894',
        ]);

        $this->actingAs($companyUser)
            ->put('/settings/profile', [
                'name' => $companyUser->name,
                'email' => $companyUser->email,
                'phone_number' => $companyUser->phone_number,
                'company_name' => 'PT Lokasi Tepat',
                'company_address' => 'Jl. Jenderal Sudirman No. 52, Senayan, Jakarta Selatan, DKI Jakarta',
                'company_description' => 'Perusahaan teknologi.',
                'company_website' => 'https://lokasitepat.test',
            ])
            ->assertRedirect('/settings/profile');

        $this->assertDatabaseHas('companies', [
            'user_id' => $companyUser->id,
            'name' => 'PT Lokasi Tepat',
            'address' => 'Jl. Jenderal Sudirman No. 52, Senayan, Jakarta Selatan, DKI Jakarta',
            'website' => 'https://lokasitepat.test',
        ]);

        $this->actingAs($companyUser)
            ->get('/admin/dashboard')
            ->assertOk()
            ->assertSee('Jl. Jenderal Sudirman No. 52, Senayan, Jakarta Selatan, DKI Jakarta')
            ->assertSee('maps.google.com/maps?q=Jl.+Jenderal+Sudirman+No.+52%2C+Senayan%2C+Jakarta+Selatan%2C+DKI+Jakarta', false);
    }

    public function test_user_can_upload_avatar_and_banner(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'role' => 'applicant',
            'phone_number' => '081234567895',
        ]);

        $this->actingAs($user)
            ->put('/settings/profile', [
                'name' => $user->name,
                'email' => $user->email,
                'phone_number' => $user->phone_number,
                'avatar' => UploadedFile::fake()->image('avatar.jpg', 400, 400),
                'banner' => UploadedFile::fake()->image('banner.jpg', 1600, 500),
            ])
            ->assertRedirect('/settings/profile');

        $user->refresh();

        $this->assertNotEmpty($user->avatar_path);
        $this->assertNotEmpty($user->banner_path);
        Storage::disk('public')->assertExists($user->avatar_path);
        Storage::disk('public')->assertExists($user->banner_path);
    }

    public function test_company_profile_does_not_accept_cv_uploads(): void
    {
        Storage::fake('public');

        $companyUser = User::factory()->create([
            'role' => 'company',
            'phone_number' => '081234567896',
        ]);

        $this->actingAs($companyUser)
            ->put('/settings/profile', [
                'name' => $companyUser->name,
                'email' => $companyUser->email,
                'phone_number' => $companyUser->phone_number,
                'cv' => UploadedFile::fake()->create('company-cv.pdf', 100, 'application/pdf'),
            ])
            ->assertSessionHasErrors('cv');

        $companyUser->refresh();

        $this->assertNull($companyUser->cv_path);
        $this->assertNull($companyUser->cv_name);
        $this->assertDatabaseMissing('users', [
            'id' => $companyUser->id,
            'cv_path' => 'profiles/cv/company-cv.pdf',
        ]);
    }
}
