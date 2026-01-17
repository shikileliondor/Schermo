<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Staff extends Model
{
    protected $table = 'staff';

    protected $fillable = [
        'first_name',
        'last_name',
        'position',
        'email',
        'phone',
        'hired_at',
        'active',
        'contract_path',
        'contract_original_name',
    ];

    protected $casts = [
        'hired_at' => 'date',
        'active' => 'boolean',
    ];

    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(SchoolClass::class, 'class_staff');
    }

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'staff_subject');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}
