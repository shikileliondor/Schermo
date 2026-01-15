<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Stancl\Tenancy\Database\Models\Tenant;

class School extends Tenant
{
    protected $table = 'schools';

    protected $fillable = [
        'id',
        'name',
        'database',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
