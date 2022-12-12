<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'name',
        'last_name',
        'photo',
        'company_id'
    ];

    public function phones(): HasMany
    {
        return $this->hasMany(PhoneNumber::class);
    }

    public function locations(): HasMany
    {
        return $this->hasMany(Location::class);
    }

    public function emails(): HasMany
    {
        return $this->hasMany(MailAddress::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
