<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class FirebasePhoneResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_phone_reset_verifies_firebase_token_and_updates_password(): void
    {
        config()->set('services.firebase.api_key', 'fake-firebase-api-key');
        Http::fake([
            'https://identitytoolkit.googleapis.com/v1/accounts:lookup*' => Http::response([
                'users' => [['phoneNumber' => '+6281234567890']],
            ]),
        ]);
        $user = User::factory()->create([
            'phone_number' => '081234567890',
            'password' => Hash::make('oldPassword123'),
        ]);

        $this->from('/forgot-password')->post('/phone-reset-password', [
            'phone_number' => '081234567890',
            'password' => 'newPassword123',
            'password_confirmation' => 'newPassword123',
            'firebase_token' => 'valid-id-token',
        ])->assertRedirect('/login');

        $this->assertTrue(Hash::check('newPassword123', $user->refresh()->password));
    }

    public function test_phone_reset_rejects_invalid_firebase_token(): void
    {
        config()->set('services.firebase.api_key', 'fake-firebase-api-key');
        Http::fake([
            'https://identitytoolkit.googleapis.com/v1/accounts:lookup*' => Http::response([
                'error' => ['message' => 'INVALID_ID_TOKEN'],
            ], 400),
        ]);
        User::factory()->create(['phone_number' => '081234567890']);

        $this->from('/forgot-password')->post('/phone-reset-password', [
            'phone_number' => '081234567890',
            'password' => 'newPassword123',
            'password_confirmation' => 'newPassword123',
            'firebase_token' => 'invalid-id-token',
        ])->assertSessionHasErrors(['firebase_token']);
    }
}
