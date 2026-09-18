<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['company_id', 'title', 'description', 'requirements', 'location', 'salary', 'status'])]
class JobListing extends Model
{
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function applicants(): HasMany
    {
        return $this->hasMany(Applicant::class);
    }
}
