<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
}
