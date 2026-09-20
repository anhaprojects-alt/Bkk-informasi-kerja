<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobListing extends Model
{
    protected $fillable = [
        'company_id',
        'title',
        'description',
        'requirements',
        'location',
        'salary',
        'status'
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function applicants(): HasMany
    {
        return $this->hasMany(Applicant::class);
    }
}
