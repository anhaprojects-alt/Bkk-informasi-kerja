<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'role',
        'headline',
        'bio',
        'location',
        'province',
        'city',
        'avatar_path',
        'banner_path',
        'cv_path',
        'cv_name',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function company(): HasOne
    {
        return $this->hasOne(Company::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Applicant::class);
    }

    public function sentMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar_path) {
            return Storage::disk('public')->url($this->avatar_path);
        }

        return 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&background=0ea5e9&color=fff&size=160';
    }

    public function getBannerUrlAttribute(): string
    {
        if ($this->banner_path) {
            return Storage::disk('public')->url($this->banner_path);
        }

        return 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=1200&q=80';
    }
}
